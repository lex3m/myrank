<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profession".
 *
 * @property integer $id
 * @property string $title
 * @property string $title_ua
 * @property string $title_en
 */
class Profession extends \yii\db\ActiveRecord {
    
    public $listProf;
    public $prefixLang = 'title_';

    /**
     * @inheritdoc
     */
    public static function tableName() {
	return 'profession';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
	    [['title', 'title_en', 'title_ua'], 'string', 'max' => 255],
	    [['listProf'], 'safe']
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'id' => Yii::t('app', 'PROFESSION_ID'),
	    'title' => Yii::t('app', 'PROFESSION_TITLE'),
	    'title_ua' => \Yii::t('app', 'PROFESSION_TITLE'). " UA",
	    'title_en' => \Yii::t('app', 'PROFESSION_TITLE'). " EN",
	    'listProf' => Yii::t('app', 'LIST'),
	];
    }
    
    public function beforeSave($insert) {
	if($this->listProf != "") {
	    $arr = explode("\n", $this->listProf);
	    foreach ($arr as $item) {
		if($this->title == "") {
		    $this->title = $item;
		} else {
		    $m = new Profession();
		    $m->title = $item;
		    $m->save();
		}
	    }
	}
	return parent::beforeSave($insert);
    }

}
