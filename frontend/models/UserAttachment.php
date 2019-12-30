<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "user_attachments".
 *
 * @property int $id
 * @property int $author_id
 * @property string $name
 * @property string $extension
 * @property string $mime
 * @property int $size
 * @property string $path
 * @property string $hash
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class UserAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_attachments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'name', 'extension', 'mime', 'size', 'path', 'hash'], 'required'],
            [['author_id', 'size'], 'integer'],
            [[], 'safe'],
            [['name', 'path', 'hash'], 'string', 'max' => 100],
            [['extension', 'mime'], 'string', 'max' => 45],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'name' => 'Name',
            'extension' => 'Extension',
            'mime' => 'Mime',
            'size' => 'Size',
            'path' => 'Path',
            'hash' => 'Hash',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
