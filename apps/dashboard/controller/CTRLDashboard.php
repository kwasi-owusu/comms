<?php
!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLSecureDashboard.php';


class CTRLDashboard
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


    public function dashboardCTRL()
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLSecureDashboard = new MDLSecureDashboard($newPDO, $thisPDO);

        $classification = array(
            'NORM' => 'NORM',
            'OLEM' => 'OLEM',
            'SUB' => 'SUBt',
            'DOUBT' => 'DOUBT',
            'LOSS' => 'LOSS'
        );

        $currency = array(
            'GHS' => 'GHS',
            'USD' => 'USD',
            'CAD' => 'CAD',
            'GBP' => 'GBP',
            'EUR' => 'EUR'
        );

        //normal loans
        $total_normal_loans     = $instanceOfMDLSecureDashboard->check_total_normal_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $sum_normal_loans       = $instanceOfMDLSecureDashboard->check_sum_normal_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $fetch_normal_loan_sum  = $sum_normal_loans->fetch(PDO::FETCH_ASSOC);

        //olem loans
        $total_olem_loans       = $instanceOfMDLSecureDashboard->check_total_olem_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $sum_olem_loans         = $instanceOfMDLSecureDashboard->check_sum_olem_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $fetch_olem_loan_sum    = $sum_olem_loans->fetch(PDO::FETCH_ASSOC);

        //sub standard loans
        $total_total_sub_standard_loans  = $instanceOfMDLSecureDashboard->check_total_sub_standard_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $sum_total_sub_standard_loans    = $instanceOfMDLSecureDashboard->check_sum_sub_standard_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $fetch_sub_standard_loans_sum    = $sum_total_sub_standard_loans->fetch(PDO::FETCH_ASSOC);

        //doubtful loans
        $total_doubtful_loans   = $instanceOfMDLSecureDashboard->check_total_doubtful_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $sum_doubtful_loans     = $instanceOfMDLSecureDashboard->check_sum_doubtful_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $fetch_doubtful_loans_sum   = $sum_doubtful_loans->fetch(PDO::FETCH_ASSOC);

        //loss loans
        $total_loss_loans       = $instanceOfMDLSecureDashboard->check_total_loss_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $sum_loss_loans         = $instanceOfMDLSecureDashboard->check_sum_loss_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $fetch_loss_loans_sum   = $sum_loss_loans->fetch(PDO::FETCH_ASSOC);

        $RSP_total_normal_loans             = isset($fetch_normal_loan_sum['NormalLoanSum']) ? number_format($fetch_normal_loan_sum['NormalLoanSum'], 2) : number_format(0, 2);
        $RSP_sum_olem_loans                 = isset($fetch_olem_loan_sum['OlemLoanSum']) ? number_format($fetch_olem_loan_sum['OlemLoanSum'], 2) : number_format(0, 2);
        $RSP_sum_total_sub_standard_loans   = isset($fetch_sub_standard_loans_sum['SubStandardLoansSum']) ? number_format($fetch_sub_standard_loans_sum['SubStandardLoansSum'], 2) : number_format(0, 2);
        $RSP_sum_doubtful_loans             = isset($fetch_doubtful_loans_sum['DoubtfulLoanSum']) ? number_format($fetch_doubtful_loans_sum['DoubtfulLoanSum'], 2) : number_format(0, 2);
        $RSP_sum_loss_loans                 = isset($fetch_loss_loans_sum['LossLoanSum']) ? number_format($fetch_loss_loans_sum['LossLoanSum'], 2) : number_format(0, 2);


        $total_bonds_and_guarantees         = $instanceOfMDLSecureDashboard->check_total_bonds_and_guarantees($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $fetch_total_bonds_and_guarantees   = $total_bonds_and_guarantees->fetch(PDO::FETCH_ASSOC);
        $RSP_total_bonds_and_guarantees     = isset($fetch_total_bonds_and_guarantees['TotalBondsAndGuarantees']) ? $fetch_total_bonds_and_guarantees['TotalBondsAndGuarantees'] : 0;

        $total_loans                = $instanceOfMDLSecureDashboard->check_total_loans($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $fetch_total_loans          = $total_loans->fetch(PDO::FETCH_ASSOC);
        $RSP_total_loans            = isset($fetch_total_loans['TotalLoans']) ? $fetch_total_loans['TotalLoans'] : 0;


        $total_overdraft            = $instanceOfMDLSecureDashboard->check_total_overdraft($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $fetch_overdraft            = $total_overdraft->fetch(PDO::FETCH_ASSOC);
        $RSP_total_overdraft        = isset($fetch_overdraft['TotalOverdraft']) ? $fetch_overdraft['TotalOverdraft'] : 0;



        $total_breached_overdraft           = $instanceOfMDLSecureDashboard->check_total_breached_overdraft($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $total_loan_principal_overdue       = $instanceOfMDLSecureDashboard->check_total_loan_principal_overdue($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $total_loan_penalty_overdue         = $instanceOfMDLSecureDashboard->check_total_loan_penalty_overdue($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        $total_loan_penalty_due             = $instanceOfMDLSecureDashboard->check_total_loan_penalty_due($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);


        $get_collateral_grouped_by_currency = $instanceOfMDLSecureDashboard->get_collateral_grouped_by_currency($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);


        $collateral_grouped_by_currency = array();
       
        while ($row = $get_collateral_grouped_by_currency->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $chart_collateral_grouped_by_currency = array(
                'collateral_currency' => $row['collateral_currency'],
                'TotalFacilityDisbursedByCurrency' => $row['TotalFacilityDisbursedByCurrency']
            );

            array_push($collateral_grouped_by_currency, $chart_collateral_grouped_by_currency);
        }
        
        
        $get_loan_classification_grouped_by_collateral_category = $instanceOfMDLSecureDashboard->loan_classification_grouped_by_collateral_category($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
        
        $loan_classification_grouped_by_collateral_category = array();
        

        while ($rrr = $get_loan_classification_grouped_by_collateral_category->fetch(PDO::FETCH_ASSOC)) {

            extract($rrr);

            $chart_classification_grouped_by_collateral_category = array(
                'collateral_type' => $rrr['collateral_type'],
                'classification' => $rrr['classification'],
                'collateral_value' => $rrr['collateral_value'],
            );

            array_push($loan_classification_grouped_by_collateral_category, $chart_classification_grouped_by_collateral_category);

        }

        $get_loan_classification = $instanceOfMDLSecureDashboard->loan_classification($this->table_a, $this->table_b, $this->table_c, $this->table_d, $classification, $currency);
       
        $loan_classification = array();

        while ($rr = $get_loan_classification->fetch(PDO::FETCH_ASSOC)) {

            extract($rr);

            $chart_loan_classification = array(
                'classification' => $rr['classification'],
                'collateral_value' => $rr['collateral_value'],
            );

            array_push($loan_classification, $chart_loan_classification);

        }

        $response_msg = array(
            'total_normal_loans' => $total_normal_loans,
            'sum_normal_loans' => $RSP_total_normal_loans,
            'total_olem_loans' => $total_olem_loans,
            'sum_olem_loans' => $RSP_sum_olem_loans,
            'total_total_sub_standard_loans' => $total_total_sub_standard_loans,
            'sum_total_sub_standard_loans' => $RSP_sum_total_sub_standard_loans,
            'total_doubtful_loans' => $total_doubtful_loans,
            'sum_doubtful_loans' => $RSP_sum_doubtful_loans,
            'total_loss_loans' => $total_loss_loans,
            'sum_loss_loans' => $RSP_sum_loss_loans,
            'total_bonds_and_guarantees' => $RSP_total_bonds_and_guarantees,
            'total_loans' => $RSP_total_loans,
            'total_overdraft' => $RSP_total_overdraft,
            'total_breached_overdraft' => $total_breached_overdraft,
            'total_loan_principal_overdue' => $total_loan_principal_overdue,
            'total_loan_penalty_overdue' => $total_loan_penalty_overdue,
            'total_loan_penalty_due' => $total_loan_penalty_due,
            'collateral_grouped_by_currency' => $collateral_grouped_by_currency,
            'loan_classification_grouped_by_collateral_category' => $loan_classification_grouped_by_collateral_category,
            'loan_classification' => $loan_classification
        );

        $resp =  json_encode($response_msg);
        echo $resp;
    }
}

$callClass      = new CTRLDashboard('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register');
$callMethod     = $callClass->dashboardCTRL();
