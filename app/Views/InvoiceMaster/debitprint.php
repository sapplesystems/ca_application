<style>
    body{
    font-family: 'Cambria', serif!important;
}
     @font-face {
    font-family: 'Cambria';
    src: url("<?= base_url('public/fonts/Cambria.ttf') ?>") format('truetype'),
         url("<?= base_url('public/fonts/Cambria.woff') ?>") format('woff'),
         url("<?= base_url('public/fonts/Cambria.woff2') ?>") format('woff2');
    font-weight: normal;
    font-style: normal;
}
.debitnotepdf-invoice {
    width: 100%;
    max-width: 750px;
    box-sizing: border-box;
    margin: 20px auto;
    border: 1px solid #D3D3D3;
    padding: 10px;
    font-family: 'Cambria', serif !important;
    background: #fff;
}

.debitnotepdf-header {
    width: 100%;
    display: table;
}

.debitnotepdf-company-details {
    display: table-cell;
    width: 75%;
    vertical-align: top;
    font-size:14px;
}

.debitnotepdf-logo {
    display: table-cell;
    width: 25%;
    text-align: right;
    vertical-align: top;
}

.debitnotepdf-title {
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
    line-height: 1.6;
}

.debitnotepdf-info-row {
    display: flex;
    justify-content: space-between;
}

.debitnotepdf-note {
    font-size: 13px;
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
    padding: 6px;
    text-align: center;
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
    display: flex;
    justify-content: space-between;
}

.debitnotepdf-sign {
    text-align: right;
}

.debitnotepdf-terms {
    font-size: 12px;
    margin-top: 15px;
}
.debitnotepdf-bank{
    width: 100%;
    border: 1px solid #BDBDBD;
    display: table;
    table-layout: fixed;
    min-height: 170px;
}

.debitnotepdf-bank-left{
    width: 50%;
    display: table-cell;
    vertical-align: top;
    padding: 10px;
    border-right: 1px solid #BDBDBD;
    line-height: 24px;
}

.debitnotepdf-bank-right{
    width: 50%;
    display: table-cell;
    vertical-align: top;
    position: relative;
    padding: 10px;
    height: 170px;
}

.debitnotepdf-company-name{
    text-align: right;
    font-size: 14px;
    vertical-align: top;
    font-weight:bold;
}

.debitnotepdf-sign{
    position: absolute;
    bottom: 0;
    right: 10px;
    font-size: 16px;
    margin: 0;
    padding: 0;
    font-weight: bold;
    
}
@media print {

    body {
        margin: 0;
        padding: 0;
    }

    .debitnotepdf-invoice {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 10px !important;
        border: 1px solid #D3D3D3;
        box-sizing: border-box;
    }

    img {
        max-width: 150px !important;
        height: auto !important;
    }

    .debitnotepdf-header,
    .debitnotepdf-info-row,
    .debitnotepdf-bank {
        display: table;
        width: 100%;
    }

    .debitnotepdf-header > div,
    .debitnotepdf-info-row > div,
    .debitnotepdf-bank > div {
        display: table-cell;
        vertical-align: top;
    }
}
.debitnotepdf-company-name
{
    margin-top:0px;
}
.debitnotepdf-info-row {
    width: 100%;
    display: table;
    table-layout: fixed;
}

.debitnotepdf-left {
    display: table-cell;
    width: 70%;
    vertical-align: top;
}

.debitnotepdf-right {
    display: table-cell;
    width: 30%;
    vertical-align: top;
    text-align: left;
    padding-left: 40px;
}
</style>
<div class="debitnotepdf-invoice">

    <div class="debitnotepdf-header ">
        <div class="debitnotepdf-company-details">
            <strong style="font-size:22px;"><?php echo $company['name']; ?></strong><br>
            <span style="font-weight:600;font-size:15px">
                            <?php echo $company['type_of_company']; ?>
                        </span><br>
        
            Address : <?php echo $company['registered_office']; ?><br />
            Ph. No. : <?php echo $company['telephone']; ?><br />
            E-mail : <?php echo $company['email']; ?><br />
            GSTIN: <?php echo $company['gstin']; ?><br />
        </div>
        <div class="debitnotepdf-logo">
           <img src="<?= base_url('public/uploads/company_logo/' . $company['logo']); ?>" 
alt="Company Logo"
style="width:180px; height:auto; display:block; margin-left:auto;">
        </div>
    </div>


    <div class="debitnotepdf-title">
        <?= ($debitNote['note_type'] === 'debit') ? 'Debit Note' : 'Credit Note'; ?>
    </div>


    <div class="debitnotepdf-info">
        <div class="debitnotepdf-info-row">

    <div class="debitnotepdf-left">
        <b>Issued To,</b><br />
        <b>Name :</b> <?php echo $client['legal_name']; ?> <br />
        <b>Address :</b> <?php echo $client['registered_office']; ?> <br />
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

    <p class="debitnotepdf-note">
        Kindly acknowledge the expenses incurred by us on your behalf, given
        below are details of the expenses, we request you to send us the payment
        at an early date.
    </p>


    <table class="debitnotepdf-table">
        <tr>
            <th>SL No.</th>
            <th>Details Of Expenses</th>
            <th>Amount (Rs)</th>
        </tr>
        <?php if (!empty($expenses)) : ?>
        <?php foreach ($expenses as $index => $exp) : ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td class="debitnotepdf-text-left">
                <?= esc($exp['expense_description']) ?>
            </td>
            <td>
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
            <td>A</td>
            <td class="debitnotepdf-text-left">
                Total Recoverable Expenses
            </td>
            <td><?php echo $debitNote['total_recoverable_expenses']; ?></td>
        </tr>
        <tr class="debitnotepdf-summary">
            <td>B</td>
            <td class="debitnotepdf-text-left">(-) Advances Received</td>
            <td><?php echo $debitNote['advance_amount']; ?></td>
        </tr>
        <tr class="debitnotepdf-summary">
            <td>C</td>
            <td class="debitnotepdf-text-left">Net Amount(A+B)</td>
            <td><?php echo $debitNote['total_amount']; ?></td>
        </tr>
    </table>


  <div class="debitnotepdf-bank">

    <div class="debitnotepdf-bank-left">
        <b>Banker's Details</b><br>

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
<script>
window.onload = function () {
    window.print();
};

window.onafterprint = function () {
    window.location.href = "<?= base_url('invoice-mangement'); ?>";
};
</script>