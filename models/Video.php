<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\models\Source;
use app\models\VideoUrl;

/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 */
class Video extends \yii\db\ActiveRecord
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
                'value' => new Expression('NOW()')
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
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['year'], 'string', 'max' => 4],
            [['title', 'title_origin', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getSource()
    {
        return $this->hasMany(Source::className(), ["vid" => "id"]);
    }

    public function getVideoUrl()
    {
        return $this->hasMany(VideoUrl::className(), ["vid" => "id"]);
    }

    public static function fetchOne($id)
    {
        return static::find()->joinWith('source')->joinWith('videoUrl')->where(['video.id' => $id])->one();
    }

    /**
     * парсит источник видео для получения url на файлы
     *
     * @param int $vid
     */
    public static function parseSource($vid)
    {
        $sources = Source::findAll(['vid' => $vid]);

        VideoUrl::deleteAll('vid=:vid', [':vid' => $vid]);

        if (!empty($sources)) {
            foreach ($sources as $source) {
                $cont = file_get_contents($source->url);
                $match = [];
                preg_match_all('/url(\d+)=(.+?mp4.+?);/i', $cont, $match);
                for ($i = 0; $i < count($match[0]) / 2; $i++) {
                    $v = new VideoUrl(['vid' => $vid, 'quality' => $match[1][$i], 'url' => $match[2][$i]]);
                    $v->save();
                }
            }
        }
    }

    /**
     * Проверяет все видео адреса на доступность файлов
     * @return type
     * @throws Exception
     */
    public function checkVideoUrl()
    {
        $r = true;
        if (empty($this->videoUrl))
            throw new Exception('Видео адресов нет', '501');


        foreach ($this->videoUrl as $vu) {
            $z = $vu->fileExists();
            $r = $z ? $r : false;
        }
        return $r;
    }

}
