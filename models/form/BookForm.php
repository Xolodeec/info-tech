<?php

namespace app\models\form;

use app\models\entity\Author;
use app\models\entity\Book;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class BookForm extends Model
{
    public $title;
    public $year;
    public $description;
    public $isbn;
    public $authorIds = [];
    public $photoFile;
    public $photoUrl = null;

    public $book;

    public function __construct(Book $book, $config = [])
    {
        $this->book = $book;
        parent::__construct($config);

        // Заполнение значениями при UPDATE
        $this->setAttributesFromBook($book);
    }

    private function setAttributesFromBook(Book $book)
    {
        if (!$book->isNewRecord) {
            $this->title = $book->title;
            $this->year = $book->year;
            $this->description = $book->description;
            $this->isbn = $book->isbn;
            $this->photoUrl = $book->photo;
            $this->authorIds = ArrayHelper::getColumn($book->authors, 'id');
        }
    }

    public function rules()
    {
        return [
            [['title', 'isbn', 'year'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['year'], 'integer', 'min' => 1900, 'max' => date('Y')],
            [['description'], 'string'],
            [['isbn'], 'validateIsbnUnique'],
            [['authorIds'], 'each', 'rule' => ['integer']],
            [['photoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 5],
            [['photoUrl'], 'url', 'skipOnEmpty' => true],
            ['photoFile', 'required', 'when' => function($model) {
                return empty($model->photoUrl) && empty($model->book->photo);
            }, 'whenClient' => "function (attribute, value) {
                return $('#bookform-photourl').val() == '';
            }"],
        ];
    }

    public function validateIsbnUnique($attribute, $params)
    {
        $query = Book::find()->where(['isbn' => $this->$attribute]);

        // Если книга существует (режим редактирования), исключаем ее
        if (!$this->book->isNewRecord) {
            $query->andWhere(['!=', 'id', $this->book->id]);
        }

        if ($query->exists()) {
            $this->addError($attribute, 'ISBN уже существует');
        }
    }

    public function getAuthorList(): array
    {
        return Author::find()
            ->select(['last_name', 'id'])
            ->indexBy('id')
            ->column();
    }
}