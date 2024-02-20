<div>
    @include('livewire.edt.quotation-form')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <div class="m-4">
        <h2 class="text-lg font-medium mr-auto">
            <b style="color: #31fbe2">{{__('QUOTATION TABLE')}}</b>
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
                    <select wire:model="quotationStatusFilter" name="quotationStatusFilter" id="quotationStatusFilter" class="form-control" style="width: 170px;">
                        <option value="" default>{{__('All')}}</option>
                        <option value="Sent">{{__('Sent')}}</option>
                        <option value="Approved">{{__('Approved')}}</option>
                        <option value="Rejected">{{__('Rejected')}}</option>
                    </select>
                </h2>

                <h2 class="text-lg font-medium mr-1">
                    <select wire:model="statusFilter" class="form-control" style="width: 170px;">
                        <option value="" default>{{__('All')}}</option>
                        <option value="1">{{__('Active')}}</option>
                        <option value="0">{{__('Non-Active')}}</option>
                    </select>
                </h2>

                <h6 class=" font-medium mr-auto">
                    <button class="btn btn-dark form-control py-0" wire:click="resetFilter()">{{__('Reset')}}</button>
                </h6>
            </div>
            <div>
                <button class="btn btn-info" data-toggle="modal" data-target="#createQuotationModal">{{__('Add New Quotation')}}</button>
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
                        <td class="align-middle">
                            @if ($col === 'id')
                                <b style="font-size: 14px">#QUI-{{ $item->id }}</b>
                            @elseif ($col === 'status')        
                            <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}" style="font-size: 14px">
                                <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                            </span>
                            @elseif ($col === 'grand_total_dollar')        
                            <div style="font-size: 14px">
                                $ {{number_format($item->grand_total_dollar)}}
                            </div>
                            @elseif ($col === 'grand_total_iraqi')        
                            <div  style="font-size: 14px">
                                {{number_format($item->grand_total_iraqi)}} IQD
                            </div>
                            @elseif ($col === 'quotation_status')
                                @if($item->quotation_status == 'Sent') 
                                    <span class="text-info" style="font-size: 14px">
                                        <b>{{__('Sent')}}</b>
                                    </span>
                                @elseif ($item->quotation_status == 'Approved') 
                                    <span class="text-success" style="font-size: 14px">
                                        <b>{{__('Approved')}}</b>
                                    </span>
                                @else 
                                    <span class="text-danger" style="font-size: 14px">
                                        <b>{{__('Rejected')}}</b>
                                    </span>
                                @endif
                            @else
                            <div style="font-size: 14px">
                                {{ data_get($item, $col) }}
                            </div>
                            @endif
                        </td>
                        @endforeach
                        <td class="align-middle">
                            <button type="button" data-toggle="modal" data-target="#editQuotationModal"
                                wire:click="editQuotation({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" wire:click="updateStatus({{ $item->id }})" class="btn {{ $item->status == 0 ? 'btn-danger' : 'btn-success' }} btn-icon m-1">
                                <i class="far {{ $item->status == 0 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            </button>
                            <button type="button" wire:click="notAllowed" class="btn {{ $item->quotation_status == 'Approved' ? 'btn-light' : 'btn-dark' }} btn-icon m-1" disabled>
                                <i class="{{ $item->quotation_status == 'Approved' ? 'fas fa-thumbs-up' : 'far fa-thumbs-up' }}"></i>
                            </button>
                            <button type="button" wire:click="notAllowed" class="btn {{ $item->quotation_status == 'Rejected' ? 'btn-light' : 'btn-dark' }} btn-icon m-1" disabled>
                                <i class="{{ $item->quotation_status == 'Rejected' ? 'fas fa-thumbs-down' : 'far fa-thumbs-down' }}"></i>
                            </button>
                            <button type="button" wire:click="printCustomPdf('{{ $item->id }}')" class="btn btn-dark btn-icon m-1">
                                <i class="fas fa-print"></i>
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
           'All Time': [moment().subtract(10, 'years'), moment()]
        }
    }, cb);
    cb(start, end);

});
</script>
<script>
    window.addEventListener('openPdfInNewTab', function (data) {
        window.open('/quotationpdf/' + data.detail.quotationId, '_blank');
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
