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
                    <button type="button" class="btn btn-danger btn-sm delete-report" data-id="{{ $report->id }}">
                        Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '.delete-report', function() {

        let reportId = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "This report will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "/sales-reports/" + reportId,
                    type: "POST",
                    data: {
                        _method: "DELETE",
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        if (response.success) {

                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {

                                // Redirect to index page
                                window.location.href = "/sales-reports";

                            });

                        }
                    },

                    error: function() {
                        Swal.fire(
                            "Error!",
                            "Failed to delete report.",
                            "error"
                        );
                    }
                });

            }

        });

    });
</script>
