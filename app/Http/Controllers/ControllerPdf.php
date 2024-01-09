<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ControllerPdf extends Controller
{
    public function quotationPdf(int $quotationId)
    {
        return view('dashboard.pdf.pdfQuotation')->with(['quotationId' => $quotationId]);    
    }
    public function invoicePdf(int $invoiceId)
    {
        return view('dashboard.pdf.pdfInvoice')->with(['invoiceId' => $invoiceId]);    
    }
    public function cashPdf(int $cashId)
    {
        return view('dashboard.pdf.pdfCash')->with(['cashId' => $cashId]);    
    }
}
