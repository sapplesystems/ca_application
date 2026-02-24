<?php
function romanNumeral($num)
{
    $map = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'xl' => 40,
        'x' => 10,
        'ix' => 9,
        'v' => 5,
        'iv' => 4,
        'i' => 1
    ];
    $returnValue = '';
    while ($num > 0) {
        foreach ($map as $roman => $int) {
            if ($num >= $int) {
                $num -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return strtolower($returnValue);
}
?>


<div class="invoiceM-containerr">
    <div class=" inv-header-main">
        <h1 class="inv-title-main"> Edit Invoice</h1>
        <a href="javascript:history.back()" class="inv-back-btn-main">
            Back to Generate Invoice Grid
        </a>
    </div>

    <form method="post"
        action="<?= site_url('/updateInvoice/' . $invoice['id']) ?>"
        id="invoiceForm">

        <table width="100%" border="0">
            <tr>
                <td style="font-size:14px; line-height:1.5;">

                    <strong style="font-size:16px;">
                        <?= esc($company['name']); ?>
                    </strong><br>

                    <?= esc($company['type_of_company']); ?><br>
                    <?= esc($company['registered_office']); ?><br>

                    <strong>Ph:</strong> <?= esc($company['telephone']); ?><br>
                    <strong>Email:</strong> <?= esc($company['email']); ?><br>
                    <strong>GSTIN:</strong> <?= esc($company['gstin']); ?>

                    <td align="right" style="vertical-align: top; padding: 12px 15px; width: 200px;">
                    <div style="display: inline-block; max-width: 200px; line-height: 0; text-align: right;">
                    <?php if (!empty($company['logo']) && file_exists(FCPATH . 'uploads/company_logo/' . $company['logo'])): ?>
                                        <img src="<?= base_url('public/uploads/company_logo/' . $company['logo']); ?>"
                                            style="max-width: 100%; max-height: 200px; width: auto; height: auto; display: inline-block; margin: 0; padding: 0; vertical-align: top;">
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>

        <hr>

        <div style="text-align:center;font-weight:bold;background-color: #0b5c7d;padding: 10px;color: #fff;">SERVICE INVOICE</div>

        <hr>

        <table width="100%" cellpadding="6">
            <tr>
                <td width="60%">
                    <strong>PAN:</strong> <?= esc($company['pan']); ?>
                </td>
                <td width="40%" align="right">
                    <strong>Invoice No:</strong><br>

                    <input type="text"
                        name="invoice_no"
                        value="<?= esc($invoice['invoice_no']); ?>"
                        style="width: 150px; padding: 4px;">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Category Of Service :</strong> CONSULTANCY
                </td>
                <td align="right">
                    <strong>Date :</strong>
                    <input type="date"
                        name="invoice_date"
                        value="<?= !empty($invoice['invoice_date']) ? date('Y-m-d', strtotime($invoice['invoice_date'])) : ''; ?>"
                        style="margin-left:8px;padding:4px">
                </td>
            </tr>
        </table>

        <hr>

        <!-- BILL TO -->
        <table width="100%" cellpadding="6">
            <tr>
                <td>
                    <strong>Bill To</strong><br><br>
                    <strong>Name :</strong> <?= esc($client['legal_name']); ?><br>
                    <strong>Address :</strong> <?= esc($client['registered_office']); ?>
                </td>
            </tr>
        </table>

        <!-- INVOICE TABLE -->
        <table width="100%" style="border-collapse:collapse;font-size:14px;">
            <thead>
                <tr style="background:#0b5c7d;color:#fff;">
                    <th>SL</th>
                    <th>Nature of Services</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>

            <tbody id="expenseBody">
                <?php $sl = 1; ?>
                <?php foreach ($invoice_works as $service): ?>
                    <tr>
                        <td style="padding:8px; border:1px solid #ccc; text-align:center;">
                            <?= $sl++; ?>
                        </td>

                        <input type="hidden" name="work_id[]" value="<?= esc($service['id']); ?>">

                        <td style="padding:8px; border:1px solid #ccc;">
                            <leval><?= esc($service['service_name']); ?></leval>

                            <input type="text"
                                name="service_description[]"
                                value="<?= esc($service['service_description'] ?? '') ?>"
                                style="width:100%; margin-top:6px; padding:8px; border:1px solid #bbb;"
                                placeholder="Description">
                        </td>

                        <td style="padding:8px; border:1px solid #ccc;">
                            <leval style="visibility:hidden">Hidden</leval>
                            <input type="text"
                                name="service_amount[]"
                                class="service-amount"
                                value="<?= esc($service['service_amount'] ?? '') ?>"
                                style="width:100%; padding:8px; border:1px solid #bbb; text-align:right;margin-top: 5px;">
                        </td>
                    </tr>

                    <input type="hidden" name="service_name[]" value="<?= esc($service['service_name']) ?>">
                    <input type="hidden" name="service_unit[]" value="<?= esc($service['service_unit']) ?>">
                <?php endforeach; ?>


                <tr style="background:#0b5c7d;color:#fff;padding:8px;border:1px solid #ccc">
                    <td align="center" style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">A</td>
                    <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">Service Value</td>
                    <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;"><span id="serviceValue">0</span></td>
                </tr>

                <?php if ($invoice['tax_apply_name'] === 'cgst_sgst'): ?>
                    <td align="center"></td>
                    <td>CGST @ 9%</td>
                    <td><input readonly id="cgstAmount" style="width:100%;text-align:right;padding:8px;border:1px solid #ccc"></td>
                    </tr>
                    <tr>
                        <td align="center"></td>
                        <td>SGST @ 9%</td>
                        <td><input readonly id="sgstAmount" style="width:100%;text-align:right;padding:8px;border:1px solid #ccc"></td>
                    </tr>

                <?php endif; ?>

                <?php if ($invoice['tax_apply_name'] === 'igst'): ?>
                    <td align="center">i</td>
                    <td>IGST @ 18%</td>
                    <td><input readonly id="igstAmount" style="width:100%;text-align:right;padding:8px;border:1px solid #ccc"></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td></td>
                    <td>Add : Expenses Recoverable</td>
                    <td>
                        <button type="button" onclick="addExpenseRow()" style="margin-top:10px; padding:6px 12px;">
                            ➕ Add Expense
                        </button>
                    </td>
                </tr>

                <?php if (!empty($expenses)): ?>
                    <?php foreach ($expenses as $index => $exp): ?>
                        <tr class="expense-row" style="background:#e9f5fb;">
                            <td style="text-align:center;">
                                <?= romanNumeral($index + 1); ?>
                            </td>
                            <td>
                                <input type="hidden" name="expense_id[]" value="<?= esc($exp['id']) ?>">
                                <input type="text"
                                    name="expense_description[]"
                                    value="<?= esc($exp['expense_description']); ?>"
                                    style="width:100%;padding:8px;border:1px solid #ccc">
                            </td>
                            <td>
                                <input type="text"
                                    class="expense"
                                    name="expense_amount[]"
                                    value="<?= esc($exp['expense_amount']); ?>"
                                    style="width:85%; text-align:right;padding:8px;border:1px solid #ccc">
                                <button type="button" class="btn btn-danger btn-sm delete-row" data-expense-id="<?= esc($exp['id']) ?>" style="background-color: red;">✖</button>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- Hidden Template Row -->
                <tr id="hiddenRow" class="expense-row" style="background:#e9f5fb; display:none;">
                    <td style="text-align:center;"></td>
                    <td>
                        <input type="hidden" name="expense_id[]" value="">
                        <input type="text" placeholder="Expense Recoverable" name="expense_description[]" style="width:100%;margin-top:6px; padding:8px; border:1px solid #bbb;">
                    </td>
                    <td>
                        <input type="text" class="expense" name="expense_amount[]" style="width:85%; text-align:right;margin-top:6px; padding:8px; border:1px solid #bbb;">
                        <button type="button" class="btn btn-danger btn-sm delete-row" style="background-color: red;">✖</button>

                    </td>
                </tr>

                <tr style="background:#0b5c7d; color:#fff;">
                    <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">B</td>
                    <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                        Total Expenses Recoverable
                    </td>
                    <td style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                        <span id="expenseTotal">0</span>
                    </td>
                </tr>
                <tr>


                <tr>
                    <td></td>
                    <td align="right"><strong>Grand Total</strong></td>
                    <td align="right" style="text-align:right;"><strong id="grandTotal">0</strong></td>
                </tr>

                <tr>
                    <td></td>
                    <td align="right">(-) Advance</td>
                    <td>
                        <input type="text" id="advance" name="advance_received"
                            value="<?= esc($invoice['advance_received']); ?>"
                            style="width:100%;text-align:right;padding:8px;border:1px solid #ccc">
                    </td>
                </tr>

                <tr style="background:#0b5c7d;color:#fff;">
                    <td style="padding:8px; border:1px solid #ccc; text-align:center;background:#0b5c7d;">C</td>
                    <td style="padding:8px; border:1px solid #ccc; text-align:left;background:#0b5c7d;">
                        <strong>Amount In Words</strong><br>

                        <!-- Display -->
                        <span id="amountInWords">
                            <?= esc($invoice['amount_in_words'] ?? 'ZERO'); ?>
                        </span>

                        <!-- Hidden field for submit -->
                        <input type="hidden"
                            name="amount_in_words"
                            id="amountInWordsInput"
                            value="<?= esc($invoice['amount_in_words'] ?? 'ZERO'); ?>">
                    </td>
                    <td align="right" style="padding:8px; border:1px solid #ccc; text-align:right;background:#0b5c7d;">
                        Net Amount Receivable<br>
                        <strong id="netAmount">0</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>
        <div>
            <b>Banker's Details</b><br />
            bank name :<?php echo $company['bank_name']; ?><br />
            Ac.No. : <?php echo $company['bank_ac_no']; ?><br />
            IFSC Code : <?php echo $company['bank_ifsc']; ?><br />
        </div>

        <strong>Terms & Conditions</strong>
        <textarea name="term_condition" style="width:100%;height:80px;">
<?= esc($invoice['term_condition']); ?>
</textarea>

        <!-- HIDDEN VALUES -->


        <input type="hidden" id="serviceValueInput" name="service_value">
        <input type="hidden" id="expenseTotalInput" name="expense_total">

        <!-- GST (only one of these may exist depending on tax type) -->
        <input type="hidden" id="cgstInput" name="cgst">
        <input type="hidden" id="sgstInput" name="sgst">
        <input type="hidden" id="igstInput" name="igst">

        <input type="hidden" id="grandTotalInput" name="grand_total">
        <input type="hidden" id="netAmountInput" name="net_amount">

        <input type="hidden" name="invoice_id" value="<?= esc($invoice['id']); ?>">


        <div style="text-align:center; margin-top:25px;">

            <button class="Gvoice-btn Gvoice-btn-success"
                style="padding:10px 22px; font-size:14px; border-radius:5px; margin-right:10px; cursor:pointer;">
                Update Invoice
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
        /* ==========================
   DOM REFERENCES
========================== */
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('invoiceForm');

            // Hidden inputs
            const serviceValueInput = document.getElementById('serviceValueInput');
            const expenseTotalInput = document.getElementById('expenseTotalInput');
            const cgstInput = document.getElementById('cgstInput');
            const sgstInput = document.getElementById('sgstInput');
            const igstInput = document.getElementById('igstInput');
            const grandTotalInput = document.getElementById('grandTotalInput');
            const netAmountInput = document.getElementById('netAmountInput');

            /* ==========================
               CALCULATE TOTALS
            ========================== */
            function calculateTotals() {

                /* =========================
                   ✅ SERVICE TOTAL
                ========================== */
                let serviceValue = 0;
                document.querySelectorAll('.service-amount').forEach(el => {
                    serviceValue += parseFloat(el.value) || 0;
                });

                document.getElementById('serviceValue').innerText = serviceValue.toFixed(2);


                /* =========================
                   ✅ EXPENSE TOTAL
                ========================== */
                let expenseTotal = 0;

                document.querySelectorAll('.expense').forEach(el => {
                    expenseTotal += parseFloat(el.value) || 0;
                });

                const expenseElement = document.getElementById('expenseTotal');
                if (expenseElement) {
                    expenseElement.innerText = expenseTotal.toFixed(2);
                }


                /* =========================
                   ✅ TAX (ONLY ON SERVICE)
                ========================== */
                let cgst = 0,
                    sgst = 0,
                    igst = 0;

                // CGST + SGST
                if (document.getElementById('cgstAmount')) {

                    cgst = serviceValue * 0.09; // 🔥 NO expense
                    sgst = serviceValue * 0.09; // 🔥 NO expense

                    document.getElementById('cgstAmount').value = cgst.toFixed(2);
                    document.getElementById('sgstAmount').value = sgst.toFixed(2);
                }

                // IGST
                if (document.getElementById('igstAmount')) {

                    igst = serviceValue * 0.18; // 🔥 NO expense

                    document.getElementById('igstAmount').value = igst.toFixed(2);
                }


                /* =========================
                   ✅ GRAND TOTAL
                ========================== */
                const taxTotal = cgst + sgst + igst;
                const grandTotal = serviceValue + expenseTotal + taxTotal;

                document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);


                /* =========================
                   ✅ NET AMOUNT
                ========================== */
                const advance = parseFloat(document.getElementById('advance')?.value) || 0;
                const netAmount = grandTotal - advance;

                // document.getElementById('netAmount').innerText = netAmount.toFixed(2);

                // const amountWords = numberToWords(Math.round(netAmount));

                // document.getElementById('amountInWords').innerText = amountWords;
                // document.getElementById('amountInWordsInput').value = amountWords;

                document.getElementById('netAmount').innerText = parseFloat(netAmount).toFixed(2);

                let amount = parseFloat(netAmount) || 0;

                // Separate rupees and paise properly
                let rupees = Math.floor(amount);
                let paise = Math.round((amount * 100) % 100);

                // Convert to words
                let amountWords = numberToWords(rupees) + " Rupees";

                if (paise > 0) {
                    amountWords += " " + numberToWords(paise) + " Paise";
                }

                // Capitalize first letter
                // amountWords = amountWords.toLowerCase().replace(/^./, c => c.toUpperCase());

                // Set values
                document.getElementById('amountInWords').innerText = amountWords;
                document.getElementById('amountInWordsInput').value = amountWords;


                /* =========================
                   ✅ HIDDEN INPUTS
                ========================== */
                if (typeof serviceValueInput !== "undefined")
                    serviceValueInput.value = serviceValue.toFixed(2);

                if (typeof expenseTotalInput !== "undefined")
                    expenseTotalInput.value = expenseTotal.toFixed(2);

                if (typeof cgstInput !== "undefined")
                    cgstInput.value = cgst.toFixed(2);

                if (typeof sgstInput !== "undefined")
                    sgstInput.value = sgst.toFixed(2);

                if (typeof igstInput !== "undefined")
                    igstInput.value = igst.toFixed(2);

                if (typeof grandTotalInput !== "undefined")
                    grandTotalInput.value = grandTotal.toFixed(2);

                if (typeof netAmountInput !== "undefined")
                    netAmountInput.value = netAmount.toFixed(2);
            }


            /* ==========================
               ADD EXPENSE ROW
            ========================== */
            window.addExpenseRow = function() {

                const template = document.getElementById('hiddenRow');
                if (!template) return;

                const clone = template.cloneNode(true);
                clone.removeAttribute('id');
                clone.style.display = 'table-row';

                clone.querySelectorAll('input').forEach(i => i.value = '');

                const tbody = document.getElementById('expenseBody');

                // 🔥 Find the "B" total row
                const totalRow = tbody.querySelector('#expenseTotal').closest('tr');

                // Insert BEFORE total row
                tbody.insertBefore(clone, totalRow);

                calculateTotals();
            };



            /* ==========================
               INPUT EVENTS (delegated)
            ========================== */
            document.addEventListener('input', function(e) {
                if (
                    e.target.classList.contains('service-amount') ||
                    e.target.classList.contains('expense') ||
                    e.target.id === 'advance'
                ) {
                    calculateTotals();
                }
            });

            /* ==========================
               DELETE EXPENSE ROW
            ========================== */
            document.addEventListener('click', function(e) {

                const deleteBtn = e.target.closest('.delete-row');
                if (!deleteBtn) return;

                const row = deleteBtn.closest('tr');
                const expenseId = deleteBtn.dataset.expenseId;
                const tbody = document.getElementById('expenseBody');

                Swal.fire({
                    title: 'Delete this expense?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete'
                }).then(result => {

                    if (!result.isConfirmed) return;

                    if (expenseId) {
                        fetch('<?= site_url("Expense/delete") ?>', {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    expense_id: expenseId
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    removeRow(row, tbody);
                                } else {
                                    Swal.fire('Error', data.message || 'Delete failed', 'error');
                                }
                            })
                            .catch(() => Swal.fire('Error', 'Server error', 'error'));
                    } else {
                        removeRow(row, tbody);
                    }
                });
            });

            function removeRow(row, tbody) {

                const rows = tbody.querySelectorAll('tr.expense-row:not([style*="display:none"])');

                // if (rows.length <= 1) {
                //     Swal.fire('Warning', 'At least one expense row is required.', 'warning');
                //     return;
                // }

                row.remove();

                tbody.querySelectorAll('tr.expense-row:not([style*="display:none"])')
                    .forEach((tr, i) => tr.cells[0].textContent = i + 1);

                calculateTotals();
            }

            /* ==========================
               FORM SUBMIT (AJAX)
            ========================== */
            form.addEventListener('submit', function(e) {

                e.preventDefault();
                calculateTotals();

                fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form)
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (data.status !== 'success') {
                            Swal.fire('Error', 'Failed to update invoice', 'error');
                            return;
                        }

                        Swal.fire({
                            title: 'Invoice Updated!',
                            icon: 'success',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Print Invoice',
                            denyButtonText: 'Download PDF'
                        }).then(result => {

                            if (result.isConfirmed) {
                                window.open('<?= site_url("invoice/print/") ?>' + data.invoice_id);
                            }
                            if (result.isDenied) {
                                window.open('<?= site_url("invoice/pdf/") ?>' + data.invoice_id, '_blank');
                            }
                        });
                    })
                    .catch(() => Swal.fire('Error', 'Server error', 'error'));
            });

            /* ==========================
               INIT
            ========================== */
            calculateTotals();
        });

        /* ==========================
           NUMBER TO WORDS
        ========================== */
        function numberToWords(num) {
            const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
            const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
            if (num < 10) return ones[num];
            if (num < 20) return ["Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"][num - 10];
            if (num < 100) return tens[Math.floor(num / 10)] + " " + ones[num % 10];
            if (num < 1000) return ones[Math.floor(num / 100)] + " Hundred " + numberToWords(num % 100);
            if (num < 100000) return numberToWords(Math.floor(num / 1000)) + " Thousand " + numberToWords(num % 1000);
            if (num < 10000000) return numberToWords(Math.floor(num / 100000)) + " Lakh " + numberToWords(num % 100000);
            return numberToWords(Math.floor(num / 10000000)) + " Crore " + numberToWords(num % 10000000);
        }
    </script>