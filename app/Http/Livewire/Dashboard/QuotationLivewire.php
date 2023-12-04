<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Dashboard\TelegramServiceNew;
use App\Notifications\Dashboard\TelegramServiceDelete;
use App\Notifications\Dashboard\TelegramServiceUpdate;

class QuotationLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $branch_id;
    public $branch_select_option;
    public $payment_id;
    public $payment_select_option;
    public $client_id;
    public $client_select_option;
    public $description;
    public $service_selected;
    public $service_details_temp;
    //TEMP
    public $serviceDefaultCode;
    public $serviceDefaultName;
    public $serviceDefaultDescription;
    public $serviceDefaultCost;
    public $serviceQty;
    public $serviceTotal;
    
    public $service_arr = [];
    public $systematic_choice;
    public $service_temp;

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
        $this->initializeServices();
        // dd($this->service_arr);
    } // END FUNCTION OF PAGE LOAD

    public function initializeServices()
    {

    } //END FUNCTION OF INITIALIZE OPTION OF FOOD

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
                'serviceCode' => $validatedData['serviceCode'],
                'serviceName' => $validatedData['serviceName'],
                'serviceDescription' => $validatedData['serviceDescription'],
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
                    'serviceCode' => $serviceEdit->serviceCode,
                    'serviceName' => $serviceEdit->serviceName,
                    'serviceDescription' => $serviceEdit->serviceDescription,
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
                'serviceCode' => $validatedData['serviceCode'],
                'serviceName' => $validatedData['serviceName'],
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

    public function updateDetailsOfService(){
        $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('Service Deleted Successfully')]);
        $this->service_details_temp = Service::where('id', $this->service_selected)->first();
        $this->serviceDefaultCode = $this->service_details_temp->service_code ?? null;
        // $this->serviceDefaultName = $this->service_details_temp->service_name ?? null;
        $this->serviceDefaultDescription = $this->service_details_temp->service_description ?? null;
        $this->serviceDefaultCost = $this->service_details_temp->cost ?? null;
    }
    public function serviceQtyChange(){
        $this->serviceTotal = $this->serviceQty * $this->serviceDefaultCost;
    }
    
    public function render()
    {
        // START GET THE Category NAMES
        $this->branch_select_option = Branch::get();
        $this->payment_select_option = Payment::get();
        $this->client_select_option = Client::get();

        $branch_temp = Branch::find($this->branch_id);

        if ($branch_temp && $branch_temp->systematic) {
            $systematicData = json_decode($branch_temp->systematic, true);
            usort($systematicData, function ($a, $b) {
                return $a['prt'] <=> $b['prt'];
            });
            $this->systematic_choice = $systematicData;
        } else {
            $this->systematic_choice = null;
        }

        $this->service_temp = Service::where('branch_id', $this->branch_id)->get();

// );
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
        

        
        return view('livewire.quotation-table',[
            'items' => $data, 
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'systematic_choice' => $this->systematic_choice,
            'service_temp' => $this->service_temp,
            'service_selected' => $this->service_details_temp ?? null
        ]);
    } // END FUNCTION OF RENDER
}