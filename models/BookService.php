<?php

namespace app\models;

use Yii;

class BookService
{
    private FileService $fileService;
    private BookAuthorService $bookAuthorService;

    public function __construct(FileService $fileService, BookAuthorService $bookAuthorService)
    {
        $this->fileService = $fileService;
        $this->bookAuthorService = $bookAuthorService;
    }

    public function save(BookForm $form)
    {
        $book = $form->book;

        $transaction = Yii::$app->db->beginTransaction();

        try {
            //Обработка фото
            if ($form->photoFile) {
                $book->photo = $this->fileService->uploadBookPhoto($form->photoFile);
            } elseif ($form->photoUrl) {
                $book->photo = $form->photoUrl;
            }

            //Перенос данных
            $book->title = $form->title;
            $book->year = $form->year;
            $book->description = $form->description;
            $book->isbn = $form->isbn;
            $book->created_by = \Yii::$app->user->identity->id;

            //Сохранение книги
            if (!$book->save()) {
                throw new \Exception('Ошибка при сохранении записи книги.');
            }

            //Сохранение авторов
            $this->bookAuthorService->saveAuthors($book, $form->authorIds);

            $transaction->commit();

            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage());
            return false;
        }
    }
}