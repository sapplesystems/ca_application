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


<h2 style="text-align:center;">Edit Invoice</h2>

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

<tbody>
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
        <input type="number"
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
    <td align="center">A</td>
    <td align="right">Service Value</td>
    <td align="right"><span id="serviceValue">0</span></td>
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
                <input type="number"
                       class="expense"
                       name="expense_amount[]"
                       value="<?= esc($exp['expense_amount']); ?>"
                       style="width:100%; text-align:right;">
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
        <input type="number" class="expense" name="expense_amount[]" style="width:100%; text-align:right;">
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
<tr>
    <td align="center">i</td>
    <td>IGST @ 18%</td>
    <td><input readonly id="igstAmount" style="width:100%;text-align:right;"></td>
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
                <input type="number"
                       class="expense"
                       name="expense_amount[]"
                       value="<?= esc($exp['expense_amount']); ?>"
                       style="width:100%; text-align:right;">
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
        <input type="number" class="expense" name="expense_amount[]" style="width:100%; text-align:right;">
    </td>
</tr>
<?php endif; ?>

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
    <td></td>
    <td align="right"><strong>Grand Total</strong></td>
    <td align="right"><strong id="grandTotal">0</strong></td>
</tr>

<tr>
    <td></td>
    <td align="right">(-) Advance</td>
    <td>
        <input type="number" id="advance" name="advance_received"
               value="<?= esc($invoice['advance_received']); ?>"
               style="width:100%;text-align:right;">
    </td>
</tr>

<tr style="background:#0b5c7d;color:#fff;">
    <td align="center">C</td>
    <td>
        <strong>Amount In Words</strong><br>
        <span id="amountInWords"></span>
    </td>
    <td align="right">
        <strong id="netAmount">0</strong>
    </td>
</tr>
</tbody>
</table>

<br>

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
    <a href="<?= site_url('InvoiceManagment'); ?>" class="Gvoice-btn Gvoice-btn-danger">
        Cancel
    </a>
</div>

</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function calculateTotals() {

    /* SERVICE TOTAL */
    let serviceValue = 0;
    document.querySelectorAll('.service-amount').forEach(el => {
        serviceValue += parseFloat(el.value) || 0;
    });

    document.getElementById('serviceValue').innerText = serviceValue.toFixed(2);

    /* TAX */
    let cgst = 0, sgst = 0, igst = 0;

    const cgstField = document.getElementById('cgstAmount');
    const sgstField = document.getElementById('sgstAmount');
    const igstField = document.getElementById('igstAmount');

    if (cgstField && sgstField) {
        cgst = serviceValue * 0.09;
        sgst = serviceValue * 0.09;

        cgstField.value = cgst.toFixed(2);
        sgstField.value = sgst.toFixed(2);
    }

    if (igstField) {
        igst = serviceValue * 0.18;
        igstField.value = igst.toFixed(2);
    }

    let taxTotal = cgst + sgst + igst;

    /* EXPENSE TOTAL */
    let expenseTotal = 0;
    document.querySelectorAll('.expense').forEach(el => {
        expenseTotal += parseFloat(el.value) || 0;
    });

    document.getElementById('expenseTotal').innerText = expenseTotal.toFixed(2);

    /* GRAND TOTAL */
    let grandTotal = serviceValue + taxTotal + expenseTotal;
    document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);

    /* ADVANCE & NET */
    let advance = parseFloat(document.getElementById('advance')?.value) || 0;
    let netAmount = grandTotal - advance;

    document.getElementById('netAmount').innerText = netAmount.toFixed(2);
    document.getElementById('amountInWords').innerText =
        numberToWords(Math.round(netAmount)).toUpperCase();

    /* HIDDEN INPUTS (MOST IMPORTANT) */
    document.getElementById('service_value').value = serviceValue.toFixed(2);
    document.getElementById('expense_total').value = expenseTotal.toFixed(2);
    document.getElementById('grand_total').value = grandTotal.toFixed(2);
    document.getElementById('net_amount').value = netAmount.toFixed(2);
    document.getElementById('cgst_amount').value = cgst.toFixed(2);
    document.getElementById('sgst_amount').value = sgst.toFixed(2);
    document.getElementById('igst_amount').value = igst.toFixed(2);
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
</script>
