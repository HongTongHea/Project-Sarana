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
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                            <i class="fas fa-chart-line me-1"></i> Generate Report
                        </button>
                        <button class="btn btn-success btn-sm" id="exportExcelBtn">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </button>
                        <select class="form-select form-select-md" id="reportTypeFilter" style="width: 150px;">
                            <option value="">All Report Types</option>
                            <option value="daily">Daily</option>
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
                                <th>Period</th>
                                <th>Total Orders</th>
                                <th>Total Sales</th>
                                <th>Avg Order Value</th>
                                <th>Report Date & Time</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reportsTableBody">
                            @forelse ($reports as $index => $report)
                                <tr data-id="{{ $report->id }}" data-type="{{ $report->report_type }}"
                                    data-start="{{ $report->start_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y') }}"
                                    data-end="{{ $report->end_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y') }}"
                                    data-orders="{{ $report->total_orders }}" data-sales="{{ $report->total_sales }}"
                                    data-avg="{{ $report->average_order_value }}"
                                    data-created="{{ $report->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}">
                                    <td class="text-center fw-bold">{{ $reports->firstItem() + $index }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($report->report_type == 'daily') bg-warning text-dark
                                            @elseif($report->report_type == 'weekly') bg-primary
                                            @elseif($report->report_type == 'monthly') bg-success
                                            @else bg-info @endif">
                                            {{ ucfirst($report->report_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $report->start_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y') }} -
                                        {{ $report->end_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y') }}
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

    <!-- Include Generate Report Modal -->
    @include('sales-reports.create')
@endsection
<style>
    .card-stats {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-stats:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2) !important;
    }
</style>
{{-- SheetJS for Excel export --}}
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {

        // ─── Filter ────────────────────────────────────────────────────────────────
        $('#reportTypeFilter').on('change', function() {
            loadReports(1);
        });

        // ─── Pagination (delegated) ─────────────────────────────────────────────
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) {
                const page = new URL(url).searchParams.get('page') || 1;
                loadReports(page);
            }
        });

        // ─── AJAX load reports ──────────────────────────────────────────────────
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
                    $('#reportsTableBody').html(
                        '<tr><td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>'
                    );
                },
                success: function(response) {
                    if (response.reports && response.reports.data) {
                        updateSummaryCards(response.summary);
                        updateTable(response.reports.data, response.reports.from);
                        updatePagination(response.reports);
                        updateModals(response.modals || '');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Invalid response format from server.'
                        });
                    }
                },
                error: function(xhr) {
                    let msg = 'Failed to load reports. Please try again.';
                    if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                    else if (xhr.status === 404) msg = 'Reports endpoint not found.';
                    else if (xhr.status === 500) msg = 'Server error occurred.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: msg
                    });
                    $('#reportsTableBody').html(
                        '<tr><td colspan="8" class="text-center">Failed to load reports</td></tr>'
                    );
                }
            });
        }

        // ─── Summary cards ──────────────────────────────────────────────────────
        function updateSummaryCards(summary) {
            if (!summary) return;
            $('#totalReports').text(formatNumber(summary.total_reports || 0));
            $('#totalSales').text('$' + formatNumber(summary.total_sales || 0, 2));
            $('#totalOrders').text(formatNumber(summary.total_orders || 0));
            $('#avgOrderValue').text('$' + formatNumber(summary.avg_order_value || 0, 2));
        }

        // ─── Update table rows ──────────────────────────────────────────────────
        function updateTable(reports, startIndex = 1) {
            const tbody = $('#reportsTableBody');
            tbody.empty();

            if (!reports || reports.length === 0) {
                tbody.append('<tr><td colspan="8" class="text-center">No reports found</td></tr>');
                return;
            }

            reports.forEach((report, index) => {
                let badgeClass = 'bg-info';
                if (report.report_type === 'daily') badgeClass = 'bg-warning text-dark';
                else if (report.report_type === 'weekly') badgeClass = 'bg-primary';
                else if (report.report_type === 'monthly') badgeClass = 'bg-success';

                const deleteBtn = report.can_delete ? `
                <li>
                    <button class="dropdown-item d-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#deleteModal${report.id}">
                        <i class="fa-solid fa-trash me-2 text-danger"></i> Delete
                    </button>
                </li>` : '';

                tbody.append(`
                <tr
                    data-id="${report.id}"
                    data-type="${report.report_type}"
                    data-start="${report.start_date}"
                    data-end="${report.end_date}"
                    data-orders="${report.total_orders}"
                    data-sales="${report.total_sales}"
                    data-avg="${report.average_order_value}"
                    data-created="${report.created_at}"
                >
                    <td class="text-center fw-bold">${startIndex + index}</td>
                    <td><span class="badge ${badgeClass}">${capitalize(report.report_type)}</span></td>
                    <td>${report.start_date} - ${report.end_date}</td>
                    <td class="text-center"><span class="fw-bold">${formatNumber(report.total_orders)}</span></td>
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
                                        data-bs-toggle="modal" data-bs-target="#showModal${report.id}">
                                        <i class="fa-solid fa-circle-info me-2 text-info"></i> Report Details
                                    </button>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="/sales-reports/${report.id}/data" target="_blank">
                                        <i class="fa-solid fa-download me-2 text-primary"></i> Download Data
                                    </a>
                                </li>
                                ${deleteBtn}
                            </ul>
                        </div>
                    </td>
                </tr>
            `);
            });
        }

        // ─── Pagination ─────────────────────────────────────────────────────────
        function updatePagination(p) {
            const container = $('#paginationContainer');
            container.empty();
            if (!p || p.last_page <= 1) return;

            let html = `
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">Showing ${p.from || 0} to ${p.to || 0} of ${p.total || 0} entries</div>
                <nav><ul class="pagination mb-0">`;

            html += p.current_page > 1 ?
                `<li class="page-item"><a class="page-link" href="?page=${p.current_page - 1}">Previous</a></li>` :
                `<li class="page-item disabled"><span class="page-link">Previous</span></li>`;

            for (let i = 1; i <= p.last_page; i++) {
                html += `<li class="page-item ${i === p.current_page ? 'active' : ''}">
                        <a class="page-link" href="?page=${i}">${i}</a>
                     </li>`;
            }

            html += p.current_page < p.last_page ?
                `<li class="page-item"><a class="page-link" href="?page=${p.current_page + 1}">Next</a></li>` :
                `<li class="page-item disabled"><span class="page-link">Next</span></li>`;

            html += `</ul></nav></div>`;
            container.html(html);
        }

        function updateModals(html) {
            $('#modalsContainer').html(html);
        }

        // ─── Helpers ────────────────────────────────────────────────────────────
        function formatNumber(num, decimals = 0) {
            if (num === null || num === undefined || num === '')
                return decimals > 0 ? '0.' + '0'.repeat(decimals) : '0';
            return Number(num).toLocaleString('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            });
        }

        function capitalize(str) {
            return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
        }

        // ─── EXCEL EXPORT ───────────────────────────────────────────────────────
        $('#exportExcelBtn').on('click', function() {
            const rows = [];

            // Collect data from current visible rows via data-* attributes
            $('#reportsTableBody tr[data-id]').each(function(i) {
                const $tr = $(this);
                rows.push({
                    'No': i + 1,
                    'Report Type': capitalize($tr.data('type')),
                    'Start Date': $tr.data('start'),
                    'End Date': $tr.data('end'),
                    'Total Orders': Number($tr.data('orders')),
                    'Total Sales ($)': Number($tr.data('sales')),
                    'Avg Order Value ($)': Number($tr.data('avg')),
                    'Report Date & Time': $tr.data('created'),
                });
            });

            if (rows.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Data',
                    text: 'There are no reports to export.'
                });
                return;
            }

            // ── Build workbook ──────────────────────────────────────────────────
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.json_to_sheet([]); // start empty

            // ── Title / meta rows ───────────────────────────────────────────────
            const filterLabel = $('#reportTypeFilter').val() ?
                capitalize($('#reportTypeFilter').val()) + ' Reports' :
                'All Reports';
            const exportDate = new Date().toLocaleString('en-US', {
                timeZone: 'Asia/Phnom_Penh'
            });

            XLSX.utils.sheet_add_aoa(ws, [
                ['AngkorTech Computer – Sales Report'],
                [`Filter: ${filterLabel}`],
                [`Exported: ${exportDate}`],
                [], // blank spacer
            ], {
                origin: 'A1'
            });

            // ── Header row ──────────────────────────────────────────────────────
            const headers = [
                'No', 'Report Type', 'Start Date', 'End Date',
                'Total Orders', 'Total Sales ($)', 'Avg Order Value ($)', 'Report Date & Time'
            ];
            XLSX.utils.sheet_add_aoa(ws, [headers], {
                origin: 'A5'
            });

            // ── Data rows ────────────────────────────────────────────────────────
            const dataRows = rows.map(r => [
                r['No'],
                r['Report Type'],
                r['Start Date'],
                r['End Date'],
                r['Total Orders'],
                r['Total Sales ($)'],
                r['Avg Order Value ($)'],
                r['Report Date & Time'],
            ]);
            XLSX.utils.sheet_add_aoa(ws, dataRows, {
                origin: 'A6'
            });

            // ── Summary rows ─────────────────────────────────────────────────────
            const totalOrders = rows.reduce((s, r) => s + r['Total Orders'], 0);
            const totalSales = rows.reduce((s, r) => s + r['Total Sales ($)'], 0);
            const avgValue = rows.length ? rows.reduce((s, r) => s + r['Avg Order Value ($)'], 0) / rows
                .length : 0;
            const summaryStart = 6 + rows.length + 1;

            XLSX.utils.sheet_add_aoa(ws, [
                [],
                ['', '', '', 'TOTALS', totalOrders, totalSales, avgValue, ''],
            ], {
                origin: `A${summaryStart}`
            });

            // ── Column widths ────────────────────────────────────────────────────
            ws['!cols'] = [{
                    wch: 5
                }, // No
                {
                    wch: 14
                }, // Report Type
                {
                    wch: 14
                }, // Start Date
                {
                    wch: 14
                }, // End Date
                {
                    wch: 14
                }, // Total Orders
                {
                    wch: 16
                }, // Total Sales
                {
                    wch: 20
                }, // Avg Order Value
                {
                    wch: 22
                }, // Report Date
            ];

            // ── Merge title cell ─────────────────────────────────────────────────
            ws['!merges'] = [{
                    s: {
                        r: 0,
                        c: 0
                    },
                    e: {
                        r: 0,
                        c: 7
                    }
                }, // Title
                {
                    s: {
                        r: 1,
                        c: 0
                    },
                    e: {
                        r: 1,
                        c: 7
                    }
                }, // Filter label
                {
                    s: {
                        r: 2,
                        c: 0
                    },
                    e: {
                        r: 2,
                        c: 7
                    }
                }, // Export date
            ];

            // ── Cell styles via !ref & manual style objects ───────────────────────
            // Title (A1)
            if (!ws['A1']) ws['A1'] = {
                v: 'AngkorTech Computer – Sales Report',
                t: 's'
            };
            ws['A1'].s = {
                font: {
                    bold: true,
                    sz: 16,
                    color: {
                        rgb: 'FFFFFF'
                    }
                },
                fill: {
                    fgColor: {
                        rgb: '1A3C5E'
                    }
                },
                alignment: {
                    horizontal: 'center',
                    vertical: 'center'
                },
            };

            // Sub-title rows (A2, A3)
            ['A2', 'A3'].forEach(cell => {
                if (ws[cell]) ws[cell].s = {
                    font: {
                        italic: true,
                        sz: 11,
                        color: {
                            rgb: '444444'
                        }
                    },
                    alignment: {
                        horizontal: 'center'
                    },
                };
            });

            // Header row (row index 4 = row 5 in sheet)
            const headerCols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
            headerCols.forEach(col => {
                const ref = `${col}5`;
                if (ws[ref]) ws[ref].s = {
                    font: {
                        bold: true,
                        color: {
                            rgb: 'FFFFFF'
                        },
                        sz: 11
                    },
                    fill: {
                        fgColor: {
                            rgb: '2E7D32'
                        }
                    },
                    alignment: {
                        horizontal: 'center',
                        vertical: 'center',
                        wrapText: true
                    },
                    border: {
                        top: {
                            style: 'thin',
                            color: {
                                rgb: 'FFFFFF'
                            }
                        },
                        bottom: {
                            style: 'thin',
                            color: {
                                rgb: 'FFFFFF'
                            }
                        },
                        left: {
                            style: 'thin',
                            color: {
                                rgb: 'FFFFFF'
                            }
                        },
                        right: {
                            style: 'thin',
                            color: {
                                rgb: 'FFFFFF'
                            }
                        },
                    },
                };
            });

            // Data rows – alternate banding + number format
            for (let i = 0; i < rows.length; i++) {
                const sheetRow = 6 + i; // 1-based row in sheet
                const isEven = i % 2 === 0;
                const bgColor = isEven ? 'F5F9F5' : 'FFFFFF';

                headerCols.forEach((col, ci) => {
                    const ref = `${col}${sheetRow}`;
                    if (!ws[ref]) ws[ref] = {
                        v: dataRows[i][ci],
                        t: 'n'
                    };

                    ws[ref].s = {
                        fill: {
                            fgColor: {
                                rgb: bgColor
                            }
                        },
                        alignment: {
                            horizontal: ci === 0 ? 'center' : 'left',
                            vertical: 'center'
                        },
                        border: {
                            top: {
                                style: 'hair',
                                color: {
                                    rgb: 'CCCCCC'
                                }
                            },
                            bottom: {
                                style: 'hair',
                                color: {
                                    rgb: 'CCCCCC'
                                }
                            },
                            left: {
                                style: 'hair',
                                color: {
                                    rgb: 'CCCCCC'
                                }
                            },
                            right: {
                                style: 'hair',
                                color: {
                                    rgb: 'CCCCCC'
                                }
                            },
                        },
                    };

                    // Currency format for sales/avg columns
                    if (ci === 5 || ci === 6) {
                        ws[ref].z = '"$"#,##0.00';
                        ws[ref].t = 'n';
                    }
                    // Number format for orders
                    if (ci === 4) {
                        ws[ref].z = '#,##0';
                        ws[ref].t = 'n';
                    }
                });
            }

            // Summary row styling
            const summaryRow = summaryStart + 1;
            ['D', 'E', 'F', 'G'].forEach((col, i) => {
                const ref = `${col}${summaryRow}`;
                if (ws[ref]) {
                    ws[ref].s = {
                        font: {
                            bold: true,
                            color: {
                                rgb: '1A3C5E'
                            }
                        },
                        fill: {
                            fgColor: {
                                rgb: 'E8F5E9'
                            }
                        },
                        alignment: {
                            horizontal: 'center'
                        },
                        border: {
                            top: {
                                style: 'medium',
                                color: {
                                    rgb: '2E7D32'
                                }
                            },
                            bottom: {
                                style: 'medium',
                                color: {
                                    rgb: '2E7D32'
                                }
                            },
                        },
                    };
                    if (i === 2 || i === 3) {
                        ws[ref].z = '"$"#,##0.00';
                        ws[ref].t = 'n';
                    }
                    if (i === 1) {
                        ws[ref].z = '#,##0';
                        ws[ref].t = 'n';
                    }
                }
            });

            // Row heights
            ws['!rows'] = [{
                    hpt: 30
                }, // Title
                {
                    hpt: 18
                }, // Filter
                {
                    hpt: 18
                }, // Export date
                {
                    hpt: 8
                }, // Spacer
                {
                    hpt: 22
                }, // Header
            ];

            // ── Append sheet & download ──────────────────────────────────────────
            XLSX.utils.book_append_sheet(wb, ws, 'Sales Reports');

            const fileName = `AngkorTech_SalesReport_${new Date().toISOString().slice(0,10)}.xlsx`;
            XLSX.writeFile(wb, fileName, {
                bookType: 'xlsx',
                type: 'binary'
            });

            Swal.fire({
                icon: 'success',
                title: 'Exported!',
                text: `${rows.length} report(s) exported to ${fileName}`,
                timer: 2500,
                showConfirmButton: false,
            });
        });

        // ─── Generate report buttons ────────────────────────────────────────────
        $(document).on('click', '.generate-report-btn', function() {
            const type = $(this).data('type');
            $('#generateReportModal').modal('hide');

            if (type === 'daily') generateDailyReport();
            else if (type === 'weekly') generateWeeklyReport();
            else {
                $('#reportTypeSelect').val(type);
                $('#monthPickerWrapper')[type === 'yearly' ? 'hide' : 'show']();
                $('#yearMonthModal').modal('show');
            }
        });

        $('#yearMonthForm').on('submit', function(e) {
            e.preventDefault();
            const type = $('#reportTypeSelect').val();
            const year = $('#report_year').val();
            const month = $('#report_month').val();

            if (type === 'monthly' && !month) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select a month.'
                });
            }
            $('#yearMonthModal').modal('hide');

            if (type === 'monthly') generateMonthlyReport(year, month);
            else if (type === 'yearly') generateYearlyReport(year);
        });

        function generateDailyReport() {
            showLoading('Generating daily report…');
            $.ajax({
                url: '{{ route('sales-reports.generate-daily') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                success: handleReportResponse,
                error: handleAjaxError
            });
        }

        function generateWeeklyReport() {
            showLoading('Generating weekly report…');
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

        function generateMonthlyReport(year, month) {
            showLoading('Generating monthly report…');
            $.ajax({
                url: '{{ route('sales-reports.generate-monthly') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                data: {
                    year,
                    month: month ? new Date(month).getMonth() + 1 : null
                },
                success: handleReportResponse,
                error: handleAjaxError
            });
        }

        function generateYearlyReport(year) {
            showLoading('Generating yearly report…');
            $.ajax({
                url: '{{ route('sales-reports.generate-yearly') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                data: {
                    year
                },
                success: handleReportResponse,
                error: handleAjaxError
            });
        }

        function handleReportResponse(response) {
            hideLoading();
            if (response.success) {
                Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message
                    })
                    .then(() => loadReports(1));
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message
                });
            }
        }

        function handleAjaxError(xhr) {
            hideLoading();
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: xhr.responseJSON?.message || 'Something went wrong. Please try again.'
            });
        }

        function showLoading(msg = 'Loading…') {
            Swal.fire({
                title: msg,
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        }

        function hideLoading() {
            Swal.close();
        }
    });

    // ─── Print ────────────────────────────────────────────────────────────────────
    function printReport(reportId) {
        const modalContent = document.querySelector(`#showModal${reportId} .modal-content`).cloneNode(true);
        const printWindow = window.open('', '_blank');
        const footer = modalContent.querySelector('.modal-footer');
        if (footer) footer.remove();

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
                        .table-bordered th,
                        .table-bordered td { border: 1px solid #dee2e6 !important; }
                    }
                    .modal-content { border: none !important; box-shadow: none !important; }
                    .modal-header  { border-bottom: 2px solid #dee2e6; }
                    pre { white-space: pre-wrap; word-wrap: break-word; }
                </style>
            </head>
            <body>
                <div class="container-fluid">${modalContent.innerHTML}</div>
                <div class="no-print mt-4 text-center">
                    <button onclick="window.print()" class="btn btn-primary me-2">Print</button>
                    <button onclick="window.close()"  class="btn btn-secondary">Close</button>
                </div>
            </body>
        </html>
    `);
        printWindow.document.close();
    }
</script>
