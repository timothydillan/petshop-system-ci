<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Snoopy</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Query Menus -->
    <?php
    $role_id = $this->session->userdata('role_id');
    $queryMenu = "SELECT `menu`.`id`, `menu` FROM `menu` 
    JOIN `menu_access` ON `menu`.`id` = `menu_access`.`menu_id` 
    WHERE `menu_access`.`role_id` = $role_id 
    ORDER BY menu_access.`menu_id` ASC;";

    $menu = $this->db->query($queryMenu)->result_array();
    ?>

    <?php foreach ($menu as $m) : ?>
        <!-- Heading -->
        <div class="sidebar-heading">
            <?= $m['menu']; ?>
        </div>

        <?php
        $menuId = $m['id'];
        $querySubMenu = "SELECT * FROM `sub_menu` 
        JOIN `menu` ON `sub_menu`.`menu_id` = `menu`.`id` 
        WHERE `sub_menu`.`menu_id` = $menuId;";

        $subMenu = $this->db->query($querySubMenu)->result_array();
        ?>

        <?php foreach ($subMenu as $sm) : if ($sm['title'] == "Accounting") continue; ?>
            <!-- Heading -->
            <?php if ($title == $sm['title']) : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link" href="<?= base_url($sm['url']); ?>">
                    <i class="<?= $sm['icon']; ?>"></i>
                    <span><?= $sm['title']; ?></span></a>
                </li>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-book"></i>
                <span>Accounting</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?php if ($role_id == 3) echo base_url('toko/accounting');
                                                    else if ($role_id == 2) echo base_url('kantor/accounting');
                                                    else echo base_url('admin/accounting');  ?>">View Groom Report</a>
                    <a class="collapse-item" href="<?php if ($role_id == 3) echo base_url('toko/expenditurerequest');
                                                    else if ($role_id == 2) echo base_url('kantor/expenditurerequest');
                                                    else echo base_url('admin/expenditurerequest');  ?>">Expenditure Request</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Sidebar Message 
        <div class="sidebar-card">
            <img class="sidebar-card-illustration mb-2" src="<?= base_url('assets/') ?>img/undraw_rocket.svg" alt="">
            <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
            <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
        </div>-->

</ul>
<!-- End of Sidebar -->