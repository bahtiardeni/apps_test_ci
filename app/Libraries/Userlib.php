<?php
namespace App\Libraries;

use App\Models\GeneralModel;
use Config\Session;

/**
 * Class Userlib
 *
 * Model
 * @property General_model  $general
 *
 * Library
 * @property Session        $session
 * @property Encryptlib     $encryptlib
 *
 */
class Userlib
{
    const STATUS_INACTIVE       = 0;
    const STATUS_ACTIVE         = 1;

    public $_status;

    public function __construct()
    {
        $this->general      = new GeneralModel();
        $this->session      = new Session();
        $this->encryptlib   = new EncryptLib();

        $this->_status      = array(
            self::STATUS_INACTIVE       => array(
                "color" => "label-danger",
                "label" => "Tidak Aktif"
            ),
            self::STATUS_ACTIVE         => array(
                "color" => "label-info",
                "label" => "Aktif"
            )
        );
    }

    public function get_user($user_id)
    {
        $data               = $this->general->get_data("tbl_users", array(
            "tbl_users.id"    => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $user_id
            )
        ), null, null, null, null, array(
            "tbl_users.*",
        ))->getRow();
        $data->hash             = $this->encryptlib->encode($data->id);

        return $data;
    }
}