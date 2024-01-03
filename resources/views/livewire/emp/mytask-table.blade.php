<div>
    <style>
        .card-header {
            padding: 0;
            margin-bottom: 0;
            background-color: #1a0933;
            border-bottom: 3px solid #40167f;
            color: rgb(0, 0, 0);
        }
        .card-body {
            background-color: #1a0933;
        }
    </style>
    <div class="m-4">
        <h2 class="text-lg font-medium mr-auto">
            <b style="color: #31fbe2">{{__('TASKS TABLE')}}</b>
        </h2>
        <div class="row d-flex justify-content-between m-0">
            <div>
                <h2 class="text-lg font-medium mr-auto">
                    <input type="search" wire:model="search" class="form-control" placeholder="Search..."
                        style="width: 250px; border: 1px solid var(--primary)" />
                </h2>
            </div>
            <div>
                <div class="">
                </div>
            </div>
        </div>

        
    
        <div class="accordion" id="accordionExample">
            @foreach ($groupedTasks as $id_index => $group)
            @php
                $taskData = App\Models\EmpTask::find($id_index);
            @endphp
            <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button class="btn btn-info btn-block d-flex justify-content-between" style="color: #000; font-weight: bold" type="button" data-toggle="collapse" data-target="#collapse{{$id_index}}" aria-expanded="true" aria-controls="collapse{{$id_index}}">
                    <div>
                        #INV - {{$taskData->invoice->id}} | {{$taskData->invoice->description}}
                    </div>
                    <div>
                        {{-- @php
                            dd($taskData);
                        @endphp --}}
                        {{$taskData->progress}}% |
                        
                        @if(count($group[0]) == 1)
                        ({{count($group[0])}}) Task
                        @else
                        ({{count($group[0])}}) Tasks
                        @endif
                    </div>
                  </button>
                </h2>
              </div>
          
              <div id="collapse{{$id_index}}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive met-table-panding">
                            <table class="table table-dark table-striped table-bordered border-dark align-middle">

                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Task</th> 
                                    <th scope="col">Start Date</th> 
                                    <th scope="col">End Date</th> 
                                    <th scope="col">Progress</th> 
                                    <th scope="col">Status</th> 
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>

                                    @foreach ($group as $index => $subgroup)
                                    @foreach ($subgroup as $sub_index => $sub_task)
                                    @php
                                        $taskName = App\Models\Task::find($sub_task['task'])->task_option;
                                    @endphp
                    
                                    <tr>
                                        <td class="align-middle text-center" width="30px">{{ $sub_index + 1 }}</td>
                                        <td class="align-middle text-center" width="130px">{{ $taskName }}</td>
                                        <td class="align-middle text-center" width="150px">{{ $sub_task['start_date'] }}</td>
                                        <td class="align-middle text-center" width="150px">{{ $sub_task['end_date'] }}</td>
                                        <td class="align-middle text-center">
                                            <input 
                                            type="range" 
                                            step="5" 
                                            min="0" 
                                            max="100" 
                                            value="progress_.{{ $id_index }}_{{$sub_index}}" 
                                            name="progress_.{{ $id_index }}_{{$sub_index}}" 
                                            wire:model="progress_.{{ $id_index }}_{{$sub_index}}" 
                                            class="form-control p-0" 
                                            required
                                        >
                                        
                                        {{ $progress_[$id_index . '_' . $sub_index] }}%


                                        </td>
                                        <td class="align-middle text-center" width="120px">
                                            @if ($progress_[$id_index . '_' . $sub_index] == 100)
                                               <span class="text-success">{{__('Complete')}}</span>
                                            @elseif ($progress_[$id_index . '_' . $sub_index] > 0)
                                                <span class="text-warning">{{__('In Process')}}</span>
                                            @else    
                                                <span class="text-danger">{{__('Pending')}}</span>
                                            @endif
                                            </td>
                                        <td class="align-middle text-center">
                                            {{-- <button type="button" class="btn btn-success" wire:click="completeTask({{ $index }})"><i class="fas fa-check"></i></button> --}}
                                            <button type="button" class="btn btn-dark" wire:click="updateTask({{ $id_index }}, {{ $sub_index }})"><i class="fas fa-paper-plane"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>

        @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
        @endif


    </div>
{{-- </div> --}}
@if(session()->has('alert'))
@php $alert = session()->get('alert'); @endphp
<script>
    toastr. {
        {
            $alert['type']
        }
    }('{{ $alert['
        message '] }}');

</script>

@endif
</div>
