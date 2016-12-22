<?php

use yii\db\Migration;

/**
 * Handles the creation of table `announcement`.
 */
class m161119_073044_create_announcement_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('announcement', [
            'announcement_id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'announcement_content' => $this->text()->notNull(),
            'add_time'=>$this->integer(11)->notNull(),
            'update_time'=>$this->integer(11),
            'type_name'=>$this->string(50),
            'admin_id'=>$this->integer(11)->notNull(),
            'admin_name'=>$this->string(50),
            'enable'=>$this->smallInteger(1)->defaultValue(1)

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('announcement');
    }
}
