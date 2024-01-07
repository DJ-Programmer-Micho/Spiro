<div>
    @include('livewire.fin.cash-form')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <div class="m-4">
        <h2 class="text-lg font-medium mr-auto">
            <b style="color: #31fbe2">{{__('CASH RECEIPT TABLE')}}</b>
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
                    <select wire:model="CashDueFilter" name="CashDueFilter" id="CashDueFilter" class="form-control" style="width: 170px;" wire:change="applyFilter">
                        <option value="" default>{{__('All')}}</option>
                        <option value="Not Complete">{{__('Not Complete')}}</option>
                        <option value="Complete">{{__('Complete')}}</option>
                    </select>
                </h2>

                <h6 class=" font-medium mr-auto">
                    <button class="btn btn-dark form-control py-0" wire:click="resetFilter()">{{__('Reset')}}</button>
                </h6>
            </div>
            <div>
                {{-- <button class="btn btn-info" data-toggle="modal" data-target="#createCashModal">{{__('Add New Cash Receipt')}}</button> --}}
                <button class="btn btn-info" data-toggle="modal" data-target="#selectNewCashModal">{{__('Add New Cash Receipt')}}</button>
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
                            <b>#CR-{{ $item->id }}</b>
                            @elseif ($col === 'invoice_id')
                            <b>#INV-{{ $item->invoice_id }}</b>
                            @elseif ($col === 'status')
                            <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                            </span>
                            @elseif ($col === 'grand_total_dollar')        
                                @if($item->due_dollar > 0)
                                <span class="text-success">$ {{number_format($item->grand_total_dollar)}}</span>
                                @else
                                <span class="text-info">$ {{number_format($item->grand_total_dollar)}}</span>
                                @endif 
                            @elseif ($col === 'grand_total_iraqi')        
                                @if($item->due_iraqi > 0)
                                <span class="text-success">{{number_format($item->grand_total_iraqi)}} IQD</span>
                                @else
                                <span class="text-info">{{number_format($item->grand_total_iraqi)}} IQD</span>
                                @endif  
                            @elseif ($col === 'due_dollar')        
                                @if($item->due_dollar > 0)
                                <span class="text-danger">$ {{number_format($item->due_dollar)}}</span>
                                @else
                                <span class="text-info">$ {{number_format($item->due_dollar)}}</span>
                                @endif 
                            @elseif ($col === 'due_iraqi')   
                                @if($item->due_iraqi > 0)
                                <span class="text-danger">{{number_format($item->due_iraqi)}} IQD</span>
                                @else
                                <span class="text-info">{{number_format($item->due_iraqi)}} IQD</span>
                                @endif     
                            @elseif ($col === 'cash_status')
                                @if($item->cash_status == 'Complete') 
                                    <span class="text-success">
                                        <b>{{__('Complete')}}</b>
                                    </span>
                                @else 
                                    <span class="text-danger">
                                        <b>{{__('Not Complete')}}</b>
                                    </span>
                                @endif
                            @else
                            {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td class="align-middle">
                            <button type="button" data-toggle="modal" data-target="#updateCashModal"
                                wire:click="editCash({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="fas fa-hand-holding-usd"></i>
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
           'All Time': [moment().subtract(25, 'year'), moment()]
        }
    }, cb);
    cb(start, end);

});
</script>
<script>
    window.addEventListener('printPdf', function (data) {
        console.log('printing');
        console.log(data);
        console.log(data.detail.pdfContent);
        const pdfDataDirectPrint = data.detail.pdfContent;
    
        // Create a blob from the base64 PDF content
        const blob = b64toBlob(pdfDataDirectPrint, 'application/pdf');
    
        // Create a data URL for the blob
        const pdfUrl = URL.createObjectURL(blob);
    
        // Open the PDF in a new window or tab
        let pdfWindow = window.open(pdfUrl, '_blank');
    
        // Wait for the window to fully load, then trigger the print
        pdfWindow.onload = function () {
            setTimeout(function () {
                pdfWindow.print();
            }, 1000); // Adjust the delay as needed
        };
    });
    
    // Function to convert base64 to Blob
    function b64toBlob(base64, contentType = '', sliceSize = 512) {
        const byteCharacters = atob(base64);
        const byteArrays = [];
    
        for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            const slice = byteCharacters.slice(offset, offset + sliceSize);
            const byteNumbers = new Array(slice.length);
    
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
    
            const byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }
    
        const blob = new Blob(byteArrays, { type: contentType });
        return blob;
    }
    
    </script>
@endpush
</div>
