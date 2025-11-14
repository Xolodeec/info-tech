<?php

namespace app\models;

class BookAuthorService
{
    public function saveAuthors(Book $book, array $authorIds) :void
    {
        BookAuthor::deleteAll(['book_id' => $book->id]);

        foreach ($authorIds as $authorId) {
            $bookAuthor = new BookAuthor([
                'book_id' => $book->id,
                'author_id' => $authorId
            ]);
            $bookAuthor->save();
        }
    }
}