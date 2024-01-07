<?php

namespace App\Http\Livewire\Fin;

use App\Models\Client;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Fin\TelegramServiceNew;
use App\Notifications\Fin\TelegramServiceDelete;
use App\Notifications\Fin\TelegramServiceUpdate;

class ServiceLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $serviceCode;
    public $serviceName;
    public $serviceDescription;
    public $priceDollar;
    public $priceIraqi;
    //FILTERS
    public $search;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $serviceUpdate;
    public $old_service_data;

    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
    } // END FUNCTION OF PAGE LOAD

    protected function rules()
    {
        $rules = [];
        $rules['serviceCode'] = ['required'];
        $rules['serviceName'] = ['required'];
        $rules['priceDollar'] = ['required'];
        $rules['priceIraqi'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addService(){
        try {
            $validatedData = $this->validate();

            $service = Service::create([
                'service_code' => $validatedData['serviceCode'],
                'service_name' => $validatedData['serviceName'],
                'service_description' => $this->serviceDescription,
                'price_dollar' => $validatedData['priceDollar'],
                'price_iraqi' => $validatedData['priceIraqi'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramServiceNew(
                        auth()->user()->name,
                        $service->id,
                        $validatedData['serviceCode'],
                        $validatedData['serviceName'],
                        $validatedData['priceDollar'],
                        $validatedData['priceIraqi'],
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
    } // END FUNCTION OF ADD CLIENT

    public function editService(int $serviceId){
        try {
            $serviceEdit = Service::find($serviceId);
            $this->serviceUpdate = $serviceId;
            $this->old_service_data = [];

            if ($serviceEdit) {
                $this->old_service_data = null;
                $this->serviceCode = $serviceEdit->service_code;
                $this->serviceName = $serviceEdit->service_name;
                $this->serviceDescription = $serviceEdit->service_description;
                $this->priceDollar = $serviceEdit->price_dollar;
                $this->priceIraqi = $serviceEdit->price_iraqi;

                $this->old_service_data = [
                    'id' => $serviceEdit->id,
                    'serviceCode' => $serviceEdit->service_code,
                    'serviceName' => $serviceEdit->service_name,
                    'serviceDescription' => $serviceEdit->service_description,
                    'priceDollar' => $serviceEdit->price_dollar,
                    'priceIraqi' => $serviceEdit->price_iraqi,
                ];
            } else {
                return redirect()->to('fin/service');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT CLIENT

    public function updateService(){
        try {
            $validatedData = $this->validate();

            Service::where('id', $this->serviceUpdate)->update([
                'service_code' => $validatedData['serviceCode'],
                'service_name' => $validatedData['serviceName'],
                'service_description' => $this->serviceDescription,
                'price_dollar' => $validatedData['priceDollar'],
                'price_iraqi' => $validatedData['priceIraqi'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramServiceUpdate(
                        auth()->user()->name,
                        $this->serviceUpdate,
                        $this->serviceCode,
                        $this->serviceName,
                        $this->serviceDescription,
                        $this->priceDollar,
                        $this->priceIraqi,

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

    public function deleteMessage(){
        $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => __('HA HA HA, Nice Try')]);
    } // END FUNCTION OF DELETE CLIENT


    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->serviceCode = '';
        $this->serviceName = '';
        $this->serviceDescription = '';
        $this->priceDollar = '';
        $this->priceIraqi = '';
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL


    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','CODE','Service Name', 'Price in ($)','Price in (IQD)', 'Actions'];
        $cols_td = ['id','service_code','service_name','price_dollar','price_iraqi'];

        $data = Service::query()
        ->where(function ($query) {
            $query->where('service_code', 'like', '%' . $this->search . '%')
                ->orWhere('service_name', 'like', '%' . $this->search . '%')
                ->orWhere('price_dollar', 'like', '%' . $this->search . '%')
                ->orWhere('price_iraqi', 'like', '%' . $this->search . '%');
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
        
        return view('livewire.fin.service-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}