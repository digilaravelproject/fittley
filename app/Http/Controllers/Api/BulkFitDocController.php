<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FitDoc;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BulkFitDocController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:admin|instructor']);
    }

    /**
     * Bulk create FitDocs
     */
    public function bulkCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fitdocs' => 'required|array|min:1|max:50',
            'fitdocs.*.title' => 'required|string|max:255',
            'fitdocs.*.description' => 'required|string',
            'fitdocs.*.type' => 'required|in:single,series',
            'fitdocs.*.cost' => 'required|numeric|min:0',
            'fitdocs.*.language' => 'required|string|max:10',
            'fitdocs.*.release_date' => 'required|date',
            'fitdocs.*.banner_image_path' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $createdFitDocs = [];
            $errors = [];

            foreach ($request->fitdocs as $index => $fitDocData) {
                try {
                    $fitDoc = FitDoc::create(array_merge($fitDocData, [
                        'status' => 'draft',
                        'created_by' => auth()->id()
                    ]));

                    $createdFitDocs[] = $fitDoc;
                } catch (\Exception $e) {
                    $errors[] = [
                        'index' => $index,
                        'title' => $fitDocData['title'],
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bulk FitDoc creation completed',
                'data' => [
                    'created_count' => count($createdFitDocs),
                    'error_count' => count($errors),
                    'created_fitdocs' => $createdFitDocs,
                    'errors' => $errors
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Bulk creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk update FitDocs
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'updates' => 'required|array|min:1|max:50',
            'updates.*.id' => 'required|integer|exists:fit_docs,id',
            'updates.*.title' => 'nullable|string|max:255',
            'updates.*.description' => 'nullable|string',
            'updates.*.cost' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $updatedFitDocs = [];
            $errors = [];

            foreach ($request->updates as $index => $updateData) {
                try {
                    $fitDoc = FitDoc::findOrFail($updateData['id']);
                    
                    $fieldsToUpdate = collect($updateData)->except('id')->filter()->toArray();
                    
                    if (!empty($fieldsToUpdate)) {
                        $fitDoc->update($fieldsToUpdate);
                        $updatedFitDocs[] = $fitDoc->fresh();
                    }
                } catch (\Exception $e) {
                    $errors[] = [
                        'index' => $index,
                        'id' => $updateData['id'],
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bulk FitDoc update completed',
                'data' => [
                    'updated_count' => count($updatedFitDocs),
                    'error_count' => count($errors),
                    'updated_fitdocs' => $updatedFitDocs,
                    'errors' => $errors
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Bulk update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete FitDocs
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fitdoc_ids' => 'required|array|min:1|max:50',
            'fitdoc_ids.*' => 'required|integer|exists:fit_docs,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $deletedCount = FitDoc::whereIn('id', $request->fitdoc_ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bulk FitDoc deletion completed',
                'data' => [
                    'deleted_count' => $deletedCount
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk status change
     */
    public function bulkStatusChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fitdoc_ids' => 'required|array|min:1|max:50',
            'fitdoc_ids.*' => 'required|integer|exists:fit_docs,id',
            'status' => 'required|in:draft,published,archived'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updatedCount = FitDoc::whereIn('id', $request->fitdoc_ids)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => "Bulk status change to {$request->status} completed",
                'data' => [
                    'updated_count' => $updatedCount,
                    'new_status' => $request->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk status change failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
