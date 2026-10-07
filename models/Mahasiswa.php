<?php namespace app\models; use yii\db\ActiveRecord;
class Mahasiswa extends ActiveRecord { public static function tableName(){return 'mahasiswa';} public function rules(){return [['nim','required'],['nim','string','max'=>30],['nama','required'],['nama','string','max'=>150],['judul','string','max'=>500]];} public function getNilai(){return $this->hasMany(Nilai::class,['mahasiswa_id'=>'id']);} }
