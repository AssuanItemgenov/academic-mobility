<?php
    session_start();
    require_once "user.php";

    if(ONLINE){
        require_once "db.php";
        require_once "forUsers/usersClass.php";

        $user_id = $_SESSION['id'];
        $user = new User($_SESSION);
        $usersInfo = $user->findUser();
            if($usersInfo['userType'] == 3){
            require_once "forData/dataClass.php";
            require_once "forData/functionsOfData.php";
            $allUsers =  $user->findAllUsers();
            if(isset($_COOKIE['lang'])){
                $language = $_COOKIE['lang'];
                if($_COOKIE['lang'] == 'kz'){
                    require_once 'lang/kz.php';
                }elseif($_COOKIE['lang'] == 'ru'){
                    require_once 'lang/ru.php';
                }elseif($_COOKIE['lang'] == 'en'){
                    require_once 'lang/en.php';
                }
            }else{
                $language = 'en';
                require_once 'lang/en.php';
            }
            $countries = findCountries($language);
            $faculties = findFaculties($language);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title><?php echo $requestsPWOrds['title']; ?></title>
</head>
<body>
    <?php
    require_once "nav.php";
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="dropdown text-end mb-2">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        скачать все завки в exel
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><form action="forData/actionsOfData.php?type=exportToExel&userType=1" method="POST"><button type="submit" class="dropdown-item">Заявки преподавателей</button></form></li>
                        <li><form action="forData/actionsOfData.php?type=exportToExel&userType=2" method="POST"><button type="submit" class="dropdown-item">Заявки студентов</button></form></li>
                    </ul>
                </div>
                <table class="table table-success table-striped">
                    <thead>
                        <tr>
                        <th class="text-center" scope="col">#</th>
                        <th class="text-center" scope="col"><?php echo $applicationPWords['nameLabel']; ?></th>
                        <th class="text-center" scope="col"><?php echo $applicationPWords['surnameLabel']; ?></th>
                        <th class="text-center" scope="col">Email</th>
                        <th class="text-center" scope="col">
                            
                            <div class="btn-group dropend">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <b><?php echo $authAndRegPWords['userType']; ?></b>
                                </button>
                                <ul class="dropdown-menu" style="background-color:#d1e7dd;">
                                    <li><a class="dropdown-item" href="?sortUserType=typeVar1"><?php echo $authAndRegPWords['userType1']; ?></a></li>
                                    <li><a class="dropdown-item" href="?sortUserType=typeVar2"><?php echo $authAndRegPWords['userType2']; ?></a></li>
                                </ul>
                            </div>
                        </th>
                        <th class="text-center" scope="col">
                            <div class="btn-group dropdown">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <b><?php echo $requestsPWOrds['regDateLabel']; ?></b>
                                </button>
                                <ul class="dropdown-menu" style="background-color:#d1e7dd;">
                                    <li>
                                        <form action="requests.php" method="GET">
                                            <div class="input-group" style="width:200px;">
                                                <input required name="regDate" type="date" class="form-control" aria-label="Example text with button addon" aria-describedby="button-addon1" value="2000-01-01" style="background-color:#d1e7dd; border:none;">
                                                <button type="submit" class="btn btn-outline-dark" type="button" id="button-addon1" style="border:none;">Ok</button>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </th>
                        <th class="text-center" scope="col">
                            <div class="btn-group dropend">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <b><?php echo $applicationPWords['citizenshipLabel']; ?></b>
                                </button>
                                <ul class="dropdown-menu" style="background-color:#d1e7dd;">
                                    <?php
                                        for($i=0; $i<count($countries); $i++){
                                            if($countries[$i]['status'] == 1){    
                                                echo "<li><a class='dropdown-item' href='?sortCountry=".$countries[$i]['country_id']."'>".$countries[$i]['country_name_'.$language]."</a></li>";
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                        </th>
                        <th class="text-center" scope="col">
                            <div class="btn-group dropend">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <b><?php echo $applicationPWords['purposeLabel']; ?></b>
                                </button>
                                <ul class="dropdown-menu" style="background-color:#d1e7dd;">
                                    <li><a class="dropdown-item" href="?sortPurpose=purpVar1"><?php echo $applicationPWords['purposeVar1']; ?></a></li>
                                    <li><a class="dropdown-item" href="?sortPurpose=purpVar2"><?php echo $applicationPWords['purposeVar2']; ?></a></li>
                                    <li><a class="dropdown-item" href="?sortPurpose=purpVar3"><?php echo $applicationPWords['purposeVar3']; ?></a></li>
                                </ul>
                            </div>
                        </th>
                        <th class="text-center" scope="col">
                            <div class="btn-group dropend">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="white-space: normal;">
                                    <b><?php echo $requestsPWOrds['facultyLabel']; ?></b>
                                </button>
                                <ul class="dropdown-menu" style="background-color:#d1e7dd;">
                                    <?php
                                        for($i=0; $i<count($faculties); $i++){
                                            if($faculties[$i]['status'] == 1){    
                                                echo "<li><a class='dropdown-item' href='?sortFaculty=".$faculties[$i]['faculty_id']."'>".$faculties[$i]['faculty_name_'.$language]."</a></li>";
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                        </th>
                        <th class="text-center" scope="col">
                            <div class="btn-group dropend">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="white-space: normal;">
                                    <b><?php echo $applicationPWords['mobilityLabel']; ?></b>
                                </button>
                                <ul class="dropdown-menu" style="background-color:#d1e7dd;">
                                    <li><a class="dropdown-item" href="?sortMobil=mobilVar1"><?php echo $applicationPWords['mobilityVar1']; ?></a></li>
                                    <li><a class="dropdown-item" href="?sortMobil=mobilVar2"><?php echo $applicationPWords['mobilityVar2']; ?></a></li>
                                </ul>
                            </div>
                        </th>
                        <th class="text-center" scope="col"><?php echo $applicationPWords['periodLabel']; ?></th>
                        <th class="text-center" scope="col"><a class="btn btn-success btn-sm" href="requests.php"><?php echo $requestsPWOrds['btnClear']; ?></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i=0; $i<count($allUsers); $i++){
                                if($allUsers[$i]['email'] == 'academ.kaznu@gmail.com'){
                                    continue;
                                }
                                $id = $allUsers[$i]['id'];
                                $dataOfUser = new Data_and_File ($id, '', '');
                                if($allUsers[$i]['userType'] == 1){
                                    $data = $dataOfUser->findDataOfTeacher();
                                }elseif($allUsers[$i]['userType'] == 2){
                                    $data = $dataOfUser->findDataOfStudent();
                                }
                                if(isset($data["data_status"])){
                                    if($data["data_status"] == 1){
                                        if(!empty($_GET)){
                                            if(isset($_GET['sortPurpose'])){
                                                if($_GET['sortPurpose'] == 'purpVar1'){
                                                    if($data['purpose'] == 'Чтение лекций' || $data['purpose'] == 'Lecturing' || $data['purpose'] == 'Дәріс оқу'){
                                                        require "tableBody.php";
                                                    }
                                                }elseif($_GET['sortPurpose'] == 'purpVar2'){
                                                    if($data['purpose'] == 'Проведение исследовательской работы' || $data['purpose'] == 'Research work' || $data['purpose'] == 'Зерттеу жұмысы'){
                                                        require "tableBody.php";
                                                    }
                                                }elseif($_GET['sortPurpose'] == 'purpVar3'){
                                                    if($data['purpose'] != 'Проведение исследовательской работы' && 
                                                    $data['purpose'] != 'Research work' && 
                                                    $data['purpose'] != 'Зерттеу жұмысы' && 
                                                    $data['purpose'] != 'Чтение лекций' && 
                                                    $data['purpose'] != 'Lecturing' && 
                                                    $data['purpose'] != 'Дәріс оқу'){
                                                        require "tableBody.php";
                                                    }
                                                }
                                            }elseif(isset($_GET['sortCountry'])){
                                                for($y=0; $y<count($countries); $y++){
                                                    if($_GET['sortCountry'] == $countries[$y]['country_id'] && $_GET['sortCountry'] == $data['country_id']){
                                                        require "tableBody.php";
                                                    }
                                                }
                                            }elseif(isset($_GET['sortFaculty'])){
                                                for($t=0; $t<count($faculties); $t++){
                                                    if($_GET['sortFaculty'] == $faculties[$t]['faculty_id'] && $_GET['sortFaculty'] == $data['faculty_to_id']){
                                                        require "tableBody.php";
                                                    }
                                                }
                                            }elseif(isset($_GET['sortMobil'])){
                                                if($_GET['sortMobil'] == 'mobilVar1'){
                                                    if($data['mobility_form'] == 'Онлайн' || $data['mobility_form'] == 'Online'){
                                                        require "tableBody.php";
                                                    }
                                                }elseif($_GET['sortMobil'] == 'mobilVar2'){
                                                    if($data['mobility_form'] == 'Офлайн' || $data['mobility_form'] == 'Offline'){
                                                        require "tableBody.php";
                                                    }
                                                }
                                            }elseif(isset($_GET['regDate'])){
                                                if($_GET['regDate'] == $allUsers[$i]['createDate']){
                                                    require "tableBody.php";
                                                }
                                            }elseif(isset($_GET['sortUserType'])){
                                                if($_GET['sortUserType'] == 'typeVar1'){
                                                    if($allUsers[$i]['userType'] == 1){
                                                        require "tableBody.php";
                                                    }
                                                }elseif($_GET['sortUserType'] == 'typeVar2'){
                                                    if($allUsers[$i]['userType'] == 2){
                                                        require "tableBody.php";
                                                    }
                                                }
                                            }
                                        }else{
                                            require "tableBody.php";
                                        }
                                    }
                                }
                            }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php
        }
    }else{
        header('Location:authAndReg.php');
    }
?>