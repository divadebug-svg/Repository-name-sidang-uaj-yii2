<?php namespace app\models; use yii\db\ActiveRecord;
class Nilai extends ActiveRecord {
 public static function tableName(){return 'nilai';}
 public function rules(){return [['mahasiswa_id','required'],['dosen_id','required'],['tanggal','required'],['nilai_data','safe'],['total','number']];}
 public function getMahasiswa(){return $this->hasOne(Mahasiswa::class,['id'=>'mahasiswa_id']);}
 public function getDosen(){return $this->hasOne(Dosen::class,['id'=>'dosen_id']);}
 public static function huruf($n){if($n>=85)return 'A'; if($n>=75)return 'B'; if($n>=65)return 'C'; return 'D';}
 public function hitungTotal(){ $data=json_decode($this->nilai_data,true) ?: []; $ks=Kriteria::find()->all(); $total=0; foreach($ks as $k){$total += ((float)($data[$k->id] ?? 0))*$k->bobot/100;} return round($total,2); }
}
