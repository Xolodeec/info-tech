<?php

namespace app\models\entity;

use app\modules\auth\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property int|null $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $photo
 * @property int|null $created_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 * @property User $createdBy
 */
class Book extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'description', 'isbn', 'photo', 'created_by'], 'default', 'value' => null],
            [['title'], 'required'],
            [['year', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title', 'photo'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'photo' => 'Photo',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

}
