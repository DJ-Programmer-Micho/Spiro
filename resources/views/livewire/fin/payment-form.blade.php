<div>
    <!-- Insert Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createPaymentModal" tabindex="-1" aria-labelledby="createPaymentModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addPayment">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPaymentModal" style="color: #31fbe2">{{__('Add Payment')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <div class="row mt-5">
                            <h5 class="mb-4"><b>{{__('Type And Status')}}</b></h5>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="paymentType">{{__('Payment Type:')}}</label>
                                        <input type="text" name="paymentType" wire:model="paymentType" class="form-control" id="paymentType" required>
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
    
    
    <div wire:ignore.self class="modal fade overflow-auto" id="updatePaymentModal" tabindex="-1" aria-labelledby="updatePaymentModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updatePayment">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPaymentModal" style="color: #31fbe2">{{__('Add Payment')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <div class="row mt-5">
                            <h5 class="mb-4"><b>{{__('Type And Status')}}</b></h5>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="paymentType">{{__('Payment Type:')}}</label>
                                        <input type="text" name="paymentType" wire:model="paymentType" class="form-control" id="paymentType" required>
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
     
    <div wire:ignore.self class="modal fade" id="deletePaymentModal" tabindex="-1" aria-labelledby="deletePaymentModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFoodModalLabel">{{__('Delete Payment')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyPayment">
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete this Payment?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_payment_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="payment_name_to_selete" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                            <button type="submit" class="btn btn-danger" wire:disabled="!confirmDelete || $paymentToDelete !== $showTextTemp">
                                {{ __('Yes! Delete') }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    </div>
    
    
    