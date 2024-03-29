<div class="space-y-6">
    <div class="flex flex-col lg:flex-row justify-between gap-2">
        <input type="search" class="input input-bordered" placeholder="Cari permission" wire:model.live="cari">
        @can('role.create')
            <button class="btn btn-primary" wire:click="$dispatch('addPermission')">
                <x-tabler-circle-plus class="icon-5" />
                <span>Role or permission</span>
            </button>
        @endcan
    </div>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <th>No</th>
                <th>Permission</th>
                @foreach ($roles as $role)
                    <th class="text-center capitalize">{{ $role->name }}</th>
                @endforeach
                @canany(['role.edit', 'role.delete'])
                    <th class="text-center">Action</th>
                @endcanany
            </thead>
            <tbody>
                @forelse ($permissions as $permit)
                    <tr wire:key="{{ $permit->id }}">
                        <td>{{ $no++ }}</td>
                        <td>{{ $permit->name }}</td>
                        @foreach ($roles as $role)
                            <td class="text-center">
                                <div class="flex items-center justify-center">
                                    @can('role.edit')
                                        <input type="checkbox" class="toggle toggle-primary toggle-sm"
                                            @checked($permit->hasRole($role->name))
                                            wire:change="applyPermission({{ $permit->id }}, '{{ $role->name }}')" />
                                    @else
                                        <x-tabler-check @class([
                                            'icon-5',
                                            'stroke-primary block' => $permit->hasRole($role->name),
                                            'hidden' => !$permit->hasRole($role->name),
                                        ]) />
                                    @endcan
                                </div>
                            </td>
                        @endforeach
                        @canany(['role.edit', 'role.delete'])
                            <td>
                                <div class="flex gap-1 justify-center">
                                    @can('role.edit')
                                        <button class="btn input-bordered btn-xs btn-square"
                                            wire:click="$dispatch('editPermission', {permission: {{ $permit->id }}})">
                                            <x-tabler-edit class="icon-4" />
                                        </button>
                                    @endcan
                                    @can('role.delete')
                                        <button class="btn input-bordered btn-xs btn-square"
                                            wire:click="deletePermission({{ $permit->id }})">
                                            <x-tabler-trash class="icon-4" />
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">
                            @livewire('partial.nocontent')
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @livewire('pages.role.actions')
</div>
