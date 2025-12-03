<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Master Work List - CA Billing</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php base_url();?>public/assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="bg-blur"></div>

    <header class="top-header">
        <div class="logo-wrap">
            <div class="logo-mark">CA</div>
            <div>
                <div class="logo-text-main">Kumar Samantaray &amp; Associates</div>
                <div class="logo-text-sub">Chartered Accountants</div>
            </div>
        </div>
        <div class="user-info">
            Welcome! <span>Rajesh Kumar</span>
            <a href="#">LOGOUT</a>
        </div>
    </header>

    <!-- NAVBAR based on ca-project functional scope -->
    <nav class="menu-bar">
        <div class="menu-item active">Master Work List</div>
        <div class="menu-item">Company Master</div>
        <div class="menu-item">Client Master</div>
        <div class="menu-item">Invoice Management</div>
        <div class="menu-item">Receipt Notes (TDS)</div>
        <div class="menu-item">Reports &amp; Registers</div>
        <div class="menu-item">PDF Outputs</div>
    </nav>

    <main class="content-wrap">
        <!-- Master Work List screen (active) -->
        <section id="screen-list" class="screen active">
            <div class="card">
                <div class="topbar">
                    <div>
                        <div class="topbar-title">Master Work List</div>
                        <div class="topbar-subtitle">Service catalog with SAC, default rate &amp; GST%</div>
                    </div>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Add Service</button>
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
                            <th>Service Code</th>
                            <th>Service Name</th>
                            <th>SAC Code</th>
                            <th>Unit</th>
                            <th>Default Rate (₹)</th>
                            <th>GST?</th>
                            <th>GST %</th>
                            <th>Frequency</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample rows as before (shortened for demo) -->
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td>GST01</td>
                            <td>GST Return Filing</td>
                            <td>998300</td>
                            <td>RETURN</td>
                            <td>2,500.00</td>
                            <td><span class="pill pill-green">Yes</span></td>
                            <td>18.00%</td>
                            <td>Monthly</td>
                            <td><span class="pill pill-green">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn action-edit">Edit</button>
                                    <button class="action-btn action-clone">Clone</button>
                                    <button class="action-btn action-deactivate">Deactivate</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td>AUD01</td>
                            <td>Statutory Audit</td>
                            <td>998201</td>
                            <td>YEAR</td>
                            <td>75,000.00</td>
                            <td><span class="pill pill-green">Yes</span></td>
                            <td>18.00%</td>
                            <td>Annually</td>
                            <td><span class="pill pill-green">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn action-edit">Edit</button>
                                    <button class="action-btn action-clone">Clone</button>
                                    <button class="action-btn action-deactivate">Deactivate</button>
                                </div>
                            </td>
                        </tr>
                        <!-- ...baaki rows yahi pattern follow karo... -->
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div class="cmg-header__icon">CA</div> Company Master <span>(Add)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="msl-add-service-wrapper">
                        <div class="msl-popup-header">
                            <h2 class="msl-popup-title">Add Service</h2>
                            <p class="msl-popup-subtitle">Service catalog with SAC, default rate & GST%</p>
                        </div>

                        <form class="msl-add-service-form">
                            <!-- Row 1 -->
                            <div class="msl-form-row">
                                <div class="msl-form-group">
                                    <label for="serviceCode">Service Code</label>
                                    <input type="text" id="serviceCode" name="service_code" placeholder="GST01">
                                </div>

                                <div class="msl-form-group">
                                    <label for="serviceName">Service Name</label>
                                    <input type="text" id="serviceName" name="service_name"
                                        placeholder="GST Return Filing">
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="msl-form-row">
                                <div class="msl-form-group">
                                    <label for="sacCode">SAC Code</label>
                                    <input type="text" id="sacCode" name="sac_code" placeholder="998300">
                                </div>

                                <div class="msl-form-group">
                                    <label for="unit">Unit</label>
                                    <select id="unit" name="unit">
                                        <option value="">Select unit</option>
                                        <option value="RETURN">RETURN</option>
                                        <option value="YEAR">YEAR</option>
                                        <option value="MONTH">MONTH</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="msl-form-row">
                                <div class="msl-form-group">
                                    <label for="defaultRate">Default Rate (₹)</label>
                                    <div class="msl-input-with-prefix">
                                        <span class="msl-prefix">₹</span>
                                        <input type="number" id="defaultRate" name="default_rate" placeholder="2500.00">
                                    </div>
                                </div>

                                <div class="msl-form-group">
                                    <label for="gstPercent">GST %</label>
                                    <div class="msl-input-with-suffix">
                                        <input type="number" step="0.01" id="gstPercent" name="gst_percent"
                                            placeholder="18.00">
                                        <span class="msl-suffix">%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 4 -->
                            <div class="msl-form-row">
                                <div class="msl-form-group">
                                    <label for="gstYesNo">GST?</label>
                                    <select id="gstYesNo" name="gst">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                                <div class="msl-form-group">
                                    <label for="frequency">Frequency</label>
                                    <select id="frequency" name="frequency">
                                        <option value="">Select frequency</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Quarterly">Quarterly</option>
                                        <option value="Annually">Annually</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 5 -->
                            <div class="msl-form-row">
                                <div class="msl-form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="msl-form-actions">
                                <button type="button" class="msl-btn-secondary">Cancel</button>
                                <button type="submit" class="msl-btn-primary">Save Service</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
            </div>
        </div>
    </div>
</body>

</html>