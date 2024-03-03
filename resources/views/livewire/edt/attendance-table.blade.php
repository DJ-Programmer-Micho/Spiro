<div>
    @include('livewire.edt.attendance-form')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <div class="m-4">
        <h2 class="d-flex justify-content-between text-lg font-medium">
            <div>
                <b style="color: #31fbe2">{{__('ATTENDANCE TABLE')}}</b>
            </div>
            <div>
                <button class="btn btn-primary" wire:click="printReportModal()" data-dismiss="modal" aria-label="Close" >{{__('Report')}}</button>
            </div>

        </h2>
        <div class="row d-flex justify-content-between m-0">
            <div class="d-flex">
                <div id="reportrange" class="form-control mr-3" style="cursor: pointer; padding: 5px 10px; border: 1px solid #333; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;<span>{{$rangeViewValue}}</span><i class="fa fa-caret-down"></i>
                </div>

                <h2 class="text-lg font-medium mr-1">
                    <input type="search" wire:model="search" class="form-control" placeholder="{{__('Search...')}}" style="width: 250px; border: 1px solid var(--primary)" />
                </h2>

                <h2 class="text-lg font-medium mr-1">
                    <select wire:model="empFilter" class="form-control" style="width: 170px;">
                        <option value="" default>{{__('All')}}</option>
                        @if($emp_data)
                        @foreach ($emp_data as $c_data)
                            <option value="{{$c_data->id}}">{{$c_data->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </h2>

                <h6 class=" font-medium mr-auto">
                    <button class="btn btn-dark form-control py-0" wire:click="resetFilter()">{{__('Reset')}}</button>
                </h6>
            </div>
            <div>
                <button class="btn btn-info" data-toggle="modal" data-target="#createAttendModal">{{__('Add New Attend')}}</button>
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
                    <tr>
                        @foreach ($cols_td as $col)
                        <td class="align-middle" style="font-size: 14px">
                            @if ($col === 'id')
                                <b>#ATD-{{ $item->id }}</b>  
                            @elseif ($col === 'status')
                            <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                            </span>
                            @elseif ($col === 'grand_total_dollar')        
                                $ {{number_format($item->grand_total_dollar)}}
                            @elseif ($col === 'grand_total_iraqi')        
                                {{number_format($item->grand_total_iraqi)}} IQD
                            @elseif ($col === 'Attend_status')
                                @if($item->Attend_status == 'Sent') 
                                    <span class="text-info">
                                        <b>{{__('Sent')}}</b>
                                    </span>
                                @elseif ($item->Attend_status == 'Approved') 
                                    <span class="text-success">
                                        <b>{{__('Approved')}}</b>
                                    </span>
                                @else 
                                    <span class="text-danger">
                                        <b>{{__('Rejected')}}</b>
                                    </span>
                                @endif
                            @else
                            {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td class="align-middle">
                            <button type="button" data-toggle="modal" data-target="#editAttendModal"
                                wire:click="editAttend({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteAttendModal" wire:click="deleteAttend({{ $item->id }})" class="btn btn-danger m-1" {{ $item->Attend_status == 'Approved' ? 'disabled' : '' }}>
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
<script>
    window.addEventListener('openPdfInNewTab', function (data) {
        window.open('/Attendpdf/' + data.detail.AttendId, '_blank');
    });
</script>
<script>
    document.addEventListener('focusDiscountDollar', function () {
    document.getElementById('discountDollarAdd').focus();
});

document.addEventListener('focusDiscountDollar', function () {
    document.getElementById('discountDollarEdit').focus();
});
</script>
@endpush
</div>
