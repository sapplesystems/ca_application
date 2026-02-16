<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Invoice <?= esc($invoice['invoice_no']); ?></title>

<style>

body {
    font-family: Arial, sans-serif;
    font-size: 15px;
    background: #f2f2f2;
}

/* Main Box */
.invoice-box {
    width: 85%;
    margin: 20px auto;
    background: #fff;
    border: 1px solid #cfcfcf;
}

/* Tables */
table {
    width: 100%;
    border-collapse: collapse;
}

/* Header Section */
.invoice-box table:first-child td {
    border: none;
    padding: 12px 15px;
    vertical-align: top;
    font-size:14px!important;
}

.logo img {
    max-width: 180px;
    height: auto;
}
.logo {
    width: 200px;   /* fixed width */
    height: 120px;   /* fixed height */
    /* display: flex;
    align-items: center;
    justify-content: flex-end;
    overflow: hidden; */
    float:right;
}

.logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}


/* Tax Invoice Bar */
.invoice-box table:first-child th {
    background: #1f5d6b;
    color: #fff;
    padding: 10px;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}

/* Bill To Section */
.invoice-box table:nth-child(2) td {
    border: 1px solid #d5d5d5;
    padding: 12px 15px;
    background: #f3f3f3;
}

/* Invoice Info Right Box */
.invoice-info {
    display: inline-block;
    background: #f3f3f3;
    /* border: 1px solid #d5d5d5; */
    padding: 10px 15px;
    text-align: left;
    min-width: 240px;
}

.invoice-info strong {
    display: inline-block;
    width: 110px;
}

/* Main Table Header */
th {
    background: #1f5d6b;
    color: #fff;
    padding: 7px;
    font-weight: bold;
    text-align: center;
    font-size:14px !important;
}

td {
    border: 1px solid #ddd;
    padding: 7px;
    font-size:14px !important;
}

/* Section Headings */
td[colspan="3"] {
    background: #e8f1f5;
    font-weight: bold;
}

/* Alternate Row Color */
table tr:nth-child(even) td {
    background: #f7fbfd;
}

/* Alignment */
.right {
    text-align: right;
}

.center {
    text-align: center;
}

/* Footer */
p {
    padding: 10px 15px;
    margin: 0;
    font-size: 12px;
}

/* Print */
@media print {

    @page {
        size: A4;
        margin: 5mm;
    }
     p {
        padding: 4px 10px !important;
    }
html, body {
    margin: 0 !important;
    padding: 0 !important;
    background: #fff !important;
}

    .invoice-box {
        width: 100%;
        margin: 0;
        border: none;
        box-shadow: none;
    }

    /* table {
        page-break-inside: avoid !important;
    } */

    tr, td, th {
        page-break-inside: avoid !important;
    }

}


</style>
</head>

<body>

<div class="invoice-box">

<!-- HEADER -->
<table>
<tr>
<td>
<div style="line-height:1.6;">
<strong style="font-size:24px;">
<?= esc($company['name']); ?>
</strong><br>
<span style="font-weight:600;font-size:16px"><?= esc($company['type_of_company']); ?></span><br>
Address: <?= esc($company['registered_office']); ?><br>
PH: <?= esc($company['telephone']); ?><br>
Email: <?= esc($company['email']); ?><br>
GSTIN: <?= esc($company['gstin']); ?>

</div>
</td>

<td class="right">
<div class="logo">
<img src="<?= base_url('public/uploads/company_logo/' . $company['logo']); ?>">
</div>
</td>
</tr>

<tr>
<th colspan="2">Tax Invoice</th>
</tr>
</table>


<!-- BILL TO + INVOICE INFO -->
<table>
<tr>

<td style="width:60%; vertical-align:top;border-right: 0;">
<strong>Bill To:</strong><br>
<?= esc($client['legal_name']); ?><br>
<?= esc($client['registered_office']); ?><br>
E-mail ID:<br>
GST No:
</td>

<td style="width:40%; vertical-align:top; text-align:right;border-left: 0;">

<div class="invoice-info">

<div>
<strong>Invoice No:</strong>
<?= esc($invoice['invoice_no']); ?>
</div>

<div>
<strong>Date :</strong>
<?php
$date = new DateTime($invoice['invoice_date']);
echo esc($date->format('d.m.Y'));
?>
</div>

</div>

</td>
</tr>
</table>


<!-- SERVICE TABLE -->
<table>

<tr>
<th style="width:10%">SL No.</th>
<th style="width:55%">Particulars of Services</th>
<th style="width:15%;text-align: right;">Sac Code</th>
<th style="width:20%" class="right">Amount (Rs)</th>
</tr>

<?php $sl = 1; ?>
<?php foreach ($invoice_works as $service): ?>

<tr>
<td class="center"><?= $sl++; ?></td>

<td>
<strong><?= esc($service['service_name']); ?></strong><br>
<?= esc($service['service_description']); ?>
</td>

<td class="center"style="text-align:right">
    <strong >
       <?= esc($service['sac_code']); ?> 
   </strong>

 
</td>

<td class="right">
<?= number_format($service['service_amount'],2); ?>
</td>
</tr>

<?php endforeach; ?>


<tr>
<th colspan="3" class="right">Service Value</th>
<th class="right"><strong><?= number_format($serviceTotal, 2); ?></strong></th>
</tr>

<!-- <?=
$serviceTotal  = (float) $serviceTotal;
$expenseTotal  = (float) ($invoice['expense_total'] ?? 0);
$subTotal = $serviceTotal + $expenseTotal;
?> -->

<tr>
<td colspan="4"><strong>Expenses Recoverable</strong></td>
</tr>

<?php foreach ($expences as $exp): ?>

<tr>
<td></td>
<td><?= esc($exp['expense_description']); ?></td>
<td style="border=0"></td>
<td class="right"><?= number_format($exp['expense_amount'],2); ?></td>
</tr>

<?php endforeach; ?>


<tr>
<th colspan="3" class="right">Total Expenses</th>
<th class="right"><?= number_format((float)$invoice['expense_total'],2); ?></th>
</tr>


<tr>
<td colspan="4"><strong>Tax</strong></td>
</tr>


<?php if($invoice['tax_apply_name']==='cgst_sgst'): ?>

<tr>
<td></td>
<td colspan="2" class="right">CGST @ 9%</td>
<td class="right"><?= number_format($serviceTotal * 0.09, 2); ?></td>
</tr>

<tr>
<td></td>
<td colspan="2" class="right">SGST @ 9%</td>
<td class="right"><?= number_format($serviceTotal * 0.09, 2); ?></td>
</tr>

<?php elseif($invoice['tax_apply_name']==='igst'): ?>

<tr>
<td></td>
<td colspan="2" class="right">IGST @ 18%</td>
<td class="right"><?= number_format($serviceTotal * 0.18, 2); ?></td>
</tr>

<?php endif; ?>


<tr>
<td colspan="3" class="right"><strong>Grand Total</strong></td>
<td class="right"><strong><?= number_format((float)$invoice['grand_total'],2); ?></strong></td>
</tr>

<tr>
<td colspan="3" class="right"><strong>(-) Advances Received</strong></td>
<td class="right"><?= number_format((float)$invoice['advance_received'],2); ?></td>
</tr>

<tr>
<th colspan="3" style="text-align:left">(Amount in Words) <?= esc($invoice['amount_in_words']); ?></th>
<th class="right"><?= number_format((float)$invoice['total_invoice_amount'],2); ?></th>
</tr>

</table>


<!-- FOOTER -->
<table>

<tr>
    <!-- Left Side : Banker Details -->
    <td style="width:65%; vertical-align:top; padding:10px;">
        <p style="font-size:15px; font-weight:400; margin:0;">
            <strong>Banker Details:</strong><br>
            Ac No: <?= esc($company['bank_ac_no']); ?><br>
            IFSC: <?= esc($company['bank_ifsc']); ?><br>
            Bank : <?= esc($company['bank_name']); ?><br>
            Branch name : <?= esc($company['head_office']); ?>
        </p>
    </td>

    <!-- Right Side : Company + Signature -->
    <td style="width:35%; vertical-align:top; padding:10px;height:120px;">
        
        <!-- Company Name Top Right -->
        <p style="font-size:16px; margin:0;">
            <strong>For <?= esc($company['name']); ?></strong>
        </p>

        <!-- Space for Signature -->
        <div style="height:40px;"></div>

        <!-- Auth Sign Bottom Right -->
        <p style="margin:0;">Auth. Sign.</p>

    </td>
</tr>


<tr>
<td colspan="2" style="vertical-align:top;">
<p style="font-size:13px; padding:0; margin:0;">
<strong>Terms & Conditions:</strong><br>
<?= nl2br(esc($invoice['term_condition'])); ?>
</p>
</td>
</tr>

<tr>
<td colspan="2">
<h3 style="text-align:center">
For more information reach us @ www.ksaca.in
</h3>
</td>
</tr>

</table>

</div>

</body>
</html>

<script>
window.onload = function() {
    window.print();
};
</script>
