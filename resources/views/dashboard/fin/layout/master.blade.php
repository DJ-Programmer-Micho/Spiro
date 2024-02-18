<!DOCTYPE html>
<html lang="{{(app()->getLocale() != 'kr') ? app()->getLocale() : 'ar'}}">

<head>
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css" rel="stylesheet"/> --}}
    <meta charset="utf-8">
    <meta name="default-locale" content="{{ app()->getLocale() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{asset('assets/dashboard/logo/72.png')}}" rel="shortcut icon">
    <title>SPIRO</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/dashboard/lib/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="{{asset('assets/dashboard/css/sb-admin-2.min.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('assets/dashboard/css/qr-style.css')}}" rel="stylesheet"> --}}
    @livewireStyles
    @stack('language_css')
    @stack('cropper_links')
    @stack('style_tag')
    @stack('support')
    @yield('dash_css')
    <script src="https://cdn.lordicon.com/lordicon-1.2.0.js"></script>
    <link href="{{asset('assets/dashboard/css/toaster.css')}}" rel="stylesheet" type="text/css">
    <style>
        #content{
            min-height: 100vh;
            background-image: linear-gradient(#17082e 0%, #1a0933 7%, #1a0933 80%, #0c1f4c 100%);
            text-shadow: 0 0 1px rgba(50, 251, 226, 0.3), 0 0 2px rgba(50, 251, 226, 0.3), 0 0 5px rgba(50, 251, 226, 0.2);    
        }
        .content-bg-met{
            background-color: transparent;
            border: 1px solid rgb(111, 66, 193, 0.9);
        }
        .sidebar .nav-item .nav-link {
            padding: 0.5rem 1rem!important;
        }
        .nav-item lord-icon{
            vertical-align: middle !important;
        }
        .nav-item span{
            vertical-align: middle !important;
        }    
        .logo1 {
            fill: #fff;
            height: 50px;
        }
        /* .minicolors-sprite {
  background-image: url(@php echo asset('assets/dashboard/css/jquery.minicolors.css') @endphp);
} */
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" >

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    {{-- <svg class="logo1" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1253.53 990.62"><path d="M150.86,442l8.93-15.51Q267.83,239.07,475,176.44c96.32-29.05,193.75-29.77,291.38-6.07a535,535,0,0,1,137.13,53.91c132.5,74.73,222.59,184,266.75,330.13,14.17,46.9,20.58,95.07,21.7,144a13.7,13.7,0,0,1-.22,1.68L94.13,711.77c-.17-1.22-.39-2.26-.43-3.31-2.58-58.66,3.53-116.35,20.24-172.7,5-17,11.63-33.63,17.5-50.43.63-1.81,1.16-3.65,1.74-5.48Zm-25.81,237.3,1032.57-11c0-1.52,0-2.47-.1-3.42-2.93-37.32-9.58-74-20.93-109.66C1095.6,426.33,1016,328.1,900,259.11a506.2,506.2,0,0,0-136.51-56.39c-113-28.25-223.93-21.87-331.57,23.38-108.75,45.73-191.5,121-248,224.66A470.71,470.71,0,0,0,129.65,622C127.41,640.83,126.57,659.86,125.05,679.32Z" transform="translate(-20.31 -46.88)"></path><path d="M714.33,63.34c2.91,2.31,6,4.47,8.72,7,10.24,9.23,16.05,20.29,12.91,34.46-2,9.19-7.58,16.27-14.94,22-11.93,9.24-25.74,14.3-40.28,17.36-32.14,6.77-64.08,6.24-95.47-4.14-11.42-3.79-22.06-9.22-30.49-18.21-13.7-14.63-13.7-33.86.28-48.2,10.65-10.92,24.24-16.7,38.65-20.39,34.13-8.73,68.18-8.61,101.95,2.22a8.93,8.93,0,0,0,2,.21ZM587.77,106.62a113.13,113.13,0,0,0,37,9c20.7,1.73,41.14.6,60.84-6.56a71.46,71.46,0,0,0,14.7-7.68c5-3.3,4.89-5.23-.22-8.52a68.07,68.07,0,0,0-12.17-6.29c-12.83-5-26.31-6.85-40-7.26-19.47-.6-38.64,1.1-56.75,9a56.22,56.22,0,0,0-10.74,6.31c-4.08,3-3.95,4.49.22,7.55C583.3,104.08,586.25,105.67,587.77,106.62Z" transform="translate(-20.31 -46.88)"></path><path d="M647.38,960.94q291.72,0,583.43,0c9.38,0,18.25,1.49,26.19,6.87a37.49,37.49,0,0,1,15.37,41.69,38.8,38.8,0,0,1-35.21,28c-1.39.06-2.79,0-4.18,0H61.12c-19.93,0-35.41-11.56-39.81-29.68-5.21-21.5,10.61-44,32.64-46.35A98.11,98.11,0,0,1,64.37,961Q355.88,960.93,647.38,960.94Zm0,23.58H64a52.21,52.21,0,0,0-7.08.29,14.37,14.37,0,0,0-12.05,17c1.63,8.1,7.44,12.21,17.29,12.21H1231.93c1.25,0,2.51.05,3.76,0a14.71,14.71,0,0,0,.16-29.37c-2.07-.17-4.17-.12-6.26-.12Z" transform="translate(-20.31 -46.88)"></path><path d="M658.53,960.91h-24c0-7.6-.66-15,.16-22.26,1.1-9.84,7.7-15.32,17.05-17.65q37.23-9.27,74.45-18.5,21.65-5.37,43.28-10.79a5.41,5.41,0,0,0,2.53-1.33H207.55a34.31,34.31,0,0,0,3.34,1.31l116.7,29.94c11.78,3,16.64,9.28,16.65,21.5v17.75h-24V943.51c-13.5-3.42-26.55-6.73-39.61-10L148,900.09c-10.16-2.56-15.48-9.64-14.29-18.9,1.09-8.52,8.35-14.31,18.15-14.49,1.11,0,2.23,0,3.34,0H825.46c1.67,0,3.35-.06,5,.06,9,.64,15.77,6.94,16.5,15.36s-4.51,15.48-13.28,17.74c-13.46,3.47-27,6.78-40.43,10.17Q728,926.44,662.65,942.8c-3,.76-4.47,1.88-4.2,5.26C658.78,952.2,658.53,956.37,658.53,960.91Z" transform="translate(-20.31 -46.88)"></path><path d="M865.09,711.77h285.47c-1.38,10.34-2.71,20.37-4.07,30.4q-6.48,47.75-13,95.47c-3.29,24.1-6.18,48.27-10,72.29-4.43,27.51-29.76,50-57.61,50.49q-58,1-116.06,0c-29.26-.5-54.71-25-58.54-54-5.9-44.66-12.09-89.27-18.16-133.91q-3.83-28.1-7.62-56.2C865.3,714.91,865.24,713.53,865.09,711.77ZM1123,735.3H892.52c1.64,12.33,3.21,24.32,4.84,36.3C903.14,814.32,909,857,914.7,899.75c2.7,20.32,14.48,33.65,33.32,37a24,24,0,0,0,4.15.41c37,0,74.05.23,111.07-.07,17.92-.14,34-14.39,36.7-31.89,2.23-14.42,4-28.92,6-43.39q7-51.26,13.92-102.51C1120.9,751.36,1121.91,743.4,1123,735.3Z" transform="translate(-20.31 -46.88)"></path><path d="M269.87,842.43c9.51-3.72,19-7.5,28.54-11.16,29.81-11.47,59.29-24,89.55-34.1,47-15.76,95.43-19.17,144.62-12.74,33.5,4.39,65.19,14.7,96.24,27.62,25.13,10.46,50.52,20.28,76.92,30.83-2.07.2-3,.38-4,.38-18.51,0-37,0-55.53,0a19.59,19.59,0,0,1-6.41-1.38c-23.73-8.69-47-19.13-71.22-25.88C501.2,797.21,434.82,802.22,370,828.41c-3.35,1.35-6.85,2.39-10.06,4-18.3,9.32-37.62,12.5-58.06,11-10.56-.79-21.24-.14-31.86-.14Z" transform="translate(-20.31 -46.88)"></path><path d="M366.78,866.65c5.38-2.34,10.74-4.7,16.13-7,16.85-7.18,33.51-15,50.61-21.34,26.57-9.86,53.94-12,81.74-8,18.93,2.75,36.85,9.2,54.4,17.29,14.2,6.54,28.55,12.68,43.47,19.28-1.17.13-1.72.24-2.26.24-10.46,0-20.93,0-31.39,0a10.09,10.09,0,0,1-3.62-.86c-13.41-5.44-26.54-12-40.25-16.19-38.08-11.73-75.6-8.6-112.23,7.79a61.46,61.46,0,0,0-5.69,2.52,55.62,55.62,0,0,1-32.81,6.86c-6-.49-12-.08-18-.08Z" transform="translate(-20.31 -46.88)"></path><path d="M644.29,633.42c-12.63.11-20.33-8.48-16.4-17.08,2.75-6,5.61-12,7.83-18.14,4-11,2.48-21.69-3.81-32-2.63-4.3-5.27-8.61-8.1-12.83-12-17.84-13.62-36.43-6.26-55.51a198.39,198.39,0,0,1,10.75-22.5c2.89-5.37,10.46-8.12,17.54-7.13,7.27,1,12.89,5.22,13.45,10.87.25,2.46-.84,5.09-1.81,7.52-3.33,8.35-7.5,16.53-10.18,25-2.94,9.3-1.13,18.54,4,27.28,2.32,3.93,4.59,7.9,7.28,11.68,14.84,20.85,15.3,42.34,5,64.35-1.71,3.66-3.49,7.31-5.49,10.88C655.37,630.82,650.05,633,644.29,633.42Z" transform="translate(-20.31 -46.88)"></path><path d="M714.85,633.42c-12.38,0-19.85-10.9-16.13-21.8,3.14-9.17,6.44-18.34,8.74-27.75,2.93-12,1.21-23.78-4-35-4.13-9-8.7-17.72-12.63-26.76-9.85-22.66-8.16-45.59-.7-68.43,2.45-7.51,5.48-14.86,8.63-22.11a16.31,16.31,0,0,1,22.2-8.67c8.39,3.8,11.4,12.63,7.71,21.79-3,7.33-5.88,14.7-8.3,22.22-5.58,17.35-4.22,34.13,4.09,50.54,5.07,10,10,20.22,13.58,30.83,6.91,20.71,3.4,41.21-3.49,61.32q-2.45,7.08-5.46,14C726.26,630.14,720.84,633,714.85,633.42Z" transform="translate(-20.31 -46.88)"></path><path d="M556.4,617.34c.85-2.76,1.69-5.52,2.56-8.27,2.65-8.47,5.86-16.8,7.83-25.42,2.92-12.77.67-25.15-5-36.91-2.65-5.51-5.31-11-8.12-16.44-11.65-22.51-13.3-46-6.18-70a279,279,0,0,1,11-29.64c3.19-7.52,11.46-10.8,19.19-8.61s12.57,8.84,11.86,16.51c-.23,2.42-1.34,4.77-2.13,7.12-3.24,9.73-7,19.31-9.64,29.21-3.38,12.93-1.73,25.68,3.84,37.85,2.31,5,4.63,10.12,7.32,15,14.4,26.05,15,53,5.34,80.58-1.89,5.37-3.87,10.73-6.24,15.89A16.07,16.07,0,0,1,569.6,633,16.81,16.81,0,0,1,556.4,617.34Z" transform="translate(-20.31 -46.88)"></path><path d="M1121.31,919.45c1.29-7.81,2.53-15.31,3.8-23,18.05,4.61,30.6-4.61,40.5-17.53,21.07-27.48,24.76-57.86,12.25-90.1a48.32,48.32,0,0,0-6.29-10.76c-7.45-10.12-15.82-13.64-28.87-12.18.58-4.45,1.21-8.75,1.7-13.06,1.34-11.9,2.06-12.47,14.06-10.05,13.77,2.77,24.39,10.45,32.71,21.49,10.43,13.84,15.72,29.72,17.2,46.76,2.79,32.15-4.95,61.33-26.47,86-11.1,12.73-24.7,21.54-41.84,23.84A41.81,41.81,0,0,1,1121.31,919.45Z" transform="translate(-20.31 -46.88)"></path><path d="M206.88,480.42C250.33,390.37,323.42,315.8,420.64,265c20.16-10.55,41.59-18.69,62.52-27.75,6.1-2.64,12.07-1.57,17.19,2.75a15.35,15.35,0,0,1,5.44,15.72c-1.29,6.17-5.58,9.44-11.18,11.87-20.16,8.74-40.74,16.71-60.17,26.86C366.3,330,310,379.42,266.81,443.12c-41.93,61.77-66.5,129.86-72.26,204.51-.8,10.43-7.69,16.85-17.31,16.2s-16.06-8.58-15.29-19.09C166,590.47,179.86,538.81,206.88,480.42Z" transform="translate(-20.31 -46.88)"></path></svg> --}}
                    <img src="{{asset('assets/dashboard/img/mainlogo.png')}}" alt="Mine Menu" width="50">
                </div>
                <div class="sidebar-brand-text mx-3">GLAM<br><small>PRODUCTION</small></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider mb-1">

            <!-- Heading -->
            <div class="sidebar-heading">
                {{__('Statistics')}}
            </div>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{(request()->path() == 'fin') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('fin.dashboard')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/gqdnbnwt.json"
                    trigger="loop"
                    delay="2000"
                    colors="primary:#cc0022,secondary:#eee"
                    style="width:48px;height:48px;">
                </lord-icon>
                    <span>{{__('Dashboard')}}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-1">

            <!-- Heading -->
            <div class="sidebar-heading">
                {{__('Initialize Information')}}
            </div>

            <!-- Nav Item - Main Menu -->
            <li class="nav-item {{(request()->path() == 'fin/user') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('fin.user')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/xzalkbkz.json"
                    trigger="loop"
                    delay="1500"
                    state="in-reveal"
                    colors="primary:#cc0022,secondary:#eee"
                    style="width:48px;height:48px">
                </lord-icon>
                    <span>{{__('Users')}}</span></a>
            </li>
            <!-- Nav Item  -->
            <li class="nav-item {{(request()->path() == 'fin/client') ? 'active' : ''}}">
                <a class="nav-link"  href="{{route('fin.client')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/kndkiwmf.json"
                    trigger="hover"
                    colors="primary:#cc0022,secondary:#eee"
                    style="width:48px;height:48px">
                    </lord-icon>
                    <span>{{__('Clients')}}</span></a>
            </li>
            <!-- Nav Item - Service -->
            <li class="nav-item  {{(request()->path() == 'fin/service') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('fin.service')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/wzwygmng.json"
                    trigger="loop"
                    delay="2000"
                    colors="primary:#cc0022,secondary:#eee"
                    style="width:48px;height:48px">
                </lord-icon>
                    <span>{{__('Services')}}</span></a>
            </li>
            <!-- Nav Item - payment -->
            <li class="nav-item  {{(request()->path() == 'fin/payment') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('fin.payment')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/wzwygmng.json"
                    trigger="loop"
                    delay="2000"
                    colors="primary:#cc0022,secondary:#eee"
                    style="width:48px;height:48px">
                </lord-icon>
                    <span>{{__('Payments')}}</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-1">
            <!-- Heading -->
            <div class="sidebar-heading">
                {{__('Expenses')}}
            </div>
            <li class="nav-item {{(str_contains(request()->path(), 'fin/expense')) ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExpense" aria-expanded="true" aria-controls="collapseExpense">
                    <lord-icon
                    src="https://cdn.lordicon.com/ofklvwkr.json"
                    trigger="loop"
                    delay="2000"
                    colors="primary:#cc0022,secondary:#ffffff"
                    style="width:48px;height:48px">
                    </lord-icon>
                    <span>{{__('Expense')}}</span>
                </a>
                <div id="collapseExpense" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded" style="background-color: #1f2535">
                        {{-- <h6 class="collapse-header">{{__('Setting')}}</h6> --}}
                        <a class="collapse-item" href="{{route('fin.expense')}}">
                            <lord-icon
                            src="https://cdn.lordicon.com/iiuaqmnt.json"
                            trigger="loop"
                            delay="2000"
                            colors="primary:#cc0022,secondary:#ffffff"
                            style="width:48px;height:48px">
                        </lord-icon>
                            <span class="text-white">{{__('Expense')}}</span>
                        </a>
                        <a class="collapse-item" href="{{route('fin.expense.bill')}}">
                            <lord-icon 
                                src="https://cdn.lordicon.com/wyqtxzeh.json"
                                trigger="loop" 
                                delay="2000"
                                colors="primary:#cc0022,secondary:#eee" 
                                state="hover-1" 
                                style="width:48px;height:48px">
                            </lord-icon>
                            <span class="text-white">{{__('Bills')}}</span>
                        </a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-1">
            <!-- Heading -->
            <div class="sidebar-heading">
                {{__('Q.I.R.D')}}
            </div>
            <li class="nav-item  {{(request()->path() == 'fin/quotation') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('fin.quotation')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/wzwygmng.json"
                    trigger="loop"
                    delay="1500"
                    state="in-unfold"
                    colors="primary:#ffffff,secondary:#cc0022"
                    style="width:48px;height:48px">
                </lord-icon>
                    <span>{{__('Quotations')}}</span></a>
            </li>
            <li class="nav-item  {{(request()->path() == 'fin/invoice') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('fin.invoice')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/wzwygmng.json"
                    trigger="loop"
                    delay="1500"
                    state="in-reveal"
                    colors="primary:#ffffff,secondary:#cc0022"
                    style="width:48px;height:48px">
                </lord-icon>
                    <span>{{__('Invoices')}}</span></a>
            </li>
            <li class="nav-item  {{(request()->path() == 'fin/cash') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('fin.cash')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/wzwygmng.json"
                    trigger="loop"
                    delay="1500"
                    state="in-unfold"
                    colors="primary:#ffffff,secondary:#cc0022"
                    style="width:48px;height:48px">
                </lord-icon>
                    <span>{{__('Cash Receipt')}}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-1">
            <!-- Heading -->
            <div class="sidebar-heading">
                {{__('Tasks')}}
            </div>
            <!-- Nav Item - Main Menu -->
            <li class="nav-item {{(request()->path() == 'fin/mytask') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('fin.mytask')}}">
                    <lord-icon
                    src="https://cdn.lordicon.com/ghhwiltn.json"
                    trigger="loop"
                    delay="2000"
                    colors="primary:#cc0022,secondary:#ffffff"
                    state="in-reveal"
                    style="width:48px;height:48px">
                </lord-icon>
                    <span>{{__('My Task')}}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-1">
            <!-- Heading -->
       


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="https://i.ibb.co/PrD6md2/MET-Circle.png" alt="metiraq">
                <p class="text-center mb-2"><strong>MET IRAQ</strong> - Pro Vesrion Of Managment System</p>
                <a class="btn btn-danger btn-sm" href="https://metiraq.com/" target="_blank">Contact Us</a>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-dark bg-gradient-dark-l topbar static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">0</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    {{__('Alerts Center')}}
                                </h6>
                                <a class="ropdown-item text-center small text-gray-500">{{__('Empty')}}</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">0</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    {{__('Message Center')}}
                                </h6>
                                <a class="dropdown-item text-center small text-gray-500">{{__('No Messages')}}</a>
                                {{-- <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a> --}}
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span> --}}
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{asset('avatars/'.auth()->user()->profile->avatar)}}">
                                    

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{auth()->user()->name}} <br>
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{auth()->user()->profile->job_title}} 
                                </a>
                                <div class="dropdown-divider"></div>
                                <div>
                                    <a href="#" onclick="changeLanguage('en')" class="dropdown-item"><img src="{{asset('assets/dashboard/img/lang/uk.webp')}}" width="25px" class="mx-1">{{__('en')}}</a>
                                    <a href="#" onclick="changeLanguage('ar')" class="dropdown-item"><img src="{{asset('assets/dashboard/img/lang/iraq.png')}}" width="25px" class="mx-1">{{__('ar')}}</a>
                                </div>
                                {{-- @foreach ($filteredLocales as $locale)
                                    <a class="dropdown-item" href="#" onclick="changeLanguage('{{ $locale }}')">
                                        <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ strtoupper($locale) }}
                                    </a>
                                @endforeach --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{__('Logout')}}
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid content-bg-met">
                    @yield('dash_content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-gradient-dark-r">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MET IRAQ</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Ready to Leave?')}}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">{{__('Select Logout below if you are ready to end your current session.')}}</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{__('Cancel')}}</button>
                    <a class="btn btn-primary" href="{{route('logout')}}">{{__('Logout')}}</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/dashboard/vendor/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('assets/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/dashboard/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/dashboard/js/sb-admin-2.min.js')}}"></script>
    <!-- Page level plugins -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- <script src="{{asset('assets/dashboard/vendor/chart.js/Chart.min.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    window.addEventListener('alert', event => {
        toastr[event.detail.type](event.detail.message, event.detail.title ?? '');
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
        };
        });
    </script>
    
    @livewireScripts
    @stack('cropper')
    @stack('drag')
    @stack('color');
    @yield('form_script')
    @stack('dash_script')
    @yield('dash_script')
    @stack('datePicker')
    @yield('datePicker')
    <form id="languageForm" action="{{ route('setLocale') }}" method="post">
        @csrf
        <input type="hidden" name="locale" id="selectedLocale" value="{{ app()->getLocale() }}">
    </form>
    <script>
        // Function to change the language and submit the form
        function changeLanguage(locale) {
            document.getElementById('selectedLocale').value = locale;
            document.getElementById('languageForm').submit();
        }
    </script>
</body>
</html>