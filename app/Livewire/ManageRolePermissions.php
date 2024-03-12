<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permissions Management')]
class ManageRolePermissions extends Component
{
    /**
     * @var User|Authenticatable $authUser
     * @var Role[]|Collection $roles
     * @var Permission[]|Collection $userPermissions
     * @var RolePermission[]|Collection $rolePermissions
     */
    public $authUser;

    public $roles = [];
    public $userPermissions = [];
    public $rolePermissions = [];


    public function mount()
    {
        $this->authUser = auth()->user();
        $this->roles = $this->authUser->hasRole(ROLE_NAME_SUPER_ADMIN) ? Role::all()
            : Role::where('hierarchy', '<', $this->authUser->roles()->max('hierarchy'))->get();
        $this->userPermissions = $this->authUser->getAllPermissions();
        $this->rolePermissions = RolePermission::all();
    }

    public function render()
    {
        return view('livewire-components.manage-role-permissions');
    }
}
