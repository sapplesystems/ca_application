<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="invoiceM-containerr">
    <h2 class="mb-4"><i class="fas fa-shield-alt"></i> Create New Role</h2>

    <?php if (isset($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?= base_url('roles/store') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label"><strong>Role Name</strong></label>
                    <input type="text" name="role_name" class="form-control" value="<?= old('role_name') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Description</strong></label>
                    <textarea name="description" class="form-control" rows="3" required><?= old('description') ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label"><strong>Permission Type</strong></label>
                    <select name="permission_type" id="permissionType" class="form-control" required>
                        <option value="all">All Permissions</option>
                        <option value="custom">Custom Permissions</option>
                    </select>
                </div>

                <div id="customPermissions" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label mb-0"><strong>Select Permissions by Module</strong></label>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-success" id="selectAllBtn">
                                <i class="fas fa-check-square"></i> Select All
                            </button>
                            <button type="button" class="btn btn-outline-danger" id="deselectAllBtn">
                                <i class="fas fa-square"></i> Deselect All
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <?php foreach ($modules as $module): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center" 
                                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                             color: white; padding: 12px 16px; border-radius: 6px 6px 0 0;">
                                    <strong><i class="fas fa-layer-group"></i> <?= ucfirst($module['module']) ?></strong>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-light btn-sm module-select-btn" 
                                                data-module="<?= $module['module'] ?>">
                                            <i class="fas fa-check"></i> Select
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm module-deselect-btn" 
                                                data-module="<?= $module['module'] ?>">
                                            <i class="fas fa-times"></i> Clear
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="permissions_<?= $module['module'] ?>" class="module-permissions"></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <a href="<?= base_url('roles') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('permissionType').addEventListener('change', function() {
    const customPerms = document.getElementById('customPermissions');
    if (this.value === 'custom') {
        customPerms.style.display = 'block';
        loadPermissions();
    } else {
        customPerms.style.display = 'none';
    }
});

function loadPermissions() {
    const modules = <?= json_encode(array_column($modules, 'module')) ?>;
    
    modules.forEach(module => {
        fetch('<?= base_url('roles/permissions/') ?>' + module)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('permissions_' + module);
                container.innerHTML = ''; // Clear previous content
                
                data.permissions.forEach(perm => {
                    const checkbox = document.createElement('div');
                    checkbox.className = 'form-check mb-2';
                    checkbox.innerHTML = `
                        <input class="form-check-input permission-checkbox" 
                               type="checkbox" 
                               name="permissions[]" 
                               value="${perm.id}"
                               data-module="${module}"
                               id="perm_${perm.id}">
                        <label class="form-check-label" for="perm_${perm.id}">
                            <i class="fas fa-key"></i> ${perm.permission_name}
                        </label>
                    `;
                    container.appendChild(checkbox);
                });
            })
            .catch(error => console.error('Error loading permissions for ' + module + ':', error));
    });
}

// Select all permissions in a specific module
document.querySelectorAll('.module-select-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const module = this.dataset.module;
        document.querySelectorAll(`input[data-module="${module}"].permission-checkbox`).forEach(checkbox => {
            checkbox.checked = true;
        });
    });
});

// Deselect all permissions in a specific module
document.querySelectorAll('.module-deselect-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const module = this.dataset.module;
        document.querySelectorAll(`input[data-module="${module}"].permission-checkbox`).forEach(checkbox => {
            checkbox.checked = false;
        });
    });
});

// Select all permissions globally
document.getElementById('selectAllBtn').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
});

// Deselect all permissions globally
document.getElementById('deselectAllBtn').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
});
</script>

<style>
    .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .card {
        border-radius: 8px;
        border: none;
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }

    .btn-group-sm .btn {
        font-size: 11px;
        padding: 4px 8px;
    }

    .module-select-btn, .module-deselect-btn {
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: all 0.3s ease;
    }

    .module-select-btn:hover, .module-deselect-btn:hover {
        background-color: rgba(255, 255, 255, 0.3) !important;
        border-color: white !important;
    }

    .permission-checkbox {
        cursor: pointer;
        width: 18px;
        height: 18px;
    }

    .form-check-label {
        cursor: pointer;
        margin-left: 8px;
        margin-bottom: 0;
        user-select: none;
    }

    .form-check-label i {
        color: #667eea;
        margin-right: 5px;
    }

    .module-permissions {
        max-height: 300px;
        overflow-y: auto;
    }

    .module-permissions::-webkit-scrollbar {
        width: 6px;
    }

    .module-permissions::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .module-permissions::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .module-permissions::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .gap-2 {
        gap: 10px;
    }
</style>
<?= $this->endSection() ?>