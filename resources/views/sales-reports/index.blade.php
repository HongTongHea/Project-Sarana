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
                </div>
                <div class="table-responsive">
                    <table id="DataTableReports" class="table mt-3 table-border table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Report Type</th>
                                <th>Date & Time</th>
                                <th>Total Orders</th>
                                <th>Total Sales</th>
                                {{-- <th>Total Tax</th> --}}
                                <th>Avg Order Value</th>
                                <th>Report Date & Time</th>
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
                                        {{ $report->start_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }} -
                                        {{ $report->end_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">{{ number_format($report->total_orders) }}</span>
                                    </td>
                                    <td class="text-success fw-bold">
                                        ${{ number_format($report->total_sales, 2) }}
                                    </td>
                                    {{-- <td class="text-warning">
                                        ${{ number_format($report->total_tax, 2) }}
                                    </td> --}}
                                    <td class="text-info fw-bold">
                                        ${{ number_format($report->average_order_value, 2) }}
                                    </td>
                                    <td>{{ $report->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}
                                    </td>
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
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $report->id }}">
                                                        <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                                        Report Details
                                                    </button>
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
                                <!-- Include Modals for each report -->
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
    @foreach ($reports as $report)
        @include('sales-reports.show', ['report' => $report])
        @include('sales-reports.delete', ['report' => $report])
    @endforeach
    <!-- Include Generate Report Modals -->
    @include('sales-reports.create')
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        // $('#DataTableReports').DataTable({
        //     "pageLength": 25,
        //     "order": [
        //         [7, 'desc']
        //     ],
        //     "language": {
        //         "search": "Search reports:",
        //         "lengthMenu": "Show _MENU_ entries"
        //     }
        // });

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

            if (type === 'monthly' && !month) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select a month',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $('#yearMonthModal').modal('hide');

            if (type === 'monthly') {
                generateMonthlyReport(year, month);
            } else if (type === 'yearly') {
                generateYearlyReport(year);
            }
        });

        // Generate weekly report
        function generateWeeklyReport() {
            showLoading('Generating weekly report...');

            $.ajax({
                url: '{{ route('sales-reports.generate-weekly') }}',
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
            showLoading('Generating monthly report...');

            $.ajax({
                url: '{{ route('sales-reports.generate-monthly') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    year: year,
                    month: month ? new Date(month).getMonth() + 1 : null
                },
                success: handleReportResponse,
                error: handleAjaxError
            });
        }

        // Generate yearly report
        function generateYearlyReport(year) {
            showLoading('Generating yearly report...');

            $.ajax({
                url: '{{ route('sales-reports.generate-yearly') }}',
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
            hideLoading();
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
            hideLoading();
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: xhr.responseJSON?.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'OK'
            });
        }

        // Loading functions
        function showLoading(message = 'Loading...') {
            Swal.fire({
                title: message,
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function hideLoading() {
            Swal.close();
        }
    });

    // Print report function
    function printReport(reportId) {
        const modalContent = document.querySelector(`#showModal${reportId} .modal-content`).cloneNode(true);
        const printWindow = window.open('', '_blank');

        // Remove buttons from print version
        const modalFooter = modalContent.querySelector('.modal-footer');
        if (modalFooter) {
            modalFooter.remove();
        }

        printWindow.document.write(`
            <html>
                <head>
                    <title>Sales Report - ${reportId}</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body { padding: 20px; font-family: Arial, sans-serif; }
                        @media print {
                            .no-print { display: none !important; }
                            .table { border-collapse: collapse; }
                            .table-bordered th, .table-bordered td { border: 1px solid #dee2e6 !important; }
                        }
                        .modal-content { border: none !important; box-shadow: none !important; }
                        .modal-header { border-bottom: 2px solid #dee2e6; }
                        pre { white-space: pre-wrap; word-wrap: break-word; }
                    </style>
                </head>
                <body>
                    <div class="container-fluid">
                        ${modalContent.innerHTML}
                    </div>
                    <div class="no-print mt-4 text-center">
                        <button onclick="window.print()" class="btn btn-primary me-2">Print</button>
                        <button onclick="window.close()" class="btn btn-secondary">Close</button>
                    </div>
                </body>
            </html>
        `);
        printWindow.document.close();
    }
</script>
