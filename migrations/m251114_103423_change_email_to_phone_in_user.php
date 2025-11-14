<?php

use yii\db\Migration;

class m251114_103423_change_email_to_phone_in_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Удаляем старые индексы
        $this->dropIndex('idx-user-email-status', '{{%user}}');
        $this->dropIndex('idx-user-email', '{{%user}}');

        // Удаляем поле email
        $this->dropColumn('{{%user}}', 'email');

        // Добавляем новое поле phone
        $this->addColumn('{{%user}}', 'phone', $this->string(20)->notNull()->unique());

        // Индексы на phone
        $this->createIndex('idx-user-phone', '{{%user}}', 'phone');
        $this->createIndex('idx-user-phone-status', '{{%user}}', ['phone', 'status']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляем индексы для phone
        $this->dropIndex('idx-user-phone-status', '{{%user}}');
        $this->dropIndex('idx-user-phone', '{{%user}}');

        // Удаляем поле phone
        $this->dropColumn('{{%user}}', 'phone');

        // Возвращаем поле email
        $this->addColumn('{{%user}}', 'email', $this->string()->notNull()->unique());

        // Восстанавливаем индексы
        $this->createIndex('idx-user-email', '{{%user}}', 'email');
        $this->createIndex('idx-user-email-status', '{{%user}}', ['email', 'status']);
    }
}
