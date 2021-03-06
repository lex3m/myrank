<?php

namespace frontend\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "static_pages".
 *
 * @property string $id
 * @property string $title
 * @property string $alias
 * @property integer $published
 * @property string $content
 * @property string $title_browser
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $create_time
 * @property string $update_time
 */
class StaticPages extends \yii\db\ActiveRecord
{
    const PUBLISHED_NO = 0;
    const PUBLISHED_YES = 1;

    /*public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_time', 'updated_time'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_time'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }*/

    public static function tableName()
    {
        return 'static_pages';
    }

    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['published'], 'integer'],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['title', 'alias', 'title_browser'], 'string', 'max' => 128],
            [['locale'], 'string', 'max' => 5],
            [['meta_keywords'], 'string', 'max' => 200],
            [['meta_description'], 'string', 'max' => 160],
            //[['alias'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'TITLE'),
            'alias' => Yii::t('app', 'ALIAS'),
            'published' => Yii::t('app', 'PUBLISHED'),
            'content' => Yii::t('app', 'CONTENT'),
            'locale' => Yii::t('app', 'LOCALE'),
            'title_browser' => Yii::t('app', 'TITLE_BROWSER'),
            'meta_keywords' => Yii::t('app', 'META_KEYWORDS'),
            'meta_description' => Yii::t('app', 'META_DESCRIPTION'),
            'create_time' => Yii::t('app', 'CREATE_TIME'),
            'update_time' => Yii::t('app', 'UPDATE_TIME'),
        ];
    }

    static public function publishedDropDownList()
    {
        $formatter = Yii::$app->formatter;
        return [
            self::PUBLISHED_NO => $formatter->asBoolean(self::PUBLISHED_NO),
            self::PUBLISHED_YES => $formatter->asBoolean(self::PUBLISHED_YES),
        ];
    }
}
