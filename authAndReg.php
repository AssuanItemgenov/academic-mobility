<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="CSS/styles.css" />
        <?php
            if(isset($_COOKIE['lang'])){
                if($_COOKIE['lang'] == 'kz'){
                    require_once 'lang/kz.php';
                }elseif($_COOKIE['lang'] == 'ru'){
                    require_once 'lang/ru.php';
                }elseif($_COOKIE['lang'] == 'en'){
                    require_once 'lang/en.php';
                }
            }else{
                require_once 'lang/en.php';
            }
        ?>
        <title><?php echo $authAndRegPWords['title']; ?></title>
    </head>

    <body>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                        <form action="forUsers/action.php?type=login" method="POST" class="sign-in-form">
                            <h2 class="title"><?php echo $authAndRegPWords['login']; ?></h2>
                            <?php
                                $message = '';
                                if(isset($_GET['error'])){
                                    if($_GET['error'] == 'PassErr'){
                                    $message = $authAndRegPWords['PassErr'];
                                    }elseif($_GET['error'] == 'LogAndPassErr'){
                                        $message = $authAndRegPWords['LogAndPassErr'];
                                    }elseif($_GET['error'] == 'emailErr'){
                                        $message = $authAndRegPWords['emailErr'];
                                    }elseif($_GET['error'] == 'PassSuccErr'){
                                        $message = $authAndRegPWords['PassSuccErr'];
                                    }elseif($_GET['error'] == 'RegSuccErr'){
                                        $message = $authAndRegPWords['RegSuccErr'];
                                    }elseif($_GET['error'] == 'downloadAuthErr'){
                                        $message = $authAndRegPWords['downloadAuthErr'];
                                    }
                            ?>
                            <p class="social-text" <?php if(($_GET['error'] == 'PassSuccErr') || ($_GET['error'] == 'RegSuccErr')){ echo "style='color: #0095b6'";} ?>><?php echo $message; ?></p>
                            <?php
                                }
                            ?>
                            <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" placeholder="Email" required />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input required name="password" type="password" placeholder="<?php echo $authAndRegPWords['password']; ?>" minlength="6" />
                            </div>
                            <input class="btn solid" type="submit" value="<?php echo $authAndRegPWords['login']; ?>" />
                            <?php
                                if(isset($_GET['error']) && (($_GET['error'] == 'PassErr') || ($_GET['error'] == 'emailErr'))){
                            ?>
                            <div class="social-media">
                                <a class="social-icon" href="restorePass.php"><?php echo $authAndRegPWords['PassErrQ']; ?></a>
                            </div>
                            <?php    
                                }
                            ?>
                        </form>
                    
                        <?php 
                            if(isset($_GET['email']) && 
                            isset($_GET['name']) && 
                            isset($_GET['surname'])){
                                $name = $_GET['name'];
                                $surname = $_GET['surname'];
                                $email = $_GET['email'];
                            }
                        ?>

                        <form action="forUsers/action.php?type=register" method="POST" class="sign-up-form">
                            <h2 class="title"><?php echo $authAndRegPWords['registration']; ?></h2>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input required name="name" type="text" placeholder="<?php echo $authAndRegPWords['name']; ?>" value="<?php if(isset($name)){ echo $name;} ?>" />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input required name="surname" type="text" placeholder="<?php echo $authAndRegPWords['surname']; ?>" value="<?php if(isset($surname)){ echo $surname;} ?>" />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-users"></i>
                                <select required class="select" name="userType">
                                    <option disabled><?php echo $authAndRegPWords['userType']; ?>*</option>
                                    <option value="1"><?php echo $authAndRegPWords['userType1']; ?></option>
                                    <option value="2"><?php echo $authAndRegPWords['userType2']; ?></option>
                                </select>
                            </div>
                            <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input required name="email" type="email" placeholder="Email" aria-describedby="emailHelp" value="<?php if(isset($email)){ echo $email;} ?>" />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input required name="password" type="password" placeholder="<?php echo $authAndRegPWords['password']; ?>" minlength="6"/>
                            </div>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input required name="passwordConfirm" type="password" placeholder="<?php echo $authAndRegPWords['passwordConfirm']; ?>" minlength="6"/>
                            </div>
                            <input type="submit" class="btn" style="width: 200px;" value="<?php echo $authAndRegPWords['registration']; ?>" />
                            <?php
                                if(isset($_GET['errorReg'])){
                                    if($_GET['errorReg'] == 'mismatchErr'){
                                        $message = $authAndRegPWords['mismatchErr'];
                                        echo "<p class='social-text'>$message</p>";
                                    }elseif($_GET['errorReg'] == 'notRegErr'){
                                        $message = $authAndRegPWords['notRegErr'];
                                        echo "<p class='social-text'>$message</p>";
                                    }elseif($_GET['errorReg'] == 'fieldErr'){
                                        $message = $authAndRegPWords['fieldErr'];
                                        echo "<p class='social-text'>$message</p>";
                                    }elseif($_GET['errorReg'] == 'emailConfirmErr'){
                                        $message = $authAndRegPWords['emailConfirmErr'];
                                        echo "<p class='social-text'>$message</p>";
                                    }
                                }
                            ?>
                        </form>
                </div>
            </div>

            <div class="panels-container">
                <div class="panel left-panel">
                <div class="content">
                <h3><?php echo $authAndRegPWords['question1']; ?></h3>
                <p>
                
                </p>
                <button class="btn transparent" id="sign-up-btn" style="width: 200px;"><?php echo $authAndRegPWords['registration']; ?></button>
                </div>
                <img src="img/login.svg" class="image" alt="" />
                </div>
                <div class="panel right-panel">
                <div class="content">
                <h3><?php echo $authAndRegPWords['question2']; ?></h3>
                <p>
                
                </p>
                <button class="btn transparent" id="sign-in-btn"><?php echo $authAndRegPWords['login']; ?></button>
                </div>
                <img src="img/register.svg" class="image" alt="" />
                </div>
            </div>
        </div>
        <script src="JS/app.js"></script>
        <?php if($_GET['errorReg']){ ?>
        <script>
            document.getElementById('sign-up-btn').click();
        </script>
        <?php } ?>
    </body>
</html>