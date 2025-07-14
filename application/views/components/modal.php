<?php
/**
 * Modal Component
 * 
 * @param string $id - ID modal
 * @param string $title - Judul modal
 * @param string $content - Konten modal
 * @param string $size - Ukuran modal (sm, lg, xl)
 * @param array $buttons - Array tombol
 * @param bool $centered - Apakah modal di tengah
 * @param bool $scrollable - Apakah modal bisa di-scroll
 */

// Default values
$size = $size ?? '';
$centered = $centered ?? true;
$scrollable = $scrollable ?? false;
$buttons = $buttons ?? [];
?>

<div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $id ?>Label" aria-hidden="true">
    <div class="modal-dialog <?= $size ? 'modal-' . $size : '' ?> <?= $centered ? 'modal-dialog-centered' : '' ?> <?= $scrollable ? 'modal-dialog-scrollable' : '' ?>" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>Label"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $content ?>
            </div>
            <?php if (!empty($buttons)): ?>
            <div class="modal-footer">
                <?php foreach ($buttons as $button): ?>
                <button type="button" 
                        class="btn btn-<?= $button['type'] ?? 'secondary' ?> <?= isset($button['class']) ? $button['class'] : '' ?>"
                        <?= isset($button['onclick']) ? 'onclick="' . $button['onclick'] . '"' : '' ?>
                        <?= isset($button['data_dismiss']) && $button['data_dismiss'] ? 'data-dismiss="modal"' : '' ?>>
                    <?php if (isset($button['icon'])): ?>
                    <i class="<?= $button['icon'] ?>"></i>
                    <?php endif; ?>
                    <?= $button['text'] ?>
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div> 