<?php

require_once dirname(__DIR__) . '/controller/ISecureCustomerFilter.php';

class MDLCustomerExposureFilter implements ISecureCustomerFilter
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }


    public function bonds_and_guarantee_filter(string $table_a, string $table_b, string $table_c, string $table_d, $customer_id): object
    {
        $stmt = $this->thisPDO->prepare("SELECT COUNT($table_b.customer_id) AS totalNumberOfBond, $table_b.bonds_and_guarantee_id, $table_b.brn, 
        $table_b.account_number, $table_b.ccy, $table_b.amount, SUM($table_b.amount) AS totalAmt, $table_a.* 
        FROM $table_b 
        INNER JOIN $table_a ON $table_b.customer_id = $table_a.liability_number
        WHERE $table_b.customer_id = :cd
        GROUP BY ccy
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
    

    public function loans_filter(string $table_a, string $table_b, string $table_c, string $table_d, $customer_id): object
    {
        $stmt = $this->thisPDO->prepare("SELECT COUNT(customer_id) AS totalNumberOfLoans, loan_id, branch_code, customer_name, loan_account, 
        currency, SUM(disbursed_amount) AS totalAmt 
        FROM $table_c 
        WHERE customer_id = :cd
        GROUP BY currency
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }


    public function overdraft_filter(string $table_a, string $table_b, string $table_c, string $table_d, $customer_id): object
    {
        $stmt = $this->thisPDO->prepare("SELECT COUNT(customer_id) AS totalNumberOfOverdraft, overdraft_id, customer_name, account_number, 
        account_currency, SUM(approved_facility) AS totalAmt 
        FROM $table_d 
        WHERE customer_id = :cd
        GROUP BY account_currency
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
    

    public function all_facilities(string $table_a, string $table_b, string $table_c, string $table_d, $customer_id): object
    {
        $stmt = $this->thisPDO->prepare("SELECT $table_b.*, $table_b.*, $table_c.*, $table_d.*, $customer_id
        FROM $table_b
        INNER JOIN $table_c ON $table_b.customer_id = $table_c.customer_id
        INNER JOIN $table_d ON $table_b.customer_id = $table_d.customer_id
        
        WHERE $table_b.customer_id = :cd
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function customer_exposure_by_collateral(string $table_a, string $table_e, $customer_id): object {

        $stmt = $this->thisPDO->prepare("SELECT $table_a.*, $table_e.*
        FROM $table_a
        INNER JOIN $table_e ON $table_a.branch_code = $table_e.branch_code
        WHERE $table_a.liability_number = :cd
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function customer_exposure_by_collateral_grouped_by_currency(string $table_a, string $table_e, $customer_id): object {

        $stmt = $this->thisPDO->prepare("SELECT COUNT($table_a.liability_number) AS totalNumberOfCollaterals, $table_a.customer_name, $table_a.collateral_currency, 
        SUM(collateral_value) AS collateralVal
        FROM $table_a
               
        WHERE $table_a.liability_number = :cd

        GROUP BY $table_a.collateral_currency
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
}
