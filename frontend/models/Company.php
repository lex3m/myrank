<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property integer $conut_persons
 * @property string $reg_date
 * @property integer $cash
 * @property integer $city_id
 * @property string $director
 * @property string $contact_face
 * @property string $about
 */
class Company extends \yii\db\ActiveRecord {
    
    public $country_id;
    public $professionField;
    
    const COUNT_PERSONS_SMALL = 1;
    const COUNT_PERSONS_MEDIUM = 2;
    const COUNT_PERSONS_BIG = 3;
    
    const CASH_SMALL = 1;
    const CASH_MEDIUM = 2;
    const CASH_BIG = 3;
    
    public $countPersonsList = [
	self::COUNT_PERSONS_SMALL => "100 - 500",
	self::COUNT_PERSONS_MEDIUM => "100 - 1000",
	self::COUNT_PERSONS_BIG => "100 - 1500",
    ];
    
    public $cashList = [
	self::CASH_SMALL => "1 000 000 руб - 5 000 000 руб",
	self::CASH_MEDIUM => "1 000 000 руб - 10 000 000 руб",
	self::CASH_BIG => "1 000 000 руб - 15 000 000 руб",
    ];
    
    public $user_id;

    /**
     * @inheritdoc
     */
    public static function tableName() {
	return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
	    [['name', 'reg_date'], 'required'],
	    [['professionField'], 'required', 'on' => 'editmaininfo'],
	    [['count_persons', 'cash'], 'integer'],
	    [['reg_date', 'user_id', 'city_id', 'professionField'], 'safe'],
	    [['about'], 'string'],
	    [['phone', 'director', 'contact_face'], 'string', 'max' => 255],
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'id' => Yii::t('app', 'ID'),
	    'name' => Yii::t('app', 'Название компании'),
	    'phone' => Yii::t('app', 'Телефон компании'),
	    'count_persons' => Yii::t('app', 'Количество сотрудников'),
	    'reg_date' => Yii::t('app', 'Дата регистрации компании'),
	    'cash' => Yii::t('app', 'Ежегодный оборот компании'),
	    'director' => Yii::t('app', 'Фио директора'),
	    'contact_face' => Yii::t('app', 'Контактное лицо'),
	    'about' => Yii::t('app', 'Информация о компании'),
	];
    }
    
    public function getCity () {
	return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }
    
    public function getCountryCity() {
	return $this->city->country_id;
    }
    
    public function getFullName () {
	return $this->name;
    }
    
    public function saveProfession() {
	if (isset($this->professionField) && (count($this->professionField) > 0)) {
	    CompanyProfession::deleteAll(['company_id' => $this->id]);
	    foreach ($this->professionField as $item) {
		$mProf = new CompanyProfession();
		$mProf->attributes = [
		    'company_id' => $this->id,
		    'profession_id' => $item,
		];
		$mProf->save();
	    }
	}
    }
    
    public function getCityName() {
	return ($this->city_id == 0) ? FALSE : $this->getCity()->one()->name;
    }
    
    public function getCountryName() {
	return ($this->city_id == 0) ? FALSE : $this->getCity()->one()->countryName;
    }
    
    public function getPosition() {
	return $this->getCityName() && $this->getCountryName() ? $this->getCityName() . ", " . $this->getCountryName() : "Не указано";
    }
    
    public function getProfession () {
	return $this->hasMany(CompanyProfession::className(), ['company_id' => 'id']);
    }
    
    public function getCompanyProfession() {
	return $this->hasMany(Profession::className(), ['id' => 'profession_id'])->via("profession");
    }
    
    public function beforeSave($insert) {
	isset($this->id) ? $this->saveProfession() : NULL;
	return parent::beforeSave($insert);
    }

}
