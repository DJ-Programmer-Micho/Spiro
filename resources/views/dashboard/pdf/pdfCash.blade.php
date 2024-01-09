@php
  $cashEditasd = App\Models\Cash::find($cashId);
  $imagePath = public_path('assets/dashboard/img/mainlogopdf.jpg');
  // $imagePath = "/home/metiszec/arnews.metiraq.com/assets/dashboard/img/mainlogopdf.jpg";
  $imageData = base64_encode(File::get($imagePath));
  $base64Image = 'data:image/jpeg;base64,' . $imageData;

  $lastPayment = json_decode($cashEditasd->payments,true);
  $amount = end($lastPayment)['paymentAmountDollar'];

  $data = [
    "img" => $base64Image,
    "cashId" => $cashEditasd->id,
    "client" => $cashEditasd->invoice->client->client_name ?? 'UnKnown',
    "email" => $cashEditasd->invoice->client->email ?? null,
    "country" => $cashEditasd->invoice->client->country ?? 'UnKnown',
    "city" => $cashEditasd->invoice->client->city ?? 'UnKnown',
    "phoneOne" => $cashEditasd->invoice->client->phone_one ?? 'UnKnown',
    "phoneTwo" => $cashEditasd->invoice->client->phone_two ?? 'UnKnown',
    "invoice_id" => $cashEditasd->invoice->id ?? 'UnKnown',
    "invoice_title" => $cashEditasd->invoice->description ?? 'UnKnown',
    "invoice_date" => $cashEditasd->invoice->invoice_date ?? 'UnKnown',
    "cash_date" => $cashEditasd->cash_date ?? 'UnKnown',
    "total" => $amount ?? 0,
    "due" => $cashEditasd->due_dollar ?? 0,
    "clientId" => $cashEditasd->invoice->client->id ?? 'UnKnown',
    "paymentData" => json_decode($cashEditasd->payments,true) ?? 'XXX',
    "notes" => $cashEditasd->invoice->notes ?? "XXXX"
  ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$cashEditasd->id . '_' . $cashEditasd->invoice->client->client_name . '_' . now()->format('Y-m-d')}}</title>
    <style>
        html { margin: 0; margin-right: auto ; margin-left: auto ; height: 1123px; width: 794px; border: 1px solid #000; }

        .invoice-box { max-width: 800px; margin: auto; padding: 20px; font-size: 0.8rem; font-family: 'Roboto', sans-serif;}
        .src-left { background-color: #ffffff; border-left: 1px solid black; border-right: 1px solid black; font-size: 0.7rem; font-style: italic;}
        .catgory { font-weight: 1000; font-size: 0.9rem; text-decoration: underline;}
        .src-right { background-color: #ffffff; border-right: 1px solid black; font-size: 0.7rem; font-style: italic;}
        .src { background-color: #ffffff; border-right: 1px solid black; font-size: 0.7rem; font-style: italic;}
        .src-heading { background-color: #cccccc; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; }
        .invoice-box table tr.invoiceheading td { border-bottom: 6px solid #2bb673; font-weight: bold; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
        .invoice-box table td { padding: 5px; }
        .invoice-box table tr.heading td { border-bottom: 1px solid #000; border-top: 1px solid #000; font-weight: bold; }
        .invoice-box table tr.total td { border-bottom: 1px solid #000; border-top: 1px solid #000; font-weight: bold; }
        .companyheading { margin-bottom: 0; text-transform: uppercase; }
        .header-subheading { margin: 0; }
        .customername { text-transform: uppercase; }
        .right { text-align: right; }        .opening-balance-text { padding-top: 20px; }
        .disclaimer-text { padding-top: 20px; font-size: 0.6rem}

/* For .invoice-headr */
.invoice-headr {
    display: block;
    margin-bottom: 90px;
}

/* Floats for .headerdiv and .headerinvoicediv */
.headerdiv {
    float: left;
}

.headerinvoicediv {
    float: right;
}

/* For .invoice-summary */
.invoice-summary {
    text-align: right;
    margin-top: 2px;
    margin-right: 0px;
    clear: both; /* Clear the float */
}
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

<body>
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
                    <h3 class="header-subheading">{{__('Quotation')}}</h3>
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
                  <div class="date ng-star-inserted" style="text-align: right;"><b>Invocie Date: {{$data['invoice_date']}}</b></div>
                  <div class="date ng-star-inserted" style="text-align: right;"><b>Cash Receipt Date: {{$data['cash_date']}}</b></div>
                  <div class="date" style="text-align: right;">Cash Receipt ID: #CR-{{$cashId}}</div>
                  <div class="date" style="text-align: right;">Client ID: #CL-{{$data['clientId']}}</div>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <div>
        <div style="margin: 20px auto 20px auto; background-color: #ffd7ae; width: 90%; height: 200px; border: 2px solid #000;">
          <div style="padding: 0 10px 0 10px; font-weight: bold; font-size: 20px; margin: 5px 0 0 0">
            <p style="
              width: 100%; 
              letter-spacing: 0;
              font-size: 24px;
              margin: 0;
              ">Received From: <span style="text-decoration: underline; width: 100%">{{$data['client']}}</span>
              <br>
              For: <span style="text-decoration: underline; width: 100%">{{$data['invoice_title']}}</span></p>
          </div>
          <div style="padding: 0 10px 0 10px; font-weight: bold; font-size: 16px; margin: 48px 0 4px 0">
            <h3>Amount Piad: <span 
              style="
                text-decoration: underline; 
                width: 100%; 
                margin-top: 0; 
                margin-bottom: 0; 
                letter-spacing: 0"
              >$ {{number_format($data['total'])}}</span>
            </h3>
          </div>
          <div style="padding: 0 2px 0 10px; color: #cc0022; font-weight: bold; font-size: 16px;">
            <h3>Amount Due: <span style="                
              text-decoration: underline; 
              width: 100%; 
              margin-top: 30px; 
              margin-bottom: 0; 
              letter-spacing: 0">$ {{number_format($data['due'])}}</span>
              </h3>
          </div>

        </div>
        <div>
          <div style="margin-top: 25px"></div>
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="3" class="src-heading" style="text-align:center; ">
                {{__('Previuos Payments')}}
              </td>
            </tr>
            <tr class="heading">
              <td>
               {{__('No.')}}
              </td>
              <td>
               {{__('Date')}}
              </td>
              <td>
                {{__(('Amount'))}}
              </td>
            </tr>
            @foreach ($data['paymentData'] as $index => $payments)
            <tr class="item">
              <td>#No-{{$index + 1}} </td>
              <td>{{$payments['payment_date']}} </td>
              <td>$ {{number_format($payments['paymentAmountDollar'])}} </td>
            </tr>
            @endforeach
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
      // window.print();
  };
  </script>
{{-- <img src="http://barcode.pinonclick.com/barcode?code=413075" /> -- --}}
</body>
</html>