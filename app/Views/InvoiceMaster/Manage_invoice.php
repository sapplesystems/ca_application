<!-------------------------------- Modal for genrate invoice------------------------------------->
<!-- Modal1 -->
<div class="modal fade" id="GenrateVoice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('preview'); ?>">
                    <div class="Gvoice-wrapper">
                        <input type="hidden" name="client_id" value="<?= esc($clients[0]['id']); ?>">

                        <!-- Title -->
                        <div class="Gvoice-title">Choose Works And Company For Invoice</div>

                        <!-- Invoice type row -->
                        <div class="Gvoice-row">
                            <div class="Gvoice-label">
                                Select Invoice Type: <span class="Gvoice-required">*</span>
                            </div>
                            <select class="Gvoice-select">
                                <option>Automatic Invoice</option>
                                <option>Manual Invoice</option>
                                <!-- other options -->
                            </select>
                        </div>

                        <!-- Choose work section -->
                        <div class="Gvoice-section-title">Choose Work For Invoice</div>
                        <div class="Gvoice-box">

                            <?php if (!empty($works)): ?>
                            <?php foreach ($works as $work): ?>

                            <div class="Gvoice-option-row">
                                <input type="checkbox" name="work_ids[]" value="<?= $work['id']; ?>" />

                                <div class="Gvoice-option-text">
                                    <?= esc($work['service_name']); ?>
                                    (<?= esc($work['sac_code']); ?>)
                                    [<?= esc($work['frequency']); ?>]
                                </div>

                                <div class="Gvoice-option-status">
                                    Allocated
                                </div>
                            </div>

                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No works found</p>
                            <?php endif; ?>

                        </div>


                        <!-- Choose company section -->
                        <div class="Gvoice-section-title">Choose Company For Invoice</div>
                        <div class="Gvoice-box">

                            <?php if (!empty($companies)): ?>
                            <?php foreach ($companies as $company): ?>

                            <div class="Gvoice-option-row">
                                <input type="radio" name="company_id" value="<?= $company['id']; ?>" />

                                <div class="Gvoice-option-text">
                                    <?= esc($company['name']); ?>
                                    [<?= esc($company['type_of_company']); ?>]
                                </div>
                            </div>

                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No companies found</p>
                            <?php endif; ?>

                        </div>


                        <div class="Gvoice-section-title">Choose tax For Invoice</div>
                        <div class="Gvoice-box">
                            <div class="Gvoice-option-row">
                                <input type="radio" name="tax" value="cgst_sgst" checked>
                                <div class="Gvoice-option-text">CGST &amp; SGST</div>
                            </div>

                            <div class="Gvoice-option-row">
                                <input type="radio" name="tax" value="igst">
                                <div class="Gvoice-option-text">IGST</div>
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="Gvoice-actions">
                            <button class="Gvoice-btn Gvoice-btn-success">Proceed</button>
                            <button class="Gvoice-btn Gvoice-btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-------------------------------- Modal for show details Recipt Note------------------------------------->
<div class="modal fade" id="ReciptNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="currentInvoiceId">

            <div class="modal-body">
                <div class="reciptnote">
                    <div class="header">
                        Receipt Note List
                        <button class="add-btn" id="addReceiptBtn">
                            <i class="fa fa-plus"></i> Add New
                        </button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Receipt No</th>
                                <th>Date.</th>
                                <th>Mode Of Payment</th>
                                <th>Cheque Date</th>
                                <th>Cheque Number</th>
                                <th>Drawer Bank</th>
                                <th>Bill Amount</th>
                                <th>Tds Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($receipt)) : ?>
                            <?php foreach ($receipt as $rec) : ?>
                            <tr>
                                <td><?= esc($rec['id']) ?></td>
                                <td><?= esc($rec['recipt_no']) ?></td>
                                <td><?= esc($rec['date']) ?></td>
                                <td><?= esc($rec['mode_of_payment']) ?></td>
                                <td><?= esc($rec['cheque_date']) ?></td>
                                <td><?= esc($rec['cheque_number']) ?></td>
                                <td><?= esc($rec['drawen_bank']) ?></td>
                                <td class="amount"><?= esc($rec['bill_amount']) ?></td>
                                <td class="amount"><?= esc($rec['tds_amount']) ?></td>
                                <td class="action">
                                    <i class="fa-solid fa-pen-to-square edit-btn" title="Edit"
                                        data-id="<?= $rec['id'] ?>" data-recipt_no="<?= esc($rec['recipt_no']) ?>"
                                        data-date="<?= esc($rec['date']) ?>"
                                        data-mode_of_payment="<?= esc($rec['mode_of_payment']) ?>"
                                        data-cheque_date="<?= esc($rec['cheque_date']) ?>"
                                        data-cheque_number="<?= esc($rec['cheque_number']) ?>"
                                        data-drawen_bank="<?= esc($rec['drawen_bank']) ?>"
                                        data-bill_amount="<?= esc($rec['bill_amount']) ?>"
                                        data-tds_amount="<?= esc($rec['tds_amount']) ?>"
                                        data-invoice-id="<?= esc($rec['invoice_id']) ?>">
                                    </i>
                                    <i class="fa-solid fa-trash delete-btn" title="Delete" data-id="<?= $rec['id'] ?>">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="9" class="Minvoice-text-center">No invoices found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Button trigger modal -->

<!-------------------------------- Modal for Add Recipt Note------------------------------------->
<div class="modal fade" id="addreciptnote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="receiptForm">
                <div class="modal-body">
                    <input type="hidden" name="invoice_id" id="current_invoice_id">
                    <input type="hidden" name="receipt_id" id="receipt_id">
                    <div class="receiptnote-container ReciptNoteData">

                        <!-- Header -->
                        <div class="receiptnote-header top">
                            <div class="receiptnote-company-name company">
                                <h2 id="companyName"></h2>
                                <span id="companyType"></span>
                            </div>

                            <div class="receiptnote-address contact">
                                Address : <span id="companyAddress"></span><br />
                                Ph. No. : <span id="companyPhone"></span><br />
                                E-Mail : <span id="companyEmail"></span><br />
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="receiptnote-title title">Receipt Note</div>

                        <!-- Receipt Info -->
                        <table class="receiptnote-table section">
                            <tr>
                                <td class="receiptnote-label">PAN :</td>
                                <td id="clientPan"></td>

                                <td class="receiptnote-label">Receipt Note No. :</td>
                                <td>
                                    <input type="text" name="recipt_no" id="receiptNo" class="receiptnote-input" />
                                </td>
                            </tr>

                            <tr class="receiptnote-light highlight">
                                <td></td>
                                <td></td>

                                <td class="receiptnote-label">Date :</td>
                                <td>
                                    <input type="text" name="date" id="receiptDate" class="receiptnote-input" />
                                </td>
                            </tr>
                        </table>

                        <!-- Issued To -->
                        <table class="receiptnote-table section">
                            <tr class="receiptnote-light highlight">
                                <td colspan="4"><strong>Issued To,</strong></td>
                            </tr>

                            <tr>
                                <td class="receiptnote-label">Name :</td>
                                <td colspan="3" id="clientName"></td>
                            </tr>

                            <tr class="receiptnote-light highlight">
                                <td class="receiptnote-label">Address :</td>
                                <td colspan="3">
                                    <span id="clientAddress"></span>
                                </td>
                            </tr>

                            <tr>
                                <td class="receiptnote-label">Mode Of Payment :</td>
                                <td colspan="3">
                                    <select name="mode_of_payment" id="modeOfPayment" class="receiptnote-select">
                                        <option value="Cash">Cash</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                </td>
                            </tr>
                        </table>

                        <!-- Cheque Fields -->
                        <div id="chequeFields" style="display:none;" class="section">
                            <label>Cheque Date</label>
                            <input type="date" name="cheque_date" class="receiptnote-input">

                            <label>Cheque Number</label>
                            <input type="text" name="cheque_number" class="receiptnote-input"
                                placeholder="Cheque Number">

                            <label>Drawn Bank</label>
                            <input type="text" name="drawen_bank" class="receiptnote-input" placeholder="Drawn Bank">
                        </div>

                        <!-- Amount Text -->
                        <div class="receiptnote-text section highlight text">
                            Received with thanks from M/s/Mr/Mrs/Ms <span id="clientName"></span> the sum of Rs.
                            <input type="text" name="bill_amount" id="billAmount" class="receiptnote-inline-input" />
                            /- Amount in Words <b>Zero Rupees</b> Against Cash after deduction of TDS Rs
                            <input type="text" name="tds_amount" id="tdsAmount" class="receiptnote-inline-input" />
                            /- Amount In Words <b>Zero Rupees</b> for professional Services Rendered /
                            Advance Against invoice Raised vide Bill No <span id="invoiceNo"></span> /
                            dated <span id="invoiceDate"></span>.
                        </div>

                        <!-- Footer -->
                        <div class="receiptnote-footer footer">
                            For more Information reach us @ <b>www.ksaca.in</b>
                        </div>

                        <!-- Buttons -->
                        <div class="receiptnote-buttons buttons">
                            <button type="button" class="receiptnote-btn receiptnote-btn-submit btn btn-primary"
                                id="saveReceiptBtn">
                                Save Receipt
                            </button>
                            <button type="button" class="receiptnote-btn receiptnote-btn-cancel">
                                Cancel
                            </button>
                            <button type="button" class="receiptnote-btn receiptnote-btn-preview"
                                id="previewReceiptBtn">
                                Preview
                            </button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-------------------------------- Modal for Preview Recipt Note------------------------------------->
<div class="modal fade" id="receiptPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Receipt Preview</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="receiptPreviewContent">
                <!-- Preview HTML will be injected here -->
            </div>

        </div>
    </div>
</div>
<!-------------------------------- Modal for submitrecipt------------------------------------->
<div class="modal fade" id="submitrecipt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="options-container">
                    <div class="options-header">Options</div>

                    <label class="pdf-label">Receipt PDF</label>

                    <div class="d-flex gap-2 mb-3">
                        <button class="btn btn-success flex-fill" id="printReceiptBtn">Print Receipt</button>
                        <button class="btn btn-success flex-fill" id="downloadPdfBtn">Receipt PDF Download</button>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">Save changes</button>
             </div> -->
        </div>
    </div>
</div>
<div class="Minvoice-wrapper">
    <!-- Header -->
    <div class="Minvoice-header">List Of Generated Invoice for <?= esc($clients[0]['legal_name']) ?></div>

    <!-- Top Buttons -->
    <div class="Minvoice-top-actions">
        <button class="Minvoice-btn Minvoice-btn-primary" onclick="printLedger()">Print Ledger</button>
        <button type="button" class=" Minvoice-btn Minvoice-btn-primary" data-toggle="modal"
            data-target="#GenrateVoice">
            Generate Invoice For Pending Work
        </button>
        <button class="Minvoice-btn Minvoice-btn-primary">
            Back To Client Grid
        </button>
    </div>

    <!-- Filters -->
    <div class="Minvoice-filter-row">
        <div class="Minvoice-filter-group">
            <label for="Minvoice-company">Select Company</label>
            <select id="Minvoice-company" name="company_id">
                <option value="">Select Company</option>

                <?php foreach ($companies as $company): ?>
                <option value="<?= $company['id']; ?>">
                    <?= esc($company['name']); ?>
                </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="Minvoice-filter-group">
            <label for="Minvoice-fromDate">From:</label>
            <input type="date" id="Minvoice-fromDate" />
        </div>

        <div class="Minvoice-filter-group">
            <label for="Minvoice-toDate">To:</label>
            <input type="date" id="Minvoice-toDate" />
        </div>

        <div class="Minvoice-filter-buttons">
            <button class="Minvoice-btn Minvoice-btn-search">Search</button>
            <button class="Minvoice-btn Minvoice-btn-reset">Reset</button>
        </div>
    </div>

    <!-- Table -->
    <div class="Minvoice-table-wrapper" id="ledger-print-area">
        <table class="Minvoice-table">
            <thead>
                <tr>
                    <th style="width: 12%">Invoice No</th>
                    <th style="width: 10%">Invoice Date</th>
                    <th style="width: 10%">Works</th>
                    <th style="width: 21%">Company</th>
                    <th style="width: 12%">Total Invoice Amount</th>
                    <th style="width: 10%">Receipt Date</th>
                    <th style="width: 5%">Receipt No</th>
                    <th style="width: 32%">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Opening balance row -->
                <tr class="Minvoice-opening-row">
                    <td colspan="9" class="Minvoice-opening-label">Opening Balance</td>
                </tr>

                <?php if (!empty($invoices)) : ?>
                <?php foreach ($invoices as $row) : ?>
                <tr>
                    <td><?= esc($row['invoice_no']) ?></td>
                    <td><?= date('d-m-Y', strtotime($row['invoice_date'])) ?></td>
                    <td class="Minvoice-works-text">
                        <?= esc($row['service_description']) ?>
                    </td>
                    <td><?= esc($row['company_name']) ?></td>
                    <td>
                        <?= number_format($row['total_invoice_amount'], 2) ?>
                    </td>
                    <td>
                        <?= !empty($row['invoice_date']) 
                            ? date('d-m-Y', strtotime($row['invoice_date'])) 
                            : '-' ?>
                    </td>
                    <td><?= esc($row['id']) ?></td>

                    <td>
                        <!-- Edit -->
                        <a href="<?= site_url('invoice/edit/' . $row['id']) ?>" class="Minvoice-icon-btn edit"
                            title="Edit Invoice">
                            ✏️
                        </a>

                        <!-- Delete -->
                        <button type="button" class="Minvoice-icon-btn delete" title="Delete Invoice"
                            onclick="deleteInvoice(<?= $row['id'] ?>)">
                            🗑️
                        </button>

                        <!-- Export Excel -->
                        <a href="#" class="Minvoice-icon-btn export open-receipt" data-toggle="modal"
                            data-target="#ReciptNote" data-id="<?= $row['id'] ?>">
                            📥
                        </a>
                        <!-- Print & Preview -->
                        <button type="button" class="Minvoice-print-btn" onclick="printInvoice(<?= $row['id'] ?>)"
                            style="padding:2px;border-radius: 10px;border: 2px solid #f1c40f;">
                            Print &amp; Preview
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td colspan="9" class="Minvoice-text-center">No invoices found</td>
                </tr>
                <?php endif; ?>

                <!-- Total row -->
                <tr class="Minvoice-total-row">
                    <td colspan="4" class="Minvoice-text-right">Total</td>
                    <td class="Minvoice-text-right Minvoice-amount-bold">
                        <?= number_format(array_sum(array_column($invoices, 'total_invoice_amount')), 2) ?>
                    </td>
                    <td colspan="2" class="Minvoice-closing-balance">Closing<br>Balance</td>
                    <td class="Minvoice-text-right Minvoice-amount-bold">
                        <?= number_format(array_sum(array_column($invoices, 'amount')), 2) ?>
                    </td>
                    <td></td>
                </tr>
            </tbody>

        </table>
    </div>

    <!-- Pagination -->
    <div class="Minvoice-pagination">
        <button>&lt;&lt;</button>
        <button class="Minvoice-active">1</button>
        <button>&gt;&gt;</button>
    </div>
</div>

<script>
function deleteInvoice(id) {
    if (!confirm('Are you sure you want to delete this invoice?')) return;

    fetch(`<?= site_url('invoice/delete') ?>/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Invoice deleted');
                location.reload();
            } else {
                alert('Failed to delete');
            }
        });
}

function printInvoice(id) {
    window.open(`<?= site_url('invoice/print') ?>/${id}`, '_blank');
}

function printLedger() {
    const printContents = document.getElementById('ledger-print-area').innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
        <head>
            <title>Invoice Ledger</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #000; padding: 6px; }
                .Minvoice-text-right { text-align: right; }
                .no-print { display: none !important; }
            </style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `;

    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
$(document).on('click', '.open-receipt', function() {
    let invoiceId = $(this).data('id');
    $('#currentInvoiceId').val(invoiceId);
});
$('#addReceiptBtn').on('click', function() {
    let invoiceId = $('#currentInvoiceId').val();
    $('#ReciptNote').css('display', 'none');
    $('#addreciptnote').modal('show');

    $('#currentInvoiceId').val(invoiceId);
    loadReceiptData(invoiceId);
});


function loadReceiptData(invoiceId) {
    $.ajax({
        url: "<?= site_url('invoice/receipt') ?>" + "/" + invoiceId,
        type: "GET",
        data: {
            invoice_id: invoiceId
        },
        dataType: "json",
        success: function(res) {

            // Company
            $('#companyName').text(res.company.name);
            $('#companyType').text(res.company.type_of_company);
            $('#companyAddress').html(res.company.registered_office);
            $('#companyPhone').text(res.company.telephone);
            $('#companyEmail').text(res.company.email);

            // Client
            $('#clientName').text(res.client.legal_name);
            $('#clientAddress').html(res.client.registered_office);
            $('#clientPan').text(res.client.pan);

            // Invoice
            $('#receiptNo').val(res.invoice.invoice_no);
            $('#receiptDate').val(res.invoice.invoice_date);
            $('#billAmount').val(res.invoice.total_invoice_amount);
            $('#current_invoice_id').val(res.invoice.id);
        }
    });
}
$(document).on('click', '.close', function() {
    $('#addreciptnote').modal('hide');
    $('#submitrecipt').modal('hide');
    location.reload();
});
$(document).ready(function() {
    // Listen for changes in the dropdown
    $('#modeOfPayment').on('change', function() {
        if ($(this).val() === 'Cheque') {
            $('#chequeFields').slideDown(); // show fields with animation
        } else {
            $('#chequeFields').slideUp(); // hide fields if not Cheque
        }
    });

    // Optional: hide cheque fields on page load if "Cash" is selected
    if ($('#modeOfPayment').val() !== 'Cheque') {
        $('#chequeFields').hide();
    }
});


document.getElementById("saveReceiptBtn").addEventListener("click", function() {

    const receiptId = document.getElementById("receipt_id").value;
    const form = document.getElementById("receiptForm");
    const formData = new FormData(form);

    // EDIT MODE → UPDATE
    if (receiptId) {
        fetch("updateReceipt", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Receipt updated successfully");
                    $('#submitrecipt').data('receipt-id', receiptId);
                    $('#submitrecipt').modal('show');

                } else {
                    alert("Update failed");
                }
            });

    }
    // ADD MODE → INSERT
    else {
        fetch("saveReceipt", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {

                if (!data.success) {
                    alert("Save failed");
                    return;
                }

                // ✅ GET ID FROM SERVER
                const receipt_id = data.receipt_id;
                alert("Receipt added successfully");

                // ✅ STORE IT
                $('#receipt_id').val(receipt_id);

                $('#submitrecipt') // make sure this is your modal ID
                    .data('receipt-id', receipt_id)
                    .attr('data-receipt-id', receipt_id)
                    .modal('show');
            });
    }
});


// Edit button click
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("edit-btn")) {
        const btn = e.target;

        const invoiceId = btn.dataset.invoiceId;

        // Fill basic receipt fields
        document.getElementById("receipt_id").value = btn.dataset.id;
        document.getElementById("receiptNo").value = btn.dataset.recipt_no;
        document.getElementById("receiptDate").value = btn.dataset.date;
        document.getElementById("billAmount").value = btn.dataset.bill_amount;
        document.getElementById("tdsAmount").value = btn.dataset.tds_amount;
        document.getElementById("modeOfPayment").value = btn.dataset.mode_of_payment;

        // Show/hide cheque fields
        const chequeFields = document.getElementById("chequeFields");
        if (btn.dataset.mode_of_payment === "Cheque") {
            chequeFields.style.display = "block";
            chequeFields.querySelector("input[name='cheque_date']").value = btn.dataset.cheque_date;
            chequeFields.querySelector("input[name='cheque_number']").value = btn.dataset.cheque_number;
            chequeFields.querySelector("input[name='drawen_bank']").value = btn.dataset.drawen_bank;
        } else {
            chequeFields.style.display = "none";
        }

        // Fetch company details from backend using invoice_id
        fetch(`getInvoiceDetails/${invoiceId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById("companyName").textContent = data.company_name;
                document.getElementById("companyType").textContent = data.company_type;
                document.getElementById("companyAddress").textContent = data.company_address;
                document.getElementById("companyPhone").textContent = data.company_phone;
                document.getElementById("companyEmail").textContent = data.company_email;
                document.getElementById("clientName").textContent = data.client_name;
                document.getElementById("clientAddress").textContent = data.client_address;
                document.getElementById("clientPan").textContent = data.client_pan;


            })
            .catch(err => console.error("Error fetching company data:", err));

        // Open modal
        const modal = new bootstrap.Modal(document.getElementById('addreciptnote'));
        modal.show();
    }
});

// Delete button click
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("delete-btn")) {
        const id = e.target.dataset.id;

        if (confirm("Are you sure you want to delete this receipt?")) {
            fetch(`deleteReceipt/${id}`, {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        e.target.closest("tr").remove();
                        alert("Receipt deleted successfully");
                    } else {
                        alert("Failed to delete receipt");
                    }
                })
                .catch(err => console.error(err));
        }
    }
});

document.getElementById("previewReceiptBtn").addEventListener("click", function() {

    const receiptNo = document.getElementById("receiptNo").value;
    const receiptDate = document.getElementById("receiptDate").value;
    const mode = document.getElementById("modeOfPayment").value;
    const billAmount = document.getElementById("billAmount").value;
    const tdsAmount = document.getElementById("tdsAmount").value;

    const companyName = document.getElementById("companyName").innerText;
    const companyAddress = document.getElementById("companyAddress").innerText;
    const companyPhone = document.getElementById("companyPhone").innerText;
    const companyEmail = document.getElementById("companyEmail").innerText;

    const previewHTML = `
<div class="receipt-wrapper">

    <div class="receipt-header">
        <div class="company-left">
            <h2>${companyName}</h2>
            <span>CONSULTANCY SERVICES</span>
        </div>
        <div class="company-right">
            <div>${companyAddress}</div>
            <div>Ph: ${companyPhone}</div>
            <div>Email: ${companyEmail}</div>
        </div>
    </div>

    <div class="receipt-title">Receipt Note</div>

    <div class="receipt-body">

        <div class="receipt-row">
            <div class="label">Receipt No :</div>
            <div class="value">${receiptNo}</div>
            <div class="label">Date :</div>
            <div class="value">${receiptDate}</div>
        </div>

        <div class="receipt-row light">
            <div class="label">Mode Of Payment :</div>
            <div class="value">${mode}</div>
        </div>

        <div class="receipt-row">
            <div class="label">Bill Amount :</div>
            <div class="value">₹ ${billAmount}</div>
        </div>

        <div class="receipt-row">
            <div class="label">TDS Amount :</div>
            <div class="value">₹ ${tdsAmount}</div>
        </div>

    </div>

    <div class="receipt-footer">
        For more information reach us @ <b>www.ksaca.in</b>
    </div>

</div>
`;


    document.getElementById("receiptPreviewContent").innerHTML = previewHTML;

    new bootstrap.Modal(
        document.getElementById("receiptPreviewModal")
    ).show();
});
document.getElementById("printReceiptBtn").addEventListener("click", function() {

    const receiptId = $('#submitrecipt').data('receipt-id');

    if (!receiptId) {
        alert("Receipt ID not found");
        return;
    }

    window.open(`printReceipt/${receiptId}`);
});
document.getElementById("downloadPdfBtn").addEventListener("click", function() {

    const receiptId = $('#submitrecipt').data('receipt-id');

    if (!receiptId) {
        alert("Receipt ID not found");
        return;
    }

    window.open(`receiptPdf/${receiptId}`, '_blank');
});
document.addEventListener('DOMContentLoaded', function() {

    const form = document.querySelector('#GenrateVoice form');

    form.addEventListener('submit', function(e) {

        // 1️⃣ Check works selected
        const worksChecked = document.querySelectorAll(
            'input[name="work_ids[]"]:checked'
        ).length;

        // 2️⃣ Check company selected
        const companySelected = document.querySelector(
            'input[name="company_id"]:checked'
        );

        if (worksChecked === 0) {
            e.preventDefault();
            alert('Please select at least one Work for Invoice');
            return false;
        }

        if (!companySelected) {
            e.preventDefault();
            alert('Please select a Company for Invoice');
            return false;
        }


    });

});
</script>