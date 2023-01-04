<?php

isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLCollateralStatusFilter.php';

class CTRLCollateralStatusFilter
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

    public function collateralStatusFilter($classification)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCollateralStatusFilter = new MDLCollateralStatusFilter($newPDO, $thisPDO);

        //$classification = isset($_POST['classification']) ? strip_tags(trim($_POST['classification'])) : null;

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

        $list_result     = $instanceOfMDLCollateralStatusFilter->search_collateral_lists($this->table_a, $this->table_b, $this->table_c, $this->table_d, $this->table_e, $classification);

        return $list_result;
    }
}

