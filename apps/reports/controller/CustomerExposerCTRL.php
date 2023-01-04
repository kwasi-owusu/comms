<?php

!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLCustomerExposer.php';


class CustomerExposerCTRL
{

    private string $table_a;
    private string $table_b;
    private string $table_c;
    private string $table_d;
    private string $table_e;

    public function __construct($table_a, $table_b, $table_c, $table_d, $table_e)
    {

        $this->table_a = $table_a;
        $this->table_b = $table_b;
        $this->table_c = $table_c;
        $this->table_d = $table_d;
        $this->table_e = $table_e;
    }

    public function get_customer_exposure()
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfCustomerExposer = new MDLCustomerExposer($newPDO, $thisPDO);

        $get_customer_exposure_rst = $instanceOfCustomerExposer->customer_exposure_analysis($this->table_a, $this->table_b, $this->table_c, $this->table_d, $this->table_e);

        return $get_customer_exposure_rst;
    }

    public function get_bonds_and_guarantee_records()
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfBondsAndGuarantee = new MDLCustomerExposer($newPDO, $thisPDO);

        $bonds_and_guarantee_records_rst = $instanceOfBondsAndGuarantee->bonds_and_guarantee_records($this->table_a, $this->table_b, $this->table_c, $this->table_d, $this->table_e);

        return $bonds_and_guarantee_records_rst;
    }

    public function get_loans_records()
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfLoans = new MDLCustomerExposer($newPDO, $thisPDO);

        $loans_records_rst = $instanceOfLoans->loans_records($this->table_a, $this->table_b, $this->table_c, $this->table_d, $this->table_e);

        return $loans_records_rst;
    }

    public function get_overdraft_records()
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfOverdraft = new MDLCustomerExposer($newPDO, $thisPDO);

        $overdraft_records_rst = $instanceOfOverdraft->overdraft_records($this->table_a, $this->table_b, $this->table_c, $this->table_d, $this->table_e);

        return $overdraft_records_rst;
    }

    public function get_collateral_records()
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfCollateralRecords = new MDLCustomerExposer($newPDO, $thisPDO);

        $collateral_records_rst = $instanceOfCollateralRecords->collateral_records($this->table_a, $this->table_b, $this->table_c, $this->table_d, $this->table_e);

        return $collateral_records_rst;
    }
}
