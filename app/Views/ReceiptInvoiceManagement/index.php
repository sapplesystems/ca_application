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
        padding: 14px 16px;
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
    .dropdown-box{
    position: relative;
    width: 100%;
}

.dropdown-list{
    position: absolute;
    width: 100%;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    max-height: 250px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}

.dropdown-search{
    width: 100%;
    border: none;
    border-bottom: 1px solid #ddd;
    padding: 10px;
    outline: none;
}

.search-input{
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
    outline: none;
}

.dropdown-item{
    padding: 10px;
    cursor: pointer;
}

.dropdown-item:hover{
    background: #0d6efd;
    color: #fff;
}

.selected-company{
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 4px;
    background: #fff;
    cursor: pointer;
    width:200px;
}

</style>
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
                    <input type="text" id="clientSearch" class="search-input" placeholder="Search client...">
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
                    <input type="text" id="workSearch" class="search-input" placeholder="Search work...">
                <?php foreach ($works as $work): ?>
                    <div class="Gvoice-option-row">
                        <input type="checkbox" name="work_ids[]" value="<?= $work['id']; ?>">
                        <?= esc($work['service_name']); ?> (<?= esc($work['sac_code']); ?>)
                    </div>
                <?php endforeach; ?>
                </div>

                <div class="Gvoice-section-title">Choose Company</div>
                <div class="Gvoice-box">
                    <input type="text" id="modalCompanySearch" class="search-input" placeholder="Search company...">
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

<!-- Debit/Credit Note Modal -->
<div class="modal fade" id="noteGenerateModal" tabindex="-1" aria-labelledby="noteGenerateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noteGenerateModalLabel">Generate Note</h5>
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="noteGenerateForm" method="post" action="<?= base_url('debit-note/store') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="note_type" id="note_type_hidden" value="">
                <input type="hidden" name="client_id" id="note_client_id" value="">
                <input type="hidden" name="company_debit" id="note_company_id" value="">
                <div class="modal-body">
                    <div class="debitP">
                        <div class="content">
                            <div class="form-group mb-3">
                                <label><strong>Select Client</strong></label>
                                <input type="text" id="noteClientSearch" class="search-input" placeholder="Search client...">
                                <?php foreach ($clients as $client): ?>
                                <div class="Gvoice-option-row note-client-row">
                                    <label>
                                        <input type="radio" name="note_client_choice" value="<?= $client['id']; ?>">
                                        <?= esc($client['legal_name']); ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group mb-3">
                                <label><strong>Choose Company</strong></label>
                                <input type="text" id="noteCompanySearch" class="search-input" placeholder="Search company...">
                                <?php foreach ($companies as $company): ?>
                                <div class="Gvoice-option-row note-company-row">
                                    <label>
                                        <input type="radio" name="note_company_choice" value="<?= esc($company['id']) ?>">
                                        <?= esc($company['name']) ?> [<?= esc($company['type_of_company']) ?>]
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                             <div class="Gvoice-actions">
                    <button class="Gvoice-btn Gvoice-btn-success">Proceed</button>
                    <button class="Gvoice-btn Gvoice-btn-danger" type="button" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                </div>
                        </div>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
</div>
    <div class="invoiceM-toolbar">
        <div class="invoiceM-toolbar-title">Invoice Management <button type="button" style="float:right;margin-left:5px;" class="Minvoice-btn Minvoice-btn-primary" data-toggle="modal" data-target="#GenrateVoice" data-bs-toggle="modal" data-bs-target="#GenrateVoice">
            Generate Invoice For Pending Work
        </button>
        <button type="button" style="float:right; margin-left:5px;" class="Minvoice-btn Minvoice-btn-primary" data-toggle="modal" data-target="#noteGenerateModal" data-bs-toggle="modal" data-bs-target="#noteGenerateModal" data-note-type="credit">
            Credit Note
        </button>
        <button type="button" style="float:right; margin-left:5px;" class="Minvoice-btn Minvoice-btn-primary" data-toggle="modal" data-target="#noteGenerateModal" data-bs-toggle="modal" data-bs-target="#noteGenerateModal" data-note-type="debit">
            Debit Note
        </button>
        </div>
            <div class="Minvoice-filter-row">
      <div class="Minvoice-filter-group">

    <label>Select Company</label>

    <div class="dropdown-box">

        <!-- Selected Company -->
        <div class="selected-company" id="selectedCompany">
            Select Company
        </div>

        <!-- Dropdown -->
        <div class="dropdown-list" id="companyDropdown">

            <!-- Search Input -->
            <input 
                type="text"
                id="companySearch"
                class="dropdown-search"
                placeholder="Search company...">

            <!-- Company List -->
            <?php foreach ($companies as $company): ?>

                <div 
                    class="dropdown-item"
                    data-id="<?= $company['id']; ?>"
                    data-name="<?= esc($company['name']); ?>"
                    data-address="<?= esc($company['registered_office']); ?>"
                    data-phone="<?= esc($company['telephone']); ?>"
                    data-email="<?= esc($company['email']); ?>">

                    <?= esc($company['name']); ?>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

    <!-- Hidden Input -->
    <input type="hidden" id="company_id" name="company_id">

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
            <button class="Minvoice-btn Minvoice-btn-green">Search</button>
            <button class="Minvoice-btn Minvoice-btn-reset">Reset</button>
        </div>
    </div>
    </div>

    <div class="invoice-footer" id="invoice-footer" style="display: none;"> 
    <div id="company-name"><strong></strong></div> 
    <div id="company-address"></div> 
    <div id="company-contact"></div>
    <div id="sales"><b>Sales Register</b></div> 
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
                    <th style="padding:8px; border:1px solid #ccc; text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody id="searchResultsBody"></tbody>
        </table>
        <p id="noSearchResults" style="display:none; margin-top:12px; font-weight:bold;">No matching records found.</p>
    </div>



 </div>
 <script>

document.addEventListener('DOMContentLoaded', function () {

    // ================================
    // CLIENT + COMPANY TAX LOGIC
    // ================================

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



    // ================================
    // FORM VALIDATION
    // ================================

    document.querySelector('form').addEventListener('submit', function(e) {

        let works =
            document.querySelectorAll('input[name="work_ids[]"]:checked').length;

        let company =
            document.querySelector('input[name="company_id"]:checked');

        let client =
            document.querySelector('input[name="client_id"]:checked');

        if (!client || !company || works === 0) {

            e.preventDefault();

            alert('Select client, company and at least one work');

        }

    });

    const noteTypeButtons = document.querySelectorAll('[data-note-type]');
    const noteTypeHidden = document.getElementById('note_type_hidden');
    const noteClientHidden = document.getElementById('note_client_id');
    const noteCompanyHidden = document.getElementById('note_company_id');
    const noteClientSearch = document.getElementById('noteClientSearch');
    const noteCompanySearch = document.getElementById('noteCompanySearch');
    const noteClientRows = document.querySelectorAll('.note-client-row');
    const noteCompanyRows = document.querySelectorAll('.note-company-row');

    noteTypeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const noteType = this.dataset.noteType || '';
            noteTypeHidden.value = noteType;
            noteClientHidden.value = '';
            noteCompanyHidden.value = '';
            document.getElementById('noteGenerateModalLabel').innerText =
                noteType === 'credit' ? 'Generate Credit Note' : 'Generate Debit Note';
            document.querySelectorAll('input[name="note_client_choice"]').forEach(input => input.checked = false);
            document.querySelectorAll('input[name="note_company_choice"]').forEach(input => input.checked = false);
        });
    });

    document.querySelectorAll('input[name="note_client_choice"]').forEach(input => {
        input.addEventListener('change', function() {
            noteClientHidden.value = this.value;
        });
    });

    document.querySelectorAll('input[name="note_company_choice"]').forEach(input => {
        input.addEventListener('change', function() {
            noteCompanyHidden.value = this.value;
        });
    });

    document.getElementById('noteGenerateForm').addEventListener('submit', function(e) {
        if (!noteTypeHidden.value || !noteClientHidden.value || !noteCompanyHidden.value) {
            e.preventDefault();
            alert('Select note type, client and company before proceeding.');
        }
    });

    noteClientSearch.addEventListener('input', function() {
        const value = this.value.toLowerCase();
        noteClientRows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? 'flex' : 'none';
        });
    });

    noteCompanySearch.addEventListener('input', function() {
        const value = this.value.toLowerCase();
        noteCompanyRows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? 'flex' : 'none';
        });
    });


    // ================================
    // SEARCHABLE COMPANY DROPDOWN
    // ================================

    const selectedCompany =
        document.getElementById('selectedCompany');

    const companyDropdown =
        document.getElementById('companyDropdown');

    const companySearch =
        document.getElementById('companySearch');

    const dropdownItems =
        document.querySelectorAll('.dropdown-item');

    const clientSearch =
        document.getElementById('clientSearch');

    const workSearch =
        document.getElementById('workSearch');

    const modalCompanySearch =
        document.getElementById('modalCompanySearch');

    const clientRows =
        document.querySelectorAll('input[type="radio"][name="client_id"]');

    const workRows =
        document.querySelectorAll('input[type="checkbox"][name="work_ids[]"]');

    const modalCompanyRows =
        document.querySelectorAll('.Gvoice-box input[type="radio"][name="company_id"]');


    // Open dropdown
    selectedCompany.addEventListener('click', function () {

        companyDropdown.style.display =
            companyDropdown.style.display === 'block'
            ? 'none'
            : 'block';

        companySearch.value = '';

        dropdownItems.forEach(item => {

            item.style.display = 'block';

        });

    });



    // Search filter
    companySearch.addEventListener('keyup', function () {

        let value = this.value.toLowerCase();

        dropdownItems.forEach(item => {

            let text = item.innerText.toLowerCase();

            if (text.includes(value)) {

                item.style.display = 'block';

            } else {

                item.style.display = 'none';

            }

        });

    });

    clientSearch.addEventListener('input', function () {
        const value = this.value.toLowerCase();
        clientRows.forEach(input => {
            const row = input.closest('.Gvoice-option-row');
            if (!row) return;
            row.style.display = row.innerText.toLowerCase().includes(value)
                ? 'flex'
                : 'none';
        });
    });

    workSearch.addEventListener('input', function () {
        const value = this.value.toLowerCase();
        workRows.forEach(input => {
            const row = input.closest('.Gvoice-option-row');
            if (!row) return;
            row.style.display = row.innerText.toLowerCase().includes(value)
                ? 'flex'
                : 'none';
        });
    });

    modalCompanySearch.addEventListener('input', function () {
        const value = this.value.toLowerCase();
        modalCompanyRows.forEach(input => {
            const row = input.closest('.Gvoice-option-row');
            if (!row) return;
            row.style.display = row.innerText.toLowerCase().includes(value)
                ? 'flex'
                : 'none';
        });
    });


    // Select company
    dropdownItems.forEach(item => {

        item.addEventListener('click', function () {

            selectedCompany.innerText =
                this.dataset.name;

            document.getElementById('company_id').value =
                this.dataset.id;

            // Footer update
            document.getElementById('company-name').innerHTML =
                '<strong>' + this.dataset.name + '</strong>';

            document.getElementById('company-address').innerText =
                this.dataset.address;

            document.getElementById('company-contact').innerText =
                'Ph No.: ' + this.dataset.phone +
                ' | Email-Id: ' + this.dataset.email;

            companyDropdown.style.display = 'none';

        });

    });



    // Close dropdown outside click
    document.addEventListener('click', function(e){

        if(!e.target.closest('.dropdown-box')){

            companyDropdown.style.display = 'none';

        }

    });




    // ================================
    // SEARCH BUTTON
    // ================================

    document.querySelector('.Minvoice-btn-green')
        .addEventListener('click', function(e) {

        e.preventDefault();

        const companyId =
            document.getElementById('company_id').value;

        const fromInput =
            document.getElementById('Minvoice-fromDate').value;

        const toInput =
            document.getElementById('Minvoice-toDate').value;

        const searchResultsSection =
            document.getElementById('searchResultsSection');

        const searchResultsBody =
            document.getElementById('searchResultsBody');

        const noSearchResults =
            document.getElementById('noSearchResults');



        // Validation
        if (!companyId && !fromInput && !toInput) {

            document.getElementById('searchResultsSection')
                .style.display = 'none';

            document.getElementById('invoice-footer')
                .style.display = 'none';

            showSearchPopup(
                'Please select at least one filter before searching.'
            );

            return;

        }



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

            document.getElementById('invoice-footer')
                .style.display = 'block';



            // DATE RANGE
            document.getElementById('date-range').innerText =
                'Period: ' +
                formatDisplayDate(fromInput) +
                ' to ' +
                formatDisplayDate(toInput);



            if (!Array.isArray(results) || results.length === 0) {

                noSearchResults.style.display = 'block';

                return;

            }



            results.forEach(row => {

                const tr = document.createElement('tr');

                tr.innerHTML = `

                    <td style="padding:8px; border:1px solid #ccc;">
                        ${formatDate(row.invoice_date)}
                    </td>

                    <td style="padding:8px; border:1px solid #ccc;">
                        ${row.invoice_no}
                    </td>

                    <td style="padding:8px; border:1px solid #ccc;">
                        ${row.party_name || '-'}
                    </td>

                    <td style="padding:8px; border:1px solid #ccc;">
                        ${row.party_gstin || '-'}
                    </td>

                    <td style="padding:8px; border:1px solid #ccc;">
                        ${row.hsn_code || '-'}
                    </td>

                    <td style="padding:8px; border:1px solid #ccc; text-align:right;">
                        ${parseFloat(row.service_value || 0).toFixed(2)}
                    </td>

                    ${row.tax_apply_name === 'cgst_sgst'
                        ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">
                                ${parseFloat(9/100*row.service_value || 0).toFixed(2)}
                           </td>`
                        : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`
                    }

                    ${row.tax_apply_name === 'cgst_sgst'
                        ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">
                                ${parseFloat(9/100*row.service_value || 0).toFixed(2)}
                           </td>`
                        : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`
                    }

                    ${row.tax_apply_name === 'igst'
                        ? `<td style="padding:8px; border:1px solid #ccc; text-align:right;">
                                ${parseFloat(18/100*row.service_value || 0).toFixed(2)}
                           </td>`
                        : `<td style="padding:8px; border:1px solid #ccc; text-align:right;">-</td>`
                    }

                    <td style="padding:8px; border:1px solid #ccc; text-align:right;">
                        ${parseFloat(row.grand_total || 0).toFixed(2)}
                    </td>

                    <td style="padding:8px; border:1px solid #ccc; text-align:center; white-space:nowrap;">

                        <a href="<?= site_url('invoice/edit/') ?>${row.id}"
                           style="margin-right:4px; text-decoration:none; color:#0b5c7d;">
                           ✏️ Edit
                        </a>

                        <a href="<?= site_url('invoice/print/') ?>${row.id}"
                           style="margin-right:4px; text-decoration:none; color:#0b5c7d;">
                           👁️ Preview
                        </a>

                        <a href="<?= site_url('invoice/pdf/') ?>${row.id}"
                           style="text-decoration:none; color:#0b5c7d;">
                           ⬇️ Download
                        </a>

                    </td>

                `;

                searchResultsBody.appendChild(tr);

            });

        })

        .catch(() => {

            searchResultsSection.style.display = 'block';

            noSearchResults.textContent =
                'Unable to load search results. Please try again.';

            noSearchResults.style.display = 'block';

        });

    });




    // ================================
    // RESET BUTTON
    // ================================

    document.querySelector('.Minvoice-btn-reset')
        .addEventListener('click', function() {

        document.getElementById('company_id').value = '';

        document.getElementById('companySearch').value = '';

        document.getElementById('selectedCompany').innerText =
            'Select Company';

        document.getElementById('Minvoice-fromDate').value = '';

        document.getElementById('Minvoice-toDate').value = '';

        document.getElementById('searchResultsSection')
            .style.display = 'none';

        document.getElementById('invoice-footer')
            .style.display = 'none';

        document.getElementById('searchResultsBody').innerHTML = '';

        document.getElementById('noSearchResults')
            .style.display = 'none';

    });

});




// ================================
// POPUP
// ================================

function showSearchPopup(message) {

    const existing =
        document.querySelector('.search-popup');

    if (existing) {

        existing.remove();

    }

    const popup =
        document.createElement('div');

    popup.className = 'search-popup';

    popup.innerHTML = `

        <div class="search-popup__message">
            ${message}
        </div>

        <button type="button"
                class="search-popup__close">

            &times;

        </button>

    `;

    popup.querySelector('.search-popup__close')
        .addEventListener('click', () => popup.remove());

    document.body.appendChild(popup);

    setTimeout(() => {

        if (document.body.contains(popup)) {

            popup.remove();

        }

    }, 4000);

}




// ================================
// DATE FORMAT
// ================================

function formatDate(value) {

    if (!value) return '-';

    const date = new Date(value);

    return Number.isNaN(date.getTime())
        ? value
        : date.toLocaleDateString('en-GB');

}



function formatDisplayDate(dateString) {

    if (!dateString) return '';

    const date = new Date(dateString);

    const day =
        String(date.getDate()).padStart(2, '0');

    const month =
        String(date.getMonth() + 1).padStart(2, '0');

    const year =
        date.getFullYear();

    return `${day}-${month}-${year}`;

}

</script>