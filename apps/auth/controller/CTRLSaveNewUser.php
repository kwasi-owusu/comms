<?php
session_start();

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLSaveNewUser.php';
require_once dirname(__DIR__) . '/controller/AuthEnums.php';

class CTRLSaveNewUser
{

    private string $table_f;

    public function __construct($table_f)
    {

        $this->table_f = $table_f;
    }


    public function save_new_user()
    {


        $first_name     = isset($_POST['first_name']) ? strip_tags(trim($_POST['first_name'])) : null;
        $middle_name    = isset($_POST['middle_name']) ? strip_tags(trim($_POST['middle_name'])) : null;
        $last_name      = isset($_POST['last_name']) ? strip_tags(trim($_POST['last_name'])) : null;
        $email          = isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : null;
        $pwd            = isset($_POST['password']) ? strip_tags(trim($_POST['password'])) : null;
        $user_access_level = isset($_POST['user_access_level']) ? strip_tags(trim($_POST['user_access_level'])) : null;
        $user_status    = 1;
        $entry_by       = $_SESSION['uid'];

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLSaveNewUser = new MDLSaveNewUser($newPDO, $thisPDO);

        $password_hash_key      = ComsHashKeys::password_hash->value;
        $password               = hash_hmac('sha512', $pwd,  $password_hash_key);


        $data = array(
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'email' => $email,
            'password' => $password,
            'user_access_level' => $user_access_level,
            'user_status' => $user_status,
            'entry_by' => $entry_by,
        );

        $save = $instanceOfMDLSaveNewUser->save_new_user($data, $this->table_f);

        return $save;
    }
}

$callClass = new CTRLSaveNewUser('abms_users');
$callMethod = $callClass->save_new_user();
