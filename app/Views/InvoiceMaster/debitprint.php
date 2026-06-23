<style>
    body{
    font-family: 'Cambria', serif!important;
    margin: 0;
    padding: 0;
}
     @font-face {
    font-family: 'Cambria';
    src: url("<?= base_url('public/fonts/Cambria.ttf') ?>") format('truetype'),
         url("<?= base_url('public/fonts/Cambria.woff') ?>") format('woff'),
         url("<?= base_url('public/fonts/Cambria.woff2') ?>") format('woff2');
    font-weight: normal;
    font-style: normal;
}

/* ====== MAIN CONTAINER - YAHAN CHANGE KIYA HAI ====== */
.debitnotepdf-invoice {
    width: 94% !important;
    max-width: 750px;
    box-sizing: border-box;
    margin: 20px auto !important;
    border: 1px solid #D3D3D3;
    padding: 5px 0px !important;  /* LEFT-RIGHT SAME PADDING */
    font-family: 'Cambria', serif !important;
    background: #fff;
}

.debitnotepdf-header {
    width: 100%;
    display: table;
    table-layout: fixed;
    padding: 5px 10px;
}

.debitnotepdf-company-details {
    display: table-cell;
    width: 70%;
    vertical-align: top;
    font-size:14px;
    padding-right: 10px;
}

.debitnotepdf-logo {
    display: table-cell;
    width: 30%;
    text-align: right;
    vertical-align: top;
    padding-left: 10px;
}

.debitnotepdf-title-note {
    background: #000;
    color: #fff;
    text-align: center;
    font-size: 18px;
    padding: 5px;
    margin: 10px 0;
    font-weight: bold;
}

.debitnotepdf-info {
    font-size: 13px;
    /* line-height: 1.6; */
}

.debitnotepdf-info-row {
    width: 100%;
    display: table;
    table-layout: fixed;
    padding: 5px 10px;
}

.debitnotepdf-left {
    display: table-cell;
    width: 60%;
    vertical-align: top;
    padding-right: 10px;
}

.debitnotepdf-right {
    display: table-cell;
    width: 40%;
    vertical-align: top;
    text-align: left;
    padding-left: 10px;
}

.debitnotepdf-note {
    font-size: 13px;
    padding: 0px 5px;
}

.debitnotepdf-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    font-size: 13px;
}

.debitnotepdf-table,
.debitnotepdf-table th,
.debitnotepdf-table td {
    border: 1px solid #BDBDBD;
}

.debitnotepdf-table th,
.debitnotepdf-table td {
    padding: 6px 8px;
}

.debitnotepdf-table th {
    background: #F5F5F5;
}

.debitnotepdf-text-left {
    text-align: left;
}

.debitnotepdf-summary td {
    font-weight: bold;
}

.debitnotepdf-bank {
    font-size: 13px;
    margin-top: 15px;
    display: table;
    table-layout: fixed;
    width: 100%;
    border: 1px solid #BDBDBD;
    /* min-height: 170px; */
}

.debitnotepdf-bank-left{
    width: 50%;
    display: table-cell;
    vertical-align: top;
    padding: 0px 5px;
    border-right: 1px solid #BDBDBD;
}

.debitnotepdf-bank-right{
    width: 50%;
    display: table-cell;
    vertical-align: top;
    position: relative;

    /* height: 170px; */
}

.debitnotepdf-company-name{
    text-align: right;
    font-size: 14px;
    vertical-align: top;
    font-weight:bold;
    padding:0px 10px;
    
}

.debitnotepdf-sign{
    position: absolute;
    bottom: 5px;
    right: 10px;
    font-size: 13px;
    margin: 0;
    padding: 0;
    font-weight: bold;
}

.right{
    text-align:right;
}
.center{
    text-align:center;
}
 .cancel-btn {
        background: linear-gradient(135deg, #999, #777);
        color: #fff;
         margin-top: 10px;
    }

    .cancel-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.2);
    }
    .action-btn {
        padding: 12px 28px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        letter-spacing: 0.5px;
         margin-top: 30px;
    }
     .print-btn {
        background: linear-gradient(135deg, #1f5d6b, #2f7f91);
        color: #fff;
    }

    .print-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.2);
    }

@media print {
    .cancel-btn {
        display: none !important;
    }
    .print-btn {
        display: none !important;
    }
    
    body {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
    }

    /* ====== PRINT MEIN BHI YAHI CHANGE ====== */
    .debitnotepdf-invoice {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 auto !important;
        padding: 5px 0px !important;  /* LEFT-RIGHT EQUAL */
        border: 1px solid #D3D3D3 !important;
        box-sizing: border-box !important;
    }

    .debitnotepdf-header {
        display: table !important;
        width: 100% !important;
        table-layout: fixed !important;
    }

    .debitnotepdf-company-details {
        display: table-cell !important;
        width: 70% !important;
        vertical-align: top !important;
        padding-right: 10px !important;
    }

    .debitnotepdf-logo {
        display: table-cell !important;
        width: 30% !important;
        text-align: right !important;
        vertical-align: top !important;
        padding-left: 10px !important;
    }

    .debitnotepdf-logo img {
        max-width: 150px !important;
        height: auto !important;
    }

    .debitnotepdf-info-row {
        display: table !important;
        width: 100% !important;
        table-layout: fixed !important;
        padding: 5px 10px;
    }

    .debitnotepdf-left {
        display: table-cell !important;
        width: 60% !important;
        vertical-align: top !important;
        padding-right: 10px !important;
    }

    .debitnotepdf-right {
        display: table-cell !important;
        width: 40% !important;
        vertical-align: top !important;
        text-align: left !important;
        padding-left: 10px !important;
    }

    .debitnotepdf-bank {
        display: table !important;
        table-layout: fixed !important;
        width: 100% !important;
        border: 1px solid #BDBDBD !important;
        /* min-height: 170px !important; */
    }

    .debitnotepdf-bank-left {
        display: table-cell !important;
        width: 50% !important;
        vertical-align: top !important;
        padding: 0px 5px !important;
        border-right: 1px solid #BDBDBD !important;
    }

    .debitnotepdf-bank-right {
        display: table-cell !important;
        width: 50% !important;
        vertical-align: top !important;
        position: relative !important;
        padding: 12px 12px !important;
        /* height: 170px !important; */
    }

    .debitnotepdf-table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    .debitnotepdf-table th,
    .debitnotepdf-table td {
        padding: 6px 8px !important;
    }
   

    .debitnotepdf-sign {
        right: 10px !important;
    }

    * {
        box-sizing: border-box !important;
    }
}
</style>

<div class="debitnotepdf-invoice">

    <div class="debitnotepdf-header ">
        <div class="debitnotepdf-company-details">
            <strong style="font-size:22px;"><?php echo $company['name']; ?></strong><br>
            <span style="font-weight:600;font-size:15px">
                            <?php echo $company['type_of_company']; ?>
                        </span><br>
        
           <b> Address :</b><?= nl2br(esc($company['registered_office'])); ?><br /> 
           <b> Ph. No. : </b><?php echo $company['telephone']; ?><br />
           <b> E-mail : </b><?php echo $company['email']; ?><br />
            <b>GSTIN:</b> <?php echo $company['gstin']; ?><br />
        </div>
        <div class="debitnotepdf-logo">
           <img src="<?= base_url('public/uploads/company_logo/' . $company['logo']); ?>" 
alt="Company Logo"
style="width:180px; height:auto; display:block;">
        </div>
    </div>


    <div class="debitnotepdf-title-note">
        <?= ($debitNote['note_type'] === 'debit') ? 'Debit Note' : 'Credit Note'; ?>
    </div>


    <div class="debitnotepdf-info">
        <div class="debitnotepdf-info-row">

    <div class="debitnotepdf-left">
        <b>Issued To,</b><br />
        <b>Name :</b> <?php echo $client['legal_name']; ?> <br />
        <b>Address :</b> <?php echo htmlspecialchars($client['registered_office']); ?> <br />
        <b>Email :</b> <?php echo $client['email']; ?> <br />
        <b>GSTIN :</b> <?php echo $client['gstin']; ?> <br />
    </div>

    <div class="debitnotepdf-right">
        <?php if ($debitNote['note_type'] === 'debit') : ?>
        <b>Invoice No.:</b> <?= esc($debitNote['debit_no']); ?><br />
        <?php elseif ($debitNote['note_type'] === 'credit') : ?>
        <b>Invoice No.:</b> <?= esc($debitNote['credit_no']); ?><br />
        <?php endif; ?>

        <b>Date:</b> <?php echo $debitNote['date']; ?>
    </div>

</div>

    <table class="debitnotepdf-table">
        <tr>
            <th style="width:12%;">SL No.</th>
            <th style="width:58%;">Particulars</th>
            <th style="width:30%;">Amount (Rs)</th>
        </tr>
        <?php if (!empty($expenses)) : ?>
        <?php foreach ($expenses as $index => $exp) : ?>
        <tr>
            <td class="center"><?= $index + 1 ?></td>
            <td class="center">
                <?= esc($exp['expense_description']) ?>
            </td>
            <td class="right">
                <?= number_format($exp['expense_amount'], 2) ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr>
            <td colspan="3" style="text-align:center;">No expenses found</td>
        </tr>
        <?php endif; ?>

        <tr class="debitnotepdf-summary">
            <td class="center">A</td>
            <td class="center">
                Total Recoverable Expenses
            </td>
            <td class="right"><?php echo number_format($debitNote['total_recoverable_expenses'], 2); ?></td>
        </tr>
        
                        <?php if ($debitNote['tax'] === 'cgst_sgst'): ?>

                <tr >
                    <td></td>
                    <td  class="center"><strong>CGST @ 9%</strong></td>
                    <td class="right"><strong><?= number_format($debitNote['total_recoverable_expenses'] * 0.09, 2); ?></strong></td>
                </tr>

                <tr>
                    <td></td>
                    <td  class="center"><strong>SGST @ 9%</strong></td>
                    <td class="right"><strong><?= number_format($debitNote['total_recoverable_expenses'] * 0.09, 2); ?></strong></td>
                </tr>

            <?php elseif ($debitNote['tax'] === 'igst'): ?>

                <tr>
                    <td></td>
                    <td class="center"><strong>IGST @ 18%</strong></td>
                    <td class="right"><strong><?= number_format($debitNote['total_recoverable_expenses'] * 0.18, 2); ?></strong></td>
                </tr>

            <?php endif; ?>
            <?php
               $amount = $debitNote['total_recoverable_expenses'];

                if ($debitNote['tax'] === 'cgst_sgst') {

                    $cgst = $amount * 9 / 100;
                    $sgst = $amount * 9 / 100;

                    $taxAmount = $cgst + $sgst;

                } else if ($debitNote['tax'] === 'igst')  {

                    $taxAmount = $amount * 18 / 100;
                }
                else{
                    $taxAmount =0;
                }
                $grandTotal = $amount + $taxAmount;
            ?>
            <tr class="debitnotepdf-summary">
                <td></td>
                <td class="center"><strong>Total Amount</strong></td>
                <td class="right"><strong><?php echo number_format($grandTotal, 2); ?></strong></td>
           </tr>
        <tr class="debitnotepdf-summary">
            <td class="center">B</td>
            <td class="center">(-) Advances Received</td>
            <td class="right"><?php echo number_format($debitNote['advance_amount'], 2); ?></td>
        </tr>
        <tr class="debitnotepdf-summary">
            <td class="center">C</td>
            <td class="center">Net Amount(A+B)</td>
            <td class="right"><?php echo number_format($debitNote['total_amount'], 2); ?></td>
        </tr>

    </table>
<p class="debitnotepdf-note">
        Kindly acknowledge the expenses incurred by us on your behalf, given
        below are details of the expenses, we request you to send us the payment
        at an early date.
    </p>

  <div class="debitnotepdf-bank">

    <div class="debitnotepdf-bank-left">
        <b>Bank Details</b><br>

        <?= esc($company['name']); ?><br>

        Bank Name : <?php echo $company['bank_name']; ?><br>

        A/C.No. : <?php echo $company['bank_ac_no']; ?><br>

        IFSC Code : <?php echo $company['bank_ifsc']; ?><br>

        Branch : <?php echo $company['branch_address']; ?>
    </div>

    <div class="debitnotepdf-bank-right">

        <div class="debitnotepdf-company-name">
          <?php echo $company['name']; ?>
        </div>

        <div class="debitnotepdf-sign">
            Authorised Signatory
        </div>

    </div>

</div>
</div>
  <center> 
    <button class="action-btn print-btn" onclick="printInvoicePage()">
        Print 
    </button>
     <button class="action-btn cancel-btn" onclick="cancelPrint()">
        ✖ Cancel
    </button></center> 
<script>

 let isPrinting = false;

    function printInvoicePage() {
        isPrinting = true;
        window.print();
    }

function cancelPrint() {
    window.location.href = "<?= base_url('DebitNoteList/' . $client['id']); ?>";
}

</script>