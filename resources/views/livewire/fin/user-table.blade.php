<div>
    @include('livewire.fin.user-form')
    <div class="m-4">
        <h2 class="text-lg font-medium mr-auto">
            <b style="color: #31fbe2">{{__('USER TABLE')}}</b>
        </h2>
        <div class="row d-flex justify-content-between m-0">
            <div>
                <h2 class="text-lg font-medium mr-auto">
                    <input type="search" wire:model="search" class="form-control" placeholder="Search..."
                        style="width: 250px; border: 1px solid var(--primary)" />
                </h2>
            </div>
            <div>
                <div class="">
                    <button class="btn btn-info" data-toggle="modal"
                        data-target="#createUserModal">{{__('Add New User')}}</button>
                </div>
            </div>
        </div>
        @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm table-dark">
                <thead>
                    <tr>
                        @foreach ($cols_th as $col)
                        <th style="font-size: 14px">{{ __($col) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr style="font-size: 14px">
                        @foreach ($cols_td as $col)
                        <td class="align-middle">
                            @if ($col === 'status')
                            <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                            </span>
                            @elseif ($col === 'avatar')
                            <img src="{{ asset('avatars/' . $item->avatar) }}" alt="spiro" class="img-thumbnail rounded-circle" width="75px">
                            {{-- @elseif ($col === 'priority')
                            <input type="number" id="priority_{{ $item->id }}" value="{{ $item->priority }}"
                                class="form-control bg-dark text-white"> --}}
                            @elseif ($col === 'role')
                                @if($item->role == 1) 
                                    <span class="text-danger">
                                        <b>Admin</b>
                                    </span>
                                @elseif ($item->role == 2)
                                    <span class="text-warning">
                                        <b>Editor</b>
                                    </span>
                                @elseif ($item->role == 3) 
                                    <span class="text-white">
                                        <b>Finance</b>
                                    </span>
                                @else 
                                    <span class="text-info">
                                        <b>Employee</b>
                                    </span>
                                @endif
                            @else
                            {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td class="align-middle">
                            <button type="button" data-toggle="modal" data-target="#updateUserModal"
                                wire:click="editUser({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" wire:click="deleteMessage" class="btn btn-danger m-1" disabled>
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="align-middle" colspan="{{ count($cols_th) + 1 }}">{{__('No Record Found')}}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="dark:bg-gray-800 dark:text-white">
            {{ $items->links() }}
        </div>

    </div>
{{-- </div> --}}
@if(session()->has('alert'))
@php $alert = session()->get('alert'); @endphp
<script>
    toastr. {
        {
            $alert['type']
        }
    }('{{ $alert['
        message '] }}');

</script>
@endif
</div>
