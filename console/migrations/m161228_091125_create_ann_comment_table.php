<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ann_comment`.
 */
class m161228_091125_create_ann_comment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ann_comment', [
            'id' => $this->primaryKey(),
            'content'=>$this->text()->notNull(),
            'ann_id'=>$this->integer(11)->notNull(),
            'user_id'=>$this->integer(11)->notNull(),
            'user_name'=>$this->string(55),
            'add_time'=>$this->integer(11),
            'parent_id'=>$this->integer(11)->notNull()->defaultValue(0),
            'blog_title'=>$this->string(55),
            'brief'=>$this->string(255)->notNull(),
            'update_tiem'=>$this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ann_comment');
    }
}
