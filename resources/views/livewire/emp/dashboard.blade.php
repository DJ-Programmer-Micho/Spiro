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
                                {{__('Total Tasks')}} <small>({{__('Life Time')}})</small>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$taskTotal}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/ghhwiltn.json"
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
            <div class="card border-left-info shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{__('In Process Tasks')}} <small>({{__('Life Time')}})</small>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$taskProcess}}</div>                        
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/uecgmesg.json"
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
            <div class="card border-left-success shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{__('Total Tasks Complete')}} <small>({{__('Life Time')}})</small>
                            </div>
                                <div class="h5 mb-0 font-weight-bold text-white">{{$taskComplete}}</div>
                            </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/cgzlioyf.json"
                                trigger="loop"
                                delay="2000"
                                state="hover-loading"
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
                                {{__('Total Tasks Not Complete')}} <small>({{__('Life Time')}})</small>
                            </div>
                                <div class="h5 mb-0 font-weight-bold text-white">{{$taskLeft}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/krenhavm.json"
                                trigger="loop"
                                delay="2000"
                                state="hover-oscillate"
                                colors="primary:#e74a3b,secondary:#fff"
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
    <div class="row my-2 p-0 m-0 justify-content-center">
        <div class="col-12 col-lg-8 profile-box bg-dark" style="border: 1px solid #eee">
            <div wire:ignore id='calendar'></div>
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
                                end: data.endStr,
                                // Uncomment the line below if you have an end property
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
                        data.event.end.toISOString()
                        // Uncomment the line below if you have an end property
                        
                    );
                },
            //     eventClick: function (info) {
            //     // Check if the event is editable, and if not, set it as unselectable
            //     const information = info.event.extendedProps.information;
                
     

            //     var myModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            //     myModal.show();

            //     let alertMessage = `Name: ${information.clientName}<br>`;
            //     alertMessage += `Invoice Created Date: ${information.invoiceCreated}<br>`;
            //     alertMessage += `Total Cost ($) : $ ${information.totalCostDollar}<br>`;
            //     alertMessage += `Total Cost (IQD) : ${information.totalCostIraqi} IQD<br><br>`;

            //     // Display information for each service
            //     information.services.forEach(data => {
            //         alertMessage += `Event Date: ${data.actionDate}<br>`;
            //         alertMessage += `Description: ${data.description}<br>`;
            //         data.services.forEach(service => {
            //         alertMessage += `Service Code: ${service.serviceCode}<br>`;
            //         alertMessage += `Service Description: ${service.serviceDescription}<br>`;
            //         alertMessage += `Service Default Cost (USD): ${service.serviceDefaultCostDollar}<br>`;
            //         alertMessage += `Service Default Cost (IQD): ${service.serviceDefaultCostIraqi}<br>`;
            //         alertMessage += `Service Quantity: ${service.serviceQty}<br>`;
            //         alertMessage += `Service Total Cost (USD): ${service.serviceTotalDollar}<br>`;
            //         alertMessage += `Service Total Cost (IQD): ${service.serviceTotalIraqi}<br>`;
            //     });
            //     alertMessage += `<br>`;

            //     });

            //     document.getElementById('clientNameTempData').innerHTML = alertMessage;
            //     // alert(alertMessage);
            // },
            });

            $('#calendar_container').delegate('.fc-toolbar-chunk button', 'click', function () {
        currentView = $(this).attr('data-view'); // Get the view type from the button
        calendar.changeView(currentView); // Change the view dynamically
    });
            calendar.render();
        }); 
    </script>
</div>