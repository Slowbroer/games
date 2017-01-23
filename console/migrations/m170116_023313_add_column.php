<?php

use yii\db\Migration;

class m170116_023313_add_column extends Migration
{
    public function up()
    {
        $this->addColumn("systemconfig",'type',$this->string()->defaultValue("text"));
        $this->addColumn("systemconfig",'options',$this->text());

    }

    public function down()
    {
        $this->dropColumn('systemconfig', 'type');
        $this->dropColumn('systemconfig', 'options');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
