<?php
/**
 * CRUD Table Component
 * 
 * @param array $data - Data untuk ditampilkan
 * @param array $columns - Konfigurasi kolom
 * @param string $table_name - Nama tabel
 * @param string $add_url - URL untuk tambah data
 * @param string $edit_url - URL untuk edit data
 * @param string $delete_url - URL untuk delete data
 */

// Default values
$table_name = $table_name ?? 'Data';
$add_url = $add_url ?? '#';
$edit_url = $edit_url ?? '#';
$delete_url = $delete_url ?? '#';
$primary_key = $primary_key ?? 'id';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><?= $table_name ?></h6>
        <a href="<?= $add_url ?>" class="btn btn-gradient btn-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah <?= $table_name ?>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column): ?>
                        <th><?= $column['label'] ?></th>
                        <?php endforeach; ?>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $row): ?>
                        <tr>
                            <?php foreach ($columns as $column): ?>
                            <td>
                                <?php if (isset($column['format'])): ?>
                                    <?= call_user_func($column['format'], $row[$column['field']], $row) ?>
                                <?php else: ?>
                                    <?= htmlspecialchars($row[$column['field']] ?? '') ?>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= $edit_url ?>?id=<?= $row[$primary_key] ?>" 
                                       class="btn btn-info btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            title="Hapus"
                                            onclick="confirmDelete('<?= $delete_url ?>?id=<?= $row[$primary_key] ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($columns) + 1 ?>" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 