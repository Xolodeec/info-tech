<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m251113_233414_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'year' => $this->smallInteger(4),
            'description' => $this->text(),
            'isbn' => $this->string(20)->unique(),
            'photo' => $this->string(255),
            'created_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Индекс для 'created_by'
        $this->createIndex(
            'idx-books-created_by',
            '{{%books}}',
            'created_by'
        );

        // Внешний ключ: books.created_by -> user.id
        $this->addForeignKey(
            'fk-books-created_by',
            '{{%books}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Индексы для отчета (по году) и поиска (по названию)
        $this->createIndex('idx-books-year', '{{%books}}', 'year');
        $this->createIndex('idx-books-title', '{{%books}}', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-books-created_by', '{{%books}}');
        $this->dropIndex('idx-books-created_by', '{{%books}}');
        $this->dropIndex('idx-books-year', '{{%books}}');
        $this->dropIndex('idx-books-title', '{{%books}}');

        $this->dropTable('{{%books}}');
    }
}
