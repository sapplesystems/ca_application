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
    <div class="container">
        <div class="cmg-shell">

            <main class="">
                <div class="cmg-section-label">SECTION: GENERAL INFO</div>

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
                                    <button type="button" class="cmg-btn cmg-btn--ghost cmg-btn--small">+
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
                        <button type="button" class="cmg-btn cmg-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="cmg-btn cmg-btn--primary">Add</button>
                    </div>
                </form>
            </main>
        </div>
    </div>

</body>

</html>