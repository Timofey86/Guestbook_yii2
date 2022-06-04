<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $message
 * @property int $user_id
 * @property string $date_add
 * @property string $updated_at
 *
 * @property Comments[] $comments
 * @property Images[] $images
 * @property Users $user
 */
class Feedback extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['date_add', 'updated_at'], 'safe'],
            [['message'], 'string', 'max' => 300],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['image', 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 5],
            [['message'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('app', 'Message'),
            'user_id' => Yii::t('app', 'User ID'),
            'date_add' => Yii::t('app', 'Date Add'),
            'imagesAsString' => Yii::t('app', 'ImagesAsString'),
            'commentsAsString' => Yii::t('app', 'CommentsAsString'),
            'image' => Yii::t('app', 'Image'),
            'images' => Yii::t('app', 'Images'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at', 'date_add'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()')
            ],
        ];

    }


    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['feedback_id' => 'id']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::className(), ['feedback_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getImgforcomments()
    {
        return $this->hasMany(Imgforcomments::className(), ['comment_id' => 'id'])
            ->via('comments');
    }

    public function getUserAsString()
    {
        $arr = ArrayHelper::map((array)$this->user, 'id', 'name');
        return $arr;
    }

    public static function getListFeedback():array
    {
        return ArrayHelper::map(self::find()->all(),'id','message');
    }

    public function setUserId()
    {
        $this->user_id = \Yii::$app->user->getId();
    }



}
