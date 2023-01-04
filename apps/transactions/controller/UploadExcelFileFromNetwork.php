<?php

class UploadExcelFileFromNetwork
{

    private string $table_a;
    private string $table_b;
    private string $table_c;
    private string $table_d;

    public function __construct($table_a, $table_b, $table_c, $table_d)
    {
        $this->table_a = $table_a;
        $this->table_b = $table_b;
        $this->table_c = $table_c;
        $this->table_d = $table_d;
    }

    public function loadExcelFileFromNetwork()
    {

        $error = false;

        $this_file = 'C:/Users/Bsystems/Documents/Projects/Collateral Management/This Sample Data.xlsx';

        $allowedFileType = [
            'application/vnd.ms-excel',
            'text/xls',
            'text/xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        $file_info = new finfo(FILEINFO_MIME_TYPE);

        $file_mime_type = $file_info->buffer(file_get_contents($this_file));
        
        echo $file_mime_type. "<br />";

        if (isset($this_file) && in_array($file_mime_type, $allowedFileType)) {

            //echo "<p>Hurray! File allowed</p>";
            
            require_once dirname(__DIR__) . '/model/UploadExcelTransaction.php';
            require_once dirname(__DIR__) . '/model/MDLUploadExcelFileFromNetwork.php';

            $excel_upload_instance = new UploadExcelTransaction();
            
            $dta = array(
                'excelFile' => $this_file
            );

            if($excel_upload_instance->execute_in_a_transaction($dta, $this->table_a, $this->table_b, $this->table_c, $this->table_d)){
                echo "<br />Successfully uploaded ". $this_file;
            }
            else{
                echo "<br />Successfully uploaded ". $this_file;
            }

        } else {
            $error = true;
            echo "Invalid File Type. Upload Excel File.";
        }
    }
}
$callClass  = new UploadExcelFileFromNetwork('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register');
$callMethod = $callClass->loadExcelFileFromNetwork();
