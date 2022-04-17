<?php
    session_start();
    require_once "user.php";
    if(ONLINE){
        require_once "db.php";
        require_once "forUsers/usersClass.php";
        require_once "forData/dataClass.php";
        require_once "forData/functionsOfData.php";
        $user = new User($_SESSION);
        $usersInfo = $user->findUser();
        $user_id = $_SESSION['id'];
        $data_and_files_of_user = new Data_and_File($user_id, '', '');
        if($usersInfo['userType']==1){
            $data_of_user = $data_and_files_of_user->findDataOfTeacher();
        }elseif($usersInfo['userType']==2){
            $data_of_user = $data_and_files_of_user->findDataOfStudent();
        }
        $files_of_user = $data_and_files_of_user->find_files_of_user();
        if(($data_of_user != null) && ($files_of_user != null)){
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title><?php echo $dataPWords['title']; ?></title>
</head>
<body>
    <?php
        require_once "nav.php";
    ?>
    <div class="container">
        <div class="row justify-content-center pt-5">
            <div class="col-lg-7">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="forData/actionsOfData.php?type=updatePersonalDates" method="POST">
                            <?php
                                if(isset($_GET['error'])){
                                    if($_GET['error'] == 'haveDataErr'){
                                        $message = $dataPWords['haveDataErr'];
                                    }elseif($_GET['error'] == 'upDataErr'){
                                        $message = $dataPWords['upDataErr'];
                                    }elseif($_GET['error'] == 'fillAllErr'){
                                        $message = $dataPWords['fillAllErr'];
                                    }
                            ?>
                            <label class="text-danger"><?php echo $message; ?></label>
                            <?php } ?>
                            <div class="form-group  mt-1">
                            <label class=""><?php echo $dataPWords['informationForData']; ?></label>
                            </div>
                            <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card1']; ?></label>
                            </div>
                            <div class="form-group  mt-1">
                                <label><?php echo $applicationPWords['nameLabel']; ?></label>
                                <input type="text" class="form-control" placeholder="<?php echo $usersInfo['name']; ?>" readonly>
                            </div>
                            <div class="form-group  mt-1">
                                <label><?php echo $applicationPWords['surnameLabel']; ?></label>
                                <input type="text" class="form-control" placeholder="<?php echo $usersInfo['surname']; ?>" readonly>
                            </div>
                            <div class="form-group  mt-1">
                                <label><?php echo $applicationPWords['sexLabel']; ?></label>
                                <select  required name="sex" class="form-select">
                                    <?php 
                                        if( ($data_of_user['sex'] == 'Мужской') || ($data_of_user['sex'] == 'Ер') || ($data_of_user['sex'] == 'Male') ){
                                            echo "<option selected>".$applicationPWords['sexVar1']."</option>
                                                    <option value=".$applicationPWords['sexVar2'].">".$applicationPWords['sexVar2']."</option>";
                                        }else{
                                            echo "<option selected>".$applicationPWords['sexVar2']."</option>
                                                    <option value=".$applicationPWords['sexVar1'].">".$applicationPWords['sexVar1']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['birthDateLabel']; ?></label>
                                <input required name="birthDate" type="date" class="form-control" value="<?php echo $data_of_user['birth_date'];?>">
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['placeOfBithrLabel']; ?></label>
                                <input required name="PlaceOfBirth" type="text" class="form-control" value="<?php echo $data_of_user['place_of_birth'];?>">
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['citizenshipLabel']; ?></label>
                                <select  required name="citizenship" class="form-select">
                                    <?php
                                        $countries = findCountries($language);
                                        for($i=0; $i<count($countries); $i++){
                                            if($countries[$i]['country_id'] == $data_of_user['country_id']){
                                                $selected = 'selected';
                                            }else{
                                                $selected = null; 
                                            }
                                            if($countries[$i]['status'] == 1){
                                                    $countryId = $countries[$i]['country_id'];
                                                    $countryName = $countries[$i]['country_name_'.$language];
                                                    echo "<option $selected value=$countryId>$countryName</option>"; 
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['nationalityLabel']; ?></label>
                                <select  required name="nationality" class="form-select">
                                    <?php
                                        $nationalities = findNationality($language);
                                        for($i=0; $i<count($nationalities); $i++){
                                            if($nationalities[$i]['nationality_id'] == $data_of_user['nationality_id']){
                                                $selected = 'selected';
                                            }else{
                                                $selected = null; 
                                            }
                                            if($nationalities[$i]['status'] == 1){
                                                    $nationalityId = $nationalities[$i]['nationality_id'];
                                                    $nationalityName = $nationalities[$i]['nationality_name_'.$language];
                                                    echo "<option $selected value=$nationalityId>$nationalityName</option>"; 
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['passportNumberLabel']; ?></label>
                                <input required name="passportNumber" type="text" class="form-control" value="<?php echo $data_of_user['passport_number'];?>">
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['issueDateLabel']; ?></label>
                                <input required name="issueDate" type="date" class="form-control" value="<?php echo $data_of_user['issue_date_of_passport'];?>">
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['expiryDateLabel']; ?></label>
                                <input required name="expiryDate" type="date" class="form-control" value="<?php echo $data_of_user['expiry_date_of_passport'];?>">
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['addressOfResidenceLabel']; ?></label>
                                <input required name="addressOfResidence" type="text" class="form-control" value="<?php echo $data_of_user['address_of_residence'];?>">
                            </div>
                            <?php if($usersInfo['userType']==1){ ?>
                            <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd;">
                                <label class="mb-2"><?php echo $applicationPWords['card2']; ?></label>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['universityLabel1']; ?></label>
                                <input required name="university" type="text" class="form-control" value="<?php echo $data_of_user['university'];?>">
                            </div>
                            <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd;">
                                <label class="mb-2"><?php echo $applicationPWords['card4']; ?></label>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['academicDegreeLabel']; ?></label>
                                <select  required name="academicDegree" class="form-select">
                                    <option selected>
                                        <?php 
                                            if( ($data_of_user['academicDegree'] == 'Бакалавр') || ($data_of_user['academicDegree'] == 'Bachelor') ){
                                                echo $applicationPWords['academDegVar1'];
                                            }elseif( ($data_of_user['academicDegree'] == 'Магистр') || ($data_of_user['academicDegree'] == 'Master') ){
                                                echo $applicationPWords['academDegVar2'];
                                            }elseif($data_of_user['academicDegree'] == 'PHD'){
                                                echo $applicationPWords['academDegVar3'];
                                            }
                                        ?>
                                    </option>
                                    <?php 
                                        if( ($data_of_user['academicDegree'] != 'Бакалавр') && ($data_of_user['academicDegree'] != 'Bachelor') ){
                                            echo "<option value=".$applicationPWords['academDegVar1'].">".$applicationPWords['academDegVar1']."</option>";
                                            }
                                        if( ($data_of_user['academicDegree'] != 'Магистр') && ($data_of_user['academicDegree'] != 'Master') ){
                                            echo "<option value=".$applicationPWords['academDegVar2'].">".$applicationPWords['academDegVar2']."</option>";
                                            }
                                        if($data_of_user['academicDegree'] != 'PHD'){
                                            echo "<option value=".$applicationPWords['academDegVar3'].">".$applicationPWords['academDegVar3']."</option>";
                                            }
                                    ?>
                                </select>
                            </div>
                            <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd;">
                                <label class="mb-2"><?php echo $applicationPWords['card3']; ?></label>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['purposeLabel']; ?></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="purpose" id="radio1" value="<?php echo $applicationPWords['purposeVar1']; ?>" 
                                    <?php 
                                        if( ($data_of_user['purpose'] == 'Чтение лекций') || 
                                        ($data_of_user['purpose'] == 'Дәріс оқу') || 
                                        ($data_of_user['purpose'] == 'Lecturing') ){
                                            echo 'checked';
                                        }
                                    ?>
                                    >
                                    <label class="form-check-label" for="radio1"><?php echo $applicationPWords['purposeVar1']; ?></label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="purpose" id="radio2" value="<?php echo $applicationPWords['purposeVar2']; ?>"
                                    <?php 
                                        if( ($data_of_user['purpose'] == 'Проведение исследовательской работы') || 
                                        ($data_of_user['purpose'] == 'Зерттеу жұмысы') || 
                                        ($data_of_user['purpose'] == 'Research work') ){
                                            echo 'checked';
                                        }
                                    ?>
                                    >
                                    <label class="form-check-label" for="radio2"><?php echo $applicationPWords['purposeVar2']; ?></label>
                                </div>

                                <div class="form-check">
                                    <?php 
                                        if( ($data_of_user['purpose'] != 'Проведение исследовательской работы') && 
                                        ($data_of_user['purpose'] != 'Зерттеу жұмысы') && 
                                        ($data_of_user['purpose'] != 'Research work') && 
                                        ($data_of_user['purpose'] != 'Чтение лекций') && 
                                        ($data_of_user['purpose'] != 'Дәріс оқу') && 
                                        ($data_of_user['purpose'] != 'Lecturing') ){
                                            $checked = 'checked';
                                            $value = $data_of_user['purpose'];
                                        }else{
                                            $checked = null;
                                            $value = null;
                                        }
                                    ?>
                                    <input class="form-check-input" type="radio" name="purpose" id="radio3" <?php echo $checked; ?>>
                                    <label class="form-check-label" for="radio3"><?php echo $applicationPWords['purposeVar3']; ?></label>
                                                
                                    <div id="forWrite" 
                                        <?php 
                                            if( ($data_of_user['purpose'] == 'Проведение исследовательской работы') || 
                                            ($data_of_user['purpose'] == 'Зерттеу жұмысы') || 
                                            ($data_of_user['purpose'] == 'Research work') || 
                                            ($data_of_user['purpose'] == 'Чтение лекций') || 
                                            ($data_of_user['purpose'] == 'Дәріс оқу') || 
                                            ($data_of_user['purpose'] == 'Lecturing') ){
                                                echo 'hidden';
                                            }
                                        ?>
                                        >
                                        <input type="text" name="radio3_data" class="form-control" for="radio3" value="<?php echo $value; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php 
                                }
                                if($usersInfo['userType']==2){
                            ?>
                            <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card2']; ?></label>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['universityLabel2']; ?></label>
                                <input required name="university" type="text" class="form-control" value="<?php echo $data_of_user['sending_university'];?>">
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['facultyFrom']; ?></label>
                                <input required name="facultyFrom" type="text" class="form-control" value="<?php echo $data_of_user['faculty_from'];?>">
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['degreeLabel']; ?></label>
                                <select  required name="academicDegree" class="form-select">
                                    <option selected>
                                        <?php 
                                            if( ($data_of_user['academic_degree'] == 'Бакалавр') || ($data_of_user['academic_degree'] == 'Bachelor') ){
                                                echo $applicationPWords['academDegVar1'];
                                            }elseif( ($data_of_user['academic_degree'] == 'Магистр') || ($data_of_user['academic_degree'] == 'Master') ){
                                                echo $applicationPWords['academDegVar2'];
                                            }elseif($data_of_user['academic_degree'] == 'PHD'){
                                                echo $applicationPWords['academDegVar3'];
                                            }
                                        ?>
                                    </option>
                                    <?php 
                                        if( ($data_of_user['academic_degree'] != 'Бакалавр') && ($data_of_user['academic_degree'] != 'Bachelor') ){
                                            echo "<option value=".$applicationPWords['academDegVar1'].">".$applicationPWords['academDegVar1']."</option>";
                                            }
                                        if( ($data_of_user['academic_degree'] != 'Магистр') && ($data_of_user['academic_degree'] != 'Master') ){
                                            echo "<option value=".$applicationPWords['academDegVar2'].">".$applicationPWords['academDegVar2']."</option>";
                                            }
                                        if($data_of_user['academic_degree'] != 'PHD'){
                                            echo "<option value=".$applicationPWords['academDegVar3'].">".$applicationPWords['academDegVar3']."</option>";
                                            }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['majorLabel']; ?></label>
                                <input required name="major" type="text" class="form-control" value="<?php echo $data_of_user['major'];?>">
                            </div>
                            <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card3']; ?></label>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['purposeLabel']; ?></label>
                                <div class="form-check">
                                    <?php
                                        $radio1Value = $applicationPWords['purposeVar4'];
                                        $radio2Value = $applicationPWords['purposeVar5'];
                                        if( ($data_of_user['purpose'] == 'Стажировка') || 
                                        ($data_of_user['purpose'] == 'Тәжірибе жинау') || 
                                        ($data_of_user['purpose'] == 'Internship') ){
                                            $checked1 = 'checked';
                                            $hidden = 'hidden';
                                        }elseif( ($data_of_user['purpose'] == 'Семестровое обучение') || 
                                        ($data_of_user['purpose'] == 'Семестрлік оқу') || 
                                        ($data_of_user['purpose'] == 'Semester training') ){
                                            $checked2 = 'checked';
                                            $hidden = 'hidden';
                                        }else{
                                            $checked = 'checked';
                                            $value = $data_of_user['purpose'];
                                        }
                                    ?>
                                    <input class="form-check-input" type="radio" name="purpose" id="radio1" <?php echo "value='".$radio1Value."'"; if(isset($checked1)){echo $checked1;} ?>>
                                    <label class="form-check-label" for="radio1"><?php echo $radio1Value; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="purpose" id="radio2" <?php echo "value='".$radio2Value."'"; if(isset($checked2)){echo $checked2;} ?>>
                                    <label class="form-check-label" for="radio2"><?php echo $radio2Value; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="purpose" id="radio3" <?php if(isset($checked)){echo $checked;} ?>>
                                    <label class="form-check-label" for="radio3"><?php echo $applicationPWords['purposeVar3']; ?></label>
                                    <div id="forWrite" <?php if(isset($hidden)){echo $hidden;} ?>>
                                    <input type="text" name="radio3_data"class="form-control" for="radio3" value="<?php if(isset($value)){echo $value;} ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['mobilityProgramLabel']; ?></label>
                                <?php
                                        $radio1MPValue = $applicationPWords['mobilityProgramVar1'];
                                        $radio2MPValue = $applicationPWords['mobilityProgramVar2'];
                                        $radio3MPValue = $applicationPWords['mobilityProgramVar3'];
                                        $radio4MPValue = $applicationPWords['mobilityProgramVar4'];
                                        $radio5MPValue = $applicationPWords['mobilityProgramVar5'];
                                        $radio6MPValue = $applicationPWords['mobilityProgramVar6'];
                                        if( ($data_of_user['mobility_program'] == 'Эразмус+') || 
                                            ($data_of_user['mobility_program'] == 'Эразмус+*') || 
                                            ($data_of_user['mobility_program'] == 'Erasmus+*') ){
                                            $checked3 = 'checked';
                                            $hidden2 = 'hidden';
                                        }elseif( ($data_of_user['mobility_program'] == 'Мевлана') || 
                                            ($data_of_user['mobility_program'] == 'Мевлана*') || 
                                            ($data_of_user['mobility_program'] == 'Mevlana*') ){
                                            $checked4 = 'checked';
                                            $hidden2 = 'hidden';
                                        }elseif( ($data_of_user['mobility_program'] == 'Орхун') || 
                                            ($data_of_user['mobility_program'] == 'Орхун*') || 
                                            ($data_of_user['mobility_program'] == 'Orhun*') ){
                                            $checked5 = 'checked';
                                            $hidden2 = 'hidden';
                                        }elseif( ($data_of_user['mobility_program'] == 'Межуниверситетский обмен') || 
                                            ($data_of_user['mobility_program'] == 'Университетаралық алмасу') || 
                                            ($data_of_user['mobility_program'] == 'Inter-university exchange') ){
                                            $checked6 = 'checked';
                                            $hidden2 = 'hidden';
                                        }elseif( ($data_of_user['mobility_program'] == 'УШОС') || 
                                            ($data_of_user['mobility_program'] == 'УШОС*') || 
                                            ($data_of_user['mobility_program'] == 'USSC*') ){
                                            $checked7 = 'checked';
                                            $hidden2 = 'hidden';
                                        }elseif( ($data_of_user['mobility_program'] == 'СУСНГ') || 
                                            ($data_of_user['mobility_program'] == 'СУСНГ*') || 
                                            ($data_of_user['mobility_program'] == 'SUSNG*') ){
                                            $checked8 = 'checked';
                                            $hidden2 = 'hidden';
                                        }else{
                                            $checked9 = 'checked';
                                            $value2 = $data_of_user['mobility_program'];
                                        }
                                    ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mobilityProgram" id="radio1MP" <?php echo "value='".$radio1MPValue."'"; if(isset($checked3)){echo $checked3;} ?>>
                                    <label class="form-check-label" for="radio1MP"><?php echo $radio1MPValue; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mobilityProgram" id="radio2MP" <?php echo "value='".$radio2MPValue."'"; if(isset($checked4)){echo $checked4;} ?>>
                                    <label class="form-check-label" for="radio2MP"><?php echo $radio2MPValue; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mobilityProgram" id="radio3MP" <?php echo "value='".$radio3MPValue."'"; if(isset($checked5)){echo $checked5;} ?>>
                                    <label class="form-check-label" for="radio3MP"><?php echo $radio3MPValue; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mobilityProgram" id="radio4MP" <?php echo "value='".$radio4MPValue."' "; if(isset($checked6)){echo $checked6;} ?>>
                                    <label class="form-check-label" for="radio4MP"><?php echo $radio4MPValue; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mobilityProgram" id="radio5MP" <?php echo "value='".$radio5MPValue."'"; if(isset($checked7)){echo $checked7;} ?>>
                                    <label class="form-check-label" for="radio5MP"><?php echo $radio5MPValue; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mobilityProgram" id="radio6MP" <?php echo "value='".$radio6MPValue."'"; if(isset($checked8)){echo $checked8;} ?>>
                                    <label class="form-check-label" for="radio6MP"><?php echo $radio6MPValue; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mobilityProgram" id="radio7MP" <?php if(isset($checked9)){echo $checked9;} ?>>
                                    <label class="form-check-label" for="radio7MP"><?php echo $applicationPWords['purposeVar3']; ?></label>
                                    <div id="forWriteMP" <?php if(isset($hidden2)){echo $hidden2;} ?>>
                                    <input type="text" name="radio7_data" class="form-control" for="radio7MP" value="<?php if(isset($value2)){echo $value2;} ?>">
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['facultyLabel']; ?></label>
                                <select  required name="faculty" class="form-select">
                                    <?php
                                        $faculties = findFaculties($language);
                                        for($i=0; $i<count($faculties); $i++){
                                            if($faculties[$i]['faculty_id'] == $data_of_user['faculty_to_id']){
                                                $selected = 'selected';
                                            }else{
                                                $selected = null; 
                                            }
                                            if($faculties[$i]['status'] == 1){
                                                $facultyId = $faculties[$i]['faculty_id'];
                                                $facultyName = $faculties[$i]['faculty_name_'.$language];
                                                echo "<option $selected value=$facultyId>$facultyName</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['mobilityLabel']; ?></label>
                                <select  required name="mobility" class="form-select">
                                    <?php 
                                        if( ($data_of_user['mobility_form'] == 'Онлайн') || ($data_of_user['mobility_form'] == 'Online') ){
                                            echo "<option selected>".$applicationPWords['mobilityVar1']."</option>
                                                    <option value=".$applicationPWords['mobilityVar2'].">".$applicationPWords['mobilityVar2']."</option>";
                                        }else{
                                            echo "<option selected>".$applicationPWords['mobilityVar2']."</option>
                                                    <option value=".$applicationPWords['mobilityVar1'].">".$applicationPWords['mobilityVar1']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['periodLabel']; ?></label>
                                <br><label>
                                    <?php echo $applicationPWords['periodVar1']; ?>
                                </label><input required name="periodFrom" type="date" class="form-control" value="<?php echo $data_of_user['period_from']; ?>">
                                <label>
                                    <?php echo $applicationPWords['periodVar2']; ?>
                                </label><input required name="periodTo" type="date" class="form-control" value="<?php echo $data_of_user['period_to'];?>">
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['visaSupportLabel']; ?></label>
                                <div class="form-check">
                                    <?php 
                                        if( $data_of_user['visa_support'] == 'Hет' || 
                                            $data_of_user['visa_support'] == 'Жоқ' || 
                                            $data_of_user['visa_support'] == 'No' ){
                                                $indicator = true;
                                        }else{
                                            $indicator = false;
                                        }
                                    ?>
                                    <input class="form-check-input" type="radio" name="visaSupport" id="radio2_1" 
                                        <?php if(!$indicator){echo 'checked';} ?>
                                    >
                                    <label class="form-check-label" for="radio2_1"><?php echo $applicationPWords['supportVar1']; ?></label>
                                </div>
                                <div id="forVisaSupport" 
                                    <?php if($indicator){echo 'hidden';} ?>
                                    >
                                    <input type="text" name="radio2_1_data" class="form-control" for="radio2_1" value=
                                        "<?php if(!$indicator){echo $data_of_user['visa_support'];}?>"
                                    >
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="visaSupport" id="radio2_2" value="<?php echo $applicationPWords['supportVar2']; ?>" 
                                    <?php if($indicator){echo 'checked';} ?>
                                    >
                                    <label class="form-check-label" for="radio2_2"><?php echo $applicationPWords['supportVar2']; ?></label>        
                                </div>
                            </div>
                            <?php if($usersInfo['userType']==2){?>
                            <div class="form-group mt-1">
                                <label><?php echo $applicationPWords['dormitoryLabel']; ?></label>
                                <select  required name="dormitory" class="form-select">
                                    <?php 
                                        if( $data_of_user['dormitory_need'] == 'Hет' || 
                                            $data_of_user['dormitory_need'] == 'Жоқ' || 
                                            $data_of_user['dormitory_need'] == 'No' ){
                                                $indicator = true;
                                        }else{
                                            $indicator = false;
                                        }
                                    ?>
                                    <option value="<?php echo $applicationPWords['supportVar1']; ?>" <?php if(!$indicator){echo 'checked';} ?> ><?php echo $applicationPWords['supportVar1']; ?></option>
                                    <option value="<?php echo $applicationPWords['supportVar2']; ?>" <?php if(!$indicator){echo 'checked';} ?> ><?php echo $applicationPWords['supportVar2']; ?></option>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="form-group text-end">
                                <button type="submit" class="btn btn-success mt-3"><?php echo $dataPWords['buttonForData']; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center pt-5 mb-5">
            <div class="col-lg-7">
                <div class="card shadow">
                    <div class="card-body">

                            <?php
                            if(isset($_GET['error2'])){
                                if($_GET['error2']){
                                    $message = $dataPWords['upFilesErr'];
                                }
                            ?>
                            <label class="text-info"><?php echo $message; ?></label>
                            <?php } ?>
                    
                        <form action="forData/actionsOfData.php?type=updatePersonalFiles" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class=""><?php echo $dataPWords['informationForFile']; ?></label>
                            </div>

                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['passportLabel']; ?></label>
                                <label><?php
                                    for($i = 0; $i < count($files_of_user); $i++){
                                        if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "copy_of_passport"){
                                            echo '- '.$files_of_user[$i]['file_name'];
                                        }
                                    }
                                ?></label>
                                <button type="button" class="btn btn-sm btn-outline-info" style="border:0;" id="forPassport"><?php echo $dataPWords['buttonForChange']; ?></button>
                                <div id="copy_passport" hidden>
                                    <input type="file" class="form-control" id="choose" name="copy_of_passport" hidden accept="application/pdf">
                                    <input type="button" class="btn btn-outline-secondary" onClick="getFile.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                    <label id="selected"><?php echo $applicationPWords['infForFile']; ?></label>
                                </div>
                            </div>
                            <?php if($usersInfo['userType']==1){ ?>
                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['certificateOfEmploymentLabel']; ?></label>
                                <label><?php
                                    for($i = 0; $i < count($files_of_user); $i++){
                                        if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "certificate_of_employment"){
                                            echo '- '.$files_of_user[$i]['file_name'];
                                        }
                                    }
                                ?></label>
                                <button type="button" class="btn btn-sm btn-outline-info" style="border:0;" id="forEmployment"><?php echo $dataPWords['buttonForChange']; ?></button>
                                <div id="certificate_of_employment" hidden>
                                    <input type="file" class="form-control" id="chooseCoE" name="certificate_of_employment" hidden accept="application/pdf">
                                    <input type="button" class="btn btn-outline-secondary" onClick="getFile1.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                    <label id="selectedCoE"><?php echo $applicationPWords['infForFile']; ?></label>
                                </div>
                            </div>

                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['educationDocumentLabel']; ?></label>
                                <label><?php
                                    for($i = 0; $i < count($files_of_user); $i++){
                                        if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "education_document"){
                                            echo '- '.$files_of_user[$i]['file_name'];
                                        }
                                    }
                                ?></label>
                                <button type="button" class="btn btn-sm btn-outline-info" style="border:0;" id="for_education_document"><?php echo $dataPWords['buttonForChange']; ?></button>
                                <div id="education_document" hidden>
                                    <input type="file" class="form-control" id="chooseED" name="education_document" hidden accept="application/pdf">
                                    <input type="button" class="btn btn-outline-secondary" onClick="getFile2.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                    <label id="selectedED"><?php echo $applicationPWords['infForFile']; ?></label>
                                </div>
                            </div>

                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['CVLabel']; ?></label>
                                <label><?php
                                    for($i = 0; $i < count($files_of_user); $i++){
                                        if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "CV"){
                                            echo '- '.$files_of_user[$i]['file_name'];
                                        }
                                    }
                                ?></label>
                                <button type="button" class="btn btn-sm btn-outline-info" style="border:0;" id="forCV"><?php echo $dataPWords['buttonForChange']; ?></button>
                                <div id="CV" hidden>
                                    <input type="file" class="form-control" id="chooseCV" name="CV" hidden accept="application/pdf">
                                    <input type="button" class="btn btn-outline-secondary" onClick="getFile3.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                    <label id="selectedCV"><?php echo $applicationPWords['infForFile']; ?></label>
                                </div>
                            </div>

                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['publicationsLabel']; ?></label>
                                <label><?php
                                    for($i = 0; $i < count($files_of_user); $i++){
                                        if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "publications"){
                                            echo '- '.$files_of_user[$i]['file_name'];
                                        }
                                    }
                                ?></label>
                                <button type="button" class="btn btn-sm btn-outline-info" style="border:0;" id="forPublications"><?php echo $dataPWords['buttonForChange']; ?></button>
                                <div id="publications" hidden>
                                    <input type="file" class="form-control" id="choosePubl" name="publications" hidden accept="application/pdf">
                                    <input type="button" class="btn btn-outline-secondary" onClick="getFile4.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                    <label id="selectedPubl"><?php echo $applicationPWords['infForFile']; ?></label>
                                </div>
                            </div>
                            <?php 
                                }
                                if($usersInfo['userType']==2){
                            ?>
                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['nominationLetterLabel']; ?></label>
                                <label><?php
                                    for($i = 0; $i < count($files_of_user); $i++){
                                        if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "nomination_letter"){
                                            echo '- '.$files_of_user[$i]['file_name'];
                                        }
                                    }
                                ?></label>
                                <button type="button" class="btn btn-sm btn-outline-info" style="border:0;" id="forNomination_letter"><?php echo $dataPWords['buttonForChange']; ?></button>
                                <div id="nominationLetter" hidden>
                                    <input type="file" class="form-control" id="chooseNL" hidden name="nomination_letter" accept="application/pdf">
                                    <input type="button" class="btn btn-outline-secondary" onClick="getFile5.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                    <label id="selectedNL"><?php echo $applicationPWords['infForFile']; ?></label>
                                </div>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['transcriptLabel']; ?></label>
                                <label><?php
                                    for($i = 0; $i < count($files_of_user); $i++){
                                        if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "transcript"){
                                            echo '- '.$files_of_user[$i]['file_name'];
                                        }
                                    }
                                ?></label>
                                <button type="button" class="btn btn-sm btn-outline-info" style="border:0;" id="forTranscript"><?php echo $dataPWords['buttonForChange']; ?></button>
                                <div id="transcript" hidden>
                                    <input type="file" class="form-control" id="chooseTranscript" hidden name="transcript" accept="application/pdf">
                                    <input type="button" class="btn btn-outline-secondary" onClick="getFile6.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                    <label id="selectedTranscript"><?php echo $applicationPWords['infForFile']; ?></label>
                                </div>
                            </div>
                            <div class="form-group mt-1">
                                <label><?php echo $dataPWords['agreementLabel']; ?></label>
                                <label><?php
                                    for($i = 0; $i < count($files_of_user); $i++){
                                        if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "agreement"){
                                            echo '- '.$files_of_user[$i]['file_name'];
                                        }
                                    }
                                ?></label>
                                <button type="button" class="btn btn-sm btn-outline-info" style="border:0;" id="forAgreement"><?php echo $dataPWords['buttonForChange']; ?></button>
                                <div id="agreement" hidden>
                                    <input type="file" class="form-control" id="chooseAgreement" hidden name="agreement" accept="application/pdf">
                                    <input type="button" class="btn btn-outline-secondary" onClick="getFile7.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                    <label id="selectedAgreement"><?php echo $applicationPWords['infForFile']; ?></label>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group text-end">
                                <button type="submit" class="btn btn-success mt-2"><?php echo $dataPWords['buttonForFile']; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="JS/selectFile.js"></script>
    <script>
        document.getElementById("radio2_1").addEventListener("click", function() {
            document.getElementById("forVisaSupport").hidden = false;
            });
        document.getElementById("radio2_2").addEventListener("click", function() {
            document.getElementById("forVisaSupport").hidden = true;
            });

            document.getElementById("radio3").addEventListener("click", function() {
            document.getElementById("forWrite").hidden = false;
            });
        document.getElementById("radio1").addEventListener("click", function() {
            document.getElementById("forWrite").hidden = true;
            });
        document.getElementById("radio2").addEventListener("click", function() {
            document.getElementById("forWrite").hidden = true;
            });

        document.getElementById("forPassport").addEventListener("click", function() {
            document.getElementById("copy_passport").hidden = false;
            });
        var getFile = new selectFile;
        getFile.targets('choose','selected');
    </script>
    <?php if($usersInfo['userType']==1){ ?>
        <script>
            document.getElementById("forEmployment").addEventListener("click", function() {
                document.getElementById("certificate_of_employment").hidden = false;
                });
            var getFile1 = new selectFile1;
            getFile1.targets('chooseCoE','selectedCoE');

            document.getElementById("for_education_document").addEventListener("click", function() {
                document.getElementById("education_document").hidden = false;
                });
            var getFile2 = new selectFile2;
            getFile2.targets('chooseED','selectedED');

            document.getElementById("forCV").addEventListener("click", function() {
                document.getElementById("CV").hidden = false;
                });
            var getFile3 = new selectFile3;
            getFile3.targets('chooseCV','selectedCV');

            document.getElementById("forPublications").addEventListener("click", function() {
                document.getElementById("publications").hidden = false;
                });
            var getFile4 = new selectFile4;
            getFile4.targets('choosePubl','selectedPubl');
        </script>
    <?php
        }
        if($usersInfo['userType']==2){
    ?>
    <script>
        document.getElementById("radio7MP").addEventListener("click", function() {
            document.getElementById("forWriteMP").hidden = false;
            });
        document.getElementById("radio1MP").addEventListener("click", function() {
            document.getElementById("forWriteMP").hidden = true;
            });
        document.getElementById("radio2MP").addEventListener("click", function() {
            document.getElementById("forWriteMP").hidden = true;
            });
        document.getElementById("radio3MP").addEventListener("click", function() {
            document.getElementById("forWriteMP").hidden = true;
            });
        document.getElementById("radio4MP").addEventListener("click", function() {
            document.getElementById("forWriteMP").hidden = true;
            });
        document.getElementById("radio5MP").addEventListener("click", function() {
            document.getElementById("forWriteMP").hidden = true;
            });
        document.getElementById("radio6MP").addEventListener("click", function() {
            document.getElementById("forWriteMP").hidden = true;
            });

        document.getElementById("forNomination_letter").addEventListener("click", function() {
            document.getElementById("nominationLetter").hidden = false;
            });
        var getFile5 = new selectFile5;
        getFile5.targets('chooseNL','selectedNL');

        document.getElementById("forTranscript").addEventListener("click", function() {
            document.getElementById("transcript").hidden = false;
            });
        var getFile6 = new selectFile6;
        getFile6.targets('chooseTranscript','selectedTranscript');

        document.getElementById("forAgreement").addEventListener("click", function() {
            document.getElementById("agreement").hidden = false;
            });
        var getFile7 = new selectFile7;
        getFile7.targets('chooseAgreement','selectedAgreement');
        
    </script>
    <?php
        }
    ?>
</body>
</html>
<?php
    }else{
        header('Location:personalDataList.php?error=fillErr');
    }
}else{
    header('Location:authAndREg.php?error=downloadAuthErr');
}
?>