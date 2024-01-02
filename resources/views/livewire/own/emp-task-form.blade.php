
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
    <div wire:ignore.self class="modal fade overflow-auto" id="newEmpTaskModal" tabindex="-1" aria-labelledby="newEmpTaskModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newEmpTaskModal" style="color: #31fbe2">{{__('Select Invoice')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Choose The Invoice')}}</b></h5>
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
                        <button type="button" class="btn btn-success submitJs" data-toggle="modal" data-target="#createTaskModal" data-dismiss="modal" aria-label="Close" wire:click="selectDataInvoice">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Insert Cash Modal -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addTask">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createTaskModal" style="color: #31fbe2">{{__('Add New Task')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row m-0">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Invoice Information')}}</b>
                                <small class="text-danger">{{__('(Read Only)')}}</small>
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label>{{__('Invoice Date')}}</label>
                                    <input type="date" name="invoiceDate" wire:model="invoiceDate" class="form-control"
                                        id="invoiceDate" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label for="invoiceTitle">{{__('Invoice Title:')}}</label>
                                    <input type="text" name="invoiceTitle" wire:model="invoiceTitle"
                                        class="form-control" id="invoiceTitle" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label for="clientName">{{__('Client Name:')}}</label>
                                    <input type="text" name="clientName" wire:model="clientName" class="form-control"
                                        id="clientName" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Tasks Section')}}</b></h5>
                            <div>
                                <button class="btn btn-info" type="button" wire:click="newRecTask">{{__('New Task')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive met-table-panding">
                                <table class="table table-dark table-striped table-bordered border-dark align-middle">

                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Employee</th> 
                                        <th scope="col">Task</th> 
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Progress</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($arr_tasks as $index => $task)
                                        <tr>
                                            <td class="align-middle" scope="row">{{$index + 1}}</td>
                                            <td class="align-middle">
                                                <select
                                                wire:model="arr_tasks.{{$index}}.name"
                                                class="form-control"
                                                required>
                                                <option value="">{{__('Select Employee')}}</option>
                                                @foreach ($user_data as $user_d)
                                                <option value="{{ $user_d->id }}">{{ $user_d->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            </td>
                                            <td class="align-middle">
                                                <select
                                                wire:model="arr_tasks.{{$index}}.task"
                                                class="form-control"
                                                required>
                                                <option value="">{{__('Select Task')}}</option>
                                                @foreach ($task_data as $task)
                                                <option value="{{ $task->id }}">{{ $task->task_option }}
                                                </option>
                                                @endforeach
                                            </select>
                                            </td>
                                            <td class="align-middle" width="90px">
                                                <input type="date" name="arr_tasks.{{ $index }}.start_date" wire:model="arr_tasks.{{ $index }}.start_date" class="form-control" id="arr_tasks.{{ $index }}.start_date" required>
                                            </td>
                                       
                                            <td class="align-middle" width="90px">
                                                <input type="date" name="arr_tasks.{{ $index }}.end_date" wire:model="arr_tasks.{{ $index }}.end_date" class="form-control" id="arr_tasks.{{ $index }}.end_date" required>
                                            </td>

                                            <td class="align-middle" width="90px">
                                                <input type="progress" name="arr_tasks.{{ $index }}.progress" wire:model="arr_tasks.{{ $index }}.progress" class="form-control" id="arr_tasks.{{ $index }}.progress" wire:change="enterManualeProgress" required>
                                            </td>
                                       
          
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-danger" wire:click="removeTask({{ $index }})"><i class="fas fa-trash-alt"></i></button>
                                            </td>                                       
                                        </tr>
                                      @endforeach
                                    </tbody>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </table>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Invoice Total Progress')}}</b>
                            </h5>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{$gProgress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$gProgress}}%"></div>
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
    <div wire:ignore.self class="modal fade overflow-auto" id="updateTaskModal" tabindex="-1" aria-labelledby="updateTaskModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateTask">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createTaskModal" style="color: #31fbe2">{{__('Update Task')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row m-0">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Invoice Information')}}</b>
                                <small class="text-danger">{{__('(Read Only)')}}</small>
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label>{{__('Invoice Date')}}</label>
                                    <input type="date" name="invoiceDate" wire:model="invoiceDate" class="form-control"
                                        id="invoiceDate" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label for="invoiceTitle">{{__('Invoice Title:')}}</label>
                                    <input type="text" name="invoiceTitle" wire:model="invoiceTitle"
                                        class="form-control" id="invoiceTitle" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-1">
                                    <label for="clientName">{{__('Client Name:')}}</label>
                                    <input type="text" name="clientName" wire:model="clientName" class="form-control"
                                        id="clientName" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1"><b>{{__('Tasks Section')}}</b></h5>
                            <div>
                                <button class="btn btn-info" type="button" wire:click="newRecTask">{{__('New Task')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive met-table-panding">
                                <table class="table table-dark table-striped table-bordered border-dark align-middle">

                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Employee</th> 
                                        <th scope="col">Task</th> 
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Progress</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($arr_tasks as $index => $task)
                                        <tr>
                                            <td class="align-middle" scope="row">{{$index + 1}}</td>
                                            <td class="align-middle">
                                                <select
                                                wire:model="arr_tasks.{{$index}}.name"
                                                class="form-control"
                                                required>
                                                <option value="">{{__('Select Employee')}}</option>
                                                @foreach ($user_data as $user_d)
                                                <option value="{{ $user_d->id }}">{{ $user_d->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            </td>
                                            <td class="align-middle">
                                                <select
                                                wire:model="arr_tasks.{{$index}}.task"
                                                class="form-control"
                                                required>
                                                <option value="">{{__('Select Task')}}</option>
                                                @foreach ($task_data as $task)
                                                <option value="{{ $task->id }}">{{ $task->task_option }}
                                                </option>
                                                @endforeach
                                            </select>
                                            </td>
                                            <td class="align-middle" width="90px">
                                                <input type="date" name="arr_tasks.{{ $index }}.start_date" wire:model="arr_tasks.{{ $index }}.start_date" class="form-control" id="arr_tasks.{{ $index }}.start_date" required>
                                            </td>
                                       
                                            <td class="align-middle" width="90px">
                                                <input type="date" name="arr_tasks.{{ $index }}.end_date" wire:model="arr_tasks.{{ $index }}.end_date" class="form-control" id="arr_tasks.{{ $index }}.end_date" required>
                                            </td>

                                            <td class="align-middle" width="90px">
                                                <input type="progress" name="arr_tasks.{{ $index }}.progress" wire:model="arr_tasks.{{ $index }}.progress" class="form-control" id="arr_tasks.{{ $index }}.progress" wire:change="enterManualeProgress" required>
                                            </td>
                                       
          
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-danger" wire:click="removeTask({{ $index }})"><i class="fas fa-trash-alt"></i></button>
                                            </td>                                       
                                        </tr>
                                      @endforeach
                                    </tbody>
                                    <small class="text-info">{{__('(Read & Write)')}}</small>
                                </table>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between m-0">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Invoice Total Progress')}}</b>
                            </h5>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{$gProgress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$gProgress}}%"></div>
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
    <div wire:ignore.self class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModal"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTaskModal">{{__('Delete Task')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyTask">
                    <div class="modal-body">
                        <p class="text-danger">{{ __('Are you sure you want to delete this Company?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_task_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="task_name_to_selete" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                            <button type="submit" class="btn btn-danger" wire:disabled="!$confirmDelete || $task_name_to_selete !== $del_task_name">
                                {{ __('Yes! Delete') }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
</div>