
<div>
    <!-- Insert Attend Modal -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createAttendModal" tabindex="-1" aria-labelledby="createAttendModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addAttend">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAttendModal" style="color: #31fbe2">{{__('Add New Attend')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row d-flex justify-content-start m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Employee Information')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Employee Name:')}}</label>
                                    <select wire:model="select_emp_data" wire:change="selectEmpStartup" name="select_emp_data" id="select_emp_data" class="form-control" required>
                                        <option value="">{{__('Choose Client')}}</option>
                                        @if($emp_data)
                                        @foreach ($emp_data as $c_data)
                                            <option value="{{$c_data->id}}">{{$c_data->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="jobTitle">{{__('Job Title:')}}</label>
                                    <input type="text" name="jobTitle" wire:model="jobTitle" class="form-control" id="jobTitle" required disabled>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Time Entry')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Start Time:')}}</label>
                                    <input type="time" name="startTime" wire:model="startTime" class="form-control" id="startTime" wire:change="timeCalculate" required>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('End Time:')}}</label>
                                    <input type="time" name="endTime" wire:model="endTime" class="form-control" id="endTime" wire:change="timeCalculate">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Date:')}}</label>
                                    <input type="date" name="dateAttend" wire:model="dateAttend" class="form-control" id="dateAttend" required>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Duration (hr):')}}</label>
                                    <input type="text" name="duration" wire:model="duration" class="form-control" id="duration">
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
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


    <div wire:ignore.self class="modal fade overflow-auto" id="editAttendModal" tabindex="-1" aria-labelledby="editAttendModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateAttend">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAttendModal" style="color: #31fbe2">{{__('Add New Attend')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row d-flex justify-content-start m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Employee Information')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Employee Name:')}}</label>
                                    <select wire:model="select_emp_data" wire:change="selectEmpStartup" name="select_emp_data" id="select_emp_data" class="form-control" required>
                                        <option value="">{{__('Choose Client')}}</option>
                                        @if($emp_data)
                                        @foreach ($emp_data as $c_data)
                                            <option value="{{$c_data->id}}">{{$c_data->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="jobTitle">{{__('Job Title:')}}</label>
                                    <input type="text" name="jobTitle" wire:model="jobTitle" class="form-control" id="jobTitle" disabled required>
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Time Entry')}}</b></h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Start Time:')}}</label>
                                    <input type="time" name="startTime" wire:model="startTime" class="form-control" id="startTime" wire:change="timeCalculate" required>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('End Time:')}}</label>
                                    <input type="time" name="endTime" wire:model="endTime" class="form-control" id="endTime" wire:change="timeCalculate">
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Date:')}}</label>
                                    <input type="date" name="dateAttend" wire:model="dateAttend" class="form-control" id="dateAttend" required>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Duration (hr):')}}</label>
                                    <input type="text" name="duration" wire:model="duration" class="form-control" id="duration">
                                    <small class="text-danger">{{__('(Read Only)')}}</small>
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

    <div wire:ignore.self class="modal fade" id="deleteAttendModal" tabindex="-1" aria-labelledby="deleteAttendModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFoodModalLabel">{{__('Delete Attend')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyAttend">
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete this Attend?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_attend_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="attend_name_to_selete" class="form-control">
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