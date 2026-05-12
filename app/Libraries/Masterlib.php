<?php
namespace App\Libraries;
use Config\Session;
use App\Libraries\Encryptlib;
use App\Libraries\Utils;
use App\Libraries\Filelib;
use App\Models\GeneralModel;

/**
 * Class Masterlib
 *
 *  Model
 * @property GeneralModel $general
 *
 *  Library
 * @property Session $session
 * @property Encryptlib $encryptlib;
 * @property Utils;
 * @property Filelib $filelib
 */

class Masterlib
{
    const MASTER_TAB_GENERAL    = "general";
    const MASTER_TAB_SOURCES    = "sources";
    const MASTER_TAB_FIELDS     = "fields";
    const MASTER_TAB_DATATABLE  = "datatable";
    const MASTER_TAB_FORM       = "form";
    const MASTER_TAB_GROUPS     = "groups";
    const MASTER_TAB_FILES      = "files";
    const MASTER_TAB_MENU       = "menu";

    const TABLE_MASTER          = "__sys_master";
    const TABLE_SOURCES         = "__sys_sources";
    const TABLE_FIELDS          = "__sys_fields";

    protected $_CI;

    public $_default_master_field;
    public $_table_system;

    public $_db_engines;
    public $_table_collation;
    public $_field_type;
    public $_field_type_not_length;
    public $_datatable_align;
    public $_bgcolor;
    public $_master_field_type;
    public $_master_field_group;
    public $_tmp_master;
    public $_exts;
    public $_user;
    public $_field_condition_source;
    public $_field_condition_target;
    public $_format_time;

    function __construct()
    {
        $this->general      = new GeneralModel();
        $this->filelib      = new \App\Libraries\Filelib();
        $this->encryptlib   = new Encryptlib();
        $this->utils        = new Utils();

        $this->_default_master_field    = array(
            "id"            => array(
                "id_table"      => "",
                "name"          => "id",
                "field"         => "id",
                "type"          => "ID",
                /*"source_type"   => SOURCE_META_FIELD,*/
                "position"      => 1,
                "source"        => json_encode(
                    array (
                        'join-type' => '',
                        'table' => '',
                        'table-alias' => '',
                        'field-key' => '',
                        'field-label' => '',
                        'field-alias' => '',
                    )
                ),
                "datatable"     => json_encode(array (
                    'render' => '0',
                    'filter' => '0',
                    'sort' => '0',
                    'label' => '',
                    'halign' => '',
                    'align' => '',
                    'position' => '',
                    'width' => '',
                )),
                "form"          => json_encode(
                    array (
                        'render' => '1',
                        'label' => '',
                        'attr-container' => '',
                        'attr-element' => '',
                        'class-container' => '',
                        'class-element' => '',
                        'position' => '',
                        'default-value' => '',
                    )
                ),
            ),
            /*"created"       => array(
                "id_table"      => "",
                "name"          => "created",
                "field"         => "created",
                "type"          => FIELD_TYPE_SYSDATE,
                "source_type"   => SOURCE_META_FIELD,
                "position"      => 97,
                "source"        => json_encode(
                    array (
                        'join-type' => '',
                        'table' => '',
                        'table-alias' => '',
                        'field-key' => '',
                        'field-label' => '',
                        'field-alias' => '',
                    )
                ),
                "datatable"     => json_encode(
                    array (
                        'render' => '1',
                        'filter' => '1',
                        'sort' => '1',
                        'label' => 'Date Created',
                        'halign' => 'text-center',
                        'align' => 'text-center',
                        'position' => 97,
                        'width' => '120',
                    )
                ),
                "form"          => json_encode(
                    array (
                        'render' => '0',
                        'label' => '',
                        'attr-container' => '',
                        'attr-element' => '',
                        'class-container' => '',
                        'class-element' => '',
                        'position' => '',
                        'default-value' => '',
                    )
                ),
            ),
            "createdby"     => array(
                "id_table"      => "",
                "name"          => "createdby",
                "field"         => "createdby",
                "type"          => FIELD_TYPE_SELECT_MASTER,
                "source_type"   => SOURCE_META_FIELD,
                "position"      => 98,
                "source"        => json_encode(
                    array (
                        'join-type'     => 'LEFT',
                        'table'         => 'mst_user',
                        'table-alias'   => 'mst_user_created',
                        'field-key'     => 'id',
                        'field-label'   => 'name',
                        'field-alias'   => 'user_created',
                        'field-order'   => 'name',
                    )
                ),
                "datatable"     => json_encode(
                    array (
                        'render' => '0',
                        'filter' => '1',
                        'sort' => '1',
                        'label' => 'Created By',
                        'halign' => 'Select',
                        'align' => 'Select',
                        'position' => 98,
                        'width' => '150',
                    )
                ),
                "form"          => json_encode(
                    array (
                        'render' => '0',
                        'label' => '',
                        'attr-container' => '',
                        'attr-element' => '',
                        'class-container' => '',
                        'class-element' => '',
                        'position' => '',
                        'default-value' => '',
                    )
                ),
            ),
            "updated"       => array(
                "id_table"      => "",
                "name"          => "updated",
                "field"         => "updated",
                "type"          => FIELD_TYPE_SYSDATE,
                "source_type"   => SOURCE_META_FIELD,
                "position"      => 99,
                "source"        => json_encode(
                    array (
                        'join-type' => '',
                        'table' => '',
                        'table-alias' => '',
                        'field-key' => '',
                        'field-label' => '',
                        'field-alias' => '',
                    )
                ),
                "datatable"     => json_encode(
                    array (
                        'render' => '1',
                        'filter' => '1',
                        'sort' => '1',
                        'label' => 'Date Updated',
                        'halign' => 'text-center',
                        'align' => 'text-center',
                        'position' => 99,
                        'width' => '120',
                    )
                ),
                "form"          => json_encode(
                    array (
                        'render' => '0',
                        'label' => '',
                        'attr-container' => '',
                        'attr-element' => '',
                        'class-container' => '',
                        'class-element' => '',
                        'position' => '',
                        'default-value' => '',
                    )
                ),
            ),
            "updatedby"     => array(
                "id_table"      => "",
                "name"          => "updatedby",
                "field"         => "updatedby",
                "type"          => FIELD_TYPE_SELECT_MASTER,
                "source_type"   => SOURCE_META_FIELD,
                "position"      => 100,
                "source"        => json_encode(
                    array (
                        'join-type'     => 'LEFT',
                        'table'         => 'mst_user',
                        'table-alias'   => 'mst_user_updated',
                        'field-key'     => 'id',
                        'field-label'   => 'name',
                        'field-alias'   => 'user_updated',
                        'field-order'   => 'name',
                    )
                ),
                "datatable"     => json_encode(
                    array (
                        'render' => '0',
                        'filter' => '1',
                        'sort' => '1',
                        'label' => 'Updated By',
                        'halign' => 'Select',
                        'align' => 'Select',
                        'position' => 100,
                        'width' => '150',
                    )
                ),
                "form"          => json_encode(
                    array (
                        'render' => '0',
                        'label' => '',
                        'attr-container' => '',
                        'attr-element' => '',
                        'class-container' => '',
                        'class-element' => '',
                        'position' => null,
                        'default-value' => '',
                    )
                ),
            ),*/
        );
        $this->_table_system            = array(
            "__sys_fields",
            "__sys_master",
            "__sys_sources",
        );

        $this->_db_engines              = array(
            "InnoDB", "MyISAM", "Memory", "Archive", "Blackhole", "Federated", "CSV"
        );
        $this->_table_collation         = array(
            array(
                "group" => "armscii8",
                "group_title" => "ARMSCII-8 Armenian",
                "collation" => "armscii8_bin",
                "collation_title" => "Armenian, binary",
            ),
            array(
                "group" => "armscii8",
                "group_title" => "ARMSCII-8 Armenian",
                "collation" => "armscii8_general_ci",
                "collation_title" => "Armenian, case-insensitive",
            ),
            array(
                "group" => "ascii",
                "group_title" => "US ASCII",
                "collation" => "ascii_bin",
                "collation_title" => "West European, binary",
            ),
            array(
                "group" => "ascii",
                "group_title" => "US ASCII",
                "collation" => "ascii_general_ci",
                "collation_title" => "West European, case-insensitive",
            ),
            array(
                "group" => "big5",
                "group_title" => "Big5 Traditional Chinese",
                "collation" => "big5_bin",
                "collation_title" => "Traditional Chinese, binary",
            ),
            array(
                "group" => "big5",
                "group_title" => "Big5 Traditional Chinese",
                "collation" => "big5_chinese_ci",
                "collation_title" => "Traditional Chinese, case-insensitive",
            ),
            array(
                "group" => "binary",
                "group_title" => "Binary pseudo charset",
                "collation" => "binary",
                "collation_title" => "Binary",
            ),
            array(
                "group" => "cp1250",
                "group_title" => "Windows Central European",
                "collation" => "cp1250_bin",
                "collation_title" => "Central European, binary",
            ),
            array(
                "group" => "cp1250",
                "group_title" => "Windows Central European",
                "collation" => "cp1250_croatian_ci",
                "collation_title" => "Croatian, case-insensitive",
            ),
            array(
                "group" => "cp1250",
                "group_title" => "Windows Central European",
                "collation" => "cp1250_czech_cs",
                "collation_title" => "Czech, case-sensitive",
            ),
            array(
                "group" => "cp1250",
                "group_title" => "Windows Central European",
                "collation" => "cp1250_general_ci",
                "collation_title" => "Central European, case-insensitive",
            ),
            array(
                "group" => "cp1250",
                "group_title" => "Windows Central European",
                "collation" => "cp1250_polish_ci",
                "collation_title" => "Polish, case-insensitive",
            ),
            array(
                "group" => "cp1251",
                "group_title" => "Windows Cyrillic",
                "collation" => "cp1251_bin",
                "collation_title" => "Cyrillic, binary",
            ),
            array(
                "group" => "cp1251",
                "group_title" => "Windows Cyrillic",
                "collation" => "cp1251_bulgarian_ci",
                "collation_title" => "Bulgarian, case-insensitive",
            ),
            array(
                "group" => "cp1251",
                "group_title" => "Windows Cyrillic",
                "collation" => "cp1251_general_ci",
                "collation_title" => "Cyrillic, case-insensitive",
            ),
            array(
                "group" => "cp1251",
                "group_title" => "Windows Cyrillic",
                "collation" => "cp1251_general_cs",
                "collation_title" => "Cyrillic, case-sensitive",
            ),
            array(
                "group" => "cp1251",
                "group_title" => "Windows Cyrillic",
                "collation" => "cp1251_ukrainian_ci",
                "collation_title" => "Ukrainian, case-insensitive",
            ),
            array(
                "group" => "cp1256",
                "group_title" => "Windows Arabic",
                "collation" => "cp1256_bin",
                "collation_title" => "Arabic, binary",
            ),
            array(
                "group" => "cp1256",
                "group_title" => "Windows Arabic",
                "collation" => "cp1256_general_ci",
                "collation_title" => "Arabic, case-insensitive",
            ),
            array(
                "group" => "cp1257",
                "group_title" => "Windows Baltic",
                "collation" => "cp1257_bin",
                "collation_title" => "Baltic, binary",
            ),
            array(
                "group" => "cp1257",
                "group_title" => "Windows Baltic",
                "collation" => "cp1257_general_ci",
                "collation_title" => "Baltic, case-insensitive",
            ),
            array(
                "group" => "cp1257",
                "group_title" => "Windows Baltic",
                "collation" => "cp1257_lithuanian_ci",
                "collation_title" => "Lithuanian, case-insensitive",
            ),
            array(
                "group" => "cp850",
                "group_title" => "DOS West European",
                "collation" => "cp850_bin",
                "collation_title" => "West European, binary",
            ),
            array(
                "group" => "cp850",
                "group_title" => "DOS West European",
                "collation" => "cp850_general_ci",
                "collation_title" => "West European, case-insensitive",
            ),
            array(
                "group" => "cp852",
                "group_title" => "DOS Central European",
                "collation" => "cp852_bin",
                "collation_title" => "Central European, binary",
            ),
            array(
                "group" => "cp852",
                "group_title" => "DOS Central European",
                "collation" => "cp852_general_ci",
                "collation_title" => "Central European, case-insensitive",
            ),
            array(
                "group" => "cp866",
                "group_title" => "DOS Russian",
                "collation" => "cp866_bin",
                "collation_title" => "Russian, binary",
            ),
            array(
                "group" => "cp866",
                "group_title" => "DOS Russian",
                "collation" => "cp866_general_ci",
                "collation_title" => "Russian, case-insensitive",
            ),
            array(
                "group" => "cp932",
                "group_title" => "SJIS for Windows Japanese",
                "collation" => "cp932_bin",
                "collation_title" => "Japanese, binary",
            ),
            array(
                "group" => "cp932",
                "group_title" => "SJIS for Windows Japanese",
                "collation" => "cp932_japanese_ci",
                "collation_title" => "Japanese, case-insensitive",
            ),
            array(
                "group" => "dec8",
                "group_title" => "DEC West European",
                "collation" => "dec8_bin",
                "collation_title" => "West European, binary",
            ),
            array(
                "group" => "dec8",
                "group_title" => "DEC West European",
                "collation" => "dec8_swedish_ci",
                "collation_title" => "Swedish, case-insensitive",
            ),
            array(
                "group" => "eucjpms",
                "group_title" => "UJIS for Windows Japanese",
                "collation" => "eucjpms_bin",
                "collation_title" => "Japanese, binary",
            ),
            array(
                "group" => "eucjpms",
                "group_title" => "UJIS for Windows Japanese",
                "collation" => "eucjpms_japanese_ci",
                "collation_title" => "Japanese, case-insensitive",
            ),
            array(
                "group" => "euckr",
                "group_title" => "EUC-KR Korean",
                "collation" => "euckr_bin",
                "collation_title" => "Korean, binary",
            ),
            array(
                "group" => "euckr",
                "group_title" => "EUC-KR Korean",
                "collation" => "euckr_korean_ci",
                "collation_title" => "Korean, case-insensitive",
            ),
            array(
                "group" => "gb18030",
                "group_title" => "China National Standard GB18030",
                "collation" => "gb18030_bin",
                "collation_title" => "Unknown, binary",
            ),
            array(
                "group" => "gb18030",
                "group_title" => "China National Standard GB18030",
                "collation" => "gb18030_chinese_ci",
                "collation_title" => "Unknown, case-insensitive",
            ),
            array(
                "group" => "gb18030",
                "group_title" => "China National Standard GB18030",
                "collation" => "gb18030_unicode_520_ci",
                "collation_title" => "Unicode (UCA 5.2.0), case-insensitive",
            ),
            array(
                "group" => "gb2312",
                "group_title" => "GB2312 Simplified Chinese",
                "collation" => "gb2312_bin",
                "collation_title" => "Simplified Chinese, binary",
            ),
            array(
                "group" => "gb2312",
                "group_title" => "GB2312 Simplified Chinese",
                "collation" => "gb2312_chinese_ci",
                "collation_title" => "Simplified Chinese, case-insensitive",
            ),
            array(
                "group" => "gbk",
                "group_title" => "GBK Simplified Chinese",
                "collation" => "gbk_bin",
                "collation_title" => "Simplified Chinese, binary",
            ),
            array(
                "group" => "gbk",
                "group_title" => "GBK Simplified Chinese",
                "collation" => "gbk_chinese_ci",
                "collation_title" => "Simplified Chinese, case-insensitive",
            ),
            array(
                "group" => "geostd8",
                "group_title" => "GEOSTD8 Georgian",
                "collation" => "geostd8_bin",
                "collation_title" => "Georgian, binary",
            ),
            array(
                "group" => "geostd8",
                "group_title" => "GEOSTD8 Georgian",
                "collation" => "geostd8_general_ci",
                "collation_title" => "Georgian, case-insensitive",
            ),
            array(
                "group" => "greek",
                "group_title" => "ISO 8859-7 Greek",
                "collation" => "greek_bin",
                "collation_title" => "Greek, binary",
            ),
            array(
                "group" => "greek",
                "group_title" => "ISO 8859-7 Greek",
                "collation" => "greek_general_ci",
                "collation_title" => "Greek, case-insensitive",
            ),
            array(
                "group" => "hebrew",
                "group_title" => "ISO 8859-8 Hebrew",
                "collation" => "hebrew_bin",
                "collation_title" => "Hebrew, binary",
            ),
            array(
                "group" => "hebrew",
                "group_title" => "ISO 8859-8 Hebrew",
                "collation" => "hebrew_general_ci",
                "collation_title" => "Hebrew, case-insensitive",
            ),
            array(
                "group" => "hp8",
                "group_title" => "HP West European",
                "collation" => "hp8_bin",
                "collation_title" => "West European, binary",
            ),
            array(
                "group" => "hp8",
                "group_title" => "HP West European",
                "collation" => "hp8_english_ci",
                "collation_title" => "English, case-insensitive",
            ),
            array(
                "group" => "keybcs2",
                "group_title" => "DOS Kamenicky Czech-Slovak",
                "collation" => "keybcs2_bin",
                "collation_title" => "Czech-Slovak, binary",
            ),
            array(
                "group" => "keybcs2",
                "group_title" => "DOS Kamenicky Czech-Slovak",
                "collation" => "keybcs2_general_ci",
                "collation_title" => "Czech-Slovak, case-insensitive",
            ),
            array(
                "group" => "koi8r",
                "group_title" => "KOI8-R Relcom Russian",
                "collation" => "koi8r_bin",
                "collation_title" => "Russian, binary",
            ),
            array(
                "group" => "koi8r",
                "group_title" => "KOI8-R Relcom Russian",
                "collation" => "koi8r_general_ci",
                "collation_title" => "Russian, case-insensitive",
            ),
            array(
                "group" => "koi8u",
                "group_title" => "KOI8-U Ukrainian",
                "collation" => "koi8u_bin",
                "collation_title" => "Ukrainian, binary",
            ),
            array(
                "group" => "koi8u",
                "group_title" => "KOI8-U Ukrainian",
                "collation" => "koi8u_general_ci",
                "collation_title" => "Ukrainian, case-insensitive",
            ),
            array(
                "group" => "latin1",
                "group_title" => "cp1252 West European",
                "collation" => "latin1_bin",
                "collation_title" => "West European, binary",
            ),
            array(
                "group" => "latin1",
                "group_title" => "cp1252 West European",
                "collation" => "latin1_danish_ci",
                "collation_title" => "Danish, case-insensitive",
            ),
            array(
                "group" => "latin1",
                "group_title" => "cp1252 West European",
                "collation" => "latin1_general_ci",
                "collation_title" => "West European, case-insensitive",
            ),
            array(
                "group" => "latin1",
                "group_title" => "cp1252 West European",
                "collation" => "latin1_general_cs",
                "collation_title" => "West European, case-sensitive",
            ),
            array(
                "group" => "latin1",
                "group_title" => "cp1252 West European",
                "collation" => "latin1_german1_ci",
                "collation_title" => "German (dictionary order), case-insensitive",
            ),
            array(
                "group" => "latin1",
                "group_title" => "cp1252 West European",
                "collation" => "latin1_german2_ci",
                "collation_title" => "German (phone book order), case-insensitive",
            ),
            array(
                "group" => "latin1",
                "group_title" => "cp1252 West European",
                "collation" => "latin1_spanish_ci",
                "collation_title" => "Spanish (modern), case-insensitive",
            ),
            array(
                "group" => "latin1",
                "group_title" => "cp1252 West European",
                "collation" => "latin1_swedish_ci",
                "collation_title" => "Swedish, case-insensitive",
            ),
            array(
                "group" => "latin2",
                "group_title" => "ISO 8859-2 Central European",
                "collation" => "latin2_bin",
                "collation_title" => "Central European, binary",
            ),
            array(
                "group" => "latin2",
                "group_title" => "ISO 8859-2 Central European",
                "collation" => "latin2_croatian_ci",
                "collation_title" => "Croatian, case-insensitive",
            ),
            array(
                "group" => "latin2",
                "group_title" => "ISO 8859-2 Central European",
                "collation" => "latin2_czech_cs",
                "collation_title" => "Czech, case-sensitive",
            ),
            array(
                "group" => "latin2",
                "group_title" => "ISO 8859-2 Central European",
                "collation" => "latin2_general_ci",
                "collation_title" => "Central European, case-insensitive",
            ),
            array(
                "group" => "latin2",
                "group_title" => "ISO 8859-2 Central European",
                "collation" => "latin2_hungarian_ci",
                "collation_title" => "Hungarian, case-insensitive",
            ),
            array(
                "group" => "latin5",
                "group_title" => "ISO 8859-9 Turkish",
                "collation" => "latin5_bin",
                "collation_title" => "Turkish, binary",
            ),
            array(
                "group" => "latin5",
                "group_title" => "ISO 8859-9 Turkish",
                "collation" => "latin5_turkish_ci",
                "collation_title" => "Turkish, case-insensitive",
            ),
            array(
                "group" => "latin7",
                "group_title" => "ISO 8859-13 Baltic",
                "collation" => "latin7_bin",
                "collation_title" => "Baltic, binary",
            ),
            array(
                "group" => "latin7",
                "group_title" => "ISO 8859-13 Baltic",
                "collation" => "latin7_estonian_cs",
                "collation_title" => "Estonian, case-sensitive",
            ),
            array(
                "group" => "latin7",
                "group_title" => "ISO 8859-13 Baltic",
                "collation" => "latin7_general_ci",
                "collation_title" => "Baltic, case-insensitive",
            ),
            array(
                "group" => "latin7",
                "group_title" => "ISO 8859-13 Baltic",
                "collation" => "latin7_general_cs",
                "collation_title" => "Baltic, case-sensitive",
            ),
            array(
                "group" => "macce",
                "group_title" => "Mac Central European",
                "collation" => "macce_bin",
                "collation_title" => "Central European, binary",
            ),
            array(
                "group" => "macce",
                "group_title" => "Mac Central European",
                "collation" => "macce_general_ci",
                "collation_title" => "Central European, case-insensitive",
            ),
            array(
                "group" => "macroman",
                "group_title" => "Mac West European",
                "collation" => "macroman_bin",
                "collation_title" => "West European, binary",
            ),
            array(
                "group" => "macroman",
                "group_title" => "Mac West European",
                "collation" => "macroman_general_ci",
                "collation_title" => "West European, case-insensitive",
            ),
            array(
                "group" => "sjis",
                "group_title" => "Shift-JIS Japanese",
                "collation" => "sjis_bin",
                "collation_title" => "Japanese, binary",
            ),
            array(
                "group" => "sjis",
                "group_title" => "Shift-JIS Japanese",
                "collation" => "sjis_japanese_ci",
                "collation_title" => "Japanese, case-insensitive",
            ),
            array(
                "group" => "swe7",
                "group_title" => "7bit Swedish",
                "collation" => "swe7_bin",
                "collation_title" => "Swedish, binary",
            ),
            array(
                "group" => "swe7",
                "group_title" => "7bit Swedish",
                "collation" => "swe7_swedish_ci",
                "collation_title" => "Swedish, case-insensitive",
            ),
            array(
                "group" => "tis620",
                "group_title" => "TIS620 Thai",
                "collation" => "tis620_bin",
                "collation_title" => "Thai, binary",
            ),
            array(
                "group" => "tis620",
                "group_title" => "TIS620 Thai",
                "collation" => "tis620_thai_ci",
                "collation_title" => "Thai, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_bin",
                "collation_title" => "Unicode, binary",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_croatian_ci",
                "collation_title" => "Croatian, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_czech_ci",
                "collation_title" => "Czech, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_danish_ci",
                "collation_title" => "Danish, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_esperanto_ci",
                "collation_title" => "Esperanto, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_estonian_ci",
                "collation_title" => "Estonian, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_general_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_general_mysql500_ci",
                "collation_title" => "Unicode (MySQL 5.0.0), case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_german2_ci",
                "collation_title" => "German (phone book order), case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_hungarian_ci",
                "collation_title" => "Hungarian, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_icelandic_ci",
                "collation_title" => "Icelandic, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_latvian_ci",
                "collation_title" => "Latvian, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_lithuanian_ci",
                "collation_title" => "Lithuanian, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_persian_ci",
                "collation_title" => "Persian, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_polish_ci",
                "collation_title" => "Polish, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_roman_ci",
                "collation_title" => "West European, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_romanian_ci",
                "collation_title" => "Romanian, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_sinhala_ci",
                "collation_title" => "Sinhalese, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_slovak_ci",
                "collation_title" => "Slovak, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_slovenian_ci",
                "collation_title" => "Slovenian, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_spanish2_ci",
                "collation_title" => "Spanish (traditional), case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_spanish_ci",
                "collation_title" => "Spanish (modern), case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_swedish_ci",
                "collation_title" => "Swedish, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_turkish_ci",
                "collation_title" => "Turkish, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_unicode_520_ci",
                "collation_title" => "Unicode (UCA 5.2.0), case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_unicode_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "ucs2",
                "group_title" => "UCS-2 Unicode",
                "collation" => "ucs2_vietnamese_ci",
                "collation_title" => "Vietnamese, case-insensitive",
            ),
            array(
                "group" => "ujis",
                "group_title" => "EUC-JP Japanese",
                "collation" => "ujis_bin",
                "collation_title" => "Japanese, binary",
            ),
            array(
                "group" => "ujis",
                "group_title" => "EUC-JP Japanese",
                "collation" => "ujis_japanese_ci",
                "collation_title" => "Japanese, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_bin",
                "collation_title" => "Unicode, binary",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_croatian_ci",
                "collation_title" => "Croatian, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_czech_ci",
                "collation_title" => "Czech, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_danish_ci",
                "collation_title" => "Danish, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_esperanto_ci",
                "collation_title" => "Esperanto, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_estonian_ci",
                "collation_title" => "Estonian, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_general_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_german2_ci",
                "collation_title" => "German (phone book order), case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_hungarian_ci",
                "collation_title" => "Hungarian, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_icelandic_ci",
                "collation_title" => "Icelandic, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_latvian_ci",
                "collation_title" => "Latvian, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_lithuanian_ci",
                "collation_title" => "Lithuanian, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_persian_ci",
                "collation_title" => "Persian, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_polish_ci",
                "collation_title" => "Polish, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_roman_ci",
                "collation_title" => "West European, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_romanian_ci",
                "collation_title" => "Romanian, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_sinhala_ci",
                "collation_title" => "Sinhalese, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_slovak_ci",
                "collation_title" => "Slovak, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_slovenian_ci",
                "collation_title" => "Slovenian, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_spanish2_ci",
                "collation_title" => "Spanish (traditional), case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_spanish_ci",
                "collation_title" => "Spanish (modern), case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_swedish_ci",
                "collation_title" => "Swedish, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_turkish_ci",
                "collation_title" => "Turkish, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_unicode_520_ci",
                "collation_title" => "Unicode (UCA 5.2.0), case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_unicode_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "utf16",
                "group_title" => "UTF-16 Unicode",
                "collation" => "utf16_vietnamese_ci",
                "collation_title" => "Vietnamese, case-insensitive",
            ),
            array(
                "group" => "utf16le",
                "group_title" => "UTF-16LE Unicode",
                "collation" => "utf16le_bin",
                "collation_title" => "Unicode, binary",
            ),
            array(
                "group" => "utf16le",
                "group_title" => "UTF-16LE Unicode",
                "collation" => "utf16le_general_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_bin",
                "collation_title" => "Unicode, binary",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_croatian_ci",
                "collation_title" => "Croatian, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_czech_ci",
                "collation_title" => "Czech, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_danish_ci",
                "collation_title" => "Danish, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_esperanto_ci",
                "collation_title" => "Esperanto, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_estonian_ci",
                "collation_title" => "Estonian, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_general_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_german2_ci",
                "collation_title" => "German (phone book order), case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_hungarian_ci",
                "collation_title" => "Hungarian, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_icelandic_ci",
                "collation_title" => "Icelandic, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_latvian_ci",
                "collation_title" => "Latvian, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_lithuanian_ci",
                "collation_title" => "Lithuanian, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_persian_ci",
                "collation_title" => "Persian, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_polish_ci",
                "collation_title" => "Polish, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_roman_ci",
                "collation_title" => "West European, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_romanian_ci",
                "collation_title" => "Romanian, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_sinhala_ci",
                "collation_title" => "Sinhalese, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_slovak_ci",
                "collation_title" => "Slovak, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_slovenian_ci",
                "collation_title" => "Slovenian, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_spanish2_ci",
                "collation_title" => "Spanish (traditional), case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_spanish_ci",
                "collation_title" => "Spanish (modern), case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_swedish_ci",
                "collation_title" => "Swedish, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_turkish_ci",
                "collation_title" => "Turkish, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_unicode_520_ci",
                "collation_title" => "Unicode (UCA 5.2.0), case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_unicode_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "utf32",
                "group_title" => "UTF-32 Unicode",
                "collation" => "utf32_vietnamese_ci",
                "collation_title" => "Vietnamese, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_bin",
                "collation_title" => "Unicode, binary",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_croatian_ci",
                "collation_title" => "Croatian, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_czech_ci",
                "collation_title" => "Czech, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_danish_ci",
                "collation_title" => "Danish, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_esperanto_ci",
                "collation_title" => "Esperanto, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_estonian_ci",
                "collation_title" => "Estonian, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_general_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_general_mysql500_ci",
                "collation_title" => "Unicode (MySQL 5.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_german2_ci",
                "collation_title" => "German (phone book order), case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_hungarian_ci",
                "collation_title" => "Hungarian, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_icelandic_ci",
                "collation_title" => "Icelandic, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_latvian_ci",
                "collation_title" => "Latvian, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_lithuanian_ci",
                "collation_title" => "Lithuanian, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_persian_ci",
                "collation_title" => "Persian, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_polish_ci",
                "collation_title" => "Polish, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_roman_ci",
                "collation_title" => "West European, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_romanian_ci",
                "collation_title" => "Romanian, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_sinhala_ci",
                "collation_title" => "Sinhalese, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_slovak_ci",
                "collation_title" => "Slovak, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_slovenian_ci",
                "collation_title" => "Slovenian, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_spanish2_ci",
                "collation_title" => "Spanish (traditional), case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_spanish_ci",
                "collation_title" => "Spanish (modern), case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_swedish_ci",
                "collation_title" => "Swedish, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_turkish_ci",
                "collation_title" => "Turkish, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_unicode_520_ci",
                "collation_title" => "Unicode (UCA 5.2.0), case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_unicode_ci",
                "collation_title" => "Unicode, case-insensitive",
            ),
            array(
                "group" => "utf8",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8_vietnamese_ci",
                "collation_title" => "Vietnamese, case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_bin",
                "collation_title" => "Unicode (UCA 4.0.0), binary",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_croatian_ci",
                "collation_title" => "Croatian (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_czech_ci",
                "collation_title" => "Czech (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_danish_ci",
                "collation_title" => "Danish (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_esperanto_ci",
                "collation_title" => "Esperanto (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_estonian_ci",
                "collation_title" => "Estonian (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_general_ci",
                "collation_title" => "Unicode (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_german2_ci",
                "collation_title" => "German (phone book order) (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_hungarian_ci",
                "collation_title" => "Hungarian (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_icelandic_ci",
                "collation_title" => "Icelandic (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_latvian_ci",
                "collation_title" => "Latvian (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_lithuanian_ci",
                "collation_title" => "Lithuanian (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_persian_ci",
                "collation_title" => "Persian (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_polish_ci",
                "collation_title" => "Polish (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_roman_ci",
                "collation_title" => "West European (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_romanian_ci",
                "collation_title" => "Romanian (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_sinhala_ci",
                "collation_title" => "Sinhalese (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_slovak_ci",
                "collation_title" => "Slovak (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_slovenian_ci",
                "collation_title" => "Slovenian (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_spanish2_ci",
                "collation_title" => "Spanish (traditional) (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_spanish_ci",
                "collation_title" => "Spanish (modern) (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_swedish_ci",
                "collation_title" => "Swedish (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_turkish_ci",
                "collation_title" => "Turkish (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_unicode_520_ci",
                "collation_title" => "Unicode (UCA 5.2.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_unicode_ci",
                "collation_title" => "Unicode (UCA 4.0.0), case-insensitive",
            ),
            array(
                "group" => "utf8mb4",
                "group_title" => "UTF-8 Unicode",
                "collation" => "utf8mb4_vietnamese_ci",
                "collation_title" => "Vietnamese (UCA 4.0.0), case-insensitive",
            ),
        );
        $this->_field_type              = array(
            array(
                "group" => "Numeric",
                "value" => "TINYINT",
                "title" => "A 1-byte integer, signed range is -128 to 127, unsigned range is 0 to 255",
            ),
            array(
                "group" => "Numeric",
                "value" => "SMALLINT",
                "title" => "A 2-byte integer, signed range is -32,768 to 32,767, unsigned range is 0 to 65,535",
            ),
            array(
                "group" => "Numeric",
                "value" => "MEDIUMINT",
                "title" => "A 3-byte integer, signed range is -8,388,608 to 8,388,607, unsigned range is 0 to 16,777,215",
            ),
            array(
                "group" => "Numeric",
                "value" => "INT",
                "title" => "A 4-byte integer, signed range is -2,147,483,648 to 2,147,483,647, unsigned range is 0 to 4,294,967,295",
            ),
            array(
                "group" => "Numeric",
                "value" => "BIGINT",
                "title" => "An 8-byte integer, signed range is -9,223,372,036,854,775,808 to 9,223,372,036,854,775,807, unsigned range is 0 to 18,446,744,073,709,551,615",
            ),
            array(
                "group" => "Numeric",
                "value" => "-",
                "title" => "",
            ),
            array(
                "group" => "Numeric",
                "value" => "DECIMAL",
                "title" => "A fixed-point number (M, D) - the maximum number of digits (M) is 65 (default 10), the maximum number of decimals (D) is 30 (default 0)",
            ),
            array(
                "group" => "Numeric",
                "value" => "FLOAT",
                "title" => "A small floating-point number, allowable values are -3.402823466E+38 to -1.175494351E-38, 0, and 1.175494351E-38 to 3.402823466E+38",
            ),
            array(
                "group" => "Numeric",
                "value" => "DOUBLE",
                "title" => "A double-precision floating-point number, allowable values are -1.7976931348623157E+308 to -2.2250738585072014E-308, 0, and 2.2250738585072014E-308 to 1.7976931348623157E+308",
            ),
            array(
                "group" => "Numeric",
                "value" => "REAL",
                "title" => "Synonym for DOUBLE (exception: in REAL_AS_FLOAT SQL mode it is a synonym for FLOAT)",
            ),
            array(
                "group" => "Numeric",
                "value" => "-",
                "title" => "",
            ),
            array(
                "group" => "Numeric",
                "value" => "BIT",
                "title" => "A bit-field type (M), storing M of bits per value (default is 1, maximum is 64)",
            ),
            array(
                "group" => "Numeric",
                "value" => "BOOLEAN",
                "title" => "A synonym for TINYINT(1), a value of zero is considered false, nonzero values are considered true",
            ),
            array(
                "group" => "Numeric",
                "value" => "SERIAL",
                "title" => "An alias for BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE",
            ),
            array(
                "group" => "Date and time",
                "value" => "DATE",
                "title" => "A date, supported range is 1000-01-01 to 9999-12-31",
            ),
            array(
                "group" => "Date and time",
                "value" => "DATETIME",
                "title" => "A date and time combination, supported range is 1000-01-01 00:00:00 to 9999-12-31 23:59:59",
            ),
            array(
                "group" => "Date and time",
                "value" => "TIMESTAMP",
                "title" => "A timestamp, range is 1970-01-01 00:00:01 UTC to 2038-01-09 03:14:07 UTC, stored as the number of seconds since the epoch (1970-01-01 00:00:00 UTC)",
            ),
            array(
                "group" => "Date and time",
                "value" => "TIME",
                "title" => "A time, range is -838:59:59 to 838:59:59",
            ),
            array(
                "group" => "Date and time",
                "value" => "YEAR",
                "title" => "A year in four-digit (4, default) or two-digit (2) format, the allowable values are 70 (1970) to 69 (2069) or 1901 to 2155 and 0000",
            ),
            array(
                "group" => "String",
                "value" => "CHAR",
                "title" => "A fixed-length (0-255, default 1) string that is always right-padded with spaces to the specified length when stored",
            ),
            array(
                "group" => "String",
                "value" => "VARCHAR",
                "title" => "A variable-length (0-65,535) string, the effective maximum length is subject to the maximum row size",
            ),
            array(
                "group" => "String",
                "value" => "-",
                "title" => "",
            ),
            array(
                "group" => "String",
                "value" => "TINYTEXT",
                "title" => "A TEXT column with a maximum length of 255 (2^8 - 1) characters, stored with a one-byte prefix indicating the length of the value in bytes",
            ),
            array(
                "group" => "String",
                "value" => "TEXT",
                "title" => "A TEXT column with a maximum length of 65,535 (2^16 - 1) characters, stored with a two-byte prefix indicating the length of the value in bytes",
            ),
            array(
                "group" => "String",
                "value" => "MEDIUMTEXT",
                "title" => "A TEXT column with a maximum length of 16,777,215 (2^24 - 1) characters, stored with a three-byte prefix indicating the length of the value in bytes",
            ),
            array(
                "group" => "String",
                "value" => "LONGTEXT",
                "title" => "A TEXT column with a maximum length of 4,294,967,295 or 4GiB (2^32 - 1) characters, stored with a four-byte prefix indicating the length of the value in bytes",
            ),
            array(
                "group" => "String",
                "value" => "-",
                "title" => "",
            ),
            array(
                "group" => "String",
                "value" => "BINARY",
                "title" => "Similar to the CHAR type, but stores binary byte strings rather than non-binary character strings",
            ),
            array(
                "group" => "String",
                "value" => "VARBINARY",
                "title" => "Similar to the VARCHAR type, but stores binary byte strings rather than non-binary character strings",
            ),
            array(
                "group" => "String",
                "value" => "-",
                "title" => "",
            ),
            array(
                "group" => "String",
                "value" => "TINYBLOB",
                "title" => "A BLOB column with a maximum length of 255 (2^8 - 1) bytes, stored with a one-byte prefix indicating the length of the value",
            ),
            array(
                "group" => "String",
                "value" => "MEDIUMBLOB",
                "title" => "A BLOB column with a maximum length of 16,777,215 (2^24 - 1) bytes, stored with a three-byte prefix indicating the length of the value",
            ),
            array(
                "group" => "String",
                "value" => "BLOB",
                "title" => "A BLOB column with a maximum length of 65,535 (2^16 - 1) bytes, stored with a two-byte prefix indicating the length of the value",
            ),
            array(
                "group" => "String",
                "value" => "LONGBLOB",
                "title" => "A BLOB column with a maximum length of 4,294,967,295 or 4GiB (2^32 - 1) bytes, stored with a four-byte prefix indicating the length of the value",
            ),
            array(
                "group" => "String",
                "value" => "-",
                "title" => "",
            ),
            array(
                "group" => "String",
                "value" => "ENUM",
                "title" => "An enumeration, chosen from the list of up to 65,535 values or the special '' error value",
            ),
            array(
                "group" => "String",
                "value" => "SET",
                "title" => "A single value chosen from a set of up to 64 members",
            ),
            array(
                "group" => "Spatial",
                "value" => "GEOMETRY",
                "title" => "A type that can store a geometry of any type",
            ),
            array(
                "group" => "Spatial",
                "value" => "POINT",
                "title" => "A point in 2-dimensional space",
            ),
            array(
                "group" => "Spatial",
                "value" => "LINESTRING",
                "title" => "A curve with linear interpolation between points",
            ),
            array(
                "group" => "Spatial",
                "value" => "POLYGON",
                "title" => "A polygon",
            ),
            array(
                "group" => "Spatial",
                "value" => "MULTIPOINT",
                "title" => "A collection of points",
            ),
            array(
                "group" => "Spatial",
                "value" => "MULTILINESTRING",
                "title" => "A collection of curves with linear interpolation between points",
            ),
            array(
                "group" => "Spatial",
                "value" => "MULTIPOLYGON",
                "title" => "A collection of polygons",
            ),
            array(
                "group" => "Spatial",
                "value" => "GEOMETRYCOLLECTION",
                "title" => "A collection of geometry objects of any type",
            ),
            array(
                "group" => "JSON",
                "value" => "JSON",
                "title" => "Stores and enables efficient access to data in JSON (JavaScript Object Notation) documents",
            ),
        );
        $this->_field_type_not_length   = array(
            "TEXT"
        );
        $this->_datatable_align         = array(
            "text-left"     => "LEFT",
            "text-center"   => "CENTER",
            "text-right"    => "RIGHT",
        );
        $this->_bgcolor                 = array(
            "#7ea5ed",
            "#5fc278",
            "#c2ab5f",
            "#b55fc2",
        );
        $this->_master_field_type       = array(
            DATA_TYPE_ID                       => "ID",
            DATA_TYPE_TEXTBOX                  => "Textbox",
            DATA_TYPE_TEXTBOX_EMAIL            => "Textbox Email",
            DATA_TYPE_TEXTBOX_PASSWORD         => "Password",
            DATA_TYPE_NUMBER                   => "Number",
            DATA_TYPE_DECIMAL                  => "Decimal",
            DATA_TYPE_TEXTAREA                 => "Textarea",
            DATA_TYPE_HTML                     => "HTML",
            DATA_TYPE_SYSDATE                  => "Sysdate",
            DATA_TYPE_DATETIME                 => "Datetime",
            DATA_TYPE_DATE                     => "Date",
            DATA_TYPE_TIME                     => "Time",
            "line1"                            => "line",

            DATA_TYPE_SELECT_LIST_KEY          => "Select List Key",
            DATA_TYPE_SELECT_LIST_VALUE        => "Select List Value",
            DATA_TYPE_SELECT_MASTER            => "Select From Table",
            DATA_TYPE_SELECT_MASTER_TREE       => "Select From Table Tree",
            DATA_TYPE_SELECT_TAGS              => "Select Tags",
            DATA_TYPE_MULTISELECT              => "Multi Select",
            DATA_TYPE_MULTISELECT_MASTER       => "Multi Select Master",
            "line2"                            => "line",

            DATA_TYPE_ICON                     => "List Icon",
            "line3"                            => "line",

            DATA_TYPE_RADIO_KEY                => "Radio Key",
            DATA_TYPE_RADIO_KEY_HORIZONTAL     => "Radio Key Horizontal",
            DATA_TYPE_RADIO_VALUE              => "Radio Value",
            DATA_TYPE_RADIO_VALUE_HORIZONTAL   => "Radio Value Horizontal",
            DATA_TYPE_RADIO_MASTER             => "Radio From Table",
            "line4"                            => "line",

            DATA_TYPE_CHECKBOX                 => "Checkbox",
            DATA_TYPE_CHECKBOX_MASTER          => "Checkbox Master",
            "line5"                            => "line",

            DATA_TYPE_CUSTOM_RADIO_MASTER      => "Custom Radio Master",
            DATA_TYPE_CUSTOM_RADIO_KEY         => "Custom Radio Key",
            DATA_TYPE_CUSTOM_RADIO_VALUE       => "Custom Radio Value",
            DATA_TYPE_CUSTOM_CHECKBOX_MASTER   => "Custom Checkbox Master",
            DATA_TYPE_CUSTOM_CHECKBOX_KEY      => "Custom Checkbox Key",
            DATA_TYPE_CUSTOM_CHECKBOX_VALUE    => "Custom Checkbox Value",
            "line6"                            => "line",

            DATA_TYPE_FILE                     => "File",
            DATA_TYPE_FILE_ARCHIVE             => "File Archive",
            DATA_TYPE_FILE_IMAGE               => "File Image",
            DATA_TYPE_FILE_DOC                 => "File Document",
            DATA_TYPE_FILE_VIDEO               => "File Video",
            DATA_TYPE_FILE_AUDIO               => "File Audio",
            "line7"                            => "line",

            DATA_TYPE_FILE_MULTIPLE             => "File Multiple",
            DATA_TYPE_FILE_ARCHIVE_MULTIPLE     => "File Archive Multiple",
            DATA_TYPE_FILE_IMAGE_MULTIPLE       => "File Image Multiple",
            DATA_TYPE_FILE_DOC_MULTIPLE         => "File Document Multiple",
            DATA_TYPE_FILE_VIDEO_MULTIPLE       => "File Video Multiple",
            DATA_TYPE_FILE_AUDIO_MULTIPLE       => "File Audio Multiple",
            "line8"                             => "line",

            DATA_TYPE_QUERY                    => "SQL Query",
        );
        $this->_master_field_group      = array(
            "field_original"        => array(
                DATA_TYPE_ID,
                DATA_TYPE_TEXTBOX,
                DATA_TYPE_TEXTBOX_EMAIL,
                DATA_TYPE_TEXTBOX_PASSWORD,
                DATA_TYPE_NUMBER,
                DATA_TYPE_DECIMAL,
                DATA_TYPE_TEXTAREA,
                DATA_TYPE_HTML,
                DATA_TYPE_SYSDATE,
                DATA_TYPE_DATETIME,
                DATA_TYPE_DATE,
                DATA_TYPE_TIME,

                DATA_TYPE_SELECT_LIST_KEY,
                DATA_TYPE_SELECT_LIST_VALUE,
                DATA_TYPE_SELECT_MASTER,
                DATA_TYPE_SELECT_MASTER_TREE,
                DATA_TYPE_MULTISELECT,
                DATA_TYPE_MULTISELECT_MASTER,
                DATA_TYPE_SELECT_TAGS,

                DATA_TYPE_ICON,

                DATA_TYPE_RADIO_KEY,
                DATA_TYPE_RADIO_KEY_HORIZONTAL,
                DATA_TYPE_RADIO_VALUE,
                DATA_TYPE_RADIO_VALUE_HORIZONTAL,
                DATA_TYPE_RADIO_MASTER,

                DATA_TYPE_CHECKBOX,
                DATA_TYPE_CHECKBOX_MASTER,

                DATA_TYPE_CUSTOM_RADIO_MASTER,
                DATA_TYPE_CUSTOM_RADIO_KEY,
                DATA_TYPE_CUSTOM_RADIO_VALUE,
                DATA_TYPE_CUSTOM_CHECKBOX_MASTER,
                DATA_TYPE_CUSTOM_CHECKBOX_KEY,
                DATA_TYPE_CUSTOM_CHECKBOX_VALUE,

                DATA_TYPE_FILE,
                DATA_TYPE_FILE_ARCHIVE,
                DATA_TYPE_FILE_IMAGE,
                DATA_TYPE_FILE_DOC,
                DATA_TYPE_FILE_VIDEO,
                DATA_TYPE_FILE_AUDIO,

                DATA_TYPE_FILE_MULTIPLE,
                DATA_TYPE_FILE_ARCHIVE_MULTIPLE,
                DATA_TYPE_FILE_IMAGE_MULTIPLE,
                DATA_TYPE_FILE_DOC_MULTIPLE,
                DATA_TYPE_FILE_VIDEO_MULTIPLE,
                DATA_TYPE_FILE_AUDIO_MULTIPLE,

                DATA_TYPE_QUERY,
            ),
            "field_text"            => array(
                DATA_TYPE_TEXTBOX,
                DATA_TYPE_TEXTAREA,
                DATA_TYPE_HTML,
            ),
            "field_other_source"    => array(
                DATA_TYPE_TEXTBOX_EMAIL,
                DATA_TYPE_TEXTBOX,
                DATA_TYPE_NUMBER,
                DATA_TYPE_DECIMAL,
                DATA_TYPE_TEXTAREA,
                DATA_TYPE_HTML,
                DATA_TYPE_SYSDATE,
                DATA_TYPE_DATETIME,
                DATA_TYPE_DATE,
                DATA_TYPE_TIME,
            ),
            "field_metadata"        => array(
                DATA_TYPE_TEXTBOX,
                DATA_TYPE_TEXTBOX_EMAIL,
                DATA_TYPE_NUMBER,
                DATA_TYPE_DECIMAL,
                DATA_TYPE_TEXTAREA,
                DATA_TYPE_HTML,
                DATA_TYPE_SYSDATE,
                DATA_TYPE_DATETIME,
                DATA_TYPE_DATE,
                DATA_TYPE_TIME,

                DATA_TYPE_SELECT_LIST_KEY,
                DATA_TYPE_SELECT_LIST_VALUE,

                DATA_TYPE_RADIO_KEY,
                DATA_TYPE_RADIO_KEY_HORIZONTAL,
                DATA_TYPE_RADIO_VALUE,
                DATA_TYPE_RADIO_VALUE_HORIZONTAL,

                DATA_TYPE_CHECKBOX,

                DATA_TYPE_CUSTOM_RADIO_KEY,
                DATA_TYPE_CUSTOM_RADIO_VALUE,
                DATA_TYPE_CUSTOM_CHECKBOX_KEY,
                DATA_TYPE_CUSTOM_CHECKBOX_VALUE,

                DATA_TYPE_FILE,
                DATA_TYPE_FILE_ARCHIVE,
                DATA_TYPE_FILE_IMAGE,
                DATA_TYPE_FILE_DOC,
                DATA_TYPE_FILE_VIDEO,
                DATA_TYPE_FILE_AUDIO,

                DATA_TYPE_FILE_MULTIPLE,
                DATA_TYPE_FILE_ARCHIVE_MULTIPLE,
                DATA_TYPE_FILE_IMAGE_MULTIPLE,
                DATA_TYPE_FILE_DOC_MULTIPLE,
                DATA_TYPE_FILE_VIDEO_MULTIPLE,
                DATA_TYPE_FILE_AUDIO_MULTIPLE,
            ),
            "field_list_key"        => array(
                DATA_TYPE_SELECT_LIST_KEY,
                DATA_TYPE_RADIO_KEY,
                DATA_TYPE_RADIO_KEY_HORIZONTAL,
                DATA_TYPE_CUSTOM_RADIO_KEY,
                DATA_TYPE_CUSTOM_CHECKBOX_KEY,
            ),
            "field_list_value"      => array(
                DATA_TYPE_CHECKBOX,
                DATA_TYPE_SELECT_LIST_VALUE,
                DATA_TYPE_RADIO_VALUE,
                DATA_TYPE_RADIO_VALUE_HORIZONTAL,
                DATA_TYPE_CUSTOM_RADIO_VALUE,
                DATA_TYPE_CUSTOM_CHECKBOX_VALUE,
                DATA_TYPE_MULTISELECT
            ),
            "field_table"           => array(
                DATA_TYPE_SELECT_MASTER,
                DATA_TYPE_SELECT_MASTER_TREE,
                DATA_TYPE_RADIO_MASTER,
                DATA_TYPE_CHECKBOX_MASTER,
                DATA_TYPE_CUSTOM_RADIO_MASTER,
                DATA_TYPE_CUSTOM_CHECKBOX_MASTER,
                DATA_TYPE_MULTISELECT_MASTER
            ),
            "field_query"           => array(
                DATA_TYPE_QUERY
            ),
            "field_single_join"     => array(
                DATA_TYPE_SELECT_MASTER,
                DATA_TYPE_SELECT_MASTER_TREE,
                DATA_TYPE_RADIO_MASTER,
                DATA_TYPE_CUSTOM_RADIO_MASTER
            ),
            "field_multi"           => array(
                DATA_TYPE_MULTISELECT,
                DATA_TYPE_SELECT_TAGS,
                DATA_TYPE_CHECKBOX,
            ),
            "field_multi_join"      => array(
                DATA_TYPE_MULTISELECT_MASTER,
                DATA_TYPE_CHECKBOX_MASTER,
            ),
            "field_date"            => array(
                DATA_TYPE_SYSDATE,
                DATA_TYPE_DATE,
                DATA_TYPE_DATETIME,
                DATA_TYPE_TIME
            ),
            "field_datetime"        => array(
                DATA_TYPE_SYSDATE,
                DATA_TYPE_DATETIME,
            ),
            "field_number"          => array(
                DATA_TYPE_NUMBER,
                DATA_TYPE_DECIMAL
            ),
            "field_file"            => array(
                DATA_TYPE_FILE,
                DATA_TYPE_FILE_ARCHIVE,
                DATA_TYPE_FILE_IMAGE,
                DATA_TYPE_FILE_DOC,
                DATA_TYPE_FILE_VIDEO,
                DATA_TYPE_FILE_AUDIO,
            ),
            "field_file_multiple"   => array(
                DATA_TYPE_FILE_MULTIPLE,
                DATA_TYPE_FILE_ARCHIVE_MULTIPLE,
                DATA_TYPE_FILE_IMAGE_MULTIPLE,
                DATA_TYPE_FILE_DOC_MULTIPLE,
                DATA_TYPE_FILE_VIDEO_MULTIPLE,
                DATA_TYPE_FILE_AUDIO_MULTIPLE,
            ),
            "field_metadata_assets" => array(
                DATA_TYPE_TEXTBOX,
                DATA_TYPE_NUMBER,
                DATA_TYPE_DECIMAL,
                DATA_TYPE_TEXTAREA,
                DATA_TYPE_HTML,
                DATA_TYPE_DATETIME,
                DATA_TYPE_DATE,
                DATA_TYPE_TIME,

                DATA_TYPE_SELECT_LIST_VALUE,
                DATA_TYPE_RADIO_VALUE,
                DATA_TYPE_CHECKBOX,
            ),
            "field_condition_equal" => array(
                DATA_TYPE_SELECT_TAGS
            )

        );
        $this->_exts                    = array();
        $this->_format_time             = array(
            "date"      => array(
                "Y-m-d",
                ""
            )
        );

        foreach ($this->filelib->_ext_group as $key => $exts)
        {
            foreach ($exts as $ext => $list)
            {
                if (!in_array($ext, $this->_exts)){
                    $this->_exts[]  = $ext;
                }
            }
        }
    }

    public function get_db_table()
    {
        $tables         = $this->general->get_data("INFORMATION_SCHEMA.TABLES", array(
            "TABLE_SCHEMA"  => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $this->general->db->database
            ),
        ), "information_schema.TABLES.TABLE_NAME", "ASC", null, null, array("TABLE_NAME as 'table'"))->getResult();

        $table_system   = array();
        $table_other    = array();

        foreach ($tables as $table)
        {
            $table->hash    = $this->encryptlib->encode($table->table);
            $table->system  = in_array($table->table, $this->_table_system) ? true : false;
            $table->fields  = $this->get_db_fields($table->table, true);


            if ($table->system)
            {
                $table_system[] = $table;
            }
            else
            {
                $table_other[]  = (array) $table;
            }
        }
        usort($table_other, function($a, $b) {
            if ($a["table"] == $b["table"]) {
                return 0;
            }
            return ($a["table"] < $b["table"]) ? -1 : 1;
        });
        $table_other    = array_map(function ($table) {
            $table  = (object) $table;
            return $table;
        }, $table_other);

        $tables         = $table_other;

        return $tables;
    }
    public function get_db_fields($table_name, $get_field_only = false)
    {
        $fields     = $this->general->get_data("INFORMATION_SCHEMA.COLUMNS", array(
            "TABLE_SCHEMA"  => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $this->general->db->database
            ),
            "TABLE_NAME"    => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $table_name
            )
        ), "ORDINAL_POSITION", "ASC", null, null, array(
            "COLUMN_NAME",
            "ORDINAL_POSITION",
            "IS_NULLABLE",
            "DATA_TYPE",
            "CHARACTER_MAXIMUM_LENGTH",
            "CHARACTER_SET_NAME",
            "COLLATION_NAME",
            "COLUMN_KEY",
            "EXTRA",
            "COLUMN_TYPE"
        ))->getResult();

        if ($get_field_only)
        {
            $fields     = array_map(function ($field) {
                return $field->COLUMN_NAME;
            }, $fields);
        }
        else
        {
            $fields     = array_map(function ($field) {


                $type   = $this->utils->search_array($this->_field_type, "value", $field->DATA_TYPE, true);
                $type   = !empty($this->_field_type[$type]) ? $this->_field_type[$type] : array();

                if (!empty($type["group"]) && $type["group"] == "Numeric")
                {
                    $column_type    = $field->COLUMN_TYPE;
                    $column_type    = explode("(", $column_type);

                    $field->CHARACTER_MAXIMUM_LENGTH    = str_ireplace(")", "", $column_type[1]);
                }
                return $field;
            }, $fields);
        }

        return $fields;
    }

    // Master Data Manipulation
    public function get_master($conditions  = array(), $single = false)
    {
        $new_condition  = array();
        foreach ($conditions as $key => $condition)
        {
            $new_condition[self::TABLE_MASTER.".".$key] = $condition;
        }

        $master_table   = $this->general->get_data(self::TABLE_MASTER, $new_condition, "label", "ASC", null, null, array(
            self::TABLE_MASTER.".*",
        ));

        if ($single)
        {
            $master_table   = $master_table->getRow();

            if (!empty($master_table))
            {

                $master_table->hash             = empty($master_table->id) ? "" : $this->encryptlib->encode($master_table->id);
                $master_table->sources          = $this->get_master_sources($master_table->id);
                $master_table->fields           = $this->get_master_field(array(
                    self::TABLE_FIELDS.".id_master"  => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $master_table->id
                    )
                ), false, $master_table->sources);
                $master_table->fields_datatable = $this->rebuilt_fields("datatable", $master_table->fields);
                $master_table->fields_form      = $this->rebuilt_fields("form", $master_table->fields);

                $master_table->other            = @json_decode($master_table->other, 1);
                $master_table->other            = empty($master_table->other) ? array() : $master_table->other;

                if (empty($master_table->other["datatable"]["type"])){
                    $master_table->other["datatable"]["type"]       = DATATABLE_TYPE_TABLE;
                }
                if (empty($master_table->other["datatable"]["protocol"])){
                    $master_table->other["datatable"]["protocol"]    = DATATABLE_GET;
                }
                $master_table->type             = $master_table->other["datatable"]["type"];


                $groups                         = $this->get_fields_groups($master_table);
                $master_table->groups           = $groups;

                $master_table                   = $this->rebuilt_master($master_table);
            }
        }
        else
        {
            $master_table   = $master_table->getResult();
            $master_table   = array_map(function ($master) {
                $master->hash               = empty($master->id) ? "" : $this->encryptlib->encode($master->id);
                $master->sources            = $this->get_master_sources($master->id);
                $master->fields             = $this->get_master_field(array(
                    self::TABLE_FIELDS.".id_master"  => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $master->id
                    )
                ), false, $master->sources);

                $master->fields_datatable   = $this->rebuilt_fields("datatable", $master->fields);
                $master->fields_form        = $this->rebuilt_fields("form", $master->fields);

                $master->other              = @json_decode($master->other, 1);
                $master->other              = empty($master->other) ? array() : $master->other;
                $master->modules            = $master->modules;
                $master->modules_code       = $master->modules_code;
                $master->modules_name       = $master->modules_name;

                $groups                     = $this->get_fields_groups($master);

                $master->groups             = $groups;
                $master                     = $this->rebuilt_master($master);

                return $master;
            }, $master_table);
        }

        return $master_table;
    }
    public function get_master_sources($id_master = "")
    {
        $sources  = $this->general->get_data(self::TABLE_SOURCES, array(
            "id_master" => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $id_master
            )
        ), "position", "ASC")->getResult();
        $sources  = array_map(function ($source, $key) {

            $source->hash           = $this->encryptlib->encode($source->id);
            $source->conditions     = !empty($source->conditions) ? json_decode($source->conditions, 1) : array();
            $source->tmp_fields     = $this->get_db_fields($source->table_name, true);

            return $source;
        }, $sources, array_keys($sources));

        return $sources;

    }

    // Master Field
    public function get_master_field($conditions = array(), $is_single = false, $sources = array())
    {
        if (empty($conditions)){
            return false;
        }
        $master_fields  = $this->general->get_data(self::TABLE_FIELDS, $conditions, "position", "ASC", null, null, array(
            self::TABLE_FIELDS.".*",
            self::TABLE_SOURCES.".table_primary",
            self::TABLE_SOURCES.".table_name",
            self::TABLE_SOURCES.".table_alias",
        ), array(
            array(
                "table"     => self::TABLE_SOURCES,
                "condition" => self::TABLE_SOURCES.".id = ".self::TABLE_FIELDS.".id_source",
                "type"      => "LEFT"
            )
        ));

        if ($is_single)
        {
            $master_fields  = $master_fields->getRow();
            $master_fields  = $this->generate_master_field($master_fields, $sources);
        }
        else
        {
            $master_fields  = $master_fields->getResult();
            $master_fields  = array_map(function ($fields) use ($sources) {

                $fields = $this->generate_master_field($fields, $sources);

                return $fields;
            }, $master_fields);

        }

        return $master_fields;
    }
    public function generate_master_field($fields = array(), $sources = array())
    {
        $result = array();
        $result = (object) $result;

        $datatable              = @json_decode($fields->datatable);
        $form                   = @json_decode($fields->form);
        $other                  = @json_decode($fields->other, 1);
        $datatable              = empty($datatable) ? (object) array() : $datatable;
        $form                   = empty($form) ? (object) array() : $form;
        $other                  = empty($other) ? array() : $other;

        if ($fields->type === DATA_TYPE_ID)
        {
            $datatable->label   = !empty($datatable->label) ? $datatable->label : strtoupper($fields->field);
            $form->label        = !empty($form->label) ? $form->label : strtoupper($fields->field);
        }

        $result->hash           = $this->encryptlib->encode($fields->id);
        $result->table_name     = $fields->table_name;
        $result->table_alias    = $fields->table_alias;
        $result->id_source      = $fields->id_source;
        $result->source         = $fields->source;
        $result->name           = $fields->name;
        $result->field          = $fields->field;
        $result->type           = $fields->type;
        $result->datatable      = (object) array(
            "render"        => !empty($datatable->render) ? true : false,
            "label"         => !empty($datatable->label) ? $datatable->label : $fields->name,
            "position"      => !empty($datatable->position) ? $datatable->position : null,
            "filter"        => !empty($datatable->filter) ? $datatable->filter : false,
            "sort"          => !empty($datatable->sort) ? true : false,
            "width"         => !empty($datatable->width) ? $datatable->width : "",
            "align"         => !empty($datatable->align) ? $datatable->align : "",
            "halign"        => !empty($datatable->halign) ? $datatable->halign : "",
            "class_th"      => !empty($datatable->class_th) ? $datatable->class_th : "",
            "class_td"      => !empty($datatable->class_td) ? $datatable->class_td : "",
            "wrap"          => !empty($datatable->wrap) ? true : false,
            "cut_string"    => !empty($datatable->cut_string) ? true : false,
        );
        $result->form           = (object) array(
            "render"                => !empty($form->render) ? true : false,
            "label"                 => !empty($form->label) ? $form->label : (!empty($datatable->label) ? $datatable->label : $fields->name),
            "position"              => !empty($form->position) ? $form->position : null,
            "class_container"       => !empty($form->class_container) ? $form->class_container : "",
            "class_element"         => !empty($form->class_element) ? $form->class_element : "",
            "default_value_type"    => !empty($form->default_value_type) ? $form->default_value_type : "",
            "default_value"         => isset($form->default_value) ? $form->default_value : "",
            "note"                  => !empty($form->note) ? $form->note : "",
            "validation"            => !empty($form->validation) ? (array) $form->validation : array(),
        );

        $result->label          = !empty($result->datatable->label) ? $result->datatable->label : (!empty($result->form->label) ? $result->form->label : $result->name);

        $result->other          = $other;

        if (in_array($result->type, $this->_master_field_group["field_single_join"]) || in_array($result->type, $this->_master_field_group["field_multi_join"]))
        {
            $tmp_source     = !empty($result->other["source"]) ? $result->other["source"] : array();

            if (!empty($sources) && !empty($tmp_source))
            {
                $field_source   = $this->utils->search_array($sources, "id", $result->other["source"]["id"], false, true);

                if (!empty($field_source["data"]))
                {
                    $field_source   = $field_source["data"];
                    $tmp_source["field_show"]       = !empty($tmp_source["field_show"]) ? $tmp_source["field_show"] : array();
                    $tmp_source["primary_key"]      = !empty($tmp_source["primary_key"]) ? $tmp_source["primary_key"] : array();

                    $query_select       = array_merge($tmp_source["field_show"], array($field_source["primary_key"]));
                    $query_select       = array_filter($query_select);
                    $conditions         = !empty($field_source["conditions"]) ? $field_source["conditions"] : array();

                    $query_conditions   = array();

                    foreach ($conditions as $condition)
                    {
                        if ($condition["type"] == "text")
                        {
                            $query_conditions[$field_source["table_name"].".".$condition["field"]] = array(
                                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                                SQL_CONDITION_VALUE     => $condition["value"]
                            );
                        }
                        else if ($condition["type"] == "user")
                        {
                            $value  = $condition["value"];
                            $user   = $this->_user;

                            if (isset($user->filter[$value]["value"]))
                            {
                                $query_conditions[$field_source["table_name"].".".$condition["field"]] = array(
                                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                                    SQL_CONDITION_VALUE     => $user->filter[$value]["value"]
                                );
                            }

                        }
                        else if ($condition["type"] == "query")
                        {
                            $query_conditions[$field_source["table_name"].".".$condition["field"]] = array(
                                SQL_CONDITION_OPERATOR  => SQL_CONDITION_QUERY,
                                SQL_CONDITION_VALUE     => $condition["value"]
                            );
                        }
                    }

                    $tmp_source["field_order"]  = !empty($tmp_source["field_order"]) ? $tmp_source["field_order"] : "";

                    if ($result->type == DATA_TYPE_SELECT_MASTER_TREE)
                    {
                        $query_select[] = "id_parent";
                    }

                    if (!empty($field_source["table_name"]))
                    {
                        $tmp_data           = $this->general->get_data($field_source["table_name"], $query_conditions, $tmp_source["field_order"], "ASC", null, null, $query_select)->getResult();
                    }
                    else
                    {
                        $tmp_data           = array();
                    }

                    $source             = array(
                        "id"            => $tmp_source["id"],
                        "field_key"     => $field_source["primary_key"],
                        "field_label"   => !empty($tmp_source["field_label"]) ? $tmp_source["field_label"] : "",
                        "field_show"    => !empty($tmp_source["field_show"]) ? $tmp_source["field_show"] : "",
                        "field_order"   => !empty($tmp_source["field_order"]) ? $tmp_source["field_order"] : "",
                        "data"          => $tmp_data
                    );

                    $result->other["source"]    = $source;
                }

            }
        }

        if ($result->type == DATA_TYPE_SELECT_TAGS && !empty($result->id_source))
        {
            $source_tags            = $this->utils->search_array($sources, "id", $result->id_source, false, true);

            if (!empty($source_tags["data"]))
            {
                $field_name = $result->field;
                $tmp_data   = $source_tags["data"];
                $tmp_data   = $this->general->get_data($tmp_data["table_name"], array(), null, null, null, null, array(
                    "DISTINCT(TRIM(`".$field_name."`)) AS 'tmp'"
                ))->getResult();
                $tmp_data   = array_map(function ($item) {
                    return $item->tmp;
                }, $tmp_data);

                sort($tmp_data);
                $result->other["list"]      = $tmp_data;
            }
        }

        return $result;


    }
    public function rebuilt_fields($type, $fields)
    {
        $tmp_fields = array();

        foreach ($fields as $field)
        {
            if ($field->$type->render)
            {
                $field->tmp_position    = $field->$type->position;
                $tmp_fields[]   = $field;
            }
        }

        usort($tmp_fields, function($a, $b) {
            return (int)(!empty($a->tmp_position) ? $a->tmp_position : 0) - (!empty($b->tmp_position) ? $b->tmp_position : 0);
        });

        $tmp_fields     = array_map(function ($fields) {

            unset($fields->tmp_position);

            return $fields;
        }, $tmp_fields);

        if ($type == "datatable")
        {
            $field_action   = (object) array(
                "hash"          => "",
                "name"          => DATA_TYPE_ACTION,
                "type"          => DATA_TYPE_ACTION,
                "field"         => DATA_TYPE_ACTION,
                "datatable"     => (object) array(
                    "render"    => true,
                    "label"     => "Action",
                    "filter"    => false,
                    "sort"      => false,
                    "width"     => 40,
                    "halign"    => "center",
                    "align"     => "center",
                    "class_th"  => "",
                    "class_td"  => "",
                ),
            );
            array_unshift($tmp_fields, $field_action);
        }

        return $tmp_fields;
    }

    public function get_fields_groups($master)
    {
        $groups     = !empty($master->other["groups"]) ? $master->other["groups"] : array();
        $result     = array(
            "source"    => array(),
            "target"    => array(),
            "list"      => $groups,
        );

        foreach ($groups as $item)
        {
            if (!in_array($item["condition"]["field"], $result["source"])){
                $result["source"][]     = $item["condition"]["field"];
            }

            foreach ($item["active"] as $active)
            {
                if (!in_array($active, $result["target"])){
                    $result["target"][] = $active;
                }
            }
        }

        return $result;
    }
    public function rebuilt_master($master)
    {
        $groups                 = !empty($master->groups) ? $master->groups : array();
        $fields_datatable       = $master->fields_datatable;
        $fields_form            = $master->fields_form;

        if (!empty($groups["list"]))
        {
            $new_fields_datatable   = array();
            $new_fields_form        = array();

            foreach ($fields_datatable as $item)
            {
                if (!in_array($item->name, $groups["target"]))
                {
                    $new_fields_datatable[]  = $item;
                }
            }
            foreach ($fields_form as $item)
            {
                if (!in_array($item->name, $groups["target"])){
                    $new_fields_form[]  = $item;
                }
            }
            foreach ($new_fields_form as $i => $item)
            {
                if (in_array($item->name, $groups["source"]))
                {
                    $new_fields_form[$i]->form->class_container    = $item->form->class_container." el-term-conditions";
                }
            }
        }
        else
        {
            $new_fields_datatable   = $fields_datatable;
            $new_fields_form        = $fields_form;
        }



        $master->fields_datatable   = $new_fields_datatable;
        $master->fields_form        = $new_fields_form;
        $master->type               = !empty($master->other["datatable"]["type"]) ? $master->other["datatable"]["type"] : DATATABLE_TYPE_TABLE;

        return $master;
    }

    public function reset_session_datatable($id_master = "")
    {
        $master         = $this->get_master(array(
            "id"  => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $id_master
            )
        ), true);

        if (!empty($master))
        {
            /*$this->_CI->session->unset_userdata("session-datatable-".$master->name);*/
        }
    }
}