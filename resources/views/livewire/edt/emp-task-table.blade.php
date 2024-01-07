<div>
    @include('livewire.edt.emp-task-form')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <div class="m-4">
        <h2 class="text-lg font-medium mr-auto">
            <b style="color: #31fbe2">{{__('EMPLOYEE TASKS TABLE')}}</b>
        </h2>
        <div class="row d-flex justify-content-between m-0">
            <div class="d-flex">
                <div id="reportrange" class="form-control mr-3" style="cursor: pointer; padding: 5px 10px; border: 1px solid #333; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;<span>{{$rangeViewValue}}</span><i class="fa fa-caret-down"></i>
                </div>

                <h2 class="text-lg font-medium mr-1">
                    <input type="search" wire:model="search" class="form-control" placeholder="Search..." style="width: 250px; border: 1px solid var(--primary)" />
                </h2>

                <h2 class="text-lg font-medium mr-1">
                    <select wire:model="taskStatus" name="taskStatus" id="taskStatus" class="form-control" style="width: 170px;" wire:change="applyFilter">
                        <option value="null" default>{{__('All')}}</option>
                        <option value="In Pending">{{__('In Pending')}}</option>
                        <option value="In Process">{{__('In Process')}}</option>
                        <option value="Complete">{{__('Complete')}}</option>
                    </select>
                </h2>

                <h6 class=" font-medium mr-auto">
                    <button class="btn btn-dark form-control py-0" wire:click="resetFilter()">{{__('Reset')}}</button>
                </h6>
            </div>
            <div>
                <button class="btn btn-info" data-toggle="modal" data-target="#newEmpTaskModal">{{__('Add New Task')}}</button>
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
                            @if ($col === 'id')
                            <b>#TS-{{ $item->id }}</b>
                            @elseif ($col === 'invoice.id')
                            <b>#INV-{{ $item->invoice_id }}</b>
                            @elseif ($col === 'status')
                            <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                            </span>
                            @elseif ($col === 'task_status')        
                                @if($item->task_status == 'In Pending')
                                <span class="text-danger">{{$item->task_status}}</span>
                                @elseif ($item->task_status == 'In Process')
                                <span class="text-warning">{{$item->task_status}}</span>
                                @else
                                <span class="text-success">{{$item->task_status}}</span>
                                @endif
                            @elseif ($col === 'progress')        
                                @if($item->progress == 0 && $item->progress <= 24)
                                <span class="text-dark">{{$item->progress}} %</span>
                                @elseif ($item->progress >= 25 && $item->progress <= 49)
                                <span class="text-danger">{{$item->progress}} %</span>
                                @elseif ($item->progress >= 50 && $item->progress <= 74)
                                <span class="text-warning">{{$item->progress}} %</span>
                                @elseif ($item->progress >= 75 && $item->progress <= 99)
                                <span class="text-info">{{$item->progress}} %</span>
                                @elseif ($item->progress == 100)
                                <span class="text-success">{{$item->progress}} %</span>
                                @endif 
                            @else
                            {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td class="align-middle">
                            <button type="button" data-toggle="modal" data-target="#updateTaskModal" wire:click="editTask({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" wire:click="approved({{ $item->id }})" class="btn {{ $item->approved == 1 ? 'btn-success text-dark' : 'btn-dark' }} btn-icon m-1">
                                <i class="{{ $item->approved == 1 ? 'fas fa-thumbs-up' : 'far fa-thumbs-down' }}"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteTaskModal" wire:click="deleteTask({{ $item->id }})" class="btn btn-danger m-1">
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

@push('datePicker')
    
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$(function() {
    var start =  moment().startOf('year');
    var end = moment().endOf('year');
    
    function cb(start, end) {
        // $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        // Update Livewire component property
        @this.set('dateRange', start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        // Emit Livewire event
        @this.emit('dateRangeSelected');
    }
    
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'This Year': [moment().startOf('year'), moment().endOf('year')],
           'All Time': [moment().subtract(25, 'year'), moment()]
        }
    }, cb);
    cb(start, end);

});
</script>
@endpush
</div>
