<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;


class ExpenseExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startDate;
    protected $endDate;
    protected $option;

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
        $sheet->getStyle('A1:G' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle('thin');
    
        // Auto-size columns
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        // Apply background color based on conditions
        $highestRow = $sheet->getHighestRow();
        foreach (range('F', 'G') as $column) {
            for ($row = 2; $row <= $highestRow; $row++) {
                $value = $sheet->getCell($column . $row)->getValue();
                $fillColor = null;

                switch ($column) {
                    case 'E':
                    case 'F':
                        $fillColor = ($value != null) ? 'e6b8b7' : null; // Red
                        break;
                    case 'G':
                        $fillColor = ($value == 'Active') ? 'd8e4bc' : 'e6b8b7'; // Green
                        break;
                }

                if ($fillColor) {
                    $sheet->getStyle($column . $row)->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
                    ]);
                }
            }
        }

        $dollarColumns = ['E']; // Columns for US Dollar
        $dinarColumns = ['F']; // Columns for Iraqi Dinar

        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            // Apply number format for US Dollar
            foreach ($dollarColumns as $column) {
                $sheet->getStyle($column . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD);
            }
            // Apply number format for Iraqi Dinar
            foreach ($dinarColumns as $column) {
                $sheet->getStyle($column . $row)->getNumberFormat()->setFormatCode('#,##0.00 "د.ع"');
            }
        }
    }
    public function __construct($startDate, $endDate, $option)
    {
        $this->startDate= $startDate; // 2024-01-01
        $this->endDate = $endDate; // 2024-02-10
        $this->option= $option; // 0
    }

    public function headings(): array
    {
        return [
            'ID', //nothing
            'Expense Date', //nothing
            'Type Expense', //nothing
            'Item', //nothing
            'Description', //nothing
            'Cost ($)', //nothing
            'Cost (IQD)', //nothing
            'Status', //nothing
        ];
    }

    public function collection()
    {
        $expenses = Expense::whereBetween('payed_date', [$this->startDate, $this->endDate])
        ->when($this->option == 0, fn ($query) => $query->where('type', 'Bill'))
        ->when($this->option == 1, fn ($query) => $query->where('type', 'Salary'))
        ->when($this->option == 2, fn ($query) => $query->where('type', 'Other'))
        ->get();

    $exportData = [];

    foreach ($expenses as $expense) {
        $payed_date = $expense->payed_date ?? '';
        $type = $expense->type ?? '';
        $item = $expense->item ?? '';
        $description = $expense->description ?? '';
        $costDollar = $expense->cost_dollar ?? '';
        $costIraqi = $expense->cost_iraqi ?? '';
        $status = $expense->status == 1 ? 'Active' : 'Non-Active';

        // Check the option and export accordingly
        $exportData[] = [
            'ID' => $expense->id ?? '',
            'Expense Date' => $payed_date ?? '',
            'Expense Type' => $type ?? '' ,
            'Expense Item' => $item ?? '',
            'Description' => $description ?? '',
            'Cost $' =>  $costDollar ?? '',
            'Cost IQD' =>  $costIraqi ?? '',
            'Status' =>  $status ?? '',
        ];
    }

    // Return or process the export data as needed
    return collect($exportData);
    }
    
}
