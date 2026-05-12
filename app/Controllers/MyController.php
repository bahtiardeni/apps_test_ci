<?php
namespace App\Controllers;
use App\Libraries\Masterlib;
use App\Libraries\Datatable;
use App\Libraries\Encryptlib;
use App\Libraries\Formlib;
use App\Libraries\Template;
use App\Libraries\Userlib;
use App\Models\GeneralModel;
use CodeIgniter\Controller;


/**
 *
 * Class MyController
 *
 * Model
 * @property GeneralModel   $general
 *
 * Library
 * @property Encryptlib     $encryptlib
 * @property Utils          $utils
 * @property Template       $template
 * @property Masterlib      $masterlib
 * @property Datatable      $datatable
 * @property Formlib        $formlib
 * @property Userlib        $userlib
 *
 */

abstract class MyController extends Controller
{
    public $template;
    public $user;
    public $general;

    public function __construct()
    {
        $this->general          = new GeneralModel();
        $this->session          = \Config\Services::session();
        $this->request          = \Config\Services::request();
        $this->check_login();

        $this->encryptlib       = new EncryptLib();
        $this->utils            = new \App\Libraries\Utils();

        $user_id                = $this->session->get('id_user');
        $this->userlib          = new Userlib();
        $this->user             = $this->userlib->get_user($user_id);
        $this->template         = new Template();
        $this->template->_user  = $this->user;
        $this->masterlib        = new Masterlib();
        $this->datatable        = new Datatable();
        $this->formlib          = new Formlib();

    }

    public function check_login()
    {
        $user_id            = $this->session->get('id_user');
        $request_method     = $this->request->getMethod();

        if (empty($user_id))
        {
            header('Location: ' . base_url("auth"));
            exit();
        }
    }
}