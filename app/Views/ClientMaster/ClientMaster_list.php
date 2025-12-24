<main class="content-wrap">
    <!-- Master Work List screen (active) -->
    <section id="screen-list" class="screen active">
        <div class="card">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Client Master List</div>
                    <div class="topbar-subtitle">Service catalog with SAC, default rate &amp; GST%</div>
                </div>
                <!-- <button class="btn" data-toggle="modal" data-target="#addclient">+ Add Client</button> -->
                <button class="btn" data-bs-toggle="modal" data-bs-target="#addclient">+ Add Client</button>

            </div>
<?php if ($message = session()->getFlashdata('success')): ?>
    <div id="successPopup"
        style="
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #79e47cff;
            color: #5f5a5aff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 9999;
            font-weight: 500;
            min-width: 250px;
        ">
         <span
            onclick="document.getElementById('successPopup').remove();"
            style="
                position: absolute;
                top: 6px;
                right: 10px;
                cursor: pointer;
                font-size: 18px;
                font-weight: bold;
                color: #000000;
            "
            title="Close"
        >
            &times;
        </span>
        <?= esc($message) ?>
    </div>
    <?php endif; ?>

    <?php if ($msg = session()->getFlashdata('error')): ?>
    <div id="errorPopup"
        style="
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            color: #000000;
            padding: 14px 18px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            z-index: 9999;
            font-weight: 500;
            min-width: 280px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        ">
        
        <span><?= esc($msg) ?></span>

        <button onclick="closeErrorPopup()"
            style="
                background: transparent;
                border: none;
                font-size: 18px;
                cursor: pointer;
                color: #000;
                font-weight: bold;
            ">
            &times;
        </button>
    </div>
    <?php endif; ?>
            <div class="layout-row">
                <div style="flex:1;">
                    <input class="search-input" placeholder="Search by Service Code / Name / SAC..." />
                </div>
                <div style="flex:0 0 260px;display:flex;gap:6px;justify-content:flex-end;">
                    <select class="select-sm">
                        <option>Status: All</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                    <select class="select-sm">
                        <option>Frequency: All</option>
                        <option>One-time</option>
                        <option>Monthly</option>
                        <option>Quarterly</option>
                        <option>Annually</option>
                        <option>Ad-hoc</option>
                    </select>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width:24px;"><input type="checkbox" /></th>
                        <th>Name</th>
                        <th>Trade Name</th>
                        <th>Registration no</th>
                        <th>Registered Office</th>
                        <th>Website</th>
                        <th>Company Category</th>
                        <th>Company Sub‑Category</th>
                        <th>Corporate Office</th>
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($clients)): ?>
                    <?php foreach($clients as $client): ?>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td><?= esc($client['legal_name']) ?></td>
                        <td><?= esc($client['trade_name']) ?></td>
                        <td><?= esc($client['registration_no']) ?></td>
                        <td><?= esc($client['registered_office']) ?></td>
                        <td><?= esc($client['website']) ?></td>
                        <td><span class="pill pill-green"><?= esc($client['company_category']) ?></span></td>
                        <td><?= esc($client['company_sub_category']) ?></td>
                        <td><?= esc($client['corporate_office']) ?></td>
                        <td>

                            <div class="toggle <?= $client['status'] == 0 ? 'inactive' : '' ?>"
                                data-id="<?= $client['id'] ?>">
                                <div class="toggle-circle"></div>
                            </div>
                        </td>
                        <td>
                            <div class="actions">
                                <button class="action-btn action-edit btn" data-id="<?= $client['id'] ?>">
                                    Edit
                                </button>
                                <button class=" action-btn action-view btn" data-toggle="modal"
                                    data-target="#exampleModal" data-id="<?= $client['id'] ?>">View</button>
                                <!-- <button class="action-btn action-deactivate">Deactivate</button> -->
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="11">No clients found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>

            </table>

            <div class="table-footer">
                <div>Showing 1–10 of 10 services</div>
                <div class="pagination">
                    <div class="page-btn">&laquo;</div>
                    <div class="page-btn active">1</div>
                    <div class="page-btn">&raquo;</div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal1  for add client all data-->
<div class="modal fade" id="addclient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Client </h5>

                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>



            </div>
            <div class="modal-body ">
                <div class="clientm">
                    <form method="post" action="<?= site_url('clients/store') ?>" enctype="multipart/form-data">

                        <div class="form-grid">

                            <!-- CIN / Legal Name / Trade Name -->
                            <div class="form-row-full">
                                <div class="input-group">
                                    <div style="flex:0 0 28%;">
                                        <label>CIN No</label>
                                        <input type="text" name="cin_no" class="input"
                                            placeholder="Enter CIN (optional)">
                                    </div>
                                    <div style="flex:1">
                                        <label>Name (Legal) <span class="req">*</span></label>
                                        <input type="text" name="legal_name" class="input"
                                            placeholder="Enter legal company name">
                                    </div>
                                    <div style="flex:0 0 28%;">
                                        <label>Trade Name (Alias)</label>
                                        <input type="text" name="trade_name" class="input"
                                            placeholder="Enter trade name">
                                    </div>
                                </div>
                            </div>

                            <!-- ROC / Reg No -->
                            <div>
                                <label>ROC Code</label>
                                <input type="text" name="roc_code" class="input" placeholder="Enter ROC code">
                            </div>
                            <div>
                                <label>Registration No</label>
                                <input type="text" name="registration_no" class="input"
                                    placeholder="Enter registration number">
                            </div>

                            <!-- Date / Certificate -->
                            <div>
                                <label>Date of Incorporation</label>
                                <input type="date" name="date_of_incorporation" class="input">
                            </div>
                            <div>
                                <label>Certificate of Incorporation</label>
                                <div class="file-input">
                                    <label class="btn-upload">
                                        Upload Certificate
                                        <input type="file" name="coi">
                                    </label>
                                    <span class="muted">PDF / Image, max 5 MB</span>
                                </div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label>Company Category</label>
                                <select name="company_category" class="select">
                                    <option value="">Select category</option>
                                    <option value="Private Limited">Private Limited</option>
                                    <option value="Public Limited">Public Limited</option>
                                    <option value="LLP">LLP</option>
                                    <option value="Partnership">Partnership</option>
                                </select>
                            </div>
                            <div>
                                <label>Company Sub-Category</label>
                                <select name="company_sub_category" class="select">
                                    <option value="">Select sub-category</option>
                                    <option value="Small">Small</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Large">Large</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="form-row-full">
                                <label>Registered Office</label>
                                <textarea name="registered_office" class="textarea"></textarea>
                            </div>
                            <div class="form-row-full">
                                <label>Corporate Office</label>
                                <textarea name="corporate_office" class="textarea"></textarea>
                            </div>

                            <!-- Contact -->
                            <div>
                                <label>Tel No</label>
                                <input type="text" name="telephone" class="input">
                            </div>
                            <div>
                                <label>Fax No</label>
                                <input type="text" name="fax" class="input">
                            </div>
                            <div class="form-row-full">
                                <label>Website</label>
                                <input type="text" name="website" class="input">
                            </div>

                            <!-- Share capital -->
                            <div>
                                <label>Authorised Share Capital</label>
                                <input type="text" name="authorised_share_capital" class="input">
                            </div>
                            <div>
                                <label>Number of Shares</label>
                                <input type="number" name="number_of_shares" class="input">
                            </div>
                            <div>
                                <label>Face Value</label>
                                <input type="text" name="face_value" class="input">
                            </div>
                            <div>
                                <label>Paid-up Share Capital</label>
                                <input type="text" name="paid_up_share_capital" class="input">
                            </div>

                            <!-- PAN / GST / ESI -->
                            <div>
                                <label>PAN</label>
                                <input type="text" name="pan" class="input">
                            </div>
                            <div>
                                <label>GSTIN</label>
                                <input type="text" name="gstin" class="input">
                            </div>
                            <div>
                                <label>ESI Number</label>
                                <input type="text" name="esi_no" class="input">
                            </div>

                            <!-- IEC / Bank -->
                            <div>
                                <label>Export & Import Code</label>
                                <input type="text" name="iec_code" class="input">
                            </div>
                            <div class="form-row-full">
                                <label>Bank Account Number</label>
                                <input type="text" name="bank_account_no" class="input">
                            </div>

                            <!-- Directors -->
                            <div>
                                <label>Number of Directors / Shareholders</label>
                                <input type="number" name="directors_count" class="input">
                            </div>
                            <div class="form-row-full">
                                <label>Name of Subsidiary / Sister Concern</label>
                                <input type="text" name="subsidiary_names" class="input">
                            </div>

                            <!-- Business -->
                            <div class="form-row-full">
                                <label>Nature of Business</label>
                                <textarea name="nature_of_business" class="textarea"></textarea>
                            </div>
                            <div>
                                <label>Nature of Service</label>
                                <textarea name="nature_of_service" class="textarea"></textarea>
                            </div>
                            <div>
                                <label>Nature of Product</label>
                                <textarea name="nature_of_product" class="textarea"></textarea>
                            </div>

                            <!-- Billing -->
                            <div class="form-row-full">
                                <label>Billing Emails</label>
                                <input type="email" name="billing_emails" class="input">
                            </div>
                            <div>
                                <label>Payment Terms</label>
                                <select name="payment_terms" class="select">
                                    <option value="">Select terms</option>
                                    <option value="Net 7">Net 7</option>
                                    <option value="Net 15">Net 15</option>
                                    <option value="Net 30">Net 30</option>
                                </select>
                            </div>

                        </div>
                        <div class="cmg-footer" style="margin-top:10px">
                            <button type=" submit" class="btn btn-primary" style="margin-top:10px">Add Client</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<!-------model 2 for edit client all data ---->

<div class="modal fade" id="clientEditModal" tabindex="-1" role="dialog" aria-labelledby="editClientLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body" id="editclient">

            </div>

        </div>
    </div>
</div>

<!-------model 3 for view client all data ---->
<div class="modal fade" id="clientviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewclient">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"> </script>
<script>
// ================== ADD CLIENT ==================
let clientAddModal = new bootstrap.Modal(document.getElementById('addclient'));
let clientEditModal = new bootstrap.Modal(document.getElementById('clientEditModal'));

// ADD form submit
$('#addclient form').on('submit', function(e) {
    e.preventDefault();

    // Clear previous errors (sirf Add modal ke andar)
    $('#addclient .text-danger').remove();
    $('#addclient input, #addclient select, #addclient textarea').css('border', '');

    let isValid = true;
    let firstErrorField = null;

    const requiredFields = [{
            name: 'legal_name',
            msg: 'Legal name is required'
        },
        {
            name: 'registration_no',
            msg: 'Registration number is required'
        },
        {
            name: 'company_category',
            msg: 'Please select company category'
        },
        {
            name: 'company_sub_category',
            msg: 'Please select sub-category'
        },
        {
            name: 'registered_office',
            msg: 'Registered office is required'
        },
        {
            name: 'corporate_office',
            msg: 'Corporate office is required'
        },
        {
            name: 'telephone',
            msg: 'Telephone number is required'
        },
        {
            name: 'fax',
            msg: 'Fax number is required'
        },
        {
            name: 'website',
            msg: 'Website is required'
        },
        {
            name: 'authorised_share_capital',
            msg: 'Authorised share capital is required'
        },
        {
            name: 'number_of_shares',
            msg: 'Number of shares is required'
        },
        {
            name: 'face_value',
            msg: 'Face value is required'
        },
        {
            name: 'paid_up_share_capital',
            msg: 'Paid-up share capital is required'
        },
        {
            name: 'pan',
            msg: 'PAN is required'
        },
        {
            name: 'gstin',
            msg: 'GSTIN is required'
        },
        {
            name: 'esi_no',
            msg: 'ESI Number is required'
        },
        {
            name: 'iec_code',
            msg: 'Export & Import Code is required'
        },
        {
            name: 'bank_account_no',
            msg: 'Bank Account Number is required'
        },
        {
            name: 'directors_count',
            msg: 'Number of Directors/Shareholders is required'
        },
        {
            name: 'subsidiary_names',
            msg: 'Name of Subsidiary/Sister Concern is required'
        },
        {
            name: 'nature_of_business',
            msg: 'Nature of Business is required'
        },
        {
            name: 'nature_of_service',
            msg: 'Nature of Service is required'
        },
        {
            name: 'nature_of_product',
            msg: 'Nature of Product is required'
        },
        {
            name: 'billing_emails',
            msg: 'Billing Emails is required'
        },
        {
            name: 'payment_terms',
            msg: 'Please select payment terms'
        },
        {
            name: 'roc_code',
            msg: 'ROC Code is required'
        },
        {
            name: 'cin_no',
            msg: 'CIN No is required'
        },
        {
            name: 'trade_name',
            msg: 'Trade Name is required'
        },
        {
            name: 'date_of_incorporation',
            msg: 'Date of Incorporation is required'
        }
    ];

    requiredFields.forEach(function(field) {
        let $input = $('#addclient [name="' + field.name + '"]');
        if ($input.length === 0) return;

        let value = ($input.val() || '').trim();

        if (!value) {
            let wrapper =
                $input.closest('.input-group').length ? $input.closest('.input-group') :
                $input.closest('.form-row-full').length ? $input.closest('.form-row-full') :
                $input.closest('div').length ? $input.closest('div') :
                $input.parent();

            $input.css('border', '1px solid red');
            wrapper.find('.text-danger').remove();
            wrapper.append(
                '<div class="text-danger" style="font-size:12px;margin-top:4px;">' +
                field.msg +
                '</div>'
            );

            if (!firstErrorField) firstErrorField = $input;
            isValid = false;
        }
    });

    if (!isValid && firstErrorField) {
        $('html, body').animate({
            scrollTop: firstErrorField.offset().top - 150
        }, 500);
        firstErrorField.focus();
        return false;
    }

    const $btn = $(this).find('button[type="submit"]');
    $btn.prop('disabled', true).text('Saving...');
    setTimeout(() => {
        this.submit(); // normal PHP clients/store
    }, 300);
});

// Add Client button
$('#addclient').on('show.bs.modal', function() {
    const $form = $('#addclient form');
    $form[0].reset();
    $('#addclient .text-danger').remove();
    $('#addclient input, #addclient select, #addclient textarea').css('border', '');
});

// Add modal close
$('#addclient').on('hidden.bs.modal', function() {
    $('#addclient .text-danger').remove();
    $('#addclient input, #addclient select, #addclient textarea').css('border', '');
});


// ================== EDIT CLIENT ==================

// Edit validation helper
function validateEditClientForm($form) {
    $form.find('.text-danger').remove();
    $form.find('input, select, textarea').css('border', '');

    let isValid = true;
    let firstErrorField = null;

    const requiredFields = [{
            name: 'legal_name',
            msg: 'Legal name is required'
        },
        {
            name: 'registration_no',
            msg: 'Registration number is required'
        },
        {
            name: 'company_category',
            msg: 'Please select company category'
        },
        {
            name: 'company_sub_category',
            msg: 'Please select sub-category'
        },
        {
            name: 'registered_office',
            msg: 'Registered office is required'
        },
        {
            name: 'corporate_office',
            msg: 'Corporate office is required'
        },
        {
            name: 'telephone',
            msg: 'Telephone number is required'
        },
        {
            name: 'fax',
            msg: 'Fax number is required'
        },
        {
            name: 'website',
            msg: 'Website is required'
        },
        {
            name: 'authorised_share_capital',
            msg: 'Authorised share capital is required'
        },
        {
            name: 'number_of_shares',
            msg: 'Number of shares is required'
        },
        {
            name: 'face_value',
            msg: 'Face value is required'
        },
        {
            name: 'paid_up_share_capital',
            msg: 'Paid-up share capital is required'
        },
        {
            name: 'pan',
            msg: 'PAN is required'
        },
        {
            name: 'gstin',
            msg: 'GSTIN is required'
        },
        {
            name: 'esi_no',
            msg: 'ESI Number is required'
        },
        {
            name: 'iec_code',
            msg: 'Export & Import Code is required'
        },
        {
            name: 'bank_account_no',
            msg: 'Bank Account Number is required'
        },
        {
            name: 'directors_count',
            msg: 'Number of Directors/Shareholders is required'
        },
        {
            name: 'subsidiary_names',
            msg: 'Name of Subsidiary/Sister Concern is required'
        },
        {
            name: 'nature_of_business',
            msg: 'Nature of Business is required'
        },
        {
            name: 'nature_of_service',
            msg: 'Nature of Service is required'
        },
        {
            name: 'nature_of_product',
            msg: 'Nature of Product is required'
        },
        {
            name: 'billing_emails',
            msg: 'Billing Emails is required'
        },
        {
            name: 'payment_terms',
            msg: 'Please select payment terms'
        },
        {
            name: 'roc_code',
            msg: 'ROC Code is required'
        },
        {
            name: 'cin_no',
            msg: 'CIN No is required'
        },
        {
            name: 'trade_name',
            msg: 'Trade Name is required'
        },
        {
            name: 'date_of_incorporation',
            msg: 'Date of Incorporation is required'
        }
    ];

    requiredFields.forEach(function(field) {
        let $input = $form.find('[name="' + field.name + '"]');
        if ($input.length === 0) return;

        let value = ($input.val() || '').trim();

        if (!value) {
            let wrapper =
                $input.closest('.input-group').length ? $input.closest('.input-group') :
                $input.closest('.form-row-full').length ? $input.closest('.form-row-full') :
                $input.closest('div').length ? $input.closest('div') :
                $input.parent();

            $input.css('border', '1px solid red');
            wrapper.find('.text-danger').remove();
            wrapper.append(
                '<div class="text-danger" style="font-size:12px;margin-top:4px;">' +
                field.msg +
                '</div>'
            );

            if (!firstErrorField) firstErrorField = $input;
            isValid = false;
        }
    });

    if (!isValid && firstErrorField) {
        $('html, body').animate({
            scrollTop: firstErrorField.offset().top - 150
        }, 500);
        firstErrorField.focus();
    }

    return isValid;
}

// Edit button -> load form + bind validation
$(document).on('click', '.action-edit', function(e) {
    e.preventDefault();
    let clientId = $(this).data('id');

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            "clientid": clientId,
            "editClient": "editClient"
        },
        success: function(data) {
            let resp = JSON.parse(data);
            if (resp.status == true) {
                $('#editclient').html(resp.html);
                clientEditModal.show();

                // Submit handler for injected form
                $('#editClientForm').on('submit', function(e) {
                    e.preventDefault();
                    const $form = $(this);

                    if (!validateEditClientForm($form)) {
                        return false;
                    }

                    const $btn = $form.find('button[type="submit"]');
                    $btn.prop('disabled', true).text('Updating...');
                    setTimeout(() => {
                        this.submit(); // normal PHP clients/update
                    }, 300);
                });
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Error while loading client');
        }
    });
});

// Edit modal close
$('#clientEditModal').on('hidden.bs.modal', function() {
    $('#editclient').html('');
});


// ================== VIEW CLIENT ==================
$(document).on('click', '.action-view', function(e) {
    e.preventDefault();
    let clientId = $(this).data('id');

    $.ajax({
        url: '<?= base_url("clients/show") ?>',
        type: 'POST',
        data: {
            client_id: clientId
        },
        dataType: 'json',
        success: function(resp) {
            if (resp.status === true) {
                $('#viewclient').html(resp.html);
                $('#clientviewModal').modal('show');
            } else {
                alert(resp.message || 'No data found for this client');
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Error while loading client');
        }
    });
});


// ================== STATUS TOGGLE ==================
document.querySelectorAll('.toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
        this.classList.toggle('inactive');
        const status = this.classList.contains('inactive') ? 0 : 1;
        const id = this.dataset.id;

        fetch("<?= base_url('client/update-status') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({
                    id: id,
                    status: status
                })
            })
            .then(res => res.json())
           .then(data => {

    // Remove existing popup if any
    document.getElementById('successPopup')?.remove();
    document.getElementById('errorPopup')?.remove();

    const popup = document.createElement('div');
    popup.id = data.status ? 'successPopup' : 'errorPopup';

    popup.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: ${data.status ? '#79e47cff' : '#f44336'};
        color: #000;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        z-index: 9999;
        font-weight: 500;
        min-width: 260px;
    `;

    popup.innerHTML = `
        <span
            style="
                position:absolute;
                top:6px;
                right:10px;
                cursor:pointer;
                font-size:18px;
                font-weight:bold;
            "
            onclick="this.parentElement.remove()"
        >&times;</span>
        ${data.message}
    `;

    document.body.appendChild(popup);

    // Auto remove after 10 seconds
    setTimeout(() => popup.remove(), 10000);
})
            .catch(err => console.error(err));
    });
});
 setTimeout(function () {
            const popup = document.getElementById('successPopup');
            if (popup) {
                popup.style.transition = 'opacity 0.5s ease';
                popup.style.opacity = '0';
                setTimeout(() => popup.remove(), 500);
            }
        }, 10000); 
         function closeErrorPopup() {
            const popup = document.getElementById('errorPopup');
            if (popup) popup.remove();
        }

        // Auto hide after 10 seconds
        setTimeout(closeErrorPopup, 10000);
</script>