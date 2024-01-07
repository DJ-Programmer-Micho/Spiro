<div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <div class="row profile-box mt-5 p-0">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 dash-card">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{__('Total Earning')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalEarningDollar)}} <br> {{number_format($totalEarningIraqi)}} IQD</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/ziynmnyj.json"
                                trigger="loop"
                                colors="primary:#4e73df,secondary:#fff"
                                state="in-reveal"
                                delay="2000"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{__('Total Payed')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalPayedDollar)}} <br> {{number_format($totalPayedIraqi)}} IQD</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/kxockqqi.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#1cc88a,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                {{__('Total Due')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalDueDollar)}} <br> {{number_format($totalDueIraqi)}} IQD</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/kndkiwmf.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#36b9cc,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{__('Total Expense')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalExpenseDollar)}} <br> {{number_format($totalExpenseIraqi)}} IQD</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/ofdfurqa.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#36b9cc,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 dash-card">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{__('Total Quotations')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalQuotation}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/wzwygmng.json"
                                trigger="loop"
                                colors="primary:#f6c23e,secondary:#fff"
                                state="in-reveal"
                                delay="2000"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{__('Total Invoices')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalInvoice}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/wzwygmng.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#4e73df,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{__('Total Cash Receipt')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalCash}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/ghhwiltn.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#1cc88a,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{__('Total People')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">Total Emp: {{$totalUser}} <br> Total Clients: {{$totalClient}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/xzalkbkz.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#36b9cc,secondary:#fff"
                                state="hover-wave"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .fc .fc-toolbar.fc-header-toolbar {
    margin-bottom: 1.5em;
    margin-top: 1.5em;
    color: white
}
@media only screen and (max-width: 1064px) {
    /* Styles for devices up to 768px width (e.g., tablets) */
    .fc-toolbar-title {
        font-size: 13px !important;
    }

    button.fc-button-primary {
        font-size: 7px !important;
    }
}

@media only screen and (max-width: 480px) {
    /* Styles for devices up to 480px width (e.g., smartphones) */
    .fc-toolbar-title {
        font-size: 12px !important;
    }

    button.fc-button-primary {
        font-size: 6px !important;
    }
}
    </style>
    <div class="row my-2 p-0 m-0">
        <div class="col-12 col-md-8 profile-box bg-dark" style="border-right: 1px solid #eee">
            <div wire:ignore id='calendar'></div>
        </div>
        <div class="col-12 col-md-4 profile-box bg-dark my-auto">
            <div class="text-center">
                <h6 class="mt-2">{{__('TOP USER IN TASKS')}}</h6>
                <canvas id="pieChartUser" class="mx-auto" style="max-width: 400px;" height="200"></canvas>
            </div>
            <hr style="background-color: #eee">
            <div class="text-center">
                <h6 class="mt-2">{{__('TOP TASKS USED')}}</h6>
                <canvas id="pieChartTask" class="mx-auto" style="max-width: 400px;" height="200"></canvas>
            </div>
           

        </div>
    </div>

    <div wire:ignore.self class="modal fade overflow-auto" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white mx-1 mx-lg-auto">
            <div class="modal-content bg-dark">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="quickViewModal" style="color: #31fbe2">{{__('Invoice Information')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row m-0">
                            <h5 class="mt-4 mb-1">
                                <small class="text-danger">{{__('(Read Only)')}}</small>
                            </h5>
                            
                        </div>

                        <div class="row border-cut-b">
                            <div class="col-12">
                                <div class="mb-1">
                                    <p id="clientNameTempData">{{__('Client Name')}}</p>
                                </div>
                                </div>
                                </div>
                             
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Assume $chartData is the data you prepared for Chart.js
            var ctx1 = document.getElementById('pieChartUser').getContext('2d');
            
            var pieChart1 = new Chart(ctx1, {
                type: 'pie',
                data: @json($chartDataUsrtCount),
                options: {
                    responsive: true, // Make the chart responsive
                    maintainAspectRatio: true, // Prevent the chart from being distorted
                    plugins: {
                        legend: {
                            position: 'bottom', // Adjust legend position
                        },
                    },
                },
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Assume $chartData is the data you prepared for Chart.js
            var ctx2 = document.getElementById('pieChartTask').getContext('2d');
            
            var pieChart2 = new Chart(ctx2, {
                type: 'pie',
                data: @json($chartDataTaskCount),
                options: {
                    responsive: true, // Make the chart responsive
                    maintainAspectRatio: true, // Prevent the chart from being distorted
                    plugins: {
                        legend: {
                            position: 'bottom', // Adjust legend position
                        },
                    },
                },
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
            start: 'dayGridMonth,timeGridWeek,listWeek', // Add buttons for different views
            center: 'title',
            end: 'today prev,next'
        },
                views: {
            dayGridMonth: { type: 'dayGridMonth', buttonText: 'Month' },
            timeGridWeek: { type: 'timeGridWeek', buttonText: 'Week' },
            listWeek: { type: 'listWeek', buttonText: 'List' }
        },
                themeSystem: 'bootstrap5',
                timeZone: 'UTC',
                editable: false,
                selectable: false,
                events: @json($events),
                select: function (data) {
                    var event_name = prompt('Event Name:');
                    if (!event_name) {
                        return;
                    }
                    @this.newEvent(event_name, data.start.toISOString())
                        .then(function (id) {
                            calendar.addEvent({
                                id: id,
                                title: event_name,
                                start: data.startStr,
                                // Uncomment the line below if you have an end property
                                // end: data.endStr,
                            });
                            calendar.unselect();
                        });
                },
                eventDrop: function (data) {
                    console.log(data.event.id)
                    @this.updateEvent(
                        data.event.id,
                        data.event.name,
                        data.event.start.toISOString(),
                        // Uncomment the line below if you have an end property
                        // data.event.end.toISOString()
                        
                    );
                },
                eventClick: function (info) {
                // Check if the event is editable, and if not, set it as unselectable
                const information = info.event.extendedProps.information;
                
     

                var myModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
                myModal.show();

                let alertMessage = `Name: ${information.clientName}<br>`;
                alertMessage += `Invoice Created Date: ${information.invoiceCreated}<br>`;
                alertMessage += `Total Cost ($) : $ ${information.totalCostDollar}<br>`;
                alertMessage += `Total Cost (IQD) : ${information.totalCostIraqi} IQD<br><br>`;

                // Display information for each service
                information.services.forEach(data => {
                    alertMessage += `Event Date: ${data.actionDate}<br>`;
                    alertMessage += `Description: ${data.description}<br>`;
                    data.services.forEach(service => {
                    alertMessage += `Service Code: ${service.serviceCode}<br>`;
                    alertMessage += `Service Description: ${service.serviceDescription}<br>`;
                    alertMessage += `Service Default Cost (USD): ${service.serviceDefaultCostDollar}<br>`;
                    alertMessage += `Service Default Cost (IQD): ${service.serviceDefaultCostIraqi}<br>`;
                    alertMessage += `Service Quantity: ${service.serviceQty}<br>`;
                    alertMessage += `Service Total Cost (USD): ${service.serviceTotalDollar}<br>`;
                    alertMessage += `Service Total Cost (IQD): ${service.serviceTotalIraqi}<br>`;
                });
                alertMessage += `<br>`;

                });

                document.getElementById('clientNameTempData').innerHTML = alertMessage;
                // alert(alertMessage);
            },
            });

            $('#calendar_container').delegate('.fc-toolbar-chunk button', 'click', function () {
        currentView = $(this).attr('data-view'); // Get the view type from the button
        calendar.changeView(currentView); // Change the view dynamically
    });
            calendar.render();
        }); 
    </script>
</div>