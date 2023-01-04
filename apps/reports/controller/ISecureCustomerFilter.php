<?php

interface ISecureCustomerFilter{

    public function bonds_and_guarantee_filter(string $table_a, string $table_b, string $table_c, string $table_d, $customer_id): object;
    public function loans_filter(string $table_a, string $table_b, string $table_c, string $table_d, $customer_id): object;
    public function overdraft_filter(string $table_a, string $table_b, string $table_c, string $table_d, $customer_id): object;
    public function customer_exposure_by_collateral(string $table_a, string $table_e, $customer_id): object;
    public function customer_exposure_by_collateral_grouped_by_currency(string $table_a, string $table_e, $customer_id): object;
}