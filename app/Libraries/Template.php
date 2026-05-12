<?php
namespace App\Libraries;
use App\Models\GeneralModel;
use Config\Services;
use Config\Session;
use App\Libraries\Utils;
use http\Env\Request;

/**
 * Class Template
 *
 * Model
 * @property GeneralModel   $general
 *
 * Library
 * @property Session        $session
 *
 */
class Template
{
    public
        $_css,
        $_js,
        $_core_css,
        $_support_css,
        $_core_js,
        $_support_js,
        $_type,
        $_template,
        $_user,
        $_agent,
        $_page_id,
        $_page_param,
        $_menu,
        $_full_size,
        $_content_class,
        $_show_kamban,
        $_version,
        $_modules,
        $_modules_url,
        $_overwrite_breadcrumb,
        $_logo,
        $data;

    function __construct()
    {
        $this->request                  = \Config\Services::request();
        $this->general                  = new GeneralModel();
        $this->data                     = array();
        $this->_page_id                 = "";
        $this->_page_param              = array();
        $this->_full_size               = false;
        $this->_overwrite_breadcrumb    = false;
        $this->_logo                    = base_url("public/images/so-logo.png");
        $this->_logo_url                = base_url();
        $this->_version                 = $this->get_version();

        $this->load_default();
    }

    function load_default()
    {
        $this->_core_css        = array(
            "https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css",
            "public/plugins/font-awesome/css/font-awesome.css",
            "public/plugins/jquery-confirm/jquery-confirm.css",
            "public/plugins/jquery.Wload/jquery.Wload.css"
        );
        $this->_support_css     = array(
            "public/css/custom.css",
        );
        $this->_core_js         = array(
            "public/plugins/jquery/jquery.min.js",
            /*"public/plugins/jquery-ui/jquery-ui.min.js",*/
            "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js",
            "public/plugins/jquery-block-ui/jqueryblockui.min.js",
            "public/plugins/jquery-unveil/jquery.unveil.min.js",
            "public/plugins/jquery-scrollbar/jquery.scrollbar.min.js",
            "public/plugins/jquery-numberAnimate/jquery.animateNumbers.js",
            "public/plugins/jquery-validation/js/jquery.validate.min.js",
            "public/plugins/jquery-confirm/jquery-confirm.js",
            "public/plugins/jquery.Wload/jquery.Wload.js",
        );
        $this->_support_js      = array(
            "public/js/common.js",
            "public/js/public.js",
        );

    }
    function generate($content)
    {
        $this->data["title"]            = (!empty($this->data["title"]) ? $this->data["title"] : "")."";
        $this->data["subtitle"]         = !empty($this->data["subtitle"]) ? $this->data["subtitle"] : "";
        $this->data["_logo"]            = $this->_logo;
        $this->data["_logo_url"]        = $this->_logo_url;
        $this->data["_version"]         = $this->_version;
        $this->data["_type"]            = $this->_type;
        $this->data["_page_id"]         = $this->_page_id;
        $this->data["_page_param"]      = $this->_page_param;
        $this->data["_content_class"]   = $this->_content_class;
        $this->data["_user"]            = $this->_user;

        $this->data["_css"]             = $this->generate_css();
        $this->data["_js"]              = $this->generate_js();


        echo view($content, $this->data);
    }

    protected function generate_css()
    {
        $content = "";

        // Core Css
        if (!empty($this->data["_core_css"]))
        {
            $this->_core_css = array_merge($this->_core_css, $this->data["_core_css"]);
        }

        foreach ($this->_core_css as $css)
        {
            if (ENVIRONMENT == ENVIRONMENT_DEVELOPMENT){
                $csst    = $css."?v=".time();
            }else{
                $csst    = $css."?v=".$this->_version;
            }

            if (strpos($css, 'http') !== false) {
                $content .= "<link rel='stylesheet' href='" . $css . "'>\n";
            } else {
                $content .= "<link rel='stylesheet' href='" . base_url($csst) . "'>\n";
            }
        }

        // Support Css
        if (!empty($this->data["_support_css"])) {
            $this->_support_css = array_merge($this->_support_css, $this->data["_support_css"]);
        }

        foreach ($this->_support_css as $css)
        {
            if (strpos($css, 'http') !== false)
            {
                $content .= "<link rel='stylesheet' href='" . $css . "'>\n";
            }
            else
            {
                if (ENVIRONMENT == ENVIRONMENT_DEVELOPMENT){
                    $csst    = $css."?v=".time();
                }else{
                    $csst    = $css."?v=".$this->_version;
                }

                $content .= "<link rel='stylesheet' href='" . base_url($csst) . "'>\n";
            }
        }

        return $content;
    }
    protected function generate_js()
    {
        $content = "";


        if (!empty($this->data["_core_js"])) {
            $this->_core_js = array_merge($this->_core_js, $this->data["_core_js"]);
        }

        $this->_core_js     = array_unique($this->_core_js);

        foreach ($this->_core_js as $js) {
            if (ENVIRONMENT == ENVIRONMENT_DEVELOPMENT){
                $jst    = $js."?v=".time();
            }else{
                $jst    = $js."?v=".$this->_version;
            }

            if (strpos($js, 'http') !== false) {
                $content .= "<script src='" . $js . "'></script>\n";
            } else {
                $content .= "<script src='" . base_url($jst) . "'></script>\n";
            }
        }

        if (!empty($this->data["_support_js"])) {
            $this->_support_js = array_merge($this->_support_js, $this->data["_support_js"]);
        }

        $this->_support_js     = array_unique($this->_support_js);

        foreach ($this->_support_js as $js) {

            if (strpos($js, 'http') !== false)
            {
                $content .= "<script src='" . $js . "'></script>\n";
            }
            else
            {
                if (ENVIRONMENT == ENVIRONMENT_DEVELOPMENT){
                    $jst    = $js."?v=".time();
                }else{
                    $jst    = $js."?v=".$this->_version;
                }

                $content .= "<script src='" . base_url($jst) . "'></script>\n";
            }

        }


        return $content;
    }
    protected function get_version()
    {
        $version        = $this->general->get_data("__sys_config", array(
            "name"      => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => "_app_version"
            )
        ))->getRow();
        $version        = !empty($version->value) ? $version->value : "1.0";

        return $version;
    }
}
