<?php

use yii\helpers\Html;

if (empty($models)): ?>
    <div class="alert alert-info">
        <strong>Info:</strong> Tidak ada pengumuman yang tersedia.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($models as $model): ?>
                    <tr>
                        <td>
                            <?php if ($model->status_kirim != 'terkirim'): ?>
                                <input type="checkbox" name="pengumuman_ids[]" value="<?= $model->history_id ?>">
                            <?php else: ?>
                                <span class="text-success">✓</span>
                            <?php endif; ?>
                        </td>
                        <td><?= Html::encode($model->judul_pengumuman) ?></td>
                        <td><?= Html::encode($model->isi_pengumuman) ?></td>
                        <td><?= $model->kodeKelas ? Html::encode($model->kodeKelas->kode_kelas) : '-' ?></td>
                        <td><?= date('d/m/Y', strtotime($model->tanggal_pengumuman)) ?></td>
                        <td><?= Html::encode($model->status_kirim) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>