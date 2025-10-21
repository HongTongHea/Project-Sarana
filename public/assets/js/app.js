$(document).ready(function () {
    $("#AdminTable").DataTable({
        ordering: false,
    });
    $("#CustomerTable").DataTable({
        ordering: false,
    });
    $("#DataTable").DataTable({
        ordering: false,
    });
});

document.addEventListener("DOMContentLoaded", function () {
    if (successMessage) {
        Swal.fire(
            {
                icon: "success",
                title: "Success!",
                text: successMessage,
                confirmButtonText: "OK",
            },
            200
        );
    }

    if (errorMessage) {
        Swal.fire(
            {
                icon: "error",
                title: "Error!",
                text: errorMessage,
                confirmButtonText: "OK",
            },
            200
        );
    }
});
