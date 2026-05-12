<?php
namespace App\Controllers;
use App\Libraries\Encryptlib;
use App\Libraries\Userlib;
use App\Libraries\Utils;
use App\Models\GeneralModel;

/**
 * Class Auth
 *
 * @property GeneralModel   $general
 *
 * @property Session        $session
 * @property Encryptlib     $encryptlib
 * @property Userlib        $userlib
 * @property Utils          $utils
 *
 */

class Auth extends BaseController
{
    protected $data         = array();

    public function __construct()
    {
        parent::__construct();

        $this->encryptlib   = new Encryptlib();
        $this->userlib      = new Userlib();
        $this->utils        = new Utils();

        $session_id         = $this->session->get("id_user");
        $method_no_auth     = array(
            "logout",
            "xyz",
            "check_users",
        );

        if (!empty($session_id) && !in_array($this->route_method, $method_no_auth)){
            header('Location: ' . base_url());
            exit();
        }
    }

    public function index()
    {
        return view("auth/index", $this->data);
    }
    public function logout()
    {
        $this->session->destroy();
        header('Location: ' . base_url("auth"));
        exit();
    }

    // Ajax Request
    public function plogin()
    {
        if ($this->request->isAJAX())
        {
            $email      = service("request")->getPost("email");
            $password   = service("request")->getPost("password");
            $result     = RESULT_ERROR;
            $message    = array();

            if (empty($email)){
                $message["email"]  = "Email tidak boleh kosong.";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL))  {
                $message["email"]  = "Masukan Email dengan benar.";
            }
            if (empty($password)){
                $message["password"]  = "Password tidak boleh kosong.";
            }
            if (empty($message))
            {
                $check_user     = $this->general->get_data("tbl_users", array(
                    "email"     => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $email
                    )
                ))->getRow();

                if (!empty($check_user))
                {
                    if (md5($password) == $check_user->password)
                    {
                        if ($check_user->status == Userlib::STATUS_INACTIVE)
                        {
                            $message["notification_error"]      = "Akun Anda tidak aktif.";
                        }
                        else if ($check_user->status == Userlib::STATUS_ACTIVE)
                        {
                            $this->session->set("id_user", $check_user->id);
                            $result         = RESULT_SUCCESS;
                            $message        = $this->session->get("url_current");

                            if (!empty($this->session->get("url_current"))){
                                $message    = $this->session->get("url_current");
                            } else {
                                $message    = "";
                            }
                        }
                        else
                        {
                            $message["email"]  = "Akun Anda tidak sesuai.";
                        }
                    }
                    else
                    {
                        $message["email"]   = "Kombinasi Email dan Password tidak ditemukan.";
                    }
                }
                else
                {
                    $message["email"]      = "Email Anda tidak terdaftar.";
                }
            }

            if (!empty($message))
            {
                $message    = implode("<br>", $message);
            }

            header("Content-Type: application/json");
            echo json_encode(array(
                "result"	=> $result,
                "message"	=> $message,
            ));
        }
    }
}
