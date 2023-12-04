<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Dashboard\TelegramClientNew;
use App\Notifications\Dashboard\TelegramClientDelete;
use App\Notifications\Dashboard\TelegramClientUpdate;

class ClientLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $companyName;
    public $clientName;
    public $email;
    public $address;
    public $city;
    public $country;
    public $zipcode;
    public $website;
    public $phoneOne;
    public $phoneTwo;
    //FILTERS
    public $search;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $clientUpdate;
    public $old_client_data;
    public $del_client_id;
    public $del_client_data;
    public $del_client_name;
    public $client_name_to_selete;
    public $confirmDelete = false;

    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
    } // END FUNCTION OF PAGE LOAD


    protected function rules()
    {
        $rules = [];
        $rules['companyName'] = ['required'];
        $rules['clientName'] = ['required'];
        $rules['email'] = ['required'];
        $rules['address'] = ['required'];
        $rules['city'] = ['required'];
        $rules['country'] = ['required'];
        $rules['zipcode'] = ['required'];
        $rules['phoneOne'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addClient(){
        try {
            $validatedData = $this->validate();

            $client = Client::create([
                'companyName' => $validatedData['companyName'],
                'clientName' => $validatedData['clientName'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
                'zipcode' => $this->zipcode,
                'website' => $this->website,
                'phoneOne' => $validatedData['phoneOne'],
                'phoneTwo' => $this->phoneTwo,
            ]);
    
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramClientNew(
                        $client->id,
                        $validatedData['companyName'],
                        $validatedData['clientName'],
                        $validatedData['email'],
                        $validatedData['address'],
                        $validatedData['phoneOne'],
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

    
    public function editClient(int $clientId){
        try {
            $clientEdit = Client::find($clientId);
            $this->clientUpdate = $clientId;
            $this->old_client_data = [];

            if ($clientEdit) {
                $this->old_client_data = null;

                $this->companyName = $clientEdit->companyName;
                $this->clientName = $clientEdit->clientName;
                $this->email = $clientEdit->email;
                $this->address = $clientEdit->address;
                $this->city = $clientEdit->city;
                $this->country = $clientEdit->country;
                $this->zipcode = $clientEdit->zipcode;
                $this->website = $clientEdit->website;
                $this->phoneOne = $clientEdit->phoneOne;
                $this->phoneTwo = $clientEdit->phoneTwo;

                $this->old_client_data = [
                    'id' => $clientEdit->id,
                    'company_name' => $clientEdit->companyName,
                    'client_name' => $clientEdit->clientName,
                    'email' => $clientEdit->email,
                    'address' => $clientEdit->address,
                    'city' => $clientEdit->city,
                    'country' => $clientEdit->country,
                    'zipcode' => $clientEdit->zipcode,
                    'website' => $clientEdit->website,
                    'phone_one' => $clientEdit->phoneOne,
                    'phone_two' => $clientEdit->phoneTwo,
                ];
            } else {
                return redirect()->to('/client');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT CLIENT

    
    public function updateClient(){
        try {
            $validatedData = $this->validate();

            Client::where('id', $this->clientUpdate)->update([
                'company_name' => $validatedData['companyName'],
                'client_name' => $validatedData['clientName'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
                'zipcode' => $validatedData['zipcode'],
                'website' => $this->website,
                'phone_one' => $validatedData['phoneOne'],
                'phone_two' => $this->phoneTwo,
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramClientUpdate(
                        $this->clientUpdate,
                        $this->companyName,
                        $this->clientName,
                        $this->email,
                        $this->address,
                        $this->city,
                        $this->country,
                        $this->zipcode,
                        $this->website,
                        $this->phoneOne,
                        $this->phoneTwo,

                        $this->old_client_data,
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


    public function deleteClient(int $selected_client_id){
        $this->del_client_id = $selected_client_id;
        $this->del_client_data = Client::find($this->del_client_id);
        if($this->del_client_data->companyName){
            $this->del_client_name = $this->del_client_data->companyName;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE CLIENT

    public function destroyClient(){
        if ($this->confirmDelete && $this->client_name_to_selete === $this->del_client_name) {
            Client::find($this->del_client_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramClientDelete(
                        $this->del_client_id,
                        $this->del_client_data->companyName,
                        $this->del_client_data->clientName,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_client_id = null;
            $this->del_client_data = null;
            $this->del_client_name = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_client_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    public function resetModal(){
        $this->companyName = '';
        $this->clientName = '';
        $this->email = '';
        $this->address = '';
        $this->city = '';
        $this->country = '';
        $this->zipcode = '';
        $this->website = '';
        $this->phoneOne = '';
        $this->phoneTwo = '';
        $this->del_client_id = null;
        $this->del_client_data = null;
        $this->del_client_name = null;
        $this->confirmDelete = false;
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public function render()
    {

        $colspan = 6;
        $cols_th = ['#','Company Name','Client Name','Phone Number','Email Address', 'Country', 'Actions'];
        $cols_td = ['id','company_name','client_name','phone_one','email','country'];

        $data = Client::query()
        ->where(function ($query) {
            $query->where('company_name', 'like', '%' . $this->search . '%')
                ->orWhere('client_name', 'like', '%' . $this->search . '%')
                ->orWhere('country', 'like', '%' . $this->search . '%');
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
    

        
        return view('livewire.client-table',['items' => $data, 'cols_th' => $cols_th, 'cols_td' => $cols_td,'colspan' => $colspan]);
    } // END FUNCTION OF RENDER
}