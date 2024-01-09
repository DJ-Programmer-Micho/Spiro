<?php

namespace App\Http\Livewire\Edt;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Edt\TelegramClientNew;
use App\Notifications\Edt\TelegramClientUpdate;

class ClientLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $clientName;
    public $country;
    public $city;
    public $address;
    public $email;
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
    public $client_name_to_selete;
    public $confirmDelete = false;

    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
    } // END FUNCTION OF PAGE LOAD

    protected function rules()
    {
        $rules = [];
        $rules['clientName'] = ['required'];
        $rules['address'] = ['required'];
        $rules['city'] = ['required'];
        $rules['country'] = ['required'];
        $rules['phoneOne'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addClient(){
        try {
            $validatedData = $this->validate();

            $client = Client::create([
                'client_name' => $validatedData['clientName'],
                'email' => $this->email,
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
                'phone_one' => $validatedData['phoneOne'],
                'phone_two' => $this->phoneTwo,
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramClientNew(
                        auth()->user()->name,
                        $client->id,
                        $validatedData['clientName'],
                        $this->email ?? 'N/A',
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
                $this->clientName = $clientEdit->client_name;
                $this->email = $clientEdit->email;
                $this->address = $clientEdit->address;
                $this->city = $clientEdit->city;
                $this->country = $clientEdit->country;
                $this->phoneOne = $clientEdit->phone_one;
                $this->phoneTwo = $clientEdit->phone_two;

                $this->old_client_data = [
                    'id' => $clientEdit->id,
                    'clientName' => $clientEdit->client_name,
                    'email' => $clientEdit->email,
                    'address' => $clientEdit->address,
                    'city' => $clientEdit->city,
                    'country' => $clientEdit->country,
                    'phoneOne' => $clientEdit->phone_one,
                    'phoneTwo' => $clientEdit->phone_two,
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
                'client_name' => $validatedData['clientName'],
                'email' => $this->email,
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
                'phone_one' => $validatedData['phoneOne'],
                'phone_two' => $this->phoneTwo,
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramClientUpdate(
                        auth()->user()->name,
                        $this->clientUpdate,
                        $this->clientName,
                        $this->email,
                        $this->address,
                        $this->city,
                        $this->country,
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

    public function deleteMessage(){
        $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => __('HA HA HA, Nice Try')]);
    } // END FUNCTION OF DELETE CLIENT


    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->clientName = '';
        $this->email = '';
        $this->address = '';
        $this->city = '';
        $this->country = '';
        $this->phoneOne = '';
        $this->phoneTwo = '';
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL


    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','Client Name','Email Address', 'Phone Number','Country', 'Actions'];
        $cols_td = ['id','client_name','email','phone_one','country'];

        $data = Client::query()
        ->where(function ($query) {
            $query->where('client_name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone_one', 'like', '%' . $this->search . '%')
                ->orWhere('phone_two', 'like', '%' . $this->search . '%')
                ->orWhere('country', 'like', '%' . $this->search . '%');
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
        
        return view('livewire.edt.client-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}