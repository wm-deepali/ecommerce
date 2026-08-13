@include('admin.top-header')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  /* ── Design Tokens ──────────────────────────────────────────── */
  :root {
    --bg: #f1f2f4;
    --surface: #ffffff;
    --border: #e3e5e8;
    --text-primary: #202223;
    --text-secondary: #6d7175;
    --text-hint: #8c9196;
    --accent: #303d89;
    /* Shopify indigo-navy */
    --accent-light: #f0f1fc;
    --green: #007a5e;
    --green-bg: #e3f1ec;
    --amber: #916a00;
    --amber-bg: #fff5cc;
    --blue: #0069d9;
    --blue-bg: #e8f2ff;
    --red: #b22222;
    --red-bg: #fce8e8;
    --radius-sm: 8px;
    --radius-md: 12px;
    --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
    --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  }

  /* ── Reset for content area ─────────────────────────────────── */
  .content-area * {
    box-sizing: border-box;
  }

  .content-area {
    background: var(--bg);
    padding: 24px 28px;
    min-height: 100vh;
    font-family: var(--font);
    color: var(--text-primary);
  }

  /* ── Page header ────────────────────────────────────────────── */
  .dash-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .dash-page-header h1 {
    font-size: 20px;
    font-weight: 650;
    color: var(--text-primary) !important;
    margin: 0;
  }

  .dash-page-header .dash-meta {
    font-size: 13px;
    color: var(--text-secondary);
    margin-top: 2px;
  }

  .dash-date-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 7px 13px;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary);
    cursor: pointer;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
  }

  /* ── Surface card ───────────────────────────────────────────── */
  .cardx {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 20px;
    box-shadow: var(--shadow-card);
    height: 100%;
    transition: box-shadow .18s;
  }

  .cardx:hover {
    box-shadow: 0 3px 10px rgba(0, 0, 0, .1), 0 0 0 1px var(--border);
  }

  .cardx h1,
  .cardx h2,
  .cardx h3,
  .cardx h4,
  .cardx h5,
  .cardx h6,
  .cardx p,
  .cardx td,
  .cardx th,
  .cardx li {
    color: var(--text-primary) !important;
  }

  .cardx h5 {
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .02em;
    text-transform: uppercase;
    color: var(--text-secondary) !important;
    margin-bottom: 16px;
  }

  /* ── KPI cards ──────────────────────────────────────────────── */
  .kpi-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 20px 20px 18px;
    box-shadow: var(--shadow-card);
    position: relative;
    height: 100%;
    transition: box-shadow .18s;
  }

  .kpi-card:hover {
    box-shadow: 0 3px 10px rgba(0, 0, 0, .1), 0 0 0 1px var(--border);
  }

  .kpi-label {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
    margin-bottom: 6px;
  }

  .kpi-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-primary) !important;
    line-height: 1.1;
    margin-bottom: 10px;
  }

  .kpi-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 20px;
  }

  .kpi-badge.up {
    background: var(--green-bg);
    color: var(--green);
  }

  .kpi-badge.warn {
    background: var(--amber-bg);
    color: var(--amber);
  }

  .kpi-badge.info {
    background: var(--blue-bg);
    color: var(--blue);
  }

  .kpi-icon {
    position: absolute;
    top: 18px;
    right: 18px;
    width: 36px;
    height: 36px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    opacity: .85;
  }

  .kpi-icon.purple {
    background: #ede9fe;
    color: #6d28d9;
  }

  .kpi-icon.green {
    background: var(--green-bg);
    color: var(--green);
  }

  .kpi-icon.blue {
    background: var(--blue-bg);
    color: var(--blue);
  }

  .kpi-icon.amber {
    background: var(--amber-bg);
    color: var(--amber);
  }

  .kpi-divider {
    height: 1px;
    background: var(--border);
    margin: 14px -20px;
  }

  .kpi-sub {
    font-size: 12px;
    color: var(--text-hint);
  }

  /* ── Revenue banner ─────────────────────────────────────────── */
  .revenue-banner {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 22px 24px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    box-shadow: var(--shadow-card);
  }

  .revenue-banner .greet {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 2px;
  }

  .revenue-banner .sub {
    font-size: 13px;
    color: var(--text-secondary);
  }

  .revenue-banner .rev-num {
    text-align: right;
  }

  .revenue-banner .rev-num span {
    font-size: 26px;
    font-weight: 700;
    color: var(--text-primary);
    display: block;
    line-height: 1.1;
  }

  .revenue-banner .rev-num small {
    font-size: 12px;
    color: var(--text-hint);
  }

  /* ── Progress bars ──────────────────────────────────────────── */
  .progress {
    height: 6px;
    border-radius: 10px;
    background: var(--bg);
    overflow: hidden;
  }

  .progress-bar {
    border-radius: 10px;
  }

  .progress-row {
    margin-bottom: 14px;
  }

  .progress-row:last-child {
    margin-bottom: 0;
  }

  .progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin-bottom: 5px;
  }

  .progress-label span:first-child {
    color: var(--text-secondary);
    font-weight: 500;
  }

  .progress-label span:last-child {
    color: var(--text-primary);
    font-weight: 600;
  }

  /* ── Table ──────────────────────────────────────────────────── */
  .dash-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }

  .dash-table thead th {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--text-hint) !important;
    padding: 0 12px 10px;
    border-bottom: 1px solid var(--border);
    text-align: left;
  }

  .dash-table tbody tr {
    border-bottom: 1px solid var(--bg);
    transition: background .12s;
  }

  .dash-table tbody tr:hover {
    background: var(--bg);
  }

  .dash-table tbody tr:last-child {
    border-bottom: none;
  }

  .dash-table tbody td {
    padding: 11px 12px;
    color: var(--text-primary) !important;
    vertical-align: middle;
  }

  /* ── Status badges ──────────────────────────────────────────── */
  .status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
  }

  .status-pill::before {
    content: '';
    width: 5px;
    height: 5px;
    border-radius: 50%;
    display: inline-block;
  }

  .status-pill.delivered {
    background: var(--green-bg);
    color: var(--green);
  }

  .status-pill.delivered::before {
    background: var(--green);
  }

  .status-pill.pending {
    background: var(--amber-bg);
    color: var(--amber);
  }

  .status-pill.pending::before {
    background: var(--amber);
  }

  .status-pill.processing {
    background: var(--blue-bg);
    color: var(--blue);
  }

  .status-pill.processing::before {
    background: var(--blue);
  }

  .status-pill.cancelled,
  .status-pill.returned {
    background: var(--red-bg);
    color: var(--red);
  }

  .status-pill.cancelled::before,
  .status-pill.returned::before {
    background: var(--red);
  }

  /* ── Top products list ──────────────────────────────────────── */
  .product-rank-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--bg);
    font-size: 13px;
  }

  .product-rank-item:last-child {
    border-bottom: none;
  }

  .product-rank-item .rank {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: var(--text-secondary);
    flex-shrink: 0;
    margin-right: 10px;
  }

  .product-rank-item .name {
    flex: 1;
    font-weight: 500;
    color: var(--text-primary);
  }

  .product-rank-item .qty {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary);
    background: var(--bg);
    padding: 2px 8px;
    border-radius: 6px;
  }

  /* ── Section label ──────────────────────────────────────────── */
  .section-label {
    font-size: 16px;
    font-weight: 650;
    color: var(--text-primary);
    margin-bottom: 14px;
  }

  /* ── Chart wrapper ──────────────────────────────────────────── */
  .chart-wrap {
    position: relative;
    height: 220px;
  }

  @media (max-width: 768px) {
    .content-area {
      padding: 16px;
    }

    .revenue-banner {
      padding: 16px;
    }

    .kpi-value {
      font-size: 24px;
    }
  }
</style>

<div class="main-section">
  @include('admin.header')

  <div class="container-fluid">
    <div class="content-area">

      <!-- Page header -->
      <div class="dash-page-header">
        <div>
          <h1>Overview</h1>
          <div class="dash-meta">Welcome back, {{ auth()->user()->name }}</div>
        </div>
        <div class="dash-date-badge">
          <i class="fa fa-calendar-alt" style="color:var(--text-hint)"></i>
          {{ now()->format('jS M, Y') }}
          <i class="fa fa-chevron-down" style="font-size:10px;color:var(--text-hint)"></i>
        </div>
      </div>

      @if($showStockBanner)
        <div class="alert alert-danger d-flex justify-content-between align-items-center mb-4">
          <div>
            <strong>
              <i class="fa fa-exclamation-triangle"></i>
              Stock Alert
            </strong>
            <br>
            {{ $criticalProducts->count() }} products are critically low or out of stock.
          </div>

          <a href="{{ route('admin.stock.alerts', ['severity' => 'critical']) }}" class="btn btn-sm btn-light">
            View Products
          </a>
        </div>
      @endif

      <!-- Revenue banner -->
      <div class="revenue-banner">
        <div>
          <div class="greet">Total Revenue This Month</div>
          <div class="sub">Compared to last month across all channels</div>
        </div>
        <div class="rev-num">
          <span>₹{{ number_format($revenueThisMonth) }}</span>
          <small class="kpi-badge {{ $revenueGrowth >= 0 ? 'up' : 'warn' }}" style="display:inline-flex;margin-top:4px;">
            <i class="fa fa-arrow-{{ $revenueGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($revenueGrowth) }}% vs last month
          </small>
        </div>
      </div>

      <!-- KPI row -->
      <div class="row g-3 mb-4">

        <div class="col-lg-3 col-md-6">
          <div class="kpi-card">
            <div class="kpi-icon purple"><i class="fa fa-box"></i></div>
            <div class="kpi-label">Total Products</div>
            <div class="kpi-value">{{ number_format($totalProducts) }}</div>
            <div class="kpi-divider"></div>
            <div style="display:flex;align-items:center;gap:8px">
              <span class="kpi-badge {{ $productGrowth >= 0 ? 'up' : 'warn' }}">
                <i class="fa fa-arrow-{{ $productGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($productGrowth) }}%
              </span>
              <span class="kpi-sub">since last month</span>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="kpi-card">
            <div class="kpi-icon green"><i class="fa fa-shopping-cart"></i></div>
            <div class="kpi-label">Total Orders</div>
            <div class="kpi-value">{{ number_format($totalOrders) }}</div>
            <div class="kpi-divider"></div>
            <div style="display:flex;align-items:center;gap:8px">
              <span class="kpi-badge {{ $orderGrowth >= 0 ? 'up' : 'warn' }}">
                <i class="fa fa-arrow-{{ $orderGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($orderGrowth) }}%
              </span>
              <span class="kpi-sub">since last month</span>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="kpi-card">
            <div class="kpi-icon blue"><i class="fa fa-users"></i></div>
            <div class="kpi-label">Customers</div>
            <div class="kpi-value">{{ number_format($totalCustomers) }}</div>
            <div class="kpi-divider"></div>
            <div style="display:flex;align-items:center;gap:8px">
              <span class="kpi-badge info">
                <i class="fa fa-arrow-{{ $customerGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($customerGrowth) }}%
              </span>
              <span class="kpi-sub">since last month</span>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="kpi-card">
            <div class="kpi-icon amber"><i class="fa fa-wallet"></i></div>
            <div class="kpi-label">Pending Payments</div>
            <div class="kpi-value">₹{{ number_format($pendingPayments) }}</div>
            <div class="kpi-divider"></div>
            <div style="display:flex;align-items:center;gap:8px">
              <span class="kpi-badge warn"><i class="fa fa-clock"></i> Awaiting</span>
              <span class="kpi-sub">{{ $pendingPaymentsCount }} transactions</span>
            </div>
          </div>
        </div>

      </div>

      <!-- Charts row -->
      <div class="row g-3 mb-4">

        <div class="col-lg-8">
          <div class="cardx">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
              <div class="section-label" style="margin:0">Sales Analytics</div>
              <div style="display:flex;gap:6px">
                <span class="kpi-badge up" style="cursor:pointer">Revenue</span>
                <span
                  style="font-size:12px;color:var(--text-hint);padding:3px 8px;border-radius:20px;cursor:pointer;">Orders</span>
              </div>
            </div>
            <div class="chart-wrap">
              <canvas id="salesChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="cardx">
            <div class="section-label">Order Status</div>

            <div class="progress-row">
              <div class="progress-label">
                <span>Pending</span><span>{{ $pendingPct }}%</span>
              </div>
              <div class="progress">
                <div class="progress-bar" style="width:{{ $pendingPct }}%;background:var(--amber)"></div>
              </div>
            </div>

            <div class="progress-row">
              <div class="progress-label">
                <span>Processing</span><span>{{ $processingPct }}%</span>
              </div>
              <div class="progress">
                <div class="progress-bar" style="width:{{ $processingPct }}%;background:var(--blue)"></div>
              </div>
            </div>

            <div class="progress-row">
              <div class="progress-label">
                <span>Delivered</span><span>{{ $deliveredPct }}%</span>
              </div>
              <div class="progress">
                <div class="progress-bar" style="width:{{ $deliveredPct }}%;background:var(--green)"></div>
              </div>
            </div>

            <div style="margin-top:24px;padding-top:16px;border-top:1px solid var(--border)">
              <div class="section-label" style="font-size:14px">Quick stats</div>
              <div
                style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-secondary);margin-top:10px">
                <span>Avg. order value</span>
                <span style="font-weight:600;color:var(--text-primary)">₹{{ number_format($avgOrderValue) }}</span>
              </div>
              <div
                style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-secondary);margin-top:8px">
                <span>Return rate</span>
                <span style="font-weight:600;color:var(--text-primary)">{{ $returnRate }}%</span>
              </div>
              <div
                style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-secondary);margin-top:8px">
                <span>Fulfilled today</span>
                <span style="font-weight:600;color:var(--text-primary)">{{ $fulfilledToday }}</span>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Orders + Top Products -->
      <div class="row g-3 mb-4">

        <div class="col-lg-8">
          <div class="cardx">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
              <div class="section-label" style="margin:0">Recent Orders</div>
              <a href="{{ route('admin.orders.index') }}" style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:500">View all →</a>
            </div>

            <table class="dash-table">
              <thead>
                <tr>
                  <th>Order</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentOrders as $order)
                  <tr>
                    <td style="font-weight:600">#{{ $order->order_number }}</td>
                    <td>
                      <div style="display:flex;align-items:center;gap:9px">
                        <div
                          style="width:30px;height:30px;border-radius:50%;background:var(--accent-light);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--accent)">
                          {{ strtoupper(substr($order->customer_name ?? 'NA', 0, 2)) }}
                        </div>
                        {{ $order->customer_name }}
                      </div>
                    </td>
                    <td style="font-weight:600">₹{{ number_format($order->grand_total) }}</td>
                    <td><span class="status-pill {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" style="text-align:center;color:var(--text-hint);padding:20px 0">No orders yet</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="cardx">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
              <div class="section-label" style="margin:0">Top Selling Products</div>
              <span style="font-size:11px;color:var(--text-hint)">This month</span>
            </div>

            @forelse($topProducts as $i => $product)
              <div class="product-rank-item">
                <div class="rank">{{ $i + 1 }}</div>
                <div class="name">{{ $product->product_name }}</div>
                <div class="qty">{{ $product->total_qty }}</div>
              </div>
            @empty
              <p style="color:var(--text-hint);font-size:13px;margin:0">No sales recorded this month.</p>
            @endforelse
          </div>
        </div>

      </div>

    </div><!-- /content-area -->
  </div><!-- /container-fluid -->
</div><!-- /main-section -->

@include('admin.footer')

<script>
  (function () {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($chartLabels),
        datasets: [{
          label: 'Revenue (₹)',
          data: @json($chartData),
          fill: true,
          tension: 0.45,
          borderColor: '#303d89',
          borderWidth: 2.5,
          pointBackgroundColor: '#303d89',
          pointRadius: 4,
          pointHoverRadius: 6,
          backgroundColor: (ctx) => {
            const chart = ctx.chart;
            const { ctx: c, chartArea } = chart;
            if (!chartArea) return 'transparent';
            const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
            g.addColorStop(0, 'rgba(48,61,137,.18)');
            g.addColorStop(1, 'rgba(48,61,137,0)');
            return g;
          }
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#202223',
            titleFont: { size: 12 },
            bodyFont: { size: 13, weight: '600' },
            padding: 10,
            cornerRadius: 8,
            callbacks: {
              label: v => ' ₹' + v.parsed.y.toLocaleString('en-IN')
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: '#8c9196', font: { size: 12 } },
            border: { display: false }
          },
          y: {
            grid: { color: '#f1f2f4', lineWidth: 1 },
            ticks: {
              color: '#8c9196',
              font: { size: 12 },
              callback: v => '₹' + (v / 1000).toFixed(0) + 'k'
            },
            border: { display: false }
          }
        }
      }
    });
  })();
</script>