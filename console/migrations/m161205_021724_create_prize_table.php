<?php

use yii\db\Migration;

/**
 * Handles the creation of table `prize`.
 */
class m161205_021724_create_prize_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('prize', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'type'=>$this->integer()->notNull()->defaultValue(0),//类型：0为积分，1为装备，2为套装
            'prize_value'=>$this->integer()->notNull()->defaultValue(0),
            'add_time'=>$this->integer()->notNull(),
            'update_time'=>$this->integer(),
            'proportion'=>$this->integer(),//占比
            'sort'=>$this->integer()->notNull(),//排序
            'limit_number'=>$this->integer()->notNull()->defaultValue(0),//限制人数，默认为0不限制，如果超过这个人数就会往下一级颁奖
            //抽奖概率根据占比和排序来的
            'cost'=>$this->integer()->notNull()->defaultValue(100),//cost to one lottery
            'is_able'=>$this->integer(1)->notNull()->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('prize');
    }
}
