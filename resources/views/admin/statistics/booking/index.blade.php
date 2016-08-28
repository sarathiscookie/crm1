@extends('admin.layouts.layout-basic')

@section('title', 'Booking Analyze')

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">Booking Analyze</h3>
            <ol class="breadcrumb">
                <li><a href="">Home</a></li>
                <li class="">Statistics</li>
                <li class="active">Booking Analyze</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Booking Analyze</h3>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 m-b-3">
                                <div class="col-xl-8 col-lg-6 m-b-2">
                                    <h5 class="section-semi-title">
                                        Date Range
                                    </h5>
                                    <div class="col-xl-6 col-lg-6 m-b-2">
                                        <div class="input-group input-daterange">
                                            <input type="text" class="form-control ls-datepicker dateFrom">
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="form-control ls-datepicker dateTo">
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-6 m-b-2">
                                        <button class="btn btn-primary ladda-button dateDifference" data-style="expand-left"><span class="ladda-label">Submit</span></button>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="m-b-2">
                            <h5 class="section-semi-title">
                                Line Chart
                            </h5>
                            <canvas id="lineChart" width="400" height="400"></canvas>
                            <div id="graph-container">
                                <canvas id="lineChartDateRange" width="400" height="400" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*Date picker date format*/
        $('.dateFrom').datepicker({
            format: 'dd/mm/yyyy'
        });
        $('.dateTo').datepicker({
            format: 'dd/mm/yyyy'
        });

        var Charts = function () {

            var handleLineChart = function(){

                var ctx =  $('#lineChart');

                var data = {
                    labels: <?php echo json_encode($ordersMonth); ?>,
                    datasets: [
                        {
                            label: "Booking",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: <?php echo json_encode($ordersCountBooking); ?>,
                        },
                        {
                            label: "Membership",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(0,125,204,0.4)",
                            borderColor: "rgba(0,125,204,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(0,125,204,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(0,125,204,1)",
                            pointHoverBorderColor: "rgba(0,125,204,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: <?php echo json_encode($ordersCountMembership); ?>,
                        },
                    ]
                };

                var options = {
                    responsive: true,
                    maintainAspectRatio: false,
                };

                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: options
                });
            };

            return {
                //main function to initiate the module
                init: function () {
                    handleLineChart();
                }
            };

        }();

        jQuery(document).ready(function() {
            Charts.init();

            $(".dateDifference").on("click", function(){
                var fromDate   = $(".dateFrom").val();
                var toDate     = $(".dateTo").val();
                $('#lineChartDateRange').remove(); // this is my <canvas> element
                $('#graph-container').append('<canvas id="lineChartDateRange"><canvas>');
                $.post('{{ route('statisticsBookingShow') }}', {fromDate: fromDate, toDate: toDate}, function(response){
                    $('#lineChart').hide();
                    $("#lineChartDateRange").attr("height", "400");
                    $("#lineChartDateRange").attr("width", "400");
                    $('#lineChartDateRange').show();
                            var ctx =  $('#lineChartDateRange');

                            var data = {
                                labels: response.ordersMonth,
                                datasets: [
                                    {
                                        label: "Booking",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(75,192,192,0.4)",
                                        borderColor: "rgba(75,192,192,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(75,192,192,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                        pointHoverBorderColor: "rgba(220,220,220,1)",
                                        pointHoverBorderWidth: 2,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: response.ordersCountBooking,
                                    },
                                    {
                                        label: "Membership",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(0,125,204,0.4)",
                                        borderColor: "rgba(0,125,204,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(0,125,204,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(0,125,204,1)",
                                        pointHoverBorderColor: "rgba(0,125,204,1)",
                                        pointHoverBorderWidth: 2,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: response.ordersCountMembership,
                                    },
                                ]
                            };

                            var options = {
                                responsive: true,
                                maintainAspectRatio: false,
                            };

                            var myLineChart = new Chart(ctx, {
                                type: 'line',
                                data: data,
                                options: options
                            });

                });
            });

            // Ladda Buttons
            Ladda.bind( 'div:not(.progress-demo) .ladda-button', { timeout: 2000 } );

            // Bind progress buttons and simulate loading progress
            Ladda.bind( '.progress-demo button', {
                callback: function( instance ) {
                    //alert($(".ls-datepicker").val());
                    var progress = 0;
                    var interval = setInterval( function() {
                        progress = Math.min( progress + Math.random() * 0.1, 1 );
                        instance.setProgress( progress );

                        if( progress === 1 ) {
                            instance.stop();
                            clearInterval( interval );
                        }
                    }, 200 );
                }
            });
        });
    </script>
@stop