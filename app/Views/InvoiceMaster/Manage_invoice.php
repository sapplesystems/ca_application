<style>
    .print-only {
        display: none !important;
    }

    @font-face {
        font-family: 'Cambria';
        src: url('../public/fonts/Cambria.woff2') format('woff2'),
            url('../public/fonts/Cambria.woff') format('woff');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }
</style><!-------------------------------- Modal for genrate invoice------------------------------------->
<!-- Modal1 -->
<div class="modal fade" id="GenrateVoice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('preview'); ?>">
                    <div class="Gvoice-wrapper">
                        <input type="hidden" name="client_id" value="<?= esc($clients[0]['id']); ?>">
                        <input type="hidden" id="client_state" value="<?= esc($clients[0]['gst_state']); ?>">
                        <!-- Title -->
                        <div class="Gvoice-title">Choose Works And Company For Invoice</div>

                        <!-- Invoice type row -->
                        <!-- <div class="Gvoice-row">
                            <div class="Gvoice-label">
                                Select Invoice Type: <span class="Gvoice-required">*</span>
                            </div>
                            <select class="Gvoice-select">
                                <option>Automatic Invoice</option>
                                <option>Manual Invoice</option> -->
                        <!-- other options -->
                        <!-- </select>
                        </div> -->

                        <!-- Choose work section -->
                        <div class="Gvoice-section-title">Choose Work For Invoice</div>
                        <div class="Gvoice-box">
                            <input type="text" id="workSearch" placeholder="Search work..." class="Gvoice-search-input">
                            <?php if (!empty($works)): ?>
                                <?php foreach ($works as $work): ?>

                                    <div class="Gvoice-option-row work-option-row" data-search="<?= strtolower(
                                                                                                    $work['service_name'] . ' ' .
                                                                                                        $work['sac_code'] . ' ' .
                                                                                                        $work['frequency']
                                                                                                ); ?>">
                                        <input type="checkbox" name="work_ids[]" value="<?= $work['id']; ?>" />

                                        <div class="Gvoice-option-text">
                                            <?= esc($work['service_name']); ?>
                                            (<?= esc($work['sac_code']); ?>)
                                        </div>

                                        <div class="Gvoice-option-status">
                                            Allocated
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No works found</p>
                            <?php endif; ?>

                        </div>


                        <!-- Choose company section -->
                        <div class="Gvoice-section-title">Choose Company For Invoice</div>

                        <div class="Gvoice-box">
                            <input type="text" id="companySearch" placeholder="Search company..."
                                class="Gvoice-search-input">
                            <?php if (!empty($companies)): ?>
                                <?php foreach ($companies as $company): ?>

                                    <div class="Gvoice-option-row"
                                        data-search="<?= strtolower($company['name'] . ' ' . $company['type_of_company']); ?>">

                                        <input type="radio" name="company_id" value="<?= $company['id']; ?>"
                                            data-state="<?= esc($company['gst_state']); ?>" />

                                        <div class="Gvoice-option-text">
                                            <?= esc($company['name']); ?>
                                            [<?= esc($company['type_of_company']); ?>]
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No companies found</p>
                            <?php endif; ?>


                        </div>


                        <div class="Gvoice-section-title">Choose tax For Invoice</div>
                        <div class="Gvoice-box">
                            <div class="Gvoice-option-row">
                                <input type="radio" name="tax" value="cgst_sgst">
                                <div class="Gvoice-option-text">CGST &amp; SGST</div>
                            </div>

                            <div class="Gvoice-option-row">
                                <input type="radio" name="tax" value="igst">
                                <div class="Gvoice-option-text">IGST</div>
                            </div>
                        </div>
                        <div class="Gvoice-section-title">Add Expenses Recoverable</div>
                        <div>
                            <div class="Gvoice-box">
                                <div class="Gvoice-option-row">
                                    <input type="checkbox" name="expenses" value="true" />
                                    <label for="toggleExpenses">Include Expenses</label>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="Gvoice-actions">
                            <button class="Gvoice-btn Gvoice-btn-success">Proceed</button>
                            <button class="Gvoice-btn Gvoice-btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-------------------------------- Modal for show details Recipt Note------------------------------------->
<div class="modal fade" id="ReciptNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="currentInvoiceId">

            <div class="modal-body">
                <div class="reciptnote">
                    <div class="header">
                        Receipt Note List
                        <button class="add-btn" id="addReceiptBtn">
                            <i class="fa fa-plus"></i> Add New
                        </button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Receipt No</th>
                                <th>Date.</th>
                                <th>Mode Of Payment</th>
                                <th>Cheque Date</th>
                                <th>Cheque Number</th>
                                <th>Drawer Bank</th>
                                <th>Bill Amount</th>
                                <th>Tds Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="receiptTableBody">
                            <?php if (!empty($receipt)) : ?>
                                <?php foreach ($receipt as $rec) : ?>

                                    <tr>
                                        <td><?= esc($rec['id']) ?></td>
                                        <td><?= esc($rec['recipt_no']) ?></td>
                                        <td><?= esc($rec['date']) ?></td>
                                        <td><?= esc($rec['mode_of_payment']) ?></td>
                                        <td><?= esc($rec['cheque_date']) ?></td>
                                        <td><?= esc($rec['cheque_number']) ?></td>
                                        <td><?= esc($rec['drawen_bank']) ?></td>
                                        <td class="amount"><?= esc($rec['bill_amount']) ?></td>
                                        <td class="amount"><?= esc($rec['tds_amount']) ?></td>
                                        <td class="action">
                                            <i class="fa-solid fa-pen-to-square edit-btn" title="Edit"
                                                data-id="<?= $rec['id'] ?>" data-recipt_no="<?= esc($rec['recipt_no']) ?>"
                                                data-date="<?= esc($rec['date']) ?>"
                                                data-mode_of_payment="<?= esc($rec['mode_of_payment']) ?>"
                                                data-cheque_date="<?= esc($rec['cheque_date']) ?>"
                                                data-cheque_number="<?= esc($rec['cheque_number']) ?>"
                                                data-drawen_bank="<?= esc($rec['drawen_bank']) ?>"
                                                data-bill_amount="<?= esc($rec['bill_amount']) ?>"
                                                data-tds_amount="<?= esc($rec['tds_amount']) ?>"
                                                data-invoice-id="<?= esc($rec['invoice_id']) ?>">
                                            </i>
                                            <i class="fa-solid fa-trash delete-btn" title="Delete" data-id="<?= $rec['id'] ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="Minvoice-text-center">No invoices found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Button trigger modal -->

<!-------------------------------- Modal for Add Recipt Note------------------------------------->
<div class="modal fade" id="addreciptnote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="receiptForm">
                <div class="modal-body">
                    <input type="hidden" name="invoice_id" id="current_invoice_id">
                    <input type="hidden" name="receipt_id" id="receipt_id">
                    <input type="hidden" name="client_id" value="<?= esc($clients[0]['id']); ?>">
                    <div class="receiptnote-container ReciptNoteData">

                        <!-- Header -->
                        <div class="receiptnote-header top">
                            <div class="receiptnote-company-name company">
                                <h2 id="companyName"></h2>
                                <span id="companyType"></span>
                            </div>

                            <div class="receiptnote-address contact">
                                Address : <span id="companyAddress"></span><br />
                                Ph. No. : <span id="companyPhone"></span><br />
                                E-Mail : <span id="companyEmail"></span><br />
                            </div>
                        </div>
                        

                        <!-- Title -->
                        <div class="receiptnote-title title">Receipt Note</div>

                        <!-- Receipt Info -->
                        <table class="receiptnote-table section">
                            <tr>
                                <td class="receiptnote-label">PAN :</td>
                                <td id="clientPan"></td>

                                <td class="receiptnote-label">Receipt Note No. :</td>
                                <td>
                                    <input type="text" name="recipt_no" id="receiptNo" class="receiptnote-input" />
                                </td>
                            </tr>

                            <tr class="receiptnote-light highlight">
                                <td></td>
                                <td></td>

                                <td class="receiptnote-label">Date :</td>
                                <td>
                                    <input type="date" name="date" id="receiptDate" class="receiptnote-input" />
                                </td>
                            </tr>
                        </table>

                        <!-- Issued To -->
                        <table class="receiptnote-table section">
                            <tr class="receiptnote-light highlight">
                                <td colspan="4"><strong>Issued To,</strong></td>
                            </tr>

                            <tr>
                                <td class="receiptnote-label">Name :</td>
                                <td colspan="3" id="clientName"></td>
                            </tr>

                            <tr class="receiptnote-light highlight">
                                <td class="receiptnote-label">Address :</td>
                                <td colspan="3">
                                    <span id="clientAddress"></span>
                                </td>
                            </tr>

                            <tr>
                                <td class="receiptnote-label">Mode Of Payment :</td>
                                <td colspan="3">
                                    <select name="mode_of_payment" id="modeOfPayment" class="receiptnote-select">
                                        <option value="Cash">Cash</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="TDS">TDS</option>
                                    </select>
                                </td>
                            </tr>
                        </table>

                        <!-- Cheque Fields -->
                        <div id="chequeFields" style="display:none;" class="section">
                            <label>Cheque Date</label>
                            <input type="date" name="cheque_date" class="receiptnote-input">

                            <label>Cheque Number</label>
                            <input type="text" name="cheque_number" class="receiptnote-input"
                                placeholder="Cheque Number">

                            <label>Drawn Bank</label>
                            <input type="text" name="drawen_bank" class="receiptnote-input" placeholder="Drawn Bank">
                        </div>

                        <!-- Amount Text -->
                        <div id="paymentTextBlock" class="receiptnote-text section highlight text">
                            Received with thanks from M/s/Mr/Mrs/Ms 
                            <span id="clientName"></span> 
                            the sum of Rs.
                            
                            <input type="text" name="bill_amount" id="billAmount" class="receiptnote-inline-input" />
                            
                            /- Amount in Words <b>Zero Rupees</b> Against Cash after deduction of TDS Rs
                            
                            <input type="text" name="tds_amount" id="tdsAmount" class="receiptnote-inline-input" />
                            
                            /- Amount In Words <b>Zero Rupees</b> for professional Services Rendered /
                            Advance Against invoice Raised vide Bill No <span id="invoiceNo"></span> /
                            dated <span id="invoiceDate"></span>.
                        </div>
                        <div id="tdsOnlyBlock" style="display:none;">
                            TDS Amount:
                            <input type="text" name="tds_amount" id="tdsAmountOnly" class="receiptnote-inline-input" />
                        </div>
                        

                        <!-- Footer -->
                        <div class="receiptnote-footer footer">
                            For more Information reach us @ <b>www.ksaca.in</b>
                        </div>

                        <!-- Buttons -->
                        <div class="receiptnote-buttons buttons">
                            <button type="button" class="receiptnote-btn receiptnote-btn-submit btn btn-primary"
                                id="saveReceiptBtn">
                                Save Receipt
                            </button>
                            <button type="button" class="receiptnote-btn receiptnote-btn-preview"
                                id="previewReceiptBtn">
                                Preview
                            </button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-------------------------------- Modal for Preview Recipt Note------------------------------------->
<div class="modal fade" id="receiptPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Receipt Preview</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="receiptPreviewContent">
                <!-- Preview HTML will be injected here -->
            </div>

        </div>
    </div>
</div>
<!-------------------------------- Modal for submitrecipt------------------------------------->
<div class="modal fade" id="submitrecipt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="options-container">
                    <div class="options-header">Options</div>

                    <label class="pdf-label">Receipt PDF</label>

                    <div class="d-flex gap-2 mb-3">
                        <button class="btn btn-success flex-fill" id="printReceiptBtn">Print Receipt</button>
                        <button class="btn btn-success flex-fill" id="downloadPdfBtn">Receipt PDF Download</button>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">Save changes</button>
             </div> -->
        </div>
    </div>
</div>
<div class="Minvoice-wrapper">
    <!-- Header -->
    <div class="Minvoice-header">List Of Generated Invoice for <?= esc($clients[0]['legal_name']) ?></div>

    <!-- Top Buttons -->
    <div class="Minvoice-top-actions">
        <button id="printLedgerBtn"
            class="Minvoice-btn Minvoice-btn-primary"
            onclick="printLedger()">
            Print Ledger
        </button>
        <button type="button" class=" Minvoice-btn Minvoice-btn-primary" data-toggle="modal"
            data-target="#GenrateVoice"onclick="localStorage.setItem('activeMenu','partyledger')">
            Generate Invoice For Pending Work
        </button>
        <a href="<?= base_url('InvoiceManagment'); ?>" class="Minvoice-btn Minvoice-btn-primary">
            Back To Client Grid
        </a>
    </div>

    <!-- Filters -->

    <div class="Minvoice-filter-row">
        <div class="Minvoice-filter-group">
            <label for="Minvoice-company">Select Company</label>
            <select id="Minvoice-company" name="company_id">
                <option value="">Select Company</option>

                <?php foreach ($companies as $company): ?>
                    <option value="<?= $company['id']; ?>"
                        data-name="<?= esc($company['name']); ?>"
                        data-address="<?= esc($company['registered_office']); ?>"
                        data-phone="<?= esc($company['telephone']); ?>"
                        data-email="<?= esc($company['email']); ?>">

                        <?= esc($company['name']); ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="Minvoice-filter-group">
            <label for="Minvoice-fromDate">From:</label>
            <input type="date" id="Minvoice-fromDate" />
        </div>

        <div class="Minvoice-filter-group">
            <label for="Minvoice-toDate">To:</label>
            <input type="date" id="Minvoice-toDate" />
        </div>

        <div class="Minvoice-filter-buttons">
            <button class="Minvoice-btn Minvoice-btn-search">Search</button>
            <button class="Minvoice-btn Minvoice-btn-reset">Reset</button>
        </div>
    </div>

    <!-- Table -->
    <div class="Minvoice-table-wrapper" id="ledger-print-area">
        <div class="print-only">
            <h4></h4>
            <h4 style="text-align: center;text-transform: uppercase;font-weight: bold;" class="firm-name" id="ledger-company-name"></h4>
            <h5 style="margin-top: -10px;text-align: center;">
                <span id="ledger-company-address"></span><br>
                Ph No.:<span id="ledger-company-phone"></span>&nbsp;&nbsp;&nbsp;
                Email-Id: <span id="ledger-company-email"></span>
            </h5>
            <!-- <h4 id="ledger-date-range" style="text-align: center;">

            </h4> -->
            <strong>
                <p id="ledger-date-range" style="text-align: center;font-size:20px;"></p>
            </strong>

        </div>
        <div class="print-only">
            <h4>Ledger For <strong><?= esc($clients[0]['legal_name']) ?></strong></h4>
        </div>
        <table class="Minvoice-table">
            <div>

            </div>

            <thead>
                <tr>
                    <th style="width: 10%" class="print-widthinvoiceno">Invoice No</th>
                    <th style="width: 7%" class="print-widthinvoicedate">Invoice Date</th>
                    <th style="width: 12%" class="print-widtinvoicework">Works</th>
                    <!-- <th style="width: 12%" class="print-hide">Company</th> -->
                    <th style="width: 9%" class="print-widthinvoiceamount">Total Invoice Amount</th>
                    <th style="width: 7%" class="print-widtreciptdate">Receipt Date</th>
                    <th style="width: 8%" class="print-widtreciptno">Receipt No</th>
                    <th style="width: 8%" class="print-widtreciptamount">TDS Amount</th>
                    <th style="width: 8%" class="print-widtreceivedamount">Received Amount</th>
                    <th style="width: 8%" class="print-widtdebitcfreditnote">Debit/Credit Note</th>
                    <th style="width: 8%" class="print-widtrunningamount">Running Amount</th>
                    <th style="width: 17%" class="no-print">Action</th>

                </tr>
            </thead>
            <tbody>
                <!-- Opening balance row -->
                <tr class="Minvoice-opening-row">
                    <td class="Minvoice-opening-label">Opening Balance</td>
                    <td></td>
                    <td></td>
                   
                    <td>
                        <div class="input-group input-group-sm" style="width:130px;">

                            <input type="number"
                                step="0.01"
                                id="openingBalanceInput"
                                class="form-control"
                                value="<?= esc($client['opening_balance'] ?? 0) ?>">

                            <button type="button"
                                id="saveOpeningBalanceBtn"
                                class="btn btn-primary">
                                Save
                            </button>

                        </div>
                    </td>
                     <td class="print-hide"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="print-hide"></td>
                </tr>

                <?php if (!empty($invoices)) : ?>
                    <?php
                    $runningBalance = (float) ($client['opening_balance'] ?? 0);
                    $isFirstRow = true;
                    ?>


                    <?php foreach ($invoices as $row) : ?>

                        <?php

$invoice = (float) ($row['total_invoice_amount'] ?? 0);
                        // $tds     = $row['tds_amount'] ?? 0;
                        $totalTds = 0.0;

                        foreach ($receipt as $r) {
                            if ($r['invoice_id'] == $row['id']) {
                                $totalTds += (float) ($r['tds_amount'] ?? 0);
                            }
                        }

                        
                        $totalReceivedAmount = 0.0;
                        foreach ($receipt as $r) {
                            if ($r['invoice_id'] == $row['id']) {
                                $totalReceivedAmount += (float) ($r['bill_amount'] ?? 0);
                            }
                        }

                         if ($isFirstRow) {
                            $runningBalance += ($invoice - ($totalTds+$totalReceivedAmount));
                            $isFirstRow = false; // next rows won't enter here
                        } else {
                            $runningBalance += ($invoice - ($totalTds+$totalReceivedAmount));

                        }
                      
                        ?>
                        <tr class="invoice-row" data-company-id="<?= $row['company_id'] ?>"
                            data-date="<?= $row['invoice_date'] ?>">
                            <td><?= esc($row['invoice_no']) ?></td>
                            <td><?= date('d-m-Y', strtotime($row['invoice_date'])) ?></td>
                            <td class="Minvoice-works-text">
                                <?= esc($row['service_names']) ?>
                            </td>
                            <!-- <td class="print-hide"><?= esc($row['company_name']) ?></td> -->
                            <td class="invoice-amount">
                                <?= number_format($row['total_invoice_amount'], 2) ?>
                            </td>
                            <td>
                                <?php
                                $receiptNos = [];

                                foreach ($receipt as $rec) {
                                    if ($rec['invoice_id'] == $row['id']) {
                                        $receiptNos[] = $rec['date'];
                                    }
                                }

                                echo !empty($receiptNos)
                                    ? implode('<br>', $receiptNos)
                                    : '-';
                                ?>
                            </td>
                            <td>
                                
                                <?php
                                $receiptNos = [];

                                foreach ($receipt as $rec) {
                                    if ($rec['invoice_id'] == $row['id']) {
                                        $receiptNos[] = $rec['recipt_no'];
                                    }
                                }

                                echo !empty($receiptNos)
                                    ? implode('<br>', $receiptNos)
                                    : '-';
                                ?>
                            </td>
                            <td><?php
foreach ($receipt as $rec) {
    if ($rec['invoice_id'] == $row['id']) {

        $tds = (float) ($rec['tds_amount'] ?? 0);

        echo '<div class="receipt-amount">' .
            ($tds > 0 ? number_format($tds, 2) : '-') .
            '</div>';
    }
}
?></td>
                            <td><?php
foreach ($receipt as $rec) {
    if ($rec['invoice_id'] == $row['id']) {

        $amount = (float) ($rec['bill_amount'] ?? 0);

        echo '<div class="received-amount">' .
            ($amount > 0 ? number_format($amount, 2) : '-') .
            '</div>';
    }
}
?></td>
                                <td></td>
                            <td class="running-amount"><strong><?= number_format($runningBalance, 2) ?></strong></td>
                            
                            <td class="no-print">
                                <!-- Edit -->
                                <a href="<?= site_url('invoice/edit/' . $row['id']) ?>" class="Minvoice-icon-btn edit"
                                    title="Edit Invoice">
                                    ✏️
                                </a>

                                <!-- Delete -->
                                <button type="button" style="border: none;" class="Minvoice-icon-btn delete" title="Delete Invoice"
                                    onclick="deleteInvoice(<?= $row['id'] ?>)">
                                    🗑️
                                </button>

                                <!-- Export Excel -->
                                <a href="#" class="Minvoice-icon-btn export open-receipt" data-toggle="modal"
                                    data-target="#ReciptNote" data-id="<?= $row['id'] ?>"title="Recipt Note">
                                    📥
                                </a>
                                <!-- ✅ NEW Download Button -->
                                <a href="<?= site_url('invoice/pdf/' . $row['id']) ?>"
                                    target="_blank"
                                    class="Minvoice-icon-btn download"
                                    title="Download Invoice">
                                    ⬇️
                                </a>
                                <!-- Print & Preview -->
                                <button type="button" class="Minvoice-print-btn" onclick="printInvoice(<?= $row['id'] ?>)"
                                    style="padding:2px;border-radius: 10px;border: 2px solid #f1c40f;"title="Print & Preview">
                                    Print &amp; Preview
                                </button>

                            </td>
                            <!-- <td></td> -->
                        </tr>
                        
                    <?php endforeach; ?>
                
    <?php foreach ($companyReceipt as $company): ?>
  <?php
        $tds      = (float)($company['tds_amount'] ?? 0);
        $received = (float)($company['bill_amount'] ?? 0);

        $receiptAmount = $tds + $received;

        // Receipt reduces outstanding balance
        $runningBalance -= $receiptAmount;
    ?>
                        
        <tr>

            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>

            <!-- Receipt Date -->
            <td>
                <?= date('d-m-Y', strtotime($company['date'])) ?>
            </td>

            <!-- Receipt No -->
            <td>
                <?= esc($company['recipt_no'] ?? '-') ?>
            </td>

            <!-- TDS -->
            <td><?= ((float)($company['tds_amount'] ?? 0) > 0)
    ? number_format($company['tds_amount'], 2)
    : '-' ?></td>

            <!-- Received -->
            <td><?= ((float)($company['bill_amount'] ?? 0) > 0)
    ? number_format($company['bill_amount'], 2)
    : '-' ?></td>

            <!-- Debit/Credit Amount -->
            <td>
            
            </td>

            <!-- Running Amount -->
            <td><strong><?= number_format($runningBalance, 2) ?></strong></td>

            <!-- Action -->
            <td></td>

        </tr>

<?php endforeach; ?>

    <?php foreach ($debit as $d): ?>

        <?php
    $amount = (float)$d['total_amount'];

    if ($d['note_type'] === 'debit') {
        $runningBalance += $amount;      // Debit Note increases balance
    } elseif ($d['note_type'] === 'credit') {
        $runningBalance -= $amount;      // Credit Note decreases balance
    }
?>
                        
        <tr class="debit-credit-row"
    data-type="<?= $d['note_type'] ?>"
    data-date="<?= $d['date'] ?>">

            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>

            <!-- Receipt Date -->
            <td>
                <?= date('d-m-Y', strtotime($d['date'])) ?>
            </td>

            <!-- Receipt No -->
            <td>
                <?php if ($d['note_type'] === 'debit'): ?>
        <?= esc($d['debit_no'] ?? '-') ?>
    <?php elseif ($d['note_type'] === 'credit'): ?>
        <?= esc($d['credit_no'] ?? '-') ?>
    <?php else: ?>
        -
    <?php endif; ?>
            </td>

            <!-- TDS -->
            <td>-</td>

            <!-- Received -->
            <td>-</td>

            <!-- Debit/Credit Amount -->
           <td class="debit-credit-amount">
    <?= ((float)($d['total_amount'] ?? 0) > 0)
        ? number_format($d['total_amount'], 2)
        : '-' ?>
</td>

            <!-- Running Amount -->
                <td class ="company-running-amount">
                    <strong><?= number_format($runningBalance, 2) ?></strong>
                </td>
            <!-- Action -->
            <td></td>

        </tr>

<?php endforeach; ?>

                    
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="Minvoice-text-center">No invoices found</td>
                    </tr>
                <?php endif; ?>
                <?php

                    $debitTotal = array_sum(array_map(function ($row) {

                        return (isset($row['note_type']) && $row['note_type'] === 'debit')
                            ? (float) str_replace(',', '', $row['total_amount'])
                            : 0;

                    }, $debit));


                    $creditTotal = array_sum(array_map(function ($row) {

                        return (isset($row['note_type']) && $row['note_type'] === 'credit')
                            ? (float) str_replace(',', '', $row['total_amount'])
                            : 0;

                    }, $debit));

                    ?>
                <?php
                $totalInvoice = array_sum(array_column($invoices, 'total_invoice_amount'));
               $totalReceived = array_sum(array_map(function ($r) {
                    return (float) str_replace(',', '', $r['bill_amount']);
                }, $receipt));

                $totalTds = array_sum(array_map(function ($r) {
                    return (float) str_replace(',', '', $r['tds_amount']);
                }, $receipt));
                // print_r($totalTds);exit;
                $totalNoteAmount = $debitTotal + $creditTotal;
                $openingBalance = $client['opening_balance'] ?? 0;
                // print_r($totalNoteAmount);exit;
                $closingBalance = $totalInvoice - ($totalReceived + $totalTds+$creditTotal) + $debitTotal+ $openingBalance;
                
                ?>

                <!-- Total row -->
                <tr class="Minvoice-total-row">
                    <td></td>
                    <td></td>
                    <!-- <td class="print-hide"></td> -->
                    <td>
                        <p style="font-size: 12px;font-weight:bold">Total Invoice Amount</p>
                    </td>
                    <td id="totalInvoiceAmount">
                        <?= number_format(
                            floatval($client['opening_balance'] ?? 0)
                            + array_sum(array_map('floatval', array_column($invoices, 'total_invoice_amount'))),
                            2
                        ) ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td><?= number_format($totalTds, 2) ?></td>
                    <td id="totalReceiptAmount"><?= number_format($totalReceived, 2) ?></td>
                   
                    <td><?php echo number_format($totalNoteAmount, 2); ?></td>
                    <td class="Minvoice-text-right print-hide">Closing Balance</td>
                    <td class="Minvoice-text-right print-hide" id="closingBalance"><?= number_format($closingBalance, 2) ?></td>
                </tr>

            </tbody>

        </table>
        <div class="Minvoice-text-right print-only" style="font-weight:bold; margin-top:10px;">
            <h2 id="closingBalance"> <strong>Closing Balance: <?= number_format($closingBalance , 2) ?></strong></h2>
        </div>
        <br><br>
    </div>

    <!-- Pagination -->
    <div class="Minvoice-pagination">
        <button>&lt;&lt;</button>
        <button class="Minvoice-active">1</button>
        <button>&gt;&gt;</button>
    </div>
</div>

<script>
    localStorage.setItem('activeMenu', 'partyledger');
    function deleteInvoice(id) {
        if (!confirm('Are you sure you want to delete this invoice?')) return;

        fetch(`<?= site_url('invoice/delete') ?>/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Invoice deleted');
                    location.reload();
                } else {
                    alert('Failed to delete');
                }
            });
    }

   function printInvoice(id) {
    window.location.href = `<?= site_url('invoice/print') ?>/${id}`;
}

    function printLedger() {
        const printContents = document.getElementById('ledger-print-area').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = `
        <html>
        <head>
            <title>Invoice Ledger</title>
           <style>
    body { font-family: Cambria, sans-serif; }

    table { width: 100%; border-collapse: collapse; }

    th, td { border: 1px solid #000; padding: 6px; }

    .Minvoice-text-right { text-align: right; }

  

    @media print {
     

        .print-only {
            display: block !important;
        }
        .print-hide {
            display: none !important;
        }
            .print-widthinvoiceno
                {
                    width: 16% !important;
                }
            .print-widthinvoicedate
                {
                     width: 10% !important;
                }

            .print-widthinvoicework
               {
                  width:18% !important;
               }
             .print-widthinvoiceamount
              {
                width: 10% !important;
              }
         .print-widtreciptdate
            {
             width: 10% !important;
            }
        .print-widtreciptno
            {
             width: 16% !important;
            }
        .print-widtreciptamount
             { 
                width: 10% !important;
            }
                .print-widtreceivedamount
                 {
                    width: 10% !important;
                 }
                    .print-widtdebitcfreditnote
                     {
                        width: 10% !important;
                     }
        .print-widtrunningamount
                 
        {
              width: 10% !important;
        }
       
            
        .no-print {
            display: none !important;
        }

        body { 
            margin: 0;
            padding: 0;
        }

        table { 
            width: 100% !important; 
            border-collapse: collapse; 
            border: 2px solid #000;
        }

        th, td { 
            border: 1px solid #000;  
            padding: 6px; 
        }
    }
</style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `;

        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

    $(document).on('click', '.open-receipt', function() {
        let invoiceId = $(this).data('id');
        $('#currentInvoiceId').val(invoiceId);
    });
    $('#addReceiptBtn').on('click', function() {
        let invoiceId = $('#currentInvoiceId').val();
        $('#ReciptNote').css('display', 'none');
        $('#addreciptnote').modal('show');

        $('#currentInvoiceId').val(invoiceId);
        loadReceiptData(invoiceId);
    });


    function loadReceiptData(invoiceId) {
        $.ajax({
            url: "<?= site_url('invoice/receipt') ?>" + "/" + invoiceId,
            type: "GET",
            data: {
                invoice_id: invoiceId
            },
            dataType: "json",
            success: function(res) {

                // Company
                $('#companyName').text(res.company.name);
                $('#companyType').text(res.company.type_of_company);
                $('#companyAddress').html(res.company.registered_office);
                $('#companyPhone').text(res.company.telephone);
                $('#companyEmail').text(res.company.email);

                // Client
                $('#clientName').text(res.client.legal_name);
                $('#clientAddress').html(res.client.registered_office);
                $('#clientPan').text(res.client.pan);

                // Invoice
                // $('#receiptNo').val(res.invoice.invoice_no);
                $('#receiptDate').val(res.invoice.invoice_date);
                $('#billAmount').val(res.invoice.total_invoice_amount);
                $('#current_invoice_id').val(res.invoice.id);

            }
        });
    }
    $(document).on('click', '.close', function() {
        $('#addreciptnote').modal('hide');
        $('#submitrecipt').modal('hide');
        location.reload();
    });
    $(document).ready(function() {
        // Listen for changes in the dropdown
        $('#modeOfPayment').on('change', function() {
            if ($(this).val() === 'Cheque') {
                $('#chequeFields').slideDown(); // show fields with animation
            } else {
                $('#chequeFields').slideUp(); // hide fields if not Cheque
            }
        });

        // Optional: hide cheque fields on page load if "Cash" is selected
        if ($('#modeOfPayment').val() !== 'Cheque') {
            $('#chequeFields').hide();
        }
    });


   document.getElementById("saveReceiptBtn").addEventListener("click", async function () {

    const receiptId = document.getElementById("receipt_id").value;
    const form = document.getElementById("receiptForm");
    const formData = new FormData(form);

    const mode = document.getElementById('modeOfPayment').value;

    // =========================
    // FIX: FORCE TDS LOGIC
    // =========================
    if (mode === 'TDS') {
        formData.set('bill_amount', 0);
    }

    try {

        let url = receiptId ? "updateReceipt" : "saveReceipt";

        const response = await fetch(url, {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        if (!data.success) {
            alert(receiptId ? "Update failed" : "Save failed");
            return;
        }

        // =========================
        // SUCCESS HANDLING
        // =========================
        const newId = data.receipt_id || receiptId;

        if (!receiptId) {
            document.getElementById("receipt_id").value = newId;
            alert("Receipt added successfully");
        } else {
            alert("Receipt updated successfully");
        }

        // store id for modal
        $('#submitrecipt')
            .data('receipt-id', newId)
            .attr('data-receipt-id', newId)
            .modal('show');

    } catch (error) {
        console.error(error);
        alert("Something went wrong");
    }
});


    // Edit button click
    document.addEventListener("click", function (e) {
    if (e.target.classList.contains("edit-btn")) {

        const btn = e.target;

        document.getElementById("receipt_id").value = btn.dataset.id;
        document.getElementById("receiptNo").value = btn.dataset.recipt_no;
        document.getElementById("receiptDate").value = btn.dataset.date;

        document.getElementById("billAmount").value = btn.dataset.bill_amount;
        document.getElementById("tdsAmountOnly").value = btn.dataset.tds_amount;

        const modeOfPayment = document.getElementById("modeOfPayment");
        modeOfPayment.value = btn.dataset.mode_of_payment;

        // 👇 IMPORTANT: trigger UI update
        modeOfPayment.dispatchEvent(new Event("change"));

        const chequeFields = document.getElementById("chequeFields");

        if (btn.dataset.mode_of_payment === "Cheque") {
            chequeFields.style.display = "block";
            chequeFields.querySelector("input[name='cheque_date']").value = btn.dataset.cheque_date;
            chequeFields.querySelector("input[name='cheque_number']").value = btn.dataset.cheque_number;
            chequeFields.querySelector("input[name='drawen_bank']").value = btn.dataset.drawen_bank;
        } else {
            chequeFields.style.display = "none";
        }

        // load invoice/company data
        fetch(`getInvoiceDetails/${btn.dataset.invoiceId}`)
             .then(res => res.json())
                .then(data => {
                    document.getElementById("companyName").textContent = data.company_name;
                    document.getElementById("companyType").textContent = data.company_type;
                    document.getElementById("companyAddress").textContent = data.company_address;
                    document.getElementById("companyPhone").textContent = data.company_phone;
                    document.getElementById("companyEmail").textContent = data.company_email;
                    document.getElementById("clientName").textContent = data.client_name;
                    document.getElementById("clientAddress").textContent = data.client_address;
                    document.getElementById("clientPan").textContent = data.client_pan;


                })                .catch(err => console.error("Error fetching company data:", err));

        new bootstrap.Modal(document.getElementById('addreciptnote')).show();
    }
});
    // Delete button click
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("delete-btn")) {
            const id = e.target.dataset.id;

            if (confirm("Are you sure you want to delete this receipt?")) {
                fetch(`deleteReceipt/${id}`, {
                        method: "POST",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            e.target.closest("tr").remove();
                            alert("Receipt deleted successfully");
                        } else {
                            alert("Failed to delete receipt");
                        }
                    })
                    .catch(err => console.error(err));
            }
        }
    });

    document.getElementById("previewReceiptBtn").addEventListener("click", function() {

        const receiptNo = document.getElementById("receiptNo").value;
        const receiptDate = document.getElementById("receiptDate").value;
        const mode = document.getElementById("modeOfPayment").value;
        const billAmount = document.getElementById("billAmount").value;
        const tdsAmount = document.getElementById("tdsAmount").value;

        const companyName = document.getElementById("companyName").innerText;
        const companyAddress = document.getElementById("companyAddress").innerText;
        const companyPhone = document.getElementById("companyPhone").innerText;
        const companyEmail = document.getElementById("companyEmail").innerText;

        const previewHTML = `
<div class="receipt-wrapper">

    <div class="receipt-header">
        <div class="company-left">
            <h2>${companyName}</h2>
            <span>CONSULTANCY SERVICES</span>
        </div>
        <div class="company-right">
            <div>${companyAddress}</div>
            <div>Ph: ${companyPhone}</div>
            <div>Email: ${companyEmail}</div>
        </div>
    </div>

    <div class="receipt-title">Receipt Note</div>

    <div class="receipt-body">

        <div class="receipt-row">
            <div class="label">Receipt No :</div>
            <div class="value">${receiptNo}</div>
            <div class="label">Date :</div>
            <div class="value">${receiptDate}</div>
        </div>

        <div class="receipt-row light">
            <div class="label">Mode Of Payment :</div>
            <div class="value">${mode}</div>
        </div>

        <div class="receipt-row">
            <div class="label">Bill Amount :</div>
            <div class="value">₹ ${billAmount}</div>
        </div>

        <div class="receipt-row">
            <div class="label">TDS Amount :</div>
            <div class="value">₹ ${tdsAmount}</div>
        </div>

    </div>

    <div class="receipt-footer">
        For more information reach us @ <b>www.ksaca.in</b>
    </div>

</div>
`;


        document.getElementById("receiptPreviewContent").innerHTML = previewHTML;

        new bootstrap.Modal(
            document.getElementById("receiptPreviewModal")
        ).show();
    });
    document.getElementById("printReceiptBtn").addEventListener("click", function() {

        const receiptId = $('#submitrecipt').data('receipt-id');

        if (!receiptId) {
            alert("Receipt ID not found");
            return;
        }

        window.open(`printReceipt/${receiptId}`);
    });
    document.getElementById("downloadPdfBtn").addEventListener("click", function() {

        const receiptId = $('#submitrecipt').data('receipt-id');

        if (!receiptId) {
            alert("Receipt ID not found");
            return;
        }

        window.open(`receiptPdf/${receiptId}`, '_blank');
    });
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.querySelector('#GenrateVoice form');

        form.addEventListener('submit', function(e) {

            // 1️⃣ Check works selected
            const worksChecked = document.querySelectorAll(
                'input[name="work_ids[]"]:checked'
            ).length;

            // 2️⃣ Check company selected
            const companySelected = document.querySelector(
                'input[name="company_id"]:checked'
            );

            if (worksChecked === 0) {
                e.preventDefault();
                alert('Please select at least one Work for Invoice');
                return false;
            }

            if (!companySelected) {
                e.preventDefault();
                alert('Please select a Company for Invoice');
                return false;
            }


        });

    });

    document.addEventListener('DOMContentLoaded', function() {
        const clientState = document.getElementById('client_state').value;

        // Get tax radio buttons
        const cgstSgst = document.querySelector('input[name="tax"][value="cgst_sgst"]');
        const igst = document.querySelector('input[name="tax"][value="igst"]');

        // Listen for company selection
        document.querySelectorAll('input[name="company_id"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const companyState = this.getAttribute('data-state');

                if (companyState === clientState) {
                    cgstSgst.checked = true; // Same state → CGST & SGST
                } else {
                    igst.checked = true; // Different state → IGST
                }
            });
        });
    });
    
    document.querySelector('.Minvoice-btn-search').addEventListener('click', function() {

        document.getElementById('printLedgerBtn').style.display = 'inline-block';

        const companySelect = document.getElementById('Minvoice-company');
        const companyId = companySelect.value;
        const fromInput = document.getElementById('Minvoice-fromDate').value;
        const toInput = document.getElementById('Minvoice-toDate').value;

        const rows = document.querySelectorAll('.invoice-row');

        let visibleDates = [];

        // -------- GET SELECTED COMPANY DETAILS --------
        const selectedOption = companySelect.options[companySelect.selectedIndex];

        if (selectedOption && selectedOption.value !== "") {

            document.getElementById('ledger-company-name').innerText =
                selectedOption.dataset.name || '';

            document.getElementById('ledger-company-address').innerText =
                selectedOption.dataset.address || '';

            document.getElementById('ledger-company-phone').innerText =
                selectedOption.dataset.phone || '';

            document.getElementById('ledger-company-email').innerText =
                selectedOption.dataset.email || '';
        }

        rows.forEach(row => {

            const rowCompany = row.dataset.companyId;
            const rowDate = row.dataset.date;

            let show = true;

            // Company Filter
            if (companyId && rowCompany !== companyId) {
                show = false;
            }

            // Date From Filter
            if (fromInput && new Date(rowDate) < new Date(fromInput)) {
                show = false;
            }

            // Date To Filter
            if (toInput && new Date(rowDate) > new Date(toInput)) {
                show = false;
            }

            row.style.display = show ? '' : 'none';

            if (show) {
                visibleDates.push(new Date(rowDate));
            }
        });

        // -------- DATE FORMAT OPTIONS --------
        const options = {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        };

        let formattedFrom = '';
        let formattedTo = '';

        // -------- USE INPUT DATES IF PROVIDED --------
        if (fromInput) {
            formattedFrom = new Date(fromInput).toLocaleDateString('en-GB', options);
        }

        if (toInput) {
            formattedTo = new Date(toInput).toLocaleDateString('en-GB', options);
        }

        // -------- IF NO INPUT DATE, USE ROW DATES --------
        if (!fromInput && !toInput && visibleDates.length > 0) {

            visibleDates.sort((a, b) => a - b);

            formattedFrom = visibleDates[0].toLocaleDateString('en-GB', options);
            formattedTo = visibleDates[visibleDates.length - 1].toLocaleDateString('en-GB', options);
        }

        // -------- PRINT DATE RANGE --------
        if (formattedFrom && formattedTo) {

            document.getElementById('ledger-date-range').innerHTML =
                `${formattedFrom} TO ${formattedTo}`;

        } else if (formattedFrom) {

            document.getElementById('ledger-date-range').innerHTML =
                `From ${formattedFrom}`;

        } else if (formattedTo) {

            document.getElementById('ledger-date-range').innerHTML =
                `Up to ${formattedTo}`;

        } else {

            document.getElementById('ledger-date-range').innerHTML =
                `Ledger (No records found)`;
        }

        let totalInvoice = 0;
        let totalReceipt = 0;

        rows.forEach(row => {

            if (row.style.display !== 'none') {

                const invoice = parseFloat(
                    row.querySelector('.invoice-amount').innerText.replace(/,/g, '')
                ) || 0;

                  let receipt = 0;
        row.querySelectorAll('.receipt-amount').forEach(el => {
            receipt += parseFloat(el.innerText.replace(/,/g, '')) || 0;
        });

                totalInvoice += invoice;
                totalReceipt += receipt;

            }
        });

        const openingBalance = parseFloat(
            document.getElementById('openingBalanceInput').dataset.opening
        ) || 0;

        const closingBalance = openingBalance + totalInvoice - totalReceipt;

        document.getElementById('totalInvoiceAmount').innerText =
            (openingBalance + totalInvoice).toFixed(2);

        // document.getElementById('totalReceiptAmount').innerText =
        //     totalReceipt.toFixed(2);

        document.getElementById('closingBalance').innerText =
            closingBalance.toFixed(2);

        let runningBalance = parseFloat(
            document.getElementById('openingBalanceInput').dataset.opening
        ) || 0;

       document.querySelectorAll('.invoice-row').forEach(row => {

    if (row.style.display !== 'none') {

        const invoice = parseFloat(
            row.querySelector('.invoice-amount').innerText.replace(/,/g, '')
        ) || 0;

        let totalDeduction = 0;
        row.querySelectorAll('.receipt-amount').forEach(el => {
            totalDeduction += parseFloat(el.innerText.replace(/,/g, '')) || 0;
        });

        row.querySelectorAll('.received-amount').forEach(el => {
            totalDeduction += parseFloat(el.innerText.replace(/,/g, '')) || 0;
        });

        runningBalance += invoice - totalDeduction;

        row.querySelector('.running-amount strong').innerText =
            runningBalance.toFixed(2);
    }
});

    });

    function formatDate(date) {
    const d = new Date(date);

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();

    return `${day}-${month}-${year}`;
}

    document.addEventListener("DOMContentLoaded", function() {

        const rows = document.querySelectorAll('.invoice-row');
        let allDates = [];

        rows.forEach(row => {
            const rowDate = row.dataset.date;
            if (rowDate) {
                allDates.push(new Date(rowDate));
            }
        });

        if (allDates.length > 0) {

            allDates.sort((a, b) => a - b);

            const firstDate = allDates[0];
            const lastDate = allDates[allDates.length - 1];

            const formattedFrom = formatDate(firstDate);
const formattedTo = formatDate(lastDate);

            document.getElementById('ledger-date-range').innerHTML =
                `${formattedFrom} TO ${formattedTo}`;
        }

    });

    document.querySelector('.Minvoice-btn-reset').addEventListener('click', function() {

        document.getElementById('Minvoice-company').value = '';
        document.getElementById('Minvoice-fromDate').value = '';
        document.getElementById('Minvoice-toDate').value = '';

        document.querySelectorAll('.invoice-row').forEach(row => {
            row.style.display = '';
        });
    });

    //seaching in company select box
    document.getElementById('companySearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.Gvoice-option-row');

        for (let row of rows) {
            const text = row.getAttribute('data-search') || '';
            row.style.display = text.includes(searchValue) ? 'flex' : 'none';
        }
    });

    //seaching in works select box
    document.getElementById('workSearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.work-option-row');

        for (let row of rows) {
            const text = row.getAttribute('data-search') || '';
            row.style.display = text.includes(searchValue) ? 'flex' : 'none';
        }
    });

    // ===============================
    // 🔁 MAIN RECALCULATION FUNCTION
    // ===============================
function recalculateLedger() {

    const rows = document.querySelectorAll('.invoice-row, .debit-credit-row');

    let openingBalance = parseFloat(
        document.getElementById('openingBalanceInput').value
    ) || 0;

    let runningBalance = openingBalance;

    let totalInvoice = 0;
    let totalDeduction = 0;

    rows.forEach(row => {

        if (row.style.display === 'none') return;

        // =========================
        // INVOICE ROW
        // =========================
        if (row.classList.contains('invoice-row')) {

            const invoice = parseFloat(
                row.querySelector('.invoice-amount')?.innerText.replace(/,/g, '')
            ) || 0;

            let rowDeduction = 0;

            // TDS
            row.querySelectorAll('.receipt-amount').forEach(el => {
                rowDeduction += parseFloat(el.innerText.replace(/,/g, '')) || 0;
            });

            // RECEIVED
            row.querySelectorAll('.received-amount').forEach(el => {
                rowDeduction += parseFloat(el.innerText.replace(/,/g, '')) || 0;
            });

            totalInvoice += invoice;
            totalDeduction += rowDeduction;

            runningBalance += (invoice - rowDeduction);

            const balanceCell = row.querySelector('.running-amount strong');
            if (balanceCell) {
                balanceCell.innerText = runningBalance.toFixed(2);
            }
        }

        // =========================
        // DEBIT / CREDIT ROW
        // =========================
        else if (row.classList.contains('debit-credit-row')) {

            const amount = parseFloat(
                row.querySelector('.debit-credit-amount')?.innerText.replace(/,/g, '')
            ) || 0;

            const type = row.dataset.type;

            // IMPORTANT FIX: no totalDeduction misuse here
            if (type === 'debit') {
                runningBalance += amount;
            }

            if (type === 'credit') {
                runningBalance -= amount;
            }

            const balanceCell = row.querySelector('.running-amount strong');
            if (balanceCell) {
                balanceCell.innerText = runningBalance.toFixed(2);
            }
        }
    });

    // =========================
    // TOTALS UPDATE
    // =========================
    document.getElementById('totalInvoiceAmount').innerText =
        (openingBalance + totalInvoice).toFixed(2);

        const cells = document.querySelectorAll('.company-running-amount');

    const closingBalance = cells.length
        ? parseFloat(
            cells[cells.length - 1].innerText.replace(/,/g, '')
        ) || 0
        : 0;

    document.getElementById('closingBalance').innerText =
        closingBalance.toFixed(2);

}

    // ===============================
    // 🔄 AUTO UPDATE WHEN INPUT CHANGES
    // ===============================
    document.addEventListener('DOMContentLoaded', function() {

        const openingInput = document.getElementById('openingBalanceInput');

        if (openingInput) {
            openingInput.addEventListener('input', function() {
                recalculateLedger();
            });
        }

        // Initial calculation on page load
        recalculateLedger();
    });


    // ===============================
    // 🔍 MODIFY SEARCH BUTTON
    // ===============================
    document.querySelector('.Minvoice-btn-search').addEventListener('click', function() {

        document.getElementById('printLedgerBtn').style.display = 'inline-block';

        const companySelect = document.getElementById('Minvoice-company');
        const companyId = companySelect.value;
        const fromInput = document.getElementById('Minvoice-fromDate').value;
        const toInput = document.getElementById('Minvoice-toDate').value;

        const rows = document.querySelectorAll('.invoice-row');

        let visibleDates = [];

        const selectedOption = companySelect.options[companySelect.selectedIndex];

        if (selectedOption && selectedOption.value !== "") {

            document.getElementById('ledger-company-name').innerText =
                selectedOption.dataset.name || '';

            document.getElementById('ledger-company-address').innerText =
                selectedOption.dataset.address || '';

            document.getElementById('ledger-company-phone').innerText =
                selectedOption.dataset.phone || '';

            document.getElementById('ledger-company-email').innerText =
                selectedOption.dataset.email || '';
        }

        rows.forEach(row => {

            const rowCompany = row.dataset.companyId;
            const rowDate = row.dataset.date;

            let show = true;

            if (companyId && rowCompany !== companyId) {
                show = false;
            }

            if (fromInput && new Date(rowDate) < new Date(fromInput)) {
                show = false;
            }

            if (toInput && new Date(rowDate) > new Date(toInput)) {
                show = false;
            }

            row.style.display = show ? '' : 'none';

            if (show) {
                visibleDates.push(new Date(rowDate));
            }
        });

        // ===============================
        // DATE RANGE
        // ===============================
       let formattedFrom = fromInput ?
    formatDate(fromInput) :
    '';

let formattedTo = toInput ?
    formatDate(toInput) :
    '';

if (!fromInput && !toInput && visibleDates.length > 0) {

    visibleDates.sort((a, b) => a - b);

    formattedFrom = formatDate(visibleDates[0]);
    formattedTo = formatDate(visibleDates[visibleDates.length - 1]);
}

        if (formattedFrom && formattedTo) {
            document.getElementById('ledger-date-range').innerHTML =
                `${formattedFrom} TO ${formattedTo}`;
        }

        // ✅ IMPORTANT: Recalculate after filtering
        recalculateLedger();
    });


    // ===============================
    // 🔄 RESET BUTTON FIX
    // ===============================
    document.querySelector('.Minvoice-btn-reset').addEventListener('click', function() {

        document.getElementById('Minvoice-company').value = '';
        document.getElementById('Minvoice-fromDate').value = '';
        document.getElementById('Minvoice-toDate').value = '';

        document.querySelectorAll('.invoice-row').forEach(row => {
            row.style.display = '';
        });

        recalculateLedger();
    });
    // ===============================
    // 💾 SAVE OPENING BALANCE (AUTO)
    // ===============================
    document.getElementById('openingBalanceInput')
        .addEventListener('change', function() {

            const value = this.value;
            const clientId = <?= $clients[0]['id']; ?>;

            fetch("<?= site_url('client/updateOpeningBalance') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        client_id: clientId,
                        opening_balance: value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log("Opening balance saved");
                    } else {
                        alert("Failed to save opening balance");
                    }
                })
                .catch(err => console.error(err));
        });

    // ===============================
    // 💾 SAVE OPENING BALANCE (BUTTON)
    // ===============================
    document.getElementById('saveOpeningBalanceBtn')
        .addEventListener('click', function() {

            const openingBalance = document.getElementById('openingBalanceInput').value;
            const clientId = <?= $clients[0]['id']; ?>;

            if (openingBalance === '') {
                alert('Please enter opening balance');
                return;
            }

            fetch("<?= site_url('client/updateOpeningBalance') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        client_id: clientId,
                        opening_balance: openingBalance
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Opening balance saved successfully');
                        location.reload();
                    } else {
                        alert('Failed to save opening balance');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Something went wrong');
                });
        });
        
        const nextReceiptId = <?= $nextReceiptId ?>;

function getFinancialYear() {
    const today = new Date();
    let startYear, endYear;

    if (today.getMonth() >= 3) { // April onwards
        startYear = today.getFullYear() % 100;
        endYear = (today.getFullYear() + 1) % 100;
    } else {
        startYear = (today.getFullYear() - 1) % 100;
        endYear = today.getFullYear() % 100;
    }

    return `${startYear}${endYear}`;
}

function generateReceiptNo() {
    const mode = document.getElementById('modeOfPayment').value;
    const receiptNo = document.getElementById('receiptNo');

    let prefix = 'CH'; // Default Cash

    if (mode === 'Cheque') {
        prefix = 'CHQ';
    } else if (mode === 'TDS') {
        prefix = 'TDS';
    }

    const serial = String(nextReceiptId).padStart(2, '0');

    receiptNo.value = `${prefix}/${getFinancialYear()}/${serial}`;
}

document.getElementById('modeOfPayment')
    .addEventListener('change', generateReceiptNo);

// Generate on page load (Cash selected by default)
window.onload = generateReceiptNo;

function calculateTDS() {
     document.getElementById('tdsAmount').value = '';
}

document.getElementById('billAmount')
    .addEventListener('input', calculateTDS);

    $(document).on('click', '.open-receipt', function () {
    var invoiceId = $(this).data('id');

    $('#current_invoice_id').val(invoiceId);

});

$(document).on('click', '.open-receipt', function () {

    let invoiceId = $(this).data('id');

    $.ajax({
        url: "<?= site_url('invoice/getReceiptByInvoice') ?>/" + invoiceId,
        type: "GET",
        dataType: "json",
        success: function(data) {

            let html = '';

            $.each(data, function(index, rec) {
                html += `
                    <tr>
                        <td>${rec.id}</td>
                        <td>${rec.recipt_no}</td>
                        <td>${rec.date}</td>
                        <td>${rec.mode_of_payment}</td>
                        <td>${rec.cheque_date ?? ''}</td>
                        <td>${rec.cheque_number ?? ''}</td>
                        <td>${rec.drawen_bank ?? ''}</td>
                        <td>${rec.bill_amount}</td>
                        <td>${rec.tds_amount}</td>
                         <td class="action">

                <i class="fa-solid fa-pen-to-square edit-btn"
                    title="Edit"
                    data-id="${rec.id}"
                    data-recipt_no="${rec.recipt_no}"
                    data-date="${rec.date}"
                    data-mode_of_payment="${rec.mode_of_payment}"
                    data-cheque_date="${rec.cheque_date ?? ''}"
                    data-cheque_number="${rec.cheque_number ?? ''}"
                    data-drawen_bank="${rec.drawen_bank ?? ''}"
                    data-bill_amount="${rec.bill_amount}"
                    data-tds_amount="${rec.tds_amount}"
                    data-invoice-id="${rec.invoice_id}">
                </i>

                <i class="fa-solid fa-trash delete-btn"
                    title="Delete"
                    data-id="${rec.id}">
                </i>

            </td>
                    </tr>`;
            });

            $('#receiptTableBody').html(html);
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {

    const modeOfPayment = document.getElementById('modeOfPayment');
    const paymentTextBlock = document.getElementById('paymentTextBlock');
    const tdsOnlyBlock = document.getElementById('tdsOnlyBlock');
    const billAmount = document.getElementById('billAmount');

    function togglePaymentUI() {

        const mode = modeOfPayment.value;

        if (mode === 'TDS') {

            // Hide full receipt text
            if (paymentTextBlock) paymentTextBlock.style.display = 'none';

            // Show TDS only block
            if (tdsOnlyBlock) tdsOnlyBlock.style.display = 'block';

            // Force bill amount to zero + lock it
            if (billAmount) {
                billAmount.value = 0;
                billAmount.readOnly = true;
            }

        } else {

            // Show full receipt text
            if (paymentTextBlock) paymentTextBlock.style.display = 'block';

            // Hide TDS only block
            if (tdsOnlyBlock) tdsOnlyBlock.style.display = 'none';

            // Enable bill amount input
            if (billAmount) {
                billAmount.readOnly = false;
            }
        }
    }

    // run on change
    modeOfPayment.addEventListener('change', togglePaymentUI);

    // run on page load (important fix)
    togglePaymentUI();

});
        
</script>