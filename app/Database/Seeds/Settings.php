<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Settings extends Seeder
{
    public function run()
    {
        $data = [
            'setting_key'            => 'app_name',
            'setting_value'            => 'BRN APPS',
            'setting_type'            => 'text',
            'setting_for'            => 'all',
        ];

        // Simple Queries
        $this->db->query("INSERT INTO settings (setting_key, setting_value, setting_type, setting_for) VALUES(:setting_key:, :setting_value:, :setting_type:, :setting_for:)", $data);

        // Using Query Builder
        $this->db->table('settings')->insert($data);
    }
}
