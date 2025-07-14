<?php
/**
 * Alert Component
 * 
 * @param string $type - Type alert (success, danger, warning, info)
 * @param string $message - Pesan alert
 * @param bool $dismissible - Apakah alert bisa ditutup
 * @param string $icon - Icon untuk alert (optional)
 */

// Default values
$type = $type ?? 'info';
$dismissible = $dismissible ?? true;
$icon = $icon ?? '';

// Icon mapping
$icon_map = [
    'success' => 'fas fa-check-circle',
    'danger' => 'fas fa-exclamation-triangle',
    'warning' => 'fas fa-exclamation-circle',
    'info' => 'fas fa-info-circle'
];

$icon = $icon ?: ($icon_map[$type] ?? '');
?>

<?php if (isset($message) && !empty($message)): ?>
<div class="alert alert-<?= $type ?> <?= $dismissible ? 'alert-dismissible' : '' ?> fade show" role="alert">
    <?php if ($icon): ?>
    <i class="<?= $icon ?> mr-2"></i>
    <?php endif; ?>
    
    <?= htmlspecialchars($message) ?>
    
    <?php if ($dismissible): ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php endif; ?>
</div>
<?php endif; ?> 