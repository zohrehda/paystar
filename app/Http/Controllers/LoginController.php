<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        $user = User::factory()->create();
        Auth::loginUsingId($user->id);
        return redirect()->route('checkout');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
