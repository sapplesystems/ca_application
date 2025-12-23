    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php base_url();?>public/assets/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    </head>

    <body>
        <main class="content-wrap">
            <!-- Master Work List screen (active) -->
            <section id="screen-list" class="screen active">
                <div class="card">
                    <div class="topbar">
                        <div>
                            <div class="topbar-title">Company Master List</div>
                            <div class="topbar-subtitle">Service catalog with SAC, default rate &amp; GST%</div>
                        </div>
                        <button class="btn" onclick="openServicePopup(0)" data-toggle="modal"
                            data-target="#staticBackdrop">+ Add Company</button>
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

                    <table id="example">
                        <thead>
                            <tr>
                                <th><input type="checkbox" /></th>
                                <th>Type of Company</th>
                                <th>Name</th>
                                <th>Date of Incorp.</th>
                                <th>Registered Office</th>
                                <th>Head Office</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($companies)): ?>
                            <?php foreach ($companies as $row): ?>
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><?= esc($row['type_of_company']) ?></td>
                                <td><?= esc($row['name']) ?></td>
                                <td><?= esc($row['date_of_incorp']) ?></td>
                                <td><?= esc($row['registered_office']) ?></td>
                                <td><?= esc($row['head_office']) ?></td>
                                <td><?= esc($row['email']) ?></td>
                                <td>

                                    <div class="toggle <?= $row['status'] == 0 ? 'inactive' : '' ?>"
                                        data-id="<?= $row['id'] ?>">
                                        <div class="toggle-circle"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn action-edit" data-id="<?= $row['id'] ?>"
                                            data-target="#editcompanymaster" data-toggle="modal">
                                            Edit
                                        </button>
                                        <button class="action-btn action-view" data-id="<?= $row['id'] ?>"> view
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="9">No companies found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>

                    <div class=" table-footer">
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


        <!-- Modal 1 for add company master -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content cmg-shell">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Company Master</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form class="cmg-form" method="POST" action="<?= base_url('company-master/store'); ?>"
                            enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="cmg-grid">

                                <!-- Type of Company -->
                                <div class="cmg-field">
                                    <label class="cmg-label">
                                        Type of Company <span class="cmg-required">*</span>
                                    </label>
                                    <select class="cmg-select" name="company_type">
                                        <option value="Consultancy Master">Consultancy Master</option>
                                        <option value="Charted Account Master">Charted Account Master</option>
                                    </select>
                                </div>

                                <!-- Name -->
                                <div class="cmg-field cmg-field--full">
                                    <label class="cmg-label">
                                        Name <span class="cmg-required">*</span>
                                    </label>
                                    <input type="text" class="cmg-input" placeholder="Enter company name" name="name">
                                </div>

                                <!-- Date of Incorporation -->
                                <div class="cmg-field">
                                    <label class="cmg-label">Date of Incorporation</label>
                                    <input type="date" class="cmg-input" name="date_of_incorporation">
                                </div>

                                <!-- Category -->
                                <div class="cmg-field">
                                    <label class="cmg-label">Category</label>
                                    <input type="text" class="cmg-input" name="category" placeholder="Enter category">
                                </div>

                                <!-- Registered Office -->
                                <div class="cmg-field cmg-field--full">
                                    <label class="cmg-label">Registered Office</label>
                                    <textarea class="cmg-textarea" name="registered_office"
                                        placeholder="Enter registered office address"></textarea>
                                </div>

                                <!-- Head Office -->
                                <div class="cmg-field cmg-field--full">
                                    <label class="cmg-label">Head Office</label>
                                    <textarea class="cmg-textarea" name="head_office"
                                        placeholder="Enter head office address (if different)"></textarea>
                                </div>

                                <!-- condition and terms-->
                                <div class="cmg-field cmg-field--full">
                                    <label class="cmg-label">Condition And Terms</label>
                                    <textarea class="cmg-textarea" name="condition_and_terms"
                                        placeholder="Enter condition and terms"></textarea>
                                </div>

                                <!-- Email / Tel / Website -->
                                <div class="cmg-field">
                                    <label class="cmg-label">Email</label>
                                    <input type="email" class="cmg-input" name="email" placeholder="info@company.com">
                                </div>

                                <div class="cmg-field">
                                    <label class="cmg-label">Phone / Tel</label>
                                    <input type="text" class="cmg-input" name="phone" placeholder="+91-9876543210">
                                </div>

                                <div class="cmg-field">
                                    <label class="cmg-label">Website</label>
                                    <input type="text" class="cmg-input" name="website" placeholder="www.company.com">
                                </div>

                                <!-- Invoice Format -->
                                <div class="cmg-field cmg-field--full">
                                    <label class="cmg-label">Invoice Format</label>
                                    <input type="text" class="cmg-input" name="invoice_format"
                                        placeholder="e.g. ORG/BRANCH/FY/SEQ">
                                    <p class="cmg-help-text">
                                        Define how invoice numbers will be generated (e.g. ORG/BRANCH/FY/SEQ).
                                    </p>
                                </div>

                                <!-- PAN / GSTIN / IEC -->
                                <div class="cmg-field">
                                    <label class="cmg-label">PAN</label>
                                    <input type="text" class="cmg-input" name="pan" placeholder="ABCDE1234F">
                                </div>

                                <div class="cmg-field">
                                    <label class="cmg-label">GSTIN</label>
                                    <input type="text" class="cmg-input" name="gstin" placeholder="22ABCDE1234F1ZS">
                                </div>

                                <div class="cmg-field">
                                    <label class="cmg-label">IEC</label>
                                    <input type="text" class="cmg-input" name="iec" placeholder="Import Export Code">
                                </div>

                                <!-- Sister Concerns -->
                                <div class="cmg-field cmg-field--full">
                                    <label class="cmg-label">Sister Concerns</label>
                                    <textarea class="cmg-textarea" name="sister_concerns"
                                        placeholder="List sister concerns, one per line"></textarea>
                                </div>


                                <!-- Branches (List) - UPDATED CLEAN UI -->
                                <div class="cmg-field cmg-field--full">
                                    <label class="cmg-label">Branches (List)</label>

                                    <div class="cmg-branches">

                                        <div class="cmg-branches__header">
                                            <span>Branches</span>
                                            <button type="button" class="cmg-btn cmg-btn--ghost cmg-btn--small"
                                                id="addBranchBtn">
                                                + Add Branch
                                            </button>
                                        </div>

                                        <div id="branchesList">

                                            <!-- Default Branch -->
                                            <div class="cmg-branches__item">
                                                <div class="cmg-branches__item-main">

                                                    <div class="cmg-branches__row">
                                                        <div class="cmg-branches__field">
                                                            <input type="text" class="cmg-input"
                                                                name="branches[__i__][name]" placeholder="Branch name">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <input type="text" class="cmg-input"
                                                                name="branches[__i__][phone]" placeholder="Phone">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <input type="email" class="cmg-input"
                                                                name="branches[__i__][email]" placeholder="Email">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <textarea class="cmg-input" name="branches[__i__][address]"
                                                                placeholder="Address"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="cmg-branches__item-actions">
                                                    <button type="button"
                                                        class="cmg-btn cmg-btn--tiny cmg-btn--danger btn-branch-delete">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Hidden Template -->
                                        <template id="branchTemplate">
                                            <div class="cmg-branches__item">
                                                <div class="cmg-branches__item-main">

                                                    <div class="cmg-branches__row">
                                                        <div class="cmg-branches__field">
                                                            <input type="text" class="cmg-input"
                                                                name="branches[__i__][name]" placeholder="Branch name">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <input type="text" class="cmg-input"
                                                                name="branches[__i__][phone]" placeholder="Phone">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <input type="email" class="cmg-input"
                                                                name="branches[__i__][email]" placeholder="Email">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <textarea class="cmg-input" name="branches[__i__][address]"
                                                                placeholder="Address"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="cmg-branches__item-actions">
                                                    <button type="button"
                                                        class="cmg-btn cmg-btn--tiny cmg-btn--danger btn-branch-delete">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </template>


                                    </div>

                                    <p class="cmg-help-text">
                                        Use “Add Branch” to add multiple branches; click “Delete” to remove a branch.
                                    </p>
                                </div>


                                <!-- Bank Account -->
                                <div class="cmg-field">
                                    <label class="cmg-label">Bank Account</label>
                                    <input type="text" class="cmg-input" name="bank_account"
                                        placeholder="23456789012345">
                                    <p class="cmg-help-text">
                                        Select default bank account for this company.
                                    </p>

                                </div>

                                <!-- Logo Upload -->
                                <div class="cmg-field">
                                    <label class="cmg-label">Logo Upload</label>
                                    <div class="cmg-upload">
                                        <label class="cmg-btn cmg-btn--primary cmg-btn--small">
                                            ⬆ Upload Logo
                                            <input type="file" name="logo" class="cmg-upload__input">
                                        </label>
                                        <span class="cmg-upload__text">No file chosen</span>
                                    </div>
                                    <p class="cmg-help-text">
                                        Recommended size: 200x200px, Max file size: 2MB.
                                    </p>
                                </div>

                                <!-- Business -->
                                <div class="form-row-full">
                                    <label class="cmg-label">Nature of Business</label>
                                    <textarea name="nature_of_business" class="cmg-textarea"></textarea>
                                </div>
                                <div>
                                    <label class="cmg-label">Nature of Service</label>
                                    <textarea name="nature_of_service" class="cmg-textarea"></textarea>
                                </div>
                                <div class="cmg-field--full">
                                    <label class="cmg-label">Nature of Product</label>
                                    <textarea name="nature_of_product" class="cmg-textarea"></textarea>
                                </div>

                            </div>

                            <!-- Footer buttons -->
                            <div class="cmg-footer">
                                <button type="button" class="cmg-btn cmg-btn--ghost" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="cmg-btn cmg-btn--primary">
                                    Save Company
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!---- modal 2 for edit company master ----->
        <div class="modal fade" id="editcompanymaster" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content cmg-shell">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit CompanyMaster</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" id="editcompany">

                    </div>

                </div>
            </div>
        </div>
        <!-- modal3 for view the comapny master -->
        <div class="modal fade" id="viewCompanyModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Company Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="viewCompanyBody">
                        <!-- DETAILS WILL LOAD HERE -->
                    </div>

                </div>
            </div>
        </div>


        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('addBranchBtn');
            const branchesList = document.getElementById('branchesList');
            const branchTpl = document.getElementById('branchTemplate');

            if (!addBtn || !branchesList || !branchTpl) return;

            let index = branchesList.children.length;

            addBtn.addEventListener('click', function() {
                const clone = branchTpl.content.cloneNode(true);
                const item = clone.querySelector('.cmg-branches__item');

                item.innerHTML = item.innerHTML.replace(/__i__/g, index);
                index++;

                branchesList.appendChild(item);
            });


            branchesList.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-branch-delete')) {
                    e.target.closest('.cmg-branches__item').remove();
                }
            });
        });
        let branchIndex;

        $(document).on('click', '#editBranchBtn', function() {
            console.log('Add clicked');

            const branchesList = document.getElementById('branchesLists');
            const branchTpl = document.getElementById('branchTemplate');

            console.log('branchesList:', branchesList);
            console.log('branchTemplate:', branchTpl);

            if (!branchesList || !branchTpl) {
                console.error('Missing branchesList or branchTemplate');
                return;
            }

            if (branchIndex === undefined) {
                branchIndex = branchesList.children.length;
            }

            const clone = branchTpl.content.cloneNode(true);
            const item = clone.querySelector('.cmg-branches__item');

            console.log('cloned item:', item);

            if (!item) {
                console.error('cmg-branches__item not found in template');
                return;
            }

            item.innerHTML = item.innerHTML.replace(/__i__/g, branchIndex);
            branchIndex++;

            branchesList.appendChild(item);
            console.log('Appended successfully');
        });

        // DELETE BRANCH (delegated)
        $(document).on('click', '.btn-branch-delete', function() {
            $(this).closest('.cmg-branches__item').remove();
        });



        $(document).on('click', '.action-edit', function(e) {
            e.preventDefault();
            let companyId = $(this).data('id');
            $.ajax({
                url: window.location.href,
                type: 'POST',
                dataType: 'json',
                data: {
                    "companyid": companyId,
                    "editCompany": "editCompany"
                },
                success: function(data) {
                    if (data.status == true) {
                        $("#editcompanymaster").modal('show');
                        $("#editcompany").html(data.html);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error while loading company data.');
                }
            });
        });

        $(document).on('click', '.action-view', function() {

            let companyId = $(this).data('id');

            $.ajax({
                url: '<?= base_url('company-master/show') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    companyid: companyId,
                    viewCompany: true
                },
                success: function(resp) {
                    if (resp.status === true) {
                        $('#viewCompanyBody').html(resp.html);
                        $('#viewCompanyModal').modal('show');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error loading company details');
                }
            });
        });
        $(function() {
            // Jab bhi koi modal band ho, backdrop clean karo
            $('#staticBackdrop, #editcompanymaster, #viewCompanyModal')
                .on('hidden.bs.modal', function() {
                    $('.modal-backdrop').remove(); // backdrop hatao
                    $('body').removeClass('modal-open'); // body se class hatao
                    $('body').css('overflow', ''); // scroll normal
                });
        });
        document.querySelectorAll('.toggle').forEach(toggle => {

            toggle.addEventListener('click', function() {

                this.classList.toggle('inactive');

                const status = this.classList.contains('inactive') ? 0 : 1;

                const id = this.dataset.id;



                fetch("<?= base_url('/company-master/update-status') ?>", {
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
                    .then(res => res.text())
                    .then(data => console.log(data.message))
                    .catch(err => console.error(err));
            });

        });
        </script>
    </body>

    </html>