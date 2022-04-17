<?php
session_start();
require_once 'user.php';
if (ONLINE){
    require_once "db.php";
    require_once "forUsers/usersClass.php";
    require_once "forData/dataClass.php";
    $user = new User($_SESSION);
    $usersInfo = $user->findUser();
    $user_id = $_SESSION['id'];
    $data_and_files_of_user = new Data_and_File($user_id, '', '');
    if($usersInfo['userType']=='1'){
        $data_of_user = $data_and_files_of_user->findDataOfTeacher();
    }elseif($usersInfo['userType']=='2'){
        $data_of_user = $data_and_files_of_user->findDataOfStudent();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
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
    <title><?php echo $welcomePWords['title']; ?></title>
</head>
<body>
    <?php
    require_once "nav.php";
    ?>
    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == 'admissionErr'){
                    echo $welcomePWords['admissionErr'];
                    }
                } 
            ?>
        </h1>
        <!-- <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
        <button class="btn btn-primary btn-lg" type="button">Example button</button> -->
      </div>
    </div>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>
    <?php
}else{
    header('Location:auth.php');
}

