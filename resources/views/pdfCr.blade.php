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
                    <h3 class="header-subheading">{{__('Cash Receipt')}}</h3>
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
                  <div class="date ng-star-inserted" style="text-align: right;"><b>Invoice Date: 2024-7-7</b></div>
                  <div class="date ng-star-inserted" style="text-align: right;"><b>Cash Receipt: 2024-7-7</b></div>
                  <div class="date" style="text-align: right;">Cash Receipt ID: #CR-31</div>
                  <div class="date" style="text-align: right;">Client ID: #CL-12</div>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <div style="margin: 20px auto 20px auto; background-color: #f9cdaa; width: 90%; height: 200px; border: 2px solid #000;">
          <div style="padding: 0 20px 0 20px">
            <h2>Received From: <span style="text-decoration: underline; width: 100%">Shabo Shabo</span></h2>
          </div>
          <div style="padding: 0 20px 0 20px">
            <h2>For: <span style="text-decoration: underline; width: 100%">PDF TEST</span></h2>
          </div>
          <div style="margin: 40px 0 40px 0;"></div>
          <div style="padding: 0 20px 0 20px;">
            <h2>Amount Piad: <span style="text-decoration: underline; width: 100%">$ 500</span></h2>
          </div>
          <div style="padding: 0 20px 0 20px; color: #cc0022">
            <h2>Amount Due: <span style="text-decoration: underline; width: 100%">$ 1000</span></h2>
          </div>

        </div>
        <div>
          <div style="margin-top: 25px"></div>
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2" class="src-heading" style="text-align:center; ">
                {{__('Previuos Payments')}}
              </td>
            </tr>
            <tr class="heading">
              <td>
                ('Date')
              </td>
              <td>
                ('Amount')
              </td>
            </tr>
            <tr class="item">
              <td> 2024-7-7 </td>
              <td> $ 300 </td>
            </tr>
            <tr class="item">
              <td> 2024-7-7 </td>
              <td> $ 500 </td>
            </tr>

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