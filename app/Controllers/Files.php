<?php
namespace App\Controllers;
use App\Controllers\GeneralModel;
use App\Controllers\MyController;
use App\Libraries\Encryptlib;
use App\Libraries\Filelib;
use App\Libraries\Template;
use App\Libraries\Datatable;
use App\Libraries\Formlib;
use App\Libraries\Transaction;
use Config\Validation;
use CodeIgniter\Files\File;
/**
 *
 * Class File
 *
 * @property Template $template
 * @property General_model $general
 * @property Datatable $datatable
 * @property Formlib $formlib
 * @property Encryptlib $encryptlib
 * @property Filelib $filelib
 *
 */

class Files extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->filelib              = new Filelib();
        $this->encryptlib           = new EncryptLib();

    }

    function download($hash)
    {
        $hash   = $this->encryptlib->decode($hash);
        $files  = $this->general->get_data("mst_files", array(
            "id" => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $hash
            )
        ))->getRow();

        $file = $files->directory.DIRECTORY_SEPARATOR.$files->file_name;


        return $this->response->download($file, null)->setFileName($files->file_name_ori);
        /*force_download($files->file_name_ori, file_get_contents($file));*/
    }
    function get_file()
    {
        if ($this->request->isAJAX())
        {
            $ids            = !empty($_REQUEST["id"]) ? $_REQUEST["id"] : "";
            $ids            = explode(",", $ids);
            $type           = !empty($_REQUEST["type"]) ? $_REQUEST["type"] : "";
            $field["type"]  = $type;

            $content    = $this->filelib->get_view_file($ids, $field, FILE_VIEW_LIST);

            if (is_array($ids))
            {

            }
            else
            {

            }

            $result     = array(
                "title"     => "File Viewer",
                "content"   => $content,
            );

            header("Content-Type: application/json");
            echo json_encode($result);

        }
    }
    function view($hash)
    {
        $hash   = $this->encryptlib->decode($hash);
        $files  = $this->filelib->get_by_id($hash);

        if (!empty($files))
        {
            if (file_exists($files->file_loc))
            {

                $mime_type  = mime_content_type($files->file_loc);
                $file_type  = $this->filelib->get_type_by_ext($files->file_ext);

                if ($file_type == DATA_TYPE_FILE_IMAGE)
                {
                    $imageData = base64_encode(file_get_contents($files->file_loc));
                    echo "data:".$mime_type.";base64,".$imageData."";
                    die;
                }


            }
            else
            {
                exit('No direct script access allowed');
            }
        }
        else
        {
            exit('No direct script access allowed');
        }
    }



    public function files_lms()
    {
        $this->load->library("zip");
        $this->load->helper("security");

        $date           = date("YmdH");
        $tmp_dir        = "public".DIRECTORY_SEPARATOR."tmp";
        $folder_name    = "JAKLEARN_".$date;
        $tmp_folder     = $tmp_dir.DIRECTORY_SEPARATOR.preg_replace('/[^a-zA-Z0-9-]/', '_', $folder_name);;

        if (!is_dir($tmp_dir)) {
            mkdir($tmp_dir, 0777);
        }
        if (!is_dir($tmp_folder)) {
            mkdir($tmp_folder, 0777);
        }

        $this->_modules_table   = array(
            "lms_"          => "JAKLEARN",
            "services_"     => "KAMBAN",
            "plan_"         => "PLANB",
            "recruitment_"  => "RECRUITMENT",
            "peduli_"       => "PEDULI",
            "__erecom_"     => "E-REKOMENDASI",
            "arsip_"        => "ARSIP"
        );

        $this->files_master();
        $this->files_table();
        ksort($this->_file_ids);

        foreach ($this->_file_ids as $id_file => $item)
        {
            $files      = $this->filelib->get_by_id($id_file);

            if (!empty($files))
            {
                if ($files->file_exist)
                {
                    $data_files     = array(
                        "id"            => $files->id,
                        "object_type"   => $files->object_type,
                        "directory"     => $files->directory,
                        "file_name_ori" => $files->file_name_ori,
                        "file_name"     => $files->file_name,
                        "file_ext"      => $files->file_ext,
                        "file_size"     => $files->file_size,
                        "file_tmp"      => $files->file_tmp,
                        "status"        => $files->status,
                        "meta"          => $files->meta,
                        "file_exist"    => $files->file_exist,
                        "file_used"     => $files->file_used,
                        "modules_name"  => $files->modules_name,
                        "modules_table" => $files->modules_table,
                        "created_tmp"   => $files->created_tmp,
                        "created"       => $files->created,
                        "createdby"     => $files->createdby,
                        "updated"       => $files->updated,
                        "updatedby"     => $files->updatedby,
                    );

                    $this->general->update_dynamic("lms_files", array(
                        "id"    => array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                            SQL_CONDITION_VALUE     => $files->id
                        )
                    ), $data_files);

                    /*$new_path       = str_replace("public/files", $tmp_folder, $files->file_loc);
                    copy($files->file_loc, $new_path);*/
                }
            }
        }
    }
    protected function files_master()
    {
        $field_type     = array();

        foreach ($this->filelib->_ext_group as $key => $value)
        {
            $field_type[]   = $key;
        }

        $master_fields  = $this->general->get_data("__sys_fields", array(
            "type"          => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_IN,
                SQL_CONDITION_VALUE     => $field_type
            ),
            "table_name"    => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_LIKE_AFTER,
                SQL_CONDITION_VALUE     => "lms_"
            )
        ), null, null, null, null, array(
            "__sys_sources.table_name",
            "__sys_sources.table_alias",
            "__sys_fields.source",
            "__sys_fields.field",
            "__sys_fields.name",
        ), array(
            array(
                "table"     => "__sys_sources",
                "condition" => "__sys_sources.id = __sys_fields.id_source",
                "type"      => "LEFT",
            )
        ))->result();

        $tmp_data       = array();

        foreach ($master_fields as $master_field)
        {
            if ($master_field->source == SOURCE_TYPE_FIELD)
            {
                $module     = "JSO";

                foreach ($this->_modules_table as $tmp_table => $tmp_module)
                {
                    $string_length  = strlen($tmp_table);
                    $string_find    = substr($master_field->table_name, 0, $string_length);

                    if ($string_find === $tmp_table)
                    {
                        $module     = $tmp_module;
                    }
                }

                $data       = $this->general->get_data($master_field->table_name, array(), null, null, null, null, array(
                    $master_field->field." AS tmp"
                ))->result();
                $data       = $this->generate_ids_files($data);

                foreach ($data as $id_file)
                {
                    $this->_file_ids[$id_file]      = array(
                        "module"        => $module,
                        "table"         => $master_field->table_name
                    );
                }
            }
        }
    }
    protected function files_table()
    {
        $fields     = $this->general->query("
            SELECT 
            TABLE_NAME AS 'table',
            COLUMN_NAME AS 'field',
            DATA_TYPE AS 'type'
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = '".$this->db->database."'
            and TABLE_NAME NOT LIKE 'talenta_%'
            and TABLE_NAME NOT LIKE '__dynamics_%'
            and TABLE_NAME NOT LIKE 'view_%'
            and TABLE_NAME NOT LIKE '__microsoft%'
            and TABLE_NAME != 'mst_files'
            and TABLE_NAME != 'mst_files_tmp'
            and TABLE_NAME LIKE 'lms_%'
            AND COLUMN_NAME REGEXP 'id_file|thumbnail|attachment|file|attachment'
        ")->result();
        $tmp_ids    = array();

        foreach ($fields as $tmp)
        {
            $module     = "JSO";

            foreach ($this->_modules_table as $tmp_table => $tmp_module)
            {
                $string_length  = strlen($tmp_table);
                $string_find    = substr($tmp->table, 0, $string_length);

                if ($string_find === $tmp_table)
                {
                    $module     = $tmp_module;
                }
            }

            $data   = $this->general->get_data($tmp->table, array(), null, null, null, null, array(
                $tmp->field." AS tmp"
            ))->result();
            $data   = $this->generate_ids_files($data);


            foreach ($data as $id_file)
            {
                $this->_file_ids[$id_file]      = array(
                    "module"        => $module,
                    "table"         => $tmp->table
                );
            }
        }
    }
    protected function generate_ids_files($data)
    {
        $result     = array();

        foreach ($data as $item)
        {
            if (!empty($item->tmp))
            {
                $tmp    = explode(",", $item->tmp);
                $tmp    = array_filter($tmp);
                $tmp    = array_unique($tmp);
                $tmp    = array_map(function ($item) {
                    return (int) $item;
                }, $tmp);

                $result    = array_merge($result, $tmp);
            }
        }

        return $result;
    }
    protected function _checkfile($path, $i = 1)
    {
        if (file_exists($path)){
            $path       = explode(".", $path);
            $new_path   = $path[0]."_".$i.".".$path[1];

            return $this->_checkfile($new_path);
        }
        return $path;
    }
    protected function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                        $this->rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                    else
                        unlink($dir. DIRECTORY_SEPARATOR .$object);
                }
            }
            rmdir($dir);
        }
    }
}
