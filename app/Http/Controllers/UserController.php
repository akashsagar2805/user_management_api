<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = $request->user()->load('details');

        return response()->json([
            'status' => 'success',
            'message' => 'Profile retrieved successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile_no' => $user->mobile_no,
                'status' => $user->status,
                'details' => $user->details,
            ]
        ], 200);
    }
}
