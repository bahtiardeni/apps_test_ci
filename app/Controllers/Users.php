<?php
namespace App\Controllers;
use App\Controllers\GeneralModel;
use App\Controllers\MyController;
use App\Libraries\Filelib;
use App\Libraries\Template;
use App\Libraries\Datatable;
use App\Libraries\Formlib;
use App\Libraries\Utils;
use Config\Validation;
use CodeIgniter\Files\File;
/**
 *
 * Class Users
 *
 * Model
 * @property GeneralModel       $general
 *
 * Library
 * @property Template           $template
 * @property Datatable          $datatable
 * @property Formlib            $formlib
 * @property Filelib            $filelib
 * @property Transaction        $transaction
 * @property Utils              $utils
 *
 */
class Users extends MyController
{
    protected $helpers;

    public function __construct()
    {
        parent::__construct();
        $this->helpers              = ["form", "url"];
        $this->validation           = \Config\Services::validation();
        $this->filelib              = new Filelib();

        $this->datatable->_user     = $this->user;
        $this->datatable->set_initial("data-users");
        $this->rebuild_fields();
        $this->_set_pluggin_library();
    }

    public function index($type = DATATABLE_TYPE_TABLE)
    {
        $filter = !empty($_REQUEST["q"]) ? $_REQUEST["q"] : array();
        if (!empty($filter["filters"]) && !is_array($filter["filters"])){
            $filter["filters"]  = json_decode($filter["filters"], 1);
        }
        $this->template->data["filter"] = !empty($filter["filters"]) ? $filter["filters"] : array();

        $this->template->data["datatable_type"]     = strtoupper($type);
        $this->template->data["title"]              = "DATA USERS";
        $this->template->data["datatable"]          = $this->datatable;
        $this->template->data["formlib"]            = $this->formlib;
        $this->template->_page_id                   = "page-users";
        $this->template->generate("template/datatable/index");
    }
    public function update($hash = "")
    {
        if ($this->request->isAJAX())
        {
            $inputs     = !empty($_REQUEST["input"]) ? $_REQUEST["input"] : "";
            $result     = $this->datatable->update($inputs);
            unset($result["id"]);
            header("Content-Type: application/json");
            echo json_encode($result);
        }
        else
        {
            $hash_id    = $this->encryptlib->decode($hash);

            if (empty($hash_id)){
                $this->template->data["title"]          = "TAMBAH USERS";
            }else{
                $this->template->data["title"]          = "UBAH USERS";
            }

            $this->datatable->generate_form($hash_id);

            $this->template->data["forms"]              = $this->datatable->_forms;
            $this->template->data["url"]                = $this->datatable->_initial->url;
            $this->template->generate("template/datatable/update");
        }
    }
    public function detail($hash = "")
    {
        if ($this->request->isAJAX()){
            $hash   = !empty($_REQUEST["hash"]) ? $_REQUEST["hash"] : "";
        }

        $hash_id   = $this->encryptlib->decode($hash);
        $data      = $this->datatable->get_detail($hash_id, "detail");

        if (!empty($data))
        {
            $this->template->data["hash"]           = $hash;
            $this->template->data["data"]           = $data["data"];
            $this->template->data["title"]          = "DETAIL USERS";
            $this->template->data["url_back"]       = $this->datatable->_initial->url;

            if ($this->request->isAJAX() && ($_SERVER["REQUEST_METHOD"] === "GET"))
            {
                $title      = $this->template->data["title"];
                $content    = view("template/datatable/detail", $this->template->data);
                $footer     = "";

                header("Content-Type: application/json");
                echo json_encode(array(
                    "title"     => $title,
                    "content"   => $content,
                    "footer"    => $footer,
                ));
            }
            else
            {
                $this->template->generate("template/datatable/detail");
            }

        }
        else
        {
            redirect($this->datatable->_initial->url);
        }
    }

    public function export()
    {
        $filter = !empty($_REQUEST["q"]) ? $_REQUEST["q"] : array();

        $this->template->data["sort"]       = !empty($filter["sort"]) ? $filter["sort"] : "";
        $this->template->data["sort_type"]  = !empty($filter["sort_type"]) ? $filter["sort_type"] : "";
        $this->template->data["filter"]     = !empty($filter["s"]) ? $filter["s"] : array();
        $this->template->data["title"]      = "Export Data";
        $this->template->data["datatable"]  = $this->datatable;
        $this->template->data["formlib"]    = $this->formlib;
        $this->template->data["utils"]      = $this->utils;

        $this->template->generate("template/datatable/export");
    }
    public function exports($type)
    {
        $param = $_REQUEST;
        $this->datatable->exports($type, $param);
    }

    // Ajax Request
    public function ajax_data($type = DATATABLE_TYPE_TABLE)
    {
        if ($this->request->isAJAX())
        {
            $type               = !empty($type) ? (strtoupper($type) == DATATABLE_TYPE_TREE ? DATATABLE_TYPE_TREE : DATATABLE_TYPE_TABLE) : DATATABLE_TYPE_TABLE;
            $draw               = !empty($_REQUEST["draw"]) ? $_REQUEST["draw"] : "";
            $columns            = !empty($_REQUEST["columns"]) ? $_REQUEST["columns"] : "";
            $orders             = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : "";
            $start              = !empty($_REQUEST["start"]) ? $_REQUEST["start"] : "";
            $length             = !empty($_REQUEST["length"]) ? $_REQUEST["length"] : "";
            $custom_conditions  = array();

            $param              = array(
                "datatable_type"    => $type,
                "draw"              => $draw,
                "columns"           => $columns,
                "orders"            => $orders,
                "start"             => $start,
                "length"            => $length,
                "conditions"        => $custom_conditions
            );
            $result             = $this->datatable->get($param);
        }
        else
        {
            $result         = array();
        }

        header("Content-Type: application/json");
        echo json_encode($result);
    }
    public function delete()
    {
        if ($this->request->isAJAX())
        {
            $hash   = !empty($_REQUEST["id"]) ? $_REQUEST["id"] : "";
            $result = $this->datatable->delete($hash);

            header("Content-Type: application/json");
            echo json_encode($result);
        }
    }
    public function upload($field = "")
    {
        $result         = RESULT_ERROR;
        $message        = "";
        $validationRule = array();

        // Get Extention
        $image          = $this->request->getFile("file");
        $extention      = $image->getExtension();
        $extention_grp  = $this->filelib->get_type_by_ext($extention);
        $max_size       = 300;

        if ($field == "foto")
        {
            $validationRule = [
                "file" => [
                    "label" => "Image File",
                    "rules" => [
                        'max_size[file,'.$max_size.']',
                        "uploaded[file]",
                        "is_image[file]",
                        "mime_in[file,image/jpg,image/jpeg,image/gif,image/png,image/webp]",
                    ],
                ],
            ];
        }

        $validated  = $this->validate($validationRule);

        if ($validated)
        {
            $image          = $this->request->getFile("file");
            $upload_path    = "public";

            if (! $image->hasMoved())
            {
                $tmp_images     = $image->store();
                $file_source    = "writable/uploads/". $tmp_images;
                $file_target    = $upload_path."/uploads/" . $tmp_images;
                $folder_target  = "";
                $path_array     = explode("/", $file_target);
                $file_name      = "";


                $tmp_path       = "";

                foreach ($path_array as $i => $tmp)
                {
                    if ($i != (count($path_array) - 1))
                    {
                        $tmp_path       .= $tmp."/";
                        $folder_target  .= $tmp."/";
                        if (!file_exists($tmp_path))
                        {
                            mkdir($tmp_path);
                        }
                    }
                    else
                    {
                        $file_name      = $tmp;
                    }
                }

                rename($file_source, $file_target);

                $file_upload    = new File($file_target);

                $directory      = explode("uploads", $file_upload->getPath());
                $directory      = $upload_path."/uploads".$directory[1];
                $file_path      = $directory."/".$image->getName();

                $data_file      = array(
                    "directory"         => $directory,
                    "file_name_ori"     => $image->getClientName(),
                    "file_name"         => $image->getName(),
                    "file_ext"          => $image->getClientExtension(),
                    "file_size"         => $image->getSize()
                );

                $id_file        = $this->general->insert("tbl_files", $data_file);
                $files          = $this->general->get_data("tbl_files", array(
                    "id"    => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $id_file
                    )
                ))->getRow();

                $files->hash        = $this->encryptlib->encode($files->id);
                $files->file_loc    = $file_path;
                $files->content     = $this->filelib->get_view_file($id_file, array(
                    "type"      => DATA_TYPE_FILE_IMAGE_MULTIPLE
                ), FILE_VIEW_FORM);

                $result     = RESULT_SUCCESS;
                $message    = $files;
            };
        }
        else
        {
            $message        = $this->validator->getErrors();

            if (is_array($message))
            {
                $message    = implode("<br>", $message);
            }
        }

        $result     = array(
            "result"        => $result,
            "message"       => $message,
        );

        header("Content-Type: application/json");
        echo json_encode($result);
    }

    public function bulk_push()
    {
        for ($i=1; $i <= 100; $i++)
        {
            $id_divisi      = $this->general->get_data("tbl_divisi", array(), "RAND()")->getRow()->id;
            $id_jabatan     = $this->general->get_data("tbl_jabatan", array(), "RAND()")->getRow()->id;

            $min            = strtotime("1980-01-01");
            $max            = strtotime("2005-12-31");

            // Generate a random timestamp within the range
            $val            = mt_rand($min, $max);

            // Format the timestamp back into a date string
            $date           = date('Y-m-d', $val);

            $jenis_kelamin  = array(
                "Laki-laki", "Perempuan"
            );
            $agama          = array(
                "Islam", "Kristen", "Katolik", "Hindu", "Buddha", "Konghucu"
            );


            $data_pegawai   = array(
                "nip"           => str_pad(($i),8,'0',STR_PAD_LEFT),
                "nama"          => "Pegawai ".$i,
                "tanggal_lahir" => $date,
                "jenis_kelamin" => $jenis_kelamin[array_rand($jenis_kelamin)],
                "agama"         => $agama[array_rand($agama)],
                "status"        => 1,
                "id_divisi"     => $id_divisi,
                "id_jabatan"    => $id_jabatan,
            );

            $this->general->update_dynamic("tbl_pegawai", array(
                "nip"       => array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                    SQL_CONDITION_VALUE     => $data_pegawai["nip"]
                )
            ), $data_pegawai);
        }
    }

    // Other Function
    function rebuild_fields()
    {
    }
    function _set_pluggin_library()
    {
        $plugins_datatable  = $this->datatable->set_library();
        $plugins_formlib    = $this->formlib->set_library();

        foreach ($plugins_datatable as $key => $plugin)
        {
            $this->template->data[$key] = !empty($this->template->data[$key]) ? array_merge($this->template->data[$key], $plugin) : $plugin;
        }
        foreach ($plugins_formlib as $key => $plugin)
        {
            $this->template->data[$key] = !empty($this->template->data[$key]) ? array_merge($this->template->data[$key], $plugin) : $plugin;
        }

    }
}