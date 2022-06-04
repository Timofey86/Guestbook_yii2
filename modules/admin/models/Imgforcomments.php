<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "imgforcomments".
 *
 * @property int $id
 * @property string $name
 * @property int $comment_id
 * @property string $date_add
 *
 * @property Comments $comment
 */
class Imgforcomments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imgforcomments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'comment_id'], 'required'],
            [['comment_id'], 'integer'],
            [['date_add'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['comment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'comment_id' => Yii::t('app', 'Comment ID'),
            'date_add' => Yii::t('app', 'Date Add'),
        ];
    }

    /**
     * Gets query for [[Comment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comments::className(), ['id' => 'comment_id']);
    }
}
