<?php
!isset($_SESSION) ? session_start() : null;

date_default_timezone_set("Africa/Accra");

class CTRLLoginUser
{

    private string $table_a;
    private string $table_b;

    public function __construct($table_a, $table_b)
    {
        $this->table_a = $table_a;
        $this->table_b = $table_b;
    }

    public function fetchUsersCtrl()
    {

        $error = false;
        $login_user_tkn  = trim(strip_tags($_POST['tkn']));


        require_once dirname(__DIR__, 2) . '/settings/controller/TransactionAccountEnums.php';

        if (isset($_SESSION['login_tkn']) && $_SESSION['login_tkn'] == $login_user_tkn) {

            $user_email     = trim(strip_tags($_POST['user_email']));
            $user_password  = trim(strip_tags($_POST['user_password']));

            if (empty($user_password)) {
                $error = true;
                $message        = "Password Cannot be empty.";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                return;
            } elseif (empty($user_email)) {
                $error = true;
                $message        = "Email cannot be empty";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                return;
            } elseif (!$error) {

                $password_hash_key      = TransactionHashKeys::password_hash->value;
                $hashed_password        = hash_hmac('sha512', $user_password,  $password_hash_key);


                $data   = array(
                    'em' => $user_email,
                    'ps' => $hashed_password
                );

                require_once dirname(__DIR__) . '/model/MDLFetchUsers.php';
                require_once dirname(__DIR__) . '/model/MDLUserActivities.php';

                require_once dirname(__DIR__) . '/controller/CTRLSecureLogin.php';
                require_once dirname(__DIR__) . '/controller/AuthEnums.php';

                $login_obj = new MDLUserActivities();


                $this_user = new MDLFetchUsers();

                $fetch_user = $this_user->loginUser($this->table_a, $this->table_b, $data);

                $count_rows = $fetch_user->rowCount();

                if ($count_rows > 0) {

                    $user = $fetch_user->fetch(PDO::FETCH_ASSOC);
                    $user_status            = isset($user['user_status']) ? $user['user_status'] : null;
                    $officer_id             = isset($user['user_id']) ? $user['user_id'] : null;
                    $user_access_level      = isset($user['user_access_level']) ? $user['user_access_level'] : null;

                    //user levels for agency
                    $agency_access_levels = array("1", "2", "3");
                    $agency_users_access_levels = array("1", "2");

                    if ($user_status == 0) {

                        $activities = array(
                            'actions' => 'Login Attempted',
                            'status' => 'Failed',
                            'usernames' => $user_email
                        );

                        $activity_desc = json_encode($activities);

                        $activity_data = array(
                            'activity_module' => 'User Login',
                            'activity_desc' => $activity_desc,
                            'user_id' => $user_email
                        );

                        $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);


                        $message        = "User Access Denied";
                        $error_code     = 112;

                        $response_msg   = array(
                            'error' => true,
                            'message' => $message,
                            'error_code' => $error_code
                        );

                        echo json_encode($response_msg);

                        return;
                    } elseif ($user_status == 1) {

                        //check if password is still valid
                        $instance_for_password_security = new CTRLSecureLogin();

                        $fetchPasswords = $instance_for_password_security->is_password_valid($officer_id, $hashed_password);
                        $password_expiry_check = PasswordSecurity::password_expires_after_days->value;

                        $password_date  = $fetchPasswords['system_date'];
                        $todays_date    = Date('Y-m-d');


                        function passwordNumberOfDays($password_date, $todays_date)
                        {

                            $diff = strtotime($todays_date) - strtotime($password_date);


                            return abs(round($diff / 86400));
                        }


                        $password_number_of_days = passwordNumberOfDays($password_date, $todays_date);

                        if ($password_number_of_days >= $password_expiry_check) {

                            $activities = array(
                                'actions' => 'Login Attempted',
                                'status' => 'Failed',
                                'usernames' => $user_email
                            );

                            $activity_desc = json_encode($activities);

                            $activity_data = array(
                                'activity_module' => 'User Login. Password Expired',
                                'activity_desc' => $activity_desc,
                                'user_id' => $user_email
                            );

                            $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);

                            $message        = "Password Expired";
                            $error_code     = 112;

                            $response_msg   = array(
                                'error' => true,
                                'message' => $message,
                                'error_code' => $error_code
                            );

                            echo json_encode($response_msg);

                            return;
                        } elseif ($password_number_of_days < $password_expiry_check) {

                            $_SESSION['officer_id']     = isset($user['user_id']) ? $user['user_id'] : null;
                            $_SESSION['first_name']     = isset($user['first_name']) ? $user['first_name'] : null;
                            $_SESSION['last_name']      = isset($user['last_name']) ? $user['last_name'] : null;
                            $_SESSION['email']          = isset($user['email']) ? $user['email'] : null;
                            $_SESSION['user_access_level']      = isset($user['user_access_level']) ? $user['user_access_level'] : null;
                            $_SESSION['user_branch']    = isset($user['user_branch']) ? $user['user_branch'] : null;
                            $_SESSION['user_institution']   = isset($user['user_institution']) ? $user['user_institution'] : null;
                            $_SESSION["isLogin"] = 1;

                            //echo "Login Successful";

                            $message        = "Login Successful";
                            $error_code     = 111;

                            $response_msg   = array(
                                'error' => false,
                                'message' => $message,
                                'error_code' => $error_code
                            );

                            echo json_encode($response_msg);
                        }
                    }
                } else {

                    $activities = array(
                        'actions' => 'Login Attempted',
                        'status' => 'Failed',
                        'usernames' => $user_email
                    );

                    $activity_desc = json_encode($activities);

                    $activity_data = array(
                        'activity_module' => 'User Login',
                        'activity_desc' => $activity_desc,
                        'user_id' => 0
                    );

                    $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);

                    $message        = "Login Unsuccessful.. $hashed_password Not in table " . $this->table_a;
                    $error_code     = 112;

                    $response_msg   = array(
                        'error' => true,
                        'message' => $message,
                        'error_code' => $error_code
                    );

                    echo json_encode($response_msg);

                    return;
                }
            }
        } else {
            $error          = true;
            $message        = "Action not permitted";
            $error_code     = 112;

            $response_msg   = array(
                'error' => true,
                'message' => $message,
                'error_code' => $error_code
            );

            echo json_encode($response_msg);

            return;
        }
        // } else {
        //     $error          = true;
        //     $message        = "L1 Action not permitted ";
        //     $error_code     = 112;

        //     $response_msg   = array(
        //         'error' => true,
        //         'message' => $message,
        //         'error_code' => $error_code
        //     );

        //     echo json_encode($response_msg);

        //     return;
        // }
    }
}

$callClass = new CTRLLoginUser('abms_users', 'user_activities');
$callMethod = $callClass->fetchUsersCtrl();
