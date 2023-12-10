<div>
    <!-- Insert Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createBillModal" tabindex="-1" aria-labelledby="createBillModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addBill">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createExpenseBillModal" style="color: #31fbe2">{{__('Add New Bill')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Bill Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="billName">{{__('Bill Name:')}}</label>
                                    <input type="text" name="billName" wire:model="billName" class="form-control" id="billName" required>
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
                                    <label>{{__('Status')}}</label>
                                    <select wire:model="status" name="status" id="status" class="form-control" required>
                                        <option value="">{{__('Choose Status')}}</option>
                                            <option value="1">{{__('Active')}}</option>
                                            <option value="0">{{__('Non-Active')}}</option>
                                    </select>
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
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Update Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="updateBillModal" tabindex="-1" aria-labelledby="updateBillModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateBill">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createExpenseBillModal" style="color: #31fbe2">{{__('Update Bill')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Bill Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="billName">{{__('Bill Name:')}}</label>
                                    <input type="text" name="billName" wire:model="billName" class="form-control" id="billName" required>
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
                                    <label>{{__('Status')}}</label>
                                    <select wire:model="status" name="status" id="status" class="form-control" required>
                                        <option value="">{{__('Choose Status')}}</option>
                                            <option value="1">{{__('Active')}}</option>
                                            <option value="0">{{__('Non-Active')}}</option>
                                    </select>
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
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     
    <div wire:ignore.self class="modal fade" id="deleteBillModal" tabindex="-1" aria-labelledby="deleteBillModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFoodModalLabel">{{__('Delete Bill')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyBill">
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete this Bill?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_bill_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="bill_name_to_selete" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                            <button type="submit" class="btn btn-danger" wire:disabled="!confirmDelete || $foodNameToDelete !== $showTextTemp">
                                {{ __('Yes! Delete') }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    </div>
    
    
    