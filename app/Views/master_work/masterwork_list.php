<style>
    /* Remove DataTable header arrows completely */
    #searchmasterwork thead th {
        background-image: none !important;
    }

    /* Alignment fix */
    #searchmasterwork th,
    #searchmasterwork td {
        vertical-align: middle;
    }

    #searchmasterwork td:nth-child(2),
    #searchmasterwork th:nth-child(2) {
        text-align: left;
        /* Service Name */
    }

    #searchmasterwork td:nth-child(3),
    #searchmasterwork th:nth-child(3),
    #searchmasterwork td:nth-child(4),
    #searchmasterwork th:nth-child(4),
    #searchmasterwork td:nth-child(6),
    #searchmasterwork th:nth-child(6) {
        text-align: right;
        /* SAC, GST, Actions */
    }
</style>

<main class="content-wrap">

    <section id="screen-list" class="screen active">
        <div class="card">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Master Work List</div>
                    <div class="topbar-subtitle">Service catalog with SAC, default rate &amp; GST%</div>
                </div>
                <button class="btn" onclick="openServicePopup(0)">+ Add Service</button>
            </div>

            <div class="layout-row">
                <div style="flex:1;">
                    <input class="search-input" placeholder="Search by Service Code / Name / SAC..." />
                </div>
                <div style="flex:0 0 260px;display:flex;gap:6px;justify-content:flex-end;">
                    <select class="select-sm status-filter">
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

            <table id="searchmasterwork">
                <thead>
                    <tr>
                        <th style="width:24px;"><input type="checkbox" /></th>
                        <!-- <th>Service Code</th> -->
                        <th>Service Name</th>
                        <th>SAC Code/ HSN</th>
                        <!-- <th>Unit</th> -->
                        <!-- <th>Default Rate (₹)</th> -->
                        <!-- <th>GST?</th> -->
                        <th>GST %</th>
                        <!-- <th>Frequency</th> -->
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($workListData as $worklist) { ?>

                        <tr>
                            <td><input type="checkbox" /></td>
                            <!-- <td><? //= $worklist['service_code']; 
                                        ?></td> -->
                            <td><?= $worklist['service_name']; ?></td>
                            <td><?= $worklist['sac_code']; ?></td>
                            <!-- <td><? //= $worklist['unit']; 
                                        ?></td> -->
                            <!-- <td><?= $worklist['default_rate']; ?></td> -->
                            <!-- <td><span class="pill pill-green"><?= $worklist['gst_applicable']; ?></span></td> -->
                            <td><?= $worklist['gst_percent']; ?></td>
                            <!-- <td><//?= $worklist['frequency']; ?></td> -->
                            <td>
                                <span class="status-text" style="display:none;">
                                    <?= $worklist['status'] == 1 ? 'Active' : 'Inactive' ?>
                                </span>
                                <div class="toggle <?= $worklist['status'] == 0 ? 'inactive' : '' ?>"
                                    data-id="<?= $worklist['id'] ?>">
                                    <div class="toggle-circle"></div>
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn action-edit"
                                        onclick="openServicePopup('<?php echo $worklist['id'];  ?>')">Edit</button>
                                    <button class="action-btn action-clone">Clone</button>
                                    <button class="action-btn action-deactivate">Deactivate</button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
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
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">
                    <div class="cmg-header__icon">CA</div> Work Master
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($validation)): ?>
                    <div style="color:red; margin-bottom:10px;">
                        <?= $validation->listErrors(); ?>
                    </div>
                <?php endif; ?>
                <div class="msl-add-service-wrapper">
                    <div class="msl-popup-header">
                        <h2 class="msl-popup-title">Add Service</h2>
                        <p class="msl-popup-subtitle">Service catalog with SAC, default rate & GST%</p>
                    </div>

                    <form class="msl-add-service-form" method="post" action="<?php echo base_url('add-services'); ?>"
                        id="addServiceForm">
                        <?= csrf_field(); ?>
                        <input type="hidden" id="serviceId" name="id">

                        <!-- Row 1 -->
                        <div class="msl-form-row">
                            <!-- <div class="msl-form-group">
                                <label for="serviceCode">Service Code</label>
                                <input type="text" id="serviceCode" name="service_code" placeholder="GST01">
                            </div> -->

                            <div class="msl-form-group">
                                <label for="serviceName">Service Name</label>
                                <input type="text" id="serviceName" name="service_name" placeholder="GST Return Filling">
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="msl-form-row">
                            <div class="msl-form-group">
                                <label for="sacCode">SAC Code/ HSN</label>
                                <input type="text" id="sacCode" name="sac_code" placeholder="998300">
                            </div>

                            <!-- <div class="msl-form-group">
                                <label for="unit">Unit</label>
                                <select id="unit" name="unit">
                                    <option value="">Select unit</option>
                                    <option value="RETURN">RETURN</option>
                                    <option value="YEAR">YEAR</option>
                                    <option value="MONTH">MONTH</option>
                                </select>
                            </div> -->
                        </div>

                        <!-- Row 3 -->
                        <div class="msl-form-row">
                            <!-- <div class="msl-form-group">
                                <label for="defaultRate">Default Rate (₹)</label>
                                <div class="msl-input-with-prefix">
                                    <span class="msl-prefix">₹</span>
                                    <input type="number" id="defaultRate" name="default_rate" placeholder="2500.00">
                                </div>
                            </div> -->

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
                        <!-- <div class="msl-form-row">
                            <div class="msl-form-group">
                                <label for="gstYesNo">GST?</label>
                                <select id="gstYesNo" name="gst">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div> -->

                        <!-- <div class="msl-form-group">
                                <label for="frequency">Frequency</label>
                                <select id="frequency" name="frequency">
                                    <option value="">Select frequency</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Quarterly">Quarterly</option>
                                    <option value="Annually">Annually</option>
                                </select>
                            </div> -->
                        <!-- </div> -->

                        <!-- Row 5 -->
                        <!-- <div class="msl-form-row">
                            <div class="msl-form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div> -->

                        <!-- Buttons -->
                        <div class="msl-form-actions">
                            <!-- <button type="button" class="msl-btn-secondary">Cancel</button> -->
                            <button type="button" class="msl-btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="msl-btn-primary" id="saveBtn">Save Service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let serviceModal = new bootstrap.Modal(document.getElementById('addServiceModal'));


    $('#addServiceForm').on('submit', function(e) {
        e.preventDefault();


        $('.text-danger').remove();
        $('input, select').css('border', '');

        const id = $('#serviceId').val();
        const url = id ?
            "<?= base_url('update-service'); ?>/" + id :
            "<?= base_url('add-services'); ?>";

        $.ajax({
            url: url,
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res) {

                if (res.status === 'error') {

                    $.each(res.errors, function(field, msg) {

                        let input = $('[name="' + field + '"]');
                        let wrapper = input.closest('.msl-form-group');

                        input.css('border', '1px solid red');

                        wrapper.find('.text-danger').remove();

                        wrapper.append(
                            '<div class="text-danger" style="font-size:12px;margin-top:4px;">' +
                            msg +
                            '</div>'
                        );
                    });

                } else if (res.status === 'success') {

                    alert(res.message);
                    serviceModal.hide();
                    location.reload();
                }
            }
        });
    });


    <?php if (isset($validation)): ?>
        document.addEventListener("DOMContentLoaded", function() {
            serviceModal.show();
        });
    <?php endif; ?>


    function openServicePopup(id) {


        $("#addServiceForm")[0].reset();
        $("#serviceId").val('');

        $("input, select").css("border", "");
        $(".text-danger").remove();


        serviceModal.show();

        if (id === 0 || id === '0') {

            $("#saveBtn").text("Save Service");
            $(".msl-popup-title").text("Add Service");
            return;
        }


        $("#serviceId").val(id);
        $("#saveBtn").text("Update Service");
        $(".msl-popup-title").text("Edit Service");


        $.ajax({
            url: "<?= base_url('get-service'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                $("#serviceCode").val(response.service_code);
                $("#serviceName").val(response.service_name);
                $("#sacCode").val(response.sac_code);
                $("#unit").val(response.unit);
                $("#defaultRate").val(response.default_rate);
                $("#gstPercent").val(response.gst_percent);
                $("#gstYesNo").val(response.gst_applicable);
                $("#frequency").val(response.frequency);
            }
        });
    }

    // ===== Status toggle =====
    document.querySelectorAll('.toggle').forEach(toggle => {

        toggle.addEventListener('click', function() {

            this.classList.toggle('inactive');

            const status = this.classList.contains('inactive') ? 0 : 1;
            const id = this.dataset.id;

            fetch("<?= base_url('/work_master/update-status') ?>", {
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
            onclick="this.parentElement.remove()"
            style="
                position:absolute;
                top:6px;
                right:10px;
                cursor:pointer;
                font-size:18px;
                font-weight:bold;
            "
        >&times;</span>
        ${data.message}
    `;

                    document.body.appendChild(popup);


                    setTimeout(() => popup.remove(), 10000);
                })
                .catch(err => console.error(err));
        });

    });
    $(document).ready(function() {

        if ($('#searchmasterwork').length) {

            const table = new DataTable('#searchmasterwork', {
                paging: false,
                searching: true,
                info: false,
                ordering: false,
                dom: 't',

                columnDefs: [{
                        targets: 0,
                        orderable: false
                    },
                    {
                        targets: -1,
                        orderable: false
                    },

                    // ✅ status column search from hidden text
                    {
                        targets: 4,
                        render: function(data, type, row, meta) {

                            if (type === 'filter') {

                                let div = document.createElement("div");
                                div.innerHTML = data;

                                let text = div.querySelector('.status-text')?.innerText || '';

                                return text.trim();
                            }

                            return data;
                        }
                    }
                ]
            });

            // search input
            $('.search-input').on('keyup', function() {
                table.search(this.value).draw();
            });

            // status filter
            $('.status-filter').on('change', function() {

                let value = $(this).val();

                if (value === "Active" || value === "Inactive") {

                    table.column(4)
                        .search('^' + value + '$', true, false)
                        .draw();

                } else {

                    table.column(4).search('').draw();
                }

            });

        }

    });
</script>