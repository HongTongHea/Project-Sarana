const rowsPerPage = 5; // Number of rows per page
let currentPage = 1;
const tableBody = document.getElementById("tableBody");
const rows = tableBody.querySelectorAll("tr");
const totalRows = rows.length;
const totalPages = Math.ceil(totalRows / rowsPerPage);

function displayPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    rows.forEach((row, index) => {
        row.style.display = (index >= start && index < end) ? "" : "none";
    });

    // Disable buttons based on the current page
    document.getElementById("prevBtn").disabled = page === 1;
    document.getElementById("nextBtn").disabled = page === totalPages;
}

function nextPage() {
    if (currentPage < totalPages) {
        currentPage++;
        displayPage(currentPage);
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        displayPage(currentPage);
    }
}

// Initial display
displayPage(currentPage);




document.addEventListener("DOMContentLoaded", function () {
    if (successMessage) {
        Swal.fire({
            icon: "success",
            title: "Success!",
            text: successMessage,
            confirmButtonText: "OK",
        });
    }

    if (errorMessage) {
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: errorMessage,
            confirmButtonText: "OK",
        });
    }
});

document.getElementById("search").addEventListener("keyup", function () {
    let filter = this.value.toUpperCase();
    let rows = document.querySelector("#Table tbody").rows;

    for (let i = 0; i < rows.length; i++) {
        let name = rows[i].cells[1].textContent.toUpperCase();
        let email = rows[i].cells[2].textContent.toUpperCase();
        let role = rows[i].cells[3].textContent.toUpperCase();
        let phone = rows[i].cells[4].textContent.toUpperCase();

        if (
            name.indexOf(filter) > -1 ||
            email.indexOf(filter) > -1 ||
            role.indexOf(filter) > -1 ||
            phone.indexOf(filter) > -1
        ) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
});
