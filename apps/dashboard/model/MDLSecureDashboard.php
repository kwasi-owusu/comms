<?php

require_once dirname(__DIR__) . '/controller/ISecureDashboard.php';

class MDLSecureDashboard implements ISecureDashboard
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO){

        $this->newPDO       = $newPDO;
        $this->thisPDO      = $thisPDO;
    }

    public function check_total_normal_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): int
    {
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE classification = 'NORM'");
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function check_sum_normal_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS NormalLoanSum FROM $table_a WHERE classification = :cl");
        $stmt->bindValue(':cl', $classification['NORM'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    public function check_total_olem_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): int
    {
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE classification = :cl");
        $stmt->bindValue(':cl', $classification['OLEM'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function check_sum_olem_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS OlemLoanSum FROM $table_a WHERE classification = :cl");
        $stmt->bindValue(':cl', $classification['OLEM'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    public function check_total_sub_standard_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): int
    {
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE classification = :cl");
        $stmt->bindValue(':cl', $classification['SUB'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function check_sum_sub_standard_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS SubStandardLoansSum FROM $table_a WHERE classification = :cl ");
        $stmt->bindValue(':cl', $classification['SUB'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    public function check_total_doubtful_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): int
    {
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE classification = :cl");
        $stmt->bindValue(':cl', $classification['DOUBT'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }
    public function check_sum_doubtful_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS DoubtfulLoanSum FROM $table_a WHERE classification = :cl ");
        $stmt->bindValue(':cl', $classification['DOUBT'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    public function check_total_loss_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): int
    {
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE classification = :cl");
        $stmt->bindValue(':cl', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function check_sum_loss_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS LossLoanSum FROM $table_a WHERE classification = :cl ");
        $stmt->bindValue(':cl', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    public function check_sum_loss_loans_usd(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS LossLoanSum FROM $table_a WHERE classification = :cl AND collateral_currency = :usd");
        $stmt->bindValue(':cl', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->bindValue(':usd', $currency['USD'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    public function check_sum_loss_loans_ghs(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS LossLoanSum FROM $table_a WHERE classification = :cl AND collateral_currency = :ghs");
        $stmt->bindValue(':cl', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->bindValue(':cl', $currency['GHS'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    public function check_sum_loss_loans_gbp(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS LossLoanSum FROM $table_a WHERE classification = :cl AND collateral_currency = :gbp");
        $stmt->bindValue(':cl', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->bindValue(':gbp', $currency['GBP'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    public function check_sum_loss_loans_eur(string $table_a, $table_b, $table_c, $table_d, $classification, $currency): object
    {
        $stmt = $this->thisPDO->prepare("SELECT SUM(facility_disbursement_amt) AS LossLoanSum FROM $table_a WHERE classification = :cl AND collateral_currency = :eur");
        $stmt->bindValue(':cl', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->bindValue(':eur', $currency['EUR'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    public function check_total_bonds_and_guarantees(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(bonds_and_guarantee_id) AS TotalBondsAndGuarantees FROM $table_b");
        $stmt->execute();
        return $stmt;
    }
    public function check_total_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(loan_id) AS TotalLoans FROM $table_c");
        $stmt->execute();
        return $stmt;

    }
    public function check_total_overdraft(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(overdraft_id) AS TotalOverdraft FROM $table_d");
        $stmt->execute();
        return $stmt;
    }


    public function check_total_breached_overdraft(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int{

        $st = 'BREACHED';
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_d WHERE breach_status = :st");
        $stmt->bindValue(':st', $st, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();

    }


    public function check_total_loan_principal_overdue(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int{
       
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_c WHERE pricipal_overdue != 0");
        $stmt->execute();
        return $stmt->rowCount();

    }


    public function check_total_loan_penalty_overdue(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int{
        
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_c WHERE total_penal_overdue != 0");
        $stmt->execute();

        return $stmt->rowCount();

    }


    public function check_total_loan_penalty_due(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int{
      
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_c WHERE total_penal_due != 0");
        $stmt->execute();
        return $stmt->rowCount();


    }


    public function get_collateral_grouped_by_currency(string $table_a, $table_b, $table_c, $table_d, $classification, $currency){
      
        $stmt = $this->thisPDO->prepare("SELECT collateral_currency, COUNT(collateral_id) AS TotalFacilityDisbursedByCurrency 
        FROM $table_a 
        GROUP BY collateral_currency");
        
        $stmt->execute();
        
        return $stmt;


    }
    
    public function loan_classification_grouped_by_collateral_category(string $table_a, $table_b, $table_c, $table_d, $classification, $currency){
      
        $stmt = $this->thisPDO->prepare("SELECT classification, collateral_type, collateral_value, 
        SUM(CASE WHEN `classification` = 'NORM' THEN 1 ELSE 0 END) AS 'NORM',
        SUM(CASE WHEN `classification` = 'OLEM' THEN 1 ELSE 0 END) AS 'OLEM',
        SUM(CASE WHEN `classification` = 'DOUBT' THEN 1 ELSE 0 END) AS 'DOUBT',
        SUM(CASE WHEN `classification` = 'SUB' THEN 1 ELSE 0 END) AS 'SUB'
        FROM $table_a 
        
        GROUP BY
        collateral_type
        ");
        
        $stmt->execute();
        
        return $stmt;

    }


    public function loan_classification(string $table_a, $table_b, $table_c, $table_d, $classification, $currency){
      
        $stmt = $this->thisPDO->prepare("SELECT classification, collateral_type, collateral_value
        
        FROM $table_a 
       
        ");
        
        $stmt->execute();
        
        return $stmt;

    }
}

