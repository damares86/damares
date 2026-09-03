<?php

declare(strict_types=1);

$userAvatar = htmlspecialchars((string) ($_SESSION['avatar'] ?? 'default.png'), ENT_QUOTES, 'UTF-8');
$userName = htmlspecialchars((string) ($_SESSION['username'] ?? ''), ENT_QUOTES, 'UTF-8');
$roleName = htmlspecialchars((string) ($_SESSION['rolename'] ?? ''), ENT_QUOTES, 'UTF-8');
?>
<button id="burger-menu" class="burger-menu">
    ☰
</button>
<div id="side_damares" class="">
    <div class="sidebar_damares sidebar-wrapper_damares shadow">
        <div class="sidebar-logo border-bottom">
            <a href="index.php">
                <img src="assets/images/logo/damares_logo.png" alt="Logo" />
            </a>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle border-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    <img src="uploads/avatar/<?= $userAvatar ?>" alt="Avatar">
                                </div>
                                <div class="text">
                                    <h6 class="user-dropdown-name"><?= $userName ?></h6>
                                    <p class="user-dropdown-status text-sm text-muted"><?= $roleName ?></p>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                                <li class="px-2"><a class="dropdown-item border-0" href="index.php?p=editProfile"><?= htmlspecialchars((string) ($common_profile ?? 'Profile'), ENT_QUOTES, 'UTF-8') ?></a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="px-2"><a class="dropdown-item border-0" href="core/logout.php"><?= htmlspecialchars((string) ($common_logout ?? 'Logout'), ENT_QUOTES, 'UTF-8') ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-center">
            <?php
            $plugin->pluginname = 'mini_cms';
            if ($plugin->itemExists('pluginname') && (int) $plugin->isActive() === 1) {
            ?>
                <a href="../" class="btn icon btn-primary shadow mx-3 px-3 text-white">
                    <i class="bi bi-arrow-left-circle"></i> &nbsp; <?= htmlspecialchars((string) ($mc_backsite ?? 'Back to site'), ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php
            }
            ?>
        </div>
        <ul class="sidebar_menu list-unstyled">
            <?php
            $role_id = (int) ($_SESSION['role_id'] ?? 0);
            $rolessection->table = 'rolesSectionChild';
            $rolessection->role_id = $role_id;
            $permissionChild = $rolessection->showAllWhere('id', ['role_id']);
            $permChildArr = $permissionChild ? $permissionChild->fetch(PDO::FETCH_ASSOC) : null;
            $sectionChild = !empty($permChildArr['section_id']) ? explode(',', (string) $permChildArr['section_id']) : [];

            $rolessection->role_id = $role_id;
            $rolessection->table = 'rolesSection';
            $permissionParent = $rolessection->showAllWhere('id', ['role_id']);
            $row3 = $permissionParent ? $permissionParent->fetch(PDO::FETCH_ASSOC) : null;
            $sectionParent = !empty($row3['section_id']) ? explode(',', (string) $row3['section_id']) : [];

            $section->table = 'sectionParent';
            $stmt = $section->showAll('id');

            if ($stmt instanceof PDOStatement) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $hasSub = '';
                    $active = '';
                    $link = ($row['link'] === 'index') ? 'index.php' : 'index.php?p=' . urlencode((string) $row['link']);
                    $parent_id = (int) $row['id'];

                    $section->table = 'sectionChild';
                    $section->parent_id = $parent_id;
                    $child = $section->showAllWhere('id', ['parent_id']);
                    $countChildPermissions = 0;
                    $check_nomenu = 0;

                    if ($child instanceof PDOStatement) {
                        while ($row2 = $child->fetch(PDO::FETCH_ASSOC)) {
                            if (in_array((string) $row2['id'], $sectionChild, true)) {
                                $countChildPermissions++;
                            }
                            if ((int) ($row2['show_menu'] ?? 1) === 1) {
                                $check_nomenu++;
                            }
                        }
                    }

                    if ($section->countChild($parent_id) > 0 && $countChildPermissions > 0 && $check_nomenu > 0) {
                        $hasSub = 'has-sub';
                        $link = 'javascript:void(0)';
                    }

                    if (($page ?? '') === $row['link']) {
                        $active = 'active';
                    }

                    if ($role_id === 1 || in_array((string) $row['id'], $sectionParent, true)) {
                        $labelDisplay = (string) $row['label'];
                        if (($lang ?? 'en') !== 'en') {
                            $locale_label = 'label_' . str_replace(' ', '_', strtolower((string) $row['label']));
                            if (isset($$locale_label)) {
                                $labelDisplay = (string) $$locale_label;
                            }
                        }
                        ?>
                        <li class="sidebar_li align-items-center <?= $active ?>">
                            <a href="<?= $link ?>" class="sidebar-link <?= $hasSub ?>">
                                <i class="bi bi-<?= htmlspecialchars((string) ($row['icon'] ?? 'circle'), ENT_QUOTES, 'UTF-8') ?>"></i>
                                <?= htmlspecialchars($labelDisplay, ENT_QUOTES, 'UTF-8') ?>
                            </a>
                            <?php if ($hasSub): ?>
                                <span class="toggle-submenu">+</span>
                                <ul class="submenu_damares list-unstyled" style="display: none;">
                                    <?php
                                    $section->parent_id = $parent_id;
                                    $child = $section->showAllChild();
                                    if ($child instanceof PDOStatement) {
                                        while ($row1 = $child->fetch(PDO::FETCH_ASSOC)) {
                                            if ($role_id === 1 || in_array((string) $row1['id'], $sectionChild, true)) {
                                                $display = ((int) ($row1['show_menu'] ?? 1) === 0) ? 'style="display:none;"' : '';
                                                $active1 = (($page ?? '') === $row1['link']) ? 'active' : '';

                                                $childLabel = (string) $row1['label'];
                                                if (($lang ?? 'en') !== 'en') {
                                                    $locale_label = 'label_' . str_replace(' ', '_', strtolower((string) $row1['label']));
                                                    if (isset($$locale_label)) {
                                                        $childLabel = (string) $$locale_label;
                                                    }
                                                }
                                                ?>
                                                <li class="<?= $active1 ?>">
                                                    <a href="index.php?p=<?= urlencode((string) $row1['link']) ?>" data-parent-id="<?= $parent_id ?>" <?= $display ?>>
                                                        <i class="bi bi-<?= htmlspecialchars((string) ($row1['icon'] ?? 'circle'), ENT_QUOTES, 'UTF-8') ?>"></i>
                                                        <span><?= htmlspecialchars($childLabel, ENT_QUOTES, 'UTF-8') ?></span>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function() {
        var currentPage = <?= json_encode($pageId ?? '') ?>;
        var parentPage = <?= json_encode($check_parent ?? 0) ?>;
        var parentOfChild = null;

        function openSubmenuNoAnimation($submenu) {
            $submenu.addClass('active').show();
            $submenu.prev('li').find('.toggle-submenu').text('-');
        }

        function openSubmenu($submenu) {
            $submenu.addClass('active').slideDown();
            $submenu.prev('li').find('.toggle-submenu').text('-');
        }

        function closeSubmenu($submenu) {
            $submenu.removeClass('active').slideUp();
            $submenu.prev('li').find('.toggle-submenu').text('+');
        }

        $('a[data-parent-id]').each(function() {
            var $this = $(this);
            var parentId = $this.data('parent-id');

            if (parentId == parentPage || parentId == currentPage) {
                var $submenu = $this.closest('li').find('.submenu_damares');
                openSubmenuNoAnimation($submenu);

                if (parentId == currentPage) {
                    parentOfChild = $this.data('parent-id');
                }
            }
        });

        if (parentOfChild !== null) {
            $('a[data-parent-id="' + parentOfChild + '"]').each(function() {
                var $submenu = $(this).closest('li').find('.submenu_damares');
                openSubmenuNoAnimation($submenu);
            });
        }

        $('.submenu_damares').each(function() {
            if ($(this).find('li.active').length > 0) {
                $(this).prev('a').addClass('active');
                openSubmenuNoAnimation($(this));
                $(this).prev('span').text('-');
            }
        });

        $('.toggle-submenu').on('click', function(e) {
            e.preventDefault();
            var $submenu = $(this).closest('li').find('.submenu_damares').first();

            if ($submenu.hasClass('active')) {
                closeSubmenu($submenu);
                $(this).text('+');
            } else {
                openSubmenu($submenu);
                $(this).text('-');
            }
        });

        $('a.has-sub').on('click', function(e) {
            e.preventDefault();
            var $submenu = $(this).closest('li').find('.submenu_damares').first();

            if ($submenu.hasClass('active')) {
                closeSubmenu($submenu);
            } else {
                openSubmenu($submenu);
            }
        });

        $('a[href="javascript:void(0)"]').on('click', function(e) {
            e.preventDefault();
        });

        $('#burger-menu').on('click', function() {
            $('#side_damares').toggleClass('active');
        });
    });
</script>

<style>
    .toggle-submenu {
        font-size: 1em;
        cursor: pointer;
        margin-left: 5px;
    }
</style>