<?php
$current_url = basename($_SERVER['REQUEST_URI']); // Obtener solo la parte final de la URL
$role = session()->get('role'); // Obtener el rol almacenado en la sesión
?>

<input type="checkbox" id="nav-toggle" />
<div class="sidebar">
    <div class="sidebar-brand">
        <h2>
            <span class=""></span>
            <span><img src="<?= base_url('assets/img/logos/LOGO CHEF TABLE2-02.png') ?>" alt="" width="180px" height="90px" /></span>
        </h2>
    </div>
    <!-- Secciones del menú -->
    <div class="sidebar-menu">
        <ul>
            <!-- Módulo de Roles (Solo para Administrador) -->
            <?php if ($role == 'Admin'): ?>
                <li>
                    <a href="<?= base_url('role') ?>" class="<?= $current_url == 'role' ? 'active' : '' ?>">
                        <i class="fa-solid fa-unlock"></i> <span>Roles</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Módulo de Usuarios (Solo para Administrador) -->
            <?php if ($role == 'Admin'): ?>
                <li>
                    <a href="<?= base_url('usuario') ?>" class="<?= $current_url == 'usuario' ? 'active' : '' ?>">
                        <i class="fa-solid fa-users"></i> <span>Usuarios</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Módulos comunes para Administrador y Chef (excluyendo Roles, Cierre y Proveedores para Chef) -->
            <?php if ($role == 'Admin' || $role == 'Chef'): ?>
                <li>
                    <a href="<?= base_url('inventario') ?>" class="<?= $current_url == 'inventario' ? 'active' : '' ?>">
                        <i class="fa-solid fa-warehouse"></i><span>Inventario</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('menudiario') ?>" class="<?= $current_url == 'menudiario' ? 'active' : '' ?>">
                        <i class="fa-solid fa-calendar"></i><span>Menú Diario</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('proveedor') ?>" class="<?= $current_url == 'proveedor' ? 'active' : '' ?>">
                        <i class="fa-solid fa-truck-field"></i><span>Proveedor</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Módulos comunes para Administrador, Chef y Mesero -->
            <?php if ($role == 'Admin' || $role == 'Chef' || $role == 'Mesero'): ?>
                <li>
                    <a href="<?= base_url('comanda') ?>" class="<?= $current_url == 'comanda' ? 'active' : '' ?>">
                        <i class="fa-solid fa-file"></i><span>Comanda</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('menu') ?>" class="<?= $current_url == 'menu' ? 'active' : '' ?>">
                        <i class="fa-solid fa-file"></i> <span>Menú</span>
                    </a>
                </li>
                <!-- Menú Diario agregado para Mesero -->
                <?php if ($role == 'Mesero'): ?>
                    <li>
                        <a href="<?= base_url('menudiario') ?>" class="<?= $current_url == 'menudiario' ? 'active' : '' ?>">
                            <i class="fa-solid fa-calendar"></i><span>Menú Diario</span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Módulos comunes para Administrador y Mesero -->
            <?php if ($role == 'Admin' || $role == 'Chef' || $role == 'Mesero'): ?>
                <li>
                    <a href="<?= base_url('mesa') ?>" class="<?= $current_url == 'mesa' ? 'active' : '' ?>">
                        <i class="fa-solid fa-table-list"></i><span>Mesa Disponible</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Módulo de Cierre (Solo para Administrador) -->
            <?php if ($role == 'Admin'): ?>
                <li>
                    <a href="<?= base_url('cierre') ?>" class="<?= $current_url == 'cierre' ? 'active' : '' ?>">
                        <i class="fa-solid fa-money-check-dollar"></i> <span>Cierre</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
