<?php

use yii\db\Migration;

/**
 * Class m220719_102852_createTableImagesForComments
 */
class m220719_102852_createTableImagesForComments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('imgforcomments',[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'comment_id' => $this->integer()->notNull(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),

        ]);

        $this->addForeignKey('fk_comments_images',
            'imgforcomments','comment_id',
            'comments','id',
            'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('imgforcomments');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220719_102852_createTableImagesForComments cannot be reverted.\n";

        return false;
    }
    */
}
