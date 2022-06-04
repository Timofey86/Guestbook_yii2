<?php

use yii\db\Migration;

/**
 * Class m220719_100353_createTableUsers
 */
class m220719_100353_createTableUsers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull(),
            'email' => $this->string(150)->notNull(),
            'password_hash' => $this->string(300)->notNull(),
            'token' => $this->string(150),
            'auth_key' => $this->string(150),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220719_100353_createTableUsers cannot be reverted.\n";

        return false;
    }
    */
}
