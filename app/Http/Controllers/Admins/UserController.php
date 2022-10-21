<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', '=', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admins.users.index', [
            'users' => $users
        ]);
    }
}
