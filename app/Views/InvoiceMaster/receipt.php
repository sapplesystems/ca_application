<!DOCTYPE html>
<html>
<head>
    <title>Receipt Note</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
        }

        .company-left h2 {
            margin: 0;
            font-size: 20px;
        }

        .company-left small {
            font-style: italic;
            color: #555;
        }

        .company-right {
            text-align: right;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            margin: 15px 0;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, td, th {
            border: 1px solid #000;
        }

        td {
            padding: 6px;
            vertical-align: top;
        }

        .no-border {
            border: none;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <div class="company-left">
            <h2><?= esc($company['name']) ?></h2>
            <small><?= esc($company['type_of_company']) ?></small>
        </div>

        <div class="company-right">
            Address : <?= esc($company['registered_office']) ?><br>
            Ph. No. : <?= esc($company['telephone']) ?><br>
            E-Mail : <?= esc($company['email']) ?>
        </div>
    </div>

    <div class="title">Receipt Note</div>

    <!-- INFO TABLE -->
    <table>
        <tr>
            <td><b>PAN :</b></td>
            <td><?= esc($client['pan'] ?? '') ?></td>
            <td><b>Receipt Note No. :</b></td>
            <td><?= esc($receipt['recipt_no']) ?></td>
        </tr>

        <tr>
            <td colspan="2"></td>
            <td><b>Date :</b></td>
            <td><?= date('d/m/Y', strtotime($receipt['date'])) ?></td>
        </tr>

        <tr>
            <td colspan="4"><b>Issued To,</b></td>
        </tr>

        <tr>
            <td><b>Name :</b></td>
            <td colspan="3"><?= esc($client['legal_name']) ?></td>
        </tr>

        <tr>
            <td><b>Address :</b></td>
            <td colspan="3"><?= esc($client['registered_office']) ?></td>
        </tr>

        <tr>
            <td><b>Mode Of Payment :</b></td>
            <td colspan="3"><?= esc($receipt['mode_of_payment']) ?></td>
        </tr>

        <tr>
            <td colspan="4">
                Received with thanks from M/s/Mr/Mrs/Ms
                <b><?= esc($client['legal_name']) ?></b>,
                the sum of Rs. <b><?= number_format($receipt['bill_amount'], 2) ?></b>
                /- Amount in Words <b>Zero Rupees</b>
                after deduction of TDS Rs.
                <b><?= number_format($receipt['tds_amount'], 2) ?></b>
                /- for professional Services Rendered / Advance Against invoice
                Raised vide Bill No <b><?= esc($invoice['invoice_no']) ?></b>
                dated <b><?= date('d/m/Y', strtotime($invoice['invoice_date'])) ?></b>
            </td>
        </tr>
    </table>

    <div class="footer">
        For more Information reach us @ <b>www.ksaca.in</b>
    </div>

</body>
</html>
