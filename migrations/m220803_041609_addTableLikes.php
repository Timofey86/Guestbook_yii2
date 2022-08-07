<?php

use yii\db\Migration;

/**
 * Class m220803_041609_addTableLikes
 */
class m220803_041609_addTableLikes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('like',[
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer()->notNull(),
            'feedback_id' => $this->integer()->notNull() ,

        ]);

        $this->addForeignKey('like_userFK','like','user_id','users',
            'id','CASCADE','CASCADE');
        $this->addForeignKey('like_feedbackFK','like','feedback_id','feedback'
            ,'id','CASCADE', 'CASCADE');
        $this->addColumn('feedback','count',$this->integer()->notNull()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('feedback','count');
        $this->dropTable('like');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220803_041609_addTableLikes cannot be reverted.\n";

        return false;
    }
    */
}
