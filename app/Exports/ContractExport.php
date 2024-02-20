<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;


class ContractExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startDate;
    protected $endDate;
    protected $invoiceId;
    // protected $companyName;
    protected $option;
    protected $clientName;

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:O1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
    
        // Example: Set a border for all cells
        $sheet->getStyle('A1:N' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle('thin');
    
        // Auto-size columns
        foreach (range('A', 'N') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        // Apply background color based on conditions
        $highestRow = $sheet->getHighestRow();
        foreach (range('G', 'N') as $column) {
            for ($row = 2; $row <= $highestRow; $row++) {
                $value = $sheet->getCell($column . $row)->getValue();
                $fillColor = null;

                switch ($column) {
                    case 'G':
                        $fillColor = ($value != null) ? 'e6b8b7' : null; // Red
                        break;
                    case 'K':
                        $fillColor = ($value != null) ? 'e6b8b7' : null; // Red
                        break;
                    case 'H':
                    case 'L':
                        $fillColor = ($value != null) ? 'd8e4bc' : null; // Green
                        break;
                    case 'I':
                        $fillColor = ($value != null) ? 'c4bd97' : null; // Yellow
                        break;
                    case 'M':
                    case 'N':
                        $fillColor = ($value != null) ? '8db4e2' : null; // Blue
                        break;
                }

                if ($fillColor) {
                    $sheet->getStyle($column . $row)->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
                    ]);
                }
            }
        }

        $dollarColumns = ['I', 'G', 'F','E', 'M']; // Columns for US Dollar
        $dinarColumns = ['K', 'L', 'J', 'N']; // Columns for Iraqi Dinar

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
    public function __construct($startDate, $endDate, $invoiceId, $companyName, $option, $clientName)
    {
        $this->startDate= $startDate; // 2024-01-01
        $this->endDate = $endDate; // 2024-02-10
        $this->invoiceId= $invoiceId; // 1
        // $this->companyName= $companyName; // 8
        $this->option= $option; // 0
        $this->clientName= $clientName; // 7
    }

    public function headings(): array
    {
        return [
            'ID', //nothing
            'Quotation ID', //nothing
            // 'Company Name', //nothing
            'Client Name', //nothing
            'Invoice Date', //nothing
            'Title', //nothing
            'Total Amount ($)', 
            'Discount ($)',   //red
            'Grand Total ($)', //green
            'Exchange Rate', // yellow
            'Total Amount (IQD)', //nothing
            'Discount (IQD)', //red
            'Grand Total (IQD)', //green
            'Due ($)', // blue
            'Due (IQD)', // blue
        ];
    }

    public function collection()
    {
        // $invoices = Invoice::with(['client.company', 'quotation', 'cashes'])
        $invoices = Invoice::with(['client', 'quotation', 'cashes'])
        ->whereBetween('invoice_date', [$this->startDate, $this->endDate])
        ->when($this->invoiceId !== 'none', function ($query) {
            $query->where('id', $this->invoiceId);
        })
        // ->when($this->companyName && $this->companyName !== 'none', function ($query) {
        //     $query->whereHas('client.company', function ($subQuery) {
        //         $subQuery->where('id', 'like', '%' . $this->companyName . '%');
        //     });
        // })
        ->when($this->clientName && $this->clientName !== 'none', function ($query) {
            $query->whereHas('client', function ($subQuery) {
                $subQuery->where('id', 'like', '%' . $this->clientName . '%');
            });
        })
        ->when($this->option == 1, function ($query) {
            // Filter only invoices with due (either in cashes or not created cashes yet)
            $query->whereHas('cashes', function ($subQuery) {
                $subQuery->where('due_dollar', '==', 0);
            });
        })
        ->when($this->option == 2, function ($query) {
            // Filter only invoices without due (in cashes or using grand_total_dollar)
            $query->whereHas('cashes', function ($subQuery) {
                $subQuery->where('due_dollar', '>', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('grand_total_dollar', '>', 0)
                    ->doesntHave('cashes');
            });
        })
        ->get();

    $exportData = [];

    foreach ($invoices as $invoice) {
        $quotationId = optional($invoice->quotation)->id ?? '';
        // $companyName = optional(optional($invoice->client)->company)->company_name ?? '';
        $clientName = optional($invoice->client)->client_name ?? '';
        $invoiceDate = $invoice->invoice_date ?? '';
        $title = $invoice->description ?? '';
        $totalAmountDollar = $invoice->total_amount_dollar ?? '';
        $totalDiscaountDollar = $invoice->discount_dollar ?? '';
        $grandTotalDollar = $invoice->grand_total_dollar ?? '';
        $exchangeRate = $invoice->exchange_rate ?? '';
        $totalAmountIraqi = $invoice->total_amount_iraqi ?? '';
        $totalDiscaountIraqi = $invoice->discount_iraqi ?? '';
        $grandTotalIraqi = $invoice->grand_total_iraqi ?? '';

        $hasCash = $invoice->cashes->isNotEmpty();
        $dueAmountDollar = $hasCash ? $invoice->cashes->sum('due_dollar') : $invoice->grand_total_dollar;
        $dueAmountIraqi = $hasCash ? $invoice->cashes->sum('due_iraqi') : $invoice->grand_total_iraqi;

        // Check the option and export accordingly
        $exportData[] = [
            'ID' => $invoice->id ?? '',
            'Quotation ID' => $quotationId, 
            // 'Company Name' => $companyName,
            'Client Name' => $clientName,
            'Invoice Date' => $invoiceDate,
            'Title' => $title,
            'Total Amount $' =>  $totalAmountDollar,
            'Discount $' =>  $totalDiscaountDollar,
            'Grand Total $' =>  $grandTotalDollar,
            'Exchange Rate' => $exchangeRate,
            'Total Amount IQD' => $totalAmountIraqi,
            'Discount IQD' => $totalDiscaountIraqi,
            'Grand Total IQD' => $grandTotalIraqi,
            'Due Amount $' => $dueAmountDollar ?? 0,
            'Due Amount IQD' => $dueAmountIraqi ?? 0,
        ];
    }

    // Return or process the export data as needed
    return collect($exportData);
    }
    
}
