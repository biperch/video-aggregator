<?php

use yii\db\Migration;

class m160314_195327_add_video_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{video}}', 'title_origin', 'varchar(255) After title');
        $this->addColumn('{{video}}', 'image', 'varchar(255) After title_origin');
        $this->addColumn('{{video}}', 'year', 'varchar(4) After image');
        $this->addColumn('{{video}}', 'description', 'text After year');
    }

    public function down()
    {
        echo "m160314_195327_add_video_field cannot be reverted.\n";

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
