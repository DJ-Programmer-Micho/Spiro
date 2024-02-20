
<div>
    <!-- Select Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="selectReportModal" tabindex="-1" aria-labelledby="selectReportModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white mx-1 mx-lg-auto">
            <div class="modal-content bg-dark">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectReportModal" style="color: #f31900">{{__('Select Expense Type')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="my-3">
                                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#createContractReportModal" data-dismiss="modal" aria-label="Close" wire:click="prepareContractReport"><b>{{__('Contracts')}}</b></button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="my-3">
                                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#createCashReportModal" data-dismiss="modal" aria-label="Close" wire:click="prepareCashesReport"><b>{{__('Payments')}}</b></button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="my-3">
                                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#createExpenseReportModal" data-dismiss="modal" aria-label="Close" wire:click="prepareExpenseReport"><b>{{__('Expenses')}}</b></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Insert Modal - Bills -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createContractReportModal" tabindex="-1" aria-labelledby="createContractReportModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="contractExport">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createContractReportModal" style="color: #f31900">{{__('Contract Report')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Filter Information')}}<br><small class="text-info">{{__('Optional')}}</small></b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('Start Date:')}}</label>
                                    <input type="date" name="date" wire:model="startDate" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('End Date:')}}</label>
                                    <input type="date" name="date" wire:model="endDate" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Invoice ID')}}</label>
                                    <select wire:model="invoiceId" wire:change="prepareSelectedInvoiceId" name="invoiceId" id="invoiceId" class="form-control" >
                                        <option value="none">{{__('Select The Invoice ID')}}</option>
                                        @if($getInvoiceIds)
                                        @foreach ($getInvoiceIds as $inv_id)
                                            <option value="{{$inv_id}}">#INV-{{$inv_id}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Company Name')}}</label>
                                    <select wire:model="companyName" name="companyName" id="companyName" wire:change="prepareSelectedCompanyName" class="form-control">
                                        <option value="none">{{__('Select The Client Name')}}</option>
                                        @if($getCompanyNames && !empty($getCompanyNames))
                                            @foreach ($getCompanyNames as $company_data)
                                                <option value="{{$company_data['id']}}">{{$company_data['company_name'] ?? 'N/A'}}</option>
                                            @endforeach
                                        @else
                                            <option value="none">{{__('NO COMPANIES DATA FOUND')}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Client Name')}}</label>
                                    <select wire:model="clientName" name="clientName" id="clientName" wire:change="prepareSelectedClientName" class="form-control">
                                        <option value="none">{{__('Select The Client Name')}}</option>
                                
                                        @if($getClientNames && !empty($getClientNames))
                                            @foreach ($getClientNames as $client_data)
                                                <option value="{{$client_data['id']}}">{{$client_data['client_name']}}</option>
                                            @endforeach
                                        @else
                                            <option value="">{{__('NO CLIENTS DATA FOUND')}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Other Options')}}</label>
                                    <select wire:model="option" name="option" id="option" class="form-control">
                                        <option value="0">{{__('Options')}}</option>
                                        <option value="0">{{__('No Due & Due')}}</option>
                                        <option value="1">{{__('No Due')}}</option>
                                        <option value="2">{{__('Due')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Export')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade overflow-auto" id="createExpenseReportModal" tabindex="-1" aria-labelledby="createExpenseReportModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="expenseExport">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createExpenseReportModal" style="color: #f31900">{{__('Expense Report')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Filter Information')}}<br><small class="text-info">{{__('Optional')}}</small></b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('Start Date:')}}</label>
                                    <input type="date" name="date" wire:model="startDate" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('End Date:')}}</label>
                                    <input type="date" name="date" wire:model="endDate" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Other Options')}}</label>
                                    <select wire:model="option" name="option" id="option" class="form-control">
                                        <option value="none">{{__('Options')}}</option>
                                        <option value="0">{{__('Bill')}}</option>
                                        <option value="1">{{__('Salary')}}</option>
                                        <option value="2">{{__('Other')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Export')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade overflow-auto" id="createCashReportModal" tabindex="-1" aria-labelledby="createCashReportModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="cashExport">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCashReportModal" style="color: #f31900">{{__('Cash Report')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Filter Information')}}<br><small class="text-info">{{__('Optional')}}</small></b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('Start Date:')}}</label>
                                    <input type="date" name="date" wire:model="startDate" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="date">{{__('End Date:')}}</label>
                                    <input type="date" name="date" wire:model="endDate" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Invoice ID')}}</label>
                                    <select wire:model="cashId" wire:change="prepareSelectedCashId" name="cashId" id="cashId" class="form-control" >
                                        <option value="none">{{__('Select The CASH ID')}}</option>
                                        @if($getCashIds)
                                        @foreach ($getCashIds as $cash_id)
                                            <option value="{{$cash_id}}">#CR-{{$cash_id}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Company Name')}}</label>
                                    <select wire:model="companyName" name="companyName" id="companyName" wire:change="prepareSelectedCashCompanyName" class="form-control">
                                        <option value="none">{{__('Select The Client Name')}}</option>
                                        @if($getCompanyNames && !empty($getCompanyNames))
                                            @foreach ($getCompanyNames as $company_data)
                                                <option value="{{$company_data['id']}}">{{$company_data['company_name'] ?? 'N/A'}}</option>
                                            @endforeach
                                        @else
                                            <option value="none">{{__('NO COMPANIES DATA FOUND')}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Client Name')}}</label>
                                    <select wire:model="clientName" name="clientName" id="clientName" wire:change="prepareSelectedCashClientName" class="form-control">
                                        <option value="none">{{__('Select The Client Name')}}</option>
                                
                                        @if($getClientNames && !empty($getClientNames))
                                            @foreach ($getClientNames as $client_data)
                                                <option value="{{$client_data['id']}}">{{$client_data['client_name']}}</option>
                                            @endforeach
                                        @else
                                            <option value="">{{__('NO CLIENTS DATA FOUND')}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Other Options')}}</label>
                                    <select wire:model="option" name="option" id="option" class="form-control">
                                        <option value="0">{{__('Options')}}</option>
                                        <option value="0">{{__('No Due & Due')}}</option>
                                        <option value="1">{{__('No Due')}}</option>
                                        <option value="2">{{__('Due')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Export')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- 
    <!-- Insert Modal - Employee -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createEmployeeModal" tabindex="-1" aria-labelledby="createEmployeeModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addEmpExpense">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createEmployeeModal" style="color: #f31900">{{__('Add Employee Salary')}}</h5>
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
                            <h5 class="modal-title" id="createExpenseBillModal" style="color: #f31900">{{__('Add Bill Expense')}}</h5>
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
                            <h5 class="modal-title" id="editExpenseModal" style="color: #f31900">{{__('Update Expense')}}</h5>
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
                        <p class="text-danger">{{ __('Are you sure you want to delete this Expense?') }}</p>
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