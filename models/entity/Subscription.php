<?php

namespace app\models\entity;

use app\modules\auth\models\User;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property int $user_id
 * @property int $author_id
 * @property int $created_at
 *
 * @property Author $author
 * @property User $user
 */
class Subscription extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'author_id', 'created_at'], 'required'],
            [['user_id', 'author_id', 'created_at'], 'integer'],
            [['user_id', 'author_id'], 'unique', 'targetAttribute' => ['user_id', 'author_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
