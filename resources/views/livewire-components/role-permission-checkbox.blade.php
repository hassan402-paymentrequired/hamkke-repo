<td>
        <div class="form-check me-3 me-lg-5">
            <input class="form-check-input" type="checkbox" wire:model="permissionAssigned"
                   name="roles[{{$role->id}}][permissions][{{$permission->id}}]"
                   id="{{ $role->name }}-{{ $permission->name }}" wire:change="updatePermission"/>
        </div>
</td>

