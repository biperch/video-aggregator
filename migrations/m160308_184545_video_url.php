<?php

use yii\db\Migration;

class m160308_184545_video_url extends Migration
{

    public function up()
    {
        $this->createTable('{{video_url}}', [
            'id'         => $this->primaryKey(),
            'vid'        => $this->integer(),
            'quality'    => $this->integer(),
            'url'        => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    public function down()
    {
        echo "m160308_184545_video_url cannot be reverted.\n";

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
