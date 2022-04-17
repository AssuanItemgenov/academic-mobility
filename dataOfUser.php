<?php
session_start();
require_once "user.php";
if(ONLINE){
    require_once "db.php";
    require_once "forUsers/usersClass.php";
    $user = new User($_SESSION);
    $usersInfo = $user->findUser();
    if($usersInfo['userType'] == 3){
        require_once "forData/dataClass.php";
        $requestedUserId = isset($_GET['id']) ? $_GET['id'] : null;
        $requestedUser = new User('');
        $requestedUserInfo = $requestedUser->findUserById($requestedUserId);
        $data_and_files_of_requestedUser = new Data_and_File($requestedUserId, '', '');
        if($requestedUserInfo['userType']==1){
            $indicator = true;
            $data_of_requestedUser = $data_and_files_of_requestedUser->findDataOfTeacher();
        }elseif($requestedUserInfo['userType']==2){
            $indicator = false;
            $data_of_requestedUser = $data_and_files_of_requestedUser->findDataOfStudent();
        }
        $files_of_requestedUser = $data_and_files_of_requestedUser->find_files_of_user();
        if(($data_of_requestedUser != null) && ($files_of_requestedUser != null)){
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
    <title><?php echo $moreDataPWOrds['title']; ?></title>
</head>
<body>
    <?php
    require_once "nav.php";
    ?>
<div class="container">
	<div class="row justify-content-center pt-5">
		<div class="col-lg-8">
            <div class="card shadow mb-5">
                <div class="card-body">
                
                        <?php
                            $message = '';
                            if(isset($_GET['error'])){
                                if($_GET['error'] == 'fileNotFound'){
                                    $message = $moreDataPWOrds['fileNotFound'];
                                    echo "<label class='text-warning'>$message</label>";
                                }elseif($_GET['error'] == 'notFoud'){
                                    $message = $preSendPWords['notFoud'];
                                    echo "<label class='text-warning'>$message</label>";
                                }
                            } 
                        ?>

                        <div class="form-group mt-2">
                            <label class=""><?php echo $moreDataPWOrds['infor'].' '.$requestedUserInfo['name'].' '.$requestedUserInfo['surname'];?></label>
                        </div>
                        <div class="form-group text-end">
                            <form action="forData/actionsOfData.php?type=downloadAllFiles&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <button type="submit" class="btn btn btn-outline-success" id="for_education_document"><h5 class="m-0"><?php echo $moreDataPWOrds['btnDownloadAll'];?></h5></button>
                            </form>
                        </div>
                        <div class="card-header text-center mt-2" style="border: none; background-color: #d1e7dd; border-radius: .25rem;">
                            <label class="mb-2"><?php echo $applicationPWords['card1']; ?></label>
                        </div>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['nameLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $requestedUserInfo['name'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['surnameLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $requestedUserInfo['surname'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li">Email</li>
                            <li class="list-group-item second-li"><?php echo $requestedUserInfo['email'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $requestsPWOrds['regDateLabel']; ?></li>
                            <li class="list-group-item second-li"><?php echo $requestedUserInfo['createDate'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['sexLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['sex'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['placeOfBithrLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['place_of_birth'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['birthDateLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['birth_date'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['citizenshipLabel'];?></li>
                            <li class="list-group-item second-li">
                                <?php
                                    $countries = findCountries($language);
                                    for($i=0; $i<count($countries); $i++){
                                        if($countries[$i]['country_id'] == $data_of_requestedUser['country_id']){
                                            if($countries[$i]['status'] == 1){    
                                                echo $countries[$i]['country_name_'.$language];
                                            }
                                        }
                                    }
                                ?>
                            </li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['nationalityLabel'];?></li>
                            <li class="list-group-item second-li">
                                <?php
                                    $nationalities = findNationality($language);
                                    for($i=0; $i<count($nationalities); $i++){
                                        if($nationalities[$i]['nationality_id'] == $data_of_requestedUser['nationality_id']){
                                            if($nationalities[$i]['status'] == 1){
                                                echo $nationalities[$i]['nationality_name_'.$language];
                                            }
                                        }
                                    }
                                ?>
                            </li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['passportNumberLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['passport_number'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['issueDateLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['issue_date_of_passport'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['expiryDateLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['expiry_date_of_passport'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['addressOfResidenceLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['address_of_residence'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['passportLabel'];?></li>
                            <li class="list-group-item second-li">
                            <form action="forData/actionsOfData.php?type=downloadFile&file=pass&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <?php
                            for($i = 0; $i < count($files_of_requestedUser); $i++){
                                if(isset($files_of_requestedUser[$i]['name_of_doc']) && $files_of_requestedUser[$i]['name_of_doc'] == "copy_of_passport"){
                                    $fileName = $files_of_requestedUser[$i]['file_name'];
                                    echo $fileName;
                                }
                            }
                            ?>
                            <button type="submit" class="btn btn btn-outline-success" style="border:0;" id="forPassport"><?php echo $moreDataPWOrds['btn'];?></button>
                            </form>
                            </li>
                        </ul>
                        <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd; border-radius: .25rem;">
                            <label class="mb-2"><?php echo $applicationPWords['card2']; ?></label>
                        </div>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php if($indicator){echo $applicationPWords['universityLabel1'];}else{echo $applicationPWords['universityLabel2'];}?></li>
                            <li class="list-group-item second-li"><?php if($indicator){echo $data_of_requestedUser['university'];}else{echo $data_of_requestedUser['sending_university'];}?></li>
                        </ul>
                        <?php if($indicator){ ?>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['certificateOfEmploymentLabel'];?></li>
                            <li class="list-group-item second-li">
                            <form action="forData/actionsOfData.php?type=downloadFile&file=cert&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <?php
                            for($i = 0; $i < count($files_of_requestedUser); $i++){
                                if(isset($files_of_requestedUser[$i]['name_of_doc']) && $files_of_requestedUser[$i]['name_of_doc'] == "certificate_of_employment"){
                                    $fileName = $files_of_requestedUser[$i]['file_name'];
                                    echo $fileName;
                                }
                            }
                            ?>
                            <button type="submit" class="btn btn btn-outline-success" style="border:0;" id="forEmployment"><?php echo $moreDataPWOrds['btn'];?></button>
                            </form>    
                            </li>
                        </ul>
                        <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd; border-radius: .25rem;">
                            <label class="mb-2"><?php echo $applicationPWords['card4']; ?></label>
                        </div>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['academicDegreeLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['academicDegree'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['educationDocumentLabel'];?></li>
                            <li class="list-group-item second-li">
                            <form action="forData/actionsOfData.php?type=downloadFile&file=educ&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <?php
                            for($i = 0; $i < count($files_of_requestedUser); $i++){
                                if(isset($files_of_requestedUser[$i]['name_of_doc']) && $files_of_requestedUser[$i]['name_of_doc'] == "education_document"){
                                    $fileName = $files_of_requestedUser[$i]['file_name'];
                                    echo $fileName;
                                }
                            }
                            ?>
                            <button type="submit" class="btn btn btn-outline-success" style="border:0;" id="for_education_document"><?php echo $moreDataPWOrds['btn'];?></button>
                            </form>    
                            </li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['CVLabel'];?></li>
                            <li class="list-group-item second-li">
                            <form action="forData/actionsOfData.php?type=downloadFile&file=CV&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <?php
                            for($i = 0; $i < count($files_of_requestedUser); $i++){
                                if(isset($files_of_requestedUser[$i]['name_of_doc']) && $files_of_requestedUser[$i]['name_of_doc'] == "CV"){
                                    $fileName = $files_of_requestedUser[$i]['file_name'];
                                    echo $fileName;
                                }
                            }
                            ?>
                            <button type="submit" class="btn btn btn-outline-success" style="border:0;" id="forCV"><?php echo $moreDataPWOrds['btn'];?></button>
                            </form> 
                            </li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['publicationsLabel'];?></li>
                            <li class="list-group-item second-li">
                            <form action="forData/actionsOfData.php?type=downloadFile&file=publ&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <?php
                            for($i = 0; $i < count($files_of_requestedUser); $i++){
                                if(isset($files_of_requestedUser[$i]['name_of_doc']) && $files_of_requestedUser[$i]['name_of_doc'] == "publications"){
                                    $fileName = $files_of_requestedUser[$i]['file_name'];
                                    echo $fileName;
                                }
                            }
                            ?>
                            <button type="submit" class="btn btn btn-outline-success" style="border:0;" id="forPublications"><?php echo $moreDataPWOrds['btn'];?></button>
                            </form> 
                            </li>
                        </ul>
                        <?php }else{ ?>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['facultyFrom'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['faculty_from'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['degreeLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['academic_degree'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['majorLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['major'];?></li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['nominationLetterLabel'];?></li>
                            <li class="list-group-item second-li">
                            <form action="forData/actionsOfData.php?type=downloadFile&file=nom_let&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <?php
                            for($i = 0; $i < count($files_of_requestedUser); $i++){
                                if(isset($files_of_requestedUser[$i]['name_of_doc']) && $files_of_requestedUser[$i]['name_of_doc'] == "nomination_letter"){
                                    $fileName = $files_of_requestedUser[$i]['file_name'];
                                    echo $fileName;
                                }
                            }
                            ?>
                            <button type="submit" class="btn btn btn-outline-success" style="border:0;" id="forNominationLetter"><?php echo $moreDataPWOrds['btn'];?></button>
                            </form> 
                            </li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['transcriptLabel'];?></li>
                            <li class="list-group-item second-li">
                            <form action="forData/actionsOfData.php?type=downloadFile&file=transcript&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <?php
                            for($i = 0; $i < count($files_of_requestedUser); $i++){
                                if(isset($files_of_requestedUser[$i]['name_of_doc']) && $files_of_requestedUser[$i]['name_of_doc'] == "transcript"){
                                    $fileName = $files_of_requestedUser[$i]['file_name'];
                                    echo $fileName;
                                }
                            }
                            ?>
                            <button type="submit" class="btn btn btn-outline-success" style="border:0;" id="forTranscript"><?php echo $moreDataPWOrds['btn'];?></button>
                            </form> 
                            </li>
                        </ul>
                        <?php } ?>
                        <div class="card-header text-center mt-4" style="border: none; background-color: #d1e7dd; border-radius: .25rem;">
                            <label class="mb-2"><?php echo $applicationPWords['card3']; ?></label>
                        </div>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['purposeLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['purpose'];?></li>
                        </ul>
                        <?php if(!$indicator){ ?>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['mobilityProgramLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['mobility_program'];?></li>
                        </ul>
                        <?php } ?>  
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $requestsPWOrds['facultyLabel'];?></li>
                            <li class="list-group-item second-li">
                                <?php
                                    $faculties = findFaculties($language);
                                    for($i=0; $i<count($faculties); $i++){
                                        if($faculties[$i]['faculty_id'] == $data_of_requestedUser['faculty_to_id']){
                                            if($faculties[$i]['status'] == 1){
                                                echo $faculties[$i]['faculty_name_'.$language];
                                            }
                                        }
                                    }
                                ?>
                            </li>  
                        </ul>
                        <?php if(!$indicator){ ?>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['agreementLabel'];?></li>
                            <li class="list-group-item second-li">
                            <form action="forData/actionsOfData.php?type=downloadFile&file=agr&userId=<?php echo $requestedUserId; ?>" method="POST" style="margin:0;">
                            <?php
                            for($i = 0; $i < count($files_of_requestedUser); $i++){
                                if(isset($files_of_requestedUser[$i]['name_of_doc']) && $files_of_requestedUser[$i]['name_of_doc'] == "agreement"){
                                    $fileName = $files_of_requestedUser[$i]['file_name'];
                                    echo $fileName;
                                }
                            }
                            ?>
                            <button type="submit" class="btn btn btn-outline-success" style="border:0;" id="forAgreement"><?php echo $moreDataPWOrds['btn'];?></button>
                            </form> 
                            </li>
                        </ul>
                        <?php } ?>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['mobilityLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['mobility_form'];?></li> 
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $applicationPWords['periodLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $applicationPWords['periodVar1']." ".$data_of_requestedUser['period_from']." ".$applicationPWords['periodVar2']." ".$data_of_requestedUser['period_to'];?></li> 
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $moreDataPWOrds['visaSupportLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['visa_support'];?></li> 
                        </ul>
                        <?php if(!$indicator){ ?>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item first-li"><?php echo $dataPWords['dormitoryLabel'];?></li>
                            <li class="list-group-item second-li"><?php echo $data_of_requestedUser['dormitory_need'];?></li>
                        </ul>
                        <?php } ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<style>
    .first-li{
        width: 40%;
    }

    .second-li{
        width: 60%;
    }
</style>
</body>
</html>
<?php
        }
    }
}else{
    header('Location:auth.php?error=downloadAuthErr');
}
?>