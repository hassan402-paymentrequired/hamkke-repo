<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Livewire\Component;

class RolePermissionCheckbox extends Component
{
    public Role $role;

    public Permission $permission;

    public $permissionAssigned;

    public function mount($role, $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
        $this->permissionAssigned = $this->role->hasPermissionTo($this->permission->name);
    }

    public function updatePermission(): void
    {
        if ($this->permissionAssigned) {
            // Attach permission to the role
            $this->role->permissions()->attach($this->permission->id);
            $toastMessage = "The role '{$this->role->display_name}' now has permission '{$this->permission->display_name}'";
        } else {
            // Detach permission from the role
            $this->role->permissions()->detach($this->permission->id);
            $toastMessage = "Permission '{$this->permission->display_name}' has been detached from role '{$this->role->display_name}'";
        }
        $this->dispatch('permission-updated', ['toastMessage' => $toastMessage]);
    }

    public function render()
    {
        return view('livewire-components.role-permission-checkbox');
    }
}
