<?php

use yii\db\Migration;

/**
 * Handles the creation of table `announcement_type`.
 */
class m161119_073141_create_announcement_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('announcement_type', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull(),
            'add_time'=>$this->integer(11),
            'update_time'=>$this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('announcement_type');
    }
}
