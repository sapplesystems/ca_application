<?php
function toRoman($number)
{
    $map = [
        'm'  => 1000,
        'cm' => 900,
        'd'  => 500,
        'cd' => 400,
        'c'  => 100,
        'xc' => 90,
        'l'  => 50,
        'xl' => 40,
        'x'  => 10,
        'ix' => 9,
        'v'  => 5,
        'iv' => 4,
        'i'  => 1,
    ];

    $result = '';
    foreach ($map as $roman => $value) {
        while ($number >= $value) {
            $result .= $roman;
            $number -= $value;
        }
    }
    return $result;
}
?>



<div class="invoiceM-containerr">
    <div class=" inv-header-main">
        <h1 class="inv-title-main">  <?= ($debitNote['note_type'] === 'debit') ? 'Debit Note' : 'Credit Note'; ?></h1>
        
        <a href="javascript:history.back()" class="inv-back-btn-main">
            Back to Generate Invoice Grid
        </a>
    </div>
    <form id="debitForm" method="post" action="<?= base_url('debits/update/' . $debitNote['id']) ?>">
    <?= csrf_field() ?>
        <table width="100%" border="0">
            <tr>
                <td>
                    <h2><?= esc($company['name']); ?></h2>
                    <br>
                    <?= esc($company['type_of_company']); ?><br>
                    <?= esc($company['registered_office'] ?? ''); ?><br>
                    PH: <?= esc($company['telephone'] ?? ''); ?><br>
                    Email: <?= esc($company['email'] ?? ''); ?><br>
                    GSTIN: <?= esc($company['gstin'] ?? ''); ?>
                </td>

                <td align="right">
                    <strong>Date:</strong> <?= esc($company['date_of_incorp']); ?>
                </td>
            </tr>
        </table>

        <hr>
        <div style="text-align:center; font-weight:bold; margin-bottom:10px;">
             <?= ($debitNote['note_type'] === 'debit') ? 'Debit Note' : 'Credit Note'; ?>
        </div>

        <table width="100%" border="0" cellpadding="6">
            <tr>
                <td width="60%">
                    <strong>PAN:</strong> <?= esc($company['pan'] ?? ''); ?>
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Category Of Service :</strong> CONSULTANCY
                </td>
                <td align="right">
                    <strong>Date :</strong><br>
                    <?= esc($debitNote['date']) ?>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="6">
            <tr>
                <td width="60%">
                    <strong>PAN:</strong> <?= esc($company['pan'] ?? ''); ?>
                </td>
                <td width="40%" align="right">
                    <strong>  <?= ($debitNote['note_type'] === 'debit') ? 'Debit Note No.' : 'Credit Note No.'; ?></strong><br>
                    <?php if ($debitNote['note_type'] === 'debit') : ?>
                     <input type="text"
                        name="debit_no"
                        value="<?= esc($debitNote['debit_no']); ?>"
                        style="width:180px; padding:4px;"
                        required>
                        <?php elseif ($debitNote['note_type'] === 'credit') : ?>
                             <input type="text"
                        name="credit_no"
                        value="<?= esc($debitNote['credit_no']); ?>"
                        style="width:180px; padding:4px;"
                        required>
                    <?php endif; ?>
                </td>
            </tr>

            <hr>

            <!-- Bill To Section -->
            <table width="100%" border="0" cellpadding="6">
                <tr>
                    <td>
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
                        <th style="width:70%; padding:8px; border:1px solid #ccc;">Details Of Expenses</th>
                        <th style="width:25%; padding:8px; border:1px solid #ccc;">Amount (Rs)</th>
                    </tr>
                </thead>

                <tbody id="expenseBody">

                    <!-- Add Expense Button Row -->
                    <tr>
                        <td></td>
                        <td>Add : Expenses Recoverable</td>
                        <td>
                            <button type="button" onclick="addExpenseRow()" style="margin-top:10px; padding:6px 12px;">
                                ➕ Add Expense
                            </button>
                        </td>
                    </tr>

                    <!-- Existing Expense Rows -->
                    <?php if(!empty($expenses)): ?>
                    <?php foreach($expenses as $index => $exp): ?>
                    <input type="hidden" name="expense_id[]" value="<?= $exp['id'] ?>">

                    <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;"><?= $index + 1 ?></td>
                        <td>
                            <input type="text" placeholder="Expense Recoverable" style="width:100%;"
                                name="expense_description[]" value="<?= esc($exp['expense_description']) ?>">
                        </td>
                        <td>
                            <input type="text" class="expense" style="width:85%; text-align:right;"
                                name="expense_amount[]" value="<?= esc($exp['expense_amount']) ?>">
                                <button type="button" class="btn btn-danger btn-sm delete-row" data-expense-id="<?= esc($exp['id']) ?>"style="background-color: red;">✖</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr class="expense-row" style="background:#e9f5fb;">
                        <td style="text-align:center;">i</td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;"
                                name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;"
                                name="expense_amount[]">
                                <button type="button" class="btn btn-danger btn-sm delete-row" data-expense-id="<?= esc($exp['id']) ?>"style="background-color: red;">✖</button>
                            </td>
                                
                    </tr>
                    <?php endif; ?>

                    <!-- Hidden Template Row -->
                    <tr id="hiddenRow" class="expense-row" style="background:#e9f5fb; display:none;">
                        <td style="text-align:center;"></td>
                        <td><input type="text" placeholder="Expense Recoverable" style="width:100%;"
                                name="expense_description[]"></td>
                        <td><input type="text" class="expense" style="width:85%; text-align:right;"
                                name="expense_amount[]">
                                <button type="button" class="btn btn-danger btn-sm delete-row" data-expense-id="<?= esc($exp['id']) ?>"style="background-color: red;">✖</button>
                            </td>
                    </tr>

                    <!-- Totals / Grand Total / Advance / Net rows -->
                    <tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">A</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            Total Expenses Recoverable
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                            <span id="expenseTotalDisplay">0</span>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:8px; border:1px solid #ccc;"></td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;"><strong>Grand Total</strong>
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;"><strong
                                id="grandTotalDisplay">0</strong></td>
                    </tr>

                    <tr>
                        <td style="padding:8px; border:1px solid #ccc;">B</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;">(-) Advances Received</td>
                        <td style="padding:8px; border:1px solid #ccc;">
                            <input type="text" value="<?= esc($debitNote['advance_amount'] ?? 0) ?>" id="advance"
                                name="advance_received"
                                style="width:100%; padding:6px; border:1px solid #bbb; text-align:right;">
                        </td>
                    </tr>

                    <tr style="background:#0b5c7d; color:#fff;">
                        <td style="padding:8px; border:1px solid #ccc; text-align:center; color:black;">C</td>
                        <td style="padding:8px; border:1px solid #ccc;color:black">
                            <strong>(Amount In Words)</strong><br>
                            <span id="amountInWords">ZERO</span>
                        </td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right; color:black;">
                            Net Amount Receivable (A+B)<br>
                            <strong id="netAmountDisplay">0</strong>
                        </td>
                    </tr>

                </tbody>
            </table>

             <div class="debitnotepdf-bank">
        <div>
          <b>Banker's Details</b><br />
          <?php echo $company['bank_name']; ?><br />
          Ac.No. : <?php echo $company['bank_ac_no']; ?><br />
          IFSC Code : <?php echo $company['bank_ifsc']; ?><br />
        </div>
      </div>

            <div>
                <label name="term_condition"><strong>Terms & Conditions:</strong></label>
              <textarea
    style="width:100%; height:100px; border:1px solid #bbb; padding:6px; margin:10px;"
    name="term_condition"><?= esc($debitNote['terms_and_conditions'] ?? '') ?></textarea>


    </textarea>
            </div>
            <input type="hidden" name="expense_total" id="expenseTotalInput" value="0">
            <input type="hidden" name="grand_total" id="grandTotalInput" value="0">
            <input type="hidden" name="net_amount" id="netAmountInput" value="0">
            <input type="hidden" name="debit_no" value="<?= esc($debitNote['debit_no']); ?>">

            <input type="hidden" name="client_id" value="<?= esc($client['id']) ?>">
            <input type="hidden" name="company_id" value="<?= esc($company['id']) ?>">
            <input type="hidden" name="debit_date" value="<?= esc(date('Y-m-d')) ?>">
            <input type="hidden" name="created_by" value="<?= esc($client['id']) ?>">


            <div style="margin-top:20px; text-align:center;">
                <button class="Gvoice-btn Gvoice-btn-success" id="saveInvoiceBtn"><?= ($debitNote['note_type'] === 'debit') ? 'Save Debit' : 'Save Credit'; ?></button>
                <a href="javascript:history.back()"
                    class="Gvoice-btn Gvoice-btn-danger">
                        Cancel
                </a>
            </div>
    </form>





    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
document.getElementById('debitForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === 'success') {

            Swal.fire({
                title: data.mode === 'update'
                    ? 'Debit Updated!'
                    : 'Debit Saved!',
                text: 'Debit Note processed successfully.',
                icon: 'success',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Print Invoice',
                denyButtonText: 'Download PDF',
                cancelButtonText: 'Close'
            }).then(result => {

                if (result.isConfirmed) {
                    window.open(
                        '<?= site_url("DebitNote/") ?>' + data.invoice_id,
                        '_blank'
                    );
                }

                else if (result.isDenied) {
                    window.open(
                        '<?= site_url("DebitNotePDF/") ?>' + data.invoice_id,
                        '_blank'
                    );
                }

                else if (result.isDismissed) {
                    Swal.fire({
                        title: 'Redirect?',
                        text: 'Go back to invoice list?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then(res => {
                        if (res.isConfirmed) {
                            window.location.href =
                                '<?= site_url("InvoiceManagment") ?>';
                        }
                    });
                }
            });

        } else {
            Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
        }
    })
    .catch(() => {
        Swal.fire('Error!', 'Network or server error', 'error');
    });

});
    function numberToWords(num) {
        if (num === 0) return 'ZERO';

        const ones = ['', 'ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX', 'SEVEN', 'EIGHT', 'NINE',
            'TEN', 'ELEVEN', 'TWELVE', 'THIRTEEN', 'FOURTEEN', 'FIFTEEN',
            'SIXTEEN', 'SEVENTEEN', 'EIGHTEEN', 'NINETEEN'
        ];

        const tens = ['', '', 'TWENTY', 'THIRTY', 'FORTY', 'FIFTY', 'SIXTY', 'SEVENTY', 'EIGHTY', 'NINETY'];

        function convert(n) {
            if (n < 20) return ones[n];
            if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 ? ' ' + ones[n % 10] : '');
            if (n < 1000) return ones[Math.floor(n / 100)] + ' HUNDRED ' + (n % 100 ? convert(n % 100) : '');
            if (n < 100000) return convert(Math.floor(n / 1000)) + ' THOUSAND ' + (n % 1000 ? convert(n % 1000) : '');
            return '';
        }

        return convert(num).trim();
    }

    function calculateTotals() {
        let expenseTotal = 0;

        document.querySelectorAll('.expense-row:not([style*="display:none"]) .expense')
            .forEach(input => {
                expenseTotal += parseFloat(input.value) || 0;
            });

        const advance = parseFloat(document.getElementById('advance').value) || 0;
        const netAmount = expenseTotal - advance;

        /* ===== DISPLAY ===== */
        document.getElementById('expenseTotalDisplay').innerText = expenseTotal.toFixed(2);
        document.getElementById('grandTotalDisplay').innerText = expenseTotal.toFixed(2);
        document.getElementById('netAmountDisplay').innerText = netAmount.toFixed(2);

        /* ===== BACKEND (HIDDEN INPUTS) ===== */
        document.getElementById('expenseTotalInput').value = expenseTotal.toFixed(2);
        document.getElementById('grandTotalInput').value = expenseTotal.toFixed(2);
        document.getElementById('netAmountInput').value = netAmount.toFixed(2);

        document.getElementById('amountInWords').innerText =
            numberToWords(Math.round(netAmount));
    }


    // Add input event listener for dynamic rows
    function attachInputListeners() {
        document.querySelectorAll('.expense, #advance').forEach(el => {
            el.removeEventListener('input', calculateTotals); // prevent duplicates
            el.addEventListener('input', calculateTotals);
        });
    }

    // Call whenever a new row is added
    function addExpenseRow() {
        const tbody = document.getElementById('expenseBody');
        const hiddenRow = document.getElementById('hiddenRow');

        const existingRows = tbody.querySelectorAll('tr.expense-row:not([style*="display:none"])').length;

        // Clone hidden row
        const newRow = hiddenRow.cloneNode(true);
        newRow.style.display = '';
        newRow.id = '';
        newRow.cells[0].textContent = existingRows + 1; // simple counting

        // Insert before totals row
        const totalsRow = tbody.querySelector('tr[style*="background:#0b5c7d"]');
        tbody.insertBefore(newRow, totalsRow);

        // Attach input listener to the new input
        attachInputListeners();

        // Recalculate totals
        calculateTotals();
    }

    // Initial setup
    attachInputListeners();
    calculateTotals()

    // Function to convert a number to Roman numeral
    function toRoman(num) {
        const romanMap = [{
                value: 1000,
                numeral: 'm'
            },
            {
                value: 900,
                numeral: 'cm'
            },
            {
                value: 500,
                numeral: 'd'
            },
            {
                value: 400,
                numeral: 'cd'
            },
            {
                value: 100,
                numeral: 'c'
            },
            {
                value: 90,
                numeral: 'xc'
            },
            {
                value: 50,
                numeral: 'l'
            },
            {
                value: 40,
                numeral: 'xl'
            },
            {
                value: 10,
                numeral: 'x'
            },
            {
                value: 9,
                numeral: 'ix'
            },
            {
                value: 5,
                numeral: 'v'
            },
            {
                value: 4,
                numeral: 'iv'
            },
            {
                value: 1,
                numeral: 'i'
            }
        ];

        let result = '';
        for (const {
                value,
                numeral
            } of romanMap) {
            while (num >= value) {
                result += numeral;
                num -= value;
            }
        }
        return result;
    }

/* ================= INPUT LISTENERS ================= */
function attachInputListeners() {
    document.querySelectorAll('.expense, #advance').forEach(el => {
        el.removeEventListener('input', calculateTotals);
        el.addEventListener('input', calculateTotals);
    });
}

/* ================= INIT ================= */
attachInputListeners();
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
