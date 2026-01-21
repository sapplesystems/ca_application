<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-key"></i> Manage Permissions</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('permissions/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Permission
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="permissionsTable">
                <thead class="table-light">
                    <tr>
                        <th>Permission Name</th>
                        <th>Slug</th>
                        <th>Module</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permissions as $permission): ?>
                    <tr>
                        <td><?= esc($permission['permission_name']) ?></td>
                        <td><code><?= esc($permission['permission_slug']) ?></code></td>
                        <td><span class="badge bg-secondary"><?= ucfirst($permission['module']) ?></span></td>
                        <td><?= esc($permission['description']) ?></td>
                        <td><?= $permission['status'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?></td>
                        <td>
                            <a href="<?= base_url('permissions/edit/' . $permission['id']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('permissions/delete/' . $permission['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>