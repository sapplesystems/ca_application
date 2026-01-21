<!-- Modal for add user -->
<div class="modal fade" id="usermanagepopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div style="color:red; margin-bottom:10px;">
                </div>

                <div class="msl-add-service-wrapper">
                    <div class="msl-popup-header">
                        <h2 class="msl-popup-title">Add User</h2>

                    </div>

                    <form class="msl-add-service-form" method="post" action="<?= base_url('user-management/store') ?>">

                        <?= csrf_field() ?>

                        <div class="msl-form-row">
                            <div class="msl-form-group">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="Enter User Name">
                            </div>

                            <div class="msl-form-group">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="msl-form-row">
                            <div class="msl-form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" placeholder="enter your phone number">
                            </div>

                            <div class="msl-form-group">
                                <label>User Role</label>
                                <select name="role">
                                    <option value="">Select User</option>
                                    <option value="user1">user1</option>
                                    <option value="user2">user2</option>
                                </select>
                            </div>
                        </div>

                        <div class="msl-form-actions">
                            <button type="button" class="msl-btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="msl-btn-primary">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for edit user-->
<div class="modal fade" id="usereditpopup" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="editUserForm">
                    <?= csrf_field() ?>

                    <input type="hidden" name="id" id="edit_id">

                    <div class="msl-form-row">
                        <div class="msl-form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" placeholder="Enter User Name">
                        </div>

                        <div class="msl-form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="msl-form-row">
                        <div class="msl-form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" id="edit_phone" placeholder="Enter phone number">
                        </div>

                        <div class="msl-form-group">
                            <label>User Role</label>
                            <select name="role" id="edit_role">
                                <option value="">Select User</option>
                                <option value="user1">user1</option>
                                <option value="user2">user2</option>
                            </select>
                        </div>
                    </div>

                    <div class="msl-form-actions">
                        <button type="button" class="msl-btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="msl-btn-primary">
                            Update User
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<main class="content-wrap">

    <section id="screen-list" class="screen active">
        <div class="card">
            <div class="topbar">
                <div>
                    <div class="topbar-title">User Managment List</div>

                </div>
                <button class="btn" data-bs-toggle="modal" data-bs-target="#usermanagepopup">Add User</button>
            </div>

            <div class="layout-row">
                <div style="flex:1;">
                    <input class="search-input" placeholder="Search by user name /email/phone" />
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
                        <th>Email</th>
                        <th>phone</th>

                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['phone']) ?></td>

                        <td>
                            <div class="toggle <?= $user['status'] == 0 ? 'inactive' : '' ?>"
                                data-id="<?= $user['id'] ?>" data-status="<?= $user['status'] ?>">
                                <div class="toggle-circle"></div>
                            </div>
                        </td>

                        <td style="text-align:right;">
                            <button class="action-btn action-edit" data-bs-toggle="modal"
                                data-bs-target="#usereditpopup" data-id="<?= $user['id'] ?>">
                                Edit
                            </button>
                            <button class="action-btn action-delete" style="background-color:#ee2400;color:#fff"
                                data-id="<?= $user['id'] ?>">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No users found</td>
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
<script>
document.querySelectorAll('.action-edit').forEach(btn => {
    btn.addEventListener('click', function() {

        let userId = this.dataset.id;

        fetch(`<?= base_url('user-management/get-user') ?>/${userId}`)
            .then(res => res.json())
            .then(user => {

                document.getElementById('edit_id').value = user.id;
                document.getElementById('edit_name').value = user.name;
                document.getElementById('edit_email').value = user.email;
                document.getElementById('edit_phone').value = user.phone;
                document.getElementById('edit_role').value = user.role;

                const editModal = bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('usereditpopup')
                );
                editModal.show();
            });
    });
});
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("<?= base_url('user-management/update') ?>", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(response => {

            if (response.status === 'success') {

                // modal close
                const modal = bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('usereditpopup')
                );
                modal.hide();

                // simple approach
                location.reload(); // 
            } else {
                alert(response.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong');
        });
});
document.querySelectorAll('.action-delete').forEach(btn => {
    btn.addEventListener('click', function() {

        let userId = this.dataset.id;

        if (!confirm('Are you sure you want to delete this user?')) {
            return;
        }

        let formData = new FormData();
        formData.append('id', userId);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        fetch("<?= base_url('user-management/delete') ?>", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {

                if (response.status === 'success') {
                    // simplest way
                    location.reload();


                } else {
                    alert(response.message);
                }
            });
    });
});
document.querySelectorAll('.toggle').forEach(toggle => {

    toggle.addEventListener('click', function() {

        let userId = this.dataset.id;
        let currStatus = parseInt(this.dataset.status); // 🔥 string → number

        let formData = new FormData();
        formData.append('id', userId);
        formData.append('status', currStatus);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        fetch("<?= base_url('user-management/toggle-status') ?>", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {

                if (response.status === 'success') {


                    if (response.new_status == 1) {
                        this.classList.remove('inactive');
                    } else {
                        this.classList.add('inactive');
                    }


                    this.dataset.status = response.new_status;
                }
            });

    });

});
</script>