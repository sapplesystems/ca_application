<style>
         .debitnotepdf-invoice {
        width: 800px;
        margin: 20px auto;
        border: 1px solid #000;
        padding: 15px;
        font-family: Arial, sans-serif;
        background: #fff;
      }

      .debitnotepdf-header {
        display: flex;
        justify-content: space-between;
      }

      .debitnotepdf-company-details {
        font-size: 13px;
        line-height: 1.5;
      }

      .debitnotepdf-company-name {
        margin: 0;
        font-size: 18px;
      }

      .debitnotepdf-logo {
        font-size: 40px;
        font-weight: bold;
        color: #1b4fa3;
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
        border: 1px solid #000;
      }

      .debitnotepdf-table th,
      .debitnotepdf-table td {
        padding: 6px;
        text-align: center;
      }

      .debitnotepdf-table th {
        background: #eee;
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
</style><div class="debitnotepdf-invoice">
      
      <div class="debitnotepdf-header ">
        <div class="debitnotepdf-company-details">
          <h2 class="debitnotepdf-company-name"><?php echo $company['name']; ?></h2>
          <b><?php echo $company['type_of_company']; ?></b><br />
          Address : <?php echo $company['registered_office']; ?><br />
          Ph. No. : <?php echo $company['telephone']; ?><br />
          E-mail : <?php echo $company['email']; ?><br />
        </div>
        <div class="debitnotepdf-logo">CA</div>
      </div>

   
      <div class="debitnotepdf-title">Debit Note</div>

      
      <div class="debitnotepdf-info">
        <div class="debitnotepdf-info-row">
          <div>
            <b>Service Tax Registration Number:</b><?php echo $client['registration_no']; ?><br />
            <b>Category Of Service:</b><?php echo $company['type_of_company']; ?><br />
          </div>
          <div>
            <b>Invoice No.:</b><?php echo $debitNote['debit_no']; ?><br />
            <b>Date:</b> <?php echo $debitNote['date']; ?>
          </div>
        </div>

        <br />
        <b>Issued To,</b><br />
        <b>Name :</b><?php echo $client['legal_name']; ?> <br />
        <b>Address :</b><?php echo $client['registered_office']; ?> <br />
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
        <div>
          <b>Banker's Details</b><br />
          ICICI Bank Ltd<br />
          Ac.No. : <?php echo $company['head_office']; ?><br />
          IFSC Code : ICIC0000722
        </div>
        <div class="debitnotepdf-sign">
          <b><?php echo $company['name']; ?></b><br /><br /><br />
          Authorised Signatory
        </div>
      </div>

      
      <div class="debitnotepdf-terms">
        <b>Terms & Conditions</b><br />
       <?php echo nl2br(esc($debitNote['terms_and_conditions'])); ?>
      </div><br/>
       <div class="right">
        <button onclick="window.print()">Print Invoice</button>
    </div>
    </div>
   