<?php

namespace app\models\entity;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BookAuthor[] $bookAuthors
 * @property Book[] $books
 */
class Author extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['middle_name'], 'default', 'value' => null],
            [['last_name', 'first_name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['last_name', 'first_name', 'middle_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('book_author', ['author_id' => 'id']);
    }

}
