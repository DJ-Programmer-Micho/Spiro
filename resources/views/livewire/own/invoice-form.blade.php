
<div>
    <!-- Insert Invoice Modal -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createInvoiceModal" tabindex="-1" aria-labelledby="createInvoiceModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addInvoice">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createQuotationModal" style="color: #31fbe2">{{__('Add New Invoice')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row d-flex justify-content-between m-0 mt-1">
                            <h5 class="mt-4 mb-1"><b>{{__('Invoice Date')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Invoice Created Date')}}</label>
                                    <input type="date" name="formDate" wire:model="formDate" class="form-control" id="formDate">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Status')}}</label>
                                    <select wire:model="status" name="status" id="status" class="form-control" required>
                                        <option value="">{{__('Choose Status')}}</option>
                                            <option value="1">{{__('Active')}}</option>
                                            <option value="0">{{__('Non-Active')}}</option>
                                    </select>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Client Information')}}</b></h5>
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addClientDirect">{{__('Add New Client')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Client Name')}}</label>
                                    <select wire:model="select_client_data" wire:change="selectClientStartup" name="select_client_data" id="select_client_data" class="form-control" required>
                                        <option value="">{{__('Choose Client')}}</option>
                                        @if($client_data)
                                        @foreach ($client_data as $c_data)
                                            <option value="{{$c_data->id}}">{{$c_data->client_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            {{-- <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientEmail">{{__('Client Email Address:')}}</label>
                                    <input type="email" name="clientEmail" wire:model="clientEmail" class="form-control" id="clientEmail" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label for="clientCountry">{{__('Country:')}}</label>
                                    <input type="text" name="clientCountry" wire:model="clientCountry" class="form-control" id="clientCountry" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label for="clientCity">{{__('City:')}}</label>
                                    <input type="text" name="clientCity" wire:model="clientCity" class="form-control" id="clientCity" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div> --}}
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientAddress">{{__('Address:')}}</label>
                                    <input type="text" name="clientAddress" wire:model="clientAddress" class="form-control" id="clientAddress" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientPhoneOne">{{__('Primary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneOne" wire:model="clientPhoneOne" class="form-control" id="clientPhoneOne" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientPhoneTwo">{{__('Secondary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneTwo" wire:model="clientPhoneTwo" class="form-control" id="clientPhoneTwo" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Payment Method')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Payment Type')}}</label>
                                    <select wire:model="select_payment_data" wire:change="selectPaymentStartup" name="select_payment_data" id="select_payment_data" class="form-control" required>
                                        <option value="">{{__('Choose Payment Type')}}</option>
                                        @if($payment_data)
                                        @foreach ($payment_data as $p_data)
                                        <option value="{{$p_data->id}}">{{$p_data->payment_type}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Exchange Rate:')}} <small>($1 = ? IQD)</small></label>
                                    <input type="number" name="exchange_rate" wire:model="exchange_rate" class="form-control" id="exchange_rate" wire:change="exchangeUpdate">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="serviceName">{{__('Title:')}}</label>
                            <input type="text" name="description" wire:model="description" class="form-control" id="description">
                            <small class="text-info">{{__('(Read & Write)')}}</small>
                        </div>
                        <div class="row d-flex justify-content-between m-0" style="border-top: 2px dotted #fff; border-bottom: 2px dotted #cc0022">
                            <h5 class="mt-4"><b>{{__('Service Section')}}</b></h5>
                            <button class="btn btn-success mt-3 mb-3" type="button" wire:click="addNewDate">{{__('Add New Date')}}</button>
                        </div>
                <div>  
                        @foreach ($arr_service_by_date as $dateIndex => $services)
                        <div class="mb-3 mt-3">
                            <div class="d-flex justify-content-between">
                                <h3>{{__('Booking No.')}}{{ $dateIndex + 1}}</h3>
                                <button class="btn btn-danger" type="button" wire:click="removeDate('{{ $dateIndex }}')" @if($dateIndex == 0) disabled @endif>{{__('Remove This Date')}}</button>
                            </div>
                            <label for="serviceName">{{__('Short Description:')}}</label>
                            <input type="text" name="arr_service_by_date.{{$dateIndex}}.description" wire:model="arr_service_by_date.{{$dateIndex}}.description" class="form-control" id="arr_service_by_date.{{$dateIndex}}.description" required>
                            <small class="text-info">{{__('(Read & Write)')}}</small>
                        </div>
                        <div class="row" style="border-bottom: 2px dotted #cc0022;">
                            <div class="row d-flex justify-content-between m-0">
                                <div>
                                    <input class="form-control" type="date" name="arr_service_by_date.{{$dateIndex}}.actionDate" wire:model="arr_service_by_date.{{$dateIndex}}.actionDate" id="arr_service_by_date.{{$dateIndex}}.actionDate" required>
                                </div>
                                <div>
                                    <button class="btn btn-info my-3" type="button" wire:click="newRecService('{{ $dateIndex }}')">{{__('New Record Service')}}</button>
                                </div>
                                <table class="table table-dark table-striped table-bordered border-dark align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{__('Code')}}</th>
                                            <th scope="col">{{__('Service')}}</th>
                                            <th scope="col">{{__('Description')}}</th>
                                            <th scope="col">{{__('Unit Price')}}</th>
                                            <th scope="col">{{__('QTY')}}</th>
                                            <th scope="col">{{__('Total')}}</th>
                                            <th scope="col">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services['services'] as $serviceIndex => $a_ser)
                                        <tr>
                                            <td class="align-middle" scope="row">{{ $serviceIndex  + 1 }}</td>
                                            <td class="align-middle" width="90px">
                                                <input type="text" name="serviceCode.{{ $serviceIndex  }}"
                                                    wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex}}.serviceCode"
                                                    class="form-control" id="serviceCode.{{ $serviceIndex  }}" disabled>

                                            </td>
                                            <td class="align-middle" width="200px">
                                                <select
                                                    wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.select_service_data"
                                                    class="form-control"
                                                    wire:change="selectServiceDataChange('{{$dateIndex}}',{{ $serviceIndex  }})"
                                                    required>
                                                    <option value="">{{__('Select Service Type')}}</option>
                                                    @foreach ($service_data as $service)
                                                    <option value="{{ $service->id }}">{{ $service->service_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle">
                                                <input type="text" name="serviceDescription"
                                                    wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceDescription"
                                                    class="form-control" disabled>
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap mb-1">
                                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                                    <input type="number" name="serviceDefaultCostDollar"
                                                        wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceDefaultCostDollar"
                                                        class="form-control"
                                                        wire:change="serviceQtyChange('{{$dateIndex}}',{{ $serviceIndex  }})">
                                                </div>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">IQD</span>
                                                    <input type="number" name="serviceDefaultCostIraqi"
                                                        wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceDefaultCostIraqi"
                                                        class="form-control"
                                                        wire:change="serviceQtyChange('{{$dateIndex}}',{{ $serviceIndex  }})"
                                                        disabled>
                                                </div>
                                            </td>
                                            <td class="align-middle" width="80px">
                                                <input type="number" name="serviceQty"
                                                    wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceQty"
                                                    class="form-control"
                                                    wire:change="serviceQtyChange('{{$dateIndex}}',{{ $serviceIndex  }})">
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap mb-1">
                                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                                    <input type="number" name="serviceTotalDollar"
                                                        wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceTotalDollar"
                                                        class="form-control" disabled>
                                                </div>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">IQD</span>
                                                    <input type="number" name="serviceTotalIraqi"
                                                        wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceTotalIraqi"
                                                        class="form-control" disabled>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-danger"
                                                    wire:click="removeService('{{ $dateIndex }}', {{ $serviceIndex  }})"  @if($serviceIndex == 0) disabled @endif>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                        </div>

                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Final Section')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label aria-label="note">{{__('Note')}}</label>
                                <textarea name="note" id="note" rows="18" wire:model="note" style="width: 100%" required></textarea>
                                <small class="text-info">{{__('(Read & Write)')}}</small>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>{{__('Total:')}} ($)</label>
                                    <input type="number" name="totalDollar" wire:model="totalDollar" class="form-control" id="totalDollar" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            
                                <div class="mb-3">
                                    {{-- <label>{{__('TAX:')}} ($)</label> --}}
                                    <input type="hidden" name="taxDollar" wire:model="taxDollar" class="form-control" id="taxDollar" wire:change="calculateTotals">
                                    {{-- <small class="text-info">{{__('(Read & Write)')}}</small> --}}
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Discount:')}} ($)</label>
                                    <input type="number" name="discountDollar" wire:model="discountDollar" class="form-control" id="discountDollar" wire:change="calculateTotals">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                                                            
                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} ($)</label>
                                    <input type="number" name="grandTotalDollar" wire:model="grandTotalDollar" class="form-control" id="grandTotalDollar" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                                
                                {{-- <div class="mb-3">
                                    <label>{{__('First Pay:')}} ($)</label>
                                    <input type="number" name="fisrtPayDollar" wire:model="fisrtPayDollar" class="form-control" id="fisrtPayDollar" wire:change="calculateTotals">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div> --}}
                                            {{-- 
                                <div class="mb-3">
                                    <label>{{__('Due:')}} ($)</label>
                                    <input type="number" name="dueDollar" wire:model="dueDollar" class="form-control" id="dueDollar" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div> --}}
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>{{__('Total:')}} (IQD)</label>
                                    <input type="number" name="totalIraqi" wire:model="totalIraqi" class="form-control" id="totalIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            
                                <div class="mb-3">
                                    {{-- <label>{{__('TAX:')}} (IQD)</label> --}}
                                    <input type="hidden" name="taxIraqi" wire:model="taxIraqi" class="form-control" id="taxIraqi" disabled>
                                    {{-- <small class="text-danger">{{__('(Read Only)')}}</small> --}}
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Discount:')}} (IQD)</label>
                                    <input type="number" name="discountIraqi" wire:model="discountIraqi" class="form-control" id="discountIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                                                            
                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} (IQD)</label>
                                    <input type="number" name="grandTotalIraqi" wire:model="grandTotalIraqi" class="form-control" id="grandTotalIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>

                                {{-- <div class="mb-3">
                                    <label>{{__('First Pay:')}} (IQD)</label>
                                    <input type="number" name="fisrtPayIraqi" wire:model="fisrtPayIraqi" class="form-control" id="fisrtPayIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div> --}}

                                {{-- <div class="mb-3">
                                    <label>{{__('Due:')}} (IQD)</label>
                                    <input type="number" name="dueIraqi" wire:model="dueIraqi" class="form-control" id="dueIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div> --}}
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

    <!-- Update Invoice Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="editInvoiceModal" tabindex="-1" aria-labelledby="editInvoiceModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateInvoice">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editQuotationModal" style="color: #31fbe2">{{__('Update Invoice')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row d-flex justify-content-between m-0 mt-1">
                            <h5 class="mt-4 mb-1"><b>{{__('Invoice Date')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Invoice Created Date')}}</label>
                                    <input type="date" name="formDate" wire:model="formDate" class="form-control" id="formDate">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>                                
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Status')}}</label>
                                    <select wire:model="status" name="status" id="status" class="form-control" required>
                                        <option value="">{{__('Choose Status')}}</option>
                                            <option value="1">{{__('Active')}}</option>
                                            <option value="0">{{__('Non-Active')}}</option>
                                    </select>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Client Information')}}</b></h5>
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addClientDirect">{{__('Add New Client')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Client Name')}}</label>
                                    <select wire:model="select_client_data" wire:change="selectClientStartup" name="select_client_data" id="select_client_data" class="form-control" required>
                                        <option value="">{{__('Choose Client')}}</option>
                                        @if($client_data)
                                        @foreach ($client_data as $c_data)
                                            <option value="{{$c_data->id}}">{{$c_data->client_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            {{-- <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientEmail">{{__('Client Email Address:')}}</label>
                                    <input type="email" name="clientEmail" wire:model="clientEmail" class="form-control" id="clientEmail" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label for="clientCountry">{{__('Country:')}}</label>
                                    <input type="text" name="clientCountry" wire:model="clientCountry" class="form-control" id="clientCountry" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label for="clientCity">{{__('City:')}}</label>
                                    <input type="text" name="clientCity" wire:model="clientCity" class="form-control" id="clientCity" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div> --}}
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientAddress">{{__('Address:')}}</label>
                                    <input type="text" name="clientAddress" wire:model="clientAddress" class="form-control" id="clientAddress" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientPhoneOne">{{__('Primary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneOne" wire:model="clientPhoneOne" class="form-control" id="clientPhoneOne" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientPhoneTwo">{{__('Secondary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneTwo" wire:model="clientPhoneTwo" class="form-control" id="clientPhoneTwo" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Payment Method')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Payment Type')}}</label>
                                    <select wire:model="select_payment_data" wire:change="selectPaymentStartup" name="select_payment_data" id="select_payment_data" class="form-control" required>
                                        <option value="">{{__('Choose Payment Type')}}</option>
                                        @if($payment_data)
                                        @foreach ($payment_data as $p_data)
                                        <option value="{{$p_data->id}}">{{$p_data->payment_type}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Exchange Rate:')}} <small>($1 = ? IQD)</small></label>
                                    <input type="number" name="exchange_rate" wire:model="exchange_rate" class="form-control" id="exchange_rate" wire:change="exchangeUpdate">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="serviceName">{{__('Title:')}}</label>
                            <input type="text" name="description" wire:model="description" class="form-control" id="description">
                            <small class="text-info">{{__('(Read & Write)')}}</small>
                        </div>
                        <div class="row d-flex justify-content-between m-0" style="border-top: 2px dotted #fff; border-bottom: 2px dotted #cc0022">
                            <h5 class="mt-4"><b>{{__('Service Section')}}</b></h5>
                            <button class="btn btn-success mt-3 mb-3" type="button" wire:click="addNewDate">{{__('Add New Date')}}</button>
                        </div>
                        
                        @foreach ($arr_service_by_date as $dateIndex => $services)
                        <div class="mb-3 mt-3">
                            <div class="d-flex justify-content-between">
                                <h3>{{__('Booking No.')}}{{ $dateIndex + 1}}</h3>
                                <button class="btn btn-danger" type="button" wire:click="removeDate('{{ $dateIndex }}')" @if($dateIndex == 0) disabled @endif>{{__('Remove This Date')}}</button>
                            </div>
                            <label for="serviceName">{{__('Short Description:')}}</label>
                            <input type="text" name="arr_service_by_date.{{$dateIndex}}.description" wire:model="arr_service_by_date.{{$dateIndex}}.description" class="form-control" id="arr_service_by_date.{{$dateIndex}}.description" required>
                            <small class="text-info">{{__('(Read & Write)')}}</small>
                        </div>
                        <div class="row" style="border-bottom: 2px dotted #cc0022;">
                            <div class="row d-flex justify-content-between m-0">
                                <div>
                                    <input class="form-control" type="date" name="arr_service_by_date.{{$dateIndex}}.actionDate" wire:model="arr_service_by_date.{{$dateIndex}}.actionDate" id="arr_service_by_date.{{$dateIndex}}.actionDate" required>
                                </div>
                                <div>
                                    <button class="btn btn-info my-3" type="button" wire:click="newRecService('{{ $dateIndex }}')">{{__('New Record Service')}}</button>
                                </div>
                                <table class="table table-dark table-striped table-bordered border-dark align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{__('Code')}}</th>
                                            <th scope="col">{{__('Service')}}</th>
                                            <th scope="col">{{__('Description')}}</th>
                                            <th scope="col">{{__('Unit Price')}}</th>
                                            <th scope="col">{{__('QTY')}}</th>
                                            <th scope="col">{{__('Total')}}</th>
                                            <th scope="col">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
          
                                        @foreach ($services['services'] as $serviceIndex => $a_ser)
                                        <tr>
                                            <td class="align-middle" scope="row">{{ $serviceIndex  + 1 }}</td>
                                            <td class="align-middle" width="90px">
                                                <input type="text" name="serviceCode.{{ $serviceIndex  }}"
                                                    wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex}}.serviceCode"
                                                    class="form-control" id="serviceCode.{{ $serviceIndex  }}" disabled>

                                            </td>
                                            <td class="align-middle" width="200px">
                                                <select
                                                    wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.select_service_data"
                                                    class="form-control"
                                                    wire:change="selectServiceDataChange('{{$dateIndex}}',{{ $serviceIndex  }})"
                                                    required>
                                                    <option value="">{{__('Select Service Type')}}</option>
                                                    @foreach ($service_data as $service)
                                                    <option value="{{ $service->id }}">{{ $service->service_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle">
                                                <input type="text" name="serviceDescription"
                                                    wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceDescription"
                                                    class="form-control" disabled>
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap mb-1">
                                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                                    <input type="number" name="serviceDefaultCostDollar"
                                                        wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceDefaultCostDollar"
                                                        class="form-control"
                                                        wire:change="serviceQtyChange('{{$dateIndex}}',{{ $serviceIndex  }})">
                                                </div>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">IQD</span>
                                                    <input type="number" name="serviceDefaultCostIraqi"
                                                        wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceDefaultCostIraqi"
                                                        class="form-control"
                                                        wire:change="serviceQtyChange('{{$dateIndex}}',{{ $serviceIndex  }})"
                                                        disabled>
                                                </div>
                                            </td>
                                            <td class="align-middle" width="80px">
                                                <input type="number" name="serviceQty"
                                                    wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceQty"
                                                    class="form-control"
                                                    wire:change="serviceQtyChange('{{$dateIndex}}',{{ $serviceIndex  }})">
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap mb-1">
                                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                                    <input type="number" name="serviceTotalDollar"
                                                        wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceTotalDollar"
                                                        class="form-control" disabled>
                                                </div>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">IQD</span>
                                                    <input type="number" name="serviceTotalIraqi"
                                                        wire:model="arr_service_by_date.{{$dateIndex}}.services.{{$serviceIndex }}.serviceTotalIraqi"
                                                        class="form-control" disabled>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-danger"
                                                    wire:click="removeService('{{ $dateIndex }}', {{ $serviceIndex  }})"  @if($serviceIndex == 0) disabled @endif>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach


                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Final Section')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label aria-label="note">{{__('Note')}}</label>
                                <textarea name="note" id="note" rows="18" wire:model="note" style="width: 100%" required></textarea>
                                <small class="text-info">{{__('(Read & Write)')}}</small>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>{{__('Total:')}} ($)</label>
                                    <input type="number" name="totalDollar" wire:model="totalDollar" class="form-control" id="totalDollar" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            
                                <div class="mb-3">
                                    {{-- <label>{{__('TAX:')}} ($)</label> --}}
                                    <input type="hidden" name="taxDollar" wire:model="taxDollar" class="form-control" id="taxDollar" wire:change="calculateTotals">
                                    {{-- <small class="text-info">{{__('(Read & Write)')}}</small> --}}
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Discount:')}} ($)</label>
                                    <input type="number" name="discountDollar" wire:model="discountDollar" class="form-control" id="discountDollar" wire:change="calculateTotals">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                                                            
                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} ($)</label>
                                    <input type="number" name="grandTotalDollar" wire:model="grandTotalDollar" class="form-control" id="grandTotalDollar" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                                
                                {{-- <div class="mb-3">
                                    <label>{{__('First Pay:')}} ($)</label>
                                    <input type="number" name="fisrtPayDollar" wire:model="fisrtPayDollar" class="form-control" id="fisrtPayDollar" wire:change="calculateTotals">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Due:')}} ($)</label>
                                    <input type="number" name="dueDollar" wire:model="dueDollar" class="form-control" id="dueDollar" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div> --}}
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>{{__('Total:')}} (IQD)</label>
                                    <input type="number" name="totalIraqi" wire:model="totalIraqi" class="form-control" id="totalIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            
                                <div class="mb-3">
                                    {{-- <label>{{__('TAX:')}} (IQD)</label> --}}
                                    <input type="hidden" name="taxIraqi" wire:model="taxIraqi" class="form-control" id="taxIraqi" disabled>
                                    {{-- <small class="text-danger">{{__('(Read Only)')}}</small> --}}
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Discount:')}} (IQD)</label>
                                    <input type="number" name="discountIraqi" wire:model="discountIraqi" class="form-control" id="discountIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                                                            
                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} (IQD)</label>
                                    <input type="number" name="grandTotalIraqi" wire:model="grandTotalIraqi" class="form-control" id="grandTotalIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>

                                {{-- <div class="mb-3">
                                    <label>{{__('First Pay:')}} (IQD)</label>
                                    <input type="number" name="fisrtPayIraqi" wire:model="fisrtPayIraqi" class="form-control" id="fisrtPayIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Due:')}} (IQD)</label>
                                    <input type="number" name="dueIraqi" wire:model="dueIraqi" class="form-control" id="dueIraqi" disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div> --}}
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
     <!-- Delete Invoice Modal  -->
    <div wire:ignore.self class="modal fade" id="deleteInvoiceModal" tabindex="-1" aria-labelledby="deleteInvoiceModal"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteInvoiceModal">{{__('Delete Invoice')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyInvoice">
                    <div class="modal-body">
                        <p class="text-danger">{{ __('Are you sure you want to delete this Invoice?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_invoice_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="invoice_name_to_selete" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                            <button type="submit" class="btn btn-danger" wire:disabled="!$confirmDelete || $invoice_name_to_selete !== $del_invoice_name">
                                {{ __('Yes! Delete') }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                                        <label for="address">{{__('Address:')}}</label>
                                        <input type="text" name="address" wire:model="address" class="form-control" id="address">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="city">{{__('City:')}}</label>
                                        <input type="text" name="city" wire:model="city" class="form-control" id="city">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="country">{{__('Country:')}}</label>
                                        <input type="text" name="country" wire:model="country" class="form-control" id="country">
                                    </div>
                                </div>
                            </div> --}}
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
                            {{-- <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="email">{{__('Email Address:')}}</label>
                                        <input type="email" name="email" wire:model="email" class="form-control" id="email">
                                    </div>
                                </div>
                            </div> --}}
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
    </div>
</div>