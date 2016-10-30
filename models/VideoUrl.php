<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "video_url".
 *
 * @property integer $id
 * @property integer $vid
 * @property integer $quality
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class VideoUrl extends \yii\db\ActiveRecord
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
        return 'video_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid', 'quality'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['url'], 'string', 'max' => 255]
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
            'quality' => Yii::t('app', 'Quality'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Проверяет доступность видео файла
     * @return boolean
     */
    public function fileExists()
    {
        $h = @get_headers($this->url);
        return strpos($h[0], '200')!==false;
    }
}
