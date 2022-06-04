<?php

use yii\db\Migration;

/**
 * Class m220719_101917_createTableFeedback
 */
class m220719_101917_createTableFeedback extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('feedback',[
            'id' => $this->primaryKey(),
            'message' => $this->string(300)->notNull(),
            'user_id'=> $this->integer()->notNull(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),


        ]);

        $this->addForeignKey('fk_user_feedback',
            'feedback','user_id',
            'users','id',
            'CASCADE', 'CASCADE');



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('feedback');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220719_101917_createTableFeedback cannot be reverted.\n";

        return false;
    }
    */
}
