<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "source".
 *
 * @property integer $id
 * @property integer $vid
 * @property string $type
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class Source extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],

                ],
                'value'=>new Expression('NOW()')
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'url'], 'required'],
            [['vid'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['type', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vid' => Yii::t('app', 'Vid'),
            'type' => Yii::t('app', 'Type'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
