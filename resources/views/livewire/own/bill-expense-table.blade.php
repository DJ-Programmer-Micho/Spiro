<div>
    @include('livewire.own.bill-expense-form')
    <div class="m-4">
        <h2 class="text-lg font-medium mr-auto">
            <b style="color: #31fbe2">{{__('Bill TABLE')}}</b>
        </h2>
        <div class="row d-flex justify-content-between m-0">
            <div>
                <h2 class="text-lg font-medium mr-auto">
                    <input type="search" wire:model="search" class="form-control" placeholder="{{__('Search...')}}" style="width: 250px; border: 1px solid var(--primary)" />
                </h2>
            </div>
            <div>
                <div class="">
                    <button class="btn btn-info" data-toggle="modal" data-target="#createBillModal">{{__('Add New Bill')}}</button>
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
                        <td>
                            @if ($col === 'status')
                                <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                   <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                                </span>
                            @elseif ($col === 'cost_dollar')        
                                $ {{number_format($item->cost_dollar)}}
                            @elseif ($col === 'cost_iraqi')        
                                {{number_format($item->cost_iraqi)}} IQD
                            @elseif ($col === 'priority')        
                                <input type="number" id="priority_{{ $item->id }}" value="{{ $item->priority }}" class="form-control bg-dark text-white">
                            @else
                                {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td>
                            <button type="button" data-toggle="modal" data-target="#updateBillModal"
                                wire:click="editBill({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" wire:click="updateStatus({{ $item->id }})" class="btn {{ $item->status == 0 ? 'btn-danger' : 'btn-success' }} btn-icon">
                                <i class="far {{ $item->status == 0 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                                </button>
                            <button type="button" data-toggle="modal" data-target="#deleteBillModal"
                                wire:click="deleteBill({{ $item->id }})" class="btn btn-danger m-1">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($cols_th) + 1 }}">{{__('No Record Found')}}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="dark:bg-gray-800 dark:text-white">
            {{ $items->links() }}
        </div>

    </div>
</div>
</div>

</div>
@if(session()->has('alert'))
    @php $alert = session()->get('alert'); @endphp
    <script>
        toastr.{{ $alert['type'] }}('{{ $alert['message'] }}');
    </script>
@endif
</div>