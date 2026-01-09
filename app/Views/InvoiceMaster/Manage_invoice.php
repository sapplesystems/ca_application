 <!-------------------------------- Modal for genrate invoice------------------------------------->
 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
 <div class="Minvoice-wrapper">
     <!-- Header -->
     <div class="Minvoice-header">List Of Generated Invoice for <?= esc($clients[0]['legal_name']) ?></div>

     <!-- Top Buttons -->
     <div class="Minvoice-top-actions">
         <button class="Minvoice-btn Minvoice-btn-primary"  onclick="printLedger()">Print Ledger</button>
         <button type="button" class=" Minvoice-btn Minvoice-btn-primary" data-toggle="modal"
             data-target="#exampleModal">
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
                     <th style="width: 30%">Works</th>
                     <th style="width: 16%">Company</th>
                     <th style="width: 12%">Total Invoice Amount</th>
                     <th style="width: 10%">Receipt Date</th>
                     <th style="width: 10%">Receipt No</th>
                     <th style="width: 12%">Action</th>
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
                <td class="Minvoice-text-right">
                    <?= number_format($row['total_invoice_amount'], 2) ?>
                </td>
                <td>
                        <?= !empty($row['invoice_date']) 
                            ? date('d-m-Y', strtotime($row['invoice_date'])) 
                            : '-' ?>
                </td>
                <td><?= esc($row['id']) ?></td>
               
                <td class="Minvoice-text-right">
    <!-- Edit -->
    <a href="<?= site_url('invoice/edit/' . $row['id']) ?>"
       class="Minvoice-icon-btn edit"
       title="Edit Invoice">
        ✏️
    </a>

    <!-- Delete -->
    <button type="button"
        class="Minvoice-icon-btn delete"
        title="Delete Invoice"
        onclick="deleteInvoice(<?= $row['id'] ?>)">
        🗑️
    </button>

    <!-- Export Excel -->
    <a href="<?= site_url('invoice/receipt/' . $row['id']) ?>"
       class="Minvoice-icon-btn export"
       title="Export Excel">
        📥
    </a>

    <!-- Print & Preview -->
    <button type="button"
        class="Minvoice-print-btn"
        onclick="printInvoice(<?= $row['id'] ?>)">
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