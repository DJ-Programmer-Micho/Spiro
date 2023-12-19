
<div>
    <style>
        .border-cut-b{
            border-bottom: 1px solid white;
            border-radius: 25px;
        }
        .border-cut-t{
            border-top: 1px solid white;
            border-radius: 25px;
        }
    </style>

    <!-- Insert Modal - Other -->
    <div wire:ignore.self class="modal fade overflow-auto" id="selectNewCashModal" tabindex="-1" aria-labelledby="selectNewCash" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addOtherExpense">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="selectNewCash" style="color: #31fbe2">{{__('Add Bill Expense')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Bill Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 ">
                                <label>{{__('Select The Invoice')}}</label>
                                <select wire:model="selectNotAttached" name="selectNotAttached" id="selectNotAttached" class="form-control" required>
                                    <option value="">{{__('Choose Status')}}</option>
                                    @if($this->notAttached)
                                    @foreach ($this->notAttached as $i_data)
                                    <option value="{{$i_data->id}}">{{$i_data->id}} | {{$i_data->client->client_name}} | {{$i_data->description}} | $ {{number_format($i_data->grand_total_dollar)}} | {{number_format($i_data->grand_total_iraqi)}} IQD</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="button" class="btn btn-success submitJs" data-toggle="modal" data-target="#createCashModal" data-dismiss="modal" aria-label="Close" wire:click="selectDataInvoice">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Insert Cash Modal -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createCashModal" tabindex="-1" aria-labelledby="createCashModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addCash">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCashModal" style="color: #31fbe2">{{__('Add New Cash')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row m-0">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Client Information')}}</b>
                                <small class="text-danger">{{__('(Read Only)')}}</small>
                            </h5>
                            
                        </div>

                        <div class="row border-cut-b">
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label>{{__('Name')}}</label>
                                    <input type="email" name="clientName" wire:model="clientName" class="form-control" id="clientName" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientCountry">{{__('Country:')}}</label>
                                    <input type="text" name="clientCountry" wire:model="clientCountry" class="form-control" id="clientCountry" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientCity">{{__('City:')}}</label>
                                    <input type="text" name="clientCity" wire:model="clientCity" class="form-control" id="clientCity" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label for="clientAddress">{{__('Address:')}}</label>
                                    <input type="text" name="clientAddress" wire:model="clientAddress" class="form-control" id="clientAddress" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientEmail">{{__('Email:')}}</label>
                                    <input type="email" name="clientEmail" wire:model="clientEmail" class="form-control" id="clientEmail" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientPhoneOne">{{__('Primary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneOne" wire:model="clientPhoneOne" class="form-control" id="clientPhoneOne" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientPhoneOne">{{__('Secondary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneTwo" wire:model="clientPhoneTwo" class="form-control" id="clientPhoneTwo" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label>{{__('Cash Created Date')}}</label>
                                    <input type="date" name="formDateCash" wire:model="formDateCash" class="form-control" id="formDateCash" disabled>
                                </div>
                                <div class="mb-1">
                                    <label>{{__('Invocie Created Date')}}</label>
                                    <input type="date" name="formDateInvoice" wire:model="formDateInvoice" class="form-control" id="formDateInvoice" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientId">{{__('Client-ID:')}}</label>
                                    <input type="text" name="clientId" wire:model="clientId" class="form-control" id="clientId" disabled>
                                </div>
                                <div class="mb-1">
                                    <label>{{__('Exchange Rate:')}} <small>($1 = ? IQD)</small></label>
                                    <input type="number" name="exchange_rate" wire:model="exchange_rate" class="form-control" id="exchange_rate" wire:change="exchangeUpdate" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0 mt-1">
                            <h5 class="mt-4 mb-1"><b>{{__('Cash Date')}}</b></h5>
                        </div>

                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Payment Section')}}</b></h5>
                            <div>
                                <button class="btn btn-info" type="button" wire:click="newRecPayment">{{__('New Payment')}}</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="serviceName">{{__('Short Description:')}}</label>
                            <input type="text" name="description" wire:model="description" class="form-control" id="description" disabled>
                            <small class="text-danger">{{__('(Read Only)')}}</small>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive met-table-panding">
                                <table class="table table-dark table-striped table-bordered border-dark align-middle">

                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date</th> 
                                        <th scope="col">Paid ($)</th> 
                                        <th scope="col">Paid (IQD)</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($arr_payments as $index => $a_pay)
                                        <tr>
                                            <td class="align-middle" scope="row">{{$index + 1}}</td>
                                            <td class="align-middle" width="90px">
                                                <input type="date" name="arr_payments.{{ $index }}.payment_date" wire:model="arr_payments.{{ $index }}.payment_date" class="form-control" id="arr_payments.{{ $index }}.payment_date" @if($index == 0 && $hasFirstPayment) disabled @endif required>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap mb-1">
                                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                                    <input type="number" name="paymentAmountDollar" wire:model="arr_payments.{{ $index }}.paymentAmountDollar" class="form-control" wire:change="enterNewPayment({{$index}})" @if($index == 0 && $hasFirstPayment) disabled @endif required>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">IQD</span>
                                                    <input type="number" name="serviceTotalIraqi" wire:model="arr_payments.{{ $index }}.paymentAmountIraqi" class="form-control" @if($index == 0 && $hasFirstPayment) disabled @endif required>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-danger" wire:click="removePayment({{ $index }})" @if($index == 0 && $hasFirstPayment) disabled @endif><i class="fas fa-trash-alt"></i></button>
                                            </td>                                       
                                        </tr>
                                      @endforeach
                                    </tbody>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </table>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0 border-cut-t">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Final Section')}}</b>
                                <small class="text-danger">{{__('(Read Only)')}}</small>
                            </h5>
                            {{-- <div>
                                <button class="btn btn-info" data-toggle="modal" data-target="#addPaymentDirect">{{__('Add New Method')}}</button>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                @for ($i = 1; $i <= 5; $i++)
                                <div class="mb-3">
                                    <label>{{__('Note No.')}}{{$i}}</label>
                                    <input type="text" name="note" wire:model="note.{{$i}}" class="form-control" id="note.{{$i}}" disabled>
                                </div>
                                @endfor
                            </div>
                            <div class="col-sm-3">

                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} ($)</label>
                                    {{-- <input type="number" name="grandTotalDollar" wire:model="grandTotalDollar" class="form-control" id="grandTotalDollar" disabled> --}}
                                    <h3 class="text-success border">$ {{number_format($grandTotalDollar) ?? null}}</h3>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Due:')}} ($)</label>
                                    {{-- <input type="number" name="dueDollar" wire:model="dueDollar" class="form-control" id="dueDollar" disabled> --}}
                                    <h3 class="text-danger border">$ {{number_format($dueDollar) ?? null }}</h3>
                                </div>
                            </div>
                            <div class="col-sm-3">
                            
                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} (IQD)</label>
                                    {{-- <input type="number" name="grandTotalIraqi" wire:model="grandTotalIraqi" class="form-control" id="grandTotalIraqi" disabled> --}}
                                    <h3 class="text-success border">{{number_format($grandTotalIraqi) ?? null }} IQD</h3>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Due:')}} (IQD)</label>
                                    {{-- <input type="number" name="dueIraqi" wire:model="dueIraqi" class="form-control" id="dueIraqi" disabled> --}}
                                    <h3 class="text-danger border">{{number_format($dueIraqi) ?? null}} IQD</h3>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Cash Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="updateCashModal" tabindex="-1" aria-labelledby="updateCashModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateCash">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateCashModal" style="color: #31fbe2">{{__('Add New Cash')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row m-0">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Client Information')}}</b>
                                <small class="text-danger">{{__('(Read Only)')}}</small>
                            </h5>
                            
                        </div>

                        <div class="row border-cut-b">
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label>{{__('Name')}}</label>
                                    <input type="email" name="clientName" wire:model="clientName" class="form-control" id="clientName" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientCountry">{{__('Country:')}}</label>
                                    <input type="text" name="clientCountry" wire:model="clientCountry" class="form-control" id="clientCountry" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientCity">{{__('City:')}}</label>
                                    <input type="text" name="clientCity" wire:model="clientCity" class="form-control" id="clientCity" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label for="clientAddress">{{__('Address:')}}</label>
                                    <input type="text" name="clientAddress" wire:model="clientAddress" class="form-control" id="clientAddress" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientEmail">{{__('Email:')}}</label>
                                    <input type="email" name="clientEmail" wire:model="clientEmail" class="form-control" id="clientEmail" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientPhoneOne">{{__('Primary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneOne" wire:model="clientPhoneOne" class="form-control" id="clientPhoneOne" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientPhoneOne">{{__('Secondary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneTwo" wire:model="clientPhoneTwo" class="form-control" id="clientPhoneTwo" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label>{{__('Cash Created Date')}}</label>
                                    <input type="date" name="formDateCash" wire:model="formDateCash" class="form-control" id="formDateCash" disabled>
                                </div>
                                <div class="mb-1">
                                    <label>{{__('Invocie Created Date')}}</label>
                                    <input type="date" name="formDateInvoice" wire:model="formDateInvoice" class="form-control" id="formDateInvoice" disabled>
                                </div>
                                <div class="mb-1">
                                    <label for="clientId">{{__('Client-ID:')}}</label>
                                    <input type="text" name="clientId" wire:model="clientId" class="form-control" id="clientId" disabled>
                                </div>
                                <div class="mb-1">
                                    <label>{{__('Exchange Rate:')}} <small>($1 = ? IQD)</small></label>
                                    <input type="number" name="exchange_rate" wire:model="exchange_rate" class="form-control" id="exchange_rate" wire:change="exchangeUpdate" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0 mt-1">
                            <h5 class="mt-4 mb-1"><b>{{__('Cash Date')}}</b></h5>
                        </div>

                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Payment Section')}}</b></h5>
                            <div>
                                <button class="btn btn-info" type="button" wire:click="newRecPayment">{{__('New Payment')}}</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="serviceName">{{__('Short Description:')}}</label>
                            <input type="text" name="description" wire:model="description" class="form-control" id="description" disabled>
                            <small class="text-danger">{{__('(Read Only)')}}</small>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive met-table-panding">
                                <table class="table table-dark table-striped table-bordered border-dark align-middle">

                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date</th> 
                                        <th scope="col">Paid ($)</th> 
                                        <th scope="col">Paid (IQD)</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($arr_payments as $index => $a_pay)
                                        <tr>
                                            <td class="align-middle" scope="row">{{$index + 1}}</td>
                                            <td class="align-middle" width="90px">
                                                <input type="date" name="arr_payments.{{ $index }}.payment_date" wire:model="arr_payments.{{ $index }}.payment_date" class="form-control" id="arr_payments.{{ $index }}.payment_date" @if($index == 0 && $hasFirstPayment) disabled @endif required>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap mb-1">
                                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                                    <input type="number" name="paymentAmountDollar" wire:model="arr_payments.{{ $index }}.paymentAmountDollar" class="form-control" wire:change="enterNewPayment({{$index}})" @if($index == 0 && $hasFirstPayment) disabled @endif required>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">IQD</span>
                                                    <input type="number" name="serviceTotalIraqi" wire:model="arr_payments.{{ $index }}.paymentAmountIraqi" class="form-control" @if($index == 0 && $hasFirstPayment) disabled @endif required>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-danger" wire:click="removePayment({{ $index }})" @if($index == 0 && $hasFirstPayment) disabled @endif><i class="fas fa-trash-alt"></i></button>
                                            </td>                                       
                                        </tr>
                                      @endforeach
                                    </tbody>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </table>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0 border-cut-t">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Final Section')}}</b>
                                <small class="text-danger">{{__('(Read Only)')}}</small>
                            </h5>
                            {{-- <div>
                                <button class="btn btn-info" data-toggle="modal" data-target="#addPaymentDirect">{{__('Add New Method')}}</button>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                @for ($i = 1; $i <= 5; $i++)
                                <div class="mb-3">
                                    <label>{{__('Note No.')}}{{$i}}</label>
                                    <input type="text" name="note" wire:model="note.{{$i}}" class="form-control" id="note.{{$i}}" disabled>
                                </div>
                                @endfor
                            </div>
                            <div class="col-sm-3">

                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} ($)</label>
                                    {{-- <input type="number" name="grandTotalDollar" wire:model="grandTotalDollar" class="form-control" id="grandTotalDollar" disabled> --}}
                                    <h3 class="text-success border">$ {{number_format($grandTotalDollar) ?? null}}</h3>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Due:')}} ($)</label>
                                    {{-- <input type="number" name="dueDollar" wire:model="dueDollar" class="form-control" id="dueDollar" disabled> --}}
                                    <h3 class="text-danger border">$ {{number_format($dueDollar) ?? null }}</h3>
                                </div>
                            </div>
                            <div class="col-sm-3">
                            
                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} (IQD)</label>
                                    {{-- <input type="number" name="grandTotalIraqi" wire:model="grandTotalIraqi" class="form-control" id="grandTotalIraqi" disabled> --}}
                                    <h3 class="text-success border">{{number_format($grandTotalIraqi) ?? null }} IQD</h3>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Due:')}} (IQD)</label>
                                    {{-- <input type="number" name="dueIraqi" wire:model="dueIraqi" class="form-control" id="dueIraqi" disabled> --}}
                                    <h3 class="text-danger border">{{number_format($dueIraqi) ?? null}} IQD</h3>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
     <!-- Delete Cash Modal  -->
    <div wire:ignore.self class="modal fade" id="deleteCashModal" tabindex="-1" aria-labelledby="deleteCashModal"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCashModal">{{__('Delete Cash')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyCash">
                    <div class="modal-body">
                        <p class="text-danger">{{ __('Are you sure you want to delete this Company?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_cash_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="cash_name_to_selete" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                            <button type="submit" class="btn btn-danger" wire:disabled="!$confirmDelete || $cash_name_to_selete !== $del_Cash_name">
                                {{ __('Yes! Delete') }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 {{-- 
    <!-- Insert Client Direct Modal -->
    <div wire:ignore.self class="modal fade overflow-auto" id="addClientDirect" tabindex="-1" aria-labelledby="addClientDirect" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addClientDirect">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addClientDirect" style="color: #31fbe2">{{__('Add Client')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <div class="row mt-5">
                            <h5 class="mb-4"><b>{{__('Initialize Information')}}</b></h5>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="dClientName">{{__('Client Name:')}}</label>
                                        <input type="text" name="dClientName" wire:model="dClientName" class="form-control" id="dClientName">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="country">{{__('Country:')}}</label>
                                        <input type="text" name="country" wire:model="country" class="form-control" id="country">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="city">{{__('City:')}}</label>
                                        <input type="text" name="city" wire:model="city" class="form-control" id="city">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="address">{{__('Address:')}}</label>
                                        <input type="text" name="address" wire:model="address" class="form-control" id="address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <h5 class="mb-4"><b>{{__('Secondary Information')}}</b></h5>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="phoneOne">{{__('Phone Number 1:')}}</label>
                                        <input type="text" name="phoneOne" wire:model="phoneOne" class="form-control" id="phoneOne">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="phoneTwo">{{__('Phone Number 2')}}</label>
                                        <input type="text" name="phoneTwo" wire:model="phoneTwo" class="form-control" id="phoneTwo">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="email">{{__('Email Address:')}}</label>
                                        <input type="email" name="email" wire:model="email" class="form-control" id="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
</div>