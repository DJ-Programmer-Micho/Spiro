<div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <div class="row profile-box mt-5">
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
            <div class="card border-left-danger shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                {{__('Total Payed')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalPayedDollar)}} <br> {{number_format($totalPayedIraqi)}} IQD</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/kxockqqi.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#e74a3b,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{__('Total Due')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalDueDollar)}} <br> {{number_format($totalDueIraqi)}} IQD</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/kndkiwmf.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#f6c23e,secondary:#fff"
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
                                {{__('Monthly Report')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{__()}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/dnoiydox.json"
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
    </div>
    <div class="row profile-box mt-5">
        <div class="col-12">
            <div wire:ignore id='calendar'></div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade overflow-auto" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addCash">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="quickViewModal" style="color: #31fbe2">{{__('Invoice Information')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row m-0">
                            <h5 class="mt-4 mb-1">
                                <b>{{__('Client Information')}}</b>
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
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Content Row -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
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
            calendar.render();
        }); 
    </script>
</div>