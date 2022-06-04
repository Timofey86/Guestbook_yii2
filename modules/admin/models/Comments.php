<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $message
 * @property int $user_id
 * @property int|null $feedback_id
 * @property string $date_add
 * @property string $updated_at
 *
 * @property Feedback $feedback
 * @property Imgforcomments[] $imgforcomments
 * @property Users $user
 */
class Comments extends \yii\db\ActiveRecord
{
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'user_id'], 'required'],
            [['user_id', 'feedback_id'], 'integer'],
            [['date_add', 'updated_at'], 'safe'],
            [['message'], 'string', 'max' => 300],
            [['feedback_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feedback::className(), 'targetAttribute' => ['feedback_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['image', 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 5],
            [['message'], 'trim'],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('app', 'Message'),
            'user_id' => Yii::t('app', 'User ID'),
            'feedback_id' => Yii::t('app', 'Feedback ID'),
            'date_add' => Yii::t('app', 'Date Add'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'images' => Yii::t('app', 'Images'),
            'image' => Yii::t('app', 'Image'),
            'feedback' => Yii::t('app', 'Feedback'),
        ];
    }

    /**
     * Gets query for [[Feedback]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedback()
    {
        return $this->hasOne(Feedback::className(), ['id' => 'feedback_id']);
    }

    /**
     * Gets query for [[Imgforcomments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImgforcomments()
    {
        return $this->hasMany(Imgforcomments::className(), ['comment_id' => 'id']);
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

    public function setUserId()
    {
        $this->user_id = \Yii::$app->user->getId();
    }
}
