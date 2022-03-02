<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use \Config\Brn;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $session;
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    protected $authconfig, $appconfig;
    protected $auth;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->initapp($request);


    }

    // protected function initSettings($request){
    //     $db = \Config\Database::connect();

    //     $data = $db->query('SELECT * FROM settings WHERE `setting_for` = "all" OR `setting_for` = "admin"')->getResult();
    // //     public $api_url = $_ENV['BASE_API_URL'];
    // // public $auth_url = $_ENV['BASE_AUTH_URL'];
    // // public $olshop_url = $_ENV['BASE_OLSHOP_URL'];
    // // public $membership_timeout_year = 2;
    // // public $app_name = "BRN";
    // // public $admin_name = "BRN";
    // }

    protected function initapp($request)
    {
        $this->session = service('session');
        $db = \Config\Database::connect();
		$this->authconfig = config('Auth');
        $this->auth = service('authentication');


        $st = $db->query('SELECT * FROM settings WHERE `setting_for` = "all" OR `setting_for` = "admin"')->getResult();
        $roles = $db->table('roles')->get()->getResultArray();
        if(count($st) > 0){
            $config = Config('Brn');
            foreach($st as $res){
                // $config->membership_timeout_year = 
                $config->settings[$res->setting_key] = array(
                    'value' => $res->setting_value,
                    'type' => $res->setting_type
                );

            }
            $config->settings['roles'] = $roles;
            // print_r($this->appconfig);exit;
            // $this->session->set($this->appconfig);
            // print_r($_SESSION);exit;
        }
        $uri = $request->uri;

        $this->session->set(array('currentpath' => $uri->getPath()));
    }
}
