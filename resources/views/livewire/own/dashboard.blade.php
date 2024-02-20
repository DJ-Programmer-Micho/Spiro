<div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    @include('livewire.own.report-select')

    <div class="mt-3 row d-flex justify-content-end">
        <button class="btn btn-info" data-toggle="modal" data-target="#selectReportModal" data-dismiss="modal" aria-label="Close" >Report</button>
    </div>
    <div class="row profile-box mt-5 p-0">
        <div class="row col-xl-4 col-12">
            <div class="col-xl-12 mb-4">
                <div class="card border-left-white shadow h-100 py-2 dash-card">
                    <div class="card-body ">
                        <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                            {{__('Invocie Summary')}}</div>
                        <table class="table table-striped table-hover table-sm text-white">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company Name</th>
                                    <th>Client Name</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody class="text-white" wire:ignore>
                                @forelse ($summaryTable as $item)
                                <tr>
                                    <td class="align-middle">
                                        {{$item['id']}}
                                    </td>
                                    <td class="align-middle">
                                        {{$item->client->company['company_name'] ?? '-'}}
                                    </td>
                                    <td class="align-middle">
                                        <span class="">
                                            <b>{{$item->client['client_name']}}</b>
                                        </span>
                                    </td>
                                    <td class="align-middle">{{$item['invoice_date']}}</td>
                                </tr>
                                @empty
                                NO DATA
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row col-xl-8 col-12">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 dash-card">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    {{__('Contract Profit')}}</div>
                                <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalProfitDollar)}}
                                    <br> {{number_format($totalProfitIraqi)}} IQD</div>
                            </div>
                            <div class="col-auto">
                                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/ziynmnyj.json" trigger="loop"
                                    colors="primary:#4e73df,secondary:#fff" state="in-reveal" delay="2000"
                                    style="width:48px;height:48px">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2 dash-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    {{__('Total Expense')}}</div>
                                <div class="h5 mb-0 font-weight-bold text-white">$
                                    {{number_format($totalExpenseDollar)}} <br> {{number_format($totalExpenseIraqi)}}
                                    IQD</div>
                            </div>
                            <div class="col-auto">
                                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/ofdfurqa.json" trigger="loop" delay="2000"
                                    colors="primary:#36b9cc,secondary:#fff" style="width:48px;height:48px">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 dash-card">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    {{__('NET Profit')}}</div>
                                <div class="h5 mb-0 font-weight-bold text-white">$
                                    {{number_format($totalEarningDollar)}} <br> {{number_format($totalEarningIraqi)}}
                                    IQD</div>
                            </div>
                            <div class="col-auto">
                                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/nkfxhqqr.json" trigger="loop"
                                    colors="primary:#f6c23e,secondary:#fff" state="in-reveal" delay="2000"
                                    style="width:48px;height:48px">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 dash-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    {{__('Total Payed')}}</div>
                                <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalPayedDollar)}}
                                    <br> {{number_format($totalPayedIraqi)}} IQD</div>
                            </div>
                            <div class="col-auto">
                                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/kxockqqi.json" trigger="loop" delay="2000"
                                    colors="primary:#1cc88a,secondary:#fff" style="width:48px;height:48px">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2 dash-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    {{__('Total Due')}}</div>
                                <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalDueDollar)}}
                                    <br> {{number_format($totalDueIraqi)}} IQD</div>
                            </div>
                            <div class="col-auto">
                                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/kndkiwmf.json" trigger="loop" delay="2000"
                                    colors="primary:#e74a3b ,secondary:#fff" style="width:48px;height:48px">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2 dash-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    {{__('Total Net Profit')}}</div>
                                <div class="h5 mb-0 font-weight-bold text-white">$ {{number_format($totalNetProfitDollar)}}
                                    <br> {{number_format($totalNetProfitiraqi)}} IQD</div>
                            </div>
                            <div class="col-auto">
                                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/wyqtxzeh.json" trigger="loop" delay="1500" state="in-reveal"
                                    colors="primary:#ffffff,secondary:#ffffff" style="width:48px;height:48px">
                                </lord-icon>
                            </div>
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
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 dash-card">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between dash-card">
                    <h6 class="m-0 font-weight-bold text-white">
                        {{__('Overview Statistic')}}
                    </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row my-1">
                        <div class="col-12 col-md-6">
                            <label for="yearSelect">{{__('Select Year:')}}</label>
                            <select id="yearSelect" class="form-control" 
                            wire:model="selectedYear" 
                            style="background-color: #303541; color: #fff;">
                                @foreach ($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="monthOption">Select Month:</label>
                            <select wire:model="selectedMonth" id="monthOption" class="form-control">
                                <option value="all">All Months</option>
                                <option value="{{$selectedYear.'-01'}}">January</option>
                                <option value="{{$selectedYear.'-02'}}">February</option>
                                <option value="{{$selectedYear.'-03'}}">March</option>
                                <option value="{{$selectedYear.'-04'}}">April</option>
                                <option value="{{$selectedYear.'-05'}}">May</option>
                                <option value="{{$selectedYear.'-06'}}">June</option>
                                <option value="{{$selectedYear.'-07'}}">July</option>
                                <option value="{{$selectedYear.'-08'}}">Augest</option>
                                <option value="{{$selectedYear.'-09'}}">Septemper</option>
                                <option value="{{$selectedYear.'-10'}}">October</option>
                                <option value="{{$selectedYear.'-11'}}">November</option>
                                <option value="{{$selectedYear.'-12'}}">December</option>
                                <!-- Add more months as needed -->
                            </select>
                        </div>
                    </div>
                    <div wire:ignore class="chart-area">
                        <canvas id="combinedChart"></canvas>
                        {{-- <canvas id="myAreaChart"></canvas> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row profile-box mt-5 p-0">
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
                            <div class="h5 mb-0 font-weight-bold text-white">{{__('Total Emp:')}} {{$totalUser}} <br> {{__('Total Clients:')}} {{$totalClient}}</div>
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

    <div class="row profile-box mt-5 p-0">
        <!-- Earnings (Monthly) Card Example -->
        @foreach ($groupedTasksByUser as $mIndex => $taskUser)
        @php
            $taskData = App\Models\User::find($mIndex);
        @endphp
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 dash-card" style="border-left-color: #7190eb">
                <div class="card-body ">
                    <div class="d-flex">
                        <div>
                            <img src="{{asset('avatars/'.$taskData->profile->avatar)}} "class="img-thumbnail rounded-circle" width="75px">
                        </div>
                        <div class="p-2">
                            <h4 class="text-white m-0">{{$taskData->name}}</h4>
                            <span class="text-white">{{$taskData->profile->job_title}}</span>
                        </div>
                    </div>
                    <hr style="background-color: #7190eb ">
                    @forelse ($taskUser as $index => $task)
                    @php
                        $taskSubData = App\Models\EmpTask::find($index);
                    @endphp
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-uppercase mb-1" style="text-shadow:none; color: #7190eb;">
                                #TS - {{$index}} | #INV - {{$taskSubData->invoice->id}}: {{$taskSubData->invoice->client->client_name}} | {{json_decode($taskSubData->invoice->services)['0']->actionDate}}
                            </div>
                    @foreach ($task as $per_task)
                        @foreach ($per_task as $item)
                        @php
                            $taskNameData = App\Models\Task::find($item['task']);
                        @endphp
                        @if ($item['progress'] == 100)
                        <div class="text-sm mb-0 font-weight-bold text-success" style="text-shadow:none">- {{$taskNameData->task_option}}: {{$item['progress']}}%</div>
                        @elseif ($item['progress'] == 0)
                        <div class="text-sm mb-0 font-weight-bold text-danger" style="text-shadow:none">- {{$taskNameData->task_option}}: {{$item['progress']}}%</div>
                        @else
                        <div class="text-sm mb-0 font-weight-bold text-white" style="text-shadow:none">- {{$taskNameData->task_option}}: {{$item['progress']}}%</div>
                        @endif
                        @endforeach
                        ***
                        @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="text-sm mb-0 font-weight-bold text-danger" style="text-shadow:none">{{__('HAS NO TASK')}}</div>
                    @endforelse

                </div>
            </div>
        </div>
        @endforeach

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
        document.addEventListener('livewire:load', function () {
                console.log('Initial');

                var combinedChart;

                // Define chart options
                var chartOptions = {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0,
                        },
                    },
                    showLines: true,
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                                drawBorder: true,
                            },
                            ticks: {
                                fontColor: "#ffffff",
                                maxTicksLimit: 12,
                            },
                        }],
                        yAxes: [{
                            maxTicksLimit: 5,
                            padding: 10,
                            color: "white",
                            ticks: {
                                fontColor: "#ffffff",
                                maxTicksLimit: 12,
                                callback: function (value, index, values) {
                                    return value.toFixed(1);
                                    // return "$" + value.toFixed(2);
                                },
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                borderColor: "rgb(234, 236, 244)",
                                drawBorder: true,
                                borderDash: [2],
                                borderDashOffset: [2],
                            },
                        }],
                    },
                    legend: {
                        labels: {
                            fontColor: "#fff",
                        }
                    },
                    plugins: {

                        colors: {
                            forceOverride: true
                        },
                        tooltip: {
                            backgroundColor: "#333",
                            bodyFontColor: "#eee",
                            titleFontColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: true,
                            intersect: true,
                            mode: "index",
                            caretPadding: 10,
                            callbacks: {
                                label: function (context) {
                                    var label = context.dataset.label || "";
                                    if (label) {
                                        label += ": ";
                                    }
                                    if (context.parsed.y !== null) {
                                        label += "$" + context.parsed.y.toFixed(2);
                                    }
                                    return label;
                                },
                            },
                        },
                    },
                };

                function createOrUpdateChart(chartData) {
            if (combinedChart) {
                combinedChart.destroy();
            }
            console.log(@this.selectedMonth);
            console.log(chartData);
                var selectedMonth =  @this.selectedMonth;
                var selectedYear =  @this.selectedYear;

                var labels, datasets;

                if (selectedMonth === 'month' || selectedMonth === null || selectedMonth === undefined || selectedMonth === '' || selectedMonth === 'all') {
                    labels = Array.from({ length: 12 }, (_, i) => (i + 1).toString());
                    datasets = chartData.map(function (entry, index) {
                        return {
                            label: entry.label,
                    data: labels.map(function (month) {
                        var monthData = entry.data[`${selectedYear}-${month.padStart(2, '0')}`] || {};
                        var sum = Object.values(monthData).reduce((acc, count) => acc + parseInt(count, 10), 0);
                        return sum;
                    }),

                    borderWidth: 2,
                    fill: true,
                        };
                    });
                } else {
                    labels = [];
                    datasets = [];
                    chartData.map(function (entry, index) {
                        var selectedMonthData = entry.data[selectedMonth];
                        if (index === 0) {
                            labels = Object.keys(selectedMonthData);
                        }
                        var dataset = {
                            label: entry.label,
                            data: Object.values(selectedMonthData),

                            borderWidth: 2,
                            fill: true,
                        };
                        datasets.push(dataset);
                    });
                }

                var ctx = document.getElementById("combinedChart").getContext('2d');
                combinedChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: labels,
                        datasets: datasets,
                    },
                    options: chartOptions,
                });
            }
            // Initial chart creation
            createOrUpdateChart(@json($chartData), null);

            document.addEventListener('chartDataUpdated', function ($event) {
                console.log('Updated',$event.detail);
                createOrUpdateChart($event.detail); // Update the chart when data changes
            });
        });
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

                let alertMessage = `{{__('Name:')}} ${information.clientName}<br>`;
                alertMessage += `{{__('Invoice Created Date:')}} ${information.invoiceCreated}<br>`;
                alertMessage += `{{__('Total Cost ($) :')}} $ ${information.totalCostDollar}<br>`;
                alertMessage += `{{__('Total Cost (IQD)')}} : ${information.totalCostIraqi} IQD<br><br>`;

                // Display information for each service
                information.services.forEach(data => {
                    alertMessage += `{{__('Event Date:')}} ${data.actionDate}<br>`;
                    alertMessage += `{{__('Description:')}} ${data.description}<br>`;
                    data.services.forEach(service => {
                    alertMessage += `{{__('Service Code:')}} ${service.serviceCode}<br>`;
                    alertMessage += `{{__('Service Description:')}} ${service.serviceDescription}<br>`;
                    alertMessage += `{{__('Service Default Cost (USD):')}}  ${service.serviceDefaultCostDollar}<br>`;
                    alertMessage += `{{__('Service Default Cost (IQD):')}}  ${service.serviceDefaultCostIraqi}<br>`;
                    alertMessage += `{{__('Service Quantity:')}} ${service.serviceQty}<br>`;
                    alertMessage += `{{__('Service Total Cost (USD):')}} ${service.serviceTotalDollar}<br>`;
                    alertMessage += `{{__('Service Total Cost (IQD):')}} ${service.serviceTotalIraqi}<br>`;
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