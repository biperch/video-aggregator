<?php

use yii\db\Migration;

class m160303_223255_video extends Migration
{
    public function up()
    {
        $this->createTable('{{video}}', [
            'id'         => $this->primaryKey(),
            'title'      => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    public function down()
    {
        echo "m160303_223255_video cannot be reverted.\n";

        return false;
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
