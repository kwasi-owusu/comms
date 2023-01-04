<?php

Interface ICollateralCategoryChartInterface{

    public function calculate_values_for_legal_mortgage(string $table_a, array $classification, array $collateral_category) : object;
    public function calculate_values_for_plants_machines(string $table_a, array $classification, array $collateral_category) : object;
    public function calculate_values_for_board_guarantee(string $table_a, array $classification, array $collateral_category) : object;
    public function calculate_values_for_inventory(string $table_a, array $classification, array $collateral_category) : object;
}