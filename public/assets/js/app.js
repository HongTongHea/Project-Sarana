const rowsPerPage = 10; // Number of rows per page
let currentPage = 1;
const tableBody = document.getElementById("tableBody");
const rows = tableBody.querySelectorAll("tr");
const totalRows = rows.length;
const totalPages = Math.ceil(totalRows / rowsPerPage);

function displayPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    rows.forEach((row, index) => {
        row.style.display = index >= start && index < end ? "" : "none";
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
    let tables = document.querySelectorAll(".search-table"); // Select all tables with the class "search-table"

    // Loop through each table and apply search functionality
    tables.forEach((table) => {
        let rows = table.querySelector("tbody").rows;
        let found = false; // Flag to track if any row is visible

        for (let i = 0; i < rows.length; i++) {
            let cells = rows[i].cells;
            let match = false;

            // Check each cell in the row
            for (let j = 0; j < cells.length; j++) {
                let cellContent = cells[j].textContent || cells[j].innerText;
                if (cellContent.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }

            // Show or hide the row based on match result
            rows[i].style.display = match ? "" : "none";
            if (match) found = true; // If a row is found, set found to true
        }

        // Handle "No results found" message
        let noResultRow = table.querySelector(".no-results");
        if (!found) {
            // If no visible rows, show "No results found" row
            if (!noResultRow) {
                noResultRow = document.createElement("tr");
                noResultRow.classList.add("no-results");
                let cell = document.createElement("td");
                cell.colSpan = table.querySelector("thead tr").children.length;
                cell.textContent = "No results found";
                noResultRow.appendChild(cell);
                table.querySelector("tbody").appendChild(noResultRow);
            }
            noResultRow.style.display = "";
        } else if (noResultRow) {
            // Hide "No results found" row if there are visible rows
            noResultRow.style.display = "none";
        }
    });
});
