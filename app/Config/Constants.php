<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

/*
 | --------------------------------------------------------------------------
 | BASE URL
 | --------------------------------------------------------------------------
 |
 | dynamic create url for base_url() function
 */
$server_name = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost:8080';
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://" .  $server_name;
if ($server_name == 'localhost' OR filter_var($server_name, FILTER_VALIDATE_IP)) {
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
}
defined('BASE') || define('BASE', $base_url);


/*ENVIRONMENT*/
defined("ENVIRONMENT_PRODUCTION")               || define("ENVIRONMENT_PRODUCTION", "production");
defined("ENVIRONMENT_TESTING")                  || define("ENVIRONMENT_TESTING", "testing");
defined("ENVIRONMENT_DEVELOPMENT")              || define("ENVIRONMENT_DEVELOPMENT", "development");

// User Roless
defined("ROLE_SUPERADMIN")                      || define("ROLE_SUPERADMIN", "Superadmin");
defined("ROLE_ADMINISTRATOR")                   || define("ROLE_ADMINISTRATOR", "Administrator");
defined("ROLE_OPERATOR")                        || define("ROLE_OPERATOR", "Operator");
defined("ROLE_VERIFIKATOR")                     || define("ROLE_VERIFIKATOR", "Verifikator");
defined("ROLE_PENGGUNA")                        || define("ROLE_PENGGUNA", "Pengguna");

// Ajax Result
defined("RESULT_ERROR")                         || define("RESULT_ERROR", "error");
defined("RESULT_SUCCESS")                       || define("RESULT_SUCCESS", "success");
defined("RESULT_HOLD")                          || define("RESULT_HOLD", "hold");
defined("RESULT_ABORT")                         || define("RESULT_ABORT", "abort");

// SQL Query Condition
defined('SQL_CONDITION_FIELD')                  || define('SQL_CONDITION_FIELD', "field");
defined('SQL_CONDITION_OPERATOR')               || define('SQL_CONDITION_OPERATOR', "op");
defined('SQL_CONDITION_VALUE')                  || define('SQL_CONDITION_VALUE', "val");
defined('SQL_CONDITION_QUERY')                  || define('SQL_CONDITION_QUERY', "query");
defined('SQL_CONDITION_OR_QUERY')               || define('SQL_CONDITION_OR_QUERY', "or_query");

defined('SQL_WHERE_EQUAL')                      || define('SQL_WHERE_EQUAL', "EQUAL");
defined('SQL_WHERE_NULL')                       || define('SQL_WHERE_NULL', "NULL");
defined('SQL_WHERE_NOT_NULL')                   || define('SQL_WHERE_NOT_NULL', "NOTNULL");
defined('SQL_WHERE_GREATER_THAN')               || define('SQL_WHERE_GREATER_THAN', "GREATER_THAN");
defined('SQL_WHERE_LESS_THAN')                  || define('SQL_WHERE_LESS_THAN', "LESS_THAN");
defined('SQL_WHERE_GREATER_EQUAL')              || define('SQL_WHERE_GREATER_EQUAL', "GREATER_EQUAL");
defined('SQL_WHERE_LESS_EQUAL')                 || define('SQL_WHERE_LESS_EQUAL', "LESS_EQUAL");
defined('SQL_WHERE_NOT_EQUAL')                  || define('SQL_WHERE_NOT_EQUAL', "NOT_EQUAL");

defined('SQL_WHERE_LIKE')                       || define('SQL_WHERE_LIKE', "LIKE");
defined('SQL_WHERE_LIKE_BEFORE')                || define('SQL_WHERE_LIKE_BEFORE', "LIKE_BEFORE");
defined('SQL_WHERE_LIKE_AFTER')                 || define('SQL_WHERE_LIKE_AFTER', "LIKE_AFTER");
defined('SQL_WHERE_NOT_LIKE')                   || define('SQL_WHERE_NOT_LIKE', "NOT_LIKE");
defined('SQL_WHERE_BETWEEN')                    || define('SQL_WHERE_BETWEEN', "BETWEEN");
defined('SQL_WHERE_IN')                         || define('SQL_WHERE_IN', "IN");
defined('SQL_WHERE_NOT_IN')                     || define('SQL_WHERE_NOT_IN', "NOT_IN");

defined('SQL_WHERE_OR_EQUAL')                   || define('SQL_WHERE_OR_EQUAL', "=");
defined('SQL_WHERE_OR_GREATER_THAN')            || define('SQL_WHERE_OR_GREATER_THAN', ">");
defined('SQL_WHERE_OR_LESS_THAN')               || define('SQL_WHERE_OR_LESS_THAN', ">");
defined('SQL_WHERE_OR_GREATER_EQUAL')           || define('SQL_WHERE_OR_GREATER_EQUAL', ">=");
defined('SQL_WHERE_OR_LESS_EQUAL')              || define('SQL_WHERE_OR_LESS_EQUAL', "<=");
defined('SQL_WHERE_OR_NOT_EQUAL')               || define('SQL_WHERE_OR_NOT_EQUAL', "<>");

defined('SQL_WHERE_OR_LIKE')                    || define('SQL_WHERE_OR_LIKE', "LIKE");
defined('SQL_WHERE_OR_BETWEEN')                 || define('SQL_WHERE_OR_BETWEEN', "OR_BETWEEN");
defined('SQL_WHERE_OR_IN')                      || define('SQL_WHERE_OR_IN', "IN");
defined('SQL_WHERE_OR_NOT_IN')                  || define('SQL_WHERE_OR_NOT_IN', "NOT_IN");

defined('SQL_SEPARATOR_DB')                     || define('SQL_SEPARATOR_DB', ",");
defined('SQL_SEPARATOR_CONCAT')                 || define('SQL_SEPARATOR_CONCAT', "<br>");

defined("SOURCE_TYPE_FIELD")                    || define("SOURCE_TYPE_FIELD", "FIELD");
defined("SOURCE_TYPE_METADATA")                 || define("SOURCE_TYPE_METADATA", "METADATA");

defined("DATATABLE_POST")                       || define("DATATABLE_POST", "POST");
defined("DATATABLE_GET")                        || define("DATATABLE_GET", "GET");

defined("DATATABLE_TYPE_TABLE")                 || define("DATATABLE_TYPE_TABLE", "DATATABLE");
defined("DATATABLE_TYPE_TREE")                  || define("DATATABLE_TYPE_TREE", "TREETABLE");

defined("DATA_TYPE_ACTION")                     || define("DATA_TYPE_ACTION", "xxxxxx");
defined("DATA_TYPE_ID")                         || define("DATA_TYPE_ID", "ID");
defined("DATA_TYPE_AUTO_INCREMENT")             || define("DATA_TYPE_AUTO_INCREMENT", "Autoincrement");
defined("DATA_TYPE_TEXTBOX")                    || define("DATA_TYPE_TEXTBOX", "Text");
defined("DATA_TYPE_TEXTBOX_EMAIL")              || define("DATA_TYPE_TEXTBOX_EMAIL", "Email");
defined("DATA_TYPE_TEXTBOX_PASSWORD")           || define("DATA_TYPE_TEXTBOX_PASSWORD", "Password");
defined("DATA_TYPE_NUMBER")                     || define("DATA_TYPE_NUMBER", "Number");
defined("DATA_TYPE_ENCRYPTION")                 || define("DATA_TYPE_ENCRYPTION", "Encryption");
defined("DATA_TYPE_DECIMAL")                    || define("DATA_TYPE_DECIMAL", "Decimal");
defined("DATA_TYPE_TEXTAREA")                   || define("DATA_TYPE_TEXTAREA", "Textarea");
defined("DATA_TYPE_HTML")                       || define("DATA_TYPE_HTML", "HTML");

defined("DATA_TYPE_DATE")                       || define("DATA_TYPE_DATE", "Date");
defined("DATA_TYPE_TIME")                       || define("DATA_TYPE_TIME", "Time");
defined("DATA_TYPE_DATETIME")                   || define("DATA_TYPE_DATETIME", "DateTime");
defined("DATA_TYPE_SYSDATE")                    || define("DATA_TYPE_SYSDATE", "Sysdate");

defined("DATA_TYPE_SELECT_LIST_KEY")            || define("DATA_TYPE_SELECT_LIST_KEY", "Select List Key");
defined("DATA_TYPE_SELECT_LIST_VALUE")          || define("DATA_TYPE_SELECT_LIST_VALUE", "Select List Value");
defined("DATA_TYPE_SELECT_MASTER")              || define("DATA_TYPE_SELECT_MASTER", "Select Master");
defined("DATA_TYPE_SELECT_MASTER_TREE")         || define("DATA_TYPE_SELECT_MASTER_TREE", "Select Master Tree");
defined("DATA_TYPE_SELECT_TAGS")                || define("DATA_TYPE_SELECT_TAGS", "Select Tags");

defined("DATA_TYPE_MULTISELECT")                || define("DATA_TYPE_MULTISELECT", "Multi Select");
defined("DATA_TYPE_MULTISELECT_MASTER")         || define("DATA_TYPE_MULTISELECT_MASTER", "Multi Select Master");

defined("DATA_TYPE_ICON")                       || define("DATA_TYPE_ICON", "List Icon");

// input Radio
defined("DATA_TYPE_RADIO_KEY")                  || define("DATA_TYPE_RADIO_KEY", "Radio Key");
defined("DATA_TYPE_RADIO_VALUE")                || define("DATA_TYPE_RADIO_VALUE", "Radio Value");
defined("DATA_TYPE_RADIO_MASTER")               || define("DATA_TYPE_RADIO_MASTER", "Radio Master");
defined("DATA_TYPE_RADIO_KEY_HORIZONTAL")       || define("DATA_TYPE_RADIO_KEY_HORIZONTAL", "Radio Key Horizontal");
defined("DATA_TYPE_RADIO_VALUE_HORIZONTAL")     || define("DATA_TYPE_RADIO_VALUE_HORIZONTAL", "Radio Value Horizontal");

// input Checkbox
defined("DATA_TYPE_CHECKBOX")                   || define("DATA_TYPE_CHECKBOX", "Checkbox");
defined("DATA_TYPE_CHECKBOX_KEY")               || define("DATA_TYPE_CHECKBOX_KEY", "Checkbox Key");
defined("DATA_TYPE_CHECKBOX_MASTER")            || define("DATA_TYPE_CHECKBOX_MASTER", "Checkbox Master");

defined("DATA_TYPE_CUSTOM_CHECKBOX_MASTER")     || define("DATA_TYPE_CUSTOM_CHECKBOX_MASTER", "Custom Checkbox Master");
defined("DATA_TYPE_CUSTOM_CHECKBOX_KEY")        || define("DATA_TYPE_CUSTOM_CHECKBOX_KEY", "Custom Checkbox Key");
defined("DATA_TYPE_CUSTOM_CHECKBOX_VALUE")      || define("DATA_TYPE_CUSTOM_CHECKBOX_VALUE", "Custom Checkbox Value");
defined("DATA_TYPE_CUSTOM_RADIO_MASTER")        || define("DATA_TYPE_CUSTOM_RADIO_MASTER", "Custom Radio Master");
defined("DATA_TYPE_CUSTOM_RADIO_KEY")           || define("DATA_TYPE_CUSTOM_RADIO_KEY", "Custom Radio Key");
defined("DATA_TYPE_CUSTOM_RADIO_VALUE")         || define("DATA_TYPE_CUSTOM_RADIO_VALUE", "Custom Radio Value");

defined("DATA_TYPE_FILE")                       || define("DATA_TYPE_FILE", "File");
defined("DATA_TYPE_FILE_ARCHIVE")               || define("DATA_TYPE_FILE_ARCHIVE", "File Archive");
defined("DATA_TYPE_FILE_IMAGE")                 || define("DATA_TYPE_FILE_IMAGE", "File Image");
defined("DATA_TYPE_FILE_DOC")                   || define("DATA_TYPE_FILE_DOC", "File Document");
defined("DATA_TYPE_FILE_VIDEO")                 || define("DATA_TYPE_FILE_VIDEO", "File Video");
defined("DATA_TYPE_FILE_AUDIO")                 || define("DATA_TYPE_FILE_AUDIO", "File Audio");

defined("DATA_TYPE_FILE_3D")                    || define("DATA_TYPE_FILE_3D", "3D");
defined("DATA_TYPE_FILE_MULTIPLE")              || define("DATA_TYPE_FILE_MULTIPLE", "File Multiple");
defined("DATA_TYPE_FILE_ARCHIVE_MULTIPLE")      || define("DATA_TYPE_FILE_ARCHIVE_MULTIPLE", "File Archive Multiple");
defined("DATA_TYPE_FILE_IMAGE_MULTIPLE")        || define("DATA_TYPE_FILE_IMAGE_MULTIPLE", "File Image Multiple");
defined("DATA_TYPE_FILE_DOC_MULTIPLE")          || define("DATA_TYPE_FILE_DOC_MULTIPLE", "File Document Multiple");
defined("DATA_TYPE_FILE_VIDEO_MULTIPLE")        || define("DATA_TYPE_FILE_VIDEO_MULTIPLE", "File Video Multiple");
defined("DATA_TYPE_FILE_AUDIO_MULTIPLE")        || define("DATA_TYPE_FILE_AUDIO_MULTIPLE", "File Audio Multiple");

defined("DATA_TYPE_FILE_LINK")                  || define("DATA_TYPE_FILE_LINK", "File Link");

defined("DATA_TYPE_QUERY")                      || define("DATA_TYPE_QUERY", "Query");

defined("DATA_MULTI_SEPARATOR")                 || define("DATA_MULTI_SEPARATOR", ",");

// Form Validation
defined("VALIDATION_REQUIRED")                  || define("VALIDATION_REQUIRED", "required");
defined("VALIDATION_UNIQUE")                    || define("VALIDATION_UNIQUE", "unique");
defined("VALIDATION_IN_RANGE")                  || define("VALIDATION_IN_RANGE", "in_range");

defined("BUTTON_TABLE_ADD")                     || define("BUTTON_TABLE_ADD", "ADD");
defined("BUTTON_TABLE_CLEAR")                   || define("BUTTON_TABLE_CLEAR", "CLEAR");
defined("BUTTON_TABLE_DELETE")                  || define("BUTTON_TABLE_DELETE", "DELETE");
defined("BUTTON_TABLE_EXPORT")                  || define("BUTTON_TABLE_EXPORT", "EXPORT");
defined("BUTTON_TABLE_IMPORT")                  || define("BUTTON_TABLE_IMPORT", "IMPORT");
defined("BUTTON_TABLE_REFRESH")                 || define("BUTTON_TABLE_REFRESH", "REFRESH");

defined("BUTTON_ACTION_VIEW_LINK")              || define("BUTTON_ACTION_VIEW_LINK", "ACTION_VIEW_LINK");
defined("BUTTON_ACTION_VIEW_POPUP")             || define("BUTTON_ACTION_VIEW_POPUP", "ACTION_VIEW_POPUP");
defined("BUTTON_ACTION_EDIT")                   || define("BUTTON_ACTION_EDIT", "ACTION_EDIT");
defined("BUTTON_ACTION_DELETE")                 || define("BUTTON_ACTION_DELETE", "ACTION_DELETE");

// File View
defined("FILE_VIEW_TABLE")                      || define("FILE_VIEW_TABLE", 1);
defined("FILE_VIEW_FORM")                       || define("FILE_VIEW_FORM", 2);
defined("FILE_VIEW_LIST")                       || define("FILE_VIEW_LIST", 3);
defined("FILE_VIEW_DETAIL")                     || define("FILE_VIEW_DETAIL", 4);
defined("FILE_VIEW_LIST_READONLY")              || define("FILE_VIEW_LIST_READONLY", 5);
defined("FILE_VIEW_HEADER")                     || define("FILE_VIEW_HEADER", 6);

defined("IMAGE_DEFAULT")                        || define("IMAGE_DEFAULT", "default.jpg");

defined("SEPARATOR_DECIMAL")                    || define("SEPARATOR_DECIMAL", ",");
defined("SEPARATOR_THOUSANDS")                  || define("SEPARATOR_THOUSANDS", ".");
defined("DECIMAL_LENGTH")                       || define("DECIMAL_LENGTH", 2);
defined("PERMISSION_VIEW")                      || define("PERMISSION_VIEW", "VIEW");
defined("PERMISSION_CREATE")                    || define("PERMISSION_CREATE", "CREATE");
defined("PERMISSION_UPDATE")                    || define("PERMISSION_UPDATE", "UPDATE");
defined("PERMISSION_DELETE")                    || define("PERMISSION_DELETE", "DELETE");


/*defined("K_PATH_IMAGES")                        || define("K_PATH_IMAGES", realpath("public/images/"));
defined("PDF_HEADER_LOGO")                      || define("PDF_HEADER_LOGO", realpath("logo-esdm.png"));*/
