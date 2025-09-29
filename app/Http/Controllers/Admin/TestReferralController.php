<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestReferralController extends Controller
{
    public function index()
    {
        return view('admin.referral.test');
    }
    
    public function test()
    {
        return response()->json([
            'message' => 'Referral routing works!',
            'timestamp' => now(),
            'route' => request()->route()->getName()
        ]);
    }
}
