<?php

interface ISecureExcelUploadInterface{
    public function uploadCollateralFileMDL(array $data, string $table_a, string $table_b, string $table_c, string $table_d);
    public function upload_bonds_and_guaranteeFileMDL(array $data, string $table_a, string $table_b, string $table_c, string $table_d);
    public function upload_loans_FileMDL(array $data, string $table_a, string $table_b, string $table_c, string $table_d);
    public function upload_overdraft_FileMDL(array $data, string $table_a, string $table_b, string $table_c, string $table_d);
}