<?php
namespace App\Libraries;
use App\Models\GeneralModel;
use Config\Session;

/**
 * Class Formlib
 *
 * Library
 * @property General_model  $general
 * @property Encryptlib     $encryptlib
 * @property Utils          $utils
 * @property Template       $template
 * @property Filelib        $filelib
 */
class Formlib
{
    protected $_is_mobile;

    function __construct()
    {


        $this->session      = \Config\Services::session();
        $this->general      = new GeneralModel();
        $this->encryptlib   = new EncryptLib();
        $this->utils        = new Utils();
        $this->template     = new Template();
        $this->masterlib    = new MasterLib();
        $this->filelib      = new Filelib();

        $configs                    = $this->session->get("_configs");
        $this->_separator_decimal   = !empty($configs["separator_decimal"]["value"]) ? $configs["separator_decimal"]["value"] : SEPARATOR_DECIMAL;
        $this->_separator_thousands = !empty($configs["separator_thousands"]["value"]) ? $configs["separator_thousands"]["value"] : SEPARATOR_THOUSANDS;
    }

    function generate_form($param)
    {
        $param  = $this->built_param_default($param);

        if (!empty($param->type))
        {
            switch ($param->type)
            {
                case DATA_TYPE_ID:
                    return $this->_generate_input_id($param);
                    break;
                case DATA_TYPE_QUERY:
                case DATA_TYPE_TEXTBOX:
                case DATA_TYPE_TEXTBOX_EMAIL:
                case DATA_TYPE_ENCRYPTION:
                    return $this->_generate_input_text($param);
                    break;
                case DATA_TYPE_TEXTBOX_PASSWORD:
                    return $this->_generate_input_text_password($param);
                    break;
                case DATA_TYPE_NUMBER:
                case DATA_TYPE_DECIMAL:
                    return $this->_generate_input_number($param);
                    break;
                case DATA_TYPE_TEXTAREA:
                    return $this->_generate_input_textarea($param);
                    break;
                case DATA_TYPE_HTML:
                    return $this->_generate_input_textarea_html($param);
                    break;

                case DATA_TYPE_DATETIME:
                case DATA_TYPE_DATE:
                case DATA_TYPE_TIME:
                case DATA_TYPE_SYSDATE:
                    return $this->_generate_input_datetime($param);
                    break;

                case DATA_TYPE_SELECT_LIST_KEY:
                case DATA_TYPE_SELECT_LIST_VALUE:
                    return $this->_generate_input_select_list($param);
                case DATA_TYPE_SELECT_MASTER:
                    return $this->_generate_input_select_table($param);
                case DATA_TYPE_SELECT_TAGS:
                case DATA_TYPE_MULTISELECT:
                case DATA_TYPE_MULTISELECT_MASTER:
                    return $this->_generate_input_multiselect($param);
                    break;
                case DATA_TYPE_SELECT_MASTER_TREE:
                    return $this->_generate_input_tree($param);
                    break;

                case DATA_TYPE_RADIO_KEY:
                case DATA_TYPE_RADIO_VALUE:
                case DATA_TYPE_RADIO_KEY_HORIZONTAL:
                case DATA_TYPE_RADIO_VALUE_HORIZONTAL:
                case DATA_TYPE_RADIO_MASTER:
                    return $this->_generate_input_radio($param);
                    break;

                case DATA_TYPE_CHECKBOX:
                case DATA_TYPE_CHECKBOX_MASTER:
                    return $this->_generate_input_checkbox($param);
                    break;

                case DATA_TYPE_FILE:
                case DATA_TYPE_FILE_ARCHIVE:
                case DATA_TYPE_FILE_IMAGE:
                case DATA_TYPE_FILE_DOC:
                case DATA_TYPE_FILE_VIDEO:
                case DATA_TYPE_FILE_AUDIO:
                    return $this->_generate_input_file($param);
                    break;

                case DATA_TYPE_FILE_MULTIPLE:
                case DATA_TYPE_FILE_ARCHIVE_MULTIPLE:
                case DATA_TYPE_FILE_IMAGE_MULTIPLE:
                case DATA_TYPE_FILE_DOC_MULTIPLE:
                case DATA_TYPE_FILE_VIDEO_MULTIPLE:
                case DATA_TYPE_FILE_AUDIO_MULTIPLE:
                    return $this->_generate_input_file_multiple($param);
                    break;

                case DATA_TYPE_ICON:
                    return $this->_generate_input_list_icon($param);

                default:
                    return "";
            }
        }

        return false;
    }

    // Generate Form Element
    protected function _generate_input_id($param)
    {
        $value      = $this->encryptlib->encode($param->value);
        $content    = "<input type='hidden' readonly id='" . $param->id . "' name='" . $param->name . "' value='" . $value . "'>";
        return $content;

        return $content;
    }
    protected function _generate_input_text($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        if (is_array($param->value)){
            $param->value   = json_encode($param->value);
        }

        $element = "<input type='".$param->type."' id='".$param->id."' name='".$param->name."' class='form-control input-sm ".$class_element."' value='".$param->value."' placeholder='".$param->label."' ".$attr_element.">";

        if ($param->form_type == "datatable")
        {
            $content    = $element;
        }
        else if ($param->form_type == "form")
        {
            if (!$this->_is_mobile)
            {
                $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
            else
            {
                $content    .= "<div class='form-group boxed mb-15 form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<div class='input-wrapper'>";
                $content    .= "<label class='label'>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block text-danger mb-10 font-size-10'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
        }

        return $content;
    }
    protected function _generate_input_number($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        if ($param->form_type == "datatable")
        {
            $element = "<input type='text' id='".$param->id."' name='".$param->name."' class='form-control input-sm ".$class_element."' value='".$param->value."' placeholder='".$param->label."' ".$attr_element.">";
            $content    = $element;
        }
        else if ($param->form_type == "form")
        {
            if ($param->type == DATA_TYPE_DECIMAL)
            {
                $param->value   = $this->utils->number_format((float) $param->value, 2);
            }

            /*var_dump($param);
            die;*/

            if (!$this->_is_mobile)
            {
                $element = "<input type='text' id='".$param->id."' name='".$param->name."' class='form-control input-sm ".$class_element." input-number' value='".$param->value."' placeholder='".$param->label."' ".$attr_element." data-dec_point='".$this->_separator_decimal."' data-thousands_sep='".$this->_separator_thousands."', data-decimal='".($param->type == DATA_TYPE_DECIMAL ? 2 : 0)."'>";

                $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
            else
            {
                $element = "<input type='text' id='".$param->id."' name='".$param->name."' class='form-control text-right ".$class_element." input-number' value='".$param->value."' placeholder='".$param->label."' ".$attr_element." data-dec_point='".$this->_separator_decimal."' data-thousands_sep='".$this->_separator_thousands."', data-decimal='".($param->type == DATA_TYPE_DECIMAL ? 2 : 0)."' style='padding-right: 16px;'>";

                $content    .= "<div class='form-group boxed mb-15 form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<div class='input-wrapper'>";
                $content    .= "<label class='label'>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block text-danger mb-10 font-size-10'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
        }


        return $content;
    }
    protected function _generate_input_text_password($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        $element = "";

        $element .= "<div class='input-group input-group-sm'>";
        $element .= "<input type='password' id='".$param->id."' name='".$param->name."' class='form-control input-sm input-password ".$class_element."' value='".$param->value."' placeholder='".$param->label."' ".$attr_element.">";
        $element .= "</div>";


        if ($param->form_type == "datatable")
        {
            $content    = $element;
        }
        else if ($param->form_type == "form")
        {
            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;

            $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }

        return $content;
    }
    protected function _generate_input_textarea($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        if (is_array($param->value)){
            $param->value   = json_encode($param->value);
        }

        if ($param->form_type == "datatable")
        {
            $element = "<input type='".$param->type."' id='".$param->id."' name='".$param->name."' class='form-control input-sm ".$class_element."' value='".$param->value."' placeholder='".$param->label."' ".$attr_element.">";
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $element = "<textarea rows='3' id='".$param->id."' name='".$param->name."' class='form-control input-sm ".$class_element."' placeholder='".$param->label."' ".$attr_element.">".$param->value."</textarea>";

            if (!$this->_is_mobile)
            {
                $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
            else
            {
                $content    .= "<div class='form-group boxed mb-15 form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<div class='input-wrapper'>";
                $content    .= "<label class='label'>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block text-danger mb-10 font-size-10'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
                $content    .= "</div>";
            }

        }

        return $content;
    }
    protected function _generate_input_textarea_html($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        if ($param->form_type == "datatable")
        {
            $element = "<input type='".$param->type."' id='".$param->id."' name='".$param->name."' class='form-control input-sm ".$class_element."' value='".$param->value."' placeholder='".$param->label."' ".$attr_element.">";
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $element = "<textarea id='".$param->id."' name='".$param->name."' class='form-control input-html input-sm ".$class_element."' placeholder='".$param->label."' ".$attr_element.">".$param->value."</textarea>";

            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }

        return $content;
    }

    protected function _generate_input_datetime($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        $date_min           = !empty($param->other["date_min"]) ? $param->other["date_min"] : false;
        $date_max           = !empty($param->other["date_max"]) ? $param->other["date_max"] : false;

        $element    = "";

        if ($param->type == DATA_TYPE_DATETIME && $param->type == DATA_TYPE_SYSDATE){
            $data_invalid   = "0000-00-00 00:00:00";
        }else if ($param->type == DATA_TYPE_DATE){
            $data_invalid   = "0000-00-00";
        }else if ($param->type == DATA_TYPE_TIME){
            $data_invalid   = "";
        }

        if (!empty($data_invalid))
        {
            if ($param->value == $data_invalid){
                $param->value = "";
            }
        }

        if ($param->form_type == "datatable")
        {
            if ($param->type == DATA_TYPE_TIME){
                $class_element  .= " input-timerangepicker";
            }else{
                $class_element  .= " input-daterangepicker";
            }

            $element    .= "<input readonly type='text' id='".$param->id."' name='".$param->name."' autocomplete='off' class='form-control  pull-right input-sm ".$class_element."' ".$attr_element." value='".$param->value."' placeholder='".$param->label."'>";
            
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            if (strpos($attr_element, "readonly") === false)
            {
                if ($param->type == DATA_TYPE_DATETIME){
                    $class_element  .= " input-datetimepicker";
                }else if ($param->type == DATA_TYPE_DATE){
                    $class_element  .= " input-datepicker";
                }else if ($param->type == DATA_TYPE_TIME){
                    $class_element  .= " input-timepicker";
                }else{
                    $class_element  .= " input-daterangepicker";
                }
            }


            if (!empty($date_min)){
                $attr_element   .= " data-date_min='".$date_min."'";
            }
            if (!empty($date_max)){
                $attr_element   .= " data-date_max='".$date_max."'";
            }

            $element    .= "<input type='text' id='".$param->id."' name='".$param->name."' class='form-control pull-right input-sm ".$class_element."' ".$attr_element." value='".$param->value."'  autocomplete='off' placeholder='".$param->label."'>";

            if (!$this->_is_mobile)
            {
                $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
            else
            {
                $content    .= "<div class='form-group boxed mb-15 form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<div class='input-wrapper'>";
                $content    .= "<label class='label'>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block text-danger mb-10 font-size-10'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
        }

        return $content;
    }
    protected function _generate_input_time($param)
    {
        $content            = "";
        $attr_container     = !empty($param["attr-container"]) ? $this->_generate_attributes($param["attr-container"]) : "";
        $attr_element       = !empty($param["attr-element"]) ? $this->_generate_attributes($param["attr-element"]) : "";

        $class_container    = !empty($param["class-container"]) ? implode(" ", $param["class-container"]) : "";
        $class_element      = !empty($param["class-element"]) ? implode(" ", $param["class-element"]) : "";

        $type   = $param["type"];
        $id     = $param["id"];
        $name   = $param["name"];
        $label  = $param["label"];
        $value  = $param["value"];

        $element    = "";

        if (!empty($param["element-only"])) {


            $element    .= "<div class='input-group'>";
            $element    .= "<div class='input-group-addon'><i class='fa fa-calendar'></i></div>";
            $element    .= "<input readonly type='text' id='".$id."' name='".$param["name"]."' class='form-control input-timerangepicker pull-right input-sm ".$class_element."' ".$attr_element." value='".$value."' placeholder='".$label."'>";
            $element    .= "</div>";

            $content = $element;
        } else {

            $element    .= "<div class='input-group'>";
            $element    .= "<div class='input-group-addon'><i class='fa fa-calendar'></i></div>";
            $element    .= "<input readonly type='text' id='".$id."' name='".$param["name"]."' class='form-control input-timepicker pull-right input-sm ".$class_element."' ".$attr_element." value='".$value."' placeholder='".$label."'>";
            $element    .= "</div>";

            $content    .= "<div class='mb-5 form-group form-field-".$id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$label." ".(in_array("required", $param["validation"]) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param["note"]) ? "<small class='form-notes'>".(!empty($param["note"]) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param["note"] : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }

        return $content;
    }

    protected function _generate_input_select_list($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        $list       = !empty($param->other["list"]) ? (array) $param->other["list"] : array();

        $element    = "";
        $element    .= "<select id='".$param->id."' name='".$param->name."' class='form-control input-sm input-select2 ".$class_element."'  ".$attr_element.">";
        $element    .= "<option selected value=''>Select</option>";

        foreach ($list as $key => $value)
        {
            if ($param->type == DATA_TYPE_SELECT_LIST_KEY)
            {
                $element        .= "<option value='".$key."' ".((string)$key === (string)$param->value ? "selected" : "").">".$value."</option>";
            }
            else if ($param->type == DATA_TYPE_SELECT_LIST_VALUE)
            {
                $element        .= "<option value='".$value."' ".((string)$value === (string)$param->value ? "selected" : "").">".$value."</option>";
            }
        }

        $element    .= "</select>";

        if ($param->form_type == "datatable")
        {
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }

        return $content;
    }
    protected function _generate_input_select_table($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        $source             = (array) $param->other["source"];

        $element    = "";
        $element    .= "<select data-show='".(!empty($source["field_show"]) ?  json_encode($source["field_show"]) : "")."' id='".$param->id."' name='".$param->name."' class='form-control input-sm input-select2 ".$class_element."'  ".$attr_element.">";
        $element    .= "<option selected value=''>Select</option>";

        if (!empty($source["field_show"]))
        {
            $tmp_select = " label='".ucfirst($source["field_label"])."'";

            foreach ($source["field_show"] as $show)
            {
                $tmp_select .= " data-".$show."='".ucfirst($show)."'";
            }
            $element    .= "<optgroup class='def-cursor' ".$tmp_select.">";
        }

        foreach ($source["data"] as $item)
        {
            $option_value      = $source["field_key"];
            $option_label      = $source["field_label"];

            $tmp_select         = "";

            if (!empty($source["field_show"]))
            {
                foreach ($source["field_show"] as $show)
                {
                    $tmp_select .= " data-".$show."='".$item->$show."'";
                }
            }

            $element        .= "<option value='".$item->$option_value."' ".($item->$option_value == $param->value ? "selected" : "")." ".$tmp_select.">".$item->$option_label."</option>";
        }

        $element    .= "</select>";

        if ($param->form_type == "datatable")
        {
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }


        return $content;
    }
    protected function _generate_input_multiselect($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        if (!is_array($param->value)){
            $param->value       = explode(DATA_MULTI_SEPARATOR, $param->value);
        }
        $param->value       = array_filter($param->value);

        if ($param->type == DATA_TYPE_MULTISELECT_MASTER)
        {
            $list   = (array) $param->other["source"]["data"];
            $source = (array) $param->other["source"];
        }
        else if ($param->type == DATA_TYPE_SELECT_TAGS)
        {
            if (!empty($param->other["list"]))
            {
                $list   = $param->other["list"];
            }
            else
            {
                $list   = $param->value;
            }

            $tmp_list   = array();
            foreach ($list as $item)
            {
                $item   = explode(DATA_MULTI_SEPARATOR, $item);
                $item   = array_filter($item);
                $item   = array_unique($item);

                foreach ($item as $value)
                {
                    $tmp_list[]     = $value;
                }
            }
            sort($tmp_list);
            $list   = $tmp_list;
        }
        else
        {
            $list   = !empty($param->other["list"]) ? (array) $param->other["list"] : array();
        }

        if ($param->type == DATA_TYPE_SELECT_TAGS){
            $tags   = true;
        }else{
            $tags   = false;
        }

        $element    = "";

        if ($param->form_type == "datatable")
        {
            $element    .= "<select id='".$param->id."' name='".$param->name."' class='form-control input-sm input-select2 ".$class_element."'  ".$attr_element.">";
        }
        else if ($param->form_type == "form")
        {
            $element    .= "<select id='".$param->id."' name='".$param->name."[]' class='form-control input-sm input-select2 ".$class_element."'  ".$attr_element."  multiple='true' ".($tags ? "tags=1" : "").">";
        }

        $element    .= "<option value=''>Select</option>";

        foreach ($list as $value)
        {
            if ($param->type == DATA_TYPE_MULTISELECT_MASTER)
            {
                $field_key      = $source["field_key"];
                $field_label    = $source["field_label"];

                $element    .= "<option value='".$value->$field_key."' ".(in_array($value->$field_key, $param->value) ? "selected" : "").">".$value->$field_label."</option>";
            }
            else
            {
                $element    .= "<option value='".$value."' ".(in_array($value, $param->value) ? "selected" : "").">".$value."</option>";
            }
        }

        $element    .= "</select>";

        if ($param->form_type == "datatable")
        {
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }

        return $content;
    }
    protected function _generate_input_tree($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        $source             = (array) $param->other["source"];
        $list               = $source["data"];
        $list               = array_map(function ($item) {

            $item   = (array) $item;
            $text   = "";

            if (!empty($item["label"])){
                $text   = $item["label"];
            } else if (!empty($item["title"])){
                $text   = $item["title"];
            } else if (!empty($item["name"])){
                $text   = $item["name"];
            }

            return array(
                "id"        => $item["id"],
                "text"      => $text,
                "id_parent" => $item["id_parent"],
            );

        }, $list);
        $list               = $this->utils->rebuilt_tree($list, 0, "id", "id_parent", "children", null, null, array("state" => "closed"));

        $element            = "";

        if ($param->form_type == "datatable")
        {
            $content    = $this->_generate_input_select_table($param);
        }
        else if ($param->form_type == "form")
        {
            $element    .= "<input type='text'  id='".$param->id."' autocomplete='off' class='form-control input-sm input-combotree ".$class_element."' ".$attr_element." value='".(!empty($param->value) ? $param->value : "")."'>";
            $element    .= "<input type='hidden' id='list_".$param->id."' value='".json_encode($list)."'>";
            $element    .= "<input type='hidden' id='data_".$param->id."' name='".$param->name."' value='".$param->value."'>";

            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }

        return $content;
    }

    protected function _generate_input_radio($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        $other              = $param->other;

        if ($param->type == DATA_TYPE_RADIO_MASTER)
        {
            $field_key      = $other["source"]["field_key"];
            $field_label    = $other["source"]["field_label"];
            $data           = $other["source"]["data"];

            $list           = array();

            foreach ($data as $item)
            {
                $list[$item->$field_key]    = $item->$field_label;
            }
        }
        else
        {
            $list   = !empty($other["list"]) ? $other["list"] : array();
        }

        if ($param->form_type == "datatable")
        {
            $element = "";
            $element .= "<select id='" . $param->id . "' name='" . $param->name . "' class='form-control input-sm input-select2 " . $class_element . "'  " . $attr_element . ">";
            $element .= "<option selected value=''>Select</option>";

            foreach ($list as $key => $value)
            {
                if ($param->type == DATA_TYPE_RADIO_KEY || $param->type == DATA_TYPE_RADIO_KEY_HORIZONTAL || $param->type == DATA_TYPE_RADIO_MASTER)
                {
                    $element .= "<option value='" . $key . "' " . ((string)$key === (string)$param->value ? "selected" : "") . ">" . $value . "</option>";
                }
                else if ($param->type == DATA_TYPE_RADIO_VALUE || $param->type == DATA_TYPE_RADIO_VALUE_HORIZONTAL)
                {
                    $element .= "<option value='" . $value . "' " . ((string)$value === (string)$param->value ? "selected" : "") . ">" . $value . "</option>";
                }
            }

            $element .= "</select>";

            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $element    = "";

            if (!$this->_is_mobile)
            {
                $element    .= "<input type='hidden'  name='".$param->name."' value=''>";

                foreach ($list as $key => $value)
                {
                    if ($param->type == DATA_TYPE_RADIO_KEY_HORIZONTAL || $param->type == DATA_TYPE_RADIO_VALUE_HORIZONTAL)
                    {
                        $element    .= "<span class='input-icheck mr-10'>";
                    }
                    else
                    {
                        $element    .= "<label class='input-icheck'>";
                    }

                    if ($param->type == DATA_TYPE_RADIO_KEY || $param->type == DATA_TYPE_RADIO_KEY_HORIZONTAL || $param->type == DATA_TYPE_RADIO_MASTER)
                    {
                        $element    .= "<input type='radio' ".$attr_element." class='flat-red ".$class_element."' name='".$param->name."' value='".$key."' ".((string)$key === (string)$param->value ? "checked" : "").">&nbsp;&nbsp;".$value;
                    }
                    else if ($param->type == DATA_TYPE_RADIO_VALUE || $param->type == DATA_TYPE_RADIO_VALUE_HORIZONTAL)
                    {
                        $element    .= "<input type='radio' ".$attr_element." class='flat-red ".$class_element."' name='".$param->name."' value='".$value."' ".((string)$value === (string)$param->value ? "checked" : "").">&nbsp;&nbsp;".$value;
                    }

                    if ($param->type == DATA_TYPE_RADIO_KEY_HORIZONTAL || $param->type == DATA_TYPE_RADIO_VALUE_HORIZONTAL)
                    {
                        $element    .= "</span>";
                    }
                    else
                    {
                        $element    .= "</label>";
                    }

                    $element    .= "<br>";
                }

                $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= $element;
                $content    .= !empty($param->note) ? "<br><small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
            else
            {
                $element    .= "<input type='hidden' name='".$param->name."' value=''>";
                foreach ($list as $key => $value)
                {
                    $element    .= "<div class='form-check'>";

                    if ($param->type == DATA_TYPE_RADIO_KEY || $param->type == DATA_TYPE_RADIO_KEY_HORIZONTAL || $param->type == DATA_TYPE_RADIO_MASTER)
                    {
                        $element    .= "<input class='form-check-input' type='radio' name='".$param->name."' value='".$key."' ".((string)$key === (string)$param->value ? "checked" : "")." id='".$param->name."_".$key."'>";
                        $element    .= "<label class='form-check-label font-size-12' for='".$param->name."_".$key."'>".$value."</label>";

                        /*$element    .= "<input type='radio' ".$attr_element." class='flat-red ".$class_element."' name='".$param->name."' value='".$key."' ".((string)$key === (string)$param->value ? "checked" : "").">&nbsp;&nbsp;".$value;*/
                    }
                    else if ($param->type == DATA_TYPE_RADIO_VALUE || $param->type == DATA_TYPE_RADIO_VALUE_HORIZONTAL)
                    {
                        $element    .= "<input class='form-check-input' type='radio' name='".$param->name."' value='".$value."' ".((string)$value === (string)$param->value ? "checked" : "")." id='".$param->name."_".$key."'>";
                        $element    .= "<label class='form-check-label font-size-12' for='".$param->name."_".$key."'>".$value."</label>";

                        /*$element    .= "<input type='radio' ".$attr_element." class='flat-red ".$class_element."' name='".$param->name."' value='".$value."' ".((string)$value === (string)$param->value ? "checked" : "").">&nbsp;&nbsp;".$value;*/
                    }

                    $element    .= "</div>";
                }

                $content    .= "<div class='form-group boxed mb-15 form-field-".$param->id." ".$class_container."' ".$attr_container.">";
                $content    .= "<div class='input-wrapper'>";
                $content    .= "<label class='label'>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
                $content    .= "<div class='element-input-container'>";
                $content    .= "<div class='input-list'>";
                $content    .= $element;
                $content    .= "</div>";
                $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
                $content    .= "<span class='help-block text-danger mb-10 font-size-10'></span>";
                $content    .= "</div>";
                $content    .= "</div>";
                $content    .= "</div>";

            }
        }


        return $content;
    }
    protected function _generate_input_checkbox($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        if (!empty($param->value)){
            if (!is_array($param->value)){
                $param->value       = explode(DATA_MULTI_SEPARATOR, $param->value);
                $param->value       = array_filter($param->value);
            }
        } else {
            $param->value       = array();
        }

        $other              = $param->other;

        if ($param->type == DATA_TYPE_CHECKBOX_MASTER)
        {
            $field_key      = $other["source"]["field_key"];
            $field_label    = $other["source"]["field_label"];
            $data           = $other["source"]["data"];

            $list           = array();

            foreach ($data as $item)
            {
                $list[$item->$field_key]    = $item->$field_label;
            }
        }
        else
        {
            $list   = !empty($other["list"]) ? $other["list"] : array();
        }

        if ($param->form_type == "datatable")
        {
            $element = "";
            $element .= "<select id='" . $param->id . "' name='" . $param->name . "' class='form-control input-sm input-select2 " . $class_element . "'  " . $attr_element . ">";
            $element .= "<option selected value=''>Select</option>";

            foreach ($list as $key => $value)
            {
                if ($param->type == DATA_TYPE_CHECKBOX_MASTER)
                {
                    $element .= "<option value='" . $key . "' " . (in_array($key, $param->value) ? "checked" : "") . ">" . $value . "</option>";
                }
                else if ($param->type == DATA_TYPE_CHECKBOX)
                {
                    $element .= "<option value='" . $value . "' " . (in_array($value, $param->value) ? "checked" : "") . ">" . $value . "</option>";
                }
            }

            $element .= "</select>";

            $content = $element;
        }
        else if ($param->form_type == "form")
        {

            $element    = "";

            foreach ($list as $key => $value)
            {
                $element    .= "<label class='input-icheck'>";

                if ($param->type == DATA_TYPE_CHECKBOX_MASTER)
                {
                    $element    .= "<input type='checkbox' ".$attr_element." class='flat-red' name='".$param->name."[]' value='".$key."' ".(in_array($key, $param->value) ? "checked" : ""). ">&nbsp;&nbsp;".$value;
                }
                else if ($param->type == DATA_TYPE_CHECKBOX)
                {
                    $element    .= "<input type='checkbox' ".$attr_element." class='flat-red' name='".$param->name."[]' value='".$value."' ".(!empty($param->value) && in_array($value, $param->value) ? "checked" : "").">&nbsp;&nbsp;".$value;
                }

                $element    .= "</label>";
            }

            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }


        return $content;
    }

    protected function _generate_input_file($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        if ($param->form_type == "datatable")
        {
            $element = "<input type='text' id='".$param->field."' name='".$param->name."' class='form-control input-sm ".$class_element."' value='".$param->value."' placeholder='".$param->label."' ".$attr_element.">";
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $param      = $this->_get_extention_allow_for_upload($param);

            $element    = "";
            $element    .= "<button type='button' data-id='form-field-".$param->id."' class='btn btn-info btn-sm btn-small btn-file'><i class='fa fa-cloud-upload'></i>&nbsp;&nbsp;Choose File</button>";
            $element    .= "<input type='file' class='input-file hidden' placeholder='".$param->label."' ".$attr_element." data-field='".$param->field."' data-type='".$param->type."'  >";
            $element    .= "<input type='hidden' id='".$param->id."' name='".$param->name."' class='file ".$class_element."' value='".$param->value."' placeholder='".$param->label."' ".$attr_element."  >";


            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label class=''>";
            $content    .= $param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "");

            $content    .= "</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<div class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</div>" : "";
            $content    .= "<span class='help-block'></span>";

            $content_file   = $this->filelib->get_view_file($param->value, $param, FILE_VIEW_FORM);

            $content    .= "<div class='well well-sm ".(empty($content_file) ? "hidden" : "")."'>";
            $content    .= "<div class='file-list ".(empty($content_file) ? "hidden" : "")."'>";
            $content    .= $content_file;
            $content    .= "</div>";
            $content    .= "<div class='file-loading hidden text-center'><img src='".base_url("public/images/loader.gif")."' class='' style='width: 40px' /></div>";
            $content    .= "</div>";
            $content    .= "</div>";
            $content    .= "</div>";
        }


        return $content;
    }
    protected function _generate_input_file_multiple($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        $param->value       = explode(DATA_MULTI_SEPARATOR, $param->value);
        $param->value       = array_filter($param->value);

        if ($param->form_type == "datatable")
        {
            $element = "<input type='text' id='".$param->id."' name='".$param->name."' class='form-control input-sm ".$class_element."' value='' placeholder='".$param->label."' ".$attr_element.">";
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $param      = $this->_get_extention_allow_for_upload($param);

            $element    = "";
            $element    .= "<button type='button' data-id='form-field-".$param->id."' class='btn btn-info btn-sm btn-small btn-file-dynamic'><i class='fa fa-cloud-upload'></i>&nbsp;&nbsp;Tambah File</button>";
            $element    .= "<input type='file' class='input-file-dynamic hidden' placeholder='".$param->label."' ".$attr_element." data-field='".$param->field."' data-type='".$param->type."'  >";
            $element    .= "<input type='hidden' id='".$param->id."' name='".$param->name."' class='file ".$class_element."' value='".(!empty($param->value) ? implode(",", $param->value) : "")."' placeholder='".$param->label."' ".$attr_element."  >";


            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container." field-file-dynamic' ".$attr_container.">";
            $content    .= "<label class=''>";
            $content    .= $param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "");

            $content    .= "</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<div class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</div>" : "";
            $content    .= "<span class='help-block'></span>";


            $content    .= "<div class='well well-sm ".(empty($param->value) ? "hidden" : "")."'>";
            $content    .= "<div class='file-list ".(empty($param->value) ? "hidden" : "")."'>";
            $content    .= $this->filelib->get_view_file($param->value, $param, FILE_VIEW_FORM);
            $content    .= "</div>";
            $content    .= "<div class='file-loading hidden text-center'><img src='".base_url("public/images/loader.gif")."' class='' style='width: 40px' /></div>";
            $content    .= "</div>";
            $content    .= "</div>";
            $content    .= "</div>";
        }


        return $content;
    }
    protected function _generate_input_list_icon($param)
    {
        $content            = "";
        $attr_container     = !empty($param->attr_container) ? $this->_generate_attributes($param->attr_container) : "";
        $attr_element       = !empty($param->attr_element) ? $this->_generate_attributes($param->attr_element) : "";

        $class_container    = !empty($param->class_container) ? implode(" ", $param->class_container) : "";
        $class_element      = !empty($param->class_element) ? implode(" ", $param->class_element) : "";

        $source             = (array) $param->other["source"];
        $list               = $source["list"];

        $element    = "";
        $element    .= "<select data-icons='true' id='".$param->id."' name='".$param->name."' class='form-control input-sm input-select2 ".$class_element."'  ".$attr_element.">";
        $element    .= "<option selected value=''>Select</option>";

        foreach ($list as $group => $list_options)
        {
            $element        .= "<optgroup label='".$group."'>";

            foreach ($list_options as $value)
            {
                $element        .= "<option value='".$value."' ".((string)$value === (string)$param->value ? "selected" : "").">".$value."</option>";
            }

            $element        .= "</optgroup>";

        }

        $element    .= "</select>";

        if ($param->form_type == "datatable")
        {
            $content = $element;
        }
        else if ($param->form_type == "form")
        {
            $content    .= "<div class='mb-5 form-group form-field-".$param->id." ".$class_container."' ".$attr_container.">";
            $content    .= "<label>".$param->label." ".(in_array("required", $param->validation) ? "<span class='text-danger'>*</span>" : "")."</label>";
            $content    .= "<div class='element-input-container'>";
            $content    .= $element;
            $content    .= !empty($param->note) ? "<small class='form-notes'>".(!empty($param->note) ? "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;".$param->note : "")."</small>" : "";
            $content    .= "<span class='help-block'></span>";
            $content    .= "</div>";
            $content    .= "</div>";
        }


        return $content;
    }

    // Other Function
    public function set_library()
    {
        $data   = array(
            "_core_css"     => array(),
            "_core_js"      => array(),
            "_support_css"  => array(),
            "_support_js"   => array(),
        );
        $data["_core_css"][]    = "public/plugins/select2/dist/css/select2.min.css";
        $data["_core_css"][]    = "public/plugins/bootstrap-daterangepicker/daterangepicker.css";

        $data["_core_css"][]    = "public/plugins/jquery.datetimepicker/jquery.datetimepicker.css";

        $data["_core_css"][]    = "public/plugins/iCheck/all.css";
        $data["_core_css"][]    = "public/plugins/jquery-confirm/jquery-confirm.css";
        $data["_core_css"][]    = "public/plugins/jquery-password-strength/passtrength.css";

        $data["_core_js"][]     = "public/plugins/select2/dist/js/select2.full.min.js";
        $data["_core_js"][]     = "public/plugins/moment/min/moment.min.js";
        $data["_core_js"][]     = "public/plugins/bootstrap-daterangepicker/daterangepicker.js";

        $data["_core_js"][]     = "public/plugins/jquery.datetimepicker/php-date-formatter.min.js";
        $data["_core_js"][]     = "public/plugins/jquery.datetimepicker/jquery.datetimepicker.js";

        $data["_core_js"][]     = "public/plugins/iCheck/icheck.min.js";
        $data["_core_js"][]     = "public/plugins/jquery-confirm/jquery-confirm.js";
        $data["_core_js"][]     = "public/plugins/jquery-number/jquery.number.js";
        $data["_core_js"][]     = "public/plugins/jquery-password-strength/jquery.passtrength.js";

        $data["_core_css"][]    = "public/plugins/easyui/easyui.css";
        $data["_core_css"][]    = "public/plugins/easyui/icon.css";
        $data["_core_css"][]    = "public/plugins/iCheck/all.css";

        $data["_core_js"][]     = "public/plugins/iCheck/icheck.min.js";
        $data["_core_js"][]     = "public/plugins/easyui/jquery.easyui.min.js";
        $data["_core_js"][]     = "public/plugins/easyui/datagrid-filter.min.js";


        $data["_core_js"][]     = "public/ckeditor5/build/ckeditor.js";
        $data["_core_js"][]     = "public/ckfinder//ckfinder.js";
        /*$data["_core_js"][]     = "public/ckeditor5/src/ckeditor.js";
        $data["_core_js"][]     = "public/ckfinder/ckfinder.js";*/

        $data["_support_js"][]  = "public/js/lib/form.js";

        return $data;
    }
    protected function built_param_default($param)
    {
        $new_param          = (object) [];

        $new_param->form_type       = $param["form_type"];
        $new_param->type            = $param["type"];
        $new_param->id              = array_key_exists("id", $param) ? $param["id"] : "";
        $new_param->field           = array_key_exists("field", $param) ? $param["field"] : "";
        $new_param->name            = array_key_exists("name", $param) ? $param["name"] : "";
        $new_param->label           = array_key_exists("label", $param) ? $param["label"] : "";
        $new_param->value           = array_key_exists("value", $param) ? $param["value"] : "";
        $new_param->attr_container  = array_key_exists("attr_container", $param) ? $param["attr_container"] : array();
        $new_param->attr_element    = array_key_exists("attr_element", $param) ? $param["attr_element"] : array();
        $new_param->class_container = array_key_exists("class_container", $param) ? $param["class_container"] : array();
        $new_param->class_element   = array_key_exists("class_element", $param) ? $param["class_element"] : array();

        if (!is_array($new_param->class_container)){
            $new_param->class_container = explode(" ", $new_param->class_container);
        }
        if (!is_array($new_param->class_element)){
            $new_param->class_element   = explode(" ", $new_param->class_element);
        }

        $new_param->validation      = array_key_exists("validation", $param) ? $param["validation"] : array();
        $new_param->note            = array_key_exists("note", $param) ? $param["note"] : "";
        $new_param->other           = array_key_exists("other", $param) ? $param["other"] : array();

        return $new_param;
    }
    protected function _generate_attributes($attributes)
    {
        $content = "";

        foreach ($attributes as $key => $val) {
            $content .= " " . $key . " = '" . $val . "' ";
        }

        return $content;
    }
    protected function _render_table_tree($param, $data, $level = 1)
    {
        $element    = "";

        foreach ($data as $item)
        {
            $option_value      = $param->other["source"]["field_key"];
            $option_label      = $param->other["source"]["field_label"];

            $tmp_select         = "";

            if (!empty($param->other["source"]["field_show"]))
            {

                foreach ($param->other["source"]["field_show"] as $show)
                {
                    $tmp_select .= " data-".$show."='".$item[$show]."'";
                }
            }

            $class_option   = "";
            $class_option   .= !empty($item["children"]) ? "non-leaf" : "";
            $class_option   .= " l".$level;

            $element        .= "<option data-pup='".($item["id_parent"])."' value='".$item[$option_value]."' ".($item[$option_value] == $param->value ? "selected" : "")." ".$tmp_select." class='".$class_option."'>".$item[$option_label]."</option>";


            if (!empty($item["children"]))
            {
                $element    .= $this->_render_table_tree($param, $item["children"], ($level + 1));
            }
        }

        return $element;

    }
    protected function _get_extention_allow_for_upload($param)
    {
        if (!empty($param->other["exts"]))
        {
            $exts   = $param->other["exts"];
        }
        else
        {
            $exts   = $this->filelib->get_ext_by_type($param->type);
        }

        $exts           = implode(", ", $exts);
        $param->note    .= (!empty($param->note) ? "<br>" : "")."File harus memiliki format (".$exts.")";

        return $param;
    }
}
