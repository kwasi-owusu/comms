<?php
interface ICollateralGrouping{

    public function group_collateral_by_currency(string $table_a): object;
    public function group_collateral_by_category(string $table_a): object;
    public function group_collateral_by_type(string $table_a): object;
    public function group_collateral_by_classification(string $table_a): object;
}