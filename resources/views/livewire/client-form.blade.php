<div>
<!-- Insert Modal  -->
<div wire:ignore.self class="modal fade overflow-auto" id="createClientModal" tabindex="-1" aria-labelledby="createClientModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="addClient">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createClientModal">{{__('Add Client')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                            wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>

                    <div class="row mt-5">
                        <h5 class="mb-4"><b>{{__('Initialize Information')}}</b></h5>
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="companyName">{{__('Comany Name:')}}</label>
                                    <input type="text" name="companyName" wire:model="companyName" class="form-control" id="companyName">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientName">{{__('Client Name:')}}</label>
                                    <input type="text" name="clientName" wire:model="clientName" class="form-control" id="clientName">
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
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="website">{{__('Website:')}}</label>
                                    <input type="url" name="website" wire:model="website" class="form-control" id="website">
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
                                    <label for="country">{{__('Country:')}}</label>
                                    <input type="text" name="country" wire:model="country" class="form-control" id="country">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="city">{{__('City:')}}</label>
                                    <input type="text" name="city" wire:model="city" class="form-control" id="city">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="address">{{__('Address:')}}</label>
                                    <input type="text" name="address" wire:model="address" class="form-control" id="address">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="zipcode">{{__('Zip Code:')}}</label>
                                    <input type="text" name="zipcode" wire:model="zipcode" class="form-control" id="zipcode">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitJs">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade overflow-auto" id="updateClientModal" tabindex="-1" aria-labelledby="updateClientModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="updateClient">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateClientModal">{{__('Edit Client')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                            wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>

                    <div class="row mt-5">
                        <h5 class="mb-4"><b>{{__('Initialize Information')}}</b></h5>
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="companyName">{{__('Comany Name:')}}</label>
                                    <input type="text" name="companyName" wire:model="companyName" class="form-control" id="companyName">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="clientName">{{__('Client Name:')}}</label>
                                    <input type="text" name="clientName" wire:model="clientName" class="form-control" id="clientName">
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
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="website">{{__('Website:')}}</label>
                                    <input type="url" name="website" wire:model="website" class="form-control" id="website">
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
                                    <label for="country">{{__('Country:')}}</label>
                                    <input type="text" name="country" wire:model="country" class="form-control" id="country">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="city">{{__('City:')}}</label>
                                    <input type="text" name="city" wire:model="city" class="form-control" id="city">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="address">{{__('Address:')}}</label>
                                    <input type="text" name="address" wire:model="address" class="form-control" id="address">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="zipcode">{{__('Zip Code:')}}</label>
                                    <input type="text" name="zipcode" wire:model="zipcode" class="form-control" id="zipcode">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitJs">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
 
<div wire:ignore.self class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteFoodModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFoodModalLabel">Delete Company</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyClient">
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this Company?') }}</p>
                    <p>{{ __('Please enter the')}}<strong> "{{$del_client_name}}" </strong>{{__('to confirm:') }}</p>
                    <input type="text" wire:model="client_name_to_selete" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" wire:disabled="!confirmDelete || $foodNameToDelete !== $showTextTemp">
                            {{ __('Yes! Delete') }}
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>


