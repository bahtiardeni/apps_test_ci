<?php
namespace App\Libraries;
use CodeIgniter\Files\File;
use Config\Session;
use App\Models\GeneralModel;
use App\Libraries\Utils;
use App\Libraries\Template;
/**
 * Class Datatable
 *
 *  Model
 * @property General_model $general
 *
 *  Library
 * @property Session        $session
 * @property File           $file
 */
class Datatable
{
    public $_configs;
    public $_initial;
    public $_forms;
    public $_list_icons;
    public $_field_system;
    public $_field_type_select_key;
    public $_field_type_joins;
    public $_item_edit;
    public $_user;
    public $_limit_text_length;

    public $_controller;
    public $_method;

    function __construct()
    {
        $this->_initial = (object)[];
        $this->_forms   = array();

        $this->session      = \Config\Services::session();
        $this->general      = new GeneralModel();
        $this->encryptlib   = new EncryptLib();
        $this->utils        = new Utils();
        $this->template     = new Template();

        $this->masterlib    = new MasterLib();
        $this->formlib      = new Formlib();
        $this->filelib      = new Filelib();

        $this->helpers      = ['form', 'url'];
        $this->validation   = \Config\Services::validation();


        $filter = !empty($_REQUEST["q"]) ? $_REQUEST["q"] : array();

        if (!empty($filter["filters"]) && !is_array($filter["filters"])){
            $filter["filters"]  = json_decode($filter["filters"], 1);
        }

        $this->template->data["filter"] = $filter;

        $this->_list_icons      = array(
            "Web App Icon"      => array("fa fa-adjust","fa fa-anchor","fa fa-archive","fa fa-arrows","fa fa-arrows-h","fa fa-arrows-v","fa fa-asterisk","fa fa-ban","fa fa-bar-chart-o","fa fa-barcode","fa fa-bars","fa fa-beer","fa fa-bell","fa fa-bell-o","fa fa-bolt","fa fa-book","fa fa-bookmark","fa fa-bookmark-o","fa fa-briefcase","fa fa-bug","fa fa-building-o","fa fa-bullhorn","fa fa-bullseye","fa fa-calendar","fa fa-calendar-o","fa fa-camera","fa fa-camera-retro","fa fa-caret-square-o-down","fa fa-caret-square-o-left","fa fa-caret-square-o-right","fa fa-caret-square-o-up","fa fa-certificate","fa fa-check","fa fa-check-circle","fa fa-check-circle-o","fa fa-check-square","fa fa-check-square-o","fa fa-circle","fa fa-circle-o","fa fa-clock-o","fa fa-cloud","fa fa-cloud-download","fa fa-cloud-upload","fa fa-code","fa fa-code-fork","fa fa-coffee","fa fa-cog","fa fa-cogs","fa fa-comment","fa fa-comment-o","fa fa-comments","fa fa-comments-o","fa fa-compass","fa fa-credit-card","fa fa-crop","fa fa-crosshairs","fa fa-cutlery","fa fa-dashboard","fa fa-desktop","fa fa-dot-circle-o","fa fa-download","fa fa-edit","fa fa-ellipsis-h","fa fa-ellipsis-v","fa fa-envelope","fa fa-envelope-o","fa fa-eraser","fa fa-exchange","fa fa-exclamation","fa fa-exclamation-circle","fa fa-exclamation-triangle","fa fa-external-link","fa fa-external-link-square","fa fa-eye","fa fa-eye-slash","fa fa-female","fa fa-fighter-jet","fa fa-film","fa fa-filter","fa fa-fire","fa fa-fire-extinguisher","fa fa-flag","fa fa-flag-checkered","fa fa-flag-o","fa fa-flash","fa fa-flask","fa fa-folder","fa fa-folder-o","fa fa-folder-open","fa fa-folder-open-o","fa fa-frown-o","fa fa-gamepad","fa fa-gavel","fa fa-gear","fa fa-gears","fa fa-gift","fa fa-glass","fa fa-globe","fa fa-group","fa fa-hdd-o","fa fa-headphones","fa fa-heart","fa fa-heart-o","fa fa-home","fa fa-inbox","fa fa-info","fa fa-info-circle","fa fa-key","fa fa-keyboard-o","fa fa-laptop","fa fa-leaf","fa fa-legal","fa fa-lemon-o","fa fa-level-down","fa fa-level-up","fa fa-lightbulb-o","fa fa-location-arrow","fa fa-lock","fa fa-magic","fa fa-magnet","fa fa-mail-forward","fa fa-mail-reply","fa fa-mail-reply-all","fa fa-male","fa fa-map-marker","fa fa-meh-o","fa fa-microphone","fa fa-microphone-slash","fa fa-minus","fa fa-minus-circle","fa fa-minus-square","fa fa-minus-square-o","fa fa-mobile","fa fa-mobile-phone","fa fa-money","fa fa-moon-o","fa fa-music","fa fa-pencil","fa fa-pencil-square","fa fa-pencil-square-o","fa fa-phone","fa fa-phone-square","fa fa-picture-o","fa fa-plane","fa fa-plus","fa fa-plus-circle","fa fa-plus-square","fa fa-plus-square-o","fa fa-power-off","fa fa-print","fa fa-puzzle-piece","fa fa-qrcode","fa fa-question","fa fa-question-circle","fa fa-quote-left","fa fa-quote-right","fa fa-random","fa fa-refresh","fa fa-reply","fa fa-reply-all","fa fa-retweet","fa fa-road","fa fa-rocket","fa fa-rss","fa fa-rss-square","fa fa-search","fa fa-search-minus","fa fa-search-plus","fa fa-share","fa fa-share-square","fa fa-share-square-o","fa fa-shield","fa fa-shopping-cart","fa fa-sign-in","fa fa-sign-out","fa fa-signal","fa fa-sitemap","fa fa-smile-o","fa fa-sort","fa fa-sort-alpha-asc","fa fa-sort-alpha-desc","fa fa-sort-amount-asc","fa fa-sort-amount-desc","fa fa-sort-asc","fa fa-sort-desc","fa fa-sort-down","fa fa-sort-numeric-asc","fa fa-sort-numeric-desc","fa fa-sort-up","fa fa-spinner","fa fa-square","fa fa-square-o","fa fa-star","fa fa-star-half","fa fa-star-half-empty","fa fa-star-half-full","fa fa-star-half-o","fa fa-star-o","fa fa-subscript","fa fa-suitcase","fa fa-sun-o","fa fa-superscript","fa fa-tablet","fa fa-tachometer","fa fa-tag","fa fa-tags","fa fa-tasks","fa fa-terminal","fa fa-thumb-tack","fa fa-thumbs-down","fa fa-thumbs-o-down","fa fa-thumbs-o-up","fa fa-thumbs-up","fa fa-ticket","fa fa-times","fa fa-times-circle","fa fa-times-circle-o","fa fa-tint","fa fa-toggle-down","fa fa-toggle-left","fa fa-toggle-right","fa fa-toggle-up","fa fa-trash-o","fa fa-trophy","fa fa-truck","fa fa-umbrella","fa fa-unlock","fa fa-unlock-alt","fa fa-unsorted","fa fa-upload","fa fa-user","fa fa-users","fa fa-video-camera","fa fa-volume-down","fa fa-volume-off","fa fa-volume-up","fa fa-warning","fa fa-wheelchair","fa fa-wrench",),
            "Currency Icon"     => array("fa fa-bitcoin","fa fa-btc","fa fa-cny","fa fa-dollar","fa fa-eur","fa fa-euro","fa fa-gbp","fa fa-inr","fa fa-jpy","fa fa-krw","fa fa-money","fa fa-rmb","fa fa-rouble","fa fa-rub","fa fa-ruble","fa fa-rupee","fa fa-try","fa fa-turkish-lira","fa fa-usd","fa fa-won","fa fa-yen",),
            "Text Editor Icon"  => array("fa fa-align-center","fa fa-align-justify","fa fa-align-left","fa fa-align-right","fa fa-bold","fa fa-chain","fa fa-chain-broken","fa fa-clipboard","fa fa-columns","fa fa-copy","fa fa-cut","fa fa-dedent","fa fa-eraser","fa fa-file","fa fa-file-o","fa fa-file-text","fa fa-file-text-o","fa fa-files-o","fa fa-floppy-o","fa fa-font","fa fa-indent","fa fa-italic","fa fa-link","fa fa-list","fa fa-list-alt","fa fa-list-ol","fa fa-list-ul","fa fa-outdent","fa fa-paperclip","fa fa-paste","fa fa-repeat","fa fa-rotate-left","fa fa-rotate-right","fa fa-save","fa fa-scissors","fa fa-strikethrough","fa fa-table","fa fa-text-height","fa fa-text-width","fa fa-th","fa fa-th-large","fa fa-th-list","fa fa-underline","fa fa-undo","fa fa-unlink",),
            "Direction Icon"    => array("fa fa-angle-double-down","fa fa-angle-double-left","fa fa-angle-double-right","fa fa-angle-double-up","fa fa-angle-down","fa fa-angle-left","fa fa-angle-right","fa fa-angle-up","fa fa-arrow-circle-down","fa fa-arrow-circle-left","fa fa-arrow-circle-o-down","fa fa-arrow-circle-o-left","fa fa-arrow-circle-o-right","fa fa-arrow-circle-o-up","fa fa-arrow-circle-right","fa fa-arrow-circle-up","fa fa-arrow-down","fa fa-arrow-left","fa fa-arrow-right","fa fa-arrow-up","fa fa-arrows","fa fa-arrows-alt","fa fa-arrows-h","fa fa-arrows-v","fa fa-caret-down","fa fa-caret-left","fa fa-caret-right","fa fa-caret-square-o-down","fa fa-caret-square-o-left","fa fa-caret-square-o-right","fa fa-caret-square-o-up","fa fa-caret-up","fa fa-chevron-circle-down","fa fa-chevron-circle-left","fa fa-chevron-circle-right","fa fa-chevron-circle-up","fa fa-chevron-down","fa fa-chevron-left","fa fa-chevron-right","fa fa-chevron-up","fa fa-hand-o-down","fa fa-hand-o-left","fa fa-hand-o-right","fa fa-hand-o-up","fa fa-long-arrow-down","fa fa-long-arrow-left","fa fa-long-arrow-right","fa fa-long-arrow-up","fa fa-toggle-down","fa fa-toggle-left","fa fa-toggle-right","fa fa-toggle-up",),
            "Video Player Icon" => array("fa fa-arrows-alt","fa fa-backward","fa fa-compress","fa fa-eject","fa fa-expand","fa fa-fast-backward","fa fa-fast-forward","fa fa-forward","fa fa-pause","fa fa-play","fa fa-play-circle","fa fa-play-circle-o","fa fa-step-backward","fa fa-step-forward","fa fa-stop","fa fa-youtube-play",),
            "Brand Icon"        => array("fa fa-adn","fa fa-android","fa fa-apple","fa fa-bitbucket","fa fa-bitbucket-square","fa fa-bitcoin","fa fa-btc","fa fa-css3","fa fa-dribbble","fa fa-dropbox","fa fa-facebook","fa fa-facebook-square","fa fa-flickr","fa fa-foursquare","fa fa-github","fa fa-github-alt","fa fa-github-square","fa fa-gittip","fa fa-google-plus","fa fa-google-plus-square","fa fa-html5","fa fa-instagram","fa fa-linkedin","fa fa-linkedin-square","fa fa-linux","fa fa-maxcdn","fa fa-pagelines","fa fa-pinterest","fa fa-pinterest-square","fa fa-renren","fa fa-skype","fa fa-stack-exchange","fa fa-stack-overflow","fa fa-trello","fa fa-tumblr","fa fa-tumblr-square","fa fa-twitter","fa fa-twitter-square","fa fa-vimeo-square","fa fa-vk","fa fa-weibo","fa fa-windows","fa fa-xing","fa fa-xing-square","fa fa-youtube","fa fa-youtube-play","fa fa-youtube-square",),
            "Medical Icon"      => array("fa fa-ambulance","fa fa-h-square","fa fa-hospital-o","fa fa-medkit","fa fa-plus-square","fa fa-stethoscope","fa fa-user-md","fa fa-wheelchair",),
        );
        $this->_field_system    = array(
            "created",
            "updated",
        );

        $this->_field_type_select_key       = array(
            DATA_TYPE_SELECT_LIST_KEY,
            DATA_TYPE_RADIO_KEY,
            DATA_TYPE_RADIO_KEY_HORIZONTAL,
            DATA_TYPE_CUSTOM_RADIO_KEY,
        );
        $this->_field_type_joins            = array(
            DATA_TYPE_SELECT_MASTER,
            DATA_TYPE_SELECT_MASTER_TREE,
            DATA_TYPE_RADIO_MASTER,
            DATA_TYPE_MULTISELECT_MASTER,
            DATA_TYPE_CHECKBOX_MASTER,
            DATA_TYPE_CUSTOM_CHECKBOX_MASTER,
            DATA_TYPE_CUSTOM_RADIO_MASTER,
        );
        $this->_user                        = $this->session->get("_user");
        $this->_configs                     = $this->session->get("_configs");
        $this->_item_edit                   = (object) [];
        $this->_limit_text_length           = 50;


        $router                 = service('router');
        $this->_controller      = $router->controllerName();
        $this->_controller      = explode("\\", $this->_controller);
        $this->_controller      = $this->_controller[(count($this->_controller) - 1)];
        $this->_method           = $router->methodName();
    }

    public function get($param, $type = 1, $escape = false, $get_all = false)
    {
        $datatable_type     = !empty($param["datatable_type"]) ? $param["datatable_type"] : $this->_initial->type;

        if ($datatable_type == DATATABLE_TYPE_TABLE)
        {
            $result     = $this->get_data($param, $type, $escape, $get_all);
        }
        else if ($datatable_type == DATATABLE_TYPE_TREE)
        {
            $result     = $this->get_tree($param, $type, $escape, $get_all);
        }

        return $result;
    }
    public function get_data($param, $type = 1, $escape = false, $get_all = false)
    {
        $draw		= !empty($param["draw"]) ? (int)$param["draw"] : 1;
        $columns	= !empty($param["columns"]) ? $param["columns"] : array();
        $orders     = !empty($param["orders"][0]) && is_array($param["orders"][0]) ? $param["orders"][0] : array();
        $start      = !empty($param["start"]) ? $param["start"] : 0;
        $length     = !empty($param["length"]) ? $param["length"] : 10;

        if ($get_all)
        {
            $start  = null;
            $length = null;
        }

        $datatable_sort             = array_key_exists("column", $orders) ? $orders["column"] : "created";
        $datatable_sort_type	    = !empty($orders["dir"]) ? $orders["dir"] : "desc";
        $datatable_searchs          = array();
        $query_selects              = !empty($param["selects"]) ? $param["selects"] : array();
        $query_selects_key          = array(
            $this->_initial->table_alias.".".$this->_initial->field_primary
        );
        $query_joins_tmp            = $this->set_query_join();
        $query_joins                = $query_joins_tmp["joins"];
        $query_conditions_source    = $query_joins_tmp["conditions"];

        $conditions                 = !empty($param["conditions"]) ? $param["conditions"] : array();
        $conditions                 = array_merge($conditions, $query_conditions_source);

        $query_conditions           = $conditions;
        $query_conditions_count     = $conditions;

        $tmp_field_sort             = !empty($this->_initial->fields_datatable[$datatable_sort]) ? $this->_initial->fields_datatable[$datatable_sort] : "";
        $query_sort                 = !empty($tmp_field_sort->table_alias) ? $tmp_field_sort->table_alias.".".$tmp_field_sort->field : "";
        $query_sort                 = $this->set_query_select_conditions("query_conditions", array(), $datatable_sort);

        /*var_dump($query_sort);
        die;*/

        $query_sort_type            = $datatable_sort_type;

        // Search Condition in Column Filter
        foreach ($columns as $key_column => $column)
        {
            if ($column["search"]["value"] != "")
            {
                $datatable_searchs[$column["name"]] = $column["search"]["value"];
            }
        }

        $datatable_searchs  = $this->set_query_select_conditions("query_conditions", $datatable_searchs);
        $query_conditions   = array_merge($query_conditions, $datatable_searchs);

        $data	        = $this->general->get_data($this->_initial->table_name." ".$this->_initial->table_alias, $query_conditions, $query_sort, $query_sort_type, $start, $length, $query_selects_key, $query_joins/*, array(), null, true*/)->getResult();
        $query_data     = $this->general->getLastQuery();

        $datatable      = array();

        foreach($data as $item_data)
        {
            $primary_key    = $this->_initial->field_primary;

            if ($type == 1)
            {
                $datatable[]    = $this->get_detail($item_data->$primary_key, "datatable", $escape);
            }
            else if ($type == 2)
            {
                $datatable[]    = $this->get_detail($item_data->$primary_key, "datatable-field", $escape);
            }
            else if ($type == 3)
            {
                $datatable[]    = $this->get_detail($item_data->$primary_key, "export", $escape);

            }
        }

        $count 	        = $this->general->get_data($this->_initial->table_name." ".$this->_initial->table_alias, $query_conditions_count, null, null, null, null, array("COUNT(".$this->_initial->table_alias.".".$this->_initial->field_primary.") as count_data"), $query_joins, array(), $escape)->getRow()->count_data;
        $query_count    = $this->general->getLastQuery();
        $filtered 	    = $this->general->get_data($this->_initial->table_name." ".$this->_initial->table_alias, $query_conditions, null, null, null, null, array("COUNT(".$this->_initial->table_alias.".".$this->_initial->field_primary.") as count_data"), $query_joins, array(), $escape)->getRow()->count_data;
        $query_filter   = $this->general->getLastQuery();

        $other  = array();
        if (ENVIRONMENT == "development"){
            $other  = array(
                "conditions"    => $query_conditions,
                "query_data"    => $query_data,
                "query_count"   => $query_count,
                "query_filter"  => $query_filter,
            );
        }

        $result     = array(
            "data"              => $datatable,
            "recordsTotal"      => (int)$count,
            "recordsFiltered"   => (int)$filtered,
            "draw"              => $draw,
            "other"             => $other
        );
        return $result;
    }
    public function get_tree($param, $type = 1, $escape = false, $get_all = false)
    {
        $id             = !empty($_REQUEST["id"]) ? $_REQUEST["id"] : "";
        $page           = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : "";
        $length         = !empty($_REQUEST["rows"]) ? $_REQUEST["rows"] : "";
        $sort           = !empty($_REQUEST["sort"]) ? $_REQUEST["sort"] : "";
        $order          = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : "";
        $conditions     = !empty($param["conditions"]) ? $param["conditions"] : array();
        $filterRules    = !empty($_REQUEST["filterRules"]) ? $_REQUEST["filterRules"] : "";
        $filterRules    = !empty($filterRules) ? json_decode($filterRules, true) : array();

        $start          = ($page - 1) * $length;

        if (!empty($this->_initial->other["datatable"]["tree_all"]))
        {
            $get_all    = true;
            $start      = null;
            $length     = null;
        }

        $field_parent   = !empty($this->_initial->other["datatable"]["tree_parent"]) ? $this->_initial->other["datatable"]["tree_parent"] : "";
        $field_key      = $this->_initial->field_primary;

        $sort_search                = $this->utils->search_array($this->_initial->fields_datatable, "name", $sort, false, true);
        $datatable_sort             = !empty($sort_search["key"]) ? $sort_search["key"] : (!empty($this->_initial->other["datatable"]["table_sort"]) ? $this->_initial->other["datatable"]["table_sort"] : "");
        $datatable_sort_type	    = $order;
        $query_selects_key          = array(
            $this->_initial->table_alias.".".$this->_initial->field_primary,
            $this->_initial->table_alias.".".$field_parent
        );
        $query_joins_tmp            = $this->set_query_join();
        $query_joins                = $query_joins_tmp["joins"];
        $query_conditions_source    = $query_joins_tmp["conditions"];

        $query_conditions           = $query_conditions_source;
        $query_conditions_count     = $query_conditions_source;
        $query_conditions           = array_merge($conditions, $query_conditions);

        $datatable_searchs          = array();
        // Search Condition in Column Filter
        foreach ($filterRules as $i => $column)
        {
            if ($column["value"] != "")
            {
                $datatable_searchs[$column["field"]] = $column["value"];
            }
        }

        $datatable_searchs  = $this->set_query_select_conditions("query_conditions", $datatable_searchs);
        $query_conditions   = array_merge($query_conditions, $datatable_searchs);

        $tmp_field_sort             = !empty($this->_initial->fields_datatable[$datatable_sort]) ? $this->_initial->fields_datatable[$datatable_sort] : "";
        $query_sort                 = !empty($tmp_field_sort->table_alias) ? $tmp_field_sort->table_alias.".".$tmp_field_sort->field : "";
        $query_sort                 = $this->set_query_select_conditions("query_conditions", array(), $datatable_sort);
        $query_sort_type            = $datatable_sort_type;
        $query_child                = $query_conditions;

        if (!empty($field_parent) && !$get_all)
        {
            if (empty($id))
            {
                $query_conditions[$this->_initial->table_alias.".".$field_parent]   = array(
                    SQL_CONDITION_OPERATOR  => SQL_CONDITION_QUERY,
                    SQL_CONDITION_VALUE     => " (".$this->_initial->table_alias.".".$field_parent." IS NULL OR ".$this->_initial->table_alias.".".$field_parent." = '' OR ".$this->_initial->table_alias.".".$field_parent." = '0') "
                );
            }
            else
            {
                $query_conditions[$this->_initial->table_alias.".".$field_parent]   = array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                    SQL_CONDITION_VALUE     => $id
                );

                $start  = null;
                $length = null;
            }
        }

        $data	        = $this->general->get_data($this->_initial->table_name." ".$this->_initial->table_alias, $query_conditions, $query_sort, $query_sort_type, $start, $length, $query_selects_key, $query_joins, array())->getResult();
        $query_data     = $this->general->getLastQuery();
        $count          = $this->general->get_data($this->_initial->table_name." ".$this->_initial->table_alias, $query_conditions, $query_sort, $query_sort_type, null, null, array(
            "COUNT(".($this->_initial->table_alias.".".$this->_initial->field_primary).") AS count"
        ), $query_joins)->getRow()->count;

        $datatable      = array();
        $built_tree     = false;

        foreach($data as $i => $item_data)
        {
            $primary_key    = $this->_initial->field_primary;

            if (is_numeric($item_data->$primary_key)){
                $escape     = false;
            } else {
                $escape     = true;
            }

            $tmp_data       = $this->get_detail($item_data->$primary_key, "datatable-field", $escape);
            $data_view      = $tmp_data["data"];
            $data_source    = $tmp_data["source"];
            $data_original  = $tmp_data["original"];

            $data_tmp       = array();

            foreach ($tmp_data["data"] as $tmp)
            {
                $data_tmp[$tmp["field"]]    = $tmp["value"];
            }

            $state              = "open";

            if (!empty($field_parent) && !$get_all)
            {
                if (property_exists($data_original, $field_parent) && property_exists($data_original, $field_key))
                {
                    $data_tmp[$field_key]       = $data_original->$field_key;
                    $data_tmp[$field_parent]    = $data_original->$field_parent;
                    $built_tree                 = true;
                }

                $query_child[$this->_initial->table_alias.".".$field_parent]    = array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                    SQL_CONDITION_VALUE     => $item_data->$primary_key
                );

                $check_child        = $this->general->get_data($this->_initial->table_name." ".$this->_initial->table_alias, $query_child, null, null, null, null, array(
                    "COUNT(".($this->_initial->table_alias.".".$primary_key).") AS count"
                ))->getRow()->count;
            }
            if (!empty($check_child)) $state    = "closed";

            $data_tmp["state"]  = $state;

            if ($get_all)
            {
                $data_tmp[$field_key]       = $item_data->$field_key;
                $data_tmp[$field_parent]    = $item_data->$field_parent;
            }
            $datatable[]        = $data_tmp;
        }

        if ($get_all)
        {
            $datatable      = $this->utils->rebuilt_tree($datatable, 0, $field_key, $field_parent);
        }
        if (!empty($id))
        {
            $result     = $datatable;
        }
        else
        {
            $result     = array(
                "rows"  => $datatable,
                "total" => $count
            );

            if (ENVIRONMENT == "development"){
                $result["other"]    = array(
                    "conditions"    => $query_conditions,
                    "query_data"    => $query_data,
                );
            }
        }
        return $result;
    }
    public function get_detail($id, $type = "datatable", $escape = false)
    {
        $query_joins    = $this->set_query_join();
        $query_joins    = $query_joins["joins"];
        $query_selects  = array();

        if ($type == "datatable" || $type == "datatable-field" || $type == "detail" || $type == "detail-field" || $type == "export" || $type == "form-detail")
        {
            $query_selects  = $this->set_query_select_conditions("query_selects", null, false, $id);
        }
        else if ($type == "form")
        {
            foreach($this->_initial->fields as $fields)
            {
                if ($fields->source == SOURCE_TYPE_FIELD)
                {
                    $query_selects[] = $fields->table_alias.".".$fields->field."" . " AS '" . $fields->name . "'";
                }
                else if ($fields->source == SOURCE_TYPE_METADATA)
                {
                    $query_selects[] = $this->generate_query_select_metadata($id, $fields);
                }

            }
        }

        $data           = $this->general->get_data($this->_initial->table_name." AS ".$this->_initial->table_alias, array(
            $this->_initial->table_alias.".".$this->_initial->field_primary => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $id
            )
        ), null, null, null, null, $query_selects, $query_joins, array(), $escape)->getRow();

        $new_data       = array();
        $primary_key    = $this->_initial->field_primary;
        $primary_key    = $this->utils->search_array($this->_initial->fields, "field", $primary_key, false, true);
        $primary_key    = !empty($primary_key["data"]["name"]) ? $primary_key["data"]["name"] : "id";

        if ($type == "datatable" || $type == "datatable-field" || $type == "detail" || $type == "detail-field" || $type == "export" || $type == "form-detail")
        {
            $fields_detail  = $this->_initial->fields_datatable;

            if ($type == "form-detail"){
                $fields_detail  = $this->_initial->fields_form;
            }

            foreach($fields_detail as $fields)
            {
                if ($type == "form-detail"){
                    $field_label    = !empty($fields->form->label) ? $fields->form->label : $fields->field;
                }else{
                    $field_label    = !empty($fields->datatable->label) ? $fields->datatable->label : $fields->field;
                }

                $field_type     = $fields->type;
                $field_name     = $fields->name;
                $item_value     = "";


                if ($field_type == DATA_TYPE_ACTION)
                {
                    $item_value     = $this->generate_button_action($data, $primary_key);
                }
                else
                {
                    if (property_exists($data, $field_name))
                    {
                        if (in_array($fields->type, $this->masterlib->_master_field_group["field_number"]) && $type != "export")
                        {
                            $item_value = $this->utils->number_format((float) $data->$field_name, ($fields->type == DATA_TYPE_NUMBER ? 0 : 2));
                        }
                        else if (in_array($fields->type, $this->masterlib->_master_field_group["field_file"]) || in_array($fields->type, $this->masterlib->_master_field_group["field_file_multiple"]))
                        {
                            $data->$field_name = explode(",", $data->$field_name);
                            $data->$field_name = array_filter($data->$field_name);

                            $item_value = $this->filelib->get_view_file($data->$field_name, $fields, FILE_VIEW_TABLE);

                        }
                        else if (in_array($fields->type, array(DATA_TYPE_DATE, DATA_TYPE_TIME, DATA_TYPE_DATETIME)))
                        {
                            if (!empty($data->$field_name))
                            {
                                if ($fields->type == DATA_TYPE_DATE)
                                {
                                    $format         = !empty($this->_configs["date_format"]["value"]) ? $this->_configs["date_format"]["value"] : "Y-m-d";
                                    $data_invalid   = "0000-00-00";
                                }
                                else if ($fields->type == DATA_TYPE_TIME)
                                {
                                    $format         = !empty($this->_configs["time_format"]["value"]) ? $this->_configs["time_format"]["value"] : "H:i:s";
                                    $data_invalid   = "";
                                }
                                else if ($fields->type == DATA_TYPE_DATETIME)
                                {
                                    $format         = !empty($this->_configs["datetime_format"]["value"]) ? $this->_configs["datetime_format"]["value"] : "Y-m-d H:i:s";
                                    $data_invalid   = "0000-00-00 00:00:00";
                                }

                                if ($data->$field_name != $data_invalid)
                                {
                                    if (!empty($format))
                                    {
                                        $item_value = date($format, strtotime($data->$field_name));
                                    }
                                    else
                                    {
                                        $item_value = $data->$field_name;
                                    }
                                }
                                else
                                {
                                    $item_value     = "";
                                }
                            }
                        }
                        else
                        {
                            $item_value = is_null($data->$field_name) ? "" : $data->$field_name;
                        }

                        if ($fields->type == DATA_TYPE_RADIO_KEY && $field_name == "status" && in_array($type, array("datatable", "detail", "detail-field")) && !empty($fields->other["list"]))
                        {
                            if ($fields->other["list"] == array(1 => "Active", 0 => "Inactive") || $fields->other["list"] == array(0 => "Inactive", 1 => "Active"))
                            {
                                if ($item_value == "Active")
                                {
                                    $item_value     = "<span class='label label-success'>".strtoupper($item_value)."</span>";
                                }
                                else if ($item_value == "Inactive")
                                {
                                    $item_value     = "<span class='label label-danger'>".strtoupper($item_value)."</span>";
                                }
                            }
                        }

                        if ($fields->source == SOURCE_TYPE_METADATA)
                        {
                            if (in_array($field_type, $this->_field_type_select_key))
                            {
                                $lists  = !empty($fields->other["list"]) ? $fields->other["list"] : array();

                                if (array_key_exists($item_value, $lists)){
                                    $item_value     = $lists[$item_value];
                                }
                            }
                        }

                        if (
                            in_array($fields->type, $this->masterlib->_master_field_group["field_text"]) &&
                            ($type == "datatable" || $type == "datatable-field") &&
                            !empty($this->_limit_text_length) &&
                            ($type == "datatable" || $type == "datatable-field") &&
                            !empty($fields->datatable->cut_string))
                        {
                            /*$text_value     = $item_value;*/
                            $item_value     = $this->utils->truncate_str($item_value, $this->_limit_text_length);
                            /*$item_value     = "<span class='tooltip-container' data-toggle='tooltip' data-original-title='".$text_value."' data-placement='top'>".$item_value."</span>";*/
                        }
                    }
                    else
                    {
                        $item_value = "";
                    }
                }

                if ($type == "datatable")
                {
                    $new_data[] = $item_value;
                }
                else if ($type == "datatable-field")
                {
                    $new_data["data"][] = array(
                        "field" => $field_name,
                        "value" => $item_value,
                    );
                }
                else if ($type == "detail")
                {
                    if ($field_type != DATA_TYPE_ACTION)
                    {
                        $new_data["data"][] = array(
                            "label" => $field_label,
                            "field" => $field_name,
                            "value" => $item_value,
                        );
                    }
                }
                else if ($type == "detail-field" || $type == "form-detail")
                {
                    if (($type == "form-detail" && $field_type != DATA_TYPE_ID) || ($type == "detail-field" && $field_type != DATA_TYPE_ACTION))
                    {
                        $new_data["data"][$field_name] = array(
                            "label" => $field_label,
                            "field" => $field_name,
                            "value" => $item_value,
                        );
                    }
                }
                else if ($type == "export")
                {
                    $new_data[] = $item_value;
                }
            }

            if ($type == "datatable-field" || $type == "detail" || $type == "detail-field" || $type == "form-detail")
            {
                $new_data["data"]       = !empty($new_data["data"]) ? $new_data["data"] : array();
                $new_data["source"]     = $data;
                $new_data["original"]   = $this->general->get_data($this->_initial->table_name." ".$this->_initial->table_alias, array(
                    $this->_initial->table_alias.".".$this->_initial->field_primary => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $id
                    )
                ))->getRow();
            }
        }
        else if ($type == "form")
        {
            $new_data   = $data;
        }

        return $new_data;
    }
    public function set_initial($master_name = "", $debug = false)
    {
        $session_name       = "session-datatable-".$master_name;
        $session_initial    = $this->session->get($session_name);

        if (!empty($session_initial) && ENVIRONMENT == ENVIRONMENT_PRODUCTION)
        {
            $this->_initial     = $session_initial;
        }
        else
        {
            $initial            = $this->masterlib->get_master(array(
                "name"  => array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                    SQL_CONDITION_VALUE     => $master_name
                )
            ), true);
            $this->_initial = (object) [];

            if (!empty($initial))
            {
                // Set Datatable Initial
                $table_key                      = $this->utils->search_array($initial->sources, "table_primary", true, false, true);

                $this->_initial->table_name     = $table_key["data"]["table_name"];
                $this->_initial->table_alias    = $table_key["data"]["table_alias"];
                $this->_initial->field_primary  = $table_key["data"]["primary_key"];
                $this->_initial->name           = $initial->name;
                $this->_initial->label          = $initial->label;
                $this->_initial->url            = !empty($this->_initial->url) ? $this->_initial->url : base_url($initial->url);

                $this->_initial->sources        = array_map(function ($source){

                    $tmp_sources                = (object) [];

                    $tmp_sources->table_name    = $source->table_name;
                    $tmp_sources->table_primary = $source->table_primary ? true : false;
                    $tmp_sources->primary_key   = $source->primary_key;

                    return $source;
                }, $initial->sources);
                $this->_initial->fields         = $initial->fields;

                $this->_initial->fields_datatable   = $initial->fields_datatable;
                $this->_initial->fields_form        = $initial->fields_form;
                $this->_initial->other              = $initial->other;
                $this->_initial->groups             = $initial->groups;
                $this->_initial->table_button       = $this->generate_button_table();

                // Get Sort Index
                if (!empty($this->_initial->other["datatable"]["table_sort"]))
                {
                    $this->_initial->other["datatable"]["table_sort"]    = $this->utils->search_array($this->_initial->fields_datatable, "field", $this->_initial->other["datatable"]["table_sort"], true, false);
                }
                if (!empty($this->_initial->other["datatable"]["type"]))
                {
                    $this->_initial->type           = $this->_initial->other["datatable"]["type"];
                }

                if (ENVIRONMENT == ENVIRONMENT_PRODUCTION)
                {
                    $session_initial    = $this->_initial;

                    $this->session->set($session_name, $session_initial);
                }
            }
        }

    }

    public function update($inputs)
    {
        $result             = RESULT_ERROR;
        $message            = array();
        $data_master        = array();
        $data_meta          = array();

        $field_primary      = $this->_initial->field_primary;
        $table_primary      = $this->_initial->table_name;
        $field_primary      = $this->utils->search_array($this->_initial->fields, array("table_name", "field"), array($table_primary, $field_primary), false, true);
        $field_primary      = $field_primary["data"]["name"];
        $primary_key        = array_key_exists($field_primary, $inputs) ? $inputs[$field_primary] : "";
        $primary_key        = $this->encryptlib->decode($primary_key);

        foreach ($this->_initial->fields as $fields)
        {
            if (array_key_exists($fields->name, $inputs) && $fields->field != $this->_initial->field_primary)
            {
                $field          = $fields->field;
                $field_name     = $fields->name;

                if (in_array($fields->type, $this->masterlib->_master_field_group["field_multi_join"]) || in_array($fields->type, $this->masterlib->_master_field_group["field_multi"]))
                {
                    $value          = is_array($inputs[$fields->name]) ? implode(DATA_MULTI_SEPARATOR, $inputs[$fields->name]) : $inputs[$fields->name];
                }
                else if ($fields->type == DATA_TYPE_TEXTBOX_PASSWORD)
                {
                    $check_data = $this->general->get_data($this->_initial->table_name, array(
                        $this->_initial->field_primary => array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                            SQL_CONDITION_VALUE     => $primary_key
                        )
                    ))->getRow();

                    if (!empty($check_data->$field_name) && $check_data->$field_name == $inputs[$field_name])
                    {
                        $value  = $check_data->$field_name;
                    }
                    else
                    {
                        $value  = array_key_exists($field_name, $inputs) && !empty($inputs[$field_name]) ? md5($inputs[$field_name]) : "";
                    }
                }
                else
                {
                    $value          = $inputs[$fields->name];
                }

                if ($fields->source == SOURCE_TYPE_METADATA)
                {
                    $data_meta[]  = array(
                        "id_field"  => $this->encryptlib->decode($fields->hash),
                        "value"     => $value
                    );
                }
                else
                {
                    $data_master[$field]   = $value;
                }

                $validation                 = $this->validation_value($fields, $value, $primary_key);

                if (!empty($validation))
                {
                    $message[$field_name]    = $validation;
                }
            }
            else if ($fields->type == DATA_TYPE_SYSDATE && !in_array($fields->field, $this->_field_system))
            {
                $data_master[$fields->field]    = date("Y-m-d H:i:s");
            }
        }

        if (empty($message))
        {
            $logs_datatable     = $this->_initial;
            $logs_tmp           = !empty($primary_key) ? $this->get_detail($primary_key, "detail") : array();
            $logs_tmp           = !empty($logs_tmp) && !empty($logs_tmp["data"]) ? $logs_tmp["data"] : array();
            $logs_data          = $data_master;
            $logs_user          = $this->_user;
            $sources_primary    = $this->utils->search_array($this->_initial->sources, "table_primary", 1, false, true);
            $sources_primary    = !empty($sources_primary["data"]) ? $sources_primary["data"] : array();

            if (!empty($primary_key))
            {
                $field_updated      = !empty($sources_primary["tmp_fields"]) && in_array("updated", $sources_primary["tmp_fields"]) ? true : false;
                $field_updatedby    = !empty($sources_primary["tmp_fields"]) && in_array("updatedby", $sources_primary["tmp_fields"]) ? true : false;

                if (!empty($field_updated)){
                    $data_master["updated"]     = date("Y-m-d H:i:s");
                }
                if (!empty($field_updatedby)){
                    $data_master["updatedby"]   = $this->_user->id;
                }

                $this->general->update($this->_initial->table_name, array(
                    $this->_initial->field_primary  => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $primary_key
                    )
                ), $data_master);
            }
            else
            {
                $field_created      = !empty($sources_primary["tmp_fields"]) && in_array("created", $sources_primary["tmp_fields"]) ? true : false;
                $field_createdby    = !empty($sources_primary["tmp_fields"]) && in_array("createdby", $sources_primary["tmp_fields"]) ? true : false;
                $field_updated      = !empty($sources_primary["tmp_fields"]) && in_array("updated", $sources_primary["tmp_fields"]) ? true : false;
                $field_updatedby    = !empty($sources_primary["tmp_fields"]) && in_array("updatedby", $sources_primary["tmp_fields"]) ? true : false;

                if (!empty($field_created)){
                    $data_master["created"]     = date("Y-m-d H:i:s");
                }
                if (!empty($field_createdby)){
                    $data_master["createdby"]   = $this->_user->id;
                }
                if (!empty($field_updated)){
                    $data_master["updated"]     = date("Y-m-d H:i:s");
                }
                if (!empty($field_updatedby)){
                    $data_master["updatedby"]   = $this->_user->id;
                }

                $primary_key  = $this->general->insert($this->_initial->table_name, $data_master);
            }

            $this->set_metadata($primary_key, $data_meta);

            $inputs["id"]   = $primary_key;

            /*$this->utils->set_metadata($primary_key, $data_meta);*/

            $message    = "Data saved successfully.";
            $result     = "success";
        }

        $result = array(
            "result"    => $result,
            "message"   => $message,
            "id"        => $primary_key
        );

        return $result;
    }
    public function upload($field, $param = array(), $from_data_master = true, $meta = array())
    {
        $exts   = array();

        if ($from_data_master)
        {
            $fields = $this->utils->search_array($this->_initial->fields, "name", $field, false, true);
            $fields = $fields["data"];

            $exts   = $this->filelib->get_ext_by_type($fields["type"]);
        }
        else
        {
            $fields = $param;
            if (!empty($param["exts"]))
            {
                $exts   = $param["exts"];
            }
        }

        if (!empty($exts)){
            $config["allowed_types"] = implode("|", $exts);
        }

        if (!empty($param["dir"]))
        {
            $dir        = $param["dir"];
        }
        else
        {
            $dir            = $this->filelib->_dir_file;
            $dir_structure  = array(
                date("Y"),
                date("m"),
                date("d"),
            );

            foreach ($dir_structure as $folder)
            {
                if ($folder == date("Y")){
                    $dir    = $dir.$folder;
                } else {
                    $dir    = $dir.DIRECTORY_SEPARATOR.$folder;
                }

                if (!is_dir($dir)) {
                    mkdir($dir);
                }
            }

            $dir    .= DIRECTORY_SEPARATOR;
        }

        $config["upload_path"]  = "./".$dir;
        $config["max_size"]     = "2048000";


        $validationRule = [
            'userfile' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[userfile]',
                    'is_image[userfile]',
                    'mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                    'max_size[userfile,100]',
                    'max_dims[userfile,1024,768]',
                ],
            ],
        ];

        $validated = $this->validation->validate($validationRule);

        var_dump($validated);
        die;


        if (! $this->validateData([], $validationRule)) {
            $data = ['errors' => $this->validator->getErrors()];

            var_dump($data);
            die;
        }

        die;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path']);
        }


        if ($this->upload->do_upload('file'))
        {
            $file_data      = $this->upload->data();
            $temp_file      = $file_data['full_path'];
            $new_file_name  = md5(date("YmdHis")."_".$file_data["file_name"]).$file_data["file_ext"];
            rename($temp_file, $file_data["file_path"].$new_file_name);

            $file["file_name_ori"]   = $file_data["file_name"];
            $file["file_name"]       = $new_file_name;
            $file["file_loc"]        = $dir.$new_file_name;
            $file["file_size"]       = $file_data["file_size"];
            $file["file_ext"]        = $file_data["file_ext"];

            if ($from_data_master && empty($meta))
            {
                $meta   = array(
                    "field-name" => $fields["field"],
                    "field-type" => $fields["type"]
                );
            }

            $file["file_ext"]   = str_ireplace(".", "", $file["file_ext"]);

            $data_file          = array(
                "directory"         => $dir,
                "file_name_ori"     => $file["file_name_ori"],
                "file_name"         => $file["file_name"],
                "file_ext"          => $file["file_ext"],
                "file_ext"          => str_ireplace(".", "", $file["file_ext"]),
                "file_size"         => $file["file_size"],
                "meta"              => json_encode($meta)
            );

            $file["id"]         = $this->general->insert("tbl_files", $data_file);
            $file["hash"]       = $this->encryptlib->encode($file["id"]);

            $file["content"]    = $this->filelib->get_view_file($file["id"], $fields, FILE_VIEW_FORM);

            $result     = "success";
            $message    = $file;
        }
        else
        {

            $result     = "error";

            $message    = strip_tags($this->upload->display_errors());
        }

        return array(
            "result"    => $result,
            "message"   => $message,
        );
    }
    public function delete($id)
    {
        $result     = "error";
        $message    = "";

        $id         = $this->encryptlib->decode($id);
        $tmp_data   = $this->get_detail($id, "detail");

        $delete     = $this->general->delete($this->_initial->table_name, array(
            $this->_initial->field_primary => array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $id
            )
        ));

        if ($delete)
        {
            $result     = "success";
            $message    = "Data berhasil dihapus.";
        }
        else
        {
            $message    = "Sorry, Data cannot deleted.";
        }

        return array(
            "result"    => $result,
            "message"   => $message,
            "other"     => $delete,
        );
    }

    // Import
    public function generate_template_import()
    {
        if (!empty($this->_initial->fields))
        {
            $data["title"]  = $this->_initial->label;
            $data["header"] = array();
            $data["body"]   = array();

            foreach ($this->_initial->fields_form as $key => $item_field)
            {
                if(!in_array($item_field->type, array(DATA_TYPE_SYSDATE)) && $item_field->source == SOURCE_TYPE_FIELD && $item_field->field != "id_client")
                {
                    $data["header"][$item_field->name]   = $item_field->form->label;

                    if (
                        in_array($item_field->type, $this->masterlib->_master_field_group["field_single_join"]) ||
                        in_array($item_field->type, $this->masterlib->_master_field_group["field_multi_join"])
                    )
                    {
                        $source         = $item_field->other["source"];
                        $field_label    = $source["field_label"];

                        $new_list   = array();

                        foreach ($source["data"] as $item)
                        {
                            $new_list[] = $item->$field_label;
                        }

                        $data["body"][$item_field->name] = $new_list;
                    }
                    else if (
                        in_array($item_field->type, $this->masterlib->_master_field_group["field_list_key"]) ||
                        in_array($item_field->type, $this->masterlib->_master_field_group["field_list_value"]))
                    {
                        $list   = $item_field->other["list"];
                        $data["body"][$item_field->name] = $list;
                    }
                    else
                    {
                        $data["body"][$item_field->name] = "";
                    }
                }
            }

            $this->generate_template_import_download($data);
        }

        return false;
    }
    public function generate_template_import_download($data = array())
    {
        $this->_CI->load->library("phpexcel");
        $objPHPExcel    = new PHPExcel();

        $sharedStyleHead = new PHPExcel_Style();
        $sharedStyleHead->applyFromArray(
            array("fill" 	=> array(
                "type"		=> PHPExcel_Style_Fill::FILL_SOLID,
                "color"		=> array("argb" => "ffe866")
            ),
                "borders" => array(
                    "bottom"	=> array("style" => PHPExcel_Style_Border::BORDER_THIN),
                    "right"		=> array("style" => PHPExcel_Style_Border::BORDER_THIN),
                    "top"		=> array("style" => PHPExcel_Style_Border::BORDER_THIN),
                    "left"		=> array("style" => PHPExcel_Style_Border::BORDER_THIN)
                )
            )
        );

        $sharedStyleBody = new PHPExcel_Style();
        $sharedStyleBody->applyFromArray(
            array(
                'borders' => array(
                    'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'top'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'left'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
                )
            ));

        $data_sheets    = array();
        $headers        = $data["header"];
        $bodies         = $data["body"];

        $sheet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->getActiveSheet()->setTitle($data["title"]);


        $i = 0;
        foreach ($bodies as $field => $value)
        {
            if (is_array($value) || is_object($value))
            {
                $objWorkSheet = $objPHPExcel->createSheet($i);

                $i_value    = 1;
                foreach ($value as $key => $item)
                {
                    $objWorkSheet->setCellValue("A".$i_value, $item);

                    $i_value++;
                }

                $objWorkSheet->setTitle($headers[$field]);
                $objWorkSheet->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);

                $data_sheets[]  = $headers[$field];

                $i++;
            }
        }

        $data_sheets[]  = $data["title"];
        end($data_sheets);
        $last_sheet     = key($data_sheets);

        $objPHPExcel->setActiveSheetIndex($last_sheet);

        $col        = "A";
        foreach ($headers as $key => $header)
        {
            $objPHPExcel->setActiveSheetIndex($last_sheet)->setCellValue($col."1", $header);
            $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyleHead, $col."1");
            $col++;
        }

        $col        = "A";
        foreach ($bodies as $key => $value)
        {
            if (is_array($value) || is_object($value))
            {
                $value  = (array) $value;

                $objPHPExcel->setActiveSheetIndex($last_sheet)->setCellValue($col."2", "");

                $objValidation = $objPHPExcel->getActiveSheet()->getCell($col."2")->getDataValidation();

                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(true);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Please Choose from list');
                $objValidation->setPrompt('Please choose a value from the drop-down list.');

                $formula    = "'".$headers[$key].''."'".'!$A$1:$A$'.(empty($value) ? 1 : count($value));
                $objValidation->setFormula1($formula);
            }
            else
            {
                $objPHPExcel->setActiveSheetIndex($last_sheet)->setCellValue($col."2", $value);
            }
            $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyleBody, $col."2");

            $col++;
        }

        $objPHPExcel->getActiveSheet()->setShowGridlines(false);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Template-'.$data["title"].'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    // Export
    public function exports($type, $param)
    {
        $filename           = !empty($param["filename"]) ? $param["filename"] : array();
        $filename_time      = !empty($param["filename_time"]) ? true : false;
        $param["filter"]    = !empty($param["filter"]) ? json_decode($param["filter"], 1) : array();
        $param["field"]     = !empty($param["field"]) ? json_decode($param["field"], 1) : array();

        $tmp_field_sort     = !empty($this->_initial->fields_datatable[$param["sort"]]) ? $this->_initial->fields_datatable[$param["sort"]] : "";
        $param["sort"]      = !empty($tmp_field_sort->name) ? $tmp_field_sort->name : "";

        $initial            = $this->export_initial($param);
        $headers            = $initial["headers"];
        $conditions         = !empty($param["conditions"]) ? $param["conditions"] : array();
        $param              = array(
            "columns"   => $initial["columns"],
            "orders"    => array(
                array(
                    "column"    => $initial["sort"],
                    "dir"       => $param["sort_type"]
                )
            ),
        );

        if (!empty($conditions))
        {
            $param["conditions"]    = $conditions;
        }

        $data               = $this->get($param, 3, false, true);

        if ($type == "excel")
        {
            $this->utils->create_excel_file(array(
                "title"     => $this->_initial->label,
                "file_name" => $filename.($filename_time ? " [".date("YmdHis")."]" : ""),
                "headers"   => $headers,
                "data"      => $data["data"]
            ));
        }
        else if ($type == "pdf")
        {
            $data       = array(
                "headers"   => $table_header,
                "data"      => $data
            );
            $content    = $this->_CI->load->view("template/datatable/export_pdf", $data, true);

            $this->_CI->load->library('pdf');
            $pdf = new Pdf("L", "mm", "A4", true, "UTF-8", false);
            $pdf->SetTitle($this->_initial->label);
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(20);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor("Author");
            $pdf->SetDisplayMode("real", "default");
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            $pdf->AddPage();
            $pdf->SetFont(PDF_FONT_MONOSPACED, '', 10);
            $pdf->writeHTML($content, true, false, true, false, "");

            $pdf->lastPage();

            $pdf->Output($this->_initial->label.".pdf", "I");
        }
    }

    public function export_initial($param)
    {
        $initial_header = array();
        $initial_column = array();
        $initial_export = array();
        $initial_sort   = "";
        $index          = 0;

        foreach ($this->_initial->fields as $fields)
        {
            $key_field_export   = array_search ($fields->name, $param["field"]);

            if ($key_field_export !== false)
            {
                $label  = "";

                if ($fields->datatable->render === true){
                    $label = $fields->datatable->label;
                } else if ($fields->form->render === true){
                    $label = $fields->form->label;
                }

                $fields->datatable->position    = $key_field_export;
                $initial_export[$key_field_export]   = $fields;
                $initial_header[$key_field_export]   = $label;

                if (isset($param["filter"][$fields->name]) && $param["filter"][$fields->name] != "")
                {
                    $search_value   = $param["filter"][$fields->name];
                }
                else
                {
                    $search_value   = "";
                }

                $initial_column[$index]   = array(
                    "data"          => $index,
                    "name"          => $fields->name,
                    "searchable"    => true,
                    "orderable"     => true,
                    "search"        => array(
                        "value" => $search_value,
                        "regex" => false,
                    ),
                );

                if (!empty($param["sort"]) && $param["sort"] == $fields->name)
                {
                    $initial_sort   = $index;
                }

                $index++;
            }
        }

        ksort($initial_export);
        ksort($initial_header);

        $this->_initial->fields_datatable   = $initial_export;

        return array(
            "columns"   => $initial_column,
            "sort"      => $initial_sort,
            "headers"   => $initial_header
        );
    }
    protected function export_data()
    {

    }

    public function set_library()
    {
        $data   = array(
            "_core_css"     => array(),
            "_core_js"      => array(),
            "_support_css"  => array(),
            "_support_js"   => array(),
        );
        $data["_core_css"][]        = "public/plugins/datatables/datatables.min.css";
        $data["_core_css"][]        = "public/plugins/popup/sm-toolbar.css";
        $data["_core_css"][]        = "public/plugins/popup/material-menu.css";

        $data["_core_js"][]         = "public/plugins/datatables/datatables.min.js";
        $data["_core_js"][]         = "public/plugins/datatables/datatables.fixedColumns.min.js";
        $data["_core_js"][]         = "public/plugins/datatables/datatables.buttons.min.js";
        $data["_core_js"][]         = "public/plugins/3d_stl_viewer/stl_viewer.js";

        if ($this->_method == "export"){
            $data["_core_js"][]     = "public/plugins/jquery-ui/jquery-ui.min.js";
        }

        $data["_core_js"][]         = "public/plugins/popup/material-menu.js";

        $data["_support_js"][]      = "public/js/lib/datatable.js";
        $data["_support_css"][]     = "public/css/datatable.css";

        return $data;
    }
    protected function set_query_join()
    {
        $result         = array();
        $table_primary  = array();
        $conditions     = array();

        foreach ($this->_initial->sources as $source)
        {
            $tmp_conditions = array();

            foreach ($source->conditions as $condition)
            {
                $condition["table"] = $source->table_alias;

                if ($source->table_primary) {
                    $conditions[] = $condition;
                }
                $tmp_conditions[]   = $condition;
            }

            if (!$source->table_primary)
            {
                $join_condition = $source->join_table.".".$source->join_key." = ".$source->table_alias.".".$source->primary_key;
                $result[]   = array(
                    "table"     => $source->table_name." AS ".$source->table_alias,
                    "condition" => $join_condition,
                    "type"      => $source->join_type
                );
            }
            else
            {
                $table_primary  = $source;
            }
        }

        $conditions     = $this->set_query_conditions($conditions);
        $result         = array(
            "joins"         => $result,
            "conditions"    => $conditions
        );

        return $result;
    }
    public function set_query_conditions($conditions)
    {
        $result = array();

        foreach ($conditions as $condition)
        {
            if ($condition["type"] == "text")
            {
                $result[$condition["table"].".".$condition["field"]] = array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                    SQL_CONDITION_VALUE     => "'".$condition["value"]."'"
                );
            }
            else if ($condition["type"] == "user")
            {
                $value  = $condition["value"];
                $user   = $this->_user;

                if (isset($user->filter[$value]["value"]))
                {
                    $result[$condition["table"].".".$condition["field"]] = array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $user->filter[$value]["value"]
                    );
                }

            }
            else if ($condition["type"] == "sql")
            {
                $result[$condition["table"].".".$condition["field"]] = array(
                    SQL_CONDITION_OPERATOR  => SQL_CONDITION_QUERY,
                    SQL_CONDITION_VALUE     => $condition["value"]
                );
            }
        }

        return $result;

    }
    public function set_query_select_conditions($type = "query_selects", $param = array(), $query_sort = false, $id_object = null)
    {
        $field_sort = "";

        if ($type == "query_selects")
        {
            $tmp_fields = $this->_initial->fields;
        }
        else if ($type == "query_conditions")
        {
            $tmp_fields = $this->_initial->fields_datatable;
        }

        $result = array();

        foreach ($tmp_fields as $i => $fields)
        {
            if ($fields->type != DATA_TYPE_ACTION && $fields->source == SOURCE_TYPE_FIELD)
            {
                if (in_array($fields->type, $this->masterlib->_master_field_group["field_list_key"]))
                {
                    $lists          = !empty($fields->other["list"]) ? $fields->other["list"] : array();
                    $select_key     = "";
                    $select_key_op  = "";
                    $tmp_field_key  = $fields->table_alias . "." . $fields->field;

                    foreach ($lists as $item_key => $item_value)
                    {
                        $select_key     .= "IF (".$tmp_field_key." = '".$item_key."', '".$item_value."',";
                        $select_key_op  .= ")";
                    }

                    $select_key .= "''".$select_key_op;

                    $query_field    = $select_key;
                    $query_field_as = $fields->name;

                    if ($type == "query_conditions" && array_key_exists($fields->name, $param))
                    {
                        $result[$fields->table_alias . "." . $fields->field] = array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                            SQL_CONDITION_VALUE     => "".$param[$fields->name].""
                        );
                    }
                    else if ($type == "query_selects")
                    {
                        $result[]   = $query_field." AS '".$query_field_as."'";
                    }

                    if (!empty($query_sort) && $query_sort == $i)
                    {
                        $field_sort = $fields->table_alias.".".$fields->field;
                    }
                }
                else if (in_array($fields->type, $this->masterlib->_master_field_group["field_single_join"]))
                {
                    $source         = $fields->other["source"];
                    $source_id      = $source["id"];
                    $tmp_source     = $this->utils->search_array($this->_initial->sources, "id", $source_id, false, true);

                    $query_field    = $tmp_source["data"]["table_alias"].".".$source["field_label"];
                    $query_field_as = $fields->name;

                    if ($type == "query_conditions" && array_key_exists($fields->name, $param))
                    {
                        $result[$fields->table_alias . "." . $fields->field] = array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                            SQL_CONDITION_VALUE     => "".$param[$fields->name].""
                        );
                    }
                    else if ($type == "query_selects")
                    {
                        $result[]   = $query_field." AS '".$query_field_as."'";
                    }

                    if (!empty($query_sort) && $query_sort == $i)
                    {
                        $field_sort = $query_field;
                    }
                }
                else if (in_array($fields->type, $this->masterlib->_master_field_group["field_multi_join"]))
                {
                    $source         = $fields->other["source"];
                    $source_id      = $source["id"];
                    $tmp_source     = $this->utils->search_array($this->_initial->sources, "id", $source_id, false, true);
                    $tmp_source     = $tmp_source["data"];

                    $query_field    = "(SELECT GROUP_CONCAT(".$tmp_source["table_alias"].".".$source["field_label"]." SEPARATOR '".DATA_MULTI_SEPARATOR."') FROM ".$tmp_source["table_name"]." as ".$tmp_source["table_alias"]." WHERE FIND_IN_SET( ".$tmp_source["table_alias"].".".$source["field_key"].", ".$fields->table_alias.".".$fields->field." ) != 0)";
                    $query_field_as = $fields->name;

                    if ($type == "query_conditions" && array_key_exists($fields->name, $param))
                    {
                        $query_field_condition  = "(SELECT GROUP_CONCAT(".$tmp_source["table_alias"].".".$source["field_key"]." SEPARATOR '".DATA_MULTI_SEPARATOR."') FROM ".$tmp_source["table_name"]." as ".$tmp_source["table_alias"]." WHERE FIND_IN_SET( ".$tmp_source["table_alias"].".".$source["field_key"].", ".$fields->table_alias.".".$fields->field." ))";
                        $query_field_condition  = "FIND_IN_SET( ".$param[$fields->name].", ".$query_field_condition." )";

                        $result[$query_field_condition] = array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_NOT_EQUAL,
                            SQL_CONDITION_VALUE     => 0
                        );
                    }
                    else if ($type == "query_selects")
                    {
                        $result[]   = $query_field." AS '".$query_field_as."'";
                    }

                    if (!empty($query_sort) && $query_sort == $i)
                    {
                        $field_sort = $query_field;
                    }
                }
                else if (in_array($fields->type, $this->masterlib->_master_field_group["field_date"]))
                {
                    $query_field    = $fields->table_alias.".".$fields->field;
                    $query_field_as = $fields->name;

                    if ($type == "query_conditions" && array_key_exists($fields->name, $param))
                    {
                        $date_value     = explode(" - ", $param[$fields->name]);

                        if (in_array($fields->type, $this->masterlib->_master_field_group["field_datetime"]))
                        {
                            $date_value[0]      .= " 00:00:00";
                            $date_value[1]      .= " 23:59:59";
                        }

                        $result[$fields->table_alias . "." . $fields->field] = array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_BETWEEN,
                            SQL_CONDITION_VALUE     => $date_value
                        );
                    }
                    else if ($type == "query_selects")
                    {
                        $result[]   = $query_field." AS '".$query_field_as."'";
                    }


                    if (!empty($query_sort) && $query_sort == $i)
                    {
                        $field_sort = $query_field;
                    }
                }
                else if (in_array($fields->type, $this->masterlib->_master_field_group["field_query"]))
                {
                    $query_field    = $fields->table_alias.".".$fields->field;
                    $query_field_as = $fields->name;
                    $query          = $fields->other["query"];

                    if ($type == "query_conditions" && array_key_exists($fields->name, $param))
                    {
                        $result[$query] = array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_LIKE,
                            SQL_CONDITION_VALUE     => "".$param[$fields->name].""
                        );
                    }
                    else if ($type == "query_selects")
                    {
                        $result[]   = "(".$query.") AS '".$query_field_as."'";
                    }

                    if (!empty($query_sort) && $query_sort == $i)
                    {
                        $field_sort = $query;
                    }
                }
                else if (in_array($fields->type, $this->masterlib->_master_field_group["field_condition_equal"]))
                {
                    $query_field    = $fields->table_alias.".".$fields->field;
                    $query_field_as = $fields->name;

                    if ($type == "query_conditions" && array_key_exists($fields->name, $param))
                    {
                        $result["TRIM(".$fields->table_alias . "." . $fields->field.")"] = array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                            SQL_CONDITION_VALUE     => "'".trim($param[$fields->name])."'"
                        );
                    }
                    else if ($type == "query_selects")
                    {
                        $result[]   = $query_field." AS '".$query_field_as."'";
                    }

                    if (!empty($query_sort) && $query_sort == $i)
                    {
                        $field_sort = $query_field;
                    }
                }
                else
                {
                    $query_field    = $fields->table_alias.".".$fields->field;
                    $query_field_as = $fields->name;

                    if ($type == "query_conditions" && array_key_exists($fields->name, $param))
                    {
                        $result[$fields->table_alias . "." . $fields->field] = array(
                            SQL_CONDITION_OPERATOR  => SQL_WHERE_LIKE,
                            SQL_CONDITION_VALUE     => "".$param[$fields->name].""
                        );
                    }
                    else if ($type == "query_selects")
                    {
                        $result[]   = $query_field." AS '".$query_field_as."'";
                    }

                    if (!empty($query_sort) && $query_sort == $i)
                    {
                        $field_sort = $query_field;
                    }
                }

            }
            else
            {
                if ($type == "query_selects")
                {
                    $result[]   = $this->generate_query_select_metadata($id_object, $fields);
                }
            }
        }

        if (!empty($query_sort)){
            return $field_sort;
        }else{
            return $result;
        }
    }
    public function generate_button_table()
    {
        if (empty($this->_initial->other["datatable"]["button_table"]))
        {
            return "";
        }
        else
        {
            $content    = "<div class='btn-group'>";

            foreach ($this->_initial->other["datatable"]["button_table"] as $button)
            {
                if ($button == BUTTON_TABLE_ADD)
                {
                    $content    .= "<a href='".(!empty($this->_initial->url) ? $this->_initial->url . '/update' : 'javascript:void(0)')."' class='btn btn-sm btn-small btn-default text-info btn-datatable-header btn-datatable-add'><i class='fa fa-plus'></i><span class='hidden-xs'>&nbsp; Tambah</span></a>";
                }
                else if ($button == BUTTON_TABLE_IMPORT)
                {
                    $content    .= "<a href='".(!empty($this->_initial->url) ? $this->_initial->url . '/import' : 'javascript:void(0)')."' class='btn btn-sm btn-small btn-default btn-datatable-header btn-datatable-import'><i class='fa fa-upload'></i>&nbsp; Import</a>";
                }
                else if ($button == BUTTON_TABLE_EXPORT)
                {

                    $content    .= "<a href='".(!empty($this->_initial->url) ? $this->_initial->url . '/export' : 'javascript:void(0)')."' class='btn btn-sm btn-small btn-default btn-datatable-header btn-datatable-export btn-export'><i class='fa fa-download'></i>&nbsp; Export</a>";
                    /*$content    .= "<div class='btn-group'>";
                    $content    .= "<button data-toggle='dropdown' class='btn btn-default btn-sm dropdown-toggle btn-group-export' aria-expanded='false'><i class='fa fa-download'></i><span class='hidden-xs'>&nbsp;&nbsp;Export &nbsp;&nbsp;<span class='caret'></span></span></button>";
                    $content    .= "<ul class='dropdown-menu'>";
                    $content    .= "<li><a data-url='".(!empty($this->_initial->url) ? $this->_initial->url . '/export/pdf' : 'javascript:void(0)')."' href='".(!empty($this->_initial->url) ? $this->_initial->url . '/export/pdf' : 'javascript:void(0)')."'><i class='fa fa-file-pdf-o'></i>&nbsp;&nbsp;PDF</a></li>";
                    $content    .= "<li><a data-url='".(!empty($this->_initial->url) ? $this->_initial->url . '/export/excel' : 'javascript:void(0)')."' href='".(!empty($this->_initial->url) ? $this->_initial->url . '/export/excel' : 'javascript:void(0)')."'><i class='fa fa-file-excel-o'></i>&nbsp;&nbsp;Excel</a></li>";
                    $content    .= "<li><a data-url='".(!empty($this->_initial->url) ? $this->_initial->url . '/export/csv' : 'javascript:void(0)')."' href='".(!empty($this->_initial->url) ? $this->_initial->url . '/export/csv' : 'javascript:void(0)')."'><i class='fa fa-file-excel-o'></i>&nbsp;&nbsp;CSV</a></li>";
                    $content    .= "</ul>";
                    $content    .= "</div>";*/
                    /*$content    .= "<a href='".(!empty($this->_initial->url) ? $this->_initial->url . '/update' : 'javascript:void(0)')."' class='btn btn-sm btn-small btn-default'><i class='fa fa-download'></i>&nbsp; Export</a>";*/
                }
                else if ($button == BUTTON_TABLE_CLEAR)
                {
                    $content    .= "<button type='button' class='btn btn-sm btn-small btn-default  btn-datatable-header btn-datatable-clear_filter btn-clear-filter'><i class='fa fa-trash'></i><span class='hidden-xs'>&nbsp; Hapus Filter</span></button>";
                }
                else if ($button == BUTTON_TABLE_REFRESH)
                {
                    $content    .= "<button type='button' class='btn btn-sm btn-small btn-default  btn-datatable-header btn-datatable-refresh'><i class='fa fa-refresh'></i><span class='hidden-xs'>&nbsp; Refresh</span></button>";
                }
                else
                {
                    $content    .= $button;
                }

            }

            $content    .= "</div>";

            return $content;
        }
    }
    public function generate_button_action($data, $primary_key)
    {
        $action_array   = array();
        $hash           = $this->encryptlib->encode($data->$primary_key);


        if (!empty($this->_initial->other["datatable"]["button_action"]))
        {
            if (in_array(BUTTON_ACTION_VIEW_POPUP, $this->_initial->other["datatable"]["button_action"]))
            {
                $action_array[] = array(
                    "label" => "LIHAT",
                    "class" => "btn-datatable-detail",
                    "icon"  => "fa fa-sticky-note text-info",
                    "hash"  => $this->encryptlib->encode($data->$primary_key),
                    "url"   => "javascript:void(0);",
                    "attr"  => array(
                        "data-id"   => $hash,
                        "data-hash" => $hash,
                    )
                );
            }
            if (in_array(BUTTON_ACTION_VIEW_LINK, $this->_initial->other["datatable"]["button_action"]))
            {
                $action_array[] = array(
                    "label" => "LIHAT",
                    "class" => "",
                    "icon"  => "fa fa-sticky-note text-info",
                    "hash"  => $this->encryptlib->encode($data->$primary_key),
                    "url"   => $this->_initial->url."/detail/".$this->encryptlib->encode($data->$primary_key),
                    "attr"  => array(
                        "data-id"   => $hash,
                        "data-hash" => $hash,
                    )
                );
            }
            if (in_array(BUTTON_ACTION_EDIT, $this->_initial->other["datatable"]["button_action"]))
            {
                $action_array[] = array(
                    "label" => "UBAH",
                    "class" => "",
                    "icon"  => "fa fa-pencil text-blue",
                    "hash"  => $this->encryptlib->encode($data->$primary_key),
                    "url"   => $this->_initial->url."/update/".$this->encryptlib->encode($data->$primary_key),
                    "attr"  => array(
                        "data-id"   => $hash,
                        "data-hash" => $hash,
                    )
                );
            }
            if (in_array(BUTTON_ACTION_DELETE, $this->_initial->other["datatable"]["button_action"]))
            {
                $action_array[] = array(
                    "label" => "HAPUS",
                    "class" => "btn-delete",
                    "icon"  => "fa fa-trash-o text-danger",
                    "hash"  => $this->encryptlib->encode($data->$primary_key),
                    "url"   => "javascript:void(0)",
                    "attr"  => array(
                        "data-type" => "basic",
                        "data-id"   => $hash,
                        "data-hash" => $hash,
                    )
                );
            }
        }

        if (!empty($action_array))
        {
            $action_content = "<button type='button' class='btn btn-xs btn-small btn-primary btn-datatable-action' data-hash='".$hash."'><i class='fa fa-list' ></i></button>";
            $action_content .= "<input type='hidden' class='content-datatable-action' value='".json_encode($action_array)."'></input>";

            return $action_content;
        }

        return "";
    }

    // Form Datatable
    public function generate_form($item_id = "", $type = "default")
    {
        if (!empty($item_id))
        {
            $item_edit  = $this->get_detail($item_id, "form");

            if (empty($item_edit)){
                redirect($this->_initial->url);
            }
        }
        else
        {
            $item_edit  = (object) [];
        }


        $this->_item_edit   = (object) array_merge((array) $item_edit, (array) $this->_item_edit);

        foreach ($this->_initial->fields_form as $fields)
        {
            $field_name = $fields->name;
            $value      = "";

            if (!empty($fields->form->default_value_type) && isset($fields->form->default_value) && strlen($fields->form->default_value) > 0)
            {
                if ($fields->form->default_value_type == "text")
                {
                    $value  = $fields->form->default_value;
                }
                else if ($fields->form->default_value_type == "user")
                {
                    $value  = array_key_exists($fields->form->default_value, $this->_user->filter) ? $this->_user->filter[$fields->form->default_value]["value"] : "";
                }
            }

            if (property_exists($this->_item_edit, $field_name))
            {
                $value  = $this->_item_edit->$field_name;
            }
            if ($fields->type == DATA_TYPE_ICON)
            {
                $fields->other["source"]["list"]  = $this->_list_icons;
            }

            $param	= array(
                "form_type"         => "form",
                "type"		        => $fields->type,
                "id"		        => "input_".$fields->name."",
                "field"		        => $fields->name,
                "name"		        => "input[".$fields->name."]",
                "label"		        => !empty($fields->form->label) ? $fields->form->label : $fields->name,
                "value"		        => $value,
                "validation"	    => !empty($fields->form->validation) ? $fields->form->validation : array(),
                "note"	            => !empty($fields->form->note) ? $fields->form->note : "",
                "other"	            => !empty($fields->other) ? $fields->other : array(),
                "class_container"   => !empty($fields->form->class_container) ? $fields->form->class_container : array(),
                "class_element"     => !empty($fields->form->class_element) ? $fields->form->class_element : array(),
                "attr_container"    => !empty($fields->form->attr_container) ? $fields->form->attr_container : array(),
                "attr_element"      => !empty($fields->form->attr_element) ? $fields->form->attr_element : array(),
            );

            if ($type == "default")
            {
                $this->_forms[] = $this->formlib->generate_form($param);
            }
            else  if ($type == "field")
            {
                $this->_forms[$param["field"]] = $this->formlib->generate_form($param);
            }
            else  if ($type == "field_detail")
            {
                $this->_forms[$param["field"]] = array(
                    "label"     => $param["label"],
                    "value"     => $value,
                    "content"   => $this->formlib->generate_form($param)
                );
            }
        }
    }
    public function generate_form_meta($inputs)
    {
        $result             = array();
        $master             = $this->_initial;

        if (!empty($inputs["id"]))
        {
            $item_edit  = $this->get_detail($inputs["id"], "form");
        }
        else
        {
            $item_edit  = (object) [];
        }

        $fields             = $master->fields;
        $fields_datatable   = $master->fields_datatable;
        $fields_form        = $master->fields_form;
        $groups             = !empty($master->groups) ? $master->groups : array();
        $list_field         = array();

        $fields_source      = !empty($groups["source"]) ? $groups["source"] : array();
        $fields_target      = !empty($groups["target"]) ? $groups["target"] : array();
        $fields_lists       = !empty($groups["list"]) ? $groups["list"] : array();
        $fields_active      = array();

        foreach ($fields_lists as $list)
        {
            if (array_key_exists($list["condition"]["field"], $inputs) && $list["condition"]["value"] == $inputs[$list["condition"]["field"]])
            {
                $fields_active = $list["active"];
            }
        }
        foreach ($fields_active as $field)
        {
            $initial    = $this->utils->search_array($fields, "name", $field, false, true);
            $initial    = !empty($initial["key"]) ? $initial["key"] : null;

            if (!empty($initial))
            {
                $initial    = $fields[$initial];
                $value      = "";

                if (property_exists($item_edit, $field)){
                    $value  = $item_edit->$field;
                }

                $param	    = array(
                    "form_type"         => "form",
                    "type"		        => $initial->type,
                    "id"		        => "input_".$initial->name."",
                    "field"		        => $initial->name,
                    "name"		        => "input[".$initial->name."]",
                    "label"		        => !empty($initial->form->label) ? $initial->form->label : $initial->name,
                    "value"		        => $value,
                    "validation"	    => !empty($initial->form->validation) ? $initial->form->validation : array(),
                    "note"	            => !empty($initial->form->note) ? $initial->form->note : "",
                    "other"	            => !empty($initial->other) ? $initial->other : array(),
                    "class_container"   => !empty($initial->form->class_container) ? $initial->form->class_container : array(),
                    "class_element"     => !empty($initial->form->class_element) ? $initial->form->class_element : array(),
                    "attr_container"    => !empty($initial->form->attr_container) ? $initial->form->attr_container : array(),
                    "attr_element"      => !empty($initial->form->attr_element) ? $initial->form->attr_element : array(),
                );
                $result[]   = $this->_CI->formlib->generate_form($param);

            }
        }

        return $result;

    }

    public function validation_value($fields, $value, $primary_key)
    {
        $validations    = !empty($fields->form->validation) ? $fields->form->validation : array();
        $message        = "";

        if (!empty($validations))
        {
            foreach ($validations as $validation)
            {
                switch ($validation)
                {
                    case VALIDATION_REQUIRED:

                        if ($fields->type   == DATA_TYPE_FILE_IMAGE && trim($value) == IMAGE_DEFAULT)
                        {
                            $message    .= "Kolom <b>".$fields->form->label."</b> tidak boleh kosong.<br>";
                        }
                        else if (trim($value) == "")
                        {
                            $message    .= "Kolom <b>".$fields->form->label."</b> tidak boleh kosong.<br>";
                        }



                        break;
                    case VALIDATION_UNIQUE:

                        // if insert
                        if (empty($primary_key))
                        {
                            $check_data = $this->general->get_data($this->_initial->table_name, array(
                                $fields->field  => array(
                                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                                    SQL_CONDITION_VALUE     => $value
                                )
                            ))->getNumRows();
                        }
                        else
                        {
                            $check_data = $this->general->get_data($this->_initial->table_name, array(
                                $this->_initial->field_primary  => array(
                                    SQL_CONDITION_OPERATOR  => SQL_WHERE_NOT_EQUAL,
                                    SQL_CONDITION_VALUE     => $primary_key
                                ),
                                $fields->field                  => array(
                                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                                    SQL_CONDITION_VALUE     => $value
                                )
                            ))->getRow();
                        }

                        if ($check_data && trim($value) != ""){
                            $message    .= " <b>".$fields->form->label."</b> tidak boleh ada yang sama.<br>";
                        }

                        break;
                    default:
                        $message    .= "";
                }
            }
        }

        // Validation Type

        // Type Email Validation
        if ($fields->type == DATA_TYPE_TEXTBOX_EMAIL)
        {
            /*$this->_CI->load->helper("email");

            if (!valid_email($value))
            {
                $message    .= "Field <b>".$fields->form->label."</b> not valid.<br>";
            }*/
        }

        return $message;
    }

    // Import
    public function import_upload()
    {
        $config["allowed_types"] = implode("|", array("xls", "xlsx", "csv"));

        $dir                   = $this->filelib->_dir_file;
        $config["upload_path"] = "./".$dir;

        $this->_CI->load->library('upload', $config);

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path']);
        }

        if ($this->_CI->upload->do_upload('file'))
        {
            $file_data      = $this->_CI->upload->data();

            $temp_file      = $file_data['full_path'];
            $new_file_name  = md5(date("YmdHis")."_".$file_data["file_name"]).$file_data["file_ext"];
            rename($temp_file, $file_data["file_path"].$new_file_name);

            $file["file_name_ori"]   = $file_data["file_name"];
            $file["file_name"]       = $new_file_name;
            $file["file_loc"]        = $dir.$new_file_name;
            $file["file_size"]       = $file_data["file_size"];
            $file["file_ext"]        = $file_data["file_ext"];

            $file["file_ext"]   = str_ireplace(".", "", $file["file_ext"]);

            $data_file          = array(
                "file_name_ori"     => $file["file_name_ori"],
                "file_name"         => $file["file_name"],
                "file_ext"          => $file["file_ext"],
                "file_ext"          => str_ireplace(".", "", $file["file_ext"]),
                "file_size"         => $file["file_size"],
            );

            $field  = $this->_initial->fields;

            if (in_array($data_file["file_ext"], array("xls", "xlsx")))
            {
                $data   = $this->utils->read_file_excel($file["file_loc"]);

                foreach ($data["header"] as $a => $header)
                {
                    $tmp_field  = $this->get_field_by_label("datatable", $header);
                    $data["header"][$a] = array(
                        "label" => $header,
                        "field" => !empty($tmp_field) ? $tmp_field : array()
                    );
                }
                foreach ($data["values"] as $a => $values)
                {
                    foreach ($values as $b => $value)
                    {
                        if ($value == ""){
                            $data["values"][$a][$b] = "";
                        }
                    }
                }

                $this->_CI->session->set_userdata(array(
                    "tmp_import"	=> array(
                        "fields"    => $field,
                        "headers"   => $data["header"],
                        "bodies"    => $data["values"],
                        "file"      => $file["file_name"]
                    )
                ));
            }

            $result     = "success";
            $message    = "";
        }
        else
        {
            $result     = "error";
            $message    = strip_tags($this->_CI->upload->display_errors());
        }

        return array(
            "result"    => $result,
            "message"   => $message,
        );
    }
    public function import_data($type = "header")
    {
        $imports_data   = $this->_CI->session->userdata("tmp_import");

        if (!empty($imports_data))
        {
            $result = array();
            $result["fields"]   = $imports_data["fields"];

            if ($type == "header")
            {
                $content    = $this->_CI->load->view("template/datatable/import-header", $imports_data, true);

                $result["header"]   = $imports_data["headers"];
                $result["content"]  = $content;
            }
            else
            {
                $content    = $this->_CI->load->view("template/datatable/import-preview", $imports_data, true);

                $result["header"]   = $imports_data["headers"];
                $result["content"]  = $content;
            }
            return $result;
        }
        return false;
    }
    public function import_update($type, $imports_data)
    {
        $tmp_data       = $this->_CI->session->userdata("tmp_import");

        if ($type == "header")
        {
            $headers    = $imports_data["headers"];

            $tmp_header = array();

            foreach ($tmp_data["headers"] as $key => $tmp_datum)
            {
                $tmp_header[$key]   = $tmp_datum;
                $field_id           = $headers[$key];
                $field              = $this->get_field_by_field_name($field_id);

                if (array_key_exists($key, $headers))
                {
                    $tmp_header[$key]["field"]  = $field;
                }
            }

            $tmp_data["headers"]    = $tmp_header;

            $this->_CI->session->set_userdata(array(
                "tmp_import"    => $tmp_data
            ));

        }
        else
        {

        }

        return false;


    }
    public function import_save($param)
    {
        $data       = !empty($param["data"]) ? $param["data"] : array();
        $result     = RESULT_ERROR;
        $message    = "";

        if (!empty($data))
        {
            $result         = RESULT_SUCCESS;
            $tmp            = $this->_CI->session->userdata("tmp_import");
            $tmp_headers    = $tmp["headers"];
            $tmp_values     = $tmp["bodies"];

            $tmp_message    = array(
                "headers"   => array("RESULT"),
                "bodies"    => array()
            );

            $table_primary  = $this->utils->search_array($this->_initial->sources, "table_primary", 1, false, true);
            $fields_primary = $table_primary["data"]["tmp_fields"];

            foreach ($tmp_headers as $header)
            {
                $tmp_message["headers"][]  = $header["label"];
            }
            foreach ($tmp_values as $key_value => $item_value)
            {
                $tmp_message_bodies = array();
                $field_sysdate      = $this->get_field_by_type(DATA_TYPE_SYSDATE);

                if (in_array($key_value, $data))
                {
                    $data_saved         = array();

                    foreach ($item_value as $key => $value)
                    {
                        $header     = !empty($tmp_headers[$key]) ? $tmp_headers[$key] : "";
                        $field      = !empty($header["field"]) ? $header["field"] : array();
                        $value      = trim($value);

                        if ($value != "" && !empty($field))
                        {
                            if (in_array($field->type, $this->_field_type_select_key))
                            {
                                $list       = !empty($field->other["list"]) ? (array) $field->other["list"] : array();
                                $key_data   = array_search($value, $list);

                                if (in_array($field->field, $fields_primary)){
                                    $data_saved[$field->field]    = $key_data;
                                }
                            }
                            else if (in_array($field->type, $this->_field_type_joins))
                            {
                                $source         = $field->other["source"];
                                $data_tmp       = $source["data"];
                                $field_key      = $source["field_key"];
                                $field_label    = $source["field_label"];

                                if (in_array($field->field, $fields_primary))
                                {
                                    $search     = $this->utils->search_array($data_tmp, $field_label, $value, false, true);
                                    $tmp_value  = "";

                                    if ($search !== false)
                                    {
                                        $tmp_value  = $search["data"][$field_key];
                                    }

                                    $data_saved[$field->field]    = $tmp_value;
                                }
                            }
                            else if (in_array($field->type, array(DATA_TYPE_DATETIME, DATA_TYPE_DATE, DATA_TYPE_TIME)))
                            {
                                $format_date    = "Y-m-d";
                                $format_time    = "H:i:s";

                                if ($field->type == DATA_TYPE_DATETIME){
                                    $format = $format_date." ".$format_time;
                                } else if ($field->type == DATA_TYPE_DATE){
                                    $format = $format_date;
                                } else if ($field->type == DATA_TYPE_TIME){
                                    $format = $format_time;
                                }

                                $value  = date($format, strtotime($value));

                                if (in_array($field->field, $fields_primary)){
                                    $data_saved[$field->field]    = $value;
                                }
                            }
                            else
                            {
                                if (in_array($field->field, $fields_primary)){
                                    $data_saved[$field->field]    = $value;
                                }
                            }
                        }

                        $tmp_message_bodies[]   = $value;
                    }

                    if (!empty($data_saved))
                    {
                        foreach ($field_sysdate as $sysdate)
                        {
                            if (!in_array($sysdate->field, array("created", "updated")))
                                $data_saved[$sysdate->field]  = date("Y-m-d H:i:s");
                        }

                        $primary_key        = $this->_initial->field_primary;

                        $logs_datatable     = $this->_initial;
                        $logs_tmp           = !empty($data_saved[$primary_key]) ? $this->get_detail($data_saved[$primary_key], "detail") : array();
                        $logs_tmp           = !empty($logs_tmp) && !empty($logs_tmp["data"]) ? $logs_tmp["data"] : array();
                        $logs_data          = $data_saved;
                        $logs_user          = $this->_user;

                        if (array_key_exists($primary_key, $data_saved))
                        {
                            $data_saved["updated"]      = date("Y-m-d H:i:s");
                            $data_saved["updatedby"]    = $this->_user->id;
                            $this->general->update($this->_initial->table_name, array(
                                "id"    => array(
                                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                                    SQL_CONDITION_VALUE     => $data_saved[$primary_key]
                                )
                            ), $data_saved);
                            $data_status            = "<span class='label label-info'>Data Updated</span>";
                            $primary_key            = $data_saved[$primary_key];
                        }
                        else
                        {
                            $data_saved["created"]      = date("Y-m-d H:i:s");
                            $data_saved["createdby"]    = $this->_user->id;
                            $data_saved["updated"]      = date("Y-m-d H:i:s");
                            $data_saved["updatedby"]    = $this->_user->id;
                            $primary_key                = $this->general->insert($this->_initial->table_name, $data_saved);
                            $data_status                = "<span class='label label-success'>Data Saved</span>";

                        }

                        $logs_data          = !empty($primary_key) ? $this->get_detail($primary_key, "detail") : array();
                        $logs_data          = !empty($logs_data) && !empty($logs_data["data"]) ? $logs_data["data"] : array();

                        $this->logs->create_log_datatable($logs_datatable, $logs_tmp, $logs_data, $primary_key, $logs_user);
                    }
                    else
                    {
                        $data_status    = "<span class='label label-warning'>Failed Save</span>";
                    }

                    array_unshift($tmp_message_bodies, $data_status);
                }
                else
                {
                    $tmp_message_bodies[]   = "<span class='label label-default'>Not Selected</span>";
                    foreach ($item_value as $key => $value)
                    {
                        $tmp_message_bodies[]   = $value;
                    }

                }

                $tmp_message["bodies"][]    = $tmp_message_bodies;
            }

            $message    = $this->_CI->load->view("template/datatable/import-result", $tmp_message, true);
            $this->_CI->session->unset_userdata("tmp_import");
        }
        else
        {
            $message    = "Please select the data to be saved.";
        }

        return array(
            "result"    => $result,
            "message"   => $message
        );

    }


    public function get_field_by_field_name($fieldname, $return_key = false)
    {
        $initial    = $this->_initial;

        foreach ($initial->fields as $key => $item_field)
        {
            if (!empty($item_field->field) && $item_field->field == $fieldname){
                if ($return_key){
                    return $key;
                }else{
                    return $item_field;
                }
            }
        }

        return false;
    }
    public function get_field_by_label($type, $value, $return_key = false)
    {
        $initial    = $this->_initial;

        foreach ($initial->fields as $key => $item_field)
        {
            if (!empty($item_field->$type->label) && $item_field->$type->label == $value){
                if ($return_key){
                    return $key;
                }else{
                    return $item_field;
                }
            }
        }

        return false;
    }
    public function get_field_by_type($type, $return_key = false)
    {
        $initial    = $this->_initial;
        $result     = array();

        foreach ($initial->fields as $key => $item_field)
        {
            if (!empty($item_field->type) && $item_field->type == $type)
            {
                if ($return_key){
                    $result[]   = $key;
                }else{
                    $result[]   = $item_field;
                }
            }
        }

        return $result;
    }

    public function generate_query_select_metadata($id_object, $fields)
    {
        $id_field   = $this->encryptlib->decode($fields->hash);
        $query      = "(SELECT __sys_metadata.value FROM __sys_metadata WHERE id_object = '".$id_object."' AND id_field = '".$id_field."' LIMIT 1) AS '" . $fields->name . "'";

        return $query;

    }
    public function set_metadata($id_object, $data)
    {
        if (!empty($id_object) && !empty($data))
        {
            $id_field   = array();
            foreach ($data as $key => $item)
            {
                $data[$key]["id_object"]    = $id_object;
                $id_field[]                 = $item["id_field"];

                $this->general->update_dynamic("__sys_metadata", array(
                    "id_object"     => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $id_object
                    ),
                    "id_field"      => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $item["id_field"]
                    ),
                ), $data[$key]);
            }

            $this->general->delete("__sys_metadata", array(
                "id_object" => array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                    SQL_CONDITION_VALUE     => $id_object
                ),
                "id_field"  => array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_NOT_IN,
                    SQL_CONDITION_VALUE     => $id_field
                )
            ));
        }
    }

    protected function check_session($table_name)
    {
        $session_initial    = $this->_CI->session->userdata("session-datatable");
        $master_reset       = array();

        if (!empty($session_initial))
        {
            foreach ($session_initial as $master_name => $master)
            {
                if (!empty($master->sources))
                {
                    foreach ($master->sources as $source)
                    {
                        if ($source->table_name == $table_name && !in_array($master_name, $master_reset))
                        {
                            $master_reset[] = $master_name;
                        }
                    }
                }
            }
        }

        $this->reset_session($master_reset);
    }
    public function reset_session($masters = array())
    {
        $session_initial    = $this->_CI->session->userdata("session-datatable");
        $new_initial        = array();

        if (!empty($session_initial))
        {
            foreach ($session_initial as $master_name => $master)
            {
                if (!in_array($master_name, $masters))
                {
                    $new_initial[$master_name]  = $master;
                }
            }

            $this->_CI->session->set_userdata(array(
                "session-datatable"	=> $new_initial
            ));
        }
    }
}