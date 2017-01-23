<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $contact_id
 * @property integer $company_id
 * @property integer $profileviews
 * @property integer $type
 * @property string $image
 * @property string $first_name
 * @property string $last_name
 * @property string $about
 * @property string $last_login
 * @property integer $rating
 * @property string $birthdate
 * @property string $gender
 * @property integer $city_id
 * @property string $phone
 * @property string $site
 */
class User extends \yii\db\ActiveRecord {
    
    const ROLE_USER_TYPE_USER = 0;
    const ROLE_USER_TYPE_MODERATOR = 1;
    const ROLE_USER_TYPE_ADMIN = 10;
    
    const ROLE_ACCESS_TYPE_STANDART = 0;
    const ROLE_ACCESS_TYPE_ADVANCED = 1;
    const ROLE_ACCESS_TYPE_PREMIUM = 2;
    
    const TYPE_USER_USER = 0;
    const TYPE_USER_COMPANY = 1;
    
    const GENDER_DEFAULT = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    
    public static $roleUser = [
	self::ROLE_USER_TYPE_USER => "user",
	self::ROLE_USER_TYPE_MODERATOR => "moderator",
	self::ROLE_USER_TYPE_ADMIN => "admin"
    ];
    
    public static $roleAccess = [
	self::ROLE_ACCESS_TYPE_STANDART => "standart",
	self::ROLE_ACCESS_TYPE_ADVANCED => "advanced",
	self::ROLE_ACCESS_TYPE_PREMIUM => "premium",
    ];
    
    public static $typeUser = [
	self::TYPE_USER_USER => "user",
	self::TYPE_USER_COMPANY => "company",
    ];
    
    public $gender = [
	self::GENDER_DEFAULT => "default",
	self::GENDER_MALE => "Male",
	self::GENDER_FEMALE => "FEMALE"
    ];

    /**
     * @inheritdoc
     */
    public static function tableName() {
	return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
	    [['account_id', 'contact_id', 'company_id', 'profileviews', 'rating'], 'integer'],
	    [['last_login', 'birthdate', 'city_id', 'phone', 'site'], 'safe'],
	    [['profile_company', 'gender'], 'string', 'max' => 40],
	    [['image'], 'string', 'max' => 255],
	    [['first_name', 'last_name', 'about'], 'string', 'max' => 50],
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'id' => Yii::t('app', 'ID'),
	    'account_id' => Yii::t('app', 'Account ID'),
	    'contact_id' => Yii::t('app', 'Contact ID'),
	    'company_id' => Yii::t('app', 'Company ID'),
	    'profileviews' => Yii::t('app', 'Profileviews'),
	    'profile_company' => Yii::t('app', 'Profile Company'),
	    'image' => Yii::t('app', 'Image'),
	    'first_name' => Yii::t('app', 'First Name'),
	    'last_name' => Yii::t('app', 'Last Name'),
	    'about' => Yii::t('app', 'About'),
	    'last_login' => Yii::t('app', 'Last Login'),
	    'rating' => Yii::t('app', 'Rating'),
	    'birthdate' => Yii::t('app', 'Birthdate'),
	    'gender' => Yii::t('app', 'Gender'),
	];
    }
    
    public function getCity () {
	return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }
    
    public function getFullName () {
	return $this->first_name." ".$this->last_name;
    }
    
    public function getCityName () {
	return ($this->city_id == 0) ? "Не задано" : $this->getCity()->name;
    }

}
