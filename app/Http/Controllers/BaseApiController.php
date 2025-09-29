<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class BaseApiController extends Controller
{
    use ApiResponseTrait, AuthorizesRequests, ValidatesRequests;

    /**
     * Validate request data
     *
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @param array $attributes
     * @return array
     */
    protected function validateRequest(Request $request, array $rules, array $messages = [], array $attributes = []): array
    {
        try {
            return $request->validate($rules, $messages, $attributes);
        } catch (ValidationException $e) {
            throw new ValidationException($e->validator, $this->validationErrorResponse($e->errors()));
        }
    }

    /**
     * Handle exceptions and return appropriate JSON response
     *
     * @param \Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleException(\Exception $e)
    {
        // Log the exception for debugging
        Log::error('API Exception: ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);

        // Handle specific exception types
        if ($e instanceof ValidationException) {
            return $this->validationErrorResponse($e->errors(), $e->getMessage());
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return $this->notFoundResponse('Resource not found');
        }

        if ($e instanceof UnauthorizedHttpException) {
            return $this->unauthorizedResponse('Authentication required');
        }

        if ($e instanceof AccessDeniedHttpException) {
            return $this->forbiddenResponse('Access denied');
        }

        // Default to server error for unknown exceptions
        return $this->serverErrorResponse('An error occurred while processing your request');
    }

    /**
     * Transform data using a transformer/resource
     *
     * @param mixed $data
     * @param string|null $transformer
     * @return mixed
     */
    protected function transformData($data, $transformer = null)
    {
        if ($transformer && class_exists($transformer)) {
            if (is_iterable($data)) {
                return $transformer::collection($data);
            } else {
                return new $transformer($data);
            }
        }

        return $data;
    }

    /**
     * Apply filters to a query based on request parameters
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @param array $allowedFilters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilters($query, Request $request, array $allowedFilters = [])
    {
        foreach ($allowedFilters as $filter) {
            if ($request->has($filter) && $request->filled($filter)) {
                $value = $request->get($filter);
                
                // Handle different filter types
                if (is_array($value)) {
                    $query->whereIn($filter, $value);
                } else {
                    $query->where($filter, $value);
                }
            }
        }

        return $query;
    }

    /**
     * Apply search to a query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @param array $searchableFields
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applySearch($query, Request $request, array $searchableFields = [])
    {
        if ($request->has('search') && $request->filled('search') && !empty($searchableFields)) {
            $searchTerm = $request->get('search');
            
            $query->where(function ($q) use ($searchableFields, $searchTerm) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$searchTerm}%");
                }
            });
        }

        return $query;
    }

    /**
     * Apply sorting to a query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @param array $allowedSorts
     * @param string $defaultSort
     * @param string $defaultDirection
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applySorting($query, Request $request, array $allowedSorts = [], string $defaultSort = 'created_at', string $defaultDirection = 'desc')
    {
        $sortBy = $request->get('sort_by', $defaultSort);
        $sortDirection = $request->get('sort_direction', $defaultDirection);

        // Validate sort direction
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = $defaultDirection;
        }

        // Validate sort field
        if (!empty($allowedSorts) && !in_array($sortBy, $allowedSorts)) {
            $sortBy = $defaultSort;
        }

        return $query->orderBy($sortBy, $sortDirection);
    }

    /**
     * Get pagination parameters from request
     *
     * @param Request $request
     * @param int $defaultPerPage
     * @param int $maxPerPage
     * @return array
     */
    protected function getPaginationParams(Request $request, int $defaultPerPage = 15, int $maxPerPage = 100): array
    {
        $perPage = (int) $request->get('per_page', $defaultPerPage);
        
        // Ensure per_page is within acceptable limits
        if ($perPage > $maxPerPage) {
            $perPage = $maxPerPage;
        } elseif ($perPage < 1) {
            $perPage = $defaultPerPage;
        }

        return [
            'per_page' => $perPage,
            'page' => (int) $request->get('page', 1)
        ];
    }

    /**
     * Check if request expects JSON response
     *
     * @param Request $request
     * @return bool
     */
    protected function expectsJson(Request $request): bool
    {
        return $request->expectsJson() || 
               $request->is('api/*') || 
               $request->header('Accept') === 'application/json' ||
               $request->ajax();
    }

    /**
     * Get the authenticated user or throw exception
     *
     * @return \App\Models\User
     * @throws UnauthorizedHttpException
     */
    protected function getAuthenticatedUser()
    {
        $user = auth()->user();
        
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'Authentication required');
        }

        return $user;
    }
}