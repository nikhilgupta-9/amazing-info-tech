<?php
$currentPage = basename($_SERVER['PHP_SELF']);

// Each entry: section header (string) or [label, icon, href] / [label, icon, [[label, href], ...]]
$adminMenu = [
  'Main',
  ['Dashboard', 'fa-dashboard', 'index.php'],

  'Content',
  ['Events & Expos', 'fa-calendar', [
    ['Add Event', 'add-event.php'],
    ['View Events', 'view-events.php'],
  ]],
  ['Awards & Recognition', 'fa-trophy', [
    ['Add Award / News', 'add-news-event.php'],
    ['View Awards', 'view-newsevent.php'],
  ]],
  ['Blogs', 'fa-pencil-square-o', [
    ['Add Blogs', 'add-blog.php'],
    ['View Blogs', 'view-blog.php'],
  ]],
  ['Banner', 'fa-sliders', [
    ['Add Banner', 'add-banner.php'],
    ['View Banner', 'view-banner.php'],
  ]],
  ['Gallery', 'fa-picture-o', 'view-gallery.php'],
  ['Miscellaneous', 'fa-puzzle-piece', [
    ['Manage Features', 'why.php'],
    ['Manage Testimonials', 'days.php'],
  ]],

  'Catalog',
  ['Products', 'fa-cubes', [
    ['Add Products', 'add-product.php?backid=0&proid=2'],
    ['View Products', 'view-product.php?backid=0&proid=2'],
  ]],
  ['Brands', 'fa-tags', [
    ['Add Brands', 'add-team.php'],
    ['View Brands', 'view-team.php'],
  ]],
  ['Orders', 'fa-shopping-cart', 'orders.php'],

  'Site Settings',
  ['Logo', 'fa-image', 'add-logo.php'],
  ['Menu', 'fa-bars', [
    ['Add Menu', 'cms.php'],
    ['View Menu', 'view-menu.php'],
  ]],
  ['Contact Details', 'fa-phone', 'view-contact-detail.php'],

  'Enquiries',
  ['Manage Enquiry', 'fa-envelope-o', 'view-managecontact.php'],

  'Account',
  ['Change Password', 'fa-lock', 'change_password.php'],
];

$isCurrent = function ($href) use ($currentPage) {
  return strtok($href, '?') === $currentPage;
};
?>
<aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <?php foreach ($adminMenu as $item): ?>
          <?php if (is_string($item)): ?>
            <li class="header"><?php echo htmlspecialchars($item); ?></li>
          <?php elseif (is_array($item[2])): ?>
            <?php
            $open = false;
            foreach ($item[2] as $child) {
              if ($isCurrent($child[1])) {
                $open = true;
              }
            }
            ?>
            <li class="treeview<?php echo $open ? ' active menu-open' : ''; ?>">
              <a href="#">
                <i class="fa <?php echo $item[1]; ?>"></i> <span><?php echo htmlspecialchars($item[0]); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php foreach ($item[2] as $child): ?>
                  <li<?php echo $isCurrent($child[1]) ? ' class="active"' : ''; ?>>
                    <a href="<?php echo htmlspecialchars($child[1]); ?>"><i class="fa fa-circle-o"></i> <?php echo htmlspecialchars($child[0]); ?></a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </li>
          <?php else: ?>
            <li<?php echo $isCurrent($item[2]) ? ' class="active"' : ''; ?>>
              <a href="<?php echo htmlspecialchars($item[2]); ?>">
                <i class="fa <?php echo $item[1]; ?>"></i> <span><?php echo htmlspecialchars($item[0]); ?></span>
              </a>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
