<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author}}`.
 */
class m251113_233229_create_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'last_name' => $this->string(100)->notNull(),
            'first_name' => $this->string(100)->notNull(),
            'middle_name' => $this->string(100)->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Индексы для оптимизации поиска и сортировки:
        $this->createIndex(
            'idx-author-last_name',
            '{{%author}}',
            'last_name'
        );

        // Составной индекс для проверки на полных тезок
        $this->createIndex(
            'idx-author-full_fio',
            '{{%author}}',
            ['last_name', 'first_name', 'middle_name']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%author}}');
    }
}
