<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;


class AttendaceExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startDate;
    protected $endDate;
    protected $search;
    protected $empFilter;

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
    
        // Example: Set a border for all cells
        $sheet->getStyle('A1:H' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle('thin');
    
        // Auto-size columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        // Apply background color based on conditions
        $highestRow = $sheet->getHighestRow();
        foreach (range('E', 'G') as $column) {
            for ($row = 2; $row <= $highestRow; $row++) {
                $value = $sheet->getCell($column . $row)->getValue();
                $fillColor = null;

                switch ($column) {
                    case 'E':
                        $fillColor = ($value != null) ? 'd8e4bc' : null; // Green
                        break;
                    case 'F':
                        $fillColor = ($value != null) ? 'c4bd97' : null; // Yellow
                        break;
                        case 'G':
                            if ($value !== null) {
                                if ($value >= 0 && $value <= 4) {
                                    $fillColor = 'e6b8b7';
                                } elseif ($value > 4) {
                                    $fillColor = '8db4e2';
                                } else {
                                    // Handle any other cases here
                                    $fillColor = null;
                                }
                            } else {
                                $fillColor = null;
                            }
                            break;
                }

                if ($fillColor) {
                    $sheet->getStyle($column . $row)->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
                    ]);
                }
            }
        }
    }
    public function __construct($startDate, $endDate, $search, $empFilter)
    {
        $this->startDate= $startDate; // 2024-01-01
        $this->endDate = $endDate; // 2024-02-10
        $this->search = $search;
        $this->empFilter = $empFilter;

    }

    public function headings(): array
    {
        return [
            'ID', //nothing
            'Employee ID', //nothing
            'Employee Name', //nothing
            'Job Title', //nothing
            'Start Time', //nothing
            'End Time', //nothing
            'Duration', 
            'Date',   //red
        ];
    }

    public function collection()
    {
        $attends = Attendance::with(['user.profile', 'user'])
        ->whereBetween('date', [$this->startDate, $this->endDate])
        ->when($this->search && $this->search !== 'none', function ($query) {
            $query->whereHas('user', function ($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->empFilter !== '', function ($query) {
            $query->where('user_id', $this->empFilter)
                  ->orWhereNull('user_id');
        })
        ->orderBy('date', 'ASC')
        ->get();
    
    $exportData = [];
    
    foreach ($attends as $attend) {
        $empId = $attend->user->id ?? '';
        $empName = optional($attend->user)->name ?? '';
        $jobTitle = optional($attend->user->profile)->job_title ?? '';
        $startTime = $attend->start_time ?? '';
        $endTime = $attend->end_time ?? '';
        $duration = $attend->duration ?? '';
        $date = $attend->date ?? '';
    
        // Check the option and export accordingly
        $exportData[] = [
            'ID' => $attend->id ?? '',
            'Employee ID' => $empId, 
            'Employee Name' => $empName,
            'Job Title' => $jobTitle,
            'Start Time' => $startTime,
            'End Time' => $endTime,
            'Duration' =>  $duration,
            'Date' =>  $date,
        ];
    }
    
    // Return or process the export data as needed
    return collect($exportData);
    }
    
}
