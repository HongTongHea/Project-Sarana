<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal{{ $report->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                        <span class="text-dark text-uppercase"> Delete Reperts</span>
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this sales report?</p>
                <div class="alert alert-warning">
                    <strong>Report Details:</strong><br>
                    Type: {{ ucfirst($report->report_type) }}<br>
                    Period: {{ $report->start_date->format('M d, Y') }} - {{ $report->end_date->format('M d, Y') }}<br>
                    Total Sales: ${{ number_format($report->total_sales, 2) }}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i
                        class="fas fa-times me-1"></i> Cancel</button>
                <form action="{{ route('sales-reports.destroy', $report->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
