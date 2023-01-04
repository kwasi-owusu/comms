<?php


!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLBranchWiseReport.php';


class BranchWiseReportCTRL
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

    public function get_bonds_and_guarantee_records_by_branch(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfBondsAndGuarantee = new MDLBranchWiseReport($newPDO, $thisPDO);
        
        $bonds_and_guarantee_records_rst = $instanceOfBondsAndGuarantee->bonds_and_guarantee_records_by_branch($this->table_a, $this->table_b, $this->table_c, $this->table_d);

        return $bonds_and_guarantee_records_rst;
    }

    public function get_loans_records_by_branch(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfLoans = new MDLBranchWiseReport($newPDO, $thisPDO);
        
        $loans_records_rst = $instanceOfLoans->loans_records_by_branch($this->table_a, $this->table_b, $this->table_c, $this->table_d);

        return $loans_records_rst;
    }

    public function get_overdraft_records_by_branch(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfOverdraft = new MDLBranchWiseReport($newPDO, $thisPDO);
        
        $overdraft_records_rst = $instanceOfOverdraft->overdraft_records_by_branch($this->table_a, $this->table_b, $this->table_c, $this->table_d);

        return $overdraft_records_rst;
    }
}
