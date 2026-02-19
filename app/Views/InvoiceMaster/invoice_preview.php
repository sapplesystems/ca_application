<div class="invoiceM-containerr">
    <div class=" inv-header-main">
        <h1 class="inv-title-main">Invoice</h1>
        <a href="javascript:history.back()" class="inv-back-btn-main">
            Back to Generate Invoice Grid
        </a>
    </div>
    <form method="post" action="<?= site_url('/saveInvoice') ?>" id="invoiceForm">
        <table width="100%" border="0">
            <tr>
              <td style="font-size:14px; line-height:1.5;">
    
    <h2 style="margin:0; font-size:18px;">
        <?= esc($company['name']); ?>
    </h2>

    <div style="margin-top:5px;">
        <?= esc($company['type_of_company']); ?>
    </div>

    <div>
        <?= esc($company['registered_office'] ?? ''); ?>
    </div>

    <div>
        <strong>Ph:</strong> <?= esc($company['telephone'] ?? ''); ?>
    </div>

    <div>
        <strong>Email:</strong> <?= esc($company['email'] ?? ''); ?>
    </div>

    <div>
        <strong>GSTIN:</strong> <?= esc($company['gstin'] ?? ''); ?>
    </div>

</td>

                <td align="right" style="vertical-align: top; padding: 12px 15px; width: 200px;">
    <div style="display: inline-block; max-width: 200px; line-height: 0; text-align: right;">
        <img src="<?= base_url('public/uploads/company_logo/' . $company['logo']); ?>" 
             style="max-width: 100%; max-height: 200px; width: auto; height: auto; display: inline-block; margin: 0; padding: 0; vertical-align: top;">
    </div>
</td>
            </tr>
        </table>

        <hr>
        <div style="text-align:center; font-weight:bold;background-color: #0b5c7d;padding: 10px;color: #fff; margin-bottom:10px;">
            Service Invoice
        </div>

        <table width="100%" border="0" cellpadding="6">
            <tr>
                <td width="60%">
                    <strong>PAN:</strong> <?= esc($company['pan'] ?? ''); ?>
                </td>
                 <td width="40%">
                   <strong>Date :</strong><br>
                    <?= date('d-m-Y'); ?>
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Category Of Service :</strong> CONSULTANCY
                </td>
                <td align="right">
                     <strong>Invoice No. :</strong><br>
                    <input type="text"
                        name="invoice_no"
                        value="<?= esc($company['invoice_format']) ?>"
                        style="width:180px; padding:4px;"
                        required>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="6">
            

            <hr>

            <!-- Bill To Section -->
            <table width="100%" border="0" cellpadding="6">
                <tr>
                    <td >
                        <strong>Bill To,</strong><br><br>

                        <strong>Name :</strong>
                        <?= esc($client['legal_name']); ?><br>

                        <strong>Address :</strong>
                        <?= esc($client['registered_office']); ?>
                    </td>
                </tr>
            </table>

            <table class="invoice-table"
                style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px;">

                <thead>
                    <tr style="background:#0b5c7d; color:#fff;">
                        <th style="width:5%; padding:8px; border:1px solid #ccc;">SL No.</th>
                        <th style="width:70%; padding:8px; border:1px solid #ccc;">Nature of Services</th>
                        <th style="width:25%; padding:8px; border:1px solid #ccc;">Amount (Rs)</th>
                    </tr>
                </thead>

                <tbody id="expenseBody">
                   <?php $sl = 1; ?>
<?php foreach($works as $service): ?>
<tr>
    <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?= $sl++; ?></td>
    
    <td style="padding:8px; border:1px solid #ccc;">
       <leval><?= esc($service['service_name']); ?></leval> 
        <input type="hidden" name="service_name[]" value="<?= esc($service['service_name']) ?>">
        <input type="hidden" name="unit[]" value="<?= esc($service['unit']) ?>">
        <input type="hidden" name="sacCode[]" value="<?= esc($service['sac_code']) ?>">
        <input type="text" 
               name="service_description[]" 
               value=""
               style="width:100%; margin-top:6px; padding:6px; border:1px solid #bbb;" 
               placeholder="Description"
               class="service-description">   
              <span class="error-msg" style="color:red; font-size:12px;"></span>
    </td>
      
    
    <td style="padding:8px; border:1px solid #ccc;">
        <leval style="visibility:hidden;">Hidden</leval>
        <input type="text" 
               name="service_amount[]" 
               class="service-amount" 
               value=""
               style="width:100%; padding:6px; border:1px solid #bbb; text-align:right;">
                <span class="error-msg" style="color:red; font-size:12px;"></span>
    </td>
   
</tr>
<?php endforeach; ?>


                    <!-- A -->
                    <tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;"></td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">Service
                            Value
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            <span id="serviceValue">0</span>
                        </td>
                    </tr>
                    <?php if ($taxType === 'cgst_sgst'): ?>
                            <!-- <tr>
                            <td></td>
                            <td>Add : Expenses Recoverable</td>
                            <td>
                                <button type="button" onclick="addExpenseRow()" style="margin-top:10px; padding:6px 12px;">
                                ➕ Add Expense
                                </button>
                            </td>
                            </tr> -->
                   
                     <!-- <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">i</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                        <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button>
                       </td>
                        </tr>

                        <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">ii</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                        <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button>
                    </td>
                        </tr> -->

                        <!-- <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">iii</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                        <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button>
                    </td>
                        </tr> -->

                        <!-- Hidden Template Row -->
                        <!-- <tr id="hiddenRow" class="expense-row" style="background:#e9f5fb; display:none;">
                        <td style="text-align:center;"></td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                    <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button></td>
                        </tr> -->
                             <!-- B -->
                    <!-- <tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">B</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            Total Expenses Recoverable
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            <span id="expenseTotal">0</span>
                        </td>
                    </tr> -->
                     <!-- CGST Row -->
                    <tr id="cgstRow" style="background:#e9f5fb;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;"></td>
                        <td style="padding:8px; border:1px solid #ccc;">CGST @ 9%</td>
                        <td style="padding:8px; border:1px solid #ccc;">
                            <input type="text" id="cgstAmount" readonly style="width:100%; text-align:right;">
                        </td>
                    </tr>

                    <!-- SGST Row -->
                    <tr id="sgstRow" style="background:#e9f5fb;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;"></td>
                        <td style="padding:8px; border:1px solid #ccc;">SGST @ 9%</td>
                        <td style="padding:8px; border:1px solid #ccc;">
                            <input type="text" id="sgstAmount" readonly style="width:100%; text-align:right;">
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($taxType === 'igst'): ?>
                            <!-- <tr>
                            <td></td>
                            <td>Add : Expenses Recoverable</td>
                            <td>
                                <button type="button" onclick="addExpenseRow()" style="margin-top:10px; padding:6px 12px;">
                                ➕ Add Expense
                                </button>
                            </td>
                            </tr> -->
                   
                      <!-- <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">i</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                    <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button></td>
                        </tr> -->

                        <!-- <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">ii</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                    <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button></td>
                        </tr> -->

                        <!-- <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">iii</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                    <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button></td>
                        </tr> -->
 
                        <!-- Hidden Template Row -->
                        <!-- <tr id="hiddenRow" class="expense-row" style="background:#e9f5fb; display:none;">
                        <td style="text-align:center;"></td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                    <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button></td>
                        </tr> -->
                             <!-- B -->
                    <!-- <tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">B</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            Total Expenses Recoverable
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            <span id="expenseTotal">0</span>
                        </td>
                    </tr> -->

                    <tr id="igstRow" style="background:#e9f5fb;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;"></td>
                        <td style="padding:8px; border:1px solid #ccc;">IGST @ 18%</td>
                        <td style="padding:8px; border:1px solid #ccc;">
                            <input type="text" id="igstAmount" readonly style="width:100%; text-align:right;">
                        </td>
                    </tr>
                       
                    <?php endif; ?>

                <?php if ($expenses === 'true'): ?> 
                     <tr>
                            <td></td>
                            <td>Add : Expenses Recoverable</td>
                            <td>
                                <button type="button" onclick="addExpenseRow()" style="margin-top:10px; padding:6px 12px;">
                                ➕ Add Expense
                                </button>
                            </td>
                            </tr>
                   
                     <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">i</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                        <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button>
                       </td>
                        </tr>

                        <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">ii</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                        <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button>
                    </td>
                        </tr>

                        <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">iii</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                        <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button>
                    </td>
                        </tr>

                        <!-- Hidden Template Row -->
                        <tr id="hiddenRow" class="expense-row" style="background:#e9f5fb; display:none;">
                        <td style="text-align:center;"></td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;" name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;" name="expense_amount[]">
                    <button type="button" class="btn btn-danger btn-sm delete-row"style="background-color: red;">✖</button></td>
                        </tr>
                             <!-- B -->
                    <tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;"></td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            Total Expenses Recoverable
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            <span id="expenseTotal">0</span>
                        </td>
                    </tr>
                 <?php endif; ?>   


                   

                    <!-- Grand total -->
                    <tr>
                        <td style="padding:8px; border:1px solid #ccc;"></td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;">
                            <strong>Grand Total</strong>
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;">
                            <strong id="grandTotal">0</strong>
                        </td>
                    </tr>

                    <!-- Advance -->
                    <tr>
                        <td style="padding:8px; border:1px solid #ccc;"></td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;">
                            (-) Advances Received
                        </td>
                        <td style="padding:8px; border:1px solid #ccc;">
                            <input type="text" id="advance" name="advance_received"
                                style="width:100%; padding:6px; border:1px solid #bbb; text-align:right;">
                        </td>
                    </tr>

                    <!-- Net -->
                    <tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">C</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:left;background:#0b5c7d;">
                            <strong>(Amount In Words)</strong><br>
                           <span id="amountInWords">ZERO</span>

    <!-- 🔑 Hidden field for DB -->
    <input type="hidden" name="amount_in_words" id="amountInWordsInput" value="ZERO">
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            Net Amount Receivable
                            <br><strong id="netAmount">0</strong>
                        </td>
                    </tr>
                </tbody>
            </table>

             <div>
          <b>Banker's Details</b><br />
         Bank name:<?php echo $company['bank_name']; ?><br />
          Ac.No. : <?php echo $company['bank_ac_no']; ?><br />
          IFSC Code : <?php echo $company['bank_ifsc']; ?><br />
          Branch :<?php echo $company['branch_address']; ?>
        </div>

            <div>
                <label name="term_condition"><strong>Terms & Conditions:</strong></label>
                    <textarea style="width:100%; height:100px; border:1px solid #bbb; padding:6px; margin:10px;"
    name="term_condition"><?php echo htmlspecialchars($company['condition_and_terms']); ?></textarea>

    </textarea>
            </div>
            <input type="hidden" name="service_value" id="serviceValueInput">
            <input type="hidden" name="cgst_amount" id="cgstInput">
            <input type="hidden" name="sgst_amount" id="sgstInput">
            <input type="hidden" name="igst_amount" id="igstInput">
            <input type="hidden" name="expense_total" id="expenseTotalInput">
            <input type="hidden" name="grand_total" id="grandTotalInput">
            <input type="hidden" name="net_amount" id="netAmountInput">
            <input type="hidden" name="client_id" value="<?= esc($client['id']) ?>">
            <input type="hidden" name="company_id" value="<?= esc($company['id']) ?>">
            <input type="hidden" name="invoice_date" value="<?= date('Y-m-d') ?>">
            <input type="hidden" name="created_by" value="<?= esc($client['id']) ?>">
            <input type="hidden" name="tax_apply_name" value="<?= esc($taxType) ?>">

            <div style="margin-top:25px; text-align:center;">

    <button class="Gvoice-btn Gvoice-btn-success" id="saveInvoiceBtn"
        style="padding:10px 22px; font-size:14px; border-radius:5px; margin-right:10px; cursor:pointer;">
        Save Invoice
    </button>

    <a href="javascript:history.back()"
        class="Gvoice-btn Gvoice-btn-danger"
        style="padding:10px 22px; font-size:14px; border-radius:5px; text-decoration:none; display:inline-block;">
        Cancel
    </a>

</div>
    </form>





    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.getElementById('invoiceForm').addEventListener('submit', function (e) {
    e.preventDefault(); // stop default submit

    let isValid = true;

    // 🔴 VALIDATION
    document.querySelectorAll('.service-description, .service-amount').forEach(input => {
        const errorSpan = input.nextElementSibling;

        if (!input.value.trim()) {
            errorSpan.textContent = 'This field is required';
            input.style.border = '2px solid red';
            isValid = false;
        } else {
            errorSpan.textContent = '';
            input.style.border = '1px solid #bbb';
        }
    });

    // ❌ STOP if validation failed
    if (!isValid) {
        return;
    }

    // ✅ AJAX SUBMIT ONLY IF VALID
    const form = this;

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                title: 'Invoice Saved!',
                text: 'Your invoice has been saved successfully.',
                icon: 'success',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Print Invoice',
                denyButtonText: 'Download PDF',
                cancelButtonText: 'Close'
            }).then(result => {
                if (result.isConfirmed) {
                    window.open('<?= site_url("invoice/print/") ?>' + data.invoice_id);
                } else if (result.isDenied) {
                    window.open('<?= site_url("invoice/pdf/") ?>' + data.invoice_id, '_blank');
                }
            });
        } else {
            Swal.fire('Error!', 'Something went wrong while saving invoice.', 'error');
        }
    })
    .catch(() => {
        Swal.fire('Error!', 'Network or server error', 'error');
    });
});


function calculateTotals() {

    /* ✅ SERVICE VALUE */
    let serviceValue = 0;
    document.querySelectorAll('.service-amount').forEach(el => {
        let value = parseFloat(el.value);
        if (!isNaN(value)) {
            serviceValue += value;
        }
    });

    const serviceValueEl = document.getElementById('serviceValue');
    if (serviceValueEl) {
        serviceValueEl.innerText = serviceValue.toFixed(2);
    }

    /* ✅ EXPENSE TOTAL (ONLY IF EXISTS IN PAGE) */
    let expenseTotal = 0;
    const expenseInputs = document.querySelectorAll('.expense');

    if (expenseInputs.length > 0) {
        expenseInputs.forEach(el => {
            let value = parseFloat(el.value);
            if (!isNaN(value)) {
                expenseTotal += value;
            }
        });

        const expenseTotalEl = document.getElementById('expenseTotal');
        if (expenseTotalEl) {
            expenseTotalEl.innerText = expenseTotal.toFixed(2);
        }
    }

    let cgst = 0, sgst = 0, igst = 0;

    /* ✅ TAX ONLY ON SERVICE VALUE */
    if (document.getElementById('cgstAmount')) {
        cgst = serviceValue * 0.09;
        sgst = serviceValue * 0.09;

        document.getElementById('cgstAmount').value = cgst.toFixed(2);
        document.getElementById('sgstAmount').value = sgst.toFixed(2);
    }

    if (document.getElementById('igstAmount')) {
        igst = serviceValue * 0.18;
        document.getElementById('igstAmount').value = igst.toFixed(2);
    }

    /* ✅ GRAND TOTAL */
    let taxTotal = cgst + sgst + igst;
    let grandTotal = serviceValue + expenseTotal + taxTotal;

    const grandTotalEl = document.getElementById('grandTotal');
    if (grandTotalEl) {
        grandTotalEl.innerText = grandTotal.toFixed(2);
    }

    /* ✅ ADVANCE */
    let advance = parseFloat(document.getElementById('advance')?.value);
    if (isNaN(advance)) advance = 0;

    let netAmount = grandTotal - advance;

    const netAmountEl = document.getElementById('netAmount');
    if (netAmountEl) {
        netAmountEl.innerText = netAmount.toFixed(2);
    }

    let words = numberToWords(Math.round(netAmount)).toUpperCase();

    if (document.getElementById('amountInWords')) {
        document.getElementById('amountInWords').innerText = words;
    }

    if (document.getElementById('amountInWordsInput')) {
        document.getElementById('amountInWordsInput').value = words;
    }

    /* ✅ HIDDEN INPUTS SAFE */
    if (typeof serviceValueInput !== 'undefined')
        serviceValueInput.value = serviceValue.toFixed(2);

    if (typeof expenseTotalInput !== 'undefined')
        expenseTotalInput.value = expenseTotal.toFixed(2);

    if (typeof cgstInput !== 'undefined')
        cgstInput.value = cgst.toFixed(2);

    if (typeof sgstInput !== 'undefined')
        sgstInput.value = sgst.toFixed(2);

    if (typeof igstInput !== 'undefined')
        igstInput.value = igst.toFixed(2);

    if (typeof grandTotalInput !== 'undefined')
        grandTotalInput.value = grandTotal.toFixed(2);

    if (typeof netAmountInput !== 'undefined')
        netAmountInput.value = netAmount.toFixed(2);
}




/* ✅ ADD EXPENSE ROW */
function addExpenseRow() {
    const template = document.getElementById('hiddenRow');
    const clone = template.cloneNode(true);

    clone.style.display = '';
    clone.removeAttribute('id');

    // 🔥 IMPORTANT: reset values
    clone.querySelectorAll('input').forEach(input => {
        input.value = '';
    });

    template.parentNode.insertBefore(clone, template);
}

/* EVENTS */
document.addEventListener('input', function (e) {
    if (
        e.target.classList.contains('service-amount') ||
        e.target.classList.contains('expense') ||
        e.target.id === 'advance'
    ) {
        calculateTotals();
    }
});

/* INIT */
calculateTotals();

    // Convert Number to Words (Indian Format – basic)
    function numberToWords(num) {
        const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
        const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
        const teens = ["Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen",
            "Nineteen"
        ];

        function convert(n) {
            if (n < 10) return ones[n];
            if (n < 20) return teens[n - 10];
            if (n < 100) return tens[Math.floor(n / 10)] + " " + ones[n % 10];
            if (n < 1000) return ones[Math.floor(n / 100)] + " Hundred " + convert(n % 100);
            if (n < 100000) return convert(Math.floor(n / 1000)) + " Thousand " + convert(n % 1000);
            if (n < 10000000) return convert(Math.floor(n / 100000)) + " Lakh " + convert(n % 100000);
            return convert(Math.floor(n / 10000000)) + " Crore " + convert(n % 10000000);
        }

        return num === 0 ? "Zero" : convert(num);
    }

    // Event listeners
    document.querySelectorAll('.service-amount').forEach(el => {
        el.addEventListener('input', calculateTotals);
    });

    document.getElementById('advance').addEventListener('input', calculateTotals);

    // Initial calculation
    calculateTotals();
    
    document.addEventListener('click', function (e) {
    if (!e.target.classList.contains('delete-row')) return;

    const row = e.target.closest('tr');
    const expenseId = e.target.dataset.expenseId; // DB ID
    const tbody = document.getElementById('expenseBody');

    Swal.fire({
        title: 'Delete this expense?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete'
    }).then(result => {

        if (!result.isConfirmed) return;

        // If expense exists in DB → delete via AJAX
        if (expenseId) {
            fetch('<?= site_url("Expense/delete") ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ expense_id: expenseId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    removeRow(row, tbody);
                } else {
                    Swal.fire('Error', data.message || 'Delete failed', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Server error', 'error');
            });
        } 
        // If not saved yet → just remove from UI
        else {
            removeRow(row, tbody);
        }
    });
});

function removeRow(row, tbody) {
    const rows = tbody.querySelectorAll('tr.expense-row:not([style*="display:none"])');

    if (rows.length <= 1) {
        Swal.fire('Warning', 'At least one expense row is required.', 'warning');
        return;
    }

    row.remove();

    // Re-index rows
    tbody.querySelectorAll('tr.expense-row:not([style*="display:none"])')
        .forEach((tr, index) => {
            tr.cells[0].textContent = index + 1;
        });

    calculateTotals();
}

    </script>