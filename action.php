<?php
session_start();
require_once "../db.php";
require_once "usersClass.php";
require_once "../phpmailer/PHPMailer.php";
require_once "../phpmailer/SMTP.php";
require_once "../phpmailer/Exception.php";

if(isset($_COOKIE['lang'])){
    if($_COOKIE['lang'] == 'kz'){
        require_once '../lang/kz.php';
    }elseif($_COOKIE['lang'] == 'ru'){
        require_once '../lang/ru.php';
    }elseif($_COOKIE['lang'] == 'en'){
        require_once '../lang/en.php';
    }
}else{
    require_once '../lang/en.php';
}

$location = '../index.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_GET['type'])){
        switch($_GET['type']){
            case 'login':
                if(isset($_POST['email']) && isset($_POST['password'])){
                    $user = new User($_POST);
                    $current_user = $user->findUser();
                    if($current_user != null){
                        if($current_user['email_confirmed'] != 0){
                            $password = sha1($_POST['password']);
                            if($current_user['password']==$password){
                                $_SESSION['email'] = $_POST['email'];
                                $_SESSION['id'] = $current_user['id'];
                                $_SESSION['ONLINE'] = true;
                                $location = '../welcome.php';
                            }else{
                                $location = '../authAndReg.php?error=PassErr';
                            }
                        }else{
                            $location = '../desk.php?error=registrationNotEnd';
                        }
                    }else{
                        $location = "../authAndReg.php?errorReg=notRegErr";
                    }
                }else{
                    $location = '../authAndReg.php?error=LogAndPassErr';
                }
            break;
            case 'register':
                if(isset($_POST['email']) && 
                    isset($_POST['password']) && 
                    isset($_POST['name']) && 
                    isset($_POST['userType']) && 
                    isset($_POST['surname']) && 
                    isset($_POST['passwordConfirm'])){
                        if($_POST['passwordConfirm'] == $_POST['password']){
                            $user = new User($_POST);
                            $current_user = $user->findUser();
                            if($current_user != null){
                                $location = '../authAndReg.php?error=emailErr';
                                }else{
                                    $hash = sha1($_POST['name'].time());
                                    $user->hash = $hash;
                                    $user->email_confirmed = 0;
                                    $user->date = date('Y-m-d');
                                    $user->register();
                                    
                                    $email = $_POST['email'];
                                    $title = $emailRegWords['letterTitle'];
                                    $encoded_email = urlencode($_POST['email']);
                                    $linkToNext = $emailRegWords['linkInLetter'];
                                    $helloVariant = $emailRegWords['letterHello'];
                                    $text = "<a href='https://academ-m.kaznu.kz/forActivation.php?hash=$hash&email=$encoded_email'>$linkToNext</a>";
                                    $body = "<h2>$helloVariant</h2><br><br><br>$text";

                                    // Настройки PHPMailer
                                    $mail = new PHPMailer\PHPMailer\PHPMailer();
                                    try {
                                        $mail->isSMTP();   
                                        $mail->CharSet = "UTF-8";
                                        $mail->SMTPAuth   = true;
                                        //$mail->SMTPDebug = 2;
                                        $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

                                        // Настройки вашей почты
                                        $mail->Host       = 'post.kaznu.kz'; // SMTP сервера вашей почты
                                        $mail->Username   = 'univer@kaznu.kz'; // Логин на почте
                                        $mail->Password   = 'PasSsWordUni503'; // Пароль на почте
                                        $mail->SMTPSecure = 'tls';
                                        $mail->Port       = 25;
                                        $mail->setFrom('univer@kaznu.kz', $emailRegWords['nameOFPost']); // Адрес самой почты и имя отправителя

                                        // Получатель письма
                                        $mail->addAddress($email);

                                        // Отправка сообщения
                                        $mail->isHTML(true);
                                        $mail->Subject = $title;
                                        $mail->Body = $body;   

                                        // Проверяем отравленность сообщения
                                        if ($mail->send()) {$result = "success";} 
                                        else {$result = "error";}

                                        } catch (Exception $e) {
                                            $result = "error";
                                            $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
                                        }
                                        echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);   
                                    $location = '../desk.php?error=emailSend';
                                }
                            }else{
                                $email = $_POST['email'];
                                $name = $_POST['name'];
                                $surname = $_POST['surname'];
                                $location = "../authAndReg.php?errorReg=mismatchErr&email=$email&name=$name&surname=$surname";
                            }                      
                }else{
                    $location = '../authAndReg.php?errorReg=fieldErr';
                }
            break;
            case 'passRestore':
                if(isset($_POST['email']) && 
                isset($_POST['password']) && 
                isset($_POST['passwordConfirm'])){
                    if($_POST['password'] == $_POST['passwordConfirm']){
                        $user = new User($_POST);
                        $current_user = $user->findUser();
                        if($current_user != null){
                            if($current_user['email_confirmed'] != 0){
                                $password = sha1($_POST['password']);
                                $hash = sha1($current_user['name'].time());
                                $user = new User($current_user);
                                $user->hash = $hash;
                                $user->change_hash();
                                $email = $_POST['email'];
                                $title = $emailRePassWords['letterTitle'];
                                $encoded_email = urlencode($_POST['email']);
                                $linkToNext = $emailRePassWords['linkInLetter'];
                                $letterText = $emailRePassWords['letterText'];
                                $text = "<a href='https://academ-m.kaznu.kz/forActivation.php?hash=$hash&email=$encoded_email&note=$password'>$linkToNext</a>";
                                $body = "<h2>$letterText</h2><br></b><br>$text";
                                
                                //нужно изменить в базе hash
                                $mail = new PHPMailer\PHPMailer\PHPMailer();
                            try {
                                $mail->isSMTP();   
                                $mail->CharSet = "UTF-8";
                                $mail->SMTPAuth   = true;
                                //$mail->SMTPDebug = 2;
                                $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};
    
                                // Настройки вашей почты
                                $mail->Host       = 'post.kaznu.kz'; // SMTP сервера вашей почты
                                $mail->Username   = 'univer@kaznu.kz'; // Логин на почте
                                $mail->Password   = 'PasSsWordUni503'; // Пароль на почте
                                $mail->SMTPSecure = 'tls';
                                $mail->Port       = 25;
                                $mail->setFrom('univer@kaznu.kz', $emailRePassWords['nameOFPost']); // Адрес самой почты и имя отправителя
    
                                /* $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
                                $mail->Username   = 'academ.kaznu@gmail.com'; // Логин на почте
                                $mail->Password   = 'K11aznu08&2021AcAdem'; // Пароль на почте
                                $mail->SMTPSecure = 'ssl';
                                $mail->Port       = 465;
                                $mail->setFrom('academ.kaznu@gmail.com', 'Академическая мобильность КазНУ'); // Адрес самой почты и имя отправителя */
    
                                // Получатель письма
                                $mail->addAddress($email);
    
                                // Отправка сообщения
                                $mail->isHTML(true);
                                $mail->Subject = $title;
                                $mail->Body = $body;   
    
                                // Проверяем отравленность сообщения
                                if ($mail->send()) {$result = "success";} 
                                else {$result = "error";}
    
                                } catch (Exception $e) {
                                    $result = "error";
                                    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
                                }
                                echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
                                $location = '../desk.php?error=emailSendForRestore';
                            }else{
                                $location = '../desk.php?error=registrationNotEnd';
                            }
                        }else{
                            $location = '../restorePass.php?error=notFoundEmailErr';
                        }
                    }else{
                        $email = $_POST['email'];
                            $location = "../restorePass.php?error=mismatchErr&email=$email";
                    }
                }else{
                    $location = '../restorePass.php?error=LogAndPassErr';
                }
                
            break;
        }
    }
}
header("Location:$location");