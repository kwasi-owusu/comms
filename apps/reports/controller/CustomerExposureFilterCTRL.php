<?php

!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLCustomerExposureFilter.php';


class CustomerExposureFilterCTRL
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


    public function get_bonds_and_guarantee_filter()
    {

        $customer_id        = isset($_POST['select_client']) ? strip_tags(trim($_POST['select_client'])) : null;
        $filter_action      = isset($_POST['filter_action']) ? strip_tags(trim($_POST['filter_action'])) : null;
        $bonds_start_date   = isset($_POST['bonds_start_date']) ? strip_tags(trim($_POST['bonds_start_date'])) : null;
        $bonds_end_date     = isset($_POST['bonds_end_date']) ? strip_tags(trim($_POST['bonds_end_date'])) : null;
        
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCustomerExposureFilter = new MDLCustomerExposureFilter($newPDO, $thisPDO);

        //get collateral filter
        $exposure_by_collateral = $instanceOfMDLCustomerExposureFilter->customer_exposure_by_collateral($this->table_a,  $this->table_e, $customer_id);

        $get_filter_for_collateral_list = array();

        while ($r = $exposure_by_collateral->fetch(PDO::FETCH_ASSOC)) {
            extract($r);
            $collateral_list_filter = array(
                'collateral_code' => $r['collateral_code'],
                'account_number' => $r['account_number'],
                'branch_name' => $r['branch_name'],
                'collateral_value' => number_format($r['collateral_value'], 2),
                'collateral_currency' => $r['collateral_currency'],
                'classification' => $r['classification']
            );

            array_push($get_filter_for_collateral_list, $collateral_list_filter);
        }

        //get collateral grouped by currency
        $exposure_by_collateral_currency = $instanceOfMDLCustomerExposureFilter->customer_exposure_by_collateral_grouped_by_currency($this->table_a,  $this->table_e, $customer_id);
        
        $get_filter_for_collateral_by_currency = array();
        while($rr = $exposure_by_collateral_currency->fetch(PDO::FETCH_ASSOC)){
            extract ($rr);
            $collateral_by_currency = array(
                'totalNumberOfCollaterals' => $rr['totalNumberOfCollaterals'],
                'customer_name' => $rr['customer_name'],
                'collateral_currency' => $rr['collateral_currency'],
                'collateralVal' => $rr['collateralVal']

            );

            array_push($get_filter_for_collateral_by_currency, $collateral_by_currency);
        }


        if ($filter_action == 1) {

            $sum_bonds_and_guarantees           = $instanceOfMDLCustomerExposureFilter->bonds_and_guarantee_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);
            $fetch_sum_bonds_and_guarantees     = $sum_bonds_and_guarantees->fetch(PDO::FETCH_ASSOC);
            $RSP_bonds_and_guarantees_amount    = isset($fetch_sum_bonds_and_guarantees['totalAmt']) ? number_format($fetch_sum_bonds_and_guarantees['totalAmt'], 2) : number_format(0, 2);

            $get_filter_for_bonds   = $instanceOfMDLCustomerExposureFilter->bonds_and_guarantee_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);
            $get_list_for_bonds     = $instanceOfMDLCustomerExposureFilter->bonds_and_guarantee_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);

            $get_filter_for_bonds_by_currency = array();

            while ($row = $get_filter_for_bonds->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $chart_get_filter_for_bonds_by_currency = array(
                    'ccy' => $row['ccy'],
                    'totalNumberOfList' => $row['totalNumberOfBond']
                );

                array_push($get_filter_for_bonds_by_currency, $chart_get_filter_for_bonds_by_currency);
            }


            $filter_for_bonds_by_currency_list = array();

            while ($new_row = $get_list_for_bonds->fetch(PDO::FETCH_ASSOC)) {
                extract($new_row);
                $table_get_filter_for_bonds_by_currency = array(
                    'customer_name' => $new_row['customer_name'],
                    'totalAmt' => number_format($new_row['totalAmt'], 2),
                    'ccy' => $new_row['ccy']
                );

                array_push($filter_for_bonds_by_currency_list, $table_get_filter_for_bonds_by_currency);
            }



            $response_msg = array(
                'response' => 'success',
                'get_filter_for_collateral_list' => $get_filter_for_collateral_list,
                'get_filter_for_collateral_by_currency' => $get_filter_for_collateral_by_currency,
                'get_filter_for_facility_by_currency' => $get_filter_for_bonds_by_currency,
                'customer_id' => $customer_id,
                'RSP_facility_amount' => $RSP_bonds_and_guarantees_amount,
                'filter_for_facility_by_currency_list' => $filter_for_bonds_by_currency_list,
            );

            $resp =  json_encode($response_msg);
            echo $resp;

        } elseif ($filter_action == 2) {

            $sum_loans          = $instanceOfMDLCustomerExposureFilter->loans_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);
            $fetch_sum_loans    = $sum_loans->fetch(PDO::FETCH_ASSOC);
            $RSP_loans_amount   = isset($fetch_sum_loans['totalAmt']) ? number_format($fetch_sum_loans['totalAmt'], 2) : number_format(0, 2);

            $get_filter_for_loan   = $instanceOfMDLCustomerExposureFilter->loans_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);
            $get_list_for_loans    = $instanceOfMDLCustomerExposureFilter->loans_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);

            $get_filter_for_loans_by_currency = array();

            while ($row = $get_filter_for_loan->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $chart_get_filter_for_loans_by_currency = array(
                    'ccy' => $row['currency'],
                    'totalNumberOfList' => $row['totalNumberOfLoans']
                );

                array_push($get_filter_for_loans_by_currency, $chart_get_filter_for_loans_by_currency);
            }


            $filter_for_loans_by_currency_list = array();

            while ($new_row = $get_list_for_loans->fetch(PDO::FETCH_ASSOC)) {
                extract($new_row);
                $table_get_filter_for_bonds_by_currency = array(
                    'customer_name' => $new_row['customer_name'],
                    'totalAmt' => $new_row['totalAmt'],
                    'ccy' => $new_row['currency']
                );

                array_push($filter_for_loans_by_currency_list, $table_get_filter_for_bonds_by_currency);
            }


            $response_msg = array(
                'response' => 'success',
                'customer_id' => $customer_id,
                'RSP_facility_amount' => $RSP_loans_amount,
                'get_filter_for_facility_by_currency' => $get_filter_for_loans_by_currency,
                'filter_for_facility_by_currency_list' => $filter_for_loans_by_currency_list,
                'get_filter_for_collateral_list' => $get_filter_for_collateral_list,
                'get_filter_for_collateral_by_currency' => $get_filter_for_collateral_by_currency
            );

            $resp =  json_encode($response_msg);
            echo $resp;
        } elseif ($filter_action == 3) {

            $sum_overdraft      = $instanceOfMDLCustomerExposureFilter->overdraft_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);
            $fetch_sum_overdraft    = $sum_overdraft->fetch(PDO::FETCH_ASSOC);
            $RSP_overdraft_amount   = isset($fetch_sum_overdraft['totalAmt']) ? number_format($fetch_sum_overdraft['totalAmt'], 2) : number_format(0, 2);

            $get_filter_for_overdraft   = $instanceOfMDLCustomerExposureFilter->overdraft_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);
            $get_list_for_loans    = $instanceOfMDLCustomerExposureFilter->overdraft_filter($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);

            $get_filter_for_overdraft_by_currency = array();

            while ($row = $get_filter_for_overdraft->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $chart_get_filter_for_overdraft_by_currency = array(
                    'ccy' => $row['account_currency'],
                    'totalNumberOfList' => $row['totalNumberOfOverdraft']
                );

                array_push($get_filter_for_overdraft_by_currency, $chart_get_filter_for_overdraft_by_currency);
            }


            $filter_for_overdraft_by_currency_list = array();

            while ($new_row = $get_list_for_loans->fetch(PDO::FETCH_ASSOC)) {
                extract($new_row);
                $table_get_filter_for_overdraft_by_currency = array(
                    'customer_name' => $new_row['customer_name'],
                    'totalAmt' => $new_row['totalAmt'],
                    'ccy' => $new_row['account_currency']
                );

                array_push($filter_for_overdraft_by_currency_list, $table_get_filter_for_overdraft_by_currency);
            }



            $response_msg = array(
                'response' => 'success',
                'customer_id' => $customer_id,
                'RSP_facility_amount' => $RSP_overdraft_amount,
                'get_filter_for_facility_by_currency' => $get_filter_for_overdraft_by_currency,
                'filter_for_facility_by_currency_list' => $filter_for_overdraft_by_currency_list,
                'get_filter_for_collateral_list' => $get_filter_for_collateral_list,
                'get_filter_for_collateral_by_currency' => $get_filter_for_collateral_by_currency
            );

            $resp =  json_encode($response_msg);
            echo $resp;
        }

        elseif ($filter_action == 4) {

            $get_filter_for_all_facilities      = $instanceOfMDLCustomerExposureFilter->all_facilities($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);
            $get_list_for_all_facilities        = $instanceOfMDLCustomerExposureFilter->all_facilities($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);

            $get_filter_for_all_facilities_by_currency = array();

            while ($row = $get_filter_for_all_facilities->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $chart_get_filter_for_all_facilities_by_currency = array(
                    'ccy' => $row['account_currency'],
                    'totalNumberOfList' => $row['totalNumberOfOverdraft']
                );

                array_push($get_filter_for_all_facilities_by_currency, $chart_get_filter_for_all_facilities_by_currency);
            }


            $filter_for_all_facilities_by_currency_list = array();

            while ($new_row = $get_list_for_all_facilities->fetch(PDO::FETCH_ASSOC)) {
                extract($new_row);
                $table_get_filter_for_all_facilities_by_currency = array(
                    'customer_name' => $new_row['customer_name'],
                    'totalAmt' => $new_row['totalAmt'],
                    'ccy' => $new_row['account_currency']
                );

                array_push($filter_for_all_facilities_by_currency_list, $table_get_filter_for_all_facilities_by_currency);
            }



            $response_msg = array(
                'response' => 'success',
                'customer_id' => $customer_id,
                'get_filter_for_facility_by_currency' => $get_filter_for_all_facilities_by_currency,
                'filter_for_facility_by_currency_list' => $filter_for_overdraft_by_currency_list,
                'get_filter_for_collateral_list' => $get_filter_for_collateral_list,
                'get_filter_for_collateral_by_currency' => $get_filter_for_collateral_by_currency
            );

            $resp =  json_encode($response_msg);
            echo $resp;
        }

        elseif ($filter_action == 5) {

            $get_filter_for_all_facilities      = $instanceOfMDLCustomerExposureFilter->all_facilities($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);
            $get_list_for_all_facilities        = $instanceOfMDLCustomerExposureFilter->all_facilities($this->table_a, $this->table_b, $this->table_c, $this->table_d, $customer_id);

            $get_filter_for_all_facilities_by_currency = array();

            while ($row = $get_filter_for_all_facilities->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $chart_get_filter_for_all_facilities_by_currency = array(
                    'ccy' => $row['account_currency'],
                    'totalNumberOfList' => $row['totalNumberOfOverdraft']
                );

                array_push($get_filter_for_all_facilities_by_currency, $chart_get_filter_for_all_facilities_by_currency);
            }


            $filter_for_all_facilities_by_currency_list = array();

            while ($new_row = $get_list_for_all_facilities->fetch(PDO::FETCH_ASSOC)) {
                extract($new_row);
                $table_get_filter_for_all_facilities_by_currency = array(
                    'customer_name' => $new_row['customer_name'],
                    'totalAmt' => $new_row['totalAmt'],
                    'ccy' => $new_row['account_currency']
                );

                array_push($filter_for_all_facilities_by_currency_list, $table_get_filter_for_all_facilities_by_currency);
            }



            $response_msg = array(
                'response' => 'success',
                'customer_id' => $customer_id,
                'get_filter_for_facility_by_currency' => $get_filter_for_all_facilities_by_currency,
                'filter_for_facility_by_currency_list' => $filter_for_overdraft_by_currency_list,
                'get_filter_for_collateral_list' => $get_filter_for_collateral_list,
                'get_filter_for_collateral_by_currency' => $get_filter_for_collateral_by_currency
            );

            $resp =  json_encode($response_msg);
            echo $resp;
        }
    }
}

$callClass      = new CustomerExposureFilterCTRL('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register', 'all_branches');
$callMethod     = $callClass->get_bonds_and_guarantee_filter();
