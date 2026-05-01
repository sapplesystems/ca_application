<div class="invoiceM-containerr">
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
                <div class="Gvoice-title">Generate Invoice</div>
                <form method="post" action="<?= base_url('invoice-mangement/preview'); ?>">

                <div class="Gvoice-section-title">Choose Client</div>
                <div class="Gvoice-box">
                <?php foreach ($clients as $client): ?>
                    <div class="Gvoice-option-row">
                        <input type="radio" name="client_id"
                            value="<?= $client['id']; ?>"
                            data-state="<?= esc($client['gst_state']); ?>" required>

                        <div><?= esc($client['legal_name']); ?></div>
                    </div>
                <?php endforeach; ?>
                </div>

                <div class="Gvoice-section-title">Choose Work</div>
                <div class="Gvoice-box">
                <?php foreach ($works as $work): ?>
                    <div class="Gvoice-option-row">
                        <input type="checkbox" name="work_ids[]" value="<?= $work['id']; ?>">
                        <?= esc($work['service_name']); ?> (<?= esc($work['sac_code']); ?>)
                    </div>
                <?php endforeach; ?>
                </div>

                <div class="Gvoice-section-title">Choose Company</div>
                <div class="Gvoice-box">
                <?php foreach ($companies as $company): ?>
                    <div class="Gvoice-option-row">
                        <input type="radio" name="company_id"
                            value="<?= $company['id']; ?>"
                            data-state="<?= esc($company['gst_state']); ?>" required>

                        <?= esc($company['name']); ?>
                    </div>
                <?php endforeach; ?>
                </div>

                <div class="Gvoice-section-title">Tax
                <div class="Gvoice-box">
                <label><input type="radio" name="tax" value="cgst_sgst"> CGST & SGST</label>
                <label><input type="radio" name="tax" value="igst"> IGST</label>
                </div>
                </div>

                 <div class="Gvoice-section-title">Add Expenses Recoverable
                    <div class="Gvoice-box">
                <label><input type="checkbox" name="expenses" value="1"> Include Expenses</label>
                </div>
                </div>

                <div class="Gvoice-actions">
                            <button class="Gvoice-btn Gvoice-btn-success">Proceed</button>
                            <button class="Gvoice-btn Gvoice-btn-danger" data-dismiss="modal">Cancel</button>
                </div>

            </form>
            </div>

        </div>
    </div>
</div>
    <div class="invoiceM-toolbar">
        <div class="invoiceM-toolbar-title">Invoice Management</div>
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
    </div>

    <div class="invoice-footer" id="invoice-footer" style="display: none;"> 
    <div id="company-name"><strong>Your Company Name Pvt Ltd</strong></div> 
    <div id="company-address">123 Business Street, City, State - 000000</div> 
    <div id="company-contact">Phone: +91 9876543210 | Email: info@company.com</div>
    <div id="sales"><b>Sales Register</b></div> 
    <div id="date-range">Date: <?= date('d-m-Y') ?></div> 
    </div>

    <div id="searchResultsSection" style="margin-top: 24px; display: none;">
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="background:#0b5c7d; color:#fff;">
                    <th style="padding:8px; border:1px solid #ccc; text-align:left;">Date</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:left;">Invoice No.</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:left;">Party Name</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:left;">GSTIN</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:right;">HSN Code</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:right;">Taxable Amount</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:right;">CGST@9%</th>  
                    <th style="padding:8px; border:1px solid #ccc; text-align:right;">SGST@9%</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:right;">IGST@18%</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:right;">Gross Total</th>
                    <th style="padding:8px; border:1px solid #ccc; text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody id="searchResultsBody"></tbody>
        </table>
        <p id="noSearchResults" style="display:none; margin-top:12px; font-weight:bold;">No matching records found.</p>
    </div>

<button type="button" class=" Minvoice-btn Minvoice-btn-primary" data-toggle="modal"
            data-target="#GenrateVoice">
            Generate Invoice For Pending Work
 </button>

 </div>
 <script>
document.addEventListener('DOMContentLoaded', function () {

    let clientState = null;

    document.querySelectorAll('input[name="client_id"]').forEach(el => {
        el.addEventListener('change', function () {
            clientState = this.dataset.state;
        });
    });

    document.querySelectorAll('input[name="company_id"]').forEach(el => {
        el.addEventListener('change', function () {

            if (!clientState) {
                alert('Select client first');
                return;
            }

            let companyState = this.dataset.state;

            if (clientState === companyState) {
                document.querySelector('input[value="cgst_sgst"]').checked = true;
            } else {
                document.querySelector('input[value="igst"]').checked = true;
            }
        });
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {

        let works = document.querySelectorAll('input[name="work_ids[]"]:checked').length;
        let company = document.querySelector('input[name="company_id"]:checked');
        let client = document.querySelector('input[name="client_id"]:checked');

        if (!client || !company || works === 0) {
            e.preventDefault();
            alert('Select client, company and at least one work');
        }
    });

});

    document.querySelector('.Minvoice-btn-search').addEventListener('click', function(e) {
        e.preventDefault();

        const companySelect = document.getElementById('Minvoice-company');
        const companyId = companySelect.value;
        const fromInput = document.getElementById('Minvoice-fromDate').value;
        const toInput = document.getElementById('Minvoice-toDate').value;
        const searchResultsSection = document.getElementById('searchResultsSection');
        const searchResultsBody = document.getElementById('searchResultsBody');
        const noSearchResults = document.getElementById('noSearchResults');

        searchResultsBody.innerHTML = '';
        noSearchResults.style.display = 'none';

        fetch('<?= base_url('invoice-mangement/search') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                company_id: companyId,
                from_date: fromInput,
                to_date: toInput,
            }),
        })
            .then(response => response.json())
            .then(results => {
                searchResultsSection.style.display = 'block';
                document.getElementById('invoice-footer').style.display = 'block';
                document.getElementById('date-range').innerText = 'Date: ' + formatDisplayDate(fromInput) + ' to ' + formatDisplayDate(toInput);

                if (!Array.isArray(results) || results.length === 0) {
                    noSearchResults.style.display = 'block';
                    return;
                }

                results.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="padding:8px; border:1px solid #ccc;">${formatDate(row.invoice_date)}</td>
                        <td style="padding:8px; border:1px solid #ccc;">${row.invoice_no}</td>
                        <td style="padding:8px; border:1px solid #ccc;">${row.party_name || '-'}</td>
                        <td style="padding:8px; border:1px solid #ccc;">${row.party_gstin || '-'}</td>
                        <td style="padding:8px; border:1px solid #ccc;">${row.hsn_code || '-'}</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(row.service_value || 0).toFixed(2)}</td>
                        ${row.tax_apply_name === 'cgst_sgst' ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(9/100*row.service_value || 0).toFixed(2)}</td>` : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`}
                        ${row.tax_apply_name === 'cgst_sgst' ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(9/100*row.service_value || 0).toFixed(2)}</td>` : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`}
                        ${row.tax_apply_name === 'igst' ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(18/100*row.service_value || 0).toFixed(2)}</td>` : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`}
                        <td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(row.grand_total || 0).toFixed(2)}</td>
                        <td style="padding:8px; border:1px solid #ccc; text-align:center; white-space:nowrap;">
                            <a href="<?= site_url('invoice/edit/') ?>${row.id}" target="_blank" style="margin-right:4px; text-decoration:none; color:#0b5c7d;">✏️ Edit</a>
                            <a href="<?= site_url('invoice/print/') ?>${row.id}" target="_blank" style="margin-right:4px; text-decoration:none; color:#0b5c7d;">👁️ Preview</a>
                            <a href="<?= site_url('invoice/pdf/') ?>${row.id}" target="_blank" style="text-decoration:none; color:#0b5c7d;">⬇️ Download</a>
                        </td>
                    `;
                    searchResultsBody.appendChild(tr);
                });
            })
            .catch(() => {
                searchResultsSection.style.display = 'block';
                noSearchResults.textContent = 'Unable to load search results. Please try again.';
                noSearchResults.style.display = 'block';
            });
    });

    function formatDate(value) {
        if (!value) {
            return '-';
        }
        const date = new Date(value);
        return Number.isNaN(date.getTime()) ? value : date.toLocaleDateString('en-GB');
    }

    function formatDisplayDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const day = date.getDate();
        const month = date.toLocaleString('default', { month: 'long' });
        const year = date.getFullYear();
        return day + '-' + month + '-' + year;
    }

    // Update footer with selected company details
    document.getElementById('Minvoice-company').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const name = selectedOption.getAttribute('data-name') || 'Your Company Name Pvt Ltd';
        const address = selectedOption.getAttribute('data-address') || '123 Business Street, City, State - 000000';
        const phone = selectedOption.getAttribute('data-phone') || '+91 9876543210';
        const email = selectedOption.getAttribute('data-email') || 'info@company.com';
        
        document.getElementById('company-name').innerHTML = '<strong>' + name + '</strong>';
        document.getElementById('company-address').innerText = address;
        document.getElementById('company-contact').innerText = 'Phone: ' + phone + ' | Email: ' + email;
    });

    // Reset button functionality
    document.querySelector('.Minvoice-btn-reset').addEventListener('click', function() {
        document.getElementById('Minvoice-company').value = '';
        document.getElementById('Minvoice-fromDate').value = '';
        document.getElementById('Minvoice-toDate').value = '';
        document.getElementById('searchResultsSection').style.display = 'none';
        document.getElementById('invoice-footer').style.display = 'none';
        document.getElementById('searchResultsBody').innerHTML = '';
        document.getElementById('noSearchResults').style.display = 'none';
        document.getElementById('company-name').innerHTML = '<strong>Your Company Name Pvt Ltd</strong>';
        document.getElementById('company-address').innerText = '123 Business Street, City, State - 000000';
        document.getElementById('company-contact').innerText = 'Phone: +91 9876543210 | Email: info@company.com';
        document.getElementById('sales').innerText = 'Sales Register';
        document.getElementById('date-range').innerText = 'Date: <?= date('d-m-Y') ?>';
    });
</script>