
<div>
<!-- Image Crop -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.js"></script>
{{-- inline style for modal --}}
<style>
    .image_area { position: relative; }
    img { display: block; max-width: 100%; }
    .preview { overflow: hidden; width: 160px;  height: 160px; margin: 10px; border: 1px solid red;}
    .modal-lg{max-width: 1000px !important;}
    .overlay { position: absolute; bottom: 10px; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5); overflow: hidden; height: 0; transition: .5s ease; width: 100%;}
    .image_area:hover .overlay { height: 50%; cursor: pointer; }
    .text { color: #333; font-size: 20px; position: absolute; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%); text-align: center;}
    .switch input { display:none; }
    .switch { display:inline-block; width:60px; height:20px; margin:8px; position:relative; }
    .slider { position:absolute; top:0; bottom:0; left:0; right:0; border-radius:30px; box-shadow:0 0 0 2px #cc0022, 0 0 4px #cc0022; cursor:pointer; border:4px solid transparent; overflow:hidden; transition:.4s; }
    .slider:before { position:absolute; content:""; width:100%; height:100%; background:#cc0022; border-radius:30px; transform:translateX(-30px); transition:.4s; }
    input:checked + .slider:before { transform:translateX(30px); background:limeGreen; }
    input:checked + .slider { box-shadow:0 0 0 2px limeGreen,0 0 2px limeGreen; }
</style>

    <!-- Insert Modal - Bills -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createQuotationModal" tabindex="-1" aria-labelledby="createQuotationModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addQuotation">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createQuotationModal" style="color: #31fbe2">{{__('Add New Quotation')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row d-flex justify-content-between m-0 mt-1">
                            <h5 class="mt-4 mb-1"><b>{{__('Quotation Date')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Quotation Created Date')}}</label>
                                    <input type="date" name="formDate" wire:model="formDate" class="form-control" id="formDate">
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
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Quotation State')}}</label>
                                    <input type="text" name="quotation_status" wire:model="quotation_status" class="form-control" id="quotation_status" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Client Information')}}</b></h5>
                            <div>
                                <button class="btn btn-info" data-toggle="modal" data-target="#addClientDirect">{{__('Add New Client')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Bill Name')}}</label>
                                    <select wire:model="select_client_data" wire:change="selectClientStartup" name="select_client_data" id="select_client_data" class="form-control" required>
                                        <option value="">{{__('Choose The Default Bill')}}</option>
                                        @if($client_data)
                                        @foreach ($client_data as $c_data)
                                            <option value="{{$c_data->id}}">{{$c_data->client_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientEmail">{{__('Client Email Address:')}}</label>
                                    <input type="email" name="clientEmail" wire:model="clientEmail" class="form-control" id="clientEmail" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label for="clientCountry">{{__('Country:')}}</label>
                                    <input type="text" name="clientCountry" wire:model="clientCountry" class="form-control" id="clientCountry" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label for="clientCity">{{__('City:')}}</label>
                                    <input type="text" name="clientCity" wire:model="clientCity" class="form-control" id="clientCity" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label for="clientAddress">{{__('Address:')}}</label>
                                    <input type="text" name="clientAddress" wire:model="clientAddress" class="form-control" id="clientAddress" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientPhoneOne">{{__('Primary Phone:')}}</label>
                                    <input type="tel" name="clientPhoneOne" wire:model="clientPhoneOne" class="form-control" id="clientPhoneOne" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientPhoneTwo">{{__('Secondary:')}}</label>
                                    <input type="tel" name="clientPhoneTwo" wire:model="clientPhoneTwo" class="form-control" id="clientPhoneTwo" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Payment Method')}}</b></h5>
                            <div>
                                <button class="btn btn-info" data-toggle="modal" data-target="#addPaymentDirect">{{__('Add New Method')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Payment Type')}}</label>
                                    <select wire:model="select_payment_data" wire:change="selectPaymentStartup" name="select_payment_data" id="select_payment_data" class="form-control" required>
                                        <option value="">{{__('Choose The Default Bill')}}</option>
                                        @if($payment_data)
                                        @foreach ($payment_data as $p_data)
                                        <option value="{{$p_data->id}}">{{$p_data->payment_type}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Exchange Rate:')}} <small>(it's a preview)</small></label>
                                    <input type="number" name="exchange_rate" wire:model="exchange_rate" class="form-control" id="exchange_rate">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Service Section')}}</b></h5>
                            <div>
                                <button class="btn btn-info" type="button" wire:click="newRecService">{{__('New Record Service')}}</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="serviceName">{{__('Short Description:')}}</label>
                            <input type="text" name="description" wire:model="description" class="form-control" id="description">
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive met-table-panding">
                                <table class="table table-dark table-striped table-bordered border-dark align-middle">
                                    <thead>
                                      <tr>
                                        {{-- <th scope="col"><input type="checkbox" name="" id=""></th> --}}
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th> 
                                        <th scope="col">Service</th> 
                                        <th scope="col">Description</th>
                                        <th scope="col">Unit Price</th>
                                        {{-- @if($this->showTextarea)
                                        <th scope="col">Unit Price ($)</th>
                                        @else
                                        <th scope="col">Unit Price (IQD)</th>
                                        @endif --}}
                                        <th scope="col">QTY</th>
                                        <th scope="col">Total</th>
                                        {{-- @if($this->showTextarea)
                                        <th scope="col">Total ($)</th>
                                        @else
                                        <th scope="col">Total (IQD)</th>
                                        @endif --}}
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    {{-- @php
                                        dd($arr_service);
                                    @endphp --}}
                                    {{-- <div class="col-12 d-flex justify-content-center align-items-center">
                                        {{__('IQD')}}
                                        <label class="switch">
                                            <input type="checkbox" wire:model="showTextarea" id="customSwitch1" wire:click="updateAllDefaultCosts">
                                            <span class="slider"></span>
                                        </label>
                                        {{__('$')}}
                                    </div> --}}
                                        @foreach ($arr_service as $index => $a_ser)
                                        <tr>
                                            <td class="align-middle" scope="row">{{$index + 1}}</td>
                                            <td class="align-middle" width="90px"><input type="text" name="serviceCode.{{ $index }}" wire:model="arr_service.{{ $index }}.serviceCode" class="form-control" id="serviceCode.{{ $index }}"></td>
                                            <td class="align-middle" width="200px">
                                                 <select wire:model="arr_service.{{ $index }}.select_service_data" class="form-control" wire:change="selectServiceDataChange({{ $index }})">
                                                    <option value="">{{__('Select Service Type')}}</option>
                                                    @foreach ($service_data as $service)
                                                        <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle">
                                                <input type="text" name="serviceDescription" wire:model="arr_service.{{ $index }}.serviceDescription" class="form-control">
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap mb-1">
                                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                                    <input type="number" name="serviceDefaultCostDollar" wire:model="arr_service.{{ $index }}.serviceDefaultCostDollar" class="form-control" wire:change="serviceQtyChange({{ $index }})">
                                                </div>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">IQD</span>
                                                    <input type="number" name="serviceDefaultCostIraqi" wire:model="arr_service.{{ $index }}.serviceDefaultCostIraqi" class="form-control" wire:change="serviceQtyChange({{ $index }})">
                                                </div>
                                            </td>
                                            <td class="align-middle" width="80px">
                                                <input type="number" name="serviceQty" wire:model="arr_service.{{ $index }}.serviceQty" class="form-control" wire:change="serviceQtyChange({{ $index }})">
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group flex-nowrap mb-1">
                                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                                    <input type="number" name="serviceTotalDollar" wire:model="arr_service.{{ $index }}.serviceTotalDollar" class="form-control" disabled>
                                                </div>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">IQD</span>
                                                    <input type="number" name="serviceTotalIraqi" wire:model="arr_service.{{ $index }}.serviceTotalIraqi" class="form-control" disabled>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-danger" wire:click="removeService({{ $index }})"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                            {{-- <td><button type="button" class="btn btn-danger" wire:click="#"><i class="fas fa-trash-alt"></i></button></td> --}}
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>

                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Final Section')}}</b></h5>
                            {{-- <div>
                                <button class="btn btn-info" data-toggle="modal" data-target="#addPaymentDirect">{{__('Add New Method')}}</button>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                @for ($i = 1; $i <= 5; $i++)
                                <div class="mb-3">
                                    <label>{{__('Note No.')}}{{$i}}</label>
                                    <input type="text" name="note" wire:model="note.{{$i}}" class="form-control" id="note.{{$i}}">
                                </div>
                                @endfor
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>{{__('Total:')}} ($)</label>
                                    <input type="number" name="totalDollar" wire:model="totalDollar" class="form-control" id="totalDollar" disabled>
                                </div>
                            
                                <div class="mb-3">
                                    <label>{{__('TAX:')}} ($)</label>
                                    <input type="number" name="taxDollar" wire:model="taxDollar" class="form-control" id="taxDollar" wire:change="calculateTotals">
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Discount:')}} ($)</label>
                                    <input type="number" name="discountDollar" wire:model="discountDollar" class="form-control" id="discountDollar" wire:change="calculateTotals">
                                </div>
                            
                                <div class="mb-3">
                                    <label>{{__('First Pay:')}} ($)</label>
                                    <input type="number" name="fisrtPayDollar" wire:model="fisrtPayDollar" class="form-control" id="fisrtPayDollar" wire:change="calculateTotals">
                                </div>
                            
                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} ($)</label>
                                    <input type="number" name="grandTotalDollar" wire:model="grandTotalDollar" class="form-control" id="grandTotalDollar" disabled>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Due:')}} ($)</label>
                                    <input type="number" name="dueDollar" wire:model="dueDollar" class="form-control" id="dueDollar" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>{{__('Total:')}} (IQD)</label>
                                    <input type="number" name="totalIraqi" wire:model="totalIraqi" class="form-control" id="totalIraqi" disabled>
                                </div>
                            
                                <div class="mb-3">
                                    <label>{{__('TAX:')}} (IQD)</label>
                                    <input type="number" name="taxIraqi" wire:model="taxIraqi" class="form-control" id="taxIraqi" wire:change="calculateTotals">
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Discount:')}} (IQD)</label>
                                    <input type="number" name="discountIraqi" wire:model="discountIraqi" class="form-control" id="discountIraqi" wire:change="calculateTotals">
                                </div>
                            
                                <div class="mb-3">
                                    <label>{{__('First Pay:')}} (IQD)</label>
                                    <input type="number" name="fisrtPayIraqi" wire:model="fisrtPayIraqi" class="form-control" id="fisrtPayIraqi" wire:change="calculateTotals">
                                </div>
                            
                                <div class="mb-3">
                                    <label>{{__('Grand Total:')}} (IQD)</label>
                                    <input type="number" name="grandTotalIraqi" wire:model="grandTotalIraqi" class="form-control" id="grandTotalIraqi" disabled>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Due:')}} (IQD)</label>
                                    <input type="number" name="dueIraqi" wire:model="dueIraqi" class="form-control" id="dueIraqi" disabled>
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

    {{-- <!-- Insert Modal - Employee -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createEmployeeModal" tabindex="-1" aria-labelledby="createEmployeeModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addEmpExpense">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createEmployeeModal" style="color: #31fbe2">{{__('Add Employee Salary')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Employee Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('User')}}</label>
                                    <select wire:model="select_user_data" wire:change="selectExpenseEmpModalStartup" name="select_user_data" id="select_user_data" class="form-control" required>
                                        <option value="">{{__('Choose The Default Bill')}}</option>
                                        @if($user_data)
                                        @foreach ($user_data as $u_data)
                                            <option value="{{$u_data->id}}">{{$u_data->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="cost_dollar">{{__('Cost in ($):')}}</label>
                                        <input type="number" name="cost_dollar" wire:model="cost_dollar" class="form-control" id="cost_dollar" required>
                                    </div>
                                </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="cost_iraqi">{{__('Cost in (IQD):')}}</label>
                                    <input type="number" name="cost_iraqi" wire:model="cost_iraqi" class="form-control" id="cost_iraqi" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('Date:')}}</label>
                                    <input type="date" name="date" wire:model="billDate" class="form-control" id="date" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="description">{{__('Description:')}}</label>
                                <div class="col-12">
                                    <textarea name="description" id="description"  wire:model="description" rows="3" class="w-100"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                            <label>{{__('Status')}}</label>
                            <select wire:model="status" name="status" id="status" class="form-control" required>
                                <option value="">{{__('Choose Status')}}</option>
                                    <option value="1">{{__('Active')}}</option>
                                    <option value="0">{{__('Non Active')}}</option>
                            </select>
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

    <!-- Insert Modal - Other -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createExpenseOtherModal" tabindex="-1" aria-labelledby="createExpenseOtherModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addOtherExpense">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createExpenseBillModal" style="color: #31fbe2">{{__('Add Bill Expense')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Bill Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="expenseOtherName">{{__('Expense Name:')}}</label>
                                    <input type="text" name="expenseOtherName" wire:model="expenseOtherName" class="form-control" id="expenseOtherName" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('Date:')}}</label>
                                    <input type="date" name="date" wire:model="billDate" class="form-control" id="date" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="cost_dollar">{{__('Cost in ($):')}}</label>
                                    <input type="number" name="cost_dollar" wire:model="cost_dollar" class="form-control" id="cost_dollar" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="cost_iraqi">{{__('Cost in (IQD):')}}</label>
                                    <input type="number" name="cost_iraqi" wire:model="cost_iraqi" class="form-control" id="cost_iraqi" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="description">{{__('Description:')}}</label>
                                <div class="col-12">
                                    <textarea name="description" id="description"  wire:model="description" rows="3" class="w-100"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                            <label>{{__('Status')}}</label>
                            <select wire:model="status" name="status" id="status" class="form-control" required>
                                <option value="">{{__('Choose Status')}}</option>
                                    <option value="1">{{__('Active')}}</option>
                                    <option value="0">{{__('Non Active')}}</option>
                            </select>
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

    <!-- Update Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateExpenseBillModalStartup">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editExpenseModal" style="color: #31fbe2">{{__('Update Expense')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Bill Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="gName">{{__('Expense Name:')}}</label>
                                    <input type="text" name="gName" wire:model="gName" class="form-control" id="gName" required disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('Date:')}}</label>
                                    <input type="date" name="date" wire:model="billDate" class="form-control" id="date" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="cost_dollar">{{__('Cost in ($):')}}</label>
                                    <input type="number" name="cost_dollar" wire:model="cost_dollar" class="form-control" id="cost_dollar" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="cost_iraqi">{{__('Cost in (IQD):')}}</label>
                                    <input type="number" name="cost_iraqi" wire:model="cost_iraqi" class="form-control" id="cost_iraqi" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="description">{{__('Description:')}}</label>
                                <div class="col-12">
                                    <textarea name="description" id="description"  wire:model="description" rows="3" class="w-100"></textarea>
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
     
    <div wire:ignore.self class="modal fade" id="deleteExpenseModal" tabindex="-1" aria-labelledby="deleteExpenseModal"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteExpenseModal">{{__('Delete Expense')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyExpense">
                    <div class="modal-body">
                        <p class="text-danger">{{ __('Are you sure you want to delete this Company?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_expense_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="expense_name_to_selete" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                            <button type="submit" class="btn btn-danger" wire:disabled="!$confirmDelete || $expense_name_to_selete !== $del_expense_name">
                                {{ __('Yes! Delete') }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

</div>