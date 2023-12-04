<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Dashboard\TelegramServiceNew;
use App\Notifications\Dashboard\TelegramServiceDelete;
use App\Notifications\Dashboard\TelegramServiceUpdate;

class ServiceLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $branch_id;
    public $branch_select_option;
    public $serviceCode;
    public $serviceName;
    public $serviceDescription;
    public $cost;
    //FILTERS
    public $search;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $serviceUpdate;
    public $old_service_data;
    public $del_service_id;
    public $del_service_data;
    public $del_service_name;
    public $service_name_to_selete;
    public $confirmDelete = false;

    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
    } // END FUNCTION OF PAGE LOAD


    protected function rules()
    {
        $rules = [];
        $rules['branch_id'] = ['required'];
        $rules['serviceCode'] = ['required'];
        $rules['serviceName'] = ['required'];
        $rules['serviceDescription'] = ['required'];
        $rules['cost'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addService(){
        try {
            $validatedData = $this->validate();

            $service = Service::create([
                'branch_id' => $validatedData['branch_id'],
                'service_code' => $validatedData['serviceCode'],
                'service_name' => $validatedData['serviceName'],
                'service_description' => $validatedData['serviceDescription'],
                'cost' => $validatedData['cost'],
            ]);
    
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramServiceNew(
                        $service->id,
                        $validatedData['branch_id'],
                        $validatedData['serviceCode'],
                        $validatedData['serviceName'],
                        $validatedData['cost'],
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Service Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF ADD SERVICE

    
    public function editService(int $serviceId){
        try {
            $serviceEdit = Service::find($serviceId);
            $this->serviceUpdate = $serviceId;
            $this->old_service_data = [];

            if ($serviceEdit) {
                $this->old_service_data = null;

                $this->branch_id = $serviceEdit->branch_id;
                $this->serviceCode = $serviceEdit->serviceCode;
                $this->serviceName = $serviceEdit->serviceName;
                $this->serviceDescription = $serviceEdit->serviceDescription;
                $this->cost = $serviceEdit->cost;

                $this->old_service_data = [
                    'service_id' => $this->serviceUpdate,
                    'branch_id' => $serviceEdit->branch_id,
                    'service_code' => $serviceEdit->serviceCode,
                    'service_name' => $serviceEdit->serviceName,
                    'service_description' => $serviceEdit->serviceDescription,
                    'cost' => $serviceEdit->cost,
                ];
            } else {
                return redirect()->to('/service');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT CLIENT

    
    public function updateService(){
        try {
            $validatedData = $this->validate();

            Service::where('id', $this->serviceUpdate)->update([
                'branch_id' => $validatedData['branch_id'],
                'service_code' => $validatedData['serviceCode'],
                'service_name' => $validatedData['serviceName'],
                'cost' => $validatedData['cost'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramServiceUpdate(
                        $this->serviceUpdate,
                        $this->branch_id,
                        $this->serviceCode,
                        $this->serviceName,
                        $this->serviceDescription,
                        $this->cost,

                        $this->old_service_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Service Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE CLIENT


    public function deleteService(int $selected_service_id){
        $this->del_service_id = $selected_service_id;
        $this->del_service_data = Service::find($this->del_service_id);
        if($this->del_service_data->serviceName){
            $this->del_service_name = $this->del_service_data->serviceName;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE service

    public function destroyService(){
        if ($this->confirmDelete && $this->service_name_to_selete === $this->del_service_name) {
            Service::find($this->del_service_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramServiceDelete(
                        $this->del_service_id,
                        $this->del_service_data->branch_id,
                        $this->del_service_data->serviceCode,
                        $this->del_service_data->serviceName,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_service_id = null;
            $this->del_service_data = null;
            $this->del_service_name = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Service Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_client_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    public function resetModal(){
        $this->branch_id = '';
        $this->serviceCode = '';
        $this->serviceName = '';
        $this->cost = '';
        $this->del_service_id = null;
        $this->del_service_data = null;
        $this->del_service_name = null;
        $this->confirmDelete = false;
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public function render()
    {
        // START GET THE Category NAMES
        $this->branch_select_option = Branch::get();
// dd( $this->branch_select_option);
        $colspan = 6;
        $cols_th = ['#','Branch Name','Service Name','Service Code','Default Cost', 'Actions'];
        $cols_td = ['id','branch','service_name','service_code','cost'];

        $data = Service::query()
        ->where(function ($query) {
            $query->where('service_code', 'like', '%' . $this->search . '%')
                ->orWhere('service_name', 'like', '%' . $this->search . '%')
                ->orWhere('branch_id', 'like', '%' . $this->search . '%');
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
    

        
        return view('livewire.service-table',['items' => $data, 'cols_th' => $cols_th, 'cols_td' => $cols_td,'colspan' => $colspan]);
    } // END FUNCTION OF RENDER
}