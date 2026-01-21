@extends('layouts.app')
@section('title', 'AngkorTech Computer | Sales Reports')
@section('content')
    <div class="container-fluid">
        <!-- Summary Cards -->
        <div id="summaryCards" class="row mt-5">
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Reports</p>
                                    <h4 class="card-title" id="totalReports">{{ number_format($reports->total() ?? 0) }}
                                    </h4>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Sales</p>
                                    <h4 class="card-title" id="totalSales">
                                        ${{ number_format($reports->sum('total_sales') ?? 0, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Orders</p>
                                    <h4 class="card-title" id="totalOrders">
                                        {{ number_format($reports->sum('total_orders') ?? 0) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Avg Order Value</p>
                                    <h4 class="card-title" id="avgOrderValue">
                                        ${{ number_format($reports->avg('average_order_value') ?? 0, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="card shadow-sm rounded-0 mt-3">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Sales Reports</h4>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                            <i class="fas fa-chart-line me-1"></i> Generate Report
                        </button>
                        <select class="form-select form-select-sm" id="reportTypeFilter" style="width: 150px;">
                            <option value="">All Report Types</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="DataTable" class="table table-border table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Report Type</th>
                                <th>Date & Time</th>
                                <th>Total Orders</th>
                                <th>Total Sales</th>
                                <th>Avg Order Value</th>
                                <th>Report Date & Time</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reportsTableBody">
                            @forelse ($reports as $index => $report)
                                <tr>
                                    <td class="text-center fw-bold">{{ $reports->firstItem() + $index }}</td>
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
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $report->id }}">
                                                        <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                                        Report Details
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('sales-reports.data', $report->id) }}"
                                                        target="_blank">
                                                        <i class="fa-solid fa-download me-2 text-primary"></i>
                                                        Download Data
                                                    </a>
                                                </li>
                                                <li>
                                                    @if (Auth::user()->role === 'admin')
                                                        <button class="dropdown-item d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $report->id }}">
                                                            <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                            Delete
                                                        </button>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No reports found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div id="paginationContainer">
                    @if ($reports->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of
                                {{ $reports->total() }} entries
                            </div>
                            <div>
                                {{ $reports->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modals Container -->
    <div id="modalsContainer">
        @foreach ($reports as $report)
            @include('sales-reports.show', ['report' => $report])
            @include('sales-reports.delete', ['report' => $report])
        @endforeach
    </div>

    <!-- Include Generate Report Modals -->
    @include('sales-reports.create')
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Auto-submit on select change
        $('#reportTypeFilter').on('change', function() {
            loadReports(1);
        });

        // Handle pagination links (delegated event)
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) {
                const page = new URL(url).searchParams.get('page') || 1;
                loadReports(page);
            }
        });

        // Load reports via AJAX
        function loadReports(page = 1) {
            const reportType = $('#reportTypeFilter').val();

            $.ajax({
                url: '{{ route('sales-reports.index') }}',
                type: 'GET',
                data: {
                    report_type: reportType,
                    page: page
                },
                beforeSend: function() {
                    // Optional: Add loading state
                    $('#reportsTableBody').html(
                        '<tr><td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>'
                    );
                },
                success: function(response) {
                    console.log('Response:', response); // Debug

                    if (response.reports && response.reports.data) {
                        updateSummaryCards(response.summary);
                        updateTable(response.reports.data, response.reports.from);
                        updatePagination(response.reports);
                        updateModals(response.modals || '');
                    } else {
                        console.error('Invalid response format:', response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Invalid response format from server.',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error loading reports:', xhr);

                    let errorMessage = 'Failed to load reports. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Reports endpoint not found.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Server error occurred.';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });

                    // Restore empty state
                    $('#reportsTableBody').html(
                        '<tr><td colspan="8" class="text-center">Failed to load reports</td></tr>'
                    );
                }
            });
        }

        // Update summary cards
        function updateSummaryCards(summary) {
            if (summary) {
                $('#totalReports').text(formatNumber(summary.total_reports || 0));
                $('#totalSales').text('$' + formatNumber(summary.total_sales || 0, 2));
                $('#totalOrders').text(formatNumber(summary.total_orders || 0));
                $('#avgOrderValue').text('$' + formatNumber(summary.avg_order_value || 0, 2));
            }
        }

        // Update table with new data
        function updateTable(reports, startIndex = 1) {
            const tbody = $('#reportsTableBody');
            tbody.empty();

            if (!reports || reports.length === 0) {
                tbody.append('<tr><td colspan="8" class="text-center">No reports found</td></tr>');
                return;
            }

            reports.forEach((report, index) => {
                const badgeClass = report.report_type === 'weekly' ? 'bg-primary' :
                    report.report_type === 'monthly' ? 'bg-success' : 'bg-info';

                const deleteButton = report.can_delete ? `
                    <li>
                        <button class="dropdown-item d-flex align-items-center"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal${report.id}">
                            <i class="fa-solid fa-trash me-2 text-danger"></i>
                            Delete
                        </button>
                    </li>
                ` : '';

                const row = `
                    <tr>
                        <td class="text-center fw-bold">${startIndex + index}</td>
                        <td>
                            <span class="badge ${badgeClass}">
                                ${report.report_type.charAt(0).toUpperCase() + report.report_type.slice(1)}
                            </span>
                        </td>
                        <td>${report.start_date} - ${report.end_date}</td>
                        <td class="text-center">
                            <span class="fw-bold">${formatNumber(report.total_orders)}</span>
                        </td>
                        <td class="text-success fw-bold">$${formatNumber(report.total_sales, 2)}</td>
                        <td class="text-info fw-bold">$${formatNumber(report.average_order_value, 2)}</td>
                        <td>${report.created_at}</td>
                        <td class="text-nowrap text-center">
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton${report.id}" data-bs-toggle="dropdown"
                                    aria-expanded="false" title="Actions">
                                    <i class="fas fa-ellipsis-v fs-6"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${report.id}">
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center"
                                            data-bs-toggle="modal"
                                            data-bs-target="#showModal${report.id}">
                                            <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                            Report Details
                                        </button>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="/sales-reports/${report.id}/data"
                                            target="_blank">
                                            <i class="fa-solid fa-download me-2 text-primary"></i>
                                            Download Data
                                        </a>
                                    </li>
                                    ${deleteButton}
                                </ul>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Update pagination
        function updatePagination(paginationData) {
            const container = $('#paginationContainer');
            container.empty();

            if (!paginationData || paginationData.last_page <= 1) {
                return;
            }

            let paginationHtml = `
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing ${paginationData.from || 0} to ${paginationData.to || 0} of ${paginationData.total || 0} entries
                    </div>
                    <nav>
                        <ul class="pagination mb-0">
            `;

            // Previous button
            if (paginationData.current_page > 1) {
                paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" href="?page=${paginationData.current_page - 1}">Previous</a>
                    </li>
                `;
            } else {
                paginationHtml += `
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                `;
            }

            // Page numbers
            for (let i = 1; i <= paginationData.last_page; i++) {
                const activeClass = i === paginationData.current_page ? 'active' : '';
                paginationHtml += `
                    <li class="page-item ${activeClass}">
                        <a class="page-link" href="?page=${i}">${i}</a>
                    </li>
                `;
            }

            // Next button
            if (paginationData.current_page < paginationData.last_page) {
                paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" href="?page=${paginationData.current_page + 1}">Next</a>
                    </li>
                `;
            } else {
                paginationHtml += `
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                `;
            }

            paginationHtml += `
                        </ul>
                    </nav>
                </div>
            `;

            container.html(paginationHtml);
        }

        // Update modals
        function updateModals(modalsHtml) {
            $('#modalsContainer').html(modalsHtml);
        }

        // Format number helper
        function formatNumber(num, decimals = 0) {
            if (num === null || num === undefined || num === '') return decimals > 0 ? '0.' + '0'.repeat(
                decimals) : '0';
            return Number(num).toLocaleString('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            });
        }

        // Handle report type button click
        $(document).on('click', '.generate-report-btn', function() {
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
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
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
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                data: {
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
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                data: {
                    year: year
                },
                success: handleReportResponse,
                error: handleAjaxError
            });
        }

        // Handle report response
        function handleReportResponse(response) {
            hideLoading();
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    loadReports(1);
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

        // Loading functions (using SweetAlert)
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
