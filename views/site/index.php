<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Nilai;
use app\models\Mahasiswa;

$this->title = 'SIDANG - Penilaian Skripsi UAJ';

$rekap = [];

foreach ($nilai as $n) {
    $rekap[$n->mahasiswa_id][] = (float) $n->total;
}
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>

    <div class="alert alert-success">
        <?= Html::encode(Yii::$app->session->getFlash('success')) ?>
    </div>

<?php endif; ?>


<?php if (Yii::$app->session->hasFlash('error')): ?>

    <div class="alert alert-danger">
        <?= Html::encode(Yii::$app->session->getFlash('error')) ?>
    </div>

<?php endif; ?>


<div class="header">

    <div>
        <h1>SIDANG</h1>
        <p>Sistem Penilaian Sidang Skripsi</p>
        <b>UNIVERSITAS AL HIKMAH JEPARA</b>
    </div>

    <div>

        <?= Html::a(
            'Export CSV',
            ['nilai/export'],
            [
                'class' => 'btn dark'
            ]
        ) ?>

        <?= Html::beginForm(
            ['site/reset-all'],
            'post',
            [
                'style' => 'display:inline-block; margin-left:10px;',
                'onsubmit' => "return confirm('PERINGATAN! Semua data mahasiswa, dosen, kriteria, dan nilai akan dihapus. Yakin ingin mereset semua data?');"
            ]
        ) ?>

            <?= Html::submitButton(
    'Reset Semua Data',
    [
        'class' => 'btn',
        'style' => 'background:#dc2626 !important; color:#ffffff !important; border:none;'
    ]

            ) ?>

        <?= Html::endForm() ?>

    </div>

</div>


<div class="stats">

    <div>
        <small>Mahasiswa</small>
        <strong><?= count($mhs) ?></strong>
    </div>

    <div>
        <small>Dosen Penguji</small>
        <strong><?= count($dosen) ?></strong>
    </div>

    <div>
        <small>Sidang Dinilai</small>
        <strong><?= count($nilai) ?></strong>
    </div>

</div>


<div class="grid">

    <section>

        <!-- DATA MAHASISWA -->
        <div class="card">

            <h2>Data Mahasiswa</h2>

            <a
                class="btn blue full"
                href="<?= Url::to(['mahasiswa/create']) ?>"
            >
                + Tambah Mahasiswa
            </a>

            <?php foreach ($mhs as $x): ?>

                <div class="item">

                    <span>
                        <b><?= Html::encode($x->nim) ?></b>
                        <?= Html::encode($x->nama) ?>
                    </span>

                    <a
                        class="danger"
                        href="<?= Url::to(['mahasiswa/delete', 'id' => $x->id]) ?>"
                        onclick="return confirm('Hapus mahasiswa?')"
                    >
                        x
                    </a>

                </div>

            <?php endforeach; ?>

        </div>


        <!-- DOSEN PENGUJI -->
        <div class="card">

            <h2>Dosen Penguji</h2>

            <a
                class="btn dark full"
                href="<?= Url::to(['dosen/create']) ?>"
            >
                + Tambah Dosen
            </a>

            <?php foreach ($dosen as $x): ?>

                <div class="pill">

                    <?= Html::encode($x->nama) ?>

                    <a
                        href="<?= Url::to(['dosen/delete', 'id' => $x->id]) ?>"
                        onclick="return confirm('Hapus dosen?')"
                    >
                        x
                    </a>

                </div>

            <?php endforeach; ?>

        </div>


        <!-- KRITERIA NILAI -->
        <div class="card">

            <h2>Kriteria Nilai</h2>

            <a
                class="btn light full"
                href="<?= Url::to(['kriteria/create']) ?>"
            >
                + Tambah Kriteria
            </a>

            <?php foreach ($kriteria as $x): ?>

                <div class="item">

                    <span>
                        <?= Html::encode($x->nama) ?>
                    </span>

                    <span>

                        <?= Html::encode($x->bobot) ?>%

                        <a
                            class="danger"
                            href="<?= Url::to(['kriteria/delete', 'id' => $x->id]) ?>"
                            onclick="return confirm('Hapus kriteria?')"
                        >
                            x
                        </a>

                    </span>

                </div>

            <?php endforeach; ?>

        </div>

    </section>


    <section class="wide">

        <!-- PENILAIAN SIDANG -->
        <div class="card">

            <div class="row">

                <h2>Penilaian Sidang</h2>

                <a
                    class="btn blue"
                    href="<?= Url::to(['nilai/create']) ?>"
                >
                    + Input Nilai
                </a>

            </div>


            <table>

                <thead>

                    <tr>
                        <th>NIM</th>
                        <th>Mahasiswa</th>
                        <th>Dosen</th>
                        <th>Nilai</th>
                        <th>Huruf</th>
                        <th>Aksi</th>
                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($nilai as $n): ?>

                        <tr>

                            <td>
                                <?= Html::encode($n->mahasiswa->nim) ?>
                            </td>

                            <td>
                                <?= Html::encode($n->mahasiswa->nama) ?>
                            </td>

                            <td>
                                <?= Html::encode($n->dosen->nama) ?>
                            </td>

                            <td>
                                <b><?= Html::encode($n->total) ?></b>
                            </td>

                            <td>

                                <span class="grade">
                                    <?= Nilai::huruf($n->total) ?>
                                </span>

                            </td>

                            <td>

                                <a
                                    class="danger"
                                    href="<?= Url::to(['nilai/delete', 'id' => $n->id]) ?>"
                                    onclick="return confirm('Hapus nilai?')"
                                >
                                    hapus
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>


        <!-- REKAP OTOMATIS -->
        <div class="card darkbox">

            <small>REKAP OTOMATIS</small>

            <?php foreach ($rekap as $mid => $arr): ?>

                <?php

                $avg = round(
                    array_sum($arr) / count($arr),
                    2
                );

                $ma = Mahasiswa::findOne($mid);

                ?>

                <?php if ($ma): ?>

                    <div class="rec">

                        <span>
                            <?= Html::encode($ma->nama) ?>
                        </span>

                        <span>

                            <?= Html::encode($avg) ?>

                            (<?= Nilai::huruf($avg) ?>)

                            -

                            <?= count($arr) ?>

                            penguji

                        </span>

                    </div>

                <?php endif; ?>

            <?php endforeach; ?>


            <?php if (!$rekap): ?>

                <span>Belum ada nilai</span>

            <?php endif; ?>

        </div>

    </section>

</div>