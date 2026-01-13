 <!-------------------------------- Modal for genrate invoice------------------------------------->
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

                         <!-- Title -->
                         <div class="Gvoice-title">Choose Works And Company For Invoice</div>

                         <!-- Invoice type row -->
                         <div class="Gvoice-row">
                             <div class="Gvoice-label">
                                 Select Invoice Type: <span class="Gvoice-required">*</span>
                             </div>
                             <select class="Gvoice-select">
                                 <option>Automatic Invoice</option>
                                 <option>Manual Invoice</option>
                                 <!-- other options -->
                             </select>
                         </div>

                         <!-- Choose work section -->
                         <div class="Gvoice-section-title">Choose Work For Invoice</div>
                         <div class="Gvoice-box">

                             <?php if (!empty($works)): ?>
                             <?php foreach ($works as $work): ?>

                             <div class="Gvoice-option-row">
                                 <input type="checkbox" name="work_ids[]" value="<?= $work['id']; ?>" />

                                 <div class="Gvoice-option-text">
                                     <?= esc($work['service_name']); ?>
                                     (<?= esc($work['sac_code']); ?>)
                                     [<?= esc($work['frequency']); ?>]
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

                             <?php if (!empty($companies)): ?>
                             <?php foreach ($companies as $company): ?>

                             <div class="Gvoice-option-row">
                                 <input type="radio" name="company_id" value="<?= $company['id']; ?>" />

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
                                 <input type="radio" name="tax" value="cgst_sgst" checked>
                                 <div class="Gvoice-option-text">CGST &amp; SGST</div>
                             </div>

                             <div class="Gvoice-option-row">
                                 <input type="radio" name="tax" value="igst">
                                 <div class="Gvoice-option-text">IGST</div>
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

 <!-- Modal2 -->
 <div class="modal fade" id="ReciptNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="reciptnote">
                     <div class="header">
                         Receipt Note List
                         <button class="add-btn" data-toggle="modal" data-target="#addreciptnote"><i
                                 class="fa fa-plus"></i> Add New</button>
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

                         <tbody>
                             <tr>
                                 <td>1</td>
                                 <td>END/1718/2425/</td>
                                 <td>09/01/2026 12:00 AM</td>
                                 <td>cash</td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td class="amount">0.00</td>
                                 <td class="amount">0.00</td>
                                 <td class="action">
                                     <i class="fa-solid fa-pen-to-square" title="Edit"></i>
                                     <i class="fa-solid fa-trash" title="Delete"></i>
                                 </td>
                             </tr>

                             <tr>
                                 <td>2</td>
                                 <td>END/1718/2425/</td>
                                 <td>09/01/2026 12:00 AM</td>
                                 <td>cash</td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td class="amount">0.00</td>
                                 <td class="amount">0.00</td>
                                 <td class="action">
                                     <i class="fa-solid fa-pen-to-square" title="Edit"></i>
                                     <i class="fa-solid fa-trash" title="Delete"></i>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>

         </div>
     </div>
 </div>
 <!-- Button trigger modal -->

 <!-------------------------------- Modal for Add Recipt Note------------------------------------->
 <!-- Modal3 -->
 <div class="modal fade" id="addreciptnote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="receiptnote-container">
                     <!-- HEADER -->
                     <div class="receiptnote-header">
                         <div>
                             <div class="receiptnote-company-name">ENDLESS SOLUTIONS</div>
                             <div class="receiptnote-company-sub">CONSULTANCY SERVICES</div>
                         </div>
                         <div class="receiptnote-address">
                             Address : A 202, RG CITY CENTRE, D.B. GUPTA ROAD,<br />
                             PAHARGANJ, NEW DELHI - 110055<br />
                             PH. No. : 011-43613961, Fax No. : 011-43613961<br />
                             E-Mail : end.solu@gmail.com
                         </div>
                     </div>

                     <!-- TITLE -->
                     <div class="receiptnote-title">Receipt Note</div>

                     <!-- TABLE -->
                     <table class="receiptnote-table">
                         <tr>
                             <td class="receiptnote-label">PAN :</td>
                             <td></td>
                             <td class="receiptnote-label">Receipt Note No. :</td>
                             <td>
                                 <input class="receiptnote-input" value="END/1718/2425/" />
                             </td>
                         </tr>

                         <tr class="receiptnote-light">
                             <td></td>
                             <td></td>
                             <td class="receiptnote-label">Date :</td>
                             <td>
                                 <input class="receiptnote-input" value="09/01/2026" />
                             </td>
                         </tr>

                         <tr class="receiptnote-light">
                             <td colspan="4"><strong>Issued To,</strong></td>
                         </tr>

                         <tr>
                             <td class="receiptnote-label">Name :</td>
                             <td colspan="3">GS HEALTHCARE PRIVATE LIMITED.</td>
                         </tr>

                         <tr class="receiptnote-light">
                             <td class="receiptnote-label">Address :</td>
                             <td colspan="3">
                                 A-1/53 FIRST FLOOR, SAFDARJUNG ENCLAVE NEW DELHI South West Delhi DL
                                 110029 IN
                             </td>
                         </tr>

                         <tr class="receiptnote-light">
                             <td class="receiptnote-label">
                                 Mode Of Payment :<br />(Cheque/Cash)
                             </td>
                             <td colspan="3">
                                 <select class="receiptnote-select">
                                     <option>Cash</option>
                                     <option>Cheque</option>
                                 </select>
                             </td>
                         </tr>
                     </table>

                     <!-- TEXT -->
                     <div class="receiptnote-text">
                         Received with thanks from M/s/Mr/Mrs/Ms GS HEALTHCARE PRIVATE LIMITED
                         the sum of Rs.
                         <input class="receiptnote-inline-input" value="0.00" />
                         /- Amount in Words <strong>Zero Rupees</strong> Against Cash after
                         deduction of TDS Rs
                         <input class="receiptnote-inline-input" placeholder="TDS Amount" />
                         /- Amount In Words <strong>Zero Rupees</strong> for professional
                         Services Rendered/ Advance Against invoice Raised vide Bill No
                         END/1718/2425/ dated 09/01/2026
                     </div>

                     <!-- FOOTER -->
                     <div class="receiptnote-footer">
                         For more Information reach us @ www.ksaca.in
                     </div>

                     <!-- BUTTONS -->
                     <div class="receiptnote-buttons">
                         <button class="receiptnote-btn receiptnote-btn-submit" data-toggle="modal"
                             data-target="#submitrecipt">Submit</button>
                         <button class="receiptnote-btn receiptnote-btn-cancel">Cancel</button>
                         <button class="receiptnote-btn receiptnote-btn-preview">Preview</button>
                     </div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">Save changes</button>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal -->
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
                         <button class="btn btn-success flex-fill">Print Receipt</button>
                         <button class="btn btn-success flex-fill">Receipt PDF Download</button>
                     </div>

                     <button class="btn btn-secondary w-100 rounded-pill">Close</button>
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
         <button class="Minvoice-btn Minvoice-btn-primary" onclick="printLedger()">Print Ledger</button>
         <button type="button" class=" Minvoice-btn Minvoice-btn-primary" data-toggle="modal"
             data-target="#GenrateVoice">
             Generate Invoice For Pending Work
         </button>
         <button class="Minvoice-btn Minvoice-btn-primary">
             Back To Client Grid
         </button>
     </div>

     <!-- Filters -->
     <div class="Minvoice-filter-row">
         <div class="Minvoice-filter-group">
             <label for="Minvoice-company">Select Company</label>
             <select id="Minvoice-company" name="company_id">
                 <option value="">Select Company</option>

                 <?php foreach ($companies as $company): ?>
                 <option value="<?= $company['id']; ?>">
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
         <table class="Minvoice-table">
             <thead>
                 <tr>
                     <th style="width: 12%">Invoice No</th>
                     <th style="width: 10%">Invoice Date</th>
                     <th style="width: 10%">Works</th>
                     <th style="width: 21%">Company</th>
                     <th style="width: 12%">Total Invoice Amount</th>
                     <th style="width: 10%">Receipt Date</th>
                     <th style="width: 5%">Receipt No</th>
                     <th style="width: 32%">Action</th>
                 </tr>
             </thead>
             <tbody>
                 <!-- Opening balance row -->
                 <tr class="Minvoice-opening-row">
                     <td colspan="9" class="Minvoice-opening-label">Opening Balance</td>
                 </tr>

                 <?php if (!empty($invoices)) : ?>
                 <?php foreach ($invoices as $row) : ?>
                 <tr>
                     <td><?= esc($row['invoice_no']) ?></td>
                     <td><?= date('d-m-Y', strtotime($row['invoice_date'])) ?></td>
                     <td class="Minvoice-works-text">
                         <?= esc($row['service_description']) ?>
                     </td>
                     <td><?= esc($row['company_name']) ?></td>
                     <td>
                         <?= number_format($row['total_invoice_amount'], 2) ?>
                     </td>
                     <td>
                         <?= !empty($row['invoice_date']) 
                            ? date('d-m-Y', strtotime($row['invoice_date'])) 
                            : '-' ?>
                     </td>
                     <td><?= esc($row['id']) ?></td>

                     <td>
                         <!-- Edit -->
                         <a href="<?= site_url('invoice/edit/' . $row['id']) ?>" class="Minvoice-icon-btn edit"
                             title="Edit Invoice">
                             ✏️
                         </a>

                         <!-- Delete -->
                         <button type="button" class="Minvoice-icon-btn delete" title="Delete Invoice"
                             onclick="deleteInvoice(<?= $row['id'] ?>)">
                             🗑️
                         </button>

                         <!-- Export Excel -->
                         <button> <a href="<?= site_url('invoice/receipt/' . $row['id']) ?>"
                                 class="Minvoice-icon-btn export" title="Export Excel" data-toggle="modal"
                                 data-target="#ReciptNote">
                                 📥
                             </a></button>
                         <!-- Print & Preview -->
                         <button type="button" class="Minvoice-print-btn" onclick="printInvoice(<?= $row['id'] ?>)"
                             style="padding:2px;border-radius: 10px;border: 2px solid #f1c40f;">
                             Print &amp; Preview
                         </button>
                     </td>
                 </tr>
                 <?php endforeach; ?>
                 <?php else : ?>
                 <tr>
                     <td colspan="9" class="Minvoice-text-center">No invoices found</td>
                 </tr>
                 <?php endif; ?>

                 <!-- Total row -->
                 <tr class="Minvoice-total-row">
                     <td colspan="4" class="Minvoice-text-right">Total</td>
                     <td class="Minvoice-text-right Minvoice-amount-bold">
                         <?= number_format(array_sum(array_column($invoices, 'total_invoice_amount')), 2) ?>
                     </td>
                     <td colspan="2" class="Minvoice-closing-balance">Closing<br>Balance</td>
                     <td class="Minvoice-text-right Minvoice-amount-bold">
                         <?= number_format(array_sum(array_column($invoices, 'amount')), 2) ?>
                     </td>
                     <td></td>
                 </tr>
             </tbody>

         </table>
     </div>

     <!-- Pagination -->
     <div class="Minvoice-pagination">
         <button>&lt;&lt;</button>
         <button class="Minvoice-active">1</button>
         <button>&gt;&gt;</button>
     </div>
 </div>

 <script>
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
    window.open(`<?= site_url('invoice/print') ?>/${id}`, '_blank');
}

function printLedger() {
    const printContents = document.getElementById('ledger-print-area').innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
        <head>
            <title>Invoice Ledger</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #000; padding: 6px; }
                .Minvoice-text-right { text-align: right; }
                .no-print { display: none !important; }
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
 </script>