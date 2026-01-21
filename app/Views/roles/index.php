<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="invoiceM-containerr">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-shield-alt"></i> Manage Roles</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('roles/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Role
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="rolesTable">
                <thead class="table-light">
                    <tr>
                        <th>Role Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $role): ?>
                    <tr>
                        <td><strong><?= esc($role['role_name']) ?></strong></td>
                        <td><?= esc(substr($role['description'], 0, 50)) ?>...</td>
                        <td><span class="badge bg-info"><?= ucfirst($role['permission_type']) ?></span></td>
                        <td>
                            <?= $role['status'] ? 
                                '<span class="badge bg-success"><i class="fas fa-check"></i> Active</span>' : 
                                '<span class="badge bg-danger"><i class="fas fa-times"></i> Inactive</span>' 
                            ?>
                        </td>
                        <td>
                            <a href="<?= base_url('roles/edit/' . $role['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="<?= base_url('roles/delete/' . $role['id']) ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this role?');">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#rolesTable').DataTable({
        "pageLength": 10,
        "language": {
            "search": "Search roles:",
            "paginate": {
                "previous": "Previous",
                "next": "Next"
            }
        }
    });
});
</script>
<?= $this->endSection() ?>