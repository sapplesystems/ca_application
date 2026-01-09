
<h2 style="text-align:center;">Invoice</h2>
<form method="post" action="<?= site_url('/saveInvoice') ?>" id="invoiceForm">
<table width="100%" border="0">
    <tr>
        <td>
            <strong><?= esc($company['name']); ?></strong><br>
            <?= esc($company['type_of_company']); ?><br>
            <?= esc($company['registered_office'] ?? ''); ?><br>
            PH: <?= esc($company['telephone'] ?? ''); ?><br>
            Email: <?= esc($company['email'] ?? ''); ?><br>
            GSTIN: <?= esc($company['gstin'] ?? ''); ?>
        </td>

        <td align="right">
            <strong>Invoice No:</strong> DEG/2023-24/001<br>
            <strong>Date:</strong> <?= esc($company['date_of_incorp']); ?>
        </td>
    </tr>
</table>

<hr>
<div style="text-align:center; font-weight:bold; margin-bottom:10px;">
    Service Invoice
</div>

<table width="100%" border="0" cellpadding="6">
    <tr>
        <td width="60%">
            <strong>PAN:</strong> <?= esc($company['pan'] ?? ''); ?>
        </td>
        <td width="40%" align="right">
            <strong>Invoice No. :</strong><br>
          <?= esc($invoiceNo) ?>
        </td>
    </tr>

    <tr>
        <td>
            <strong>Category Of Service :</strong> CONSULTANCY
        </td>
        <td align="right">
            <strong>Date :</strong><br>
             <?= date('d-m-Y'); ?>
        </td>
    </tr>
</table>

<hr>

<!-- Bill To Section -->
<table width="100%" border="0" cellpadding="6">
    <tr>
        <td>
            <strong>Bill To,</strong><br><br>

            <strong>Name :</strong>
            <?= esc($client['legal_name']); ?><br>

            <strong>Address :</strong>
            <?= esc($client['registered_office']); ?>
        </td>
    </tr>
</table>

<table class="invoice-table" style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px;">

    <thead>
        <tr style="background:#0b5c7d; color:#fff;">
            <th style="width:5%; padding:8px; border:1px solid #ccc;">SL No.</th>
            <th style="width:70%; padding:8px; border:1px solid #ccc;">Nature of Services</th>
            <th style="width:25%; padding:8px; border:1px solid #ccc;">Amount (Rs)</th>
        </tr>
    </thead>

    <tbody>
        <!-- Service row -->
        <tr>
            <td style="padding:8px; border:1px solid #ccc; text-align:center;">1</td>
            <td style="padding:8px; border:1px solid #ccc;">
                <?= esc($company['name']); ?>[<?= esc($company['type_of_company']); ?>]
                <input type="text" name="service_description"
                       style="width:100%; margin-top:6px; padding:6px; border:1px solid #bbb;"
                       placeholder="Description">
            </td>
            <td style="padding:8px; border:1px solid #ccc;">
                <input type="number"
                       name="service_amount"
                       class="service-amount"
                       value="0"
                       style="width:100%; padding:6px; border:1px solid #bbb; text-align:right;">
            </td>
        </tr>

        <!-- A -->
        <tr style="background:#0b5c7d; color:#fff;">
            <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">A</td>
            <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">Service Value</td>
            <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                <span id="serviceValue">0</span>
            </td>
        </tr>
<?php if ($taxType === 'cgst_sgst'): ?>
       <!-- CGST Row -->
<tr id="cgstRow" style="background:#e9f5fb;">
    <td style="padding:8px; border:1px solid #ccc; text-align:center;">i</td>
    <td style="padding:8px; border:1px solid #ccc;">CGST @ 9%</td>
    <td style="padding:8px; border:1px solid #ccc;">
        <input type="text" id="cgstAmount" readonly
               style="width:100%; text-align:right;">
    </td>
</tr>

<!-- SGST Row -->
<tr id="sgstRow" style="background:#e9f5fb;">
    <td style="padding:8px; border:1px solid #ccc; text-align:center;">ii</td>
    <td style="padding:8px; border:1px solid #ccc;">SGST @ 9%</td>
    <td style="padding:8px; border:1px solid #ccc;">
        <input type="text" id="sgstAmount" readonly
               style="width:100%; text-align:right;">
    </td>
</tr>
<?php endif; ?>
<?php if ($taxType === 'igst'): ?>
<tr id="igstRow" style="background:#e9f5fb;">
    <td style="padding:8px; border:1px solid #ccc; text-align:center;">i</td>
    <td style="padding:8px; border:1px solid #ccc;">IGST @ 18%</td>
    <td style="padding:8px; border:1px solid #ccc;">
        <input type="text" id="igstAmount" readonly
               style="width:100%; text-align:right;">
    </td>
</tr>
<?php endif; ?>

        <!-- B -->
        <tr style="background:#0b5c7d; color:#fff;">
            <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">B</td>
            <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                Total Expenses Recoverable
            </td>
            <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                <span id="expenseTotal">0</span>
            </td>
        </tr>

        <!-- Grand total -->
        <tr>
            <td style="padding:8px; border:1px solid #ccc;"></td>
            <td style="padding:8px; border:1px solid #ccc; text-align:right;">
                <strong>Grand Total</strong>
            </td>
            <td style="padding:8px; border:1px solid #ccc; text-align:right;">
                <strong id="grandTotal">0</strong>
            </td>
        </tr>

        <!-- Advance -->
        <tr>
            <td style="padding:8px; border:1px solid #ccc;"></td>
            <td style="padding:8px; border:1px solid #ccc; text-align:right;">
                (-) Advances Received
            </td>
            <td style="padding:8px; border:1px solid #ccc;">
                <input type="number" id="advance" name="advance_received"
                       style="width:100%; padding:6px; border:1px solid #bbb; text-align:right;">
            </td>
        </tr>

        <!-- Net -->
        <tr style="background:#0b5c7d; color:#fff;">
            <td style="padding:8px; border:1px solid #ccc; text-align:center; color:black;">C</td>
            <td style="padding:8px; border:1px solid #ccc;color:black">
                <strong>(Amount In Words)</strong><br>
                <span id="amountInWords">ZERO</span>
            </td>
            <td style="padding:8px; border:1px solid #ccc; text-align:right; color:black;">
                Net Amount Receivable (A+B)
                <br><strong id="netAmount">0</strong>
            </td>
        </tr>
    </tbody>
</table>

<div class="bank-details">
    <strong>Banker's Details</strong><br>
    SBI<br>
    <?= esc($company['head_office']); ?><br>
    Ac.No.: <?= esc($company['bank_ac_no']); ?><br>
    IFSC Code: ICIC0000722
</div>
<div>
    <label name="term_condition"><strong>Terms & Conditions:</strong></label>
    <textarea style="width:100%; height:100px; border:1px solid #bbb; padding:6px; margin:10px;" name="term_condition">
    
    </textarea>
</div>
<input type="hidden" name="service_value" id="serviceValueInput">
<input type="hidden" name="cgst_amount" id="cgstInput">
<input type="hidden" name="sgst_amount" id="sgstInput">
<input type="hidden" name="igst_amount" id="igstInput">
<input type="hidden" name="expense_total" id="expenseTotalInput">
<input type="hidden" name="grand_total" id="grandTotalInput">
<input type="hidden" name="net_amount" id="netAmountInput">
<input type="hidden" name="client_id" value="<?= esc($client['id']) ?>">
<input type="hidden" name="company_id" value="<?= esc($company['id']) ?>">
<input type="hidden" name="invoice_no" value="<?= esc($invoiceNo) ?>">
<input type="hidden" name="invoice_date" value="<?= date('Y-m-d') ?>">
<input type="hidden" name="created_by" value="<?= esc($client['id']) ?>">
<input type="hidden" name="tax_apply_name" value="<?= esc($taxType) ?>">

<div style="margin-top:20px; text-align:center;">
    <button class="Gvoice-btn Gvoice-btn-success" id="saveInvoiceBtn">Save Invoice</button>
    <a href="<?= base_url('InvoiceManagment'); ?>" class="Gvoice-btn Gvoice-btn-danger">
        Cancel
    </a>
</div>
</form>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('invoiceForm').addEventListener('submit', function(e) {
    e.preventDefault(); // prevent normal form submit

    const form = this;
    
    // Submit form via AJAX
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            Swal.fire({
                title: 'Invoice Saved!',
                text: 'Your invoice has been saved successfully.',
                icon: 'success',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Print Invoice',
                denyButtonText: 'Download PDF',
                cancelButtonText: 'Close'
            }).then((result) => {
                if(result.isConfirmed) {
                    alert(data.invoice_id);
                    // Print invoice
                    window.open('<?= site_url("invoice/print/") ?>'+data.invoice_id, '_blank');
                } else if(result.isDenied) {
                    // Download PDF
                    window.open('<?= site_url("invoice/pdf/") ?>'+data.invoice_id, '_blank');
                } else if(result.isDismissed) {
                    // Check if user clicked cancel
                    // Optional: redirect to invoice list
                    Swal.fire({
                        title: 'Redirect?',
                        text: 'Do you want to go back to invoice list?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Redirect',
                        cancelButtonText: 'No'
                    }).then((res) => {
                        if(res.isConfirmed){
                            window.location.href = '<?= site_url("InvoiceManagment") ?>';
                        }
                        // else just close popup
                    });
                }
            });
        } else {
            Swal.fire('Error!', 'Something went wrong while saving invoice.', 'error');
        }
    })
    .catch(err => {
        Swal.fire('Error!', 'Network or server error', 'error');
    });
});

function calculateTotals() {

    let serviceInputs = document.querySelectorAll('.service-amount');
    let serviceValue = 0;

    serviceInputs.forEach(input => {
        serviceValue += parseFloat(input.value || 0);
    });

    document.getElementById('serviceValue').innerText = serviceValue.toFixed(2);

    let cgst = 0, sgst = 0, igst = 0;

    if (document.getElementById('cgstAmount')) {
        cgst = serviceValue * 0.09;
        sgst = serviceValue * 0.09;
        document.getElementById('cgstAmount').value = cgst.toFixed(2);
        document.getElementById('sgstAmount').value = sgst.toFixed(2);
    }

    if (document.getElementById('igstAmount')) {
        igst = serviceValue * 0.18;
        document.getElementById('igstAmount').value = igst.toFixed(2);
    }

    let expenseTotal = cgst + sgst + igst;
    document.getElementById('expenseTotal').innerText = expenseTotal.toFixed(2);

    let grandTotal = serviceValue + expenseTotal;
    document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);

    let advance = parseFloat(document.getElementById('advance').value || 0);
    let netAmount = grandTotal - advance;

    document.getElementById('netAmount').innerText = netAmount.toFixed(2);

    document.getElementById('amountInWords').innerText =
        numberToWords(Math.round(netAmount)).toUpperCase();

    /* ✅ STORE VALUES FOR BACKEND */
    document.getElementById('serviceValueInput').value = serviceValue.toFixed(2);
    document.getElementById('expenseTotalInput').value = expenseTotal.toFixed(2);
    document.getElementById('grandTotalInput').value = grandTotal.toFixed(2);
    document.getElementById('netAmountInput').value = netAmount.toFixed(2);

    document.getElementById('cgstInput').value = cgst.toFixed(2);
    document.getElementById('sgstInput').value = sgst.toFixed(2);
    document.getElementById('igstInput').value = igst.toFixed(2);
}

// Convert Number to Words (Indian Format – basic)
function numberToWords(num) {
    const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
    const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
    const teens = ["Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];

    function convert(n) {
        if (n < 10) return ones[n];
        if (n < 20) return teens[n - 10];
        if (n < 100) return tens[Math.floor(n / 10)] + " " + ones[n % 10];
        if (n < 1000) return ones[Math.floor(n / 100)] + " Hundred " + convert(n % 100);
        if (n < 100000) return convert(Math.floor(n / 1000)) + " Thousand " + convert(n % 1000);
        if (n < 10000000) return convert(Math.floor(n / 100000)) + " Lakh " + convert(n % 100000);
        return convert(Math.floor(n / 10000000)) + " Crore " + convert(n % 10000000);
    }

    return num === 0 ? "Zero" : convert(num);
}

// Event listeners
document.querySelectorAll('.service-amount').forEach(el => {
    el.addEventListener('input', calculateTotals);
});

document.getElementById('advance').addEventListener('input', calculateTotals);

// Initial calculation
calculateTotals();



</script>


