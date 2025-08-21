<div class="modal fade" id="editModal{{ $purchaseOrder->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('purchase_orders.update', $purchaseOrder->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h6 class="mt-3 ms-1 text-black text-uppercase fw-bold" style="font-size: 16px">
                        Edit Purchase Order #{{ $purchaseOrder->id }}
                    </h6>
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
                                    <option value="{{ $supplier->id }}"
                                        {{ $supplier->id == $purchaseOrder->supplier_id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Created By -->
                        <div class="form-group col-12 col-md-4">
                            <label for="created_by">Created By (Employee)</label>
                            <select class="form-control" id="created_by" name="created_by" required>
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ $employee->id == $purchaseOrder->created_by ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Order Date -->
                        <div class="form-group col-12 col-md-4">
                            <label for="order_date">Order Date</label>
                            <input type="date" class="form-control" id="order_date" name="order_date"
                                value="{{ $purchaseOrder->order_date->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Purchase Order Items -->
                    <div class="mt-4">
                        <h6 class="fw-bold">Order Items</h6>
                        <table class="table table-bordered" id="itemsTable{{ $purchaseOrder->id }}">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Item</th>
                                    <th width="120px">Quantity</th>
                                    <th width="150px">Unit Price</th>
                                    <th width="150px">Total</th>
                                    <th width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrder->items as $index => $item)
                                    <tr data-item-id="{{ $item->item_id }}" data-item-type="{{ $item->item_type }}">
                                        <td>
                                            <select name="items[{{ $index }}][item_type]"
                                                class="form-control item_type" required>
                                                <option value="">Select Type</option>
                                                <option value="App\Models\Product"
                                                    {{ $item->item_type == 'App\Models\Product' ? 'selected' : '' }}>
                                                    Product</option>
                                                <option value="App\Models\Accessory"
                                                    {{ $item->item_type == 'App\Models\Accessory' ? 'selected' : '' }}>
                                                    Accessory</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="items[{{ $index }}][item_id]"
                                                class="form-control item_id" required>
                                                <option value="">Select Item</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                class="form-control quantity" min="1"
                                                value="{{ $item->quantity }}" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][unit_price]"
                                                class="form-control unit_price" step="0.01" min="0"
                                                value="{{ $item->unit_price }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control total_price" readonly
                                                value="{{ number_format($item->total_price, 2) }}">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm removeRow"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success btn-sm" id="addRow{{ $purchaseOrder->id }}"><i
                                class="fas fa-plus"></i> Add Item</button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let rowIndex = {{ $purchaseOrder->items->count() }};

        const products = @json($products);
        const accessories = @json($accessories);

        function populateItems(itemSelect, type, selectedId = null) {
            itemSelect.innerHTML = '<option value="">Select Item</option>';
            let items = type === 'App\\Models\\Product' ? products : accessories;
            items.forEach(item => {
                let option = document.createElement('option');
                option.value = item.id;
                option.text = item.name;
                if (selectedId && selectedId == item.id) option.selected = true;
                itemSelect.appendChild(option);
            });
        }

        const tableBody = document.querySelector("#itemsTable{{ $purchaseOrder->id }} tbody");

        // Initialize existing rows
        tableBody.querySelectorAll("tr").forEach(row => {
            const typeSelect = row.querySelector(".item_type");
            const itemSelect = row.querySelector(".item_id");
            const selectedType = row.dataset.itemType;
            const selectedId = row.dataset.itemId;

            if (selectedType) {
                typeSelect.value = selectedType;
                populateItems(itemSelect, selectedType, selectedId);
            }

            typeSelect.addEventListener("change", function() {
                populateItems(itemSelect, typeSelect.value);
            });
        });

        // Add new row
        document.getElementById("addRow{{ $purchaseOrder->id }}").addEventListener("click", function() {
            let newRow = tableBody.rows[0].cloneNode(true);

            newRow.querySelectorAll("input, select").forEach(input => {
                let name = input.getAttribute("name");
                if (name) input.setAttribute("name", name.replace(/\[\d+\]/, `[${rowIndex}]`));

                if (input.tagName === "INPUT") {
                    if (input.type === "number") input.value = 1;
                    if (input.classList.contains("unit_price")) input.value = 0;
                    if (input.classList.contains("total_price")) input.value = "0.00";
                }

                if (input.tagName === "SELECT") input.selectedIndex = 0;
            });

            tableBody.appendChild(newRow);

            const typeSelect = newRow.querySelector(".item_type");
            const itemSelect = newRow.querySelector(".item_id");
            typeSelect.addEventListener("change", function() {
                populateItems(itemSelect, typeSelect.value);
            });

            rowIndex++;
        });

        // Remove row
        tableBody.addEventListener("click", function(e) {
            if (e.target.closest(".removeRow")) {
                const rows = tableBody.querySelectorAll("tr");
                if (rows.length > 1) e.target.closest("tr").remove();
            }
        });

        // Calculate total
        tableBody.addEventListener("input", function(e) {
            const row = e.target.closest("tr");
            const qty = parseFloat(row.querySelector(".quantity").value) || 0;
            const price = parseFloat(row.querySelector(".unit_price").value) || 0;
            row.querySelector(".total_price").value = (qty * price).toFixed(2);
        });
    });
</script>
