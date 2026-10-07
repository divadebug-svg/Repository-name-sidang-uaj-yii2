<?php namespace app\models; use yii\db\ActiveRecord;
class Kriteria extends ActiveRecord { public static function tableName(){return 'kriteria';} public function rules(){return [['nama','required'],['bobot','required'],['bobot','integer','min'=>1,'max'=>100]];} }
