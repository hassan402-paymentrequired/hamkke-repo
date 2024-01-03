<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        $roles = Role::all();
        $users = User::join('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.hierarchy', '<=', $authUser->role->hierarchy)
            ->select(['users.*'])
            ->paginate(20);
        return view('users.users-list', compact('roles', 'users'));
    }

    public function create()
    {
        flashErrorMessage('The user creation feature is currently unavailable');
        return back();
    }

    public function update(User $user)
    {
        flashErrorMessage('The user update feature is currently unavailable');
        return back();
    }

    public function delete(User $user)
    {
        flashErrorMessage('The user deletion feature is currently unavailable');
        return back();
    }
}
