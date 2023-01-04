<?php

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLUploadExcelFileFromNetwork.php';

class UploadExcelTransaction
{

    public function execute_in_a_transaction($dta, $table_a, $table_b, $table_c, $table_d)
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        try {
            $thisPDO->beginTransaction();

            $rk = new MDLUploadExcelFileFromNetwork();

            $rk->uploadCollateralFileMDL($dta, $table_a, $table_b, $table_c, $table_d);
            $rk->upload_bonds_and_guaranteeFileMDL($dta, $table_a, $table_b, $table_c, $table_d);
            $rk->upload_loans_FileMDL($dta, $table_a, $table_b, $table_c, $table_d);
            $rk->upload_overdraft_FileMDL($dta, $table_a, $table_b, $table_c, $table_d);

            $thisPDO->commit();

        } catch (\PDOException $e) {

            $thisPDO->rollBack();
          
            echo $e->getMessage();
        }
    }
}
