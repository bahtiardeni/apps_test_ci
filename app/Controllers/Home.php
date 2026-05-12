<?php
namespace App\Controllers;
use App\Libraries\Template;
use App\Libraries\Userlib;

/**
 *
 * Class Dashboard
 *
 * Model
 * @property Template       $template
 * @property GeneralModel   $general
 */

class Home extends MyController
{
    public function __construct()
    {
        parent::__construct();

        $this->_set_pluggin_library();
    }

    public function index()
    {
        $this->template->data["title"]              = "HOME";
        $this->template->_page_id                   = "page-home";

        $this->template->generate("home/index");
    }

    public function get_data()
    {
        if ($this->request->isAJAX() && ($_SERVER["REQUEST_METHOD"] === "GET"))
        {
            $pegawai            = $this->general->get_data("tbl_pegawai")->getResult();
            $chart_divisi       = $this->general->get_data("tbl_divisi")->getResult();
            $chart_divisi       = array_map(function ($item) use ($pegawai) {
                $item_tmp       = $this->general->get_data("tbl_pegawai", array(
                    "id_divisi"      => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $item->id
                    )
                ))->getNumRows();
                return array(
                    "name"      => $item->nama,
                    "value"     => $item_tmp,
                    "y"         => !empty($pegawai) ? round(($item_tmp / count($pegawai) * 100), 2 ) :0
                );
            }, $chart_divisi);

            $chart_jabatan      = $this->general->get_data("tbl_jabatan")->getResult();
            $chart_jabatan      = array_map(function ($item) use ($pegawai) {
                $item_tmp       = $this->general->get_data("tbl_pegawai", array(
                    "id_jabatan"      => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $item->id
                    )
                ))->getNumRows();
                return array(
                    "name"      => $item->nama,
                    "value"     => $item_tmp,
                    "y"         => !empty($pegawai) ? round(($item_tmp / count($pegawai) * 100), 2 ) :0
                );
            }, $chart_jabatan);

            $gender             = array("Laki-laki", "Perempuan");
            $chart_gender       = array_map(function ($item) use ($pegawai) {
                $item_tmp       = $this->general->get_data("tbl_pegawai", array(
                    "jenis_kelamin"      => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $item
                    )
                ))->getNumRows();
                return array(
                    "name"      => $item,
                    "value"     => $item_tmp,
                    "y"         => !empty($pegawai) ? round(($item_tmp / count($pegawai) * 100), 2 ) :0
                );
            }, $gender);

            $result         = array(
                "chart_divisi"      => $chart_divisi,
                "chart_jabatan"     => $chart_jabatan,
                "chart_gender"      => $chart_gender,
            );
        }
        else
        {
            $result         = array();
        }

        header("Content-Type: application/json");
        echo json_encode($result);
    }

    // Other Function
    function _set_pluggin_library()
    {
        $this->template->data["_core_js"][]     = "public/plugins/highcharts-11.3.0/highcharts.js";
        $this->template->data["_core_js"][]     = "public/plugins/highcharts-11.3.0/highcharts-3d.js";
        $this->template->data["_core_js"][]     = "public/plugins/highcharts-11.3.0/modules/accessibility.js";
        $this->template->data["_support_js"][]  = "public/js/home.js";
    }
}
