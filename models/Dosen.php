<?php namespace app\models; use yii\db\ActiveRecord;
class Dosen extends ActiveRecord { public static function tableName(){return 'dosen';} public function rules(){return [['nama','required'],['nama','string','max'=>150]];} public function getNilai(){return $this->hasMany(Nilai::class,['dosen_id'=>'id']);} }
