<main class="content-wrap">
    <!-- Master Work List screen (active) -->
    <section id="screen-list" class="screen active">
        <div class="card">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Client Master List</div>
                    <div class="topbar-subtitle">Service catalog with SAC, default rate &amp; GST%</div>
                </div>
                <button class="btn" data-toggle="modal" data-target="#addclient">+ Add Client</button>
            </div>

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
                        <td><span class="pill pill-green">Active</span></td>
                        <td>
                            <div class="actions">
                                <button class="action-btn action-edit btn" data-id="<?= $client['id'] ?>">
                                    Edit
                                </button>
                                <button class=" action-btn action-view btn" data-toggle="modal"
                                    data-target="#exampleModal" data-id="<?= $client['id'] ?>">View</button>
                                <button class="action-btn action-deactivate">Deactivate</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Section: General Info</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                            placeholder="Enter legal company name" required>
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
                                    <option value="">Select category</option>
                                    <option value="">Select category</option>
                                    <option value="">Select category</option>
                                </select>
                            </div>
                            <div>
                                <label>Company Sub-Category</label>
                                <select name="company_sub_category" class="select">
                                    <option value="">Select sub-category</option>
                                    <option value="">Select sub-category</option>
                                    <option value="">Select sub-category</option>
                                    <option value="">Select sub-category</option>
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
                        <div>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div </form>

                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>
<!-------model 2 for edit client all data ---->

<div class="modal fade" id="clientEditModal" tabindex="-1" role="dialog" aria-labelledby="editClientLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Section: General Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body" id="editclient">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                $("#clientEditModal").modal('show');
                $("#editclient").html(resp.html);
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Error while loading client');
        }
    });
});
$(document).on('click', '.action-view', function(e) {
    e.preventDefault();
    let clientId = $(this).data('id');

    $.ajax({
        url: '<?= base_url('clients/show') ?>',
        type: 'POST',
        data: {
            client_id: clientId
        },
        dataType: 'json', // tell jQuery to expect JSON
        success: function(resp) {
            if (resp.status === true) {
                $("#viewclient").html(resp.html); // inject HTML
                $('#clientviewModal').modal('show'); // show modal
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
</script>