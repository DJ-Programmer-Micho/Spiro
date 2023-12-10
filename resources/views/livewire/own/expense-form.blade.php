
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

    <!-- Select Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="selectExpenseModal" tabindex="-1" aria-labelledby="selectExpenseModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white mx-1 mx-lg-auto">
            <div class="modal-content bg-dark">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectExpenseModal" style="color: #31fbe2">{{__('Select Expense Type')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="my-3">
                                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#createExpenseBillModal" data-dismiss="modal" aria-label="Close" wire:click="addExpenseBillModalStartup"><b>{{__('Bills')}}</b></button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="my-3">
                                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#createEmployeeModal" data-dismiss="modal" aria-label="Close" wire:click="addExpenseEmpModalStartup"><b>{{__('Employess')}}</b></button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="my-3">
                                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#createExpenseOtherModal" data-dismiss="modal" aria-label="Close" wire:click="selectExpenseOthModalStartup"><b>{{__('Other')}}</b></button>
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
    <div wire:ignore.self class="modal fade overflow-auto" id="createExpenseBillModal" tabindex="-1" aria-labelledby="createExpenseBillModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addBillExpense">
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
                                    <label>{{__('Bill Name')}}</label>
                                    <select wire:model="select_bill_data" wire:change="selectExpenseBillModalStartup" name="select_bill_data" id="select_bill_data" class="form-control" required>
                                        <option value="">{{__('Choose The Default Bill')}}</option>
                                        @if($bill_data)
                                        @foreach ($bill_data as $b_data)
                                            <option value="{{$b_data->id}}">{{$b_data->bill_name}}</option>
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

    <!-- Insert Modal - Employee -->
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

    <!-- Insert Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createUserModal" tabindex="-1" aria-labelledby="createUserModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addUser">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserModal" style="color: #31fbe2">{{__('Add User')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Initialize Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="name">{{__('Full Name:')}}</label>
                                    <input type="text" name="name" wire:model="name" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email">{{__('Email To Sign In:')}}</label>
                                    <input type="email" name="email" wire:model="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password">{{__('Password:')}}</label>
                                    <input type="text" name="password" wire:model="password" class="form-control" id="password" required>
                                </div>
                                <div class="mb-3">
                                    <label>{{__('Role')}}</label>
                                    <select wire:model="role" name="role" id="role" class="form-control" required>
                                        <option value="">{{__('Choose Role')}}</option>
                                            <option value="1">{{__('Admin')}}</option>
                                            <option value="2">{{__('Editor')}}</option>
                                            <option value="3">{{__('Finance')}}</option>
                                            <option value="4">{{__('Employee')}}</option>
                                    </select>
                                </div>
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="status" class="form-control" required>
                                    <option value="">{{__('Choose Status')}}</option>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Non Active')}}</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h2 class="text-lg font-medium text-center">
                                    <b class="text-uppercase text-white">{{__('Upload Avatar Image')}}</b>
                                </h2>
                                <label for="img">{{__('Upload Image')}}</label>
                                <input type="file" name="avatarImg" id="avatarImg" class="form-control" style="height: auto">
                                <small class="bg-info text-white px-2 rounded">{{__('The Image Size Should be')}} <b>{{__('(640px X 640px)')}}</b></small>
                                @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                                <input type="file" name="croppedAvatarImg" id="croppedAvatarImg" style="display: none;">
                                <div class="progress my-1">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated fImg" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <div class="mb-3 d-flex justify-content-center mt-1">
                                    <img id="showAvatarImg" class="img-thumbnail rounded" src="{{ $temp_avatarImg ?? $default_avatarImg }}" width="200px">
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Secondary Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="jobTitle">{{__('Job Title:')}}</label>
                                    <input type="text" name="jobTitle" wire:model="jobTitle" class="form-control" id="jobTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nationalId">{{__('National ID:')}}</label>
                                    <input type="text" name="nationalId" wire:model="nationalId" class="form-control" id="nationalId" required>
                                </div>
                                <div class="mb-3">
                                    <label for="actualEmail">{{__('Owner Email Address:')}}</label>
                                    <input type="email" name="actualEmail" wire:model="actualEmail" class="form-control" id="actualEmail">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="phoneNumberOne">{{__('First Phone Number:')}}</label>
                                    <input type="tel" name="phoneNumberOne" wire:model="phoneNumberOne" class="form-control" id="phoneNumberOne" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumberTwo">{{__('Second Phone Number:')}}</label>
                                    <input type="tel" name="phoneNumberTwo" wire:model="phoneNumberTwo" class="form-control" id="phoneNumberTwo">
                                </div>
                                <div class="mb-3">
                                    <label for="salaryDollar">{{__('Salary in ($):')}}</label>
                                    <input type="number" name="salaryDollar" wire:model="salaryDollar" class="form-control" id="salaryDollar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="salaryIraqi">{{__('Salary in (IQD):')}}</label>
                                    <input type="number" name="salaryIraqi" wire:model="salaryIraqi" class="form-control" id="salaryIraqi" required>
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
    <div wire:ignore.self class="modal fade overflow-auto" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateUser">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserModal" style="color: #31fbe2">{{__('Add User')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Initialize Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="name">{{__('Full Name:')}}</label>
                                    <input type="text" name="name" wire:model="name" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email">{{__('Email To Sign In:')}}</label>
                                    <input type="email" name="email" wire:model="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password">{{__('Password:')}}</label>
                                    <input type="text" name="password" wire:model="password" class="form-control" id="password" required>
                                </div>
                                <div class="mb-3">
                                    <label>{{__('Role')}}</label>
                                    <select wire:model="role" name="role" id="role" class="form-control" required>
                                        <option value="">{{__('Choose Role')}}</option>
                                            <option value="1">{{__('Admin')}}</option>
                                            <option value="2">{{__('Editor')}}</option>
                                            <option value="3">{{__('Finance')}}</option>
                                            <option value="4">{{__('Employee')}}</option>
                                    </select>
                                </div>
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="status" class="form-control" required>
                                    <option value="">{{__('Choose Status')}}</option>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Non Active')}}</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h2 class="text-lg font-medium text-center">
                                    <b class="text-uppercase text-white">{{__('Upload Avatar Image')}}</b>
                                </h2>
                                <label for="img">{{__('Upload Image')}}</label>
                                <input type="file" name="editAvatarImg" id="editAvatarImg" class="form-control" style="height: auto">
                                <small class="bg-info text-white px-2 rounded">{{__('The Image Size Should be')}} <b>{{__('(640px X 640px)')}}</b></small>
                                @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                                <input type="file" name="editCroppedAvatarImg" id="editCroppedAvatarImg" style="display: none;">
                                <div class="progress my-1">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated fImg" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <div class="mb-3 d-flex justify-content-center mt-1">
                                    <img id="editShowAvatarImg" class="img-thumbnail rounded" src="{{ $temp_avatarImg ?? $default_avatarImg }}" width="200px">
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Secondary Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="jobTitle">{{__('Job Title:')}}</label>
                                    <input type="text" name="jobTitle" wire:model="jobTitle" class="form-control" id="jobTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nationalId">{{__('National ID:')}}</label>
                                    <input type="text" name="nationalId" wire:model="nationalId" class="form-control" id="nationalId" required>
                                </div>
                                <div class="mb-3">
                                    <label for="actualEmail">{{__('Owner Email Address:')}}</label>
                                    <input type="email" name="actualEmail" wire:model="actualEmail" class="form-control" id="actualEmail">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="phoneNumberOne">{{__('First Phone Number:')}}</label>
                                    <input type="tel" name="phoneNumberOne" wire:model="phoneNumberOne" class="form-control" id="phoneNumberOne" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumberTwo">{{__('Second Phone Number:')}}</label>
                                    <input type="tel" name="phoneNumberTwo" wire:model="phoneNumberTwo" class="form-control" id="phoneNumberTwo">
                                </div>
                                <div class="mb-3">
                                    <label for="salaryDollar">{{__('Salary in ($):')}}</label>
                                    <input type="number" name="salaryDollar" wire:model="salaryDollar" class="form-control" id="salaryDollar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="salaryIraqi">{{__('Salary in (IQD):')}}</label>
                                    <input type="number" name="salaryIraqi" wire:model="salaryIraqi" class="form-control" id="salaryIraqi" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success submitJs">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     
    <div wire:ignore.self class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFoodModalLabel">{{__('Delete User')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyUser">
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete this Company?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_user_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="user_name_to_selete" class="form-control">
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