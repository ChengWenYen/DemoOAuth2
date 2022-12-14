<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show()
    {
        if(Auth::check()) {
            if(Auth::user()->is_admin) {
                return redirect(route('admin.notify.index'));
            } else {
                return redirect(route('home'));
            }
        }
        return view('admins.login');
    }

    public function login(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        $result = Auth::attempt(['email' => $email, 'guid' => null, 'channel' => null, 'password' => $password, 'is_admin' => true], false);
        Log::info($result);
        if($result) {
            return redirect(route('admin.notify.index'));
        } else {
            return back()->with('message', 'Login failed!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('admin.auth.show'));
    }
}
