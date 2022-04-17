<?php
require_once "../db.php";
require_once "usersClass.php";
$location = '../welcome.php';
if(isset($_GET)){
        $new_hash = $_GET['hash'];
        $user_for_confirm = new User($_GET);
        $current_user_for_confirm=$user_for_confirm->findUser();
        if(isset($_GET['note'])){  
            if(($current_user_for_confirm != null) && ($new_hash == $current_user_for_confirm['hash']) && ($current_user_for_confirm['email_confirmed'] != 0)){
                //$user_for_confirm = new User($current_user_for_confirm);
                $user_for_confirm->password = $_GET['note'];
                $user_for_confirm->change_password();
                $location = '../authAndReg.php?error=PassSuccErr';
            }else{
                $location = '../restorePass.php?error=restoreErr';
            }
        }else{
            if(($current_user_for_confirm != null) && ($new_hash == $current_user_for_confirm['hash'])){
                $user_for_confirm->email_confirmed = 1;
                $user_for_confirm->change_email_confirmed();
                $location = '../authAndReg.php?error=RegSuccErr';
            }else{
                $location = '../authAndReg.php?errorReg=emailConfirmErr';
            }
        }
    }
header("Location:$location");
