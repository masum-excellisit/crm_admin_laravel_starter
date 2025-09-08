<nav class="navbar navbar-expand-lg main-navbar sticky">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                    <svg xmlns="http: //www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-menu">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </a>
            </li>
            <li></li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">

        
        <!-- <li>
            <a href="" class="nav-link nav-link-lg fullscreen-btn">
                <i class="ph-gear"></i>
            </a>
        </li> -->
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <?php if(Auth::user()->profile_picture): ?>
                    <img alt="image" src="<?php echo e(Storage::url(Auth::user()->profile_picture)); ?>"
                        class="user-img-radious-style" /> <?php echo e(Auth::user()->name); ?>

                <?php else: ?>
                    <img alt="image" src="<?php echo e(asset('admin_assets/img/profile_dummy.png')); ?>"
                        class="user-img-radious-style" /> <?php echo e(Auth::user()->name); ?>

                <?php endif; ?>
            </a>

            <div class="dropdown-menu dropdown-menu-right pullDown">
                <div class="dropdown-title">Hello, <?php echo e(Auth::user()->name); ?></div>
                <div class="dropdown-divider"></div>

                <!-- Profile -->
                <a href="<?php echo e(route('admin.profile')); ?>" class="dropdown-item has-icon">
                    <i class="ph ph-user"></i> Profile
                </a>

                <!-- Change Password -->
                <a href="<?php echo e(route('admin.password')); ?>" class="dropdown-item has-icon">
                    <i class="ph ph-key"></i> Change Password
                </a>

                <div class="dropdown-divider"></div>

                <!-- Logout -->
                <a href="<?php echo e(route('admin.logout')); ?>" class="dropdown-item has-icon text-danger">
                    <i class="ph ph-sign-out"></i> Logout
                </a>
            </div>
        </li>

    </ul>
</nav>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/masum/CRM_sale/crm_sale/resources/views/admin/includes/header.blade.php ENDPATH**/ ?>