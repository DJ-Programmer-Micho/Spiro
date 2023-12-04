<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Dashboard\TelegramBranchNew;
use App\Notifications\Dashboard\TelegramBranchUpdate;
use App\Notifications\Dashboard\TelegramBranchDelete;


class BranchLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $branchName;
    public $branchManager;
    public $description;
    //SERVICE KEYS AND VALUES
    public $branchService = [];
    //FILTERS
    public $search;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $branchUpdate;
    public $old_branch_data;
    public $del_branch_id;
    public $del_branch_data;
    public $del_branch_name;
    public $branch_name_to_selete;
    public $confirmDelete = false;

    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
        $this->branchService[] = ['prt' => '','key' => ''];
    } // END FUNCTION OF PAGE LOAD

    public function addServiceToBranch(){
        $this->branchService[] = ['prt' => '','key' => ''];
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('New Systenatic Added')]);
    }

    public function removeServiceToBranch($index)
    {
        unset($this->branchService[$index]);
        $this->branchService = array_values($this->branchService); // Reindex the array
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Systematic Removed')]);
    }

    
    protected function rules()
    {
        $rules = [];
        $rules['branchName'] = ['required'];
        $rules['branchManager'] = ['required'];
        $rules['description'] = ['required'];
        // $rules['branchService'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addBranch(){
        try {
            $validatedData = $this->validate();
            if(empty($this->branchService)){
                $this->dispatchBrowserEvent('error', ['type' => 'success', 'message' => __('you should add at least one Systematic')]);
                return;
            }

            $branch = Branch::create([
                'branch_name' => $validatedData['branchName'],
                'branch_manager' => $validatedData['branchManager'],
                'description' => $validatedData['description'],
                'systematic' => json_encode($this->branchService),
            ]);
    
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramBranchNew(
                        $branch->id,
                        $validatedData['branchName'],
                        $validatedData['branchManager'],
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Branch Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF ADD BRANCH

    
    public function editBranch(int $branchId){
        try {
            $branchtEdit = Branch::find($branchId);
            $this->branchUpdate = $branchId;
            $this->old_branch_data = [];

            if ($branchtEdit) {
                $this->old_branch_data = null;

                $this->branchName = $branchtEdit->branchName;
                $this->branchManager = $branchtEdit->branchManager;
                $this->description = $branchtEdit->description;

                $this->old_branch_data = [
                    'id' => $branchtEdit->id,
                    'branch_name' => $branchtEdit->branchName,
                    'branch_manager' => $branchtEdit->branchManager,
                    'description' => $branchtEdit->description,
                ];
            } else {
                return redirect()->to('/branch');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT Branch

    
    public function updateBranch(){
        try {
            $validatedData = $this->validate();

            Branch::where('id', $this->branchUpdate)->update([
                'branch_name' => $validatedData['branchName'],
                'branch_manager' => $validatedData['branchManager'],
                'description' => $validatedData['description'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramBranchUpdate(
                        $this->branchUpdate,
                        $this->branchName,
                        $this->branchManager,
                        $this->description,

                        $this->old_branch_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Branch Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE BRANCH


    public function deleteBranch(int $selected_branch_id){
        $this->del_branch_id = $selected_branch_id;
        $this->del_branch_data = Branch::find($this->del_branch_id);
        if($this->del_branch_data->branchName){
            $this->del_branch_name = $this->del_branch_data->branchName;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE BRANCH

    public function destroyBranch(){
        if ($this->confirmDelete && $this->branch_name_to_selete === $this->del_branch_name) {
            Branch::find($this->del_branch_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramBranchDelete(
                        $this->del_branch_id,
                        $this->del_branch_data->branchName,
                        $this->del_branch_data->branchManager,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_branch_id = null;
            $this->del_branch_data = null;
            $this->del_branch_name = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Branch Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_branch_name]);
        }
    } // END FUNCTION OF DESTROY BRANCH

    public function resetModal(){
        $this->branchName = '';
        $this->branchManager = '';
        $this->description = '';
        $this->del_branch_id = null;
        $this->del_branch_data = null;
        $this->del_branch_name = null;
        $this->confirmDelete = false;
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public function render()
    {

        $colspan = 6;
        $cols_th = ['#','Branch Name','Branch Manager', 'Description', 'Actions'];
        $cols_td = ['id','branch_name','branch_manager','description'];

        $data = Branch::query()
        ->where(function ($query) {
            $query->where('branch_name', 'like', '%' . $this->search . '%')
                ->orWhere('branch_manager', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
    

        
        return view('livewire.branch-table',['items' => $data, 'cols_th' => $cols_th, 'cols_td' => $cols_td,'colspan' => $colspan]);
    } // END FUNCTION OF RENDER
}