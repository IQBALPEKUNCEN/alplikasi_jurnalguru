<?php

use yii\db\Migration;

/**
 * Handles the creation of table `token_session`.
 */
class m240323_170410_create_token_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('token_session', [
            'token' => $this->string(255)->notNull(),
            'expired_at' => $this->dateTime()->defaultValue(null),
            'last_accessed' => $this->dateTime()->notNull()->append('DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'PRIMARY KEY (`token`)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=latin1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('token_session');
    }
}
