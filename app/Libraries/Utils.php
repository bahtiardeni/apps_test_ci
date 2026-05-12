<?php
namespace App\Libraries;
use App\Models\GeneralModel;
use CodeIgniter\HTTP\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class Utils
 *
 * Model
 * @property GeneralModel   $general
 *
 * Library
 * @property Session        $session
 *
 */
class Utils
{
    public function __construct()
    {
        $this->general          = new GeneralModel();
        $this->request          = \Config\Services::request();
    }

    function search_array($arrays = array(), $field = null, $value = null, $return_key = false, $return_data = false)
    {
        foreach ($arrays as $key => $val)
        {
            $val    = (array) $val;

            if (is_array($field) && is_array($value))
            {
                $found_data = array();

                for ($i = 0; $i < count($field); $i++)
                {
                    $tmp_field  = $field[$i];
                    $tmp_value  = $value[$i];

                    if (strtolower($val[$tmp_field]) === strtolower($tmp_value))
                    {
                        $found_data[]   = true;
                    }
                    else
                    {
                        $found_data[]   = false ;
                    }
                }

                if (!in_array(false, $found_data))
                {
                    if ($return_data){
                        return array(
                            "key"   => $key,
                            "data"  => $val
                        );
                    }

                    if ($return_key){
                        return $key;
                    }else{
                        return true;
                    }
                }
            }
            else
            {
                if (array_key_exists($field, $val) && strtolower($val[$field]) === strtolower($value))
                {

                    if ($return_data){
                        return array(
                            "key"   => $key,
                            "data"  => $val
                        );
                    }

                    if ($return_key){
                        return $key;
                    }else{
                        return true;
                    }
                }
            }

        }
        return false;
    }
    function number_format($value = 0, $decimal = 0)
    {
        return number_format($value, $decimal, SEPARATOR_DECIMAL, SEPARATOR_THOUSANDS);
    }
    function date_forrmat_indonesia($date, $format = "Y-m-d")
    {
        $month = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $date               = is_int($date) ? $date : strtotime($date);
        $month_date_name    = date("F", $date);
        $month_date         = date("n", $date);

        if (strpos(date($format, $date), $month_date_name) !== false) {
            $return = date($format, $date);
            $return = str_replace($month_date_name, $month[$month_date], $return);
        }else{
            $return = date($format, $date);
        }


        return $return;
    }
    function isLocal()
    {
        $host       = base_url();
        $ip_address = $this->request->getIPAddress();

        if (strpos($host, 'localhost') !== false || strpos($host, '.local') !== false || $ip_address == "127.0.0.1") {
            return true;
        }else{
            return false;
        }
    }
    function get_config($conditions, $single = true)
    {
        $new_conditions = array();
        foreach ($conditions as $key => $value)
        {
            $new_conditions[$key]   = array(
                SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                SQL_CONDITION_VALUE     => $value
            );
        }
        $configs    = $this->general->get_data("__sys_config", $new_conditions);

        if ($single)
        {
            $configs    = $configs->getRow();

            if (!empty($configs))
            {
                $value = @json_decode($configs->value, 1);

                if (!empty($value)){
                    $configs->value = $value;
                }
            }
        }
        else
        {
            $configs    = $configs->getResult();
        }

        return $configs;
    }
    function set_config($name, $data = "")
    {
        if (!empty($name))
        {
            $config     = $this->general->get_data("__sys_config", array(
                "name"  => array(
                    SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                    SQL_CONDITION_VALUE     => $name
                )
            ))->getRow();

            if (!empty($config))
            {
                $config_value       = @json_decode($config->value, 1);

                if ($config_value === null && json_last_error() !== JSON_ERROR_NONE)
                {
                    $config_value   = $config->value;
                }
                else
                {
                    if (is_array($config_value) && is_array($data["value"]))
                    {
                        foreach ($data["value"] as $tmp_key => $tmp_value)
                        {
                            $config_value[$tmp_key]    = $tmp_value;
                        }
                    }
                    else
                    {
                        $config_value   = $data["value"];
                    }
                }

                $data["value"]      = $config_value;

                $this->general->update("__sys_config", array(
                    "name"  => array(
                        SQL_CONDITION_OPERATOR  => SQL_WHERE_EQUAL,
                        SQL_CONDITION_VALUE     => $name
                    )
                ), $data);
            }
            else
            {
                $this->general->insert("__sys_config", $data);
            }

        }
    }
    function get_random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function create_excel_file($param)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getProperties()->setTitle($param["file_name"]);

        $sharedStyleHead = array(
            'fill' => array(
                'fillType'          => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor'        => array('argb' => 'FF4F81BD')
            ),
            'borders' => array(
                'outline' => array(
                    'borderStyle'   => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color'         => array('argb' => '99999999'),
                ),
            )
        );

        $sharedStyleBody = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle'   => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color'         => array('argb' => '99999999'),
                ),
            ),
        );

        $headers    = $param["headers"];
        $bodies     = $param["data"];

        $col        = "A";
        foreach ($headers as $key => $header)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col."1", $header);
            $objPHPExcel->getActiveSheet()->getStyle($col."1")->applyFromArray($sharedStyleHead);
            $col++;
        }

        $row        = 2;
        foreach ($bodies as $data)
        {
            $col        = "A";

            foreach ($data as $value)
            {
                $value  = $value != "" && $value != null ? strip_tags($value) : "";
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$row, $value);
                $objPHPExcel->getActiveSheet()->getStyle($col.$row)->applyFromArray($sharedStyleBody);

                $col++;
            }
            $row++;
        }


        foreach(range("A",$col) as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        $objPHPExcel->getActiveSheet()->setTitle(!empty($param["title"]) ? $param["title"] : "Data");

        $writer = new Xlsx($objPHPExcel);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $param["file_name"] .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        die;

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$param["file_name"].'.xlsx"');
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

        die;
    }
}