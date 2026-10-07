<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Mahasiswa;
use app\models\Dosen;
use app\models\Kriteria;
use app\models\Nilai;

class SiteController extends Controller
{
    /**
     * Dashboard
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'mhs' => Mahasiswa::find()
                ->orderBy(['id' => SORT_DESC])
                ->all(),

            'dosen' => Dosen::find()
                ->orderBy(['nama' => SORT_ASC])
                ->all(),

            'kriteria' => Kriteria::find()
                ->orderBy(['id' => SORT_ASC])
                ->all(),

            'nilai' => Nilai::find()
                ->with(['mahasiswa', 'dosen'])
                ->orderBy(['id' => SORT_DESC])
                ->all(),
        ]);
    }

    /**
     * Halaman Error
     */
    public function actionError()
    {
        $e = Yii::$app->errorHandler->exception;

        return $this->render('error', [
            'exception' => $e,
        ]);
    }

    /**
     * Reset Semua Data
     */
    public function actionResetAll()
    {
        // Reset hanya boleh melalui POST
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['site/index']);
        }

        $db = Yii::$app->db;

        try {

            // Matikan pengecekan foreign key sementara
            $db->createCommand(
                'SET FOREIGN_KEY_CHECKS = 0'
            )->execute();

            // Hapus seluruh data nilai
            $db->createCommand(
                'TRUNCATE TABLE nilai'
            )->execute();

            // Hapus seluruh data mahasiswa
            $db->createCommand(
                'TRUNCATE TABLE mahasiswa'
            )->execute();

            // Hapus seluruh data dosen
            $db->createCommand(
                'TRUNCATE TABLE dosen'
            )->execute();

            // Hapus seluruh data kriteria
            $db->createCommand(
                'TRUNCATE TABLE kriteria'
            )->execute();

            // Aktifkan kembali pengecekan foreign key
            $db->createCommand(
                'SET FOREIGN_KEY_CHECKS = 1'
            )->execute();

            // Pesan berhasil
            Yii::$app->session->setFlash(
                'success',
                'Semua data berhasil direset.'
            );

        } catch (\Exception $e) {

            // Pastikan foreign key kembali aktif
            $db->createCommand(
                'SET FOREIGN_KEY_CHECKS = 1'
            )->execute();

            // Pesan gagal
            Yii::$app->session->setFlash(
                'error',
                'Gagal mereset data: ' . $e->getMessage()
            );
        }

        // Kembali ke dashboard
        return $this->redirect(['site/index']);
    }
}