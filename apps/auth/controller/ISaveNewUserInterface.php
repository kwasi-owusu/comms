<?php

interface ISaveNewUserInterface{

    public function save_new_user(array $data, string $table_f) : object;
}