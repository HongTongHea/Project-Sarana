<!-- Modal for Report Details -->
<div class="modal fade" id="showModal{{ $report->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $report->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark fw-bold text-uppercase" id="showModalLabel{{ $report->id }}">
                    Sales Report Details - {{ ucfirst($report->report_type) }} Report
                </h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Report Summary -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Report Summary</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <th class="text-nowrap">Report Type:</th>
                                                <td>
                                                    <span
                                                        class="badge 
                                                        @if ($report->report_type == 'weekly') bg-primary
                                                        @elseif($report->report_type == 'monthly') bg-success
                                                        @else bg-info @endif">
                                                        {{ ucfirst($report->report_type) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Period:</th>
                                                <td>
                                                    {{ $report->start_date->format('M d, Y') }} -
                                                    {{ $report->end_date->format('M d, Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Generated At:</th>
                                                <td>{{ $report->created_at->format('M d, Y H:i:s') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <th>Total Sales:</th>
                                                <td class="text-success fw-bold">
                                                    ${{ number_format($report->total_sales, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Orders:</th>
                                                <td class="fw-bold">{{ number_format($report->total_orders) }}</td>
                                            </tr>
                                            <tr>
                                                {{-- <th>Total Tax:</th>
                                                <td class="text-warning">${{ number_format($report->total_tax, 2) }}
                                                </td> --}}
                                            </tr>
                                            <tr>
                                                <th>Avg Order Value:</th>
                                                <td class="text-info fw-bold">
                                                    ${{ number_format($report->average_order_value, 2) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Breakdown -->
                @php
                    // Check if report_data is already an array or needs decoding
                    if (is_string($report->report_data)) {
                        $breakdownData = json_decode($report->report_data, true);
                    } else {
                        $breakdownData = $report->report_data;
                    }
                @endphp

                @if ($report->report_type === 'weekly' && isset($breakdownData['daily_sales']))
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-calendar-day me-2"></i>Daily Sales Breakdown
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Date</th>
                                                    <th class="text-end">Sales</th>
                                                    <th class="text-center">Orders</th>
                                                    <th class="text-end">Avg Order Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($breakdownData['daily_sales'] as $date => $data)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</td>
                                                        <td class="text-end text-success fw-bold">
                                                            ${{ number_format($data['sales'] ?? 0, 2) }}</td>
                                                        <td class="text-center">{{ $data['orders'] ?? 0 }}</td>
                                                        <td class="text-end text-info">
                                                            ${{ number_format(($data['sales'] ?? 0) / max(1, $data['orders'] ?? 0), 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($report->report_type === 'monthly' && isset($breakdownData['weekly_breakdown']))
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Weekly Breakdown</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Week</th>
                                                    <th class="text-end">Sales</th>
                                                    <th class="text-center">Orders</th>
                                                    <th class="text-end">Avg Order Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($breakdownData['weekly_breakdown'] as $week => $data)
                                                    <tr>
                                                        <td>{{ $week }}</td>
                                                        <td class="text-end text-success fw-bold">
                                                            ${{ number_format($data['sales'] ?? 0, 2) }}</td>
                                                        <td class="text-center">{{ $data['orders'] ?? 0 }}</td>
                                                        <td class="text-end text-info">
                                                            ${{ number_format(($data['sales'] ?? 0) / max(1, $data['orders'] ?? 0), 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($report->report_type === 'yearly' && isset($breakdownData['monthly_breakdown']))
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Monthly Breakdown</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Month</th>
                                                    <th class="text-end">Sales</th>
                                                    <th class="text-center">Orders</th>
                                                    <th class="text-end">Avg Order Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($breakdownData['monthly_breakdown'] as $month => $data)
                                                    <tr>
                                                        <td>{{ $month }}</td>
                                                        <td class="text-end text-success fw-bold">
                                                            ${{ number_format($data['sales'] ?? 0, 2) }}</td>
                                                        <td class="text-center">{{ $data['orders'] ?? 0 }}</td>
                                                        <td class="text-end text-info">
                                                            ${{ number_format(($data['sales'] ?? 0) / max(1, $data['orders'] ?? 0), 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- 
                <!-- Additional breakdown sections can be added here for other report types -->

                @if (empty($breakdownData['daily_sales']) && empty($breakdownData['weekly_breakdown']) && empty($breakdownData['monthly_breakdown']))
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No detailed breakdown available for this report.
                            </div>
                        </div>
                    </div>
                @endif --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="printReport({{ $report->id }})">
                    <i class="fas fa-print me-2"></i>Print Report
                </button>
            </div>
        </div>
    </div>
</div>
