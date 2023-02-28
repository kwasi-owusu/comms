<?php

interface INewUserPasswordInterface{
    public function change_user_password(string $page_name, string $hash_key) : string;
    public function log_new_password(string $officer_id, string $password) : array;
}