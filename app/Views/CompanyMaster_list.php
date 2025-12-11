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
                    <button class="btn" onclick="openServicePopup(0)" data-toggle="modal" data-target="#staticBackdrop">+ Add Company</button>
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
                            <th>Category</th>
                            <th>Registered Office</th>
                            <th>Head Office</th>
                            <th>Email / Tel / Website</th>
                             <th>Invoice Format</th>
                            <th>PAN / GSTIN / IEC</th>
                            <th>Bank A/c No.</th>
                            <th>Sister Concerns</th>
                            <th>Branches</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <!-- Sample rows as before (shortened for demo) -->
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td>Private Ltd.</td>
                            <td>ABC Technologies Pvt Ltd</td>
                            <td>01-04-2018</td>
                            <td>Company limited by shares</td>
                            <td>Lucknow, Uttar Pradesh</td>
                            <td>Noida, Uttar Pradesh</td>
                            <td>info@abctech.com
                                +91-9876543210
                                www.abctech.com
                            </td>
                            <td>ORG/BRANCH/FY/SEQ</td>
                            <td>PAN: AAACA1234A
                                    GSTIN: 09AAACA1234A1Z5
                                    IEC: 1234567890
                                
                            </td>
                             <td>123456789012</td>
                              <td>ABC Global LLP, ABC Export House</td>
                               <td>3 Branches
                                    Add Branch
                                </td>
                                <td> <span class="pill pill-green">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn action-edit">Edit</button>
                                    <button class="action-btn action-clone">Clone</button>
                                    <button class="action-btn action-deactivate">Deactivate</button>
                                </div>
                            </td>
                        </tr>
                        
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


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content cmg-shell">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">SECTION: GENERAL INFO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="cmg-form" method="POST" action="">
                    <div class="cmg-grid">

                        <!-- Name -->
                        <div class="cmg-field cmg-field--full">
                            <label class="cmg-label">
                                Name <span class="cmg-required">*</span>
                            </label>
                            <input type="text" class="cmg-input" placeholder="Enter company name" name="name">
                        </div>

                        <!-- Type -->
                        <div class="cmg-field">
                            <label class="cmg-label">
                                Type <span class="cmg-required">*</span>
                            </label>
                            <select class="cmg-select" name="type">
                                <option value="">Select type</option>
                                <option value="proprietorship">Proprietorship</option>
                                <option value="partnership">Partnership</option>
                                <option value="pvt">Private Limited</option>
                                <option value="ltd">Limited</option>
                            </select>
                        </div>

                        <!-- Category -->
                        <div class="cmg-field">
                            <label class="cmg-label">Category</label>
                            <select class="cmg-select" name="category">
                                <option value="">Select category</option>
                                <option value="consulting">Consulting</option>
                                <option value="trading">Trading</option>
                                <option value="manufacturing">Manufacturing</option>
                            </select>
                        </div>

                        <!-- Date of Incorporation -->
                        <div class="cmg-field">
                            <label class="cmg-label">Date of Incorporation</label>
                            <input type="date" class="cmg-input" name="date_of_incorporation">
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

                        <!-- Terms & Conditions -->
                        <div class="cmg-field cmg-field--full">
                            <label class="cmg-label">Terms &amp; Conditions (Invoice Footer)</label>
                            <textarea class="cmg-textarea" name="terms"
                                placeholder="Enter terms and conditions that will appear on invoices"></textarea>
                            <p class="cmg-help-text">
                                This text will appear at the bottom of all invoices.
                            </p>
                        </div>

                        <!-- Branches block -->
                        <div class="cmg-field cmg-field--full">
                            <label class="cmg-label">Branches (List)</label>

                            <div class="cmg-branches">
                                <div class="cmg-branches__header">
                                    <span>Branches</span>
                                    <button type="button" class="cmg-btn cmg-btn--ghost cmg-btn--small ">+
                                        Add Branch</button>
                                </div>

                                <div class="cmg-branches__item">
                                    <div>
                                        <div class="cmg-branches__title">HO | Civil Lines, Delhi</div>
                                        <div class="cmg-branches__subtitle">
                                            123, Civil Lines, New Delhi - 110054
                                        </div>
                                    </div>
                                    <div class="cmg-branches__actions">
                                        <button type="button"
                                            class="cmg-btn cmg-btn--tiny cmg-btn--outline">Edit</button>
                                        <button type="button"
                                            class="cmg-btn cmg-btn--tiny cmg-btn--danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PAN -->
                        <div class="cmg-field">
                            <label class="cmg-label">PAN</label>
                            <input type="text" class="cmg-input" name="pan" placeholder="ABCDE1234F">
                        </div>

                        <!-- GSTIN -->
                        <div class="cmg-field">
                            <label class="cmg-label">GSTIN</label>
                            <input type="text" class="cmg-input" name="gstin" placeholder="22ABCDE1234F1ZS">
                        </div>

                        <!-- Bank Account -->
                        <div class="cmg-field">
                            <label class="cmg-label">Bank Account</label>
                            <select class="cmg-select" name="bank_account">
                                <option value="">Select bank account</option>
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
                                    ⬆ Upload Button
                                    <input type="file" name="logo" class="cmg-upload__input">
                                </label>
                                <span class="cmg-upload__text">No file chosen</span>
                            </div>

                            <p class="cmg-help-text">
                                Recommended size: 200x200px, Max file size: 2MB
                            </p>
                        </div>

                    </div>

                    <!-- Footer buttons -->
                    <div class="cmg-footer">
                        <button type="button" class="cmg-btn cmg-btn--ghost" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="cmg-btn cmg-btn--primary">Add</button>
                    </div>
                </form>
      </div>
    </div>
  </div>
</div>


</body>

</html>