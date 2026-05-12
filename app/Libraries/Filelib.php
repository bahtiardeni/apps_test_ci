<?php
namespace App\Libraries;
use App\Models\GeneralModel;

/**
 *
 * Class Filelib
 *
 * Library
 * @property Template       $template
 * @property Encryptlib     $encryptlib
 * @property Datatable      $datatable
 * @property General_model  $general
 * @property Utils          $utils
 * @property Fileword       $fileword
 */

class Filelib
{
    public $_dir_file;
    public $_ext_group;
    public $_ext_type;
    public $_cant_deleted;

    // For Cleaner Files
    protected $_files;
    protected $_file_ids;
    protected $_file_name_exist;
    protected $_request_type;
    protected $_modules_table;

    // For Monitoring
    public $_files_list, $_files_tree, $_files_size, $_files_folder;

    function __construct()
    {
        $this->general      = new GeneralModel();
        $this->encryptlib   = new EncryptLib();

        $this->_dir_file    = "public".DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR;

        $this->_ext_group   = array(
            DATA_TYPE_FILE                  => array(
                "jpg"   => array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "jpeg"  => array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "gif"   => array(
                    "color" => "#eb6b05",
                    "icon"  => "fa fa-file-image-o"
                ),
                "bmp"   => array(
                    "color" => "#d21431",
                    "icon"  => "fa fa-file-image-o"
                ),
                "png"   => array(
                    "color" => "#1d599e",
                    "icon"  => "fa fa-file-image-o"
                ),
                "doc"   => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "docx"  => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "ppt"   => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "pptx"  => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "xls"   => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "xlsx"  => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "pdf"   => array(
                    "color" => "#d2132f",
                    "icon"  => "fa fa-file-pdf-o"
                ),
                "mp4"   => array(
                    "color" => "#504589",
                    "icon"  => "fa fa-file-video-o"
                ),
                "wmv"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "3gp"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mpg"   => array(
                    "color" => "#74a740",
                    "icon"  => "fa fa-file-video-o"
                ),
                "avi"   => array(
                    "color" => "#ef690f",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mkv"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                )
            ),
            DATA_TYPE_FILE_ARCHIVE          => array(
                "zip"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                ),
                "rar"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                )
            ),
            DATA_TYPE_FILE_IMAGE            => array(
                "jpg"   => array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "jpeg"  =>  array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "gif"   =>  array(
                    "color" => "#eb6b05",
                    "icon"  => "fa fa-file-image-o"
                ),
                "bmp"   =>  array(
                    "color" => "#d21431",
                    "icon"  => "fa fa-file-image-o"
                ),
                "png"   =>  array(
                    "color" => "#1d599e",
                    "icon"  => "fa fa-file-image-o"
                )
            ),
            DATA_TYPE_FILE_DOC              => array(
                "doc"   => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "docx"  => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "ppt"   => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "pptx"  => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "xls"   => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "xlsx"  => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "pdf"   => array(
                    "color" => "#d2132f",
                    "icon"  => "fa fa-file-pdf-o"
                )
            ),
            DATA_TYPE_FILE_VIDEO            => array(
                "mp4"   => array(
                    "color" => "#504589",
                    "icon"  => "fa fa-file-video-o"
                ),
                "wmv"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "3gp"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mpg"   => array(
                    "color" => "#74a740",
                    "icon"  => "fa fa-file-video-o"
                ),
                "avi"   => array(
                    "color" => "#ef690f",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mkv"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mov"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "ts"    => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                )
            ),
            DATA_TYPE_FILE_AUDIO            => array(
                "mp3"   => array(
                    "color" => "#cb1232",
                    "icon"  => "fa fa-file-sound-o"
                )
            ),

            DATA_TYPE_FILE_MULTIPLE         => array(
                "zip"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                ),
                "rar"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                ),
                "jpg"   => array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "jpeg"  => array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "gif"   => array(
                    "color" => "#eb6b05",
                    "icon"  => "fa fa-file-image-o"
                ),
                "bmp"   => array(
                    "color" => "#d21431",
                    "icon"  => "fa fa-file-image-o"
                ),
                "png"   => array(
                    "color" => "#1d599e",
                    "icon"  => "fa fa-file-image-o"
                ),
                "doc"   => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "docx"  => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "ppt"   => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "pptx"  => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "xls"   => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "xlsx"  => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "pdf"   => array(
                    "color" => "#d2132f",
                    "icon"  => "fa fa-file-pdf-o"
                ),
                "mp4"   => array(
                    "color" => "#504589",
                    "icon"  => "fa fa-file-video-o"
                ),
                "wmv"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "3gp"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mpg"   => array(
                    "color" => "#74a740",
                    "icon"  => "fa fa-file-video-o"
                ),
                "avi"   => array(
                    "color" => "#ef690f",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mkv"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mp3"   => array(
                    "color" => "#cb1232",
                    "icon"  => "fa fa-file-sound-o"
                ),

                "stl"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file"
                ),
            ),
            DATA_TYPE_FILE_ARCHIVE_MULTIPLE => array(
                "zip"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                ),
                "rar"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                )
            ),
            DATA_TYPE_FILE_IMAGE_MULTIPLE   => array(
                "jpg"   => array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "jpeg"  =>  array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "gif"   =>  array(
                    "color" => "#eb6b05",
                    "icon"  => "fa fa-file-image-o"
                ),
                "bmp"   =>  array(
                    "color" => "#d21431",
                    "icon"  => "fa fa-file-image-o"
                ),
                "png"   =>  array(
                    "color" => "#1d599e",
                    "icon"  => "fa fa-file-image-o"
                )
            ),
            DATA_TYPE_FILE_DOC_MULTIPLE     => array(
                "doc"   => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "docx"  => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "ppt"   => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "pptx"  => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "xls"   => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "xlsx"  => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "pdf"   => array(
                    "color" => "#d2132f",
                    "icon"  => "fa fa-file-pdf-o"
                )
            ),
            DATA_TYPE_FILE_VIDEO_MULTIPLE   => array(
                "mp4"   => array(
                    "color" => "#504589",
                    "icon"  => "fa fa-file-video-o"
                ),
                "wmv"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "3gp"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mpg"   => array(
                    "color" => "#74a740",
                    "icon"  => "fa fa-file-video-o"
                ),
                "avi"   => array(
                    "color" => "#ef690f",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mkv"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mov"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "ts"    => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                )
            ),
            DATA_TYPE_FILE_AUDIO_MULTIPLE   => array(
                "mp3"   => array(
                    "color" => "#cb1232",
                    "icon"  => "fa fa-file-sound-o"
                )
            ),

            DATA_TYPE_FILE_3D               => array(
                "stl"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file"
                ),
            )
        );
        $this->_ext_type    = array(
            DATA_TYPE_FILE_ARCHIVE          => array(
                "zip"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                ),
                "rar"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                )
            ),
            DATA_TYPE_FILE_IMAGE            => array(
                "jpg"   => array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "jpeg"  =>  array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "gif"   =>  array(
                    "color" => "#eb6b05",
                    "icon"  => "fa fa-file-image-o"
                ),
                "bmp"   =>  array(
                    "color" => "#d21431",
                    "icon"  => "fa fa-file-image-o"
                ),
                "png"   =>  array(
                    "color" => "#1d599e",
                    "icon"  => "fa fa-file-image-o"
                )
            ),
            DATA_TYPE_FILE_DOC              => array(
                "doc"   => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "docx"  => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "ppt"   => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "pptx"  => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "xls"   => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "xlsx"  => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "pdf"   => array(
                    "color" => "#d2132f",
                    "icon"  => "fa fa-file-pdf-o"
                )
            ),
            DATA_TYPE_FILE_VIDEO            => array(
                "mp4"   => array(
                    "color" => "#504589",
                    "icon"  => "fa fa-file-video-o"
                ),
                "wmv"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "3gp"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mpg"   => array(
                    "color" => "#74a740",
                    "icon"  => "fa fa-file-video-o"
                ),
                "avi"   => array(
                    "color" => "#ef690f",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mkv"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mov"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "ts"    => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                )
            ),
            DATA_TYPE_FILE_AUDIO            => array(
                "mp3"   => array(
                    "color" => "#cb1232",
                    "icon"  => "fa fa-file-sound-o"
                )
            ),

            DATA_TYPE_FILE_ARCHIVE_MULTIPLE => array(
                "zip"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                ),
                "rar"   => array(
                    "color" => "#dc3545",
                    "icon"  => "fa fa-file-zip-o"
                )
            ),
            DATA_TYPE_FILE_IMAGE_MULTIPLE   => array(
                "jpg"   => array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "jpeg"  =>  array(
                    "color" => "#509117",
                    "icon"  => "fa fa-file-image-o"
                ),
                "gif"   =>  array(
                    "color" => "#eb6b05",
                    "icon"  => "fa fa-file-image-o"
                ),
                "bmp"   =>  array(
                    "color" => "#d21431",
                    "icon"  => "fa fa-file-image-o"
                ),
                "png"   =>  array(
                    "color" => "#1d599e",
                    "icon"  => "fa fa-file-image-o"
                )
            ),
            DATA_TYPE_FILE_DOC_MULTIPLE     => array(
                "doc"   => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "docx"  => array(
                    "color" => "#2359a9",
                    "icon"  => "fa fa-file-word-o"
                ),
                "ppt"   => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "pptx"  => array(
                    "color" => "#e76d07",
                    "icon"  => "fa fa-file-powerpoint-o"
                ),
                "xls"   => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "xlsx"  => array(
                    "color" => "#4c9215",
                    "icon"  => "fa fa-file-excel-o"
                ),
                "pdf"   => array(
                    "color" => "#d2132f",
                    "icon"  => "fa fa-file-pdf-o"
                )
            ),
            DATA_TYPE_FILE_VIDEO_MULTIPLE   => array(
                "mp4"   => array(
                    "color" => "#504589",
                    "icon"  => "fa fa-file-video-o"
                ),
                "wmv"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "3gp"   => array(
                    "color" => "#2654a3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mpg"   => array(
                    "color" => "#74a740",
                    "icon"  => "fa fa-file-video-o"
                ),
                "avi"   => array(
                    "color" => "#ef690f",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mkv"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "mov"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                ),
                "ts"    => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file-video-o"
                )
            ),
            DATA_TYPE_FILE_AUDIO_MULTIPLE   => array(
                "mp3"   => array(
                    "color" => "#cb1232",
                    "icon"  => "fa fa-file-sound-o"
                )
            ),

            DATA_TYPE_FILE_3D               => array(
                "stl"   => array(
                    "color" => "#2456b3",
                    "icon"  => "fa fa-file"
                ),
            )
        );

        $this->_cant_deleted    = array(
            "index.html",
            "bawana.json",
            "cors.json",
            "talenta_employee.json",
            "loader.gif",
            "logo.gif",
            "default.jpg",
        );
        $this->_request_type    = php_sapi_name();
        $this->_modules_table   = array(
            "lms_"          => "JAKLEARN",
            "services_"     => "KAMBAN",
            "plan_"         => "PLANB",
            "recruitment_"  => "RECRUITMENT",
            "peduli_"       => "PEDULI",
            "__erecom_"     => "E-REKOMENDASI",
            "arsip_"        => "ARSIP"
        );
    }

    function get_by_id($id_file)
    {
        $result = $this->general->get_data("tbl_files", array(
            "id" => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $id_file
            )
        ))->getRow();

        if (!empty($result))
        {
            $result->hash       = $this->encryptlib->encode($result->id);
            $file_group         = $this->get_type_by_ext($result->file_ext);
            $result->file_group = $file_group;

            if (!empty($result->directory))
            {
                $result->file_loc   = $result->directory."/".$result->file_name;
            }
            else
            {
                $result->file_loc   = $this->_dir_file.$result->file_name;
            }

            if (file_exists($result->file_loc)){
                $result->file_exist = true;
            } else {
                $result->file_exist = false;
            }

            $result->meta       = json_decode($result->meta);

            if (!empty($result->meta))
            {
                foreach ($result->meta as $key => $value)
                {
                    $result->$key   = $value;
                }
            }

            $result->meta       = (array) $result->meta;
            $result->type       = !empty($result->meta["field-type"]) ? $result->meta["field-type"] : "";

            return $result;
        }

        return false;
    }
    function get_by_name($file_name)
    {
        $result = $this->general->get_data("tbl_files", array(
            "file_name" => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $file_name
            )
        ))->row();

        if (!empty($result))
        {
            $result->hash       = $this->encryptlib->encode($result->id);


            if (!empty($result->directory))
            {
                $result->file_loc   = $result->directory.$result->file_name;
            }
            else
            {
                $result->file_loc   = $this->_dir_file.$result->file_name;
            }

            if (file_exists($result->file_loc)){
                $result->file_exist = true;
            } else {
                $result->file_exist = false;
            }

            $result->meta       = json_decode($result->meta);

            if (!empty($result->meta))
            {
                foreach ($result->meta as $key => $value)
                {
                    $result->$key   = $value;
                }
            }

            $result->meta   = (array) $result->meta;
            $result->type   = !empty($result->meta["field-type"]) ? $result->meta["field-type"] : "";

            return $result;
        }

        return false;
    }
    function get_by_meta($meta_table, $meta_field, $meta_id, $file_id)
    {
        $meta_data  = $this->general->get_data($meta_table, array(
            $meta_field => $meta_id
        ))->result();
        $result     = array();
        foreach ($meta_data as $meta)
        {
            $result[]   = $this->get_by_id($meta->$file_id);
        }

        return $result;
    }
    function get_file_content($path)
    {
        $finfo      = new \finfo(FILEINFO_MIME);

        if (file_exists($path))
        {

            $type       = $finfo->file($path);
            $mime       = mime_content_type($path);

            $imageData  = base64_encode(file_get_contents($path));

// Format the image SRC:  data:{mime};base64,{data};
            $src = 'data: '.$type.';base64,'.$imageData;

            return $src;
        }

        return false;
    }

    function delete_by_meta($meta_table, $meta_field, $meta_id, $file_id)
    {
        $meta_data  = $this->general->get_data($meta_table, array(
            $meta_field => $meta_id
        ))->result();

        foreach ($meta_data as $meta)
        {
            $id_file    = $meta->$file_id;
            $this->delete_by_id($id_file);

            $this->general->delete($meta_table, array(
                "id" => $meta->id
            ));
        }

        return true;
    }
    function delete_by_id($id)
    {
        $condition  = array(
            "id" => $id
        );
        $file       = $this->general->get_data("tbl_files", $condition)->row();
        $path       = FCPATH.$file->file_loc;

        // Delete File
        if (file_exists($path)){
            unlink($path);
        }
        $this->general->delete("tbl_files", $condition);
    }

    function get_ext_by_type($type)
    {
        $result = array();

        foreach ($this->_ext_group[$type] as $ext => $color)
        {
            $result[]   = $ext;
        }

        return $result;
    }
    function get_type_by_ext($ext)
    {
        foreach ($this->_ext_type as $type => $group)
        {
            if (array_key_exists(strtolower($ext), $group)) return $type;
        }

    }

    function get_view_file($ids = "", $field = array(), $for = FILE_VIEW_TABLE, $downloaded = true)
    {
        if (!is_array($ids))
        {
            $ids    = array($ids);
        }

        $content    = "";
        $field      = (array) $field;
        $ids        = array_filter($ids);
        $new_ids    = array();

        foreach ($ids as $id)
        {
            if ($id != "Nan"){
                $new_ids[]  = $id;
            }
        }
        $ids    = $new_ids;

        if (!empty($ids))
        {
            if ($for == FILE_VIEW_TABLE && !empty($field["type"]) && in_array($field["type"], array(
                    DATA_TYPE_FILE_MULTIPLE,
                    DATA_TYPE_FILE_MULTIPLE,
                    DATA_TYPE_FILE_AUDIO_MULTIPLE,
                    DATA_TYPE_FILE_VIDEO_MULTIPLE,
                    DATA_TYPE_FILE_DOC_MULTIPLE,
                    DATA_TYPE_FILE_IMAGE_MULTIPLE,
                    DATA_TYPE_FILE_ARCHIVE_MULTIPLE
                )))
            {
                $content    = "<button type='button' class='btn btn-xs btn-mini btn-info btn-file-view btn-datatable btn-block' data-type='".$field["type"]."' data-id='".implode(",", $ids)."'><i class='fa fa-search'></i> View</button>";
            }
            else if ($for == FILE_VIEW_LIST)
            {
                $tab_head       = "";
                $tab_content    = "";
                $i              = 0;

                if (count($ids) > 1)
                {

                    foreach ($ids as $id)
                    {
                        if ($field["type"] == DATA_TYPE_FILE_LINK)
                        {
                            $ext        = pathinfo($id, PATHINFO_EXTENSION);
                            $ext        = $this->_ext_group[DATA_TYPE_FILE_MULTIPLE][strtolower($ext)];

                            $tab_head       .= "<li class='".($i == 0 ? "active" : "")."'><a data-toggle='tab' href='#tab-file-".$id."' aria-expanded='true'><i class='".$ext["icon"]."' style='color: ".$ext["color"]."'></i>&nbsp;&nbsp;<span class='font-size-10 font-normal'>".$id."</span></a>";
                            $tab_content    .= "<div id='tab-file-".$id."' class='tab-pane ".($i == 0 ? "active" : "")."'>";
                            $tab_content    .= "<div class='panel-body no-border'>";

                            $tab_content    .= $this->generate_view_file_link($id, $field, $downloaded);

                            $tab_content    .= "</div>";
                            $tab_content    .= "</div>";
                        }
                        else
                        {
                            $file       = $this->get_by_id($id);

                            if (!empty($file))
                            {
                                $ext        = $this->_ext_group[$field["type"]][strtolower($file->file_ext)];

                                $tab_head       .= "<li class='".($i == 0 ? "active" : "")."'><a data-toggle='tab' href='#tab-file-".$id."' aria-expanded='true'><i class='".$ext["icon"]."' style='color: ".$ext["color"]."'></i>&nbsp;&nbsp;<span class='font-size-10 font-normal'>".$file->file_name_ori."</span></a>";
                                $tab_content    .= "<div id='tab-file-".$id."' class='tab-pane ".($i == 0 ? "active" : "")."'>";
                                $tab_content    .= "<div class='panel-body no-border'>";

                                $tab_content    .= $this->generate_view($file, $field, $for, $downloaded);

                                $tab_content    .= "</div>";
                                $tab_content    .= "</div>";


                                $i++;
                            }
                        }
                    }

                    $content    = "<div class='hpanel'>";
                    $content    .= "<ul class='nav nav-tabs'>";
                    $content    .= $tab_head;
                    $content    .= "</ul>";
                    $content    .= "<div class='tab-content'>";
                    $content    .= $tab_content;
                    $content    .= "</div>";
                    $content    .= "</div>";
                }
                else
                {

                    $file       = $this->get_by_id($ids[0]);
                    $content    .= $this->generate_view($file, $field, $for, $downloaded);
                }


            }
            else
            {
                foreach ($ids as $id)
                {
                    $file       = $this->get_by_id($id);

                    if (!empty($file))
                    {
                        $content    .= $this->generate_view($file, $field, $for, $downloaded);
                    }
                }
            }
        }

        return $content;
    }
    function generate_view($file, $field = array(), $for = FILE_VIEW_LIST, $downloaded = true)
    {
        $type       = "";
        $content    = "";

        if (!empty($field["type"]))
        {
            $type   = $field["type"];
        }
        else
        {
            if (!empty($file->type))
            {
                $type   = $file->type;
            }
        }

        if (!empty($type))
        {
            $ext        = !empty($this->_ext_group[$type][strtolower($file->file_ext)]) ? $this->_ext_group[$type][strtolower($file->file_ext)] : "";

            if ($for == FILE_VIEW_TABLE)
            {
                if ($type == DATA_TYPE_FILE_IMAGE)
                {
                    $content    = "<img src='".base_url($file->file_loc)."' style='height: 15px;' class='btn-file-view cursor-pointer' data-type='".$field["type"]."' data-id='".$file->id."'>";
                }
                else
                {
                    $content     = "<button type='button' class='btn btn-xs btn-mini btn-info btn-file-view btn-datatable btn-block' data-type='".$field["type"]."' data-id='".$file->id."'><i class='fa fa-search'></i> View</button>";
                }
            }
            else if ($for == FILE_VIEW_FORM)
            {
                $content    .= "<div class='file-item' data-id='".$file->id."'>";
                $content    .= "<div class='row'>";
                $content    .= "<div class='col-lg-8 col-sm-8 col-xs-8' style='word-wrap: break-word;'>";
                $content    .= "<a href='javascript:void(0);' class='btn-file-view' data-type='".$field["type"]."' data-id='".$file->id."'><i class='".(!empty($ext["icon"]) ? $ext["icon"] : "")."' style='color: ".(!empty($ext["color"]) ? $ext["color"] : "")."'></i>&nbsp;&nbsp;".$file->file_name_ori."</a>";
                $content    .= "</div>";
                $content    .= "<div class='col-lg-4 col-sm-4 col-xs-4 text-right'>";
                $content    .= "<div class='btn-group'>";

                if ($downloaded){
                    $content    .= "<a href='".base_url("file/download/".$this->encryptlib->encode($file->id))."' class='btn btn-xs btn-mini btn-default' data-hash='".$this->encryptlib->encode($file->id)."' ><span class='fa fa-download'></span></a>";
                }

                $content    .= "<button type='button' class='btn btn-xs btn-mini btn-default btn-file-view' data-type='".$field["type"]."' data-id='".$file->id."' ><span class='fa fa-search-plus'></span></button>";
                $content    .= "<button type='button' class='btn btn-xs btn-mini btn-default btn-file-delete' data-id='".$file->id."' ><span class='fa fa-trash'></span></button>";

                $content    .= "</div>";

                $content    .= "</div>";
                $content    .= "</div>";
                $content    .= "</div>";
            }
            else if ($for == FILE_VIEW_LIST)
            {
                $content    = $this->generate_view_file($file, $field, $downloaded);
            }
            else if ($for == FILE_VIEW_DETAIL)
            {
                $content    = $this->generate_view_file($file, $field, $downloaded);
            }
            else if ($for == FILE_VIEW_LIST_READONLY)
            {
                $content    = $this->generate_view_file($file, $field, $downloaded);
            }
            else if ($for == FILE_VIEW_HEADER)
            {
                if ($this->agent->is_mobile())
                {

                }
                else
                {
                    $content    .= "<div class='file-item' data-id='".$file->id."' style='border-bottom: 1px solid #ccc; padding: 2px; margin-bottom: 5px; '>";
                    $content    .= "<div class='row'>";
                    $content    .= "<div class='col-lg-8 col-sm-8 col-xs-8' style='word-wrap: break-word;'>";
                    $content    .= "<a href='javascript:void(0);' class='btn-file-view' data-type='".$field["type"]."' data-id='".$file->id."'><i class='".(!empty($ext["icon"]) ? $ext["icon"] : "")."' style='color: ".(!empty($ext["color"]) ? $ext["color"] : "")."'></i>&nbsp;&nbsp;".$file->file_name_ori."</a>";
                    $content    .= "</div>";
                    $content    .= "<div class='col-lg-4 col-sm-4 col-xs-4 text-right'>";
                    $content    .= "<div class='btn-group'>";

                    if ($downloaded){
                        $content    .= "<a href='".base_url("file/download/".$this->encryptlib->encode($file->id))."' class='btn btn-xs btn-mini btn-default' data-hash='".$this->encryptlib->encode($file->id)."' ><span class='fa fa-download'></span></a>";
                    }

                    $content    .= "<button type='button' class='btn btn-xs btn-mini btn-default btn-file-view' data-type='".$field["type"]."' data-id='".$file->id."' ><span class='fa fa-search-plus'></span></button>";

                    $content    .= "</div>";

                    $content    .= "</div>";
                    $content    .= "</div>";
                    $content    .= "</div>";
                }
            }
        }



        return $content;
    }

    protected function generate_view_file($file, $field, $downloaded = true)
    {
        $content    = "";
        $ext        = $this->_ext_group[$field["type"]][strtolower($file->file_ext)];

        if ($field["type"] == DATA_TYPE_FILE_IMAGE_MULTIPLE || $field["type"] == DATA_TYPE_FILE_IMAGE)
        {
            $content    .= $this->generate_view_file_ext_images($file, $downloaded);
        }
        else if ($field["type"] == DATA_TYPE_FILE_VIDEO_MULTIPLE || $field["type"] == DATA_TYPE_FILE_VIDEO)
        {
            $content    .= $this->generate_view_file_ext_videos($file, $downloaded);
        }
        else if ($field["type"] == DATA_TYPE_FILE_AUDIO_MULTIPLE || $field["type"] == DATA_TYPE_FILE_AUDIO)
        {
            $content    .= $this->generate_view_file_ext_audios($file, $downloaded);
        }
        else if ($field["type"] == DATA_TYPE_FILE_DOC_MULTIPLE || $field["type"] == DATA_TYPE_FILE_DOC)
        {
            $content    .= $this->generate_view_file_ext_documents($file, $downloaded);
        }
        else if ($field["type"] == DATA_TYPE_FILE_MULTIPLE || $field["type"] == DATA_TYPE_FILE)
        {
            if (array_key_exists(strtolower($file->file_ext), $this->_ext_group[DATA_TYPE_FILE_IMAGE]))
            {
                $content    .= $this->generate_view_file_ext_images($file, $downloaded);
            }
            else if (array_key_exists(strtolower($file->file_ext), $this->_ext_group[DATA_TYPE_FILE_DOC]))
            {
                $content    .= $this->generate_view_file_ext_documents($file, $downloaded);
            }
            else if (array_key_exists(strtolower($file->file_ext), $this->_ext_group[DATA_TYPE_FILE_VIDEO]))
            {
                $content    .= $this->generate_view_file_ext_videos($file, $downloaded);
            }

            else if (array_key_exists($file->file_ext,  $this->_ext_group[DATA_TYPE_FILE_3D]))
            {
                $content    .= "<div class='files_3d_view mb-10' id='file-".$file->id."' data-file='".base_url($file->file_loc)."' style='width: 100%; height: 500px;'></div>";

                if ($downloaded){
                    $content    .= "<a href='".base_url("file/download/".$this->encryptlib->encode($file->id))."' class='btn btn-info btn-sm btn-small mb-10'><i class='fa fa-download'></i>&nbsp;Download File</a>";
                }
            }
        }
        else
        {
            $content    .= "<h3 class='text-center mb-20'>The file cannot be previewed.</h3>";

            if ($downloaded) {
                $content .= "<a href='" . base_url("file/download/" . $this->encryptlib->encode($file->id)) . "' class='btn btn-info btn-sm btn-small mt-20'><i class='fa fa-download'></i>&nbsp;Download File</a>";
            }
        }

        return $content;

    }
    protected function generate_view_file_link($file, $field, $downloaded = true)
    {
        $content    = "";
        $ext        = pathinfo($file, PATHINFO_EXTENSION);
        $ext        = $this->_ext_group[DATA_TYPE_FILE_MULTIPLE][strtolower($ext)];

        if (in_array($ext, $this->_ext_group[DATA_TYPE_FILE_IMAGE]))
        {
            $content    .= "<div class='row'>";
            $content    .= "<div class='col-lg-12 text-danger'>";
            $content    .= "<div class='text-center pd-10'>";
            $content    .= "<img src='".$file."' style='width:50%'>";
            $content    .= "</div>";

            if ($downloaded){
                $content    .= "<a href='".$file."' class='btn btn-info btn-sm btn-small mb-10'><i class='fa fa-download'></i>&nbsp;Download File</a>";
            }

            $content    .= "</div>";
            $content    .= "</div>";
        }
        else if (in_array($ext, $this->_ext_group[DATA_TYPE_FILE_VIDEO]))
        {
            $content    .= "<div class='row'>";
            $content    .= "<div class='col-lg-12 text-danger'>";
            $content    .= "<div class='text-center pd-10'>";
            $content    .= "<video width='100%' controls>";
            $content    .= "<source src='".$file."' type='video/mp4'><source src='mov_bbb.ogg' type='video/ogg'>";
            $content    .= "</video>";
            $content    .= "</div>";

            if ($downloaded){
                $content    .= "<a href='".$file."' class='btn btn-info btn-sm btn-small mb-10'><i class='fa fa-download'></i>&nbsp;Download File</a>";
            }
            $content    .= "</div>";
            $content    .= "</div>";
        }
        else if (in_array($ext, $this->_ext_group[DATA_TYPE_FILE_AUDIO]))
        {
            $content    .= "<div class='row'>";
            $content    .= "<div class='col-lg-12 text-danger'>";
            $content    .= "<div class='text-center pd-10'>";
            $content    .= "<source src='horse.ogg' type='audio/ogg'><source src='".$file."' type='audio/mpeg'>";
            $content    .= "</audio>";
            $content    .= "</div>";

            if ($downloaded){
                $content    .= "<a href='".$file."' class='btn btn-info btn-sm btn-small mb-10'><i class='fa fa-download'></i>&nbsp;Download File</a>";
            }
            $content    .= "</div>";
            $content    .= "</div>";
        }
        else if (in_array($ext, $this->_ext_group[DATA_TYPE_FILE_DOC]))
        {
            $content    .= "<div class='row'>";
            $content    .= "<div class='col-lg-12 text-danger'>";
            $content    .= "<iframe src='https://docs.google.com/gview?url=".$file."&embedded=true' style='width: 100%; height: 400px; margin-bottom: 10px;'></iframe>";

            if ($downloaded){
                $content    .= "<a href='".$file."' class='btn btn-info btn-sm btn-small mb-10'><i class='fa fa-download'></i>&nbsp;Download File</a>";
            }
            $content    .= "</div>";
            $content    .= "</div>";
        }
        else
        {
            $content    .= "<div class='row'>";
            $content    .= "<div class='col-lg-12 text-danger'>";
            $content    .= "<h3 class='text-center mb-20'>The file cannot be previewed.</h3>";

            if ($downloaded){
                $content    .= "<a href='".$file."' class='btn btn-info btn-sm btn-small mb-10'><i class='fa fa-download'></i>&nbsp;Download File</a>";
            }
            $content    .= "</div>";
            $content    .= "</div>";
        }



        return $content;

    }

    protected function generate_view_file_ext_images($file, $downloaded = true)
    {
        $content    = "";

        $content    .= "<img src='".base_url($file->file_loc)."' style='width:100%;'>";

        if ($downloaded) {
            $content .= "<a href='" . base_url("file/download/" . $this->encryptlib->encode($file->id)) . "' class='btn btn-info btn-sm btn-small mt-20'><i class='fa fa-download'></i>&nbsp;Download File</a>";
        }

        return $content;
    }
    protected function generate_view_file_ext_videos($file, $downloaded = true)
    {
        $content    = "";

        $content    .= "<video width='100%' id='video-".$file->id."' controls>";
        $content    .= "<source src='".base_url($file->file_loc)."' type='video/mp4'><source src='mov_bbb.ogg' type='video/ogg'>";
        $content    .= "</video>";

        if ($downloaded) {
            $content .= "<a href='" . base_url("file/download/" . $this->encryptlib->encode($file->id)) . "' class='btn btn-info btn-sm btn-small mt-20'><i class='fa fa-download'></i>&nbsp;Download File</a>";
        }

        return $content;
    }
    protected function generate_view_file_ext_audios($file, $downloaded = true)
    {
        $content    = "";

        $content    .= "<div class='row'>";
        $content    .= "<div class='col-lg-12 text-danger'>";
        $content    .= "<div class='text-center pd-10'>";
        $content    .= "<source src='horse.ogg' type='audio/ogg'><source src='".base_url($file->file_loc)."' type='audio/mpeg'>";
        $content    .= "</audio>";
        $content    .= "</div>";

        if ($downloaded) {
            $content .= "<a href='" . base_url("file/download/" . $this->encryptlib->encode($file->id)) . "' class='btn btn-info btn-sm btn-small mt-20'><i class='fa fa-download'></i>&nbsp;Download File</a>";
        }

        $content    .= "</div>";
        $content    .= "</div>";

        return $content;
    }
    protected function generate_view_file_ext_documents($file, $downloaded = true)
    {
        $content    = "";

        /*if ($file->file_ext != "pdf")
        {
            $convert    = false;

            if (!empty($file->file_tmp))
            {
                if (!file_exists($file->file_tmp))
                {
                    $convert    = true;
                }
            }
            else
            {
                $convert    = true;
            }

            if ($convert)
            {

                if ($file->file_ext == "doc" || $file->file_ext == "docx"){
                    $file_location  = $this->__convert_doc_pdf($file->file_loc);
                } else if ($file->file_ext == "xls" || $file->file_ext == "xlsx"){
                    $file_location  = $this->__convert_xls_pdf($file->file_loc);
                } else if ($file->file_ext == "ppt" || $file->file_ext == "pptx"){
                    $file_location  = $this->__convert_ppt_pdf($file->file_loc);
                }

                $this->general->update("tbl_files", array(
                    "id"    => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $file->id
                    )
                ), array(
                    "file_tmp"  => $file_location
                ));
            }
            else
            {
                $file_location      = $file->file_tmp;
            }


            $file_location  = base_url($file_location);
        }
        else
        {
            $file_location  = base_url($file->file_loc);
        }*/

        $file_location  = base_url($file->file_loc);
        $file_location  = $this->__generate_document_viewer($file_location);

        $content    .= "<iframe src='".$file_location."#toolbar=0' width='100%' height='700px'>";
        $content    .= "</iframe>";

        if ($downloaded) {
            $content .= "<a href='" . base_url("file/download/" . $this->encryptlib->encode($file->id)) . "' class='btn btn-info btn-sm btn-small mt-10'><i class='fa fa-download mr-5'></i>Download File</a>";
        }

        return $content;
    }

    protected function __convert_doc_pdf($file_location)
    {
        return $this->fileword->convert_to_pdf($file_location);
    }
    protected function __convert_xls_pdf($file_location)
    {
        return $this->fileword->convert_to_pdf($file_location);
    }
    protected function __convert_ppt_pdf($file_location)
    {

        // Set PDF renderer.
        // Make sure you have `tecnickcom/tcpdf` in your composer dependencies.
        Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
        // Path to directory with tcpdf.php file.
        // Rigth now `TCPDF` writer is depreacted. Consider to use `DomPDF` or `MPDF` instead.
        Settings::setPdfRendererPath('vendor/tecnickcom/tcpdf');

        $new_dir        = "public".DIRECTORY_SEPARATOR."tmp".DIRECTORY_SEPARATOR;
        $new_filename   = $this->utils->get_random_string("50").".pdf";

        $phpOffice = IOFactory::load($file_location, 'Word2007');
        $phpOffice->save($new_dir.$new_filename, 'PDF');

        return $new_dir.$new_filename;
    }

    protected function __generate_document_viewer($url_file = "", $lib = "google")
    {
        $result     = "";

        if ($lib == "google")
        {
            $result     = "https://docs.google.com/viewer?url=".$url_file."&embedded=true&enablejsapi=1";
        }

        return $result;
    }

    // MANAGE FILES (Scanning, Cleaner, Refoldering)
    public function scan_files($all_files = false, $check_exist = true, $check_used = true)
    {
        ini_set('memory_limit', '-1');

        if ($check_used)
        {
            if ($this->_request_type == "cli"){
                echo date("Y-m-d H:i:s")." => Checking Files Used..........................".PHP_EOL;
            }

            $this->files_config();
            $this->files_master();
            $this->files_table();

            $ids_files_used     = $this->_file_ids;
        }

        $condition  = array();

        if ($all_files === false)
        {
            $condition  = array(
                "id"    => array(
                    SQL_CONDITION_OPERATOR  => SQL_CONDITION_QUERY,
                    SQL_CONDITION_VALUE     => " (file_exist IS NULL OR file_used IS NULL) "
                )
            );
        }

        $files      = $this->general->get_data("tbl_files", $condition, null, null, null, null, array(
            "id",
            "file_name",
            "directory",
            "created",
        ))->result();

        if (!empty($files))
        {
            foreach ($files as $i => $file)
            {
                $path       = $file->directory.$file->file_name;
                $data       = array();
                $log_msg    = date("Y-m-d H:i:s")." => ".($i + 1).". ".$file->file_name;

                if ($check_exist)
                {
                    if (file_exists($path))
                    {
                        $data["file_exist"]     = 1;
                        $log_msg                .= " [FILE EXIST]";


                        $file_size              = filesize($path);
                        $file_created           = date("Y-m-d H:i:s", filemtime($path));
                        $file_size              = !empty($file_size) ? ($file_size/ 1024) : $file_size;

                        if (!empty($file_size))
                        {
                            $data["file_size"]      = $file_size;
                        }
                        if (!empty($file_created))
                        {
                            $data["created_tmp"]    = $file_created;
                        }
                    }
                    else
                    {
                        $data["file_exist"]     = 0;
                        $log_msg                .= " [FILE NOT FOUND]";
                    }
                }
                if ($check_used)
                {
                    if (!empty($ids_files_used) && array_key_exists($file->id, $ids_files_used))
                    {
                        $data["modules_name"]   = $ids_files_used[$file->id]["module"];
                        $data["modules_table"]  = $ids_files_used[$file->id]["table"];
                        $data["file_used"]      = 1;
                        $log_msg                .= " [FILE USED] [".$ids_files_used[$file->id]["module"]."] [".$ids_files_used[$file->id]["table"]."]";
                    }
                    else
                    {
                        $data["modules_name"]   = null;
                        $data["modules_table"]  = null;
                        $data["file_used"]      = 0;
                        $log_msg                .= " [FILE NOT USED]";
                    }
                }


                $log_msg    .= PHP_EOL;

                $this->general->update("tbl_files", array(
                    "id"     => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $file->id
                    )
                ), $data);

                if ($this->_request_type == "cli"){
                    echo $log_msg;
                }

            }
        }
        else
        {
            if ($this->_request_type == "cli"){
                echo date("Y-m-d H:i:s")." => Files Not found..........................".PHP_EOL;
            }
        }

    }
    public function clean_files($start_date = "", $end_date = "")
    {
        ini_set('memory_limit', '-1');
        $conditions     = array(
            "file_used"     => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => 0
            )
        );

        if (!empty($start_date) && !empty($end_date))
        {
            $conditions["created"]      = array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_BETWEEN,
                SQL_CONDITION_VALUE     => array(
                    $start_date." 00:00:00",
                    $end_date." 23:59:59",
                )
            );
        }

        $files          = $this->general->get_data("tbl_files", $conditions)->result();
        $ids_delete     = array();


        if (php_sapi_name() == "cli"){
            echo date("Y-m-d H:i:s")." => ".count($files)." FILES FOUND..........................".PHP_EOL;
        }

        foreach ($files as $i => $file)
        {
            $file_path      = $file->directory.DIRECTORY_SEPARATOR.$file->file_name;

            if (!empty($file->file_exist) && file_exists($file_path)) {
                unlink($file_path);
            }

            if ($this->_request_type == "cli"){
                echo date("Y-m-d H:i:s")." => ".($i + 1)." DELETING ".$file_path." ..........................".PHP_EOL;
            }

            $ids_delete[]   = $file->id;

            if (count($ids_delete) === 1000 || count($files) === ($i + 1))
            {
                if (!empty($ids_delete)){
                    $this->general->delete("tbl_files", array(
                        "id"        => array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_IN,
                            SQL_CONDITION_VALUE     => $ids_delete
                        )
                    ));
                    $ids_delete     = array();
                }

            }

        }
    }
    public function scan_storage($dir = "public/files")
    {
        $result     = $this->get_files($dir);

        echo "<pre>";
        print_r($result);
        echo "</pre>";
        die;
    }

    public function files_config()
    {
        $fiels_name     = array(
            "__lms-banner_trending",
            "__lms-thumbnail_default",
            "__lms-template_certificate",
            "__lms-banner",
        );
        $configs        = $this->general->get_data("__sys_config")->result();
        $id_files       = array();

        foreach ($configs as $config)
        {
            $tmp_value  = @json_decode($config->value, true);

            if ($tmp_value === null && json_last_error() !== JSON_ERROR_NONE) {
                $values     = $config->value;
            } else {
                $values     = $tmp_value;
            }

            if (is_array($values))
            {
                foreach ($values as $tmp_field => $tmp_value)
                {
                    if (!is_array($tmp_value))
                    {
                        if (in_array($tmp_field, $fiels_name))
                        {
                            $id_files[]    = $tmp_value;
                        }
                    }
                }
            }
            else
            {
                if (in_array($config->name, $fiels_name))
                {
                    $id_files[]    = $values;
                }
            }

        }

        $tmp_value  = array();
        foreach ($id_files as $value)
        {
            $value      = explode(",", $value);

            foreach ($value as $item){
                if (!empty((int) $item)){
                    $tmp_value[]    = (int) $item;
                }
            }
        }

        if (!empty($this->_file_ids))
        {
            $this->_file_ids    = !empty($tmp_value) ? array_merge($this->_file_ids, $tmp_value) : $this->_file_ids;
            $this->_file_ids    = !empty($this->_file_ids) ? array_filter($this->_file_ids) : array();
            $this->_file_ids    = array_unique($this->_file_ids);
        }
        else
        {
            $this->_file_ids    = $tmp_value;
            $this->_file_ids    = array_unique($this->_file_ids);
        }

        $new_ids        = array();

        foreach ($this->_file_ids as $id_file)
        {
            $new_ids[$id_file]      = array(
                "module"        => "JAKLEARN",
                "table"         => "__sys_config"
            );
        }

        $this->_file_ids        = $new_ids;
    }
    public function files_master()
    {
        $field_type     = array();

        foreach ($this->_ext_group as $key => $value)
        {
            $field_type[]   = $key;
        }

        $master_fields  = $this->general->get_data("__sys_fields", array(
            "type"      => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_IN,
                SQL_CONDITION_VALUE     => $field_type
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

    public function generate_ids_files($data)
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

    protected function get_files($dir = "public/files")
    {
        $results    = array();
        $files      = scandir($dir);

        foreach ($files as $key => $value)
        {
            $path = $dir . "/" . $value;

            if (!is_dir($path))
            {
                $file_size              = filesize($path);
                $file_modify            = date("Y-m-d H:i:s", filemtime($path));
                $this->_files_size      += $file_size;
                $this->_files_list[]    = array(
                    "file_name"     => $value,
                    "file_path"     => $dir,
                    "file_size"     => $file_size
                );
                $tbl_files              = $this->general->get_data("tbl_files", array(
                    "file_name"     => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $value
                    )
                ))->row();

                $tmp_data               = array(
                    "file_path"     => $dir,
                    "file_name"     => $value,
                    "file_size"     => $file_size,
                    "last_updated"  => $file_modify
                );

                if (!empty($tbl_files))
                {
                    $tmp_data["files"]      = $tbl_files;
                }

                $results[]      = $tmp_data;
            }
            else if ($value != "." && $value != "..")
            {
                $files      = $this->get_files($path);
                $file_size  = 0;

                foreach ($files as $file)
                {
                    $file_size  += $file["file_size"];
                }


                $this->_files_folder[]  = array(
                    "folder_name"   => $value,
                    "file_path"     => $dir,
                );

                $results[]  = array(
                    "file_path"     => $dir,
                    "file_name"     => $value,
                    "file_size"     => $file_size,
                    "childs"        => $files
                );
            }
        }

        return $results;
    }
    public function change_directory_to_date($date_start = "", $date_end = "")
    {
        ini_set("memory_limit", '-1');

        if ($this->_request_type == "cli"){
            echo date("Y-m-d H:i:s")." => Remap Structure Folder 'FILES' .......... ".PHP_EOL;
        }

        $condition  = array(
            "directory"     => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_IN,
                SQL_CONDITION_VALUE     => array(
                    "public/files/",
                    "public\\files\\"
                )
            )
        );

        if (!empty($date_start) && !empty($date_end))
        {
            $condition["created"]       = array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_BETWEEN,
                SQL_CONDITION_VALUE     => array(
                    $date_start,
                    $date_end
                )
            );
        }

        $files      = $this->general->get_data("tbl_files", $condition, null, null, null, null, array(
            "id",
            "file_name",
            "directory",
            "created",
        ))->result();

        if ($this->_request_type == "cli"){
            echo date("Y-m-d H:i:s")." => ".count($files)." Data found.......... ".PHP_EOL;
        }

        foreach ($files as $i => $file)
        {
            $date       = $file->created;
            $date       = date("Y-m-d", strtotime($date));
            $date       = explode("-", $date);
            $path       = "public".DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR;

            $old_path   = $path.$file->file_name;
            $new_dir    = $this->check_directory_date($path, $date);
            $new_path   = $new_dir.$file->file_name;



            $data       = array(
                "directory"     => $new_dir
            );

            if (file_exists($old_path))
            {
                rename($old_path, $new_path);
                $data["status"]     = 1;

                if ($this->_request_type == "cli"){
                    echo date("Y-m-d H:i:s")." => ".($i + 1).". ".$file->file_name." = (".$old_path.") => (".$new_path.") ".PHP_EOL;
                }
            }
            else
            {
                $data["status"]     = 0;

                if ($this->_request_type == "cli"){
                    echo date("Y-m-d H:i:s")." => ".($i + 1).". ".$file->file_name." (FILE NOT FOUND) ".PHP_EOL;
                }
            }

            $this->general->update("tbl_files", array(
                "id"     => array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                    SQL_CONDITION_VALUE     => $file->id
                )
            ), $data);
        }


    }
    // MANAGE FILES (Scanning, Cleaner, Refoldering)
}
