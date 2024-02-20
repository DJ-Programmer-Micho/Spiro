<?php

namespace App\Exports;

use App\Models\Cash;
use App\Models\Invoice;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class CashExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startDate;
    protected $endDate;
    protected $cashId;
    // protected $companyName;
    protected $option;
    protected $clientName;

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
    
        // Example: Set a border for all cells
        $sheet->getStyle('A1:L' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle('thin');
    
        // Auto-size columns
        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        // Apply background color based on conditions
        $highestRow = $sheet->getHighestRow();
        foreach (range('E', 'L') as $column) {
            for ($row = 2; $row <= $highestRow; $row++) {
                $value = $sheet->getCell($column . $row)->getValue();
                $fillColor = null;

                switch ($column) {
                    case 'G':
                    case 'K':
                        $fillColor = ($value != null) ? 'e6b8b7' : null; // Red 
                        break;
                    case 'F':
                    case 'J':
                        $fillColor = ($value != null) ? 'd8e4bc' : null; // Green
                        break;
                    case 'H':
                        $fillColor = ($value != null) ? 'c4bd97' : null; // Yellow
                        break;
                    case 'E':
                        $fillColor = ($value != null) ? '8db4e2' : null; // Blue
                        break;
                    case 'I':
                        $fillColor = ($value != null) ? '8db4e2' : null; // Blue
                        break;
                    case 'L':
                        if ($value !== null) {
                            if ($value >= 0 && $value <= 49) {
                                $fillColor = 'e6b8b7';
                            } elseif ($value >= 50 && $value <= 79) {
                                $fillColor = 'c4bd97';
                            } elseif ($value >= 80 && $value <= 99) {
                                $fillColor = '8db4e2';
                            } elseif ($value == 100) {
                                $fillColor = 'd8e4bc';
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

        $dollarColumns = ['E', 'F', 'G','H',]; // Columns for US Dollar
        $dinarColumns = ['I', 'J', 'K',]; // Columns for Iraqi Dinar

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
    public function __construct($startDate, $endDate, $cashId, $companyName, $option, $clientName)
    {
        $this->startDate= $startDate; // 2024-01-01
        $this->endDate = $endDate; // 2024-02-10
        $this->cashId= $cashId; // 1
        // $this->companyName= $companyName; // 8
        $this->option= $option; // 0
        $this->clientName= $clientName; // 7
    }

    public function headings(): array
    {
        return [
            'ID', //nothing
            'Invoice ID', //nothing
            'Cash Date', //nothing
            'Client Name', //nothing
            // 'Company Name', //nothing
            'Grand Total ($)', //green
            'Paid ($)', //green
            'Due ($)', // blue
            'Exchange Rate', // yellow
            'Grand Total (IQD)', //green
            'Paid (IQD)', //green
            'Due (IQD)', // blue
            'Process (%)',
        ];
    }

    public function collection()
    {

        $cashes = Cash::with(['client', 'invoice'])
    ->whereBetween('cash_date', [$this->startDate, $this->endDate])
    ->when($this->cashId !== 'none', function ($query) {
        $query->where('id', $this->cashId);
    })
    // ->when($this->companyName && $this->companyName !== 'none', function ($query) {
    //     $query->whereHas('invoice.client.company', function ($subQuery) {
    //         $subQuery->where('id', 'like', '%' . $this->companyName . '%');
    //     });
    // })
    ->when($this->clientName && $this->clientName !== 'none', function ($query) {
        $query->whereHas('invoice.client', function ($subQuery) {
            $subQuery->where('id', 'like', '%' . $this->clientName . '%');
        });
    })
    ->when($this->option == 1, function ($query) {
        // Filter only invoices with due (either in cashes or not created cashes yet)
        $query->whereHas('invoice.cashes', function ($subQuery) {
            $subQuery->where('due_dollar', 0);
        });
    })
    ->when($this->option == 2, function ($query) {
        // Filter only invoices without due (in cashes or using grand_total_dollar)
        $query->whereHas('invoice.cashes', function ($subQuery) {
            $subQuery->where('due_dollar', '>', 0);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('grand_total_dollar', '>', 0)
                ->doesntHave('invoice.cashes');
        });
    })
    ->get();


        $exportData = [];

        foreach ($cashes as $cash) {
            $invoiceId = optional($cash->invoice)->id ?? '';
            $clientName = optional($cash->invoice->client)->client_name ?? '';
            // $companyName = optional(optional($cash->invoice->client)->company)->company_name ?? '';
            $cashDate = $cash->cash_date ?? '';
            $grandTotalDollar = $cash->grand_total_dollar ?? '';
            $dueAmountDollar = $cash->due_dollar ?? '';
            $paidDollar = ($grandTotalDollar - $dueAmountDollar) ?? '';
            $exchangeRate = $cash->invoice->exchange_rate ?? '';
            $grandTotalIraqi = $cash->grand_total_iraqi ?? '';
            $dueAmountIraqi = $cash->due_iraqi ?? '';
            $paidIraqi = ($grandTotalIraqi - $dueAmountIraqi) ?? '';

            // Check the option and export accordingly
        $exportData[] = [
            'ID' => $cash->id ?? '',
            'Invoice ID' => $invoiceId, 
            'Cash Date' => $cashDate,
            'Client Name' => $clientName,
            // 'Company Name' => $companyName,
            'Grand Total $' =>  $grandTotalDollar ?? 0,
            'Paid $' =>  $paidDollar ?? 0,
            'Due Amount $' => $dueAmountDollar ?? 0,
            'Exchange Rate' => $exchangeRate,
            'Grand Total IQD' => $grandTotalIraqi ?? 0,
            'Paid IQD' =>  $paidIraqi ?? 0,
            'Due Amount IQD' => $dueAmountIraqi ?? 0,
            'Process %' => ($paidDollar / $grandTotalDollar) * 100,
        ];
    }

    // Return or process the export data as needed
    return collect($exportData);
    }
    
}
