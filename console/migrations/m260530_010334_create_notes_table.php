<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notes}}`.
 */
class m260530_010334_create_notes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('notes', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),

            'title' => $this->string(255)->notNull(),
            'content' => $this->text(),

            'color' => $this->string(7)->defaultValue('#6366f1'),
            'is_pinned' => $this->tinyInteger()->defaultValue(0),

            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-notes-user_id', 'notes', 'user_id');

        $this->addForeignKey(
            'fk-notes-user_id',
            'notes',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-notes-user_id', '{{%notes}}');

        $this->dropTable('{{%notes}}');
    }
}
