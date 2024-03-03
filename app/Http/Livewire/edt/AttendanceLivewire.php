<?php

namespace App\Http\Livewire\Edt;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Quotation;
use App\Models\Attendance;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendaceExport;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Edt\TelegramAttendNew;
use App\Notifications\Edt\TelegramAttendUpdate;
use App\Notifications\Edt\TelegramAttendDelete;

class AttendanceLivewire extends Component
{

    use WithPagination; 
    // use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    // Form Client Section
    public $emp_data;
    public $select_emp_data;
    public $empName;
    public $jobTitle;
    public $startTime;
    public $endTime;
    public $dateAttend;
    public $duration;
    //FILTERS
    public $search;
    public $empFilter = '';
    public $attendEmpFilter = '';
    public $dateRange = null;
    public $rangeViewValue = null;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $attendUpdate;
    public $old_attend_data;
    public $del_attend_id;
    public $del_attend_data;
    public $del_attend_name;
    public $attend_name_to_selete;
    public $confirmDelete = false;


    protected $listeners = [ 'dateRangeSelected' => 'applyDateRangeFilter' ];

    public function mount() {
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
        $this->emp_data = User::orderBy('name', 'ASC')->get();
    } // END FUNCTION OF PAGE LOAD

    public function printReportModal(){
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $search = $this->search;
        $empFilter = $this->empFilter;

        return Excel::download(new AttendaceExport($startDate, $endDate, $search, $empFilter), 'attendaceReport_'.now()->format('Y-m-d').'_.xlsx');
    }

    public function selectEmpStartup(){
        $user_selected = User::with('profile')->where('id', $this->select_emp_data)->first();
        $this->jobTitle = $user_selected->profile->job_title;
        if($this->startTime == null){
            $this->startTime = now()->format('H:i');
        }
    }

    protected function rules() {
        $rules = [];
        $rules['select_emp_data'] = ['required'];
        $rules['startTime'] = ['required'];
        $rules['dateAttend'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function timeCalculate() {
        if ($this->endTime && $this->startTime) {

            // Trim leading and trailing whitespace from input strings
            $startTime = trim($this->startTime);
            $endTime = trim($this->endTime);
            

            try { 
                $startTime = Carbon::createFromFormat('H:i', $startTime);
            } catch (\Exception $e){
                $startTime = Carbon::createFromFormat('H:i:s', $startTime);
            }

            try { 
                $endTime = Carbon::createFromFormat('H:i', $endTime);
            } catch (\Exception $e){
                $endTime = Carbon::createFromFormat('H:i:s', $endTime);
            }
            
            // Calculate the duration
            $this->duration = $endTime->diffInHours($startTime); // Duration in hours
            // $this->duration = $endTime->diffInMinutes($startTime); // Duration in minutes
        } else {
            $this->duration = null; // or any default value indicating no end time
        }
    }
    

    public function addAttend(){
        // try {
            $validatedData = $this->validate();

            if ($this->endTime) {
                // Convert the time strings into Carbon instances
                $startTime = Carbon::createFromFormat('H:i', $validatedData['startTime']);
                $endTime = Carbon::createFromFormat('H:i', $this->endTime);
                
                // Calculate the duration
                $this->duration = $endTime->diffInHours($startTime); // Duration in hours
                // If you want to get the duration in minutes, you can use diffInMinutes()
                // $duration = $endTime->diffInMinutes($startTime); // Duration in minutes
            } else {
                $this->endTime = null;
                $this->duration = null; // or any default value indicating no end time
            }

            $attend = Attendance::create([
                'user_id' => $validatedData['select_emp_data'],
                'start_time' => $validatedData['startTime'],
                'end_time' => $this->endTime ?? null,
                'duration' => $this->duration ?? 0,
                'date' => $validatedData['dateAttend'],
            ]);


            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramAttendNew(
                        $attend->id,
                        $validatedData['select_emp_data'],
                        $this->jobTitle,
                        $validatedData['startTime'],
                        $this->endTime,
                        $this->duration,
                        $validatedData['dateAttend'],

                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending INV Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Attend Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        // } catch (\Exception $e){
        //     $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        // }

        
    }

    public function editAttend(int $attendId){
        try {
            $attendEdit = Attendance::with('user.profile')->find($attendId);
            $this->attendUpdate = $attendId;
            $this->old_attend_data = [];

            if ($attendEdit) {
                $this->old_attend_data = null;
                // Client Information
                $this->select_emp_data =  $attendEdit->user_id;
                $this->jobTitle = $attendEdit->user->profile->job_title;
                $this->startTime = $attendEdit->start_time;
                $this->endTime = $attendEdit->end_time;
                $this->duration = $attendEdit->duration;
                $this->dateAttend = $attendEdit->date;

                $this->old_attend_data = [
                    'select_emp_data' =>  $attendEdit->user_id,
                    'jobTitle' => $attendEdit->user->profile->job_title,
                    'startTime' => $attendEdit->start_time,
                    'endTime' => $attendEdit->end_time,
                    'duration' => $attendEdit->duration,
                    'date' => $attendEdit->date,
                ];
            } else {
                return redirect()->to('own/attend');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT attend

    public function updateAttend(){
        try {
            $validatedData = $this->validate();

            Attendance::where('id', $this->attendUpdate)->update([
                'user_id' => $validatedData['select_emp_data'],
                'start_time' => $validatedData['startTime'],
                'end_time' => $this->endTime ?? null,
                'duration' => $this->duration ?? 0,
                'date' => $validatedData['dateAttend'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramattendUpdate(
                        $this->attendUpdate,
                        $validatedData['select_emp_data'],
                        $this->jobTitle,
                        $validatedData['startTime'],
                        $this->endTime,
                        $this->duration,
                        $validatedData['dateAttend'],

                        $this->old_attend_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }

            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('attend Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE attend

    public function deleteAttend(int $selected_attend_id){
        $this->del_attend_id = $selected_attend_id;
        $this->del_attend_data = Attendance::find($this->del_attend_id);
        if($this->del_attend_data){
            // $this->del_attend_name = $this->del_attend_data->attend_name;
            $this->del_attend_name = 'delete';
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE attend

    public function destroyAttend(){
        if ($this->confirmDelete && $this->attend_name_to_selete === $this->del_attend_name) {

            Attendance::find($this->del_attend_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramAttendDelete(
                        $this->del_attend_id,
                        $this->del_attend_data->user_id,
                        $this->del_attend_data->date,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            
            $this->del_attend_id = null;
            $this->del_attend_data = null;
            $this->del_attend_name = null;
            $this->attend_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('attend Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_attend_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->emp_data = '';
        $this->select_emp_data = '';
        $this->empName = '';
        $this->jobTitle = '';
        $this->startTime = '';
        $this->endTime = '';
        $this->dateAttend = '';
        $this->duration = '';

        $this->emp_data = User::orderBy('name', 'ASC')->get();
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal() {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public function resetFilter(){
        $this->search = null;
        $this->empFilter = '';
        $this->dateRange = null;
        $this->rangeViewValue = null;
        $this->startDate = null;
        $this->endDate = null;
    }

    public function applyDateRangeFilter() {
        // return $this->dateRange;
    }

    public $startDate ;
    public $endDate ; 
    public function render() {
        if ($this->dateRange) {
            list($this->startDate, $this->endDate) = explode(' - ', $this->dateRange);
        }

        $this->rangeViewValue = $this->startDate . ' - ' . $this->endDate . ' ';


        $colspan = 6;
        $cols_th = ['#','Employee Name', 'Start Time','End Time', 'Duration', 'Created Date', 'Actions'];
        $cols_td = ['id','user.name','start_time','end_time','duration','created_at'];

        $data = Attendance::with(['user'])
        ->where(function ($query) {
            $query->whereHas('user', function ($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orWhere('start_time', 'like', '%' . $this->search . '%')
            ->orWhere('end_time', 'like', '%' . $this->search . '%')
            ->orWhere('duration', 'like', '%' . $this->search . '%');
        })
        ->when($this->startDate && $this->endDate, function ($query) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        })
        ->when($this->empFilter !== '', function ($query) {
            $query->where(function ($query) {
                $query->where('user_id', $this->empFilter)
                    ->orWhereNull('user_id');
            });
        })
        ->orderBy('id', 'DESC')
        ->paginate(15);
        
        return view('livewire.fin.attendance-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}
