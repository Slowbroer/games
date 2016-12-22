<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_prize`.
 */
class m161205_065625_create_user_prize_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_prize', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(11)->notNull(),
            'user_name'=>$this->string()->notNull(),
            'prize_id'=>$this->integer(11)->notNull(),
            'prize_name'=>$this->string(),
            'used'=>$this->integer(1)->notNull()->defaultValue(0),
            'order_id'=>$this->integer(11)->notNull()->defaultValue(0),
            'add_time'=>$this->integer(11),
            'update_time'=>$this->integer(11),
            'is_able'=>$this->integer()->notNull()->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_prize');
    }
}
