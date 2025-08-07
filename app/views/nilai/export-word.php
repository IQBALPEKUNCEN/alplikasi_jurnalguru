<?php

use yii\helpers\Html;
?>
<h2 style="text-align:center;">Laporan Nilai Siswa</h2>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <?php foreach ($mapelList as $nama): ?>
                <th><?= Html::encode($nama) ?></th>
            <?php endforeach; ?>
            <th>Rata-rata</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($statistikSiswa as $i => $siswa): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= Html::encode($siswa['nis']) ?></td>
                <td><?= Html::encode($siswa['nama']) ?></td>
                <td><?= Html::encode($siswa['kelas']) ?></td>
                <td><?= Html::encode($siswa['jurusan']) ?></td>
                <?php foreach ($mapelList as $kode => $nama): ?>
                    <td><?= $siswa['mapel'][$kode]['nilai'] ?? '-' ?></td>
                <?php endforeach; ?>
                <td><?= number_format($siswa['rata_rata'] ?? 0, 1) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>