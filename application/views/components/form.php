<?php
/**
 * Form Component
 * 
 * @param array $fields - Konfigurasi field form
 * @param string $form_title - Judul form
 * @param string $action_url - URL action form
 * @param string $method - Method form (POST/GET)
 * @param array $data - Data untuk edit (optional)
 * @param string $submit_text - Text tombol submit
 */

// Default values
$form_title = $form_title ?? 'Form';
$action_url = $action_url ?? '#';
$method = $method ?? 'POST';
$submit_text = $submit_text ?? 'Simpan';
$data = $data ?? [];
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $form_title ?></h6>
    </div>
    <div class="card-body">
        <form action="<?= $action_url ?>" method="<?= $method ?>" id="formData">
            
            <?php foreach ($fields as $field): ?>
            <div class="form-group">
                <label for="<?= $field['name'] ?>">
                    <?= $field['label'] ?>
                    <?php if (isset($field['required']) && $field['required']): ?>
                        <span class="text-danger">*</span>
                    <?php endif; ?>
                </label>
                
                <?php if ($field['type'] == 'text' || $field['type'] == 'email' || $field['type'] == 'password' || $field['type'] == 'number'): ?>
                    <input type="<?= $field['type'] ?>" 
                           class="form-control <?= isset($field['class']) ? $field['class'] : '' ?>" 
                           id="<?= $field['name'] ?>" 
                           name="<?= $field['name'] ?>"
                           value="<?= htmlspecialchars($data[$field['name']] ?? '') ?>"
                           <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                           <?= isset($field['placeholder']) ? 'placeholder="' . $field['placeholder'] . '"' : '' ?>
                           <?= isset($field['attributes']) ? $field['attributes'] : '' ?>>
                
                <?php elseif ($field['type'] == 'textarea'): ?>
                    <textarea class="form-control <?= isset($field['class']) ? $field['class'] : '' ?>" 
                              id="<?= $field['name'] ?>" 
                              name="<?= $field['name'] ?>"
                              rows="<?= $field['rows'] ?? 3 ?>"
                              <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                              <?= isset($field['placeholder']) ? 'placeholder="' . $field['placeholder'] . '"' : '' ?>
                              <?= isset($field['attributes']) ? $field['attributes'] : '' ?>><?= htmlspecialchars($data[$field['name']] ?? '') ?></textarea>
                
                <?php elseif ($field['type'] == 'select'): ?>
                    <select class="form-control <?= isset($field['class']) ? $field['class'] : '' ?>" 
                            id="<?= $field['name'] ?>" 
                            name="<?= $field['name'] ?>"
                            <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                            <?= isset($field['attributes']) ? $field['attributes'] : '' ?>>
                        <option value="">Pilih <?= $field['label'] ?></option>
                        <?php if (isset($field['options'])): ?>
                            <?php foreach ($field['options'] as $value => $label): ?>
                            <option value="<?= $value ?>" <?= ($data[$field['name']] ?? '') == $value ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                
                <?php elseif ($field['type'] == 'radio'): ?>
                    <div>
                        <?php if (isset($field['options'])): ?>
                            <?php foreach ($field['options'] as $value => $label): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="<?= $field['name'] ?>" 
                                       id="<?= $field['name'] ?>_<?= $value ?>" 
                                       value="<?= $value ?>"
                                       <?= ($data[$field['name']] ?? '') == $value ? 'checked' : '' ?>
                                       <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>>
                                <label class="form-check-label" for="<?= $field['name'] ?>_<?= $value ?>">
                                    <?= $label ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                
                <?php elseif ($field['type'] == 'checkbox'): ?>
                    <div>
                        <?php if (isset($field['options'])): ?>
                            <?php foreach ($field['options'] as $value => $label): ?>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="<?= $field['name'] ?>[]" 
                                       id="<?= $field['name'] ?>_<?= $value ?>" 
                                       value="<?= $value ?>"
                                       <?= in_array($value, $data[$field['name']] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="<?= $field['name'] ?>_<?= $value ?>">
                                    <?= $label ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                
                <?php elseif ($field['type'] == 'date'): ?>
                    <input type="date" 
                           class="form-control <?= isset($field['class']) ? $field['class'] : '' ?>" 
                           id="<?= $field['name'] ?>" 
                           name="<?= $field['name'] ?>"
                           value="<?= htmlspecialchars($data[$field['name']] ?? '') ?>"
                           <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                           <?= isset($field['attributes']) ? $field['attributes'] : '' ?>>
                
                <?php elseif ($field['type'] == 'datetime-local'): ?>
                    <input type="datetime-local" 
                           class="form-control <?= isset($field['class']) ? $field['class'] : '' ?>" 
                           id="<?= $field['name'] ?>" 
                           name="<?= $field['name'] ?>"
                           value="<?= htmlspecialchars($data[$field['name']] ?? '') ?>"
                           <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                           <?= isset($field['attributes']) ? $field['attributes'] : '' ?>>
                
                <?php elseif ($field['type'] == 'file'): ?>
                    <input type="file" 
                           class="form-control-file <?= isset($field['class']) ? $field['class'] : '' ?>" 
                           id="<?= $field['name'] ?>" 
                           name="<?= $field['name'] ?>"
                           <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                           <?= isset($field['accept']) ? 'accept="' . $field['accept'] . '"' : '' ?>
                           <?= isset($field['attributes']) ? $field['attributes'] : '' ?>>
                
                <?php endif; ?>
                
                <?php if (isset($field['help_text'])): ?>
                    <small class="form-text text-muted"><?= $field['help_text'] ?></small>
                <?php endif; ?>
                
                <?php if (isset($field['error'])): ?>
                    <div class="invalid-feedback d-block"><?= $field['error'] ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            
            <div class="form-group">
                <button type="submit" class="btn btn-gradient">
                    <i class="fas fa-save"></i> <?= $submit_text ?>
                </button>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Form validation
document.getElementById('formData').addEventListener('submit', function(e) {
    if (!validateForm('formData')) {
        e.preventDefault();
        return false;
    }
});
</script> 