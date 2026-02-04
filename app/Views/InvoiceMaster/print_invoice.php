<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice <?= esc($invoice['invoice_no']); ?></title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 13px;
        background: #f2f2f2;
    }

    /* Main Box */
    .invoice-box {
        width: 85%;
        margin: 20px auto;
        background: #fff;
        border: 1px solid #cfcfcf;
        padding: 0;
    }

    /* Tables */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Top Company Table */
    .invoice-box table:first-child td {
        border: none;
        padding: 15px;
        vertical-align: top;
    }

    /* Logo Right */
    .logo img {
        max-width: 180px;
        height: auto;
    }

    /* Professional Invoice Black Strip */
    .invoice-box table:first-child th {
        background: #000;
        color: #fff;
        padding: 8px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }

    /* GST / Invoice Row */
    .invoice-box table:first-child tr:nth-child(3) td,
    .invoice-box table:first-child tr:nth-child(4) td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    /* Bill To Section */
    .invoice-box table:nth-child(2) td {
        border: 1px solid #ddd;
        padding: 10px;
        background: #f9f9f9;
    }

    /* Main Service Table */
    th {
        background: #155e75;
        color: #fff;
        padding: 8px;
        font-weight: bold;
        text-align: center;
    }

    td {
        border: 1px solid #ddd;
        padding: 7px;
    }

    /* Section Heading Rows like Nature, Tax etc */
    td[colspan="3"] {
        background: #e6eef2;
        font-weight: bold;
    }

    /* Alternate rows light blue */
    table tr:nth-child(even) td {
        background: #eef5f8;
    }

    /* Strong rows A B C darker */
    tr td strong {
        font-weight: bold;
    }

    /* Alignment */
    .right {
        text-align: right;
    }

    .center {
        text-align: center;
    }

    /* Footer text */
    p {
        padding: 10px 15px;
        margin: 0;
        font-size: 12px;
    }

    /* Print Button */
    button {
        background: #155e75;
        color: #fff;
        border: none;
        padding: 6px 14px;
        cursor: pointer;
    }

    button:hover {
        background: #0e3f4f;
    }

    /* Print View */
    @media print {
        button {
            display: none;
        }

        body {
            background: #fff;
        }
    }
    </style>

</head>

<body>
    <div class="invoice-box">

        <table>
            <tr>
                <td>
                    <div style="padding:15px 20px; line-height:1.6;">
                        <strong style="font-size:18px;"><?= esc($company['name']); ?></strong><br>

                        Address: <?= esc($company['registered_office']); ?><br>
                        PH: <?= esc($company['telephone']); ?><br>
                        Email: <?= esc($company['email']); ?><br>
                    </div>
                </td>
                <td class="right">
                    <div class="logo">
                        <img src="<?= base_url('public/uploads/company_logo/' . $company['logo']); ?>"
                            alt="Company Logo" style="max-width:200px; max-height:200px;">
                    </div>

                </td>
            </tr>
            <tr>
                <th colspan=2>
                    <p>Professional Invoice</p>
                </th>

            </tr>
            <tr>
                <td> <strong>GSTIN:</strong> <?= esc($company['gstin']); ?></td>
                <td> <strong>Invoice No:</strong> <?= esc($invoice['invoice_no']); ?></td>

            </tr>
            <tr>
                <td> <strong>Type of Company:</strong><?= esc($company['type_of_company']); ?></td>
                <td> <strong>Date:</strong> <?= esc($invoice['invoice_date']); ?></td>

            </tr>

        </table>



        <table>



            <tr>
                <td><strong>Bill
                        To:</strong><br><?= esc($client['legal_name']); ?><br><?= esc($client['registered_office']); ?>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <th>SL No.</th>
                <th>Nature of Services</th>
                <th class="right">Amount (Rs)</th>
            </tr>
            <tr>
                <td colspan="3"><strong>Nature of Services</strong></td>
            </tr>
            <?php $sl = 1; ?>
            <?php foreach ($invoice_works as $service): ?>

            <tr>

                <td class="center"><?= $sl++; ?></td>
                <td><?= esc($service['service_description']); ?></td>
                <td class="right"><?= number_format($service['service_amount'],2); ?></td>

            </tr>
            <?php endforeach; ?>
            <tr>
                <th class="center"><strong>A</strong></th>
                <th class="right"><strong>Service Value</strong></th>
                <td class="right"><strong><?= number_format($serviceTotal, 2); ?></strong></td>
            </tr>
            <?=
       
        $serviceTotal  = (float) $serviceTotal;
        $expenseTotal  = (float) ($invoice['expense_total'] ?? 0);
        $subTotal = $serviceTotal + $expenseTotal; ?>
            <tr>
                <td colspan="3"><strong>Expenses Recoverable</strong></td>
            </tr>
            <?php $sl = 1; ?>
            <?php foreach ($expences as $exp): ?>

            <tr>

                <td class="center"><?= $sl++; ?></td>
                <td><?= esc($exp['expense_description']); ?></td>
                <td class="right"><?= number_format($exp['expense_amount'],2); ?></td>

            </tr>
            <?php endforeach; ?>
            <tr>
                <th class="center"><strong>B</strong></th>
                <th class="right"><strong>Total Expenses Recoverable</strong></th>
                <th class="right"><strong><?= number_format((float)$invoice['expense_total'],2); ?></strong></th>
            </tr>
            <tr>
                <td colspan="3"><strong>Tax</strong></td>
            </tr>
            <?php if($invoice['tax_apply_name']==='cgst_sgst'): ?>
            <tr>
                <td class="center">i</td>
                <td>CGST @ 9%</td>
                <td class="right"><?= number_format((float)$subTotal * 0.09, 2); ?></td>
            </tr>
            <tr>
                <td class="center">ii</td>
                <td>SGST @ 9%</td>
                <td class="right"><?= number_format((float)$subTotal * 0.09, 2); ?></td>
            </tr>
            <?php elseif($invoice['tax_apply_name']==='igst'): ?>
            <tr>
                <td class="center">i</td>
                <td>IGST @ 18%</td>
                <td class="right"><?= number_format((float)$subTotal* 0.18, 2); ?></td>
            </tr>
            <?php endif; ?>

            <tr>
                <td colspan="3"><br></td>
            </tr>
            <tr>
                <td></td>
                <td class="right"><strong>Grand Total</strong></td>
                <td class="right"><strong><?= number_format((float)$invoice['grand_total'],2); ?></strong></td>
            </tr>
            <tr>
                <td></td>
                <td class="right"><strong>(-) Advances Received</strong></td>
                <td class="right"><strong><?= number_format((float)$invoice['advance_received'],2); ?></strong></td>
            </tr>
            <tr>
                <td colspan="3"><br></td>
            </tr>
            <tr>
                <th class="center"><strong>C</strong></th>
                <th>(Amount in Words)<strong> <?= esc($invoice['amount_in_words']); ?></strong></th>
                <th class="right"><strong><?= number_format((float)$invoice['total_invoice_amount'],2); ?></strong></th>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <p><strong>Banker Details:<br>
                            Branch name:<?= esc($company['bank_name']); ?>
                            <br>Ac No: <?= esc($company['bank_ac_no']); ?><br>
                            Address:
                            <?= esc($company['head_office']); ?><br>IFSC:<?= esc($company['bank_ifsc']); ?>
                        </strong></p>
                </td>
                <td>
                    <p><strong style="font-size:16px;float:right"><?= esc($company['name']); ?></strong></p>
                </td>
            </tr>
        </table>




        <p><strong>Terms & Conditions:</strong><br><?= nl2br(esc($invoice['term_condition'])); ?></p>

        <div class="right">
            <button onclick="window.print()">Print Invoice</button>
        </div>
    </div>
</body>

</html>