<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {
      $credentials = $request->only('email', 'password');
  
      if (Auth::guard('web')->attempt($credentials)) {
          return response()->json(['message' => 'Login successful']);
      }
  
      return response()->json(['message' => 'Invalid credentials'], 401);
  }
  
}
