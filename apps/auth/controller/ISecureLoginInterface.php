<?php

interface ISecureLoginInterface{
    public function is_login_hash_valid(string $page_name, string $hash_key) : string;
    public function is_password_valid(string $officer_id, string $password) : array;
}