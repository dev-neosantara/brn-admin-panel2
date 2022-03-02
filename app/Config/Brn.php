<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Brn extends BaseConfig
{
    // public $membership_timeout_year = 2;
    // public $app_name = "BRN";
    // public $admin_name = "BRN";
    // // public $x = $_ENV['A'];
    // public $api_url = "";
    // public $auth_url = "";
    // public $olshop_url = "";
    public $settings = [];
    public $admin_roles = [
        ['id' => 'super_admin', 'name' => 'Super Admin'],
        ['id' => 'admin', 'name' => 'Admin'],
        ['id' => 'journalist', 'name' => 'Jurnalis'],
        ['id' => 'diklat', 'name' => 'Diklat'],
        ['id' => 'personalia', 'name' => 'Personalia'],
    ];
}
