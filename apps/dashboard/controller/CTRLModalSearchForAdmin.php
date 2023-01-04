<?php

!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLModalSearchForAdmin.php';

class CTRLModalSearchForAdmin
{
   
    private string $table_b;
    private string $table_c;
    private string $table_d;
    private string $table_e;


    public function __construct($table_b, $table_c, $table_d, $table_e)
    {
       
        $this->table_b = $table_b;
        $this->table_c = $table_c;
        $this->table_d = $table_d;
        $this->table_e = $table_e;
    }

    public function search_facility_details($customer_id): array
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $account_number = isset($customer_id) ? $customer_id : null;

        $instanceOfMDLModalSearchForAdmin = new MDLModalSearchForAdmin($newPDO, $thisPDO);

        //check bonds and guarantees for collateral facility details
        $get_bonds_facility = $instanceOfMDLModalSearchForAdmin->search_bonds_for_facility_details($this->table_b, $this->table_c, $this->table_d, $this->table_e, $customer_id);

        //check loans for collateral facility details
        $get_loans_facility = $instanceOfMDLModalSearchForAdmin->search_loans_for_facility_details($this->table_b, $this->table_c, $this->table_d, $this->table_e, $customer_id);

        //check overdraft facility for collateral details
        $get_overdraft_facility = $instanceOfMDLModalSearchForAdmin->search_overdraft_for_facility_details($this->table_b, $this->table_c, $this->table_d, $this->table_e, $customer_id);


        $general_array_for_all_records = array();

        //count the number of records in the database
        $cnt_bonds_facilities = $get_bonds_facility->rowCount();
        $get_bonds_facility_records = array();
        $null_bonds = null;

        if ($cnt_bonds_facilities > 0) {

            while ($bnd = $get_bonds_facility->fetch(PDO::FETCH_ASSOC)) {

                extract($bnd);

                $get_bonds_array = array(
                    'id' => $bnd['bonds_and_guarantee_id'],
                    'customer_name' => $bnd['customer_name'],
                    'account_number' => $bnd['account_number'],
                    'customer_id' => $bnd['customer_id'],
                    'facility_type' => $bnd['facility_type'],
                    'amount' => $bnd['amount'],
                    'currency' => $bnd['ccy'],
                    'branch_name' => $bnd['branch_name']
                );

                array_push($general_array_for_all_records, $get_bonds_array);
            }
        }

       
        $cnt_loan_facilities = $get_loans_facility->rowCount();
        $get_loans_facility_records = array();
        $null_loans = null;

        if ($cnt_loan_facilities > 0) {
            
            while ($lns = $get_loans_facility->fetch(PDO::FETCH_ASSOC)) {

                extract($lns);

                $get_loans_array = array(
                    'id' => $lns['loan_id'],
                    'customer_name' => $lns['customer_name'],
                    'account_number' => $lns['loan_account'],
                    'customer_id' => $lns['customer_id'],
                    'facility_type' => $lns['facility_type'],
                    'amount' => $lns['disbursed_amount'],
                    'currency' => $lns['currency'],
                    'branch_name' => $lns['branch_name']
                );

                array_push($general_array_for_all_records, $get_loans_array);
            }
        }

       
        $cnt_overdraft_facilities = $get_overdraft_facility->rowCount();
        $get_overdraft_facility_records = array();
        $null_overdraft = null;

        if ($cnt_overdraft_facilities > 0) {
            
            while ($ovd = $get_overdraft_facility->fetch(PDO::FETCH_ASSOC)) {

                extract($ovd);

                $get_overdraft_array = array(
                    'id' => $ovd['overdraft_id'],
                    'customer_name' => $ovd['customer_name'],
                    'account_number' => $ovd['account_number'],
                    'customer_id' => $ovd['customer_id'],
                    'facility_type' => $ovd['facility_type'],
                    'amount' => $ovd['approved_facility'],
                    'currency' => $ovd['account_currency'],
                    'branch_name' => $ovd['branch_name']
                );

                array_push($general_array_for_all_records, $get_overdraft_array);
            }
        }

      
        $response_msg = array(
            'general_array_for_all_records' => $general_array_for_all_records
        );

        $resp =  json_encode($response_msg);
        return $response_msg;
    }
}
