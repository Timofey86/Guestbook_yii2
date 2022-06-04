<?php

use yii\db\Migration;

/**
 * Class m220719_103145_addAdmin
 */
class m220719_103145_addAdmin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('users', [
            'id' => 1,
            'name' => 'Alex',
            'email' => 'admin1@mail.ru',
            'password_hash' => Yii::$app->security->generatePasswordHash('123man'),

        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('users',['id'=> 1]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220719_103145_addAdmin cannot be reverted.\n";

        return false;
    }
    */
}
