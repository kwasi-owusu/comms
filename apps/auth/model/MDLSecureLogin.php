<?php

class MDLSecureLogin extends ConnectDatabase
{
    public function is_password_valid_mdl($officer_id, $password, $table)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $table WHERE user_id = :uid AND password = :password ORDER BY password_log_id DESC LIMIT 1");
        $stmt->bindValue(':uid', $officer_id, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
