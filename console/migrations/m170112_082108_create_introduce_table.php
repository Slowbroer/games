<?php

use yii\db\Migration;

/**
 * Handles the creation of table `introduce`.
 */
class m170112_082108_create_introduce_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('introduce', [
            'id' => $this->primaryKey(),
            'content'=>$this->text(),
            'title'=>$this->string(255)->notNull(),
            'is_able'=>$this->integer(1)->defaultValue(1),
            'is_show'=>$this->integer(1)->defaultValue(1),
            'brief'=>$this->string(255),
            'add_time'=>$this->integer(11),
            'update_time'=>$this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('introduce');
    }
}
