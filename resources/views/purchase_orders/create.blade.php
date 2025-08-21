<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('purchase_orders.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-0">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h6 class="mt-3 ms-1 text-black text-uppercase fw-bold" style="font-size: 16px">
                            Create Purchase Order
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row m-2">
                        <!-- Supplier -->
                        <div class="form-group col-12 col-md-4">
                            <label for="supplier_id">Supplier</label>
                            <select class="form-control" id="supplier_id" name="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Created By -->
                        <div class="form-group col-12 col-md-4">
                            <label for="created_by">Created By (Employee)</label>
                            <select class="form-control" id="created_by" name="created_by" required>
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Order Date -->
                        <div class="form-group col-12 col-md-4">
                            <label for="order_date">Order Date</label>
                            <input type="date" class="form-control" id="order_date" name="order_date" required>
                        </div>
                    </div>

                    <!-- Purchase Order Items -->
                    <div class="mt-4 m-3">
                        <h6 class="fw-bold">Order Items</h6>
                        <table class="table table-bordered" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Item Type</th>
                                    <th>Item</th>
                                    <th width="120px">Quantity</th>
                                    <th width="150px">Unit Price</th>
                                    <th width="150px">Total</th>
                                    <th width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="items[0][item_type]" class="form-control item_type" required>
                                            <option value="">Select Type</option>
                                            <option value="App\Models\Product">Product</option>
                                            <option value="App\Models\Accessory">Accessory</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="items[0][item_id]" class="form-control item_id" required>
                                            <option value="">Select Item</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][quantity]" class="form-control quantity"
                                            min="1" value="1" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][unit_price]"
                                            class="form-control unit_price" step="0.01" min="0" value="0"
                                            required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control total_price" readonly value="0.00">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm removeRow">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success btn-sm" id="addRow">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let rowIndex = 1;

        const products = @json($products);
        const accessories = @json($accessories);

        function populateItems(selectElement, type) {
            selectElement.innerHTML = '<option value="">Select Item</option>';
            const list = (type === 'App\\Models\\Product') ? products : accessories;
            list.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item.name;
                selectElement.appendChild(opt);
            });
        }

        // Add new row
        document.getElementById("addRow").addEventListener("click", function() {
            const tableBody = document.querySelector("#itemsTable tbody");
            const newRow = tableBody.rows[0].cloneNode(true);

            newRow.querySelectorAll("input, select").forEach((input) => {
                const name = input.getAttribute("name");
                if (name) input.setAttribute("name", name.replace(/\[\d+\]/, `[${rowIndex}]`));

                if (input.tagName === "INPUT") {
                    if (input.type === "number") input.value = 1;
                    if (input.classList.contains("unit_price")) input.value = 0;
                    if (input.classList.contains("total_price")) input.value = "0.00";
                }
                if (input.tagName === "SELECT") {
                    input.selectedIndex = 0;
                    if (input.classList.contains("item_id")) input.innerHTML =
                        '<option value="">Select Item</option>';
                }
            });

            tableBody.appendChild(newRow);
            rowIndex++;
        });

        // Remove row
        document.querySelector("#itemsTable").addEventListener("click", function(e) {
            if (e.target.closest(".removeRow")) {
                const rows = document.querySelectorAll("#itemsTable tbody tr");
                if (rows.length > 1) e.target.closest("tr").remove();
            }
        });

        // Calculate total
        document.querySelector("#itemsTable").addEventListener("input", function(e) {
            const row = e.target.closest("tr");
            const qty = parseFloat(row.querySelector(".quantity").value) || 0;
            const price = parseFloat(row.querySelector(".unit_price").value) || 0;
            row.querySelector(".total_price").value = (qty * price).toFixed(2);
        });

        // Populate items based on type
        document.querySelector("#itemsTable").addEventListener("change", function(e) {
            if (e.target.classList.contains("item_type")) {
                const row = e.target.closest("tr");
                const itemSelect = row.querySelector(".item_id");
                populateItems(itemSelect, e.target.value);
            }
        });
    });
</script>
