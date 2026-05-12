<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

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
    padding: 14px 18px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.12);
    font-size: 14px;
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

.dropdown-item{
    padding: 10px;
    cursor: pointer;
}

.dropdown-item:hover{
    background: #0d6efd;
    color: #fff;
}
.Minvoice-btn-search{
    background: #16a34a;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-weight: 600;
}

.Minvoice-btn-search:hover{
    background:  #16a34a;
}

.Minvoice-btn-reset{
    background: #f59e0b;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-weight: 600;
}

.Minvoice-btn-reset:hover{
    background: #d97706;
}

</style>


<div class="invoiceM-containerr">

    <div class="invoiceM-toolbar">

        <div class="invoiceM-toolbar-title">
            Reports & Registers
        </div>

        <div class="Minvoice-filter-row">

            <!-- Company Search -->
            <div class="Minvoice-filter-group">

                <label>Select Company</label>

                <div class="dropdown-box">

                    <input 
                        type="text"
                        id="companySearch"
                        class="form-control"
                        placeholder="Search company...">

                    <!-- Dropdown -->
                    <div class="dropdown-list" id="companyDropdown">

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
                <input type="hidden" name="company_id" id="company_id">

            </div>


            <!-- From Date -->
            <div class="Minvoice-filter-group">
                <label for="Minvoice-fromDate">From:</label>
                <input type="date" id="Minvoice-fromDate" class="form-control"/>
            </div>


            <!-- To Date -->
            <div class="Minvoice-filter-group">
                <label for="Minvoice-toDate">To:</label>
                <input type="date" id="Minvoice-toDate" class="form-control"/>
            </div>


            <!-- Buttons -->
            <div class="Minvoice-filter-buttons">
                <button class="Minvoice-btn Minvoice-btn-search btn btn-primary">
                    Search
                </button>

                <button class="Minvoice-btn Minvoice-btn-reset btn btn-secondary">
                    Reset
                </button>
            </div>

        </div>

    </div>


    <!-- Invoice Header -->
    <div class="invoice-footer" id="invoice-footer" style="display:none;">

        <div id="company-name">
            <strong></strong>
        </div>

        <div id="company-address"></div>

        <div id="company-contact"></div>

        <div id="sales">
            <b>Sales Register</b>
        </div>

        <div id="date-range">
            Period: <?= date('d-m-Y') ?>
        </div>

    </div>


    <!-- Results -->
    <div id="searchResultsSection" style="margin-top:24px; display:none;">

        <table style="width:100%; border-collapse: collapse;">

            <thead>

                <tr style="background:#0b5c7d; color:#fff;">

                    <th style="padding:8px; border:1px solid #ccc;">Date</th>

                    <th style="padding:8px; border:1px solid #ccc;">Invoice No.</th>

                    <th style="padding:8px; border:1px solid #ccc;">Party Name</th>

                    <th style="padding:8px; border:1px solid #ccc;">GSTIN</th>

                    <th style="padding:8px; border:1px solid #ccc;">Gross Total</th>

                </tr>

            </thead>

            <tbody id="searchResultsBody"></tbody>

        </table>

        <p id="noSearchResults"
           style="display:none; margin-top:12px; font-weight:bold;">
            No matching records found.
        </p>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('companySearch');
    const dropdown = document.getElementById('companyDropdown');
    const items = document.querySelectorAll('.dropdown-item');


    // Show all companies
    searchInput.addEventListener('click', function () {

        dropdown.style.display = 'block';

        items.forEach(item => {
            item.style.display = 'block';
        });

    });


    // Search filter
    searchInput.addEventListener('keyup', function () {

        let value = this.value.toLowerCase();

        dropdown.style.display = 'block';

        items.forEach(item => {

            let text = item.innerText.toLowerCase();

            if (text.includes(value)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }

        });

    });


    // Select company
    items.forEach(item => {

        item.addEventListener('click', function () {

            searchInput.value = this.dataset.name;

            document.getElementById('company_id').value =
                this.dataset.id;

            // Footer data
            document.getElementById('company-name').innerHTML =
                '<strong>' + this.dataset.name + '</strong>';

            document.getElementById('company-address').innerText =
                this.dataset.address;

            document.getElementById('company-contact').innerText =
                'Ph No.: ' + this.dataset.phone +
                ' | Email-Id: ' + this.dataset.email;

            dropdown.style.display = 'none';

        });

    });


    // Close dropdown outside click
    document.addEventListener('click', function(e){

        if(!e.target.closest('.dropdown-box')){
            dropdown.style.display = 'none';
        }

    });



    // SEARCH BUTTON
    document.querySelector('.Minvoice-btn-search')
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

            showSearchPopup(
                'Please select at least one filter before searching.'
            );

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

            document.getElementById('invoice-footer')
                .style.display = 'block';


            // SHOW DATE RANGE
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
                        ${parseFloat(row.grand_total || 0).toFixed(2)}
                    </td>

                `;

                searchResultsBody.appendChild(tr);

            });

        })

        .catch(() => {

            searchResultsSection.style.display = 'block';

            noSearchResults.style.display = 'block';

            noSearchResults.innerText =
                'Unable to load search results.';

        });

    });



    // RESET BUTTON
    document.querySelector('.Minvoice-btn-reset')
        .addEventListener('click', function() {

        document.getElementById('companySearch').value = '';

        document.getElementById('company_id').value = '';

        document.getElementById('Minvoice-fromDate').value = '';

        document.getElementById('Minvoice-toDate').value = '';

        document.getElementById('searchResultsSection')
            .style.display = 'none';

        document.getElementById('invoice-footer')
            .style.display = 'none';

    });

});



// Popup Message
function showSearchPopup(message) {

    const popup = document.createElement('div');

    popup.className = 'search-popup';

    popup.innerText = message;

    document.body.appendChild(popup);

    setTimeout(() => {

        popup.remove();

    }, 3000);

}



// Table Date Format
function formatDate(value) {

    if (!value) return '-';

    const date = new Date(value);

    return date.toLocaleDateString('en-GB');

}



// Header Date Format
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