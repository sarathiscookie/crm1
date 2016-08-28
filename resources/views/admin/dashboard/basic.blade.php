@extends('admin.layouts.layout-basic')

@section('title', 'Dashboard')

@section('scripts')
  <script src="/assets/admin/js/dashboard/dashboard.js"></script>
  <script src="/assets/admin/js/dashboard/tooltip.js"></script>
  <script>
    /* Sales chart begin */
    var salesPrice = <?php echo json_encode($salesPrice); ?>;
    var salesCost  = <?php echo json_encode($salesCost); ?>;

    var barChartData = {
      labels: <?php echo json_encode($salesMonth); ?>,
      datasets: [{
        label: 'Price',
        backgroundColor: "rgba(255, 99, 132, 0.2)",
        borderColor: "rgba(255,99,132,1)",
        data: salesPrice
      },
        {
          label: 'Cost',
          backgroundColor: "rgba(79, 196, 127,0.2)",
          data: salesCost
        }]
    };

    window.onload = function() {
      var ctx = document.getElementById("salesReport").getContext("2d");
      window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
          elements: {
            rectangle: {
              backgroundColor: "rgba(79, 196, 127,0.2)",
              borderColor: "rgba(79, 196, 127,1)",
              borderWidth: 1,
              hoverBackgroundColor: "rgba(79, 196, 127,0.4)",
              hoverBorderColor: "rgba(79, 196, 127,1)",
            }
          },
          responsive: true,
          maintainAspectRatio: false,
        }
      });

    };
    /* Sales chart end */

    /* Orders status begin */
    var ordersCountBooking    = <?php echo json_encode($ordersCountBooking); ?>;
    var ordersCountMembership = <?php echo json_encode($ordersCountMembership); ?>;

    var myLineChart = {
      labels: <?php echo json_encode($ordersMonth); ?>,
      datasets: [{
        label: 'Booking',
        backgroundColor: "rgba(0,125,204,0.4)",
        data: ordersCountBooking
      },
        {
        label: 'Membership',
        backgroundColor: "rgba(255, 206, 86, 0.2)",
        borderColor: "rgba(255, 206, 86, 1)",
        data: ordersCountMembership
      }]
    };

    $(function() {
      $('[data-toggle="tooltip"]').tooltip()
      var context = document.getElementById("orderStats").getContext("2d");
      window.myLine = new Chart(context, {
        type: 'line',
        data: myLineChart,
        options: {
          elements: {
            rectangle: {
              fill: false,
              lineTension: 0.1,
              backgroundColor: "rgba(0,125,204,0.4)",
              borderColor: "rgba(0,125,204,1)",
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
            }
          },
          responsive: true,
          maintainAspectRatio: false,
        }
      });

    });
    /* Orders status end */
  </script>
@stop

@section('content')
<div class="main-content">
  <div class="row">
    <div class="col-md-12 col-lg-6 col-xl-3" data-toggle="tooltip" data-placement="top" title="Top hotel from three months">
      @if(isset($topHotelCount))
      <a class="dashbox" href="#">
        <i class="fa fa-flag text-primary"></i>
        <span class="title">
          {{ $topHotelCount->count }}
        </span>
        <span class="desc">
          {{ $topHotelCount->title }}
        </span>
      </a>
      @endif
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3" data-toggle="tooltip" data-placement="top" title="Top school from three months">
      @if(isset($topSchoolCount))
      <a class="dashbox" href="#">
        <i class="fa fa-flag text-success"></i>
        <span class="title">
          {{ $topSchoolCount->count }}
        </span>
        <span class="desc">
          {{ $topSchoolCount->title }}
        </span>
      </a>
      @endif
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3" data-toggle="tooltip" data-placement="top" title="Top offer from three months">
      @if(isset($topOfferCount))
      <a class="dashbox" href="#">
        <i class="fa fa-flag text-danger"></i>
        <span class="title">
          {{ $topOfferCount->count }}
        </span>
        <span class="desc">
          {{ $topOfferCount->title }}
        </span>
      </a>
      @endif
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3">
      <a class="dashbox" href="#">
        <i class="fa fa-comments text-info"></i>
        <span class="title">
          59
        </span>
        <span class="desc">
          Comments
        </span>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-xl-6 m-t-2">
      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-line-chart text-warning"></i> Orders Stats</h4>
        </div>
        <div class="card-block">
          <div class="graph-container">
            <canvas id="orderStats" width="760" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-xl-6 m-t-2">
      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-bar-chart text-success"></i> Sales Chart</h4>
        </div>
        <div class="card-block">
          <div class="graph-container">
            <canvas id="salesReport" width="760" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-xl-6 m-t-2">
      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-shopping-cart text-danger"></i> Recent Orders</h4>
        </div>
        <div class="card-block">
          <table class="table">
            <thead>
              <tr>
                <th>Booking Id</th>
                <th>Invoice Id</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @if(isset($bookings))
              @forelse($bookings as $booking)
                <tr>
                  <td>{{ $booking->id }}</td>
                  <td>{{ $booking->invoice_id }}</td>
                  <td>{{ date('d.m.Y', strtotime($booking->created_at)) }}</td>
                  <td><a href="{{ route('adminBookingShow', $booking->id) }}" class="btn btn-default btn-xs">View</a></td>
                </tr>
              @empty
                <tr> No new bookings </tr>
              @endforelse
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-xl-6 m-t-2">
      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-users text-info"></i> New Customers</h4>
        </div>
        <div class="card-block">
          <table class="table">
            <thead>
              <tr>
                <th>Customer Name</th>
                <th>City</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @if(isset($customers))
              @forelse($customers as $customer)
                <tr>
                  <td>{{ $customer->firstname }} {{ $customer->lastname }}</td>
                  <td>{{ $customer->city }}</td>
                  <td>{{ date('d.m.Y', strtotime($customer->created_at)) }}</td>
                  <td><a href="{{ route('admin.customer.show', $customer->id) }}" class="btn btn-default btn-xs">View</a></td>
                </tr>
              @empty
                <tr> No new customers </tr>
              @endforelse
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

