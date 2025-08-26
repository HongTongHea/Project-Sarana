<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('purchase_orders.store') }}" method="POST" id="purchaseOrderForm">
                @csrf
                <div class="modal-header bg-light">
                    <div class="d-flex justify-content-center align-items-center">
                        <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                            Create Purchase Order
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row m-3">
                        <!-- Supplier -->
                        <div class="form-group col-12 col-md-4 mb-3">
                            <label for="supplier_id" class="form-label fw-semibold">Supplier <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-control @error('supplier_id') is-invalid @enderror"
                                id="supplier_id" name="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Created By -->
                        <div class="form-group col-12 col-md-4 mb-3">
                            <label for="created_by" class="form-label fw-semibold">Created By (Employee) <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-control @error('created_by') is-invalid @enderror"
                                id="created_by" name="created_by" required>
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ old('created_by') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('created_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Order Date -->
                        <div class="form-group col-12 col-md-4 mb-3">
                            <label for="order_date" class="form-label fw-semibold">Order Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('order_date') is-invalid @enderror"
                                id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}"
                                required>
                            @error('order_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Purchase Order Items -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="fw-bold mb-0">Order Items</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="itemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Item Type</th>
                                        <th width="25%">Item</th>
                                        <th width="15%">Quantity</th>
                                        <th width="15%">Unit Price</th>
                                        <th width="15%">Total</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $oldItems = old('items', [
                                            ['item_type' => '', 'item_id' => '', 'quantity' => 1, 'unit_price' => 0],
                                        ]);
                                        if (empty($oldItems[0]['item_type'])) {
                                            $oldItems = [
                                                [
                                                    'item_type' => '',
                                                    'item_id' => '',
                                                    'quantity' => 1,
                                                    'unit_price' => 0,
                                                ],
                                            ];
                                        }
                                    @endphp

                                    @foreach ($oldItems as $index => $oldItem)
                                        <tr>
                                            <td>
                                                <select name="items[{{ $index }}][item_type]"
                                                    class="form-select item_type" required>
                                                    <option value="">Select Type</option>
                                                    <option value="product"
                                                        {{ $oldItem['item_type'] == 'product' ? 'selected' : '' }}>
                                                        Product</option>
                                                    <option value="accessory"
                                                        {{ $oldItem['item_type'] == 'accessory' ? 'selected' : '' }}>
                                                        Accessory</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="items[{{ $index }}][item_id]"
                                                    class="form-select item_id" required>
                                                    <option value="">Select Item</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                    class="form-control quantity" min="1"
                                                    value="{{ $oldItem['quantity'] }}" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][unit_price]"
                                                    class="form-control unit_price" step="0.01" min="0"
                                                    value="{{ $oldItem['unit_price'] }}" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control total_price" readonly
                                                    value="{{ number_format($oldItem['quantity'] * $oldItem['unit_price'], 2) }}">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm removeRow">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success btn-sm" id="addRow">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let rowIndex = {{ count($oldItems) }};
        const products = @json($products);
        const accessories = @json($accessories);

        // Initialize items for existing rows
        document.querySelectorAll('.item_type').forEach((select, index) => {
            const selectedType = select.value;
            const itemSelect = select.closest('tr').querySelector('.item_id');

            if (selectedType) {
                populateItems(itemSelect, selectedType);

                // Set the previously selected value if exists
                const oldItemId = "{{ old('items.0.item_id') }}";
                if (oldItemId && index === 0) {
                    itemSelect.value = oldItemId;
                }
            }
        });

        function populateItems(selectElement, type) {
            selectElement.innerHTML = '<option value="">Select Item</option>';
            const itemList = (type === 'product') ? products : accessories;

            itemList.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name + (item.code ? ' (' + item.code + ')' : '');
                option.setAttribute('data-price', item.price || item.unit_price || 0);
                selectElement.appendChild(option);
            });
        }

        // Add new row
        document.getElementById("addRow").addEventListener("click", function() {
            const tableBody = document.querySelector("#itemsTable tbody");
            const newRow = tableBody.rows[0].cloneNode(true);

            // Clear all values in the new row
            newRow.querySelectorAll("input, select").forEach((input) => {
                const name = input.getAttribute("name");
                if (name) {
                    input.setAttribute("name", name.replace(/\[\d+\]/, `[${rowIndex}]`));
                }

                if (input.classList.contains("item_type")) {
                    input.value = "";
                } else if (input.classList.contains("item_id")) {
                    input.innerHTML = '<option value="">Select Item</option>';
                } else if (input.classList.contains("quantity")) {
                    input.value = 1;
                } else if (input.classList.contains("unit_price")) {
                    input.value = 0;
                } else if (input.classList.contains("total_price")) {
                    input.value = "0.00";
                }
            });

            tableBody.appendChild(newRow);
            rowIndex++;
        });

        // Remove row
        document.querySelector("#itemsTable").addEventListener("click", function(e) {
            if (e.target.closest(".removeRow")) {
                const rows = document.querySelectorAll("#itemsTable tbody tr");
                if (rows.length > 1) {
                    e.target.closest("tr").remove();
                } else {
                    alert("You must have at least one item in the order.");
                }
            }
        });

        // Calculate row total
        document.querySelector("#itemsTable").addEventListener("input", function(e) {
            if (e.target.classList.contains("quantity") || e.target.classList.contains("unit_price")) {
                const row = e.target.closest("tr");
                calculateRowTotal(row);
            }
        });

        // Populate items based on type and set unit price when item is selected
        document.querySelector("#itemsTable").addEventListener("change", function(e) {
            if (e.target.classList.contains("item_type")) {
                const row = e.target.closest("tr");
                const itemSelect = row.querySelector(".item_id");
                populateItems(itemSelect, e.target.value);
            }

            if (e.target.classList.contains("item_id") && e.target.value) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const unitPrice = selectedOption.getAttribute('data-price') || 0;
                const row = e.target.closest("tr");
                row.querySelector('.unit_price').value = unitPrice;
                calculateRowTotal(row);
            }
        });

        function calculateRowTotal(row) {
            const quantity = parseFloat(row.querySelector(".quantity").value) || 0;
            const unitPrice = parseFloat(row.querySelector(".unit_price").value) || 0;
            const total = quantity * unitPrice;
            row.querySelector(".total_price").value = total.toFixed(2);
        }

        // Form validation
        document.getElementById('purchaseOrderForm').addEventListener('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            // Check if at least one item is added
            const itemRows = document.querySelectorAll('#itemsTable tbody tr');
            if (itemRows.length === 0) {
                isValid = false;
                errorMessage = 'Please add at least one item to the order.';
            }

            // Check if all items have valid selections
            itemRows.forEach((row, index) => {
                const itemType = row.querySelector('.item_type').value;
                const itemId = row.querySelector('.item_id').value;

                if (!itemType || !itemId) {
                    isValid = false;
                    errorMessage =
                        `Please select both item type and specific item for row ${index + 1}.`;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    });
</script>
