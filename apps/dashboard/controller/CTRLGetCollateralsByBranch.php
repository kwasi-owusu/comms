<?php

isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLGetCollateralByBranch.php';


class CTRLGetCollateralsByBranch
{


    private string $table_a;
    private string $table_e;

    public function __construct($table_a, $table_e)
    {

        $this->table_a = $table_a;
        $this->table_e = $table_e;
    }

    public function get_collaterals_by_branch()
    {

        $newPDO     = new ConnectDatabase();
        $thisPDO    = $newPDO->Connect();

        $classification = isset($_POST['classification']) ? $_POST['classification'] : null;
        $branch_code    = isset($_POST['branch_code']) ? $_POST['branch_code'] : null;

        switch ($classification) {

            case 1:
                $classification = 'NORM';
                break;

            case 2:
                $classification = 'OLEM';
                break;

            case 3:
                $classification = 'SUBT';
                break;

            case 4:
                $classification = 'DOUBT';
                break;

            case 5:
                $classification = 'LOSS';
                break;

            default:
                'Unknown';
        }

        $instanceOfMDLGetCollateralByBranch = new MDLGetCollateralByBranch($newPDO, $thisPDO);
        $method_of_instance = $instanceOfMDLGetCollateralByBranch->getBranches($this->table_a, $this->table_e, $branch_code, $classification);

        $fetch_records = $method_of_instance->fetchAll();

        $output = "";
        $output .= '<table id="modal_data_table" class="display table buttons-datatables table-responsive modal_data_table" style="width:100%">

            <thead>
            <tr>
            <th>Total Count</th>
            <th>Currency</th>
            <th>Sum Value</th>
            <th>Collateral Category</th>
            </tr>
            </thead>
            <tbody> 
            ';

        foreach ($fetch_records as $rcd) {

            $output .= '<tr>
                           <td>' . $rcd["totalCount"] . '</td>
                           <td>' . $rcd["collateral_currency"] . '</td>
                           <td>' . $rcd["sumValue"] . '</td>
                           <td>' . $rcd["collateral_category"] . '</td>
                           </tr>
                           ';
                        }

        $output .= '
        </tbody>
        </table>';

        echo $output;
    }
}

$callClass = new CTRLGetCollateralsByBranch('collateral_register', 'all_branches');
$callMethod = $callClass->get_collaterals_by_branch();
