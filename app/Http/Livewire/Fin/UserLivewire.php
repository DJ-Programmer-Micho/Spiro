<?php

namespace App\Http\Livewire\Fin;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Fin\TelegramUserNew;
use App\Notifications\Fin\TelegramUserUpdate;

class UserLivewire extends Component
{
    use WithPagination; 
    // use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $name;
    public $email;
    public $password;
    public $role;
    public $status;
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

    public $baseAvatar;

    protected $listeners = [
        'updateCroppedAvatarImg' => 'handleCroppedImage',
        'simulationCompleteImgFood' => 'handlesimulationCompleteImg',
    ];

    public function mount(){
        $this->baseAvatar = '/home/metiszec/arnews.metiraq.com/avatars/';

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
        $rules['role'] = ['required'];
        $rules['status'] = ['required'];
        $rules['nationalId'] = ['required'];
        $rules['phoneNumberOne'] = ['required'];
        $rules['salaryDollar'] = ['required'];
        $rules['salaryIraqi'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

public $decodedImage;
public $img_public;
public function handleCroppedImage($img)
{
    $this->img_public = $img;
    $this->temp_avatarImg = $img;
}

    public function addUser(){
        try {
            $validatedData = $this->validate();

            if ($this->img_public) {
                $this->img_public = preg_replace('/^data:image\/\w+;base64,/', '', $this->img_public);
                $this->decodedImage = base64_decode($this->img_public);
                if ($this->decodedImage === false) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Imade did not Encoded, please check the file or file format!')]);
                }

                $filename = 'user_' . now()->format('YmdHis') . '.jpg';
                $success = File::put(public_path('avatars/' . $filename), $this->decodedImage);
                // $success = File::put($this->baseAvatar . $filename, $this->decodedImage);

                if ($success) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Avatar Uploaded Successfully')]);
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('Avatar did not upload')]);
                }
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('No Image Found!')]);
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
                'avatar' => $filename ?? 'user.png',
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
                        auth()->user()->name,
                        $user->id,
                        $validatedData['name'],
                        $roleName,
                        $this->jobTitle,
                        $filename ?? 'user.png',
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
                return redirect()->to('fin/user');
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
                    if ($oldAvatarFilename && $oldAvatarFilename != 'user.png') {
                        // Use public_path() for files in the public directory
                        $filePath = public_path('avatars/' . $oldAvatarFilename);
                    // $filePath = $this->baseAvatar . $oldAvatarFilename;
                        // Delete the old avatar file
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                    // Generate a new filename for the avatar
                    $filename = 'user_' . now()->format('YmdHis') . '.jpg';
                    // Save the new avatar file
                    File::put(public_path('avatars/' . $filename), $this->decodedImage);
                    // File::put($this->baseAvatar . $filename, $this->decodedImage);
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
                        auth()->user()->name,
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

    public function deleteMessage(){
            $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => __('HA HA HA, Nice Try')]);
    } // END FUNCTION OF DELETE CLIENT

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
        $cols_th = ['#','User Name','Avatar','Email Address', 'Role','status', 'Actions'];
        $cols_td = ['id','name','avatar','email','role','status'];

        $data = User::query()
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*', 'profiles.avatar')
            ->where(function ($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%')
                    ->orWhere('users.role', 'like', '%' . $this->search . '%')
                    ->orWhere('users.status', 'like', '%' . $this->search . '%');
            })
            ->paginate(15);

        return view('livewire.fin.user-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}