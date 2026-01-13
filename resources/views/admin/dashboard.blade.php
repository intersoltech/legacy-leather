@extends('admin.layout')
@section('title','Dashboard')

@push('styles')
<link href="{{ asset('assets/vendor/apexcharts/apexcharts.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Sales <span>| Today</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ number_format($todaySales) }}</h6>
                  <span class="text-success small pt-1 fw-bold">{{ $ordersCount > 0 ? number_format(($todaySales / $ordersCount) * 100, 1) : 0 }}%</span> <span class="text-muted small pt-2 ps-1">of total</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Revenue <span>| This Month</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6>${{ number_format($monthRevenue, 0) }}</h6>
                  <span class="text-success small pt-1 fw-bold">{{ $totalRevenue > 0 ? number_format(($monthRevenue / $totalRevenue) * 100, 1) : 0 }}%</span> <span class="text-muted small pt-2 ps-1">of total</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Customers <span>| Total</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ number_format($customersCount) }}</h6>
                  <span class="text-success small pt-1 fw-bold">{{ $ordersCount > 0 ? number_format(($customersCount / $ordersCount) * 100, 1) : 0 }}%</span> <span class="text-muted small pt-2 ps-1">conversion</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Customers Card -->

        <!-- Reports -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Reports <span>/Last 7 Days</span></h5>
              <!-- Line Chart -->
              <div id="reportsChart"></div>
            </div>
          </div>
        </div><!-- End Reports -->

        <!-- Recent Sales -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="card-body">
              <h5 class="card-title">Recent Sales <span>| Today</span></h5>
              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Order Ref</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentOrders as $order)
                  <tr>
                    <th scope="row"><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a></th>
                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="text-primary">{{ $order->order_ref }}</a></td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>
                      <span class="badge 
                        @if($order->status === 'completed') bg-success
                        @elseif($order->status === 'pending') bg-warning
                        @elseif($order->status === 'cancelled') bg-danger
                        @else bg-secondary
                        @endif">
                        {{ ucfirst($order->status) }}
                      </span>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center">No orders yet</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- End Recent Sales -->

        <!-- Top Selling -->
        <div class="col-12">
          <div class="card top-selling overflow-auto">
            <div class="card-body pb-0">
              <h5 class="card-title">Top Selling <span>| All Time</span></h5>
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">Preview</th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Sold</th>
                    <th scope="col">Revenue</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($topProducts as $product)
                  <tr>
                    <th scope="row">
                      <a href="#">
                        <img src="{{ image_url($product->product_image, 'assets/img/logo.png') }}" alt="{{ $product->product_name }}" style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                      </a>
                    </th>
                    <td><a href="#" class="text-primary fw-bold">{{ $product->product_name }}</a></td>
                    <td>${{ number_format($product->avg_price / 100, 2) }}</td>
                    <td class="fw-bold">{{ number_format($product->total_sold) }}</td>
                    <td>${{ number_format($product->total_revenue / 100, 2) }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center">No sales data yet</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- End Top Selling -->

      </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4">

      <!-- Recent Activity -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Recent Activity <span>| Today</span></h5>
          <div class="activity">
            @php
              $activities = [];
              // Recent orders
              foreach($recentOrders->take(5) as $order) {
                $activities[] = [
                  'type' => 'order',
                  'time' => $order->created_at->diffForHumans(),
                  'text' => 'New order #' . $order->order_ref . ' from ' . $order->first_name . ' ' . $order->last_name,
                  'badge' => $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger')
                ];
              }
            @endphp
            @forelse($activities as $activity)
            <div class="activity-item d-flex">
              <div class="activite-label">{{ $activity['time'] }}</div>
              <i class='bi bi-circle-fill activity-badge text-{{ $activity['badge'] }} align-self-start'></i>
              <div class="activity-content">
                {{ $activity['text'] }}
              </div>
            </div><!-- End activity item-->
            @empty
            <div class="activity-item d-flex">
              <div class="activite-label">No activity</div>
              <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
              <div class="activity-content">
                No recent activity
              </div>
            </div>
            @endforelse
          </div>
        </div>
      </div><!-- End Recent Activity -->

      <!-- Budget Report -->
      <div class="card">
        <div class="card-body pb-0">
          <h5 class="card-title">Revenue Report <span>| Last 6 Months</span></h5>
          <div id="budgetChart" style="min-height: 400px;" class="echart"></div>
        </div>
      </div><!-- End Budget Report -->

      <!-- Website Traffic -->
      <div class="card">
        <div class="card-body pb-0">
          <h5 class="card-title">Orders by Status <span>| Overview</span></h5>
          <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
        </div>
      </div><!-- End Website Traffic -->

    </div><!-- End Right side columns -->

  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Reports Chart (ApexCharts)
  const reportsChartEl = document.querySelector("#reportsChart");
  if (reportsChartEl) {
    new ApexCharts(reportsChartEl, {
      series: [{
        name: 'Sales',
        data: @json($salesData)
      }, {
        name: 'Revenue',
        data: @json($revenueData)
      }, {
        name: 'Customers',
        data: @json($customersData)
      }],
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false
        },
      },
      markers: {
        size: 4
      },
      colors: ['#4154f1', '#2eca6a', '#ff771d'],
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.3,
          opacityTo: 0.4,
          stops: [0, 90, 100]
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 2
      },
      xaxis: {
        type: 'datetime',
        categories: @json($dates)
      },
      tooltip: {
        x: {
          format: 'dd/MM/yy HH:mm'
        },
      }
    }).render();
  }

  // Budget Chart (ECharts) - Revenue by Month
  const budgetChartEl = document.querySelector("#budgetChart");
  if (budgetChartEl) {
    const budgetChart = echarts.init(budgetChartEl);
    const revenueData = @json($revenueByMonth->pluck('revenue')->toArray());
    const monthLabels = @json($revenueByMonth->map(function($item) {
      return \Carbon\Carbon::createFromFormat('Y-m', $item->month)->format('M Y');
    })->toArray());

    budgetChart.setOption({
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'shadow'
        }
      },
      grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
      },
      xAxis: {
        type: 'category',
        data: monthLabels,
        axisTick: {
          alignWithLabel: true
        }
      },
      yAxis: {
        type: 'value'
      },
      series: [{
        name: 'Revenue',
        type: 'bar',
        data: revenueData,
        itemStyle: {
          color: '#4154f1'
        }
      }]
    });
  }

  // Traffic Chart (ECharts) - Orders by Status
  const trafficChartEl = document.querySelector("#trafficChart");
  if (trafficChartEl) {
    const trafficChart = echarts.init(trafficChartEl);
    const statusData = @json(collect($ordersByStatus)->map(function($count, $status) {
      return ['value' => $count, 'name' => ucfirst($status)];
    })->values()->toArray());

    trafficChart.setOption({
      tooltip: {
        trigger: 'item'
      },
      legend: {
        top: '5%',
        left: 'center'
      },
      series: [{
        name: 'Orders',
        type: 'pie',
        radius: ['40%', '70%'],
        avoidLabelOverlap: false,
        label: {
          show: false,
          position: 'center'
        },
        emphasis: {
          label: {
            show: true,
            fontSize: '18',
            fontWeight: 'bold'
          }
        },
        labelLine: {
          show: false
        },
        data: statusData
      }]
    });
  }
});
</script>
@endpush
