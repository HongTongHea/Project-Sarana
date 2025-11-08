@extends('layouts.app')
@section('title', 'AngkorTech Computer | Sales Reports')
@section('content')
    <div class="container-fluid mt-3">
        <div class="card shadow rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Sales Reports</h4>

                </div>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 mb-3 ml-2">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                        <i class="fas fa-chart-line"></i> Generate Report
                    </button>
                    <!-- Filter by Report Type -->
                    <select class="form-select form-select-sm" id="reportTypeFilter" style="width: auto;">
                        <option value="">All Report Types</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                    <!-- Generate Report Button -->

                </div>
                <div class="table-responsive">
                    <table id="DataTableReports" class="table mt-3 table-border table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Report Type</th>
                                <th>Period</th>
                                <th>Total Orders</th>
                                <th>Total Sales</th>
                                <th>Total Tax</th>
                                <th>Avg Order Value</th>
                                <th>Generated Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($report->report_type == 'weekly') bg-primary
                                            @elseif($report->report_type == 'monthly') bg-success
                                            @else bg-info @endif">
                                            {{ ucfirst($report->report_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $report->start_date->format('M d, Y') }} -
                                        {{ $report->end_date->format('M d, Y') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">{{ number_format($report->total_orders) }}</span>
                                    </td>
                                    <td class="text-success fw-bold">
                                        ${{ number_format($report->total_sales, 2) }}
                                    </td>
                                    <td class="text-warning">
                                        ${{ number_format($report->total_tax, 2) }}
                                    </td>
                                    <td class="text-info fw-bold">
                                        ${{ number_format($report->average_order_value, 2) }}
                                    </td>
                                    <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $report->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $report->id }}">
                                                <!-- View Report -->
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('sales-reports.show', $report->id) }}">
                                                        <i class="fa-solid fa-eye me-2 text-info"></i>
                                                        View Report
                                                    </a>
                                                </li>

                                                <!-- Download Report -->
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('sales-reports.data', $report->id) }}"
                                                        target="_blank">
                                                        <i class="fa-solid fa-download me-2 text-primary"></i>
                                                        Download Data
                                                    </a>
                                                </li>

                                                <!-- Delete Report -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $report->id }}">
                                                        <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @include('sales-reports.delete', ['report' => $report])
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($reports->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }}
                            entries
                        </div>
                        <div>
                            {{ $reports->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Generate Report Modal -->
    <div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="generateReportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateReportModalLabel">Generate Sales Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <button type="button" class="list-group-item list-group-item-action generate-report-btn"
                            data-type="weekly">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="d-block"> <i class="fas fa-calendar text-danger"></i> Weekly
                                        Report</strong>
                                    <small class="text-muted">Generate report for current week or custom date range</small>
                                </div>

                            </div>
                        </button>

                        <button type="button" class="list-group-item list-group-item-action generate-report-btn"
                            data-type="monthly">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="d-block"> <i class="fas fa-calendar-alt text-success"></i> Monthly
                                        Report</strong>
                                    <small class="text-muted">Generate report for specific month</small>
                                </div>

                            </div>
                        </button>

                        <button type="button" class="list-group-item list-group-item-action generate-report-btn"
                            data-type="yearly">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="d-block"> <i class="fas fa-calendar text-info"></i> Yearly
                                        Report</strong>
                                    <small class="text-muted">Generate report for specific year</small>
                                </div>

                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Date Range Modal -->
    <div class="modal fade" id="customDateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Custom Date Range</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="customDateForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="reportType" name="report_type">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Year/Month Picker Modal -->
    <div class="modal fade" id="yearMonthModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Report Period</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="yearMonthForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="reportTypeSelect" name="report_type">

                        <div class="mb-3">
                            <label for="report_year" class="form-label fw-semibold">Year</label>
                            <input type="number" id="report_year" name="year" class="form-control" min="2000"
                                max="2100" value="{{ date('Y') }}" required>
                        </div>

                        <div class="mb-3" id="monthPickerWrapper">
                            <label for="report_month" class="form-label fw-semibold">Month</label>
                            <input type="month" id="report_month" name="month" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#DataTableReports').DataTable({
            "pageLength": 25,
            "order": [
                [7, 'desc']
            ]
        });

        // Filter by report type
        $('#reportTypeFilter').on('change', function() {
            const type = $(this).val();
            $('#DataTableReports').DataTable().column(1).search(type).draw();
        });

        // Handle report type button click
        $('.generate-report-btn').on('click', function() {
            const type = $(this).data('type');
            $('#generateReportModal').modal('hide');

            if (type === 'weekly') {
                generateWeeklyReport();
            } else {
                $('#reportTypeSelect').val(type);
                if (type === 'yearly') {
                    $('#monthPickerWrapper').hide();
                } else {
                    $('#monthPickerWrapper').show();
                }
                $('#yearMonthModal').modal('show');
            }
        });

        // Handle Year/Month form submission
        $('#yearMonthForm').on('submit', function(e) {
            e.preventDefault();
            const type = $('#reportTypeSelect').val();
            const year = $('#report_year').val();
            const month = $('#report_month').val();

            $('#yearMonthModal').modal('hide');

            if (type === 'monthly') {
                generateMonthlyReport(year, month);
            } else if (type === 'yearly') {
                generateYearlyReport(year);
            }
        });

        // Generate weekly report
        function generateWeeklyReport() {
            $.ajax({
                url: '{{ route('sales-reports.weekly') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: handleReportResponse,
                error: handleAjaxError
            });
        }

        // Generate monthly report
        function generateMonthlyReport(year, month) {
            $.ajax({
                url: '{{ route('sales-reports.monthly') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    year: year,
                    month: new Date(month).getMonth() + 1 // Correct month number
                },
                success: handleReportResponse,
                error: handleAjaxError
            });
        }

        // Generate yearly report
        function generateYearlyReport(year) {
            $.ajax({
                url: '{{ route('sales-reports.yearly') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    year: year
                },
                success: handleReportResponse,
                error: handleAjaxError
            });
        }

        // ✅ SweetAlert for success/error messages
        function handleReportResponse(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message,
                    confirmButtonText: 'OK'
                });
            }
        }

        function handleAjaxError(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: xhr.responseJSON?.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'OK'
            });
        }
    });
</script>
