<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m190228_132131_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'group_id' => $this->integer()->notNull(),
            'photo' => $this->string(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ]);
        $this->createIndex(
            'idx-users-group_id',
            'users',
            'group_id'
        );
        $this->addForeignKey(
            'fk-users-group_id',
            'users',
            'group_id',
            'groups',
            'id',
            'CASCADE'
        );
        $this->insert('{{%users}}',[
            'login'=>'alloon',
            'password'=>md5(random_bytes(10)),
            'email'=>'mail1@gmail.com',
            'group_id'=>'2',
            'photo'=>null,
        ]);$this->insert('{{%users}}',[
            'login'=>'vasya_pupkin',
            'password'=>md5(random_bytes(10)),
            'email'=>'mail2@gmail.com',
            'group_id'=>'3',
            'photo'=>null,
        ]);$this->insert('{{%users}}',[
            'login'=>'master_Yoda',
            'password'=>md5(random_bytes(10)),
            'email'=>'mail3@gmail.com',
            'group_id'=>'1',
            'photo'=>null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
