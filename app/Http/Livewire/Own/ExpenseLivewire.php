<?php

namespace App\Http\Livewire\Own;

use App\Models\User;
use App\Models\Expense;
use App\Models\Profile;
use Livewire\Component;
use App\Models\BillsExpense;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramExpenseNew;
use App\Notifications\Own\TelegramUserDelete;
use App\Notifications\Own\TelegramUserUpdate;

class ExpenseLivewire extends Component
{
    use WithPagination; 
    // use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    // FORM BILL TYPE
    public $bill_data;
    public $select_bill_data;
    public $billName;

    // FORM emp TYPE
    public $user_data;
    public $select_user_data;
    public $empName;

    // FORM emp TYPE
    public $expenseOtherName;

    // GENERAL INFORMATION
    public $cost_dollar;
    public $cost_iraqi;
    public $description;
    public $billDate;




    //FORM
    public $name;
    public $email;
    public $password;
    public $role;
    public $jobTitle;
    public $nationalId;
    public $actualEmail;
    public $phoneNumberOne;
    public $phoneNumberTwo;
    public $salaryDollar;
    public $salaryIraqi;
    //FORM IMG
    public $imgFlag = false; 
    public $default_avatarImg;
    public $temp_avatarImg;
    public $old_avatarImg;
    //FILTERS
    public $search;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $userUpdate;
    public $old_user_data;
    public $del_user_id;
    public $del_user_data;
    public $del_user_name;
    public $user_name_to_selete;
    public $confirmDelete = false;


    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
        $this->default_avatarImg = asset('avatars/user.png');
    } // END FUNCTION OF PAGE LOAD

    protected function rules()
    {
        $rules = [];
        $rules['name'] = ['required'];
        $rules['email'] = ['required'];
        $rules['password'] = ['required'];
        $rules['status'] = ['required'];
        $rules['nationalId'] = ['required'];
        $rules['phoneNumberOne'] = ['required'];
        $rules['salaryDollar'] = ['required'];
        $rules['salaryIraqi'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    // *********************
    // START - FOR THE BILLS PROCESS
    // *********************
    // Add Section
    public function addExpenseBillModalStartup(){
        $this->resetModal();
        $this->bill_data = BillsExpense::get();
    }
    public function selectExpenseBillModalStartup(){
        $this->resetModal();
        $this->select_bill_data;

        $selected_by_user_bill_data = BillsExpense::where('id', $this->select_bill_data)->first();
        $this->billName = $selected_by_user_bill_data->bill_name;
        $this->cost_dollar = $selected_by_user_bill_data->cost_dollar;
        $this->cost_iraqi = $selected_by_user_bill_data->cost_iraqi;
        $this->description = $selected_by_user_bill_data->description;
    }
    public function addBillExpense(){
        try {
            $bill_expense = Expense::create([
                'item' => $this->billName,
                'type' => 'Bill',
                'description' => $this->description,
                'cost_dollar' => $this->cost_dollar,
                'cost_iraqi' => $this->cost_iraqi,
                'payed_date' => $this->billDate
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramExpenseNew(
                        $bill_expense->id,
                        $this->billName,
                        'Bill',
                        $this->cost_dollar,
                        $this->cost_iraqi,
                        $this->billDate,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Expense Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }

    // Edit Section
    public function editExpenseBillModalStartup(){
        $this->resetModal();
        $this->bill_data = BillsExpense::get();
    }
    // Delete Section

    // *********************
    // END - FOR THE BILLS PROCESS
    // *********************

    // *********************
    // START - FOR THE EMP PROCESS
    // *********************
    public function addExpenseEmpModalStartup(){
        $this->resetModal();
        $this->user_data = User::get();
    }
    public function selectExpenseEmpModalStartup(){
        $this->resetModal();
        $this->select_user_data;

        $selected_by_user_user_data = User::where('id', $this->select_user_data)->first();
        $this->empName = $selected_by_user_user_data->name;
        $this->cost_dollar = $selected_by_user_user_data->profile->salary_dollar;
        $this->cost_iraqi = $selected_by_user_user_data->profile->salary_iraqi;
        $this->description = $selected_by_user_user_data->profile->job_title;
    }
    public function addEmpExpense(){
        try {
            $emp_expense = Expense::create([
                'item' => $this->empName,
                'type' => 'Salary',
                'description' => $this->description,
                'cost_dollar' => $this->cost_dollar,
                'cost_iraqi' => $this->cost_iraqi,
                'payed_date' => $this->billDate
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramExpenseNew(
                        $emp_expense->id,
                        $this->empName,
                        'Salary',
                        $this->cost_dollar,
                        $this->cost_iraqi,
                        $this->billDate,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Expense Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }
    // *********************
    // END - FOR THE EMP PROCESS
    // *********************

        // *********************
    // START - FOR THE EMP PROCESS
    // *********************
    public function selectExpenseOthModalStartup(){
        $this->resetModal();
    }
    public function addOtherExpense(){
        try {
            $other_expense = Expense::create([
                'item' => $this->expenseOtherName,
                'type' => 'Other',
                'description' => $this->description,
                'cost_dollar' => $this->cost_dollar,
                'cost_iraqi' => $this->cost_iraqi,
                'payed_date' => $this->billDate
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramExpenseNew(
                        $other_expense->id,
                        $this->expenseOtherName,
                        'Other',
                        $this->cost_dollar,
                        $this->cost_iraqi,
                        $this->billDate,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Expense Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }
    // *********************
    // END - FOR THE EMP PROCESS
    // *********************


    public function addUser(){
        try {
            $validatedData = $this->validate();
            if ($this->img_public) {
                $this->img_public = preg_replace('/^data:image\/\w+;base64,/', '', $this->img_public);
                $this->decodedImage = base64_decode($this->img_public);
                if ($this->decodedImage === false) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Imade did not Encoded, please check the file or file format!')]);
                }
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('No Image Found!')]);
            }

            $filename = 'user_' . now()->format('YmdHis') . '.jpg';
            $success = File::put(public_path('avatars/' . $filename), $this->decodedImage);
            if ($success) {
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Avatar Uploaded Successfully')]);
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('Avatar did not upload')]);
            }

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'role' => $validatedData['role'],
                'status' => $validatedData['status']
            ]);

            Profile::Create([
                'user_id' => $user->id,
                'job_title' => $this->jobTitle,
                'national_id' => $validatedData['nationalId'],
                'avatar' => $filename ?? null,
                'phone_number_1' => $validatedData['phoneNumberOne'],
                'phone_number_2' => $this->phoneNumberTwo ?? null,
                'email_address' => $this->actualEmail ?? null,
                'salary_dollar' => $validatedData['salaryDollar'],
                'salary_iraqi' => $validatedData['salaryIraqi'],
            ]);



            if($validatedData['role'] == 1) {
                $roleName = 'Admin';
            } else if ($validatedData['role'] == 2){
                $roleName = 'Editor';
            } else if ($validatedData['role'] == 3) {
                $roleName = 'Finance';
            } else {
                $roleName = 'Employee';
            }
             
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramUserNew(
                        $user->id,
                        $validatedData['name'],
                        $roleName,
                        $this->jobTitle,
                        $filename,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF ADD CLIENT

    public function editUser(int $userId){
        try {
            $userEdit = User::find($userId);
            $this->userUpdate = $userId;
            $this->old_user_data = [];

            if ($userEdit) {
                $this->old_user_data = null;
                $this->name = $userEdit->name;
                $this->email = $userEdit->email;
                $this->password = $userEdit->password;
                $this->role = $userEdit->role;
                $this->status = $userEdit->status;
                $this->jobTitle = $userEdit->profile->job_title;
                $this->nationalId = $userEdit->profile->national_id;
                $this->actualEmail = $userEdit->profile->email_address;
                $this->phoneNumberOne = $userEdit->profile->phone_number_1;
                $this->phoneNumberTwo = $userEdit->profile->phone_number_2;
                $this->salaryDollar = $userEdit->profile->salary_dollar;
                $this->salaryIraqi = $userEdit->profile->salary_iraqi;

                if($userEdit->profile->avatar){
                    $this->temp_avatarImg = asset('avatars/'.$userEdit->profile->avatar);
                }

                $this->old_user_data = [
                    'id' => $userEdit->id,
                    'name' => $userEdit->name,
                    'email' => $userEdit->email,
                    'password' => $userEdit->password,
                    'role' => $userEdit->role,
                    'status' => $userEdit->status,
                    'jobTitle' => $userEdit->profile->job_title,
                    'nationalId' => $userEdit->profile->national_id,
                    'avatar' => $userEdit->profile->avatar,
                    'actualEmail' => $userEdit->profile->email_address,
                    'phoneNumberOne' => $userEdit->profile->phone_number_1,
                    'phoneNumberTwo' => $userEdit->profile->phone_number_2,
                    'salaryDollar' => $userEdit->profile->salary_dollar,
                    'salaryIraqi' => $userEdit->profile->salary_iraqi
                ];
            } else {
                return redirect()->to('own/user');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT CLIENT

    public function updateUser(){
        try {
            $validatedData = $this->validate();

            if ($this->img_public) {
                $this->img_public = preg_replace('/^data:image\/\w+;base64,/', '', $this->img_public);
                $this->decodedImage = base64_decode($this->img_public);
    
                if ($this->decodedImage === false) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Image did not encode correctly, please check the file or file format!')]);
                } else {
                    $oldAvatarFilename = Profile::where('user_id', $this->userUpdate)->value('avatar');
                    // Delete the old avatar file
                    if ($oldAvatarFilename) {
                        // Use public_path() for files in the public directory
                        $filePath = public_path('avatars/' . $oldAvatarFilename);
                    
                        // Delete the old avatar file
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                    // Generate a new filename for the avatar
                    $filename = 'user_' . now()->format('YmdHis') . '.jpg';
                    // Save the new avatar file
                    File::put(public_path('avatars/' . $filename), $this->decodedImage);

                    Profile::where('user_id', $this->userUpdate)->update([
                        'avatar' => $filename ?? null,
                    ]);
                }
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('Image Did not Update')]);
            }

            User::where('id', $this->userUpdate)->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'role' => $validatedData['role'],
                'status' => $validatedData['status']
            ]);

            Profile::where('user_id', $this->userUpdate)->update([
                'job_title' => $this->jobTitle,
                'national_id' => $validatedData['nationalId'],
                'phone_number_1' => $validatedData['phoneNumberOne'],
                'phone_number_2' => $this->phoneNumberTwo ?? null,
                'email_address' => $this->actualEmail ?? null,
                'salary_dollar' => $validatedData['salaryDollar'],
                'salary_iraqi' => $validatedData['salaryIraqi'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramUserUpdate(
                        $this->userUpdate,
                        $this->name,
                        $this->email,
                        $this->password,
                        $this->role,
                        $this->status,
                        $this->jobTitle,
                        $this->nationalId,
                        $this->actualEmail,
                        $this->phoneNumberOne,
                        $this->phoneNumberTwo,
                        $this->salaryDollar,
                        $this->salaryIraqi,
                        $filename ?? $this->old_user_data['avatar'],

                        $this->old_user_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE CLIENT

    public function deleteUser(int $selected_user_id){
        $this->del_user_id = $selected_user_id;
        $this->del_user_data = User::find($this->del_user_id);
        if($this->del_user_data->name){
            $this->del_user_name = $this->del_user_data->name ?? "DELETE";
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE CLIENT

    public function destroyUser(){
        if ($this->confirmDelete && $this->user_name_to_selete === $this->del_user_name) {
            User::find($this->del_user_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramUserDelete(
                        $this->del_user_id,
                        $this->del_user_data->name,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_user_id = null;
            $this->del_user_data = null;
            $this->del_user_name = null;
            $this->user_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('User Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_client_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->status = '';
        $this->jobTitle = '';
        $this->nationalId = '';
        $this->actualEmail = '';
        $this->phoneNumberOne = '';
        $this->phoneNumberTwo = '';
        $this->salaryDollar = '';
        $this->salaryIraqi = '';
        $this->del_user_id = null;
        $this->del_user_data = null;
        $this->del_user_name = null;
        $this->imgFlag = false; 
        $this->img_public = null;
        $this->temp_avatarImg = null;
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL


    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','Item','Type Expense', 'Price in ($)','Price in (IQD)', 'Note', 'Date', 'Actions'];
        $cols_td = ['id','item','type','cost_dollar','cost_iraqi','description','payed_date'];

        $data = Expense::query()
        ->where(function ($query) {
            $query->where('item', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('cost_dollar', 'like', '%' . $this->search . '%')
                ->orWhere('cost_iraqi', 'like', '%' . $this->search . '%');
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
        
        return view('livewire.own.expense-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan,
        ]);
    } // END FUNCTION OF RENDER
}