<!DOCTYPE html>
<html>
<head>
    <title>Receipt Note</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 30px;
            background: #fff;
        }

        .receipt-container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-sizing: border-box;
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

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
        }

        .print-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin: 30px 0;
        }

        .action-btn {
            border: none;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all .3s ease;
            min-width: 180px;
        }

        .print-btn {
            background: linear-gradient(135deg, #1f5d6b, #2f7f91);
            color: #fff;
        }

        .cancel-btn {
            background: linear-gradient(135deg, #999, #777);
            color: #fff;
        }

        /* ===== PRINT STYLES - BLANK PAGE FIXED ===== */
        @media print {
            /* Remove all extra margins and padding */
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
                height: auto !important;
                min-height: 0 !important;
            }

            body {
                font-size: 11px !important;
                display: block !important;
            }

            /* Main container - fit in one page */
            .receipt-container {
                max-width: 100% !important;
                width: 100% !important;
                padding: 10px 15px !important;
                margin: 0 !important;
                background: #fff !important;
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
                page-break-before: avoid !important;
                /* Force single page */
                height: auto !important;
                max-height: none !important;
                overflow: visible !important;
            }

            /* Hide print buttons */
            .print-actions {
                display: none !important;
            }

            /* Prevent any page breaks */
            .receipt-container > * {
                page-break-inside: avoid !important;
                page-break-after: avoid !important;
                page-break-before: avoid !important;
            }

            /* Table - keep on one page */
            table {
                page-break-inside: avoid !important;
                page-break-after: avoid !important;
                margin-top: 5px !important;
                font-size: 10px !important;
            }

            td {
                padding: 3px 5px !important;
                font-size: 10px !important;
                line-height: 1.3 !important;
            }

            /* Reduce header size */
            .title {
                font-size: 14px !important;
                margin: 5px 0 !important;
            }

            /* Reduce company header */
            .receipt-container > div:first-child {
                margin-bottom: 5px !important;
                line-height: 1.2 !important;
            }

            .receipt-container > div:first-child div:first-child {
                font-size: 20px !important;
            }

            .receipt-container > div:first-child div:nth-child(2) {
                font-size: 13px !important;
                margin-bottom: 3px !important;
            }

            .receipt-container > div:first-child div:last-child {
                font-size: 11px !important;
            }

            .footer {
                font-size: 10px !important;
                margin-top: 5px !important;
            }

            /* CRITICAL FIX: Remove blank page */
            @page {
                size: A4;
                margin: 0.3cm !important;
                padding: 0 !important;
            }

            /* Remove extra blank page at end */
            .receipt-container:last-child {
                page-break-after: avoid !important;
            }

            /* Hide empty space */
            br {
                display: none !important;
            }

            .receipt-container > div:first-child br {
                display: inline !important;
            }

            /* Fix for Chrome blank page issue */
            @page :last {
                margin: 0 !important;
            }

            /* Ensure no extra content */
            .receipt-container::after {
                content: none !important;
                display: none !important;
            }
        }

        @font-face {
            font-family: 'Cambria';
            src: url('../public/fonts/Cambria.woff2') format('woff2'),
                url('../public/fonts/Cambria.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <!-- HEADER -->
        <div style="text-align:center; margin-bottom:15px; line-height:1.3;">
            <div style="font-size:28px; font-weight:bold; text-transform:uppercase; font-family:'Times New Roman', serif;">
                <?= esc($company['name']) ?>
            </div>
            <div style="font-size:17px; color:#555; font-style:italic; margin-bottom:5px;">
                <?= esc($company['type_of_company']) ?>
            </div>
            <div style="font-size:15px; font-family:'Times New Roman', serif;">
                <strong>Address :</strong>
                <span style="font-weight:normal; color:#444;">
                    <?= esc($company['registered_office']) ?>
                </span>
                <br>
                <strong>Ph No.:</strong>
                <span style="font-weight:normal; color:#444;">
                    <?= esc($company['telephone']) ?>
                </span>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Email-Id:</strong>
                <span style="font-weight:normal; color:#444;">
                    <?= esc($company['email']) ?>
                </span>
            </div>
        </div>

        <div class="title">Receipt Note</div>

        <!-- INFO TABLE -->
        <table>
            <tr>
                <td style="width:10%;"><b>PAN :</b></td>
                <td style="width:35%;"><?= esc($client['pan'] ?? '') ?></td>
                <td style="width:20%;"><b>Receipt Note No. :</b></td>
                <td style="width:35%;"><?= esc($receipt['recipt_no']) ?></td>
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
                <td colspan="3"><?= $receipt['mode_of_payment'] === 'Online'
                    ? 'Online Transfer'
                    : esc($receipt['mode_of_payment']) ?></td>
            </tr>
              <?php
        $formatter = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);

        $amountInWords = ucwords(
            $formatter->format((int)$receipt['bill_amount'])
        );
        ?>
            <tr>
                <td colspan="4" style="font-size:11px; line-height:1.6;">
                    Received with thanks from M/s/Mr/Mrs/Ms
                    <b><?= esc($client['legal_name']) ?></b>,
                    the sum of Rs. <b><?= number_format($receipt['bill_amount'], 2) ?></b>
                    /- Amount in Words <b><?= esc($amountInWords) ?> Only</b>
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

        <div class="print-actions">
            <button class="action-btn print-btn" onclick="printInvoicePage()">
                🖨 Print Invoice
            </button>
            <button class="action-btn cancel-btn" onclick="cancelPrint()">
                ✖ Cancel
            </button>
        </div>
    </div>

    <script>
        // Auto print on load
        window.onload = function() {
            window.print();
        };

        function printInvoicePage() {
            window.print();
        }

        function cancelPrint() {
            window.location.href = '<?= base_url('ManageInvoice/' . $invoice['client_id']); ?>';
        }
    </script>
</body>
</html>