<?php

use yii\db\Migration;

/**
 * Class m240709_111648_files
 */
class m240709_111648_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('files', [
            'id' => $this->primaryKey(),
            'table_name' => $this->string()->notNull(),
            'table_row_id' => $this->integer()->notNull(),
            'file_type' => $this->string()->notNull(),
            'filepath' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('files');
        echo "m240709_111648_files cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240709_111648_files cannot be reverted.\n";

        return false;
    }
    */
}
