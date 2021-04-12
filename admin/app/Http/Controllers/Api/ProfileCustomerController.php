<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class ProfileCustomerController extends Controller
{
    //
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $user = $request->user();

        $user->update($request->only('name'));

        return response()->json($user);
    }
}
