<?php

use yii\db\Migration;

/**
 * Handles the creation of table `systemconfig`.
 */
class m161212_033146_create_SystemConfig_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('systemconfig', [
            'id' => $this->primaryKey(),
            'key'=>$this->string(255)->notNull(),
            'value'=>$this->string()->notNull(),
            'update_time'=>$this->integer(11)->null(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('systemconfig');
    }
}
