<?php

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

require_once dirname(__DIR__) . '/interfaces/ISecureLoginInterface.php';
require_once dirname(__DIR__) . '/model/MDLSecureLogin.php';

class CTRLSecureLogin implements ISecureLoginInterface{


    public function is_login_hash_valid(string $page_name, string $hash_key) : string {
        
        $page_is        = $page_name;
        $thi_is_is      = $hash_key;
        $rock_hash      = $page_is.$thi_is_is;

        $loginTkn = hash_hmac('sha512', $rock_hash, $thi_is_is);


        return $loginTkn;
        
    }
  
    public function is_password_valid(string $officer_id, string $password) : array{

        $table = 'password_logs';
        $check_if_password_is_valid = new MDLSecureLogin();

        $getRst = $check_if_password_is_valid->is_password_valid_mdl($officer_id, $password, $table);

        return $getRst;
    }
}