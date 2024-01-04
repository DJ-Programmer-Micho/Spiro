<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page { margin:0px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; font-size: 0.8rem; font-family: 'Roboto', sans-serif;}
        /* .invoice-headr { display: flex; flex-direction: row; justify-content: space-between; } */
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
        .right { text-align: right; }
        /* .invoice-summary { display: flex; justify-content: flex-end; margin-top: 2px; margin-right: 0px } */
        .opening-balance-text { padding-top: 20px; }
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
                    <img src="{{asset('assets/dashboard/img/mainlogo.png')}}" alt="logo" width="80px">
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
                  <div class="sub-customerinfo"><b>client</b></div>
                  <div class="customername">country / city</div>
                  <div class="sub-customerinfo">email</div>
                  <div class="sub-customerinfo">phoneOne</div>
                  <div class="sub-customerinfo">phoneTwo</div>
                </div>
              </td>
              <td style="padding-top: 15px; vertical-align: top;">
                <div class="ng-star-inserted">
                  <div class="date ng-star-inserted" style="text-align: right;"><b>Date: date</b></div>
                  <div class="date" style="text-align: right;">Invoice ID: invoiceId</div>
                  <div class="date" style="text-align: right;">Client ID: clientId</div>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <div>
          <div style="margin-top: 15px"></div>
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="1" class="src-heading" style="text-align:center; ">
                DATE : ('31-12-2023')
              </td>
              <td colspan="5" class="src-heading" style="text-align:center; ">
                TITLE : ('Happy New Year')
              </td>
            </tr>
            <tr class="heading">
              <td>
                ('SERVICE CODE')
              </td>
              <td>
                ('SERVICE NAME')
              </td>
              <td>
                ('DESCRIPTION')
              </td>
              <td>
                ('PRICE')
              </td>
              <td class="center">
                ('QTY')
              </td>
              <td class="right">
                ('AMOUNT')
              </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
          </table>
          <div style="margin-top: 15px"></div>
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="1" class="src-heading" style="text-align:center; ">
                DATE : ('31-12-2023')
              </td>
              <td colspan="5" class="src-heading" style="text-align:center; ">
                TITLE : ('Happy New Year')
              </td>
            </tr>
            <tr class="heading">
              <td>
                ('SERVICE CODE')
              </td>
              <td>
                ('SERVICE NAME')
              </td>
              <td>
                ('DESCRIPTION')
              </td>
              <td>
                ('PRICE')
              </td>
              <td class="center">
                ('QTY')
              </td>
              <td class="right">
                ('AMOUNT')
              </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
          </table>
          <div style="margin-top: 15px"></div>
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="1" class="src-heading" style="text-align:center; ">
                DATE : ('31-12-2023')
              </td>
              <td colspan="5" class="src-heading" style="text-align:center; ">
                TITLE : ('Happy New Year')
              </td>
            </tr>
            <tr class="heading">
              <td>
                ('SERVICE CODE')
              </td>
              <td>
                ('SERVICE NAME')
              </td>
              <td>
                ('DESCRIPTION')
              </td>
              <td>
                ('PRICE')
              </td>
              <td class="center">
                ('QTY')
              </td>
              <td class="right">
                ('AMOUNT')
              </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
            <tr class="item">
              <td> serviceCode </td>
              <td> serviceName </td>
              <td> serviceDesc</td>
              <td> unitPrice  </td>
              <td class="center"> qty </td>
              <td class="right"> amount  </td>
            </tr>
          </table>
        </div>
        <div class="invoice-summary">
          <table style="width:50%" border>
            <tbody>
              <tr>
                <td class="right"> amountDollar  </td>
                <td style="font-size:13px; font-weight: 600;"> ('Grand Total') </td>
              </tr>
             <tr>
               <td class="right"> tax  </td>
                <td style="font-size:13px; font-weight: 600; "> ('TAX') </td>
              </tr> 
              <tr>
                <td class="right"> discount  </td>
                <td style="font-size:13px; font-weight: 600; "> ('Discount') </td>
              </tr>
              <tr>
                <td class="right"> grandDollar  </td>
                <td style="font-size:13px; font-weight: 600;"> ('Net Cost') </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="flex-invoicesubheader">
          <table>
            <tbody>
              <tr>
                <div class="opening-balance-text" style="text-align:center;"> ('THANK YOU FOR YOUR BUSINESS') </div>
              </tr>
    
              <tr>
                <h3 class="disclaimer-text">('NOTES:')</h3>
                <ul>
                    <li>Payment in Advance</li>
                    <li>No Refunds</li>
                </ul>
    
                 {{-- <img src="http://barcode.pinonclick.com/barcode?code=413075" /> --}}
              </tr>
              <tr class="">
                <td style="text-align: center;">
                    <h3 class="disclaimer-text" style="text-align: center; border-bottom: 1px solid #000; width:49%">{{__('Prepared By:')}}</h3>
                </td>
                <td style="text-align: center;">
                    <h3 class="disclaimer-text" style="text-align: center; border-bottom: 1px solid #000;">{{__('Client Signature:')}}</h3>
                </td>    
            </tr>
        </tbody>
    </table>
</div>
</div>

{{-- <img src="http://barcode.pinonclick.com/barcode?code=413075" /> -- --}}
</body>
</html>