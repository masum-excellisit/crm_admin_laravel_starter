<?php $__env->startSection('title', 'Edit Role'); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="inner_page">
            <div class="card search_bar sales-report-card">
                <div class="sales-report-header">
                    <h2>Edit Role: <?php echo e($role->name); ?></h2>
                    <div class="btn-1 btn btn-primary mb-2">
                        <a class="text-white" href="<?php echo e(route('roles.index')); ?>">Back to Roles</a>
                    </div>
                </div>

                <form action="<?php echo e(route('roles.update', $role->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="<?php echo e(old('name', $role->name)); ?>" required>
                                <?php if($errors->has('name')): ?>
                                    <div class="error" style="color:red;"><?php echo e($errors->first('name')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h4>Permissions</h4>
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupPermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="permission-group mb-3">
                                    <h5><?php echo e(ucfirst($group)); ?> Management</h5>
                                    <div class="row">
                                        <?php $__currentLoopData = $groupPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="<?php echo e($permission->name); ?>"
                                                        id="permission_<?php echo e($permission->id); ?>"
                                                        <?php echo e(in_array($permission->name, $rolePermissions) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="permission_<?php echo e($permission->id); ?>">
                                                        <?php echo e(ucfirst(str_replace('-', ' ', $permission->name))); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($errors->has('permissions')): ?>
                                <div class="error" style="color:red;"><?php echo e($errors->first('permissions')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/masum/CRM_sale/crm_sale/resources/views/admin/roles/edit.blade.php ENDPATH**/ ?>