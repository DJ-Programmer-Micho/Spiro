@php
  $invoiceEditasd = App\Models\Invoice::find($invoiceId);
  $imagePath = public_path('assets/dashboard/img/mainlogopdf.jpg');
  // $imagePath = "/home/metiszec/arnews.metiraq.com/assets/dashboard/img/mainlogopdf.jpg";
  $imageData = base64_encode(File::get($imagePath));
  $base64Image = 'data:image/jpeg;base64,' . $imageData;
  $data = [
    "img" => $base64Image,
    "invoiceId" => $invoiceEditasd->id,
    "client" => $invoiceEditasd->client->client_name ?? 'UnKnown',
    "email" => $invoiceEditasd->client->email ?? null,
    "country" => $invoiceEditasd->client->country ?? 'UnKnown',
    "city" => $invoiceEditasd->client->city ?? 'UnKnown',
    "phoneOne" => $invoiceEditasd->client->phone_one ?? 'UnKnown',
    "phoneTwo" => $invoiceEditasd->client->phone_two ?? 'UnKnown',
    "date" =>$invoiceEditasd->invoice_date ?? 'UnKnown',
    "total" => $invoiceEditasd->grand_total_dollar ?? 'UnKnown',
    "clientId" => $invoiceEditasd->client->id ?? 'UnKnown',
    "serviceData" => json_decode($invoiceEditasd->services,true) ?? 'XXX',
    "amountDollar" => $invoiceEditasd->total_amount_dollar ?? '$XXXX',
    "discount" => $invoiceEditasd->discount_dollar ?? '$XXXX',
    "grandDollar" => $invoiceEditasd->grand_total_dollar ?? '$XXXX',
    "notes" => $invoiceEditasd->notes ?? 'NO NOTES',
  ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$invoiceEditasd->id . '_' . $invoiceEditasd->client->client_name . '_' . now()->format('Y-m-d')}}</title>
    <style>
        html { margin: 0; margin-right: auto ; margin-left: auto ; height: 1123px; width: 794px; border: 1px solid #000; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; font-size: 0.8rem; font-family: 'Roboto', sans-serif;}
        /* .invoice-headr { display: flex; flex-direction: row; justify-content: space-between; } */
        .src-left { background-color: #ffffff; border-left: 1px solid black; border-right: 1px solid black; font-size: 0.7rem; font-style: italic;}
        .catgory { font-weight: 1000; font-size: 0.9rem; text-decoration: underline;}
        .src-right { background-color: #ffffff; border-right: 1px solid black; font-size: 0.7rem; font-style: italic;}
        .src { background-color: #ffffff; border-right: 1px solid black; font-size: 0.7rem; font-style: italic;}
        .src-heading { background-color: #cccccc; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; }
        .invoice-box table tr.invoiceheading td { border-bottom: 6px solid #2bb673; font-weight: bold; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
        .invoice-box table td { padding: 1px; }
        .invoice-box table tr.heading td { border-bottom: 1px solid #000; border-top: 1px solid #000; font-weight: bold; }
        .invoice-box table tr.total td { border-bottom: 1px solid #000; border-top: 1px solid #000; font-weight: bold; }
        .companyheading { margin-bottom: 0; text-transform: uppercase; }
        .header-subheading { margin: 0; }
        .customername { text-transform: uppercase; }
        .right { text-align: right; }
        .opening-balance-text { padding-top: 20px; }
        .disclaimer-text { padding-top: 20px; font-size: 0.6rem;}
        .invoice-headr { display: block; margin-bottom: 90px;}
        .headerdiv { float: left; }
        .headerinvoicediv { float: right; }
        .invoice-summary { text-align: right; margin-top: 2px;}
        td { font-size: 12px }
        @media print {
            .print-button {
                display: none;
            }

            html {
              border: none;
            }

            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>
</head>


<body style="font-family: ScheherazadeNew;">
  <div class="invoice-box">
     <div class="flex-invoicesubheader">
       <table>
         <tr class="invoiceheading">
           <td colspan=2>
             <div class="invoice-headr">
               <div class="headerdiv">
                 <img src="{{$data['img']}}" alt="logo" width="80px">
                 {{-- <img src="{{asset('assets/dashboard/img/mainlogopdfc.jpg')}}" alt="logo" width="80px"> --}}
               </div>
               <div class="headerinvoicediv">
                 {{-- <h2 class="companyheading"> OTO-9171</h2> --}}
                 <h3 class="header-subheading">{{__('Invoice')}}</h3>
                 <h4 class="header-subheading">{{now()->format('y-m-d')}}</h4>
               </div>
             </div>
           </td>
         </tr>
         <tr>
           <td style="padding-top: 15px; vertical-align: top; font-size: 15px">
             <div class="headerdiv-customer">
               <div class="sub-customerinfo">Client Name: <b>{{$data['client']}}</b></div>
               <div class="sub-customerinfo">Country & City: {{$data['country']}} / {{$data['city']}}</div>
               @if ($data['email'])
               <div class="sub-customerinfo">Email Address: {{$data['email']}}</div>
               @endif
               <div class="sub-customerinfo">Phone Number 1: {{$data['phoneOne']}}</div>
               @if ($data['phoneTwo'])
               <div class="sub-customerinfo">Phone Number 2: {{$data['phoneTwo']}}</div>
               @endif
             </div>
           </td>
           <td style="padding-top: 15px; vertical-align: top;">
             <div class="ng-star-inserted">
               <div class="date ng-star-inserted" style="text-align: right;"><b>Invoice Date: {{$data['date']}}</b></div>
               <div class="date" style="text-align: right;">Invoice ID: #INV-{{$data['invoiceId']}}</div>
               <div class="date" style="text-align: right;">Client ID: #CL-{{$data['clientId']}}</div>
             </div>
             {{-- <div>
               <div class="date" style="text-align: right;"><b>Invoice ID: {{$invoiceID ?? '#INV-00'}}</b></div>
               <div class="date" style="text-align: right;">$44.00</div>
             </div> --}}
           </td>
         </tr>
       </table>
     </div>
     <div>
       @foreach ($data['serviceData'] as $headerInfo)

       <div style="margin-top: 15px"></div>
       <table cellpadding="0" cellspacing="0">
         <tr>
           <td colspan="1" class="src-heading" style="text-align:center; ">
             DATE : {{$headerInfo['actionDate']}}
           </td>
           <td colspan="5" class="src-heading" style="text-align:center; ">
             TITLE : {{$headerInfo['description']}}
           </td>
         </tr>
         <tr class="heading">
           <td>
             {{__('SERVICE CODE')}}
           </td>
           <td>
             {{__('SERVICE NAME')}}
           </td>
           <td>
             {{__('DESCRIPTION')}}
           </td>
           <td>
             {{__('PRICE')}}
           </td>
           <td class="center">
             {{__('QTY')}}
           </td>
           <td class="right">
             {{__('AMOUNT')}}
           </td>
         </tr>
         @foreach ($headerInfo['services'] as $service)
         @php
           $tempServiceName = App\Models\Service::find($service['select_service_data'])->service_name;
         @endphp
 
         <tr class="item">
           <td> {{$service['serviceCode']}} </td>
           <td> {{$tempServiceName}} </td>
           <td> {{$service['serviceDescription']}}</td>
           <td> $ {{number_format($service['serviceDefaultCostDollar'])}} </td>
           <td class="center"> {{$service['serviceQty']}} </td>
           <td class="right">$ {{number_format($service['serviceTotalDollar']) }} </td>
         </tr>
         @endforeach
       </table>
       @endforeach
     </div>
     <div class="invoice-summary" style="margin-left: auto;">
       <table style="width:50%;" border>
         <tbody>
           @if($data['discount'])
           <tr>
             <td style="font-size:13px; font-weight: 600;"> {{__('Total Amount')}} </td>
             <td class="right">$ {{number_format($data['amountDollar']) }} </td>
           </tr>
           {{-- <tr>
             <td style="font-size:13px; font-weight: 600; "> {{__('TAX')}} </td>
             <td class="right"> {{$tax }} </td>
           </tr> --}}
     
           <tr>
             <td style="font-size:13px; font-weight: 600; color: #cc0022"> {{__('Discount')}} </td>
             <td class="right" style=" color: #cc0022">$ {{number_format($data['discount']) }} </td>
           </tr>
           @endif
           <tr>
             <td style="font-size:13px; font-weight: 600;"> {{__('Net Cost')}} </td>
             <td class="right">$ {{number_format($data['grandDollar']) }} </td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="flex-invoicesubheader">
       <table>
         <tbody>
           <tr>
             <h3 class="disclaimer-text">{{__('NOTES:')}}</h3>
             <textarea readonly id="notesTextArea" style="width: 100%; overflow: hidden;"></textarea>
           </tr>
           <tr>
             <div class="opening-balance-text" style="text-align:center;"> {{__('THANK YOU FOR YOUR BUSINESS')}} </div>
           </tr>
     </tbody>
 </table>
 <div style="position: absolute; bottom: 100px; display: flex; width: 100%;">
   <div style="width: 20%; margin-left: 40px;">
     <h3 class="disclaimer-text" style="text-align: center; border-bottom: 1px solid #000;">{{__('Prepared By:')}}</h3>
   </div>
   <div style="width: 20%; margin-left: 240px;">
     <h3 class="disclaimer-text" style="text-align: center; border-bottom: 1px solid #000;">{{__('Client Signature:')}}</h3>
   </div>
 </div>
 
</div>
</div>
<div style="position: fixed; top:150px; right: 0px;">
<button class="print-button" onclick="printPDF()">Print / Print Preview</button>
</div>
<script>
var notesTextArea = document.getElementById('notesTextArea');
notesTextArea.value = `{{$data['notes']}}`;

function autoExpandTextarea() {
   notesTextArea.style.height = 'auto';
   notesTextArea.style.height = (notesTextArea.scrollHeight) + 'px';
}

notesTextArea.addEventListener('input', autoExpandTextarea);
// Trigger initial height adjustment
window.addEventListener('DOMContentLoaded', autoExpandTextarea);
</script>
<script>
function printPDF() {
   window.print();
}
</script>
<script>
window.onload = (event) => {
 window.print();
};
</script>
{{-- @php
dd($serviceData, $headerInfo, $headerInfo['actionDate'], $headerInfo['services'], $service['serviceCode']);
@endphp --}}
{{-- <img src="http://barcode.pinonclick.com/barcode?code=413075" /> --}}
</body>
</html>