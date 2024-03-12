<div>
    <h4 class="py-3 mb-4">Manage Permissions</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">Permissions List</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered permissions-management-table">
                        <thead class="thead-dark">
                        <tr>
                            <th>S/N</th>
                            <th>Permission Name</th>
                            @foreach($roles as $role)
                                <th>{{ $role->display_name }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <?php $n = 0; ?>
                        @foreach($userPermissions as $perm)
                            <tr :key="$perm->id">
                                <td>{{ $n += 1 }}</td>
                                <td class="nk-tb-col">{{ $perm->display_name }}</td>
                                @foreach($roles as $role)
                                    <livewire:role-permission-checkbox :role="$role" :permission="$perm" :key="$role->name . '_' . $perm->name" >
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<x-slot name="more_scripts_slot">
    @script
    <script>
        $wire.on('permission-updated', (event) => {
            const eventParams = event[0]
            HamkkeJsHelpers.showToast('Successful', eventParams.toastMessage)
        });
    </script>
    @endscript
</x-slot>

