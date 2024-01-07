<div>
    <!-- Insert Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createServiceModal" tabindex="-1" aria-labelledby="createServiceModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addService">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createClientModal" style="color: #31fbe2">{{__('Add Service')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <div class="row mt-5">
                            <h5 class="mb-4"><b>{{__('Initialize Information')}}</b></h5>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="serviceCode">{{__('Service Code:')}}</label>
                                        <input type="text" name="serviceCode" wire:model="serviceCode" class="form-control" id="serviceCode" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="serviceName">{{__('Service Name:')}}</label>
                                        <input type="text" name="serviceName" wire:model="serviceName" class="form-control" id="serviceName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12">
                                    <label for="serviceDescription">{{__('Description:')}}</label>
                                    <div class="col-12">
                                        <textarea name="serviceDescription" id="serviceDescription"  wire:model="serviceDescription" rows="3" class="w-100"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <h5 class="mb-4"><b>{{__('Secondary Information')}}</b></h5>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="priceDollar">{{__('Default Price in ($):')}}</label>
                                        <input type="number" name="priceDollar" wire:model="priceDollar" class="form-control" id="priceDollar" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="priceIraqi">{{__('Default Price in (IQD)')}}</label>
                                        <input type="number" name="priceIraqi" wire:model="priceIraqi" class="form-control" id="priceIraqi" required>
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
    
    
    <div wire:ignore.self class="modal fade overflow-auto" id="updateServiceModal" tabindex="-1" aria-labelledby="updateServiceModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateService">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createServiceModal" style="color: #31fbe2">{{__('Edit Service')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <div class="row mt-5">
                            <h5 class="mb-4"><b>{{__('Initialize Information')}}</b></h5>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="serviceCode">{{__('Service Code:')}}</label>
                                        <input type="text" name="serviceCode" wire:model="serviceCode" class="form-control" id="serviceCode" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="serviceName">{{__('Service Name:')}}</label>
                                        <input type="text" name="serviceName" wire:model="serviceName" class="form-control" id="serviceName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12">
                                    <label for="serviceDescription">{{__('Description:')}}</label>
                                    <div class="col-12">
                                        <textarea name="serviceDescription" id="serviceDescription"  wire:model="serviceDescription" rows="3" class="w-100"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <h5 class="mb-4"><b>{{__('Secondary Information')}}</b></h5>
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="priceDollar">{{__('Default Price in ($):')}}</label>
                                        <input type="number" name="priceDollar" wire:model="priceDollar" class="form-control" id="priceDollar" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="priceIraqi">{{__('Default Price in (IQD)')}}</label>
                                        <input type="number" name="priceIraqi" wire:model="priceIraqi" class="form-control" id="priceIraqi" required>
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

    <div wire:ignore.self class="modal fade" id="deleteServiceModal" tabindex="-1" aria-labelledby="deleteServiceModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFoodModalLabel">{{__('Delete Service')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyService">
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this Service?') }}</p>
                    <p>{{ __('Please enter the')}}<strong> "{{$del_service_name}}" </strong>{{__('to confirm:') }}</p>
                    <input type="text" wire:model="service_name_to_selete" class="form-control">
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