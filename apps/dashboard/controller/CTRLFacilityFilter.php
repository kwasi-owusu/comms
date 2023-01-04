<?php

isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLFacilityFilter.php';

class CTRLFacilityFilter
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

    public function get_facility_details($facility_id)
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $this_facility_id = isset($facility_id) ? $facility_id : null;

        $instanceOfMDLFacilityFilter = new MDLFacilityFilter($newPDO, $thisPDO);

        if ($this_facility_id == 1) {

            $get_list_of_bonds = $instanceOfMDLFacilityFilter->search_bonds_lists($this->table_b, $this->table_c, $this->table_d, $this->table_e);

            return $get_list_of_bonds;
        } else if ($this_facility_id == 2) {

            $get_list_of_bonds = $instanceOfMDLFacilityFilter->search_loans_lists($this->table_b, $this->table_c, $this->table_d, $this->table_e);

            return $get_list_of_bonds;
        } else if ($this_facility_id == 3) {

            $get_list_of_bonds = $instanceOfMDLFacilityFilter->search_overdraft_lists($this->table_b, $this->table_c, $this->table_d, $this->table_e);

            return $get_list_of_bonds;
        }
    }
}
