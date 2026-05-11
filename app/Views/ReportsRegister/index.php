<style>
    .search-popup {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        padding: 14px 18px 14px 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.12);
        font-size: 14px;
        min-width: 260px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }
    .search-popup__message {
        flex: 1;
    }
    .search-popup__close {
        cursor: pointer;
        font-weight: bold;
        color: #721c24;
        background: transparent;
        border: none;
        font-size: 18px;
        line-height: 1;
        padding: 0;
    }
</style>
<div class="invoiceM-containerr">
    <div class="invoiceM-toolbar">
        <div class="invoiceM-toolbar-title">Reports & Registers</div>
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
        <div id="company-name"><strong></strong></div>
        <div id="company-address"></div>
        <div id="company-contact"></div>
        <div id="sales"><b>Reports Register</b></div>
        <div id="date-range">Period: <?= date('d-m-Y') ?></div>
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
                    <th style="padding:8px; border:1px solid #ccc; text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody id="searchResultsBody"></tbody>
        </table>
        <p id="noSearchResults" style="display:none; margin-top:12px; font-weight:bold;">No matching records found.</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.Minvoice-btn-search').addEventListener('click', function(e) {
            e.preventDefault();

            const companySelect = document.getElementById('Minvoice-company');
            const companyId = companySelect.value;
            const fromInput = document.getElementById('Minvoice-fromDate').value;
            const toInput = document.getElementById('Minvoice-toDate').value;
            const searchResultsSection = document.getElementById('searchResultsSection');
            const searchResultsBody = document.getElementById('searchResultsBody');
            const noSearchResults = document.getElementById('noSearchResults');

            if (!companyId && !fromInput && !toInput) {
                searchResultsSection.style.display = 'none';
                document.getElementById('invoice-footer').style.display = 'none';
                showSearchPopup('Please select at least one filter before searching.');
                return;
            }

            searchResultsBody.innerHTML = '';
            noSearchResults.style.display = 'none';

            fetch('<?= base_url('reports_registers/search') ?>', {
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
                    document.getElementById('date-range').innerText = 'Period: ' + formatDisplayDate(fromInput) + ' to ' + formatDisplayDate(toInput);

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
                            <td style="padding:8px; border:1px solid #ccc; text-align:right;">${row.hsn_code || '-'}</td>
                            <td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(row.service_value || 0).toFixed(2)}</td>
                            ${row.tax_apply_name === 'cgst_sgst' ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(9/100*row.service_value || 0).toFixed(2)}</td>` : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`}
                            ${row.tax_apply_name === 'cgst_sgst' ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(9/100*row.service_value || 0).toFixed(2)}</td>` : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`}
                            ${row.tax_apply_name === 'igst' ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(18/100*row.service_value || 0).toFixed(2)}</td>` : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`}
                            <td style="padding:8px; border:1px solid #ccc; text-align:right;">${parseFloat(row.grand_total || 0).toFixed(2)}</td>
                            <td style="padding:8px; border:1px solid #ccc; text-align:center; white-space:nowrap;">
                                <a href="<?= site_url('invoice/print/') ?>${row.id}" style="margin-right:4px; text-decoration:none; color:#0b5c7d;">Print & Preview</a>
                                <a href="<?= site_url('invoice/pdf/') ?>${row.id}" style="text-decoration:none; color:#0b5c7d;">Download</a>
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

        function showSearchPopup(message) {
            const existing = document.querySelector('.search-popup');
            if (existing) {
                existing.remove();
            }

            const popup = document.createElement('div');
            popup.className = 'search-popup';
            popup.innerHTML = `
                <div class="search-popup__message">${message}</div>
                <button type="button" class="search-popup__close" aria-label="Close">&times;</button>
            `;

            const closeButton = popup.querySelector('.search-popup__close');
            closeButton.addEventListener('click', () => popup.remove());

            document.body.appendChild(popup);

            setTimeout(() => {
                if (document.body.contains(popup)) {
                    popup.style.opacity = '0';
                    setTimeout(() => popup.remove(), 300);
                }
            }, 4000);
        }

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
            document.getElementById('sales').innerText = 'Reports Register';
            document.getElementById('date-range').innerText = 'Date: <?= date('d-m-Y') ?>';
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

    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();

    return `${day}-${month}-${year}`;
}

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
</script>
