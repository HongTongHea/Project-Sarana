<!-- Create Sales Report Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('sales-reports.generate') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                            Generate Sales Report
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-2">
                    <div class="row m-2">
                        <div class="form-group col-12 col-md-6">
                            <label for="period" class="fw-semibold">Period Type</label>
                            <select id="period" name="period" class="form-control" required>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly" selected>Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="start_date" class="fw-semibold">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="end_date" class="fw-semibold">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
