<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice <?= esc($invoice['invoice_no']); ?></title>
<style>
body { font-family: Arial, sans-serif; font-size: 12px; }
.invoice-box { width: 50%; margin: auto; border: 1px solid #000; padding: 10px; }
table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
th, td { border: 1px solid #000; padding: 4px; font-size: 12px; }
th { background: #000; color: #fff; }
.right { text-align: right; }
.center { text-align: center; }
.no-border { border: none; }
h2 { text-align: center; font-size: 14px; margin: 5px 0; }
</style>
</head>
<body>
<div class="invoice-box">
    <table>
        <tr>
            <td>
                <strong><?= esc($company['name']); ?></strong><br>
                <?= esc($company['type_of_company']); ?><br>
                <?= esc($company['registered_office']); ?><br>
                PH: <?= esc($company['telephone']); ?><br>
                Email: <?= esc($company['email']); ?><br>
                GSTIN: <?= esc($company['gstin']); ?>
            </td>
            <td class="right">
                <strong>Invoice No:</strong> <?= esc($invoice['invoice_no']); ?><br>
                <strong>Date:</strong> <?= esc($invoice['invoice_date']); ?>
            </td>
        </tr>
    </table>

    <h2>Professional Invoice</h2>

    <table>
        <tr>
            <td><strong>Bill To:</strong><br><?= esc($client['legal_name']); ?><br><?= esc($client['registered_office']); ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <th>SL No.</th>
            <th>Nature of Services</th>
            <th class="right">Amount (Rs)</th>
        </tr>
         <tr><td colspan="3"><strong>Nature of Services</strong></td></tr> 
        <?php $sl = 1; ?>
        <?php foreach ($invoice_works as $service): ?>
          
        <tr>
             
            <td class="center"><?= $sl++; ?></td>
            <td><?= esc($service['service_description']); ?></td>
            <td class="right"><?= number_format($service['service_amount'],2); ?></td>
            
        </tr>
        <?php endforeach; ?>
        <tr>
            <td class="center"><strong>A</strong></td>
            <td class="right"><strong>Service Value</strong></td>
            <td class="right"><strong><?= number_format($invoice['service_value'],2); ?></strong></td>
        </tr>
        <tr><td colspan="3"><strong>Tax</strong></td></tr> 
        <?php if($invoice['tax_apply_name']==='cgst_sgst'): ?>
        <tr>
            <td class="center">i</td>
            <td>CGST @ 9%</td>
            <td class="right"><?= number_format($invoice['service_value'] * 0.09, 2); ?></td>
        </tr>
        <tr>
            <td class="center">ii</td>
            <td>SGST @ 9%</td>
            <td class="right"><?= number_format($invoice['service_value'] * 0.09, 2); ?></td>
        </tr>
        <?php elseif($invoice['tax_apply_name']==='igst'): ?>
        <tr>
            <td class="center">i</td>
            <td>IGST @ 18%</td>
            <td class="right"><?= number_format($invoice['service_value'] * 0.18, 2); ?></td>
        </tr>
        <?php endif; ?>
        <tr><td colspan="3"><strong>Expenses Recoverable</strong></td></tr>
          <?php $sl = 1; ?>
        <?php foreach ($expences as $exp): ?>
            
        <tr>
             
            <td class="center"><?= $sl++; ?></td>
            <td><?= esc($exp['expense_description']); ?></td>
            <td class="right"><?= number_format($exp['expense_amount'],2); ?></td>
            
        </tr>
        <?php endforeach; ?>
        <tr>
            <td class="center"><strong>B</strong></td>
            <td class="right"><strong>Total Expenses Recoverable</strong></td>
            <td class="right"><strong><?= number_format($invoice['expense_total'],2); ?></strong></td>
        </tr>
        <tr><td colspan="3"><br></td></tr>
        <tr>
            <td ></td>
            <td class="right"><strong>Grand Total</strong></td>
            <td class="right"><strong><?= number_format($invoice['grand_total'],2); ?></strong></td>
        </tr>
        <tr>
            <td ></td>
            <td class="right"><strong>(-) Advances Received</strong></td>
            <td class="right"><strong><?= number_format($invoice['advance_received'],2); ?></strong></td>
        </tr>
         <tr><td colspan="3"><br></td></tr>
        <tr>
            <td class="center"><strong>C</strong></td>
            <td><strong>Amount in Words</strong></td>
            <td class="right"><strong><?= number_format($invoice['total_invoice_amount'],2); ?></strong></td>
        </tr>
    </table>

    <p><strong>Banker Details:</strong> <?= esc($company['bank_ac_no']); ?> - <?= esc($company['head_office']); ?></p>

    <p><strong>Terms & Conditions:</strong><br><?= nl2br(esc($invoice['term_condition'])); ?></p>

    <div class="right">
        <button onclick="window.print()">Print Invoice</button>
    </div>
</div>
</body>
</html>
