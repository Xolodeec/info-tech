<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m251113_233414_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
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
            'idx-book-created_by',
            '{{%book}}',
            'created_by'
        );

        // Внешний ключ: book.created_by -> user.id
        $this->addForeignKey(
            'fk-book-created_by',
            '{{%book}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Индексы для отчета (по году) и поиска (по названию)
        $this->createIndex('idx-book-year', '{{%book}}', 'year');
        $this->createIndex('idx-book-title', '{{%book}}', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-book-created_by', '{{%book}}');
        $this->dropIndex('idx-book-created_by', '{{%book}}');
        $this->dropIndex('idx-book-year', '{{%book}}');
        $this->dropIndex('idx-book-title', '{{%book}}');

        $this->dropTable('{{%book}}');
    }
}
