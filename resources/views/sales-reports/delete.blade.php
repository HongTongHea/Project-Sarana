<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal{{ $report->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $report->id }}">Delete Sales Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this sales report?</p>
                <div class="alert alert-warning">
                    <strong>Report Details:</strong><br>
                    <strong>Type:</strong> {{ ucfirst($report->report_type) }}<br>
                    <strong>Period:</strong> {{ $report->start_date->format('M d, Y') }} -
                    {{ $report->end_date->format('M d, Y') }}<br>
                    <strong>Total Orders:</strong> {{ number_format($report->total_orders) }}<br>
                    <strong>Total Sales:</strong> ${{ number_format($report->total_sales, 2) }}
                </div>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('sales-reports.destroy', $report->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
