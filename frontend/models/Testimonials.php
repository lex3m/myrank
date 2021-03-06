<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "testimonials".
 *
 * @property integer $id
 * @property string $text
 * @property integer $status
 * @property integer $who_from_to
 * @property integer $user_from
 * @property integer $user_to
 * @property integer $smile
 * @property integer $parent_id
 * @property string $created
 */
class Testimonials extends \yii\db\ActiveRecord {

    const SMILE_CLASS_POSITIVE = 2;
    const SMILE_CLASS_NEGATIVE = 1;
    const SMILE_CLASS_NEUTRAL = 0;
    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_MODERATION = 2;

    public static $smiles = [
        self::SMILE_CLASS_POSITIVE => 'b-comments__item__smile_positive',
        self::SMILE_CLASS_NEGATIVE => 'b-comments__item__smile_negative',
        self::SMILE_CLASS_NEUTRAL => 'b-comments__item__smile_neutral',
    ];
    
    public static $smilesSmall = [
        self::SMILE_CLASS_POSITIVE  => 'b-small-message__smile_positive',
        self::SMILE_CLASS_NEGATIVE  => 'b-small-message__smile_negative',
        self::SMILE_CLASS_NEUTRAL   => 'b-small-message__smile_neutral',
    ];

    const WHO_FROM_TO_NONE = 0;
    const WHO_FROM_TO_DIRECTOR = 1;
    const WHO_FROM_TO_CHIEF = 2;
    const WHO_FROM_TO_COLLEAGUE = 3;
    const WHO_FROM_TO_CLOSE_RELATIVE = 4;
    const WHO_FROM_TO_RELATIVE = 5;
    const WHO_FROM_TO_FRIEND = 6;
    const WHO_FROM_TO_FAMILIAR = 7;
    const WHO_FROM_TO_SLAVE = 8;
    const WHO_FROM_TO_UNKNOW = 9;
    const WHO_FROM_TO_ANONIM = 10;

    public static function whoFromTo($id = Null) {
        $arr = [
            self::WHO_FROM_TO_NONE => (string) \Yii::t('app', 'WHO_FROM_TO_NONE'),
            self::WHO_FROM_TO_DIRECTOR => (string) \Yii::t('app', 'WHO_FROM_TO_DIRECTOR'),
            self::WHO_FROM_TO_CHIEF => (string) \Yii::t('app', 'WHO_FROM_TO_CHIEF'),
            self::WHO_FROM_TO_COLLEAGUE => (string) \Yii::t('app', 'WHO_FROM_TO_COLLEAGUE'),
            self::WHO_FROM_TO_CLOSE_RELATIVE => (string) \Yii::t('app', 'WHO_FROM_TO_CLOSE_RELATIVE'),
            self::WHO_FROM_TO_RELATIVE => (string) \Yii::t('app', 'WHO_FROM_TO_RELATIVE'),
            self::WHO_FROM_TO_FRIEND => (string) \Yii::t('app', 'WHO_FROM_TO_FRIEND'),
            self::WHO_FROM_TO_FAMILIAR => (string) \Yii::t('app', 'WHO_FROM_TO_FAMILIAR'),
            self::WHO_FROM_TO_SLAVE => (string) \Yii::t('app', 'WHO_FROM_TO_SLAVE'),
            self::WHO_FROM_TO_UNKNOW => (string) \Yii::t('app', 'WHO_FROM_TO_UNKNOW'),
            //self::WHO_FROM_TO_ANONIM => (string) \Yii::t('app', 'WHO_FROM_TO_ANONIM'),
        ];
        if(isset($id)) {
            return $arr[$id];
        }
        return $arr;
    }

    const COUNT_LIST = 10;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'testimonials';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['from_id', 'to_id', 'smile', 'who_from_to', 'text'], 'required'],
            [['text'], 'string'],
            [['type_from', 'from_id', 'type_to', 'to_id', 'smile', 'parent_id'], 'integer'],
            [['user_from', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'TESTIMONIALS_TEXT'),
            'from_id' => Yii::t('app', 'USER_FROM'),
            'to_id' => Yii::t('app', 'USER_TO'),
            'smile' => Yii::t('app', 'SMILE'),
            'parent_id' => Yii::t('app', 'PARENT_ID'),
            'created' => Yii::t('app', 'CREATED'),
        ];
    }

    public function getObjFrom() {
        return ($this->type_from == UserConstant::TYPE_USER_COMPANY) ? Company::className() : User::className();
    }
    
    public function getObjTo () {
        return ($this->type_to == UserConstant::TYPE_USER_COMPANY) ? Company::className() : User::className();
    }

    public function getUserFrom() {
        return $this->hasOne($this->objFrom, ['id' => 'from_id']);
    }

    public function getUserTo() {
        return $this->hasOne($this->objTo, ['id' => 'to_id']);
    }
    
    public function getUserFromName () {
        return $this->isAnonim ? "****" : $this->userFrom->fullName;
    }
    
    public function getUserFromImage () {
        return $this->isAnonim ? 
                $this->userFrom->noPhoto : 
                $this->userFrom->imageName;
    }

    public function getAnswer() {
        return $this->hasOne(Testimonials::className(), ['parent_id' => 'id'])->from(Testimonials::tableName(). ' ta');
        //return static::findOne(['parent_id' => $this->id]); // Even not singleton? Facepalm...
    }

    public function beforeSave($insert) {
        if (!isset($this->status)) {
            $this->status = self::STATUS_ACTIVE;
        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete() {
        static::deleteAll(['parent_id' => $this->id]);
        return parent::beforeDelete();
    }
    
    public function getIsAnonim () {
        return $this->who_from_to == self::WHO_FROM_TO_ANONIM;
    }

}
