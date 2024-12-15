<?php
// Menu data
$menuItems = [
  [
    'icon' => 'airplay',
    'label' => 'Dashboard',
    'href' => '/staff-and-scheduling/index.php',
  ],
  [
    'icon' => 'table-2',
    'label' => 'Wards',
    'href' => '/staff-and-scheduling/wardList.php',
  ],

  [
    'icon' => 'list',
    'label' => 'Patient list',
    'href' => '/staff-and-scheduling/patientList.php',
  ],
  [
    'icon' => 'list',
    'label' => 'Order',
    'href' => '/staff-and-scheduling/orderList.php',
  ],
  [
    'icon' => 'list',
    'label' => 'Inventory',
    'href' => '/staff-and-scheduling/itemList.php',
  ],
  [
    'icon' => 'list',
    'label' => 'Physician List',
    'href' => '/staff-and-scheduling/physicianList.php',
  ],
  [
    'icon' => 'list',
    'label' => 'Staff',
    'href' => '/staff-and-scheduling/staffList.php',
  ],
  [
    'icon' => 'list',
    'label' => 'Vendors',
    'href' => '/staff-and-scheduling/vendorList.php',
  ],
  [
    'icon' => 'Log out',
    'label' => 'Log out',
    'href' => '/staff-and-scheduling/logout.php',
  ],
];

// Get current path (assuming you're using this in a web server context)
$currentPath = $_SERVER['REQUEST_URI'];
?>

<div class="drawer-side">
  <label for="sidebar" aria-label="close sidebar" class="drawer-overlay"></label>
  <ul class="menu bg-base-100 border-r text-base-content min-h-full w-80 p-4">
    <?php foreach ($menuItems as $item): ?>
      <li>
        <a href="<?= $item["href"] ?>" class="<?= $item['href'] === $currentPath ? 'bg-base-300' : ''; ?>">
          <div class="flex items-center gap-2">
            <i data-lucide="<?= $item['icon']; ?>" class="h-4 w-4"></i>
            <?= htmlspecialchars($item['label']); ?>
          </div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>