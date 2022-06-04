<?php

use yii\db\Migration;

/**
 * Class m220719_102631_createTableComments
 */
class m220719_102631_createTableComments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments',[
            'id' => $this->primaryKey(),
            'message' => $this->string(300)->notNull(),
            'user_id'=> $this->integer()->notNull(),
            'feedback_id'=> $this->integer()->null(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk_feedback_comments',
            'comments','feedback_id',
            'feedback','id',
            'CASCADE', 'CASCADE');

        $this->addForeignKey('fk_user_comments',
            'comments','user_id',
            'users','id',
            'CASCADE', 'CASCADE');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220719_102631_createTableComments cannot be reverted.\n";

        return false;
    }
    */
}
