<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Settings extends Migration
{
    public function up()
    {
        /*
         * Users
         */
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'setting_key'            => ['type' => 'varchar', 'constraint' => 255],
            'setting_value'            => ['type' => 'varchar', 'constraint' => 1024],
            'setting_type'            => ['type' => 'varchar', 'constraint' => 255, 'default' => 'text', 'comment' => 'text, number, bool, json'],
            'setting_for'            => ['type' => 'varchar', 'constraint' => 255, 'default' => 'disable', 'comment' => 'admin, app, api, disable, all'],
            'created_at timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'
        ]);

        $this->forge->addPrimaryKey('id', true);
        $this->forge->addUniqueKey('setting_key');
        $this->forge->createTable('settings', true);
    }

    public function down()
    {
        $this->forge->dropTable('settings', true);
    }
}
