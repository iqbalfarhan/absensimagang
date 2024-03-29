<div class="space-y-6">
    <div class="flex flex-col lg:flex-row justify-between gap-2">
        <input type="search" class="input input-bordered" placeholder="Pencarian" wire:model.live="cari">
        @can('user.create')
            <button class="btn btn-primary" wire:click="$dispatch('createUser')">
                <x-tabler-circle-plus class="icon-5" />
                <span>Tambah user</span>
            </button>
        @endcan
    </div>

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                @can('user.edit')
                    <th>Active</th>
                @endcan
                @canany(['user.show', 'user.edit', 'user.delete'])
                    <th class="text-center">Actions</th>
                @endcanany
            </thead>
            <tbody>
                @forelse ($datas as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                            <div class="flex gap-2 items-center">
                                <div class="avatar">
                                    <div class="w-5 rounded-full">
                                        <img src="{{ $data->avatar }}" alt="">
                                    </div>
                                </div>
                                <span>{{ $data->name }}</span>
                            </div>
                        </td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->getRoleNames()->first() }}</td>
                        @can('user.edit')
                            <td>
                                <input type="checkbox" class="toggle toggle-primary toggle-sm" @checked($data->active)
                                    wire:change="$dispatch('toggleActiveUser', {user : {{ $data->id }}})">
                            </td>
                        @endcan
                        @canany(['user.show', 'user.edit', 'user.delete'])
                            <td>
                                <div class="flex gap-1 justify-center">
                                    @can('user.show')
                                        <a href="{{ route('user.show', $data) }}" class="btn btn-xs btn-square input-bordered"
                                            wire:navigate>
                                            <x-tabler-folder class="icon-4" />
                                        </a>
                                    @endcan
                                    @can('user.edit')
                                        <button class="btn btn-xs btn-square input-bordered"
                                            wire:click="$dispatch('updateUser', {user:{{ $data->id }}})">
                                            <x-tabler-edit class="icon-4" />
                                        </button>
                                    @endcan
                                    @can('user.delete')
                                        <button class="btn btn-xs btn-square input-bordered"
                                            wire:click="$dispatch('deleteUser', {user:{{ $data->id }}})">
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

    @livewire('pages.user.actions')
</div>
