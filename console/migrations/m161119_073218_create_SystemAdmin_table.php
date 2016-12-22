<?php

use yii\db\Migration;

/**
 * Handles the creation of table `systemadmin`.
 */
class m161119_073218_create_SystemAdmin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('systemadmin', [
            'admin_id' => $this->primaryKey(),
            'admin_name' => $this->string(50)->notNull(),
            'admin_level' => $this->integer()->notNull(),
            'admin_power'=>$this->string(),
            'mobile_phone'=>$this->string()->notNull(),
            'email'=>$this->string()->notNull(),
            'salt'=>$this->string()->notNull(),
            'authkey'=>$this->string(),
            'password'=>$this->string(255)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('systemadmin');
    }
}
