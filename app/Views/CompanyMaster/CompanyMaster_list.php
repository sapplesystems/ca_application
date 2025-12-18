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
                                    <?php if ($row['status'] == 'active'): ?>
                                    <span class="pill pill-green">Active</span>
                                    <?php else: ?>
                                    <span class="pill pill-red">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn action-edit" data-id="<?= $row['id'] ?>"
                                            data-target="#editcompanymaster" data-toggle="modal">
                                            Edit
                                        </button>
                                        <button class="action-btn action-edit"> view </button>
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
                        <h5 class="modal-title" id="staticBackdropLabel">SECTION: GENERAL INFO</h5>
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
                                        <option value="">Select type</option>
                                        <option value="proprietorship">Proprietorship</option>
                                        <option value="partnership">Partnership</option>
                                        <option value="pvt_ltd">Private Limited</option>
                                        <option value="ltd">Public Limited</option>
                                        <option value="llp">LLP</option>
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
                                    <select class="cmg-select" name="category">
                                        <option value="">Select category</option>
                                        <option value="company_limited_by_shares">Company limited by shares</option>
                                        <option value="company_limited_by_guarantee">Company limited by guarantee
                                        </option>
                                        <option value="one_person_company">One Person Company</option>
                                        <option value="others">Others</option>
                                    </select>
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

                                <!-- Branches (List) - UPDATED -->
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

                                        <!-- yahan dynamic list aayegi -->
                                        <div id="branchesList">

                                            <!-- default example (optional) -->
                                            <div class="cmg-branches__item">
                                                <div class="cmg-branches__item-main">
                                                    <div class="cmg-branches__row">
                                                        <input type="text" class="cmg-input cmg-branches__title-input"
                                                            name="branches[][title]" value="HO | Civil Lines, Delhi"
                                                            placeholder="Branch title (e.g. HO | Civil Lines, Delhi)">
                                                    </div>
                                                    <div class="cmg-branches__row">
                                                        <textarea class="cmg-textarea cmg-branches__subtitle-input"
                                                            name="branches[][address]"
                                                            placeholder="Branch address">123, Civil Lines, New Delhi - 110054</textarea>
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

                                        <!-- Hidden template for new branch -->
                                        <template id="branchTemplate">
                                            <div class="cmg-branches__item">
                                                <div class="cmg-branches__item-main">
                                                    <div class="cmg-branches__row">
                                                        <input type="text" class="cmg-input cmg-branches__title-input"
                                                            name="branches[][title]"
                                                            placeholder="Branch title (e.g. HO | Civil Lines, Delhi)">
                                                    </div>
                                                    <div class="cmg-branches__row">
                                                        <textarea class="cmg-textarea cmg-branches__subtitle-input"
                                                            name="branches[][address]"
                                                            placeholder="Branch address"></textarea>
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
                                    <select class="cmg-select" name="bank_account">
                                        <option value="">Select bank account</option>
                                        <!-- options dynamically from bank_accounts master -->
                                    </select>
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

                                <!-- Status -->
                                <div class="cmg-field">
                                    <label class="cmg-label">Status</label>
                                    <select class="cmg-select" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
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
                        <h5 class="modal-title" id="staticBackdropLabel">SECTION: GENERAL INFO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form class="cmg-form" method="POST" action="" enctype="multipart/form-data">
                            <div class="cmg-grid">

                                <!-- Type of Company -->
                                <div class="cmg-field">
                                    <label class="cmg-label">
                                        Type of Company <span class="cmg-required">*</span>
                                    </label>
                                    <select class="cmg-select" name="company_type">
                                        <option value="">Select type</option>
                                        <option value="proprietorship">Proprietorship</option>
                                        <option value="partnership">Partnership</option>
                                        <option value="pvt_ltd">Private Limited</option>
                                        <option value="ltd">Public Limited</option>
                                        <option value="llp">LLP</option>
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
                                    <select class="cmg-select" name="category">
                                        <option value="">Select category</option>
                                        <option value="company_limited_by_shares">Company limited by shares</option>
                                        <option value="company_limited_by_guarantee">Company limited by guarantee
                                        </option>
                                        <option value="one_person_company">One Person Company</option>
                                        <option value="others">Others</option>
                                    </select>
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

                                <!-- Branches (List) - UPDATED -->
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

                                        <!-- yahan dynamic list aayegi -->
                                        <div id="branchesList">

                                            <!-- default example (optional) -->
                                            <div class="cmg-branches__item">
                                                <div class="cmg-branches__item-main">
                                                    <div class="cmg-branches__row">
                                                        <input type="text" class="cmg-input cmg-branches__title-input"
                                                            name="branches[][title]" value="HO | Civil Lines, Delhi"
                                                            placeholder="Branch title (e.g. HO | Civil Lines, Delhi)">
                                                    </div>
                                                    <div class="cmg-branches__row">
                                                        <textarea class="cmg-textarea cmg-branches__subtitle-input"
                                                            name="branches[][address]"
                                                            placeholder="Branch address">123, Civil Lines, New Delhi - 110054</textarea>
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

                                        <!-- Hidden template for new branch -->
                                        <template id="branchTemplate">
                                            <div class="cmg-branches__item">
                                                <div class="cmg-branches__item-main">
                                                    <div class="cmg-branches__row">
                                                        <input type="text" class="cmg-input cmg-branches__title-input"
                                                            name="branches[][title]"
                                                            placeholder="Branch title (e.g. HO | Civil Lines, Delhi)">
                                                    </div>
                                                    <div class="cmg-branches__row">
                                                        <textarea class="cmg-textarea cmg-branches__subtitle-input"
                                                            name="branches[][address]"
                                                            placeholder="Branch address"></textarea>
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
                                    <select class="cmg-select" name="bank_account">
                                        <option value="">Select bank account</option>
                                        <!-- options dynamically from bank_accounts master -->
                                    </select>
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

                                <!-- Status -->
                                <div class="cmg-field">
                                    <label class="cmg-label">Status</label>
                                    <select class="cmg-select" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Footer buttons -->
                            <div class="cmg-footer">
                                <button type="button" class="cmg-btn cmg-btn--ghost" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="cmg-btn cmg-btn--primary">
                                    Update Company
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('addBranchBtn');
            const branchesList = document.getElementById('branchesList');
            const branchTpl = document.getElementById('branchTemplate');

            if (!addBtn || !branchesList || !branchTpl) {
                return;
            }

            // Add Branch
            addBtn.addEventListener('click', function() {
                const clone = branchTpl.content.cloneNode(true);
                branchesList.appendChild(clone);
            });

            // Delete Branch (event delegation)
            branchesList.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-branch-delete')) {
                    const item = e.target.closest('.cmg-branches__item');
                    if (item) {
                        item.remove();
                    }
                }
            });
        });
        </script>

    </body>

    </html>