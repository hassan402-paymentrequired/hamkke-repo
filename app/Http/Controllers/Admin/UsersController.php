<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrCreateUser;
use App\Models\Role;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('users.users-list', compact('users'));
    }

    public function create(UpdateOrCreateUser $request)
    {
        if($request->isMethod('GET')){
            $roles = Role::all();
            return view('users.create-user', compact('roles'));
        }
        $user = new User([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'author_bio' => $request->get('author_bio'),
            'password' => null
        ]);

        $role = Role::find($request->get('role'));
        $user->syncRoles($role);

        if($request->user_avatar) {
            $user->avatar = uploadFilesFromRequest(
                $request,
                'user_avatar',
                'users-avatars',
                strtolower("user_{$user->id}_avatar")
            );
        }
        $user->save();
        $user->sendPasswordSetupNotification();
        flashSuccessMessage("User: '{$user->name}' created successfully.");
        return redirect()->route('admin.user.list');
    }

    public function update(UpdateOrCreateUser $request, User $user)
    {
        if($request->isMethod('GET')){
            $roles = Role::all();
            return view('users.edit-user', compact('roles', 'user'));
        }
        $userAvatar = $user->avatar;
        if($request->user_avatar) {
            $userAvatar = uploadFilesFromRequest(
                $request,
                'user_avatar',
                'users-avatars',
                strtolower("user_{$user->id}_avatar")
            );
        }
        $user->update([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'author_bio' => $request->get('author_bio'),
            'avatar' => $userAvatar
        ]);
        $role = Role::find($request->get('role'));
        $user->syncRoles($role);
        flashSuccessMessage("User: @{$user->username} updated successfully");
        return redirect()->route('admin.user.list');
    }

    public function activate(User $user)
    {
        $user->update(['is_active' => 1]);
        flashSuccessMessage('User activated successfully');
        return redirect()->route('admin.user.list');
    }

    public function deactivate(User $user)
    {
        $user->update(['is_active' => 0]);
        flashSuccessMessage('User deactivated successfully');
        return redirect()->route('admin.user.list');
    }

    public function delete(User $user)
    {
        $user->delete();
        $userName = $user->username ?: $user->name;
        flashSuccessMessage("User:{$userName} removed successfully");
        return redirect()->route('admin.user.list');
    }
}
