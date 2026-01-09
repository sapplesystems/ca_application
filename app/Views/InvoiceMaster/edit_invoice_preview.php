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
<tr>
    <td align="center">1</td>
    <td>
        <?= esc($company['name']); ?> (<?= esc($company['type_of_company']); ?>)
        <input type="text" name="service_description"
               value="<?= esc($invoice['service_description']); ?>"
               style="width:100%;margin-top:6px;">
    </td>
    <td>
        <input type="number" class="service-amount"
               name="service_amount"
               value="<?= esc($invoice['service_value']); ?>"
               style="width:100%;text-align:right;">
    </td>
</tr>

<tr style="background:#0b5c7d;color:#fff;">
    <td align="center">A</td>
    <td align="right">Service Value</td>
    <td align="right"><span id="serviceValue">0</span></td>
</tr>

<?php if ($invoice['tax_apply_name'] === 'cgst_sgst'): ?>
<tr>
    <td align="center">i</td>
    <td>CGST @ 9%</td>
    <td><input readonly id="cgstAmount" style="width:100%;text-align:right;"></td>
</tr>
<tr>
    <td align="center">ii</td>
    <td>SGST @ 9%</td>
    <td><input readonly id="sgstAmount" style="width:100%;text-align:right;"></td>
</tr>
<?php endif; ?>

<?php if ($invoice['tax_apply_name'] === 'igst'): ?>
<tr>
    <td align="center">i</td>
    <td>IGST @ 18%</td>
    <td><input readonly id="igstAmount" style="width:100%;text-align:right;"></td>
</tr>
<?php endif; ?>

<tr style="background:#0b5c7d;color:#fff;">
    <td align="center">B</td>
    <td align="right">Total Tax</td>
    <td align="right"><span id="expenseTotal">0</span></td>
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
<input type="hidden" name="service_value" id="serviceValueInput">
<input type="hidden" name="cgst_amount" id="cgstInput">
<input type="hidden" name="sgst_amount" id="sgstInput">
<input type="hidden" name="igst_amount" id="igstInput">
<input type="hidden" name="expense_total" id="expenseTotalInput">
<input type="hidden" name="grand_total" id="grandTotalInput">
<input type="hidden" name="net_amount" id="netAmountInput">

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

    let service = parseFloat(document.querySelector('.service-amount').value || 0);

    document.getElementById('serviceValue').innerText = service.toFixed(2);

    let cgst = 0, sgst = 0, igst = 0;

    if (document.getElementById('cgstAmount')) {
        cgst = service * 0.09;
        sgst = service * 0.09;
        cgstAmount.value = cgst.toFixed(2);
        sgstAmount.value = sgst.toFixed(2);
    }

    if (document.getElementById('igstAmount')) {
        igst = service * 0.18;
        igstAmount.value = igst.toFixed(2);
    }

    let tax = cgst + sgst + igst;
    document.getElementById('expenseTotal').innerText = tax.toFixed(2);

    let grand = service + tax;
    document.getElementById('grandTotal').innerText = grand.toFixed(2);

    let advance = parseFloat(document.getElementById('advance').value || 0);
    let net = grand - advance;

    document.getElementById('netAmount').innerText = net.toFixed(2);
    document.getElementById('amountInWords').innerText =
        numberToWords(Math.round(net)).toUpperCase();

    serviceValueInput.value = service;
    expenseTotalInput.value = tax;
    grandTotalInput.value = grand;
    netAmountInput.value = net;
    cgstInput.value = cgst;
    sgstInput.value = sgst;
    igstInput.value = igst;
}

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
