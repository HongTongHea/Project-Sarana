$(document).ready(function () {
    $("#DataTable").DataTable({
        paging: true, // Enable pagination
        searching: true, // Enable search bar
        ordering: false, // Enable column sorting
        // Enable column sorting
        info: false, // Display table information
        lengthChange: true, // Allow the user to change the number of rows displayed
        pageLength: 10,// Default number of rows per page
        nextPrev: true,
        // Default number of rows per page
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
            500
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
            500
        );
    }
});
