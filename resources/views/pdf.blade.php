<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            font-size: 0.8rem;
            font-family: 'Roboto', sans-serif;
        }

        .invoice-headr {
            display: flex;
            flex-direction: rows;
            justify-content: space-between;
        }

        .src-left {
            background-color: #fffff;
            border-left: 1px solid black;
            border-right: 1px solid black;
            font-size: 0.7rem;
            font-style: italic;
        }

        .catgory {
            font-weight: 1000;
            font-size: 0.9rem;
            text-decoration: underline;

        }

        .src-right {
            background-color: #fffff;
            border-right: 1px solid black;
            font-size: 0.7rem;
            font-style: italic;
        }

        .src {
            background-color: #fffff;
            border-right: 1px solid black;
            font-size: 0.7rem;
            font-style: italic;
        }


        .src-heading {
            background-color: #cccccc;
            border-top: 1px solid black;
            border-right: 1px solid black;
            border-left: 1px solid black;
        }

        .invoice-box table tr.invoiceheading td {
            border-bottom: 6px solid #2bb673;
            font-weight: bold;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
        }

        .invoice-box table tr.heading td {
            border-bottom: 1px solid #000;
            border-top: 1px solid #000;
            font-weight: bold;
        }

        .invoice-box table tr.total td {
            border-bottom: 1px solid #000;
            border-top: 1px solid #000;
            font-weight: bold;
        }

        .companyheading {
            margin-bottom: 0;
            text-transform: uppercase;
        }

        .header-subheading {
            margin: 0;
        }

        .customername {
            text-transform: uppercase;
        }

        .right {
            text-align: right;
        }

        .invoice-summary {
            display: flex;
            justify-content: flex-end;
            margin-top: 2px;
            margin-right: 0px
        }

        .opening-balance-text {
            padding-top: 20px;
        }

        .disclaimer-text {
            padding-top: 40px;
            font-size: 0.6rem;
        }
    </style>
</head>
<body>


    {{-- <p>#INV-{{$invoiceId ?? 00}}</p>
    <p>Client Name: {{$client ?? 'UnKnown'}}</p>
    <p>Date: {{$date ?? '2024-01-01'}}</p>
    <p>Total Amout: $ {{number_format($total ?? 30000)}}</p>
     --}}
    
     <div class="invoice-box">
        <div class="flex-invoicesubheader">
          <table>
            <tr class="invoiceheading">
              <td colspan=2>
                <div class="invoice-headr">
                  <div class="headerdiv">
                    <img src="{{asset('assets/dashboard/img/mainlogo.png')}}" alt="logo" width="80px">
                    {{-- <h2 class="companyheading"> QUICKSTOP </h2>
                    <small>Houston Texas</small><br>
                    <small>Tobacco Id: 1212323  Tax ID: 2222-44434-3343434</small> --}}
                  </div>
                  <div class="headerinvoicediv">
                    <h2 class="companyheading"> OTO-9171</h2>
                    <h3 class="header-subheading">16 May, 2019</h3>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td style="padding-top: 15px; vertical-align: top;">
                <div class="headerdiv-customer">
                  <div class="sub-customerinfo"><b>{{$client ?? 'UnKnown'}}</b></div>
                  <div class="customername">{{$country ?? 'Country'}} / {{$city ?? 'City'}}</div>
                  <div class="sub-customerinfo">{{$email ?? 'Email'}}</div>
                  <div class="sub-customerinfo">{{$phoneOne ?? '+964'}}</div>
                  <div class="sub-customerinfo">{{$phoneTwo ?? '+964'}}</div>
                </div>
              </td>
              <td style="padding-top: 15px; vertical-align: top;">
                <div class="ng-star-inserted">
                  <div class="date ng-star-inserted" style="text-align: right;"><b>Date: {{$date ?? '2024-01-01'}}</b></div>
                  <div class="date" style="text-align: right;">Invoice ID: {{$invoiceId ?? '#INV-00'}}</div>
                  <div class="date" style="text-align: right;">Client ID: {{$clientId ?? '#CLI-00'}}</div>
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
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td></td>
              <td></td>
              <td class="right"></td>
              <td colspan="5" class="src-heading" style="text-align:center; ">
                {{__('Payment Information')}}
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
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            <tr class="item">
              <td> {{$serviceCode ?? '#XXX'}} </td>
              <td> {{$serviceName ?? 'Service Name'}} </td>
              <td> {{$serviceDesc ?? 'Description'}}</td>
              <td> {{$unitPrice ?? '$XXXX'}} </td>
              <td class="center"> {{$qty ?? 'XX'}} </td>
              <td class="right"> {{$amount ?? '$XXXX'}} </td>
            </tr>
            
          </table>
        </div>
        <div class="invoice-summary">
          <table style="width:30%">
            <thead>
    
            </thead>
            <tbody>
              <tr>
                <td style="font-size:13px; font-weight: 600;"> {{__('Grand Total')}} </td>
                <td class="right"> {{$amountDollar ?? '$XXXX'}} </td>
              </tr>
              <tr>
                <td style="font-size:13px; font-weight: 600; "> {{__('TAX')}} </td>
                <td class="right"> {{$tax ?? '$XXXX'}} </td>
              </tr>
              <tr>
                <td style="font-size:13px; font-weight: 600; "> {{__('Discount')}} </td>
                <td class="right"> {{$discount ?? '$XXXX'}} </td>
              </tr>
              <tr>
                <td style="font-size:13px; font-weight: 600;"> {{__('Net Cost')}} </td>
                <td class="right"> {{$grandDollar ?? '$XXXX'}} </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="flex-invoicesubheader">
          <table>
            <tbody>
              <tr>
                <div class="opening-balance-text" style="text-align:center;"> {{__('THANK YOU FOR YOUR BUSINESS')}} </div>
              </tr>
    
              <tr>
                <h3 class="disclaimer-text">{{__('NOTES:')}}</h3>
                <ul>
                    <li>Payment in Advance</li>
                    <li>No Refunds</li>
                </ul>
    
                {{-- <img src="http://barcode.pinonclick.com/barcode?code=413075" /> --}}
              </tr>
              <tr class="">
                <td style="text-align: center;">
                    <h3 class="disclaimer-text" style="text-align: center; border-bottom: 1px solid #000;">{{__('Prepared By:')}}</h3>
                </td>
                <td style="text-align: center;">
                    <h3 class="disclaimer-text" style="text-align: center; border-bottom: 1px solid #000;">{{__('Client Signature:')}}</h3>
                </td>    
            </tr>
        </tbody>
    </table>
</div>
</div>

{{-- <img src="http://barcode.pinonclick.com/barcode?code=413075" /> --}}
</body>
</html>