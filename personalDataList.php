<?php
    session_start();
    require_once "user.php";
    if(ONLINE){
        require_once "db.php";
        require_once "forUsers/usersClass.php";
        require_once "forData/dataClass.php";
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
            header('Location:preSendData.php?error=haveDataErr');
        }else{
            require_once "forData/functionsOfData.php";
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
    <title><?php echo $applicationPWords['title']; ?></title>
</head>
<body>
    <?php
        require_once "nav.php";
    ?>
    <div class="container">
        <div class="row justify-content pt-5 mb-5">
            <div class="col-lg-7">
                <div class="card shadow">
                    <div class="card-body">
                        <?php
                            if(isset($_GET['error'])){
                                if($_GET['error'] == 'fillAllErr'){
                                    $message = $applicationPWords['fillAllErr'];
                                    echo "<label class='text-info'>$message</label>";
                                }elseif($_GET['error'] == 'fillErr'){
                                    $message = $applicationPWords['fillErr'];
                                    echo "<label class='text-info'>$message</label>"; 
                                }elseif($_GET['error'] == 'notHaveDataErr'){
                                    $message = $applicationPWords['notHaveDataErr'];
                                    echo "<label class='text-info'>$message</label>"; 
                                }
                            }
                            if($usersInfo['userType'] == 1){
                        ?>
                        <form method="POST" action="forData/actionsOfData.php?type=personalDates1" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="mb-2"><?php echo $applicationPWords['information']; ?></label>
                            </div>
                            <div class="form-group mt-4" id="card1teach">
                                <div class="card-header text-center" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card1']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['nameLabel']; ?></label>
                                    <input type="text" class="form-control" placeholder="<?php echo $usersInfo['name']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['surnameLabel']; ?></label>
                                    <input type="text" class="form-control" placeholder="<?php echo $usersInfo['surname']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['sexLabel']; ?></label>
                                    <select  required name="sex" class="form-select">
                                        <option value="<?php echo $applicationPWords['sexVar1']; ?>"><?php echo $applicationPWords['sexVar1']; ?></option>
                                        <option value="<?php echo $applicationPWords['sexVar2']; ?>"><?php echo $applicationPWords['sexVar2']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['birthDateLabel']; ?></label>
                                    <input required name="birthDate" type="date" class="form-control" value="2000-01-01">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['placeOfBithrLabel']; ?></label>
                                    <input required name="PlaceOfBirth" type="text" class="form-control" placeholder="<?php echo $applicationPWords['placeOfBithrLabel']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['citizenshipLabel']; ?></label>
                                    <select  required name="citizenship" class="form-select">
                                    <?php
                                        $countries = findCountries($language);
                                        for($i=0; $i<count($countries); $i++){
                                            if($countries[$i]['status'] == 1){
                                                $countryId = $countries[$i]['country_id'];
                                                $countryName = $countries[$i]['country_name_'.$language];
                                                echo "<option value=$countryId>$countryName</option>";
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['nationalityLabel']; ?></label>
                                    <select  required name="nationality" class="form-select">
                                        <?php
                                            $nationalities = findNationality($language);
                                            for($i=0; $i<count($nationalities); $i++){
                                                if($nationalities[$i]['status'] == 1){
                                                    $nationalityId = $nationalities[$i]['nationality_id'];
                                                    $nationalityName = $nationalities[$i]['nationality_name_'.$language];
                                                    echo "<option value=$nationalityId>$nationalityName</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['passportNumberLabel']; ?></label>
                                    <input required name="passportNumber" type="text" class="form-control" placeholder="<?php echo $applicationPWords['passportNumberLabel']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['issueDateLabel']; ?></label>
                                    <input required name="issueDate" type="date" class="form-control" value="2017-01-01">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['expiryDateLabel']; ?></label>
                                    <input required name="expiryDate" type="date" class="form-control" value="2026-01-01">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['addressOfResidenceLabel']; ?></label>
                                    <input required name="addressOfResidence" type="text" class="form-control" placeholder="<?php echo $applicationPWords['addressOfResidenceLabel']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['copyOfPassportLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="choose" name="copy_of_passport" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selected"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group text-end me-5">
                                    <button type="button" class="btn btn-success mt-2 " id="btnCard1teach"><?php echo $applicationPWords['btnNext']; ?></button>
                                </div>
                            </div>
                            <div class="form-group mt-4" hidden id="card2teach">
                                <div class="card-header text-center" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card2']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['universityLabel1']; ?></label>
                                    <input required name="university" type="text" class="form-control" placeholder="<?php echo $applicationPWords['universityValue']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['certificateOfEmploymentLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="chooseCoE" name="certificate_of_employment" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile1.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selectedCoE"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group text-end me-5">
                                    <button type="button" class="btn btn-success mt-2 " id="btn1Card2teach"><?php echo $applicationPWords['btnBack']; ?></button>
                                    <button type="button" class="btn btn-success mt-2 " id="btn2Card2teach"><?php echo $applicationPWords['btnNext']; ?></button>
                                </div>
                            </div>
                            <div class="form-group mt-4" hidden id="card3teach">
                                <div class="card-header text-center" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card4']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['academicDegreeLabel']; ?></label>
                                    <select  required name="academicDegree" class="form-select">
                                        <option value="<?php echo $applicationPWords['academDegVar1']; ?>"><?php echo $applicationPWords['academDegVar1']; ?></option>
                                        <option value="<?php echo $applicationPWords['academDegVar2']; ?>"><?php echo $applicationPWords['academDegVar2']; ?></option>
                                        <option value="<?php echo $applicationPWords['academDegVar3']; ?>"><?php echo $applicationPWords['academDegVar3']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['educationDocumentLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="chooseED" name="education_document" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile2.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selectedED"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['CVLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="chooseCV" name="CV" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile3.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selectedCV"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['publicationsLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="choosePubl" name="publications" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile4.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selectedPubl"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group text-end me-5">
                                    <button type="button" class="btn btn-success mt-2 " id="btn1Card3teach"><?php echo $applicationPWords['btnBack']; ?></button>
                                    <button type="button" class="btn btn-success mt-2 " id="btn2Card3teach"><?php echo $applicationPWords['btnNext']; ?></button>
                                </div>
                            </div>
                            <div class="form-group mt-4" hidden id="card4teach">
                                <div class="card-header text-center" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card3']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['purposeLabel']; ?></label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="purpose" id="radio1" value="<?php echo $applicationPWords['purposeVar1']; ?>">
                                        <label class="form-check-label" for="radio1"><?php echo $applicationPWords['purposeVar1']; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="purpose" id="radio2" value="<?php echo $applicationPWords['purposeVar2']; ?>">
                                        <label class="form-check-label" for="radio2"><?php echo $applicationPWords['purposeVar2']; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="purpose" id="radio3">
                                        <label class="form-check-label" for="radio3"><?php echo $applicationPWords['purposeVar3']; ?></label>
                                        
                                        <div id="forWrite" hidden>
                                        <input type="text" name="radio3_data"class="form-control" for="radio3">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['facultyLabel']; ?></label>
                                    <select  required name="faculty" class="form-select">
                                        <?php 
                                            $faculties = findFaculties($language);
                                            for($i=0; $i<count($faculties); $i++){
                                                $facultyId = $faculties[$i]['faculty_id'];
                                                $facultyName = $faculties[$i]['faculty_name_'.$language];
                                                echo "<option value=$facultyId>$facultyName</option>";
                                                } 
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['mobilityLabel']; ?></label>
                                    <select  required name="mobility" class="form-select">
                                        <option value="<?php echo $applicationPWords['mobilityVar1']; ?>"><?php echo $applicationPWords['mobilityVar1']; ?></option>
                                        <option value="<?php echo $applicationPWords['mobilityVar2']; ?>"><?php echo $applicationPWords['mobilityVar2']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['periodLabel']; ?></label>
                                    <br><label><?php echo $applicationPWords['periodVar1']; ?></label>
                                        <input required name="periodFrom" type="date" class="form-control" value="2021-01-01">
                                        <label><?php echo $applicationPWords['periodVar2']; ?></label>
                                        <input required name="periodTo" type="date" class="form-control" value="2022-01-01">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['visaSupportLabel']; ?></label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visaSupport" id="radio2_1" >
                                        <label class="form-check-label" for="radio2_1"><?php echo $applicationPWords['supportVar1']; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visaSupport" id="radio2_2" value="<?php echo $applicationPWords['supportVar2']; ?>">
                                        <label class="form-check-label" for="radio2_2"><?php echo $applicationPWords['supportVar2']; ?></label>
                                        
                                        <div id="forVisaSupport" hidden>
                                        <input type="text" name="radio2_1_data" class="form-control" for="radio2_1" placeholder="<?php echo $applicationPWords['supportValue']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-end me-5">
                                    <button type="button" class="btn btn-success mt-2 " id="btn1Card4teach"><?php echo $applicationPWords['btnBack']; ?></button>
                                    <button type="submit" class="btn btn-success mt-2"><?php echo $applicationPWords['button']; ?></button>
                                </div>
                            </div>
                        </form>
                        <?php
                            }elseif($usersInfo['userType'] == 2){
                        ?>
                        <form method="POST" action="forData/actionsOfData.php?type=personalDates2" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="mb-2"><?php echo $applicationPWords['information']; ?></label>
                            </div>
                            <div class="form-group mt-4" id="card1">
                                <div class="card-header text-center" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card1']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['nameLabel']; ?></label>
                                    <input type="text" class="form-control" placeholder="<?php echo $usersInfo['name']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['surnameLabel']; ?></label>
                                    <input type="text" class="form-control" placeholder="<?php echo $usersInfo['surname']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['sexLabel']; ?></label>
                                    <select  required name="sex" class="form-select">
                                        <option value="<?php echo $applicationPWords['sexVar1']; ?>"><?php echo $applicationPWords['sexVar1']; ?></option>
                                        <option value="<?php echo $applicationPWords['sexVar2']; ?>"><?php echo $applicationPWords['sexVar2']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['birthDateLabel']; ?></label>
                                    <input required name="birthDate" type="date" class="form-control" value="2000-01-01">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['placeOfBithrLabel']; ?></label>
                                    <input required name="PlaceOfBirth" type="text" class="form-control" placeholder="<?php echo $applicationPWords['placeOfBithrLabel']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['citizenshipLabel']; ?></label>
                                    <select  required name="citizenship" class="form-select">
                                    <?php
                                        $countries = findCountries($language);
                                        for($i=0; $i<count($countries); $i++){
                                            if($countries[$i]['status'] == 1){
                                                $countryId = $countries[$i]['country_id'];
                                                $countryName = $countries[$i]['country_name_'.$language];
                                                echo "<option value=$countryId>$countryName</option>";
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['nationalityLabel']; ?></label>
                                    <select  required name="nationality" class="form-select">
                                        <?php
                                            $nationalities = findNationality($language);
                                            for($i=0; $i<count($nationalities); $i++){
                                                if($nationalities[$i]['status'] == 1){
                                                    $nationalityId = $nationalities[$i]['nationality_id'];
                                                    $nationalityName = $nationalities[$i]['nationality_name_'.$language];
                                                    echo "<option value=$nationalityId>$nationalityName</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['passportNumberLabel']; ?></label>
                                    <input required name="passportNumber" type="text" class="form-control" placeholder="<?php echo $applicationPWords['passportNumberLabel']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['issueDateLabel']; ?></label>
                                    <input required name="issueDate" type="date" class="form-control" value="2017-01-01">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['expiryDateLabel']; ?></label>
                                    <input required name="expiryDate" type="date" class="form-control" value="2026-01-01">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['addressOfResidenceLabel']; ?></label>
                                    <input required name="addressOfResidence" type="text" class="form-control" placeholder="<?php echo $applicationPWords['addressOfResidenceLabel']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['copyOfPassportLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="choose" name="copy_of_passport" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selected"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group text-end me-5">
                                    <button type="button" class="btn btn-success mt-2 " id="btnCard1"><?php echo $applicationPWords['btnNext']; ?></button>
                                </div>
                            </div>
                            <div class="form-group mt-4" hidden id="card2">
                                <div class="card-header text-center" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card2']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['universityLabel2']; ?></label>
                                    <input required name="sendingUniversity" type="text" class="form-control" placeholder="<?php echo $applicationPWords['universityValue']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['facultyFrom']; ?></label>
                                    <input required name="facultyFrom" type="text" class="form-control" placeholder="<?php echo $applicationPWords['facultyFromValue']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['degreeLabel']; ?></label>
                                    <select  required name="academicDegree" class="form-select">
                                        <option value="<?php echo $applicationPWords['academDegVar1']; ?>"><?php echo $applicationPWords['academDegVar1']; ?></option>
                                        <option value="<?php echo $applicationPWords['academDegVar2']; ?>"><?php echo $applicationPWords['academDegVar2']; ?></option>
                                        <option value="<?php echo $applicationPWords['academDegVar3']; ?>"><?php echo $applicationPWords['academDegVar3']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['majorLabel']; ?></label>
                                    <input required name="major" type="text" class="form-control" placeholder="<?php echo $applicationPWords['majorValue']; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['nominationLetterLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="chooseNL" name="nomination_letter" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile5.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selectedNL"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['transcriptLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="chooseTranscript" name="transcript" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile6.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selectedTranscript"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group text-end me-5">
                                    <button type="button" class="btn btn-success mt-2 " id="btn1Card2"><?php echo $applicationPWords['btnBack']; ?></button>
                                    <button type="button" class="btn btn-success mt-2 " id="btn2Card2"><?php echo $applicationPWords['btnNext']; ?></button>
                                </div>
                            </div>
                            <div class="form-group mt-4" hidden id="card3">
                                <div class="card-header text-center" style="border: none; background-color: #d1e7dd;">
                                    <label class="mb-2"><?php echo $applicationPWords['card3']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['purposeLabel']; ?></label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="purpose" id="radio1" value="<?php echo $applicationPWords['purposeVar4']; ?>">
                                        <label class="form-check-label" for="radio1"><?php echo $applicationPWords['purposeVar4']; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="purpose" id="radio2" value="<?php echo $applicationPWords['purposeVar5']; ?>">
                                        <label class="form-check-label" for="radio2"><?php echo $applicationPWords['purposeVar5']; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="purpose" id="radio3">
                                        <label class="form-check-label" for="radio3"><?php echo $applicationPWords['purposeVar3']; ?></label>
                                        
                                        <div id="forWrite" hidden>
                                        <input type="text" name="radio3_data"class="form-control" for="radio3" placeholder="<?php echo $applicationPWords['purposeVar6Value']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['mobilityProgramLabel']; ?></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mobilityProgram" id="radio1MP" value="<?php echo $applicationPWords['mobilityProgramVar1']; ?>">
                                        <label class="form-check-label" for="radio1MP"><?php echo $applicationPWords['mobilityProgramVar1']; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mobilityProgram" id="radio2MP" value="<?php echo $applicationPWords['mobilityProgramVar2']; ?>">
                                        <label class="form-check-label" for="radio2MP"><?php echo $applicationPWords['mobilityProgramVar2']; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mobilityProgram" id="radio3MP" value="<?php echo $applicationPWords['mobilityProgramVar3']; ?>">
                                        <label class="form-check-label" for="radio3MP"><?php echo $applicationPWords['mobilityProgramVar3']; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mobilityProgram" id="radio4MP" value="<?php echo $applicationPWords['mobilityProgramVar4']; ?>">
                                        <label class="form-check-label" for="radio4MP"><?php echo $applicationPWords['mobilityProgramVar4']; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mobilityProgram" id="radio5MP" value="<?php echo $applicationPWords['mobilityProgramVar5']; ?>">
                                        <label class="form-check-label" for="radio5MP"><?php echo $applicationPWords['mobilityProgramVar5']; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mobilityProgram" id="radio6MP" value="<?php echo $applicationPWords['mobilityProgramVar6']; ?>">
                                        <label class="form-check-label" for="radio6MP"><?php echo $applicationPWords['mobilityProgramVar6']; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mobilityProgram" id="radio7MP">
                                        <label class="form-check-label" for="radio7MP"><?php echo $applicationPWords['purposeVar3']; ?></label>
                                        
                                        <div id="forWriteMP" hidden>
                                        <input type="text" name="radio7_data" class="form-control" for="radio7MP">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['facultyLabel']; ?></label>
                                    <select  required name="faculty" class="form-select">
                                        <?php 
                                            $faculties = findFaculties($language);
                                            for($i=0; $i<count($faculties); $i++){
                                                $facultyId = $faculties[$i]['faculty_id'];
                                                $facultyName = $faculties[$i]['faculty_name_'.$language];
                                                echo "<option value=$facultyId>$facultyName</option>";
                                                } 
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['agreementLabel']; ?></label>
                                    <div>
                                        <input type="file" class="form-control" id="chooseAgreement" name="agreement" hidden accept="application/pdf">
                                        <input type="button" class="btn btn-outline-secondary" onClick="getFile7.simulate()" value="<?php echo $applicationPWords['btnForFile']; ?>">
                                        <label id="selectedAgreement"><?php echo $applicationPWords['infForFile']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['mobilityLabel']; ?></label>
                                    <select  required name="mobility" class="form-select">
                                        <option value="<?php echo $applicationPWords['mobilityVar1']; ?>"><?php echo $applicationPWords['mobilityVar1']; ?></option>
                                        <option value="<?php echo $applicationPWords['mobilityVar2']; ?>"><?php echo $applicationPWords['mobilityVar2']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['periodLabel']; ?></label>
                                    <br><label><?php echo $applicationPWords['periodVar1']; ?></label>
                                        <input required name="periodFrom" type="date" class="form-control" value="2021-01-01">
                                        <label><?php echo $applicationPWords['periodVar2']; ?></label>
                                        <input required name="periodTo" type="date" class="form-control" value="2022-01-01">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['visaSupportLabel']; ?></label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visaSupport" id="radio2_1" >
                                        <label class="form-check-label" for="radio2_1"><?php echo $applicationPWords['supportVar1']; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visaSupport" id="radio2_2" value="<?php echo $applicationPWords['supportVar2']; ?>">
                                        <label class="form-check-label" for="radio2_2"><?php echo $applicationPWords['supportVar2']; ?></label>
                                        
                                        <div id="forVisaSupport" hidden>
                                        <input type="text" name="radio2_1_data" class="form-control" for="radio2_1" placeholder="<?php echo $applicationPWords['supportValue']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $applicationPWords['dormitoryLabel']; ?></label>
                                    <select  required name="dormitory" class="form-select">
                                        <option value="<?php echo $applicationPWords['supportVar1']; ?>"><?php echo $applicationPWords['supportVar1']; ?></option>
                                        <option value="<?php echo $applicationPWords['supportVar2']; ?>"><?php echo $applicationPWords['supportVar2']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group text-end mt-3">
                                    <button type="button" class="btn btn-success mt-2 " id="btn1Card3"><?php echo $applicationPWords['btnBack']; ?></button>
                                    <button type="submit" class="btn btn-success mt-2"><?php echo $applicationPWords['button']; ?></button>
                                </div>
                            </div>
                        </form>
                        <?php
                            }
                        ?>
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
        document.getElementById("radio3").addEventListener("click", function() {
            document.getElementById("forWrite").hidden = false;
            });
        document.getElementById("radio1").addEventListener("click", function() {
            document.getElementById("forWrite").hidden = true;
            });
        document.getElementById("radio2").addEventListener("click", function() {
            document.getElementById("forWrite").hidden = true;
            });
        document.getElementById("radio2_1").addEventListener("click", function() {
            document.getElementById("forVisaSupport").hidden = false;
            });
        document.getElementById("radio2_2").addEventListener("click", function() {
            document.getElementById("forVisaSupport").hidden = true;
            });
        
        var getFile = new selectFile;
        getFile.targets('choose','selected');
    </script>
    <?php if($usersInfo['userType'] == 1){ ?>
    <script>
        document.getElementById("btnCard1teach").addEventListener("click", function() {
            document.getElementById("card2teach").hidden = false;
            });
        document.getElementById("btnCard1teach").addEventListener("click", function() {
            document.getElementById("card1teach").hidden = true;
            });
        document.getElementById("btn2Card2teach").addEventListener("click", function() {
            document.getElementById("card3teach").hidden = false;
            });
        document.getElementById("btn2Card2teach").addEventListener("click", function() {
            document.getElementById("card2teach").hidden = true;
            });
        document.getElementById("btn1Card2teach").addEventListener("click", function() {
            document.getElementById("card1teach").hidden = false;
            });
        document.getElementById("btn1Card2teach").addEventListener("click", function() {
            document.getElementById("card2teach").hidden = true;
            });
        document.getElementById("btn2Card3teach").addEventListener("click", function() {
            document.getElementById("card4teach").hidden = false;
            });
        document.getElementById("btn2Card3teach").addEventListener("click", function() {
            document.getElementById("card3teach").hidden = true;
            });
        document.getElementById("btn1Card3teach").addEventListener("click", function() {
            document.getElementById("card2teach").hidden = false;
            });
        document.getElementById("btn1Card3teach").addEventListener("click", function() {
            document.getElementById("card3teach").hidden = true;
            });
        document.getElementById("btn1Card4teach").addEventListener("click", function() {
            document.getElementById("card3teach").hidden = false;
            });
        document.getElementById("btn1Card4teach").addEventListener("click", function() {
            document.getElementById("card4teach").hidden = true;
            });
        var getFile1 = new selectFile1;
        getFile1.targets('chooseCoE','selectedCoE');

        var getFile2 = new selectFile2;
        getFile2.targets('chooseED','selectedED');

        var getFile3 = new selectFile3;
        getFile3.targets('chooseCV','selectedCV');

        var getFile4 = new selectFile4;
        getFile4.targets('choosePubl','selectedPubl');
    </script>
    <?php }elseif($usersInfo['userType'] == 2){ ?>
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
        document.getElementById("btnCard1").addEventListener("click", function() {
            document.getElementById("card2").hidden = false;
            });
        document.getElementById("btnCard1").addEventListener("click", function() {
            document.getElementById("card1").hidden = true;
            });
        document.getElementById("btn1Card2").addEventListener("click", function() {
            document.getElementById("card1").hidden = false;
            });
        document.getElementById("btn1Card2").addEventListener("click", function() {
            document.getElementById("card2").hidden = true;
            });
        document.getElementById("btn2Card2").addEventListener("click", function() {
            document.getElementById("card3").hidden = false;
            });
        document.getElementById("btn2Card2").addEventListener("click", function() {
            document.getElementById("card2").hidden = true;
            });
        document.getElementById("btn1Card3").addEventListener("click", function() {
            document.getElementById("card3").hidden = true;
            });
        document.getElementById("btn1Card3").addEventListener("click", function() {
            document.getElementById("card2").hidden = false;
            });
            var getFile5 = new selectFile5;
        getFile5.targets('chooseNL','selectedNL');

        var getFile6 = new selectFile6;
        getFile6.targets('chooseTranscript','selectedTranscript');

        var getFile7 = new selectFile7;
        getFile7.targets('chooseAgreement','selectedAgreement');
    </script>
    <?php } ?>
</body>
</html>
<?php
        }
    }else{
        header('Location:auth.php?error=downloadAuthErr');
    }
?>