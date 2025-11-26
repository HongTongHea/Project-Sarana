<!-- Generate Report Modal -->
<div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="generateReportModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px"
                    id="generateReportModalLabel">Generate Sales Report</h6>
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

<!-- Year/Month Picker Modal -->
<div class="modal fade" id="yearMonthModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black text-uppercase fw-bold">Select Report Period</h5>
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
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"> <i
                            class="fas fa-times me-2"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i
                            class="fas fa-cogs me-1"></i>Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
