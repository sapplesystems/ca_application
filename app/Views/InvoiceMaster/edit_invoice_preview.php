<?php
function romanNumeral($num) {
    $map = [
        'M'=>1000,'CM'=>900,'D'=>500,'CD'=>400,
        'C'=>100,'XC'=>90,'L'=>50,'xl'=>40,
        'x'=>10,'ix'=>9,'v'=>5,'iv'=>4,'i'=>1
    ];
    $returnValue = '';
    while ($num > 0) {
        foreach ($map as $roman => $int) {
            if($num >= $int) {
                $num -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return strtolower($returnValue);
}
?>


<div class="invoiceM-containerr">
    <div class=" inv-header-main">
        <h1 class="inv-title-main"> Edit Invoice</h1>
        <a href="javascript:history.back()" class="inv-back-btn-main">
            Back to Generate Invoice Grid
        </a>
    </div>

<form method="post"
      action="<?= site_url('/updateInvoice/'.$invoice['id']) ?>"
      id="invoiceForm">

<table width="100%" border="0">
    <tr>
        <td>
            <strong><?= esc($company['name']); ?></strong><br>
            <?= esc($company['type_of_company']); ?><br>
            <?= esc($company['registered_office']); ?><br>
            PH: <?= esc($company['telephone']); ?><br>
            Email: <?= esc($company['email']); ?><br>
            GSTIN: <?= esc($company['gstin']); ?>
        </td>

        <td align="right">
            <strong>Invoice No:</strong> <?= esc($invoice['invoice_no']); ?><br>
            <strong>Date:</strong> <?= esc($invoice['invoice_date']); ?>
        </td>
    </tr>
</table>

<hr>

<div style="text-align:center;font-weight:bold;">SERVICE INVOICE</div>

<hr>

<table width="100%" cellpadding="6">
    <tr>
        <td width="60%">
            <strong>PAN:</strong> <?= esc($company['pan']); ?>
        </td>
        <td width="40%" align="right">
            <strong>Invoice No:</strong><br>
            <?= esc($invoice['invoice_no']); ?>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Category Of Service :</strong> CONSULTANCY
        </td>
        <td align="right">
            <strong>Date :</strong><br>
            <?= date('d-m-Y', strtotime($invoice['invoice_date'])); ?>
        </td>
    </tr>
</table>

<hr>

<!-- BILL TO -->
<table width="100%" cellpadding="6">
    <tr>
        <td>
            <strong>Bill To</strong><br><br>
            <strong>Name :</strong> <?= esc($client['legal_name']); ?><br>
            <strong>Address :</strong> <?= esc($client['registered_office']); ?>
        </td>
    </tr>
</table>

<!-- INVOICE TABLE -->
<table width="100%" style="border-collapse:collapse;font-size:14px;">
<thead>
<tr style="background:#0b5c7d;color:#fff;">
    <th>SL</th>
    <th>Nature of Services</th>
    <th>Amount (₹)</th>
</tr>
</thead>

<tbody id="expenseBody">
  <?php $sl = 1; ?>
<?php foreach ($invoice_works as $service): ?>
<tr>
    <td style="padding:8px; border:1px solid #ccc; text-align:center;">
        <?= $sl++; ?>
    </td>
    <input type="hidden" name="work_id[]" value="<?= esc($service['id']); ?>">

    <td style="padding:8px; border:1px solid #ccc;">
        <?= esc($service['service_name']); ?> [<?= esc($service['service_unit']); ?>]

        <input type="text"
               name="service_description[]"
               value="<?= esc($service['service_description'] ?? '') ?>"
               style="width:100%; margin-top:6px; padding:6px; border:1px solid #bbb;"
               placeholder="Description">
    </td>

    <td style="padding:8px; border:1px solid #ccc;">
        <input type="text"
               name="service_amount[]"
               class="service-amount"
               value="<?= esc($service['service_amount'] ?? '') ?>"
               style="width:100%; padding:6px; border:1px solid #bbb; text-align:right;">
    </td>
</tr>
     <input type="hidden" name="service_name[]" value="<?= esc($service['service_name']) ?>">
    <input type="hidden" name="service_unit[]" value="<?= esc($service['service_unit']) ?>">
<?php endforeach; ?>


<tr style="background:#0b5c7d;color:#fff;">
    <td align="center" style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">A</td>
    <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">Service Value</td>
    <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;"><span id="serviceValue">0</span></td>
</tr>

<?php if ($invoice['tax_apply_name'] === 'cgst_sgst'): ?>
 <tr>
 <td></td>
 <td>Add : Expenses Recoverable</td>
 <td>
     <button type="button" onclick="addExpenseRow()" style="margin-top:10px; padding:6px 12px;">
     ➕ Add Expense
     </button>
 </td>
 </tr>

<?php if (!empty($expenses)): ?>
    <?php foreach ($expenses as $index => $exp): ?>
        <tr class="expense-row" style="background:#e9f5fb;">
            <td style="text-align:center;">
                <?= romanNumeral($index + 1); ?>
            </td>

            <td>
                 <input type="hidden" name="expense_id[]" value="<?= $exp['id'] ?>">
                <input type="text"
                       name="expense_description[]"
                       value="<?= esc($exp['expense_description']); ?>"
                       style="width:100%;">
            </td>
            <td>
                <input type="text"
                       class="expense"
                       name="expense_amount[]"
                       value="<?= esc($exp['expense_amount']); ?>"
                       style="width:85%; text-align:right;">
              <button type="button" class="btn btn-danger btn-sm delete-row"data-expense-id="<?= esc($exp['id']) ?>"style="background-color: red;">✖</button>

            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">B</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            Total Expenses Recoverable
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            <span id="expenseTotal">0</span>
                        </td>
                    </tr>
                    <tr>
    <tr>
    <td align="center"></td>
    <td>CGST @ 9%</td>
    <td><input readonly id="cgstAmount" style="width:100%;text-align:right;"></td>
</tr>
<tr>
    <td align="center"></td>
    <td>SGST @ 9%</td>
    <td><input readonly id="sgstAmount" style="width:100%;text-align:right;"></td>
</tr>
<?php endif; ?>
 <!-- Hidden Template Row -->
 <tr id="hiddenRow" class="expense-row" style="background:#e9f5fb; display:none;">
    <td style="text-align:center;"></td>
    <td>
        <input type="text"  placeholder="Expense Recoverable" name="expense_description[]" style="width:100%;">
    </td>
    <td>
        <input type="text" class="expense" name="expense_amount[]" style="width:85%; text-align:right;">
       <button type="button" class="btn btn-danger btn-sm delete-row" style="background-color: red;">✖</button>

    </td>
</tr>
<?php endif; ?>

<?php if ($invoice['tax_apply_name'] === 'igst'): ?>
     <tr>
 <td></td>
 <td>Add : Expenses Recoverable</td>
 <td>
     <button type="button" onclick="addExpenseRow()" style="margin-top:10px; padding:6px 12px;">
     ➕ Add Expense
     </button>
 </td>
 </tr>

<?php if (!empty($expenses)): ?>
    <?php foreach ($expenses as $index => $exp): ?>
        <tr class="expense-row" style="background:#e9f5fb;">
            <td style="text-align:center;">
                <?= romanNumeral($index + 1); ?>
            </td>
            <td>
                <input type="text"
                       name="expense_description[]"
                       value="<?= esc($exp['expense_description']); ?>"
                       style="width:100%;">
            </td>
            <td>
                <input type="text"
                       class="expense"
                       name="expense_amount[]"
                       value="<?= esc($exp['expense_amount']); ?>"
                       style="width:85%; text-align:right;">
              <button type="button" class="btn btn-danger btn-sm delete-row" data-expense-id="<?= esc($exp['id']) ?>"style="background-color: red;">✖</button>

            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
 <!-- Hidden Template Row -->
 <tr id="hiddenRow" class="expense-row" style="background:#e9f5fb; display:none;">
    <td style="text-align:center;"></td>
    <td>
        <input type="text"  placeholder="Expense Recoverable" name="expense_description[]" style="width:100%;">
    </td>
    <td>
        <input type="text" class="expense" name="expense_amount[]" style="width:85%; text-align:right;">
        <button type="button" class="btn btn-danger btn-sm delete-row" style="background-color: red;">✖</button>

    </td>
</tr>

<tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">B</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            Total Expenses Recoverable
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            <span id="expenseTotal">0</span>
                        </td>
                    </tr>
                    <tr>
    <td align="center">i</td>
    <td>IGST @ 18%</td>
    <td><input readonly id="igstAmount" style="width:100%;text-align:right;"></td>
</tr>
<?php endif; ?>



<tr>
    <td></td>
    <td align="right"><strong>Grand Total</strong></td>
    <td align="right" style="text-align:right;"><strong id="grandTotal">0</strong></td>
</tr>

<tr>
    <td></td>
    <td align="right">(-) Advance</td>
    <td>
        <input type="text" id="advance" name="advance_received"
               value="<?= esc($invoice['advance_received']); ?>"
               style="width:100%;text-align:right;">
    </td>
</tr>

<tr style="background:#0b5c7d;color:#fff;">
    <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">C</td>
    <td style="padding:8px; border:1px solid #ccc; text-align:left;background:#0b5c7d;">
        <strong>Amount In Words</strong><br>
        <span id="amountInWords"></span>
    </td>
    <td align="right" style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;" >
         Net Amount Receivable (A+B)<br>
        <strong id="netAmount">0</strong>
    </td>
</tr>
</tbody>
</table>

<br>
        <div>
          <b>Banker's Details</b><br />
          <?php echo $company['bank_name']; ?><br />
          Ac.No. : <?php echo $company['bank_ac_no']; ?><br />
          IFSC Code : <?php echo $company['bank_ifsc']; ?><br />
        </div>

<strong>Terms & Conditions</strong>
<textarea name="term_condition" style="width:100%;height:80px;">
<?= esc($invoice['term_condition']); ?>
</textarea>

<!-- HIDDEN VALUES -->
<input type="hidden" name="service_value" id="service_value">
<input type="hidden" name="expense_total" id="expense_total">
<input type="hidden" name="grand_total" id="grand_total">
<input type="hidden" name="net_amount" id="net_amount">
<input type="hidden" name="cgst_amount" id="cgst_amount">
<input type="hidden" name="sgst_amount" id="sgst_amount">
<input type="hidden" name="igst_amount" id="igst_amount">

<input type="hidden" name="invoice_id" value="<?= esc($invoice['id']); ?>">

<div style="text-align:center;margin-top:20px;">
    <button class="Gvoice-btn Gvoice-btn-success">
        Update Invoice
    </button>
    <a href="javascript:history.back()"
   class="Gvoice-btn Gvoice-btn-danger">
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
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Invoice Updated!',
                        text: 'Your invoice has been updated successfully.',
                        icon: 'success',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Print Invoice',
                        denyButtonText: 'Download PDF',
                        cancelButtonText: 'Close'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Print invoice
                            window.open('<?= site_url("invoice/print/") ?>' + data.invoice_id,
                                '_blank');
                        } else if (result.isDenied) {
                            // Download PDF
                            window.open('<?= site_url("invoice/pdf/") ?>' + data.invoice_id,
                                '_blank');
                        } else if (result.isDismissed) {
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
                                if (res.isConfirmed) {
                                    window.location.href =
                                        '<?= site_url("InvoiceManagment") ?>';
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

    /* ✅ SERVICE VALUE */
    let serviceValue = 0;
    document.querySelectorAll('.service-amount').forEach(el => {
        serviceValue += parseFloat(el.value || 0);
    });
    document.getElementById('serviceValue').innerText = serviceValue.toFixed(2);

    /* ✅ EXPENSE TOTAL */
    let expenseTotal = 0;
    document.querySelectorAll('.expense').forEach(el => {
        expenseTotal += parseFloat(el.value || 0);
    });
    document.getElementById('expenseTotal').innerText = expenseTotal.toFixed(2);

    let cgst = 0, sgst = 0, igst = 0;

    /* ✅ CGST + SGST */
    if (document.getElementById('cgstAmount')) {

        cgst = (serviceValue + expenseTotal) * 0.09;
        sgst = (serviceValue + expenseTotal) * 0.09;

        document.getElementById('cgstAmount').value = cgst.toFixed(2);
        document.getElementById('sgstAmount').value = sgst.toFixed(2);
    }

    /* ✅ IGST */
    if (document.getElementById('igstAmount')) {

        igst = (serviceValue + expenseTotal) * 0.18;

        document.getElementById('igstAmount').value = igst.toFixed(2);
    }

    /* ✅ GRAND TOTAL */
    let taxTotal = cgst + sgst + igst;
    let grandTotal = serviceValue + expenseTotal + taxTotal;

    document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);

    /* ✅ ADVANCE */
    let advance = parseFloat(document.getElementById('advance').value || 0);
    let netAmount = grandTotal - advance;

    document.getElementById('netAmount').innerText = netAmount.toFixed(2);
    document.getElementById('amountInWords').innerText =
        numberToWords(Math.round(netAmount)).toUpperCase();

    /* ✅ HIDDEN INPUTS */
    serviceValueInput.value = serviceValue.toFixed(2);
    expenseTotalInput.value = expenseTotal.toFixed(2);
    cgstInput.value = cgst.toFixed(2);
    sgstInput.value = sgst.toFixed(2);
    igstInput.value = igst.toFixed(2);
    grandTotalInput.value = grandTotal.toFixed(2);
    netAmountInput.value = netAmount.toFixed(2);
}


function addExpenseRow() {
    const template = document.getElementById('hiddenRow');
    const clone = template.cloneNode(true);

    clone.style.display = 'table-row'; // make it visible
    clone.removeAttribute('id');

    // Reset all input values
    clone.querySelectorAll('input').forEach(input => input.value = '');

    // Find all visible expense rows
    const expenseRows = document.querySelectorAll('.expense-row:not([style*="display:none"])');

    if (expenseRows.length > 0) {
        // Insert after the last visible expense row
        const lastRow = expenseRows[expenseRows.length - 1];
        lastRow.parentNode.insertBefore(clone, lastRow.nextSibling);
    } else {
        // If no visible rows, insert before the first hidden row (fallback)
        template.parentNode.insertBefore(clone, template);
    }

    // Recalculate totals after adding
    calculateTotals();
}


/* EVENTS */
document.addEventListener('input', function (e) {
    if (
        e.target.classList.contains('service-amount') ||
        e.target.classList.contains('expense') ||
        e.target.id === 'advance'
    ) {
        calculateTotals();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#invoiceForm'); // your form ID
    form.addEventListener('submit', function() {
        calculateTotals(); // calculate and populate hidden inputs
    });
});


function numberToWords(num) {
    const ones=["","One","Two","Three","Four","Five","Six","Seven","Eight","Nine"];
    const tens=["","","Twenty","Thirty","Forty","Fifty","Sixty","Seventy","Eighty","Ninety"];
    if(num<10)return ones[num];
    if(num<20)return ["Ten","Eleven","Twelve","Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen","Nineteen"][num-10];
    if(num<100)return tens[Math.floor(num/10)]+" "+ones[num%10];
    if(num<1000)return ones[Math.floor(num/100)]+" Hundred "+numberToWords(num%100);
    if(num<100000)return numberToWords(Math.floor(num/1000))+" Thousand "+numberToWords(num%1000);
    if(num<10000000)return numberToWords(Math.floor(num/100000))+" Lakh "+numberToWords(num%100000);
    return numberToWords(Math.floor(num/10000000))+" Crore "+numberToWords(num%10000000);
}

document.querySelector('.service-amount').addEventListener('input', calculateTotals);
document.getElementById('advance').addEventListener('input', calculateTotals);

calculateTotals();

document.addEventListener('click', function (e) {
    if (!e.target.classList.contains('delete-row')) return;

    const row = e.target.closest('tr');
    const expenseId = e.target.dataset.expenseId; // DB ID
    const tbody = document.getElementById('expenseBody');

    Swal.fire({
        title: 'Delete this expense?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete'
    }).then(result => {

        if (!result.isConfirmed) return;

        // If expense exists in DB → delete via AJAX
        if (expenseId) {
            fetch('<?= site_url("Expense/delete") ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ expense_id: expenseId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    removeRow(row, tbody);
                } else {
                    Swal.fire('Error', data.message || 'Delete failed', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Server error', 'error');
            });
        } 
        // If not saved yet → just remove from UI
        else {
            removeRow(row, tbody);
        }
    });
});

function removeRow(row, tbody) {
    const rows = tbody.querySelectorAll('tr.expense-row:not([style*="display:none"])');

    if (rows.length <= 1) {
        Swal.fire('Warning', 'At least one expense row is required.', 'warning');
        return;
    }

    row.remove();

    // Re-index rows
    tbody.querySelectorAll('tr.expense-row:not([style*="display:none"])')
        .forEach((tr, index) => {
            tr.cells[0].textContent = index + 1;
        });

    calculateTotals();
}
</script>
