<?php

use yii\db\Migration;

/**
 * Class m220719_102145_createTableImages
 */
class m220719_102145_createTableImages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('images',[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'feedback_id' => $this->integer()->notNull(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),

        ]);

        $this->addForeignKey('fk_feedback_images',
            'images','feedback_id',
            'feedback','id',
            'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('images');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220719_102145_createTableImages cannot be reverted.\n";

        return false;
    }
    */
}
