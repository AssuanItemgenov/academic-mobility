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
            //$applicationStatus = true;
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
    <title><?php echo $preSendPWords['title'];?></title>
</head>
<body>
    <?php
        require_once "nav.php";
    ?>
    <div class="container mb-5">
        <div class="row justify-content-center pt-5">
            <div class="col-lg-9">
                <div class="form-group mt-2 mb-4 text-center">
                    <h5 class="card-title"><?php echo $preSendPWords['information'];?></h5>
                </div>
                <?php
                    if(isset($_GET['error'])){
                        if($_GET['error'] == 'haveDataErr'){
                            $message = $preSendPWords['haveDataErr'];
                            echo "<label class='text-warning'>$message</label>";
                        }elseif($_GET['error'] == 'upDataErr'){
                            $message = $preSendPWords['upDataErr'];
                            echo "<label class='text-warning'>$message</label>";
                        }elseif($_GET['error'] == 'upFilesErr'){
                            $message = $preSendPWords['upFilesErr'];
                            echo "<label class='text-warning'>$message</label>";
                        }elseif($_GET['error'] == 'notFoud'){
                            $message = $preSendPWords['notFoud'];
                            echo "<label class='text-warning'>$message</label>";
                        }elseif($_GET['error'] == 'dataSent'){
                            $message = $preSendPWords['dataSent'];
                            echo "<label class='text-warning'>$message</label>";
                        }elseif($_GET['error'] == 'fileNotFound'){
                            $message = $moreDataPWOrds['fileNotFound'];
                            echo "<label class='text-warning'>$message</label>";
                        }
                    }
                ?>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row" class="ml-5 table-success text-center" colspan="2"><?php echo $applicationPWords['card1']; ?></th>
                        </tr>
                        <tr>
                            <th scope="row" class="ml-5"><?php echo $applicationPWords['nameLabel'];?></th>
                            <td><?php echo $usersInfo['name'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['surnameLabel'];?></th>
                            <td><?php echo $usersInfo['surname'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['sexLabel'];?></th>
                            <td><?php echo $data_of_user['sex'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['placeOfBithrLabel'];?></th>
                            <td><?php echo $data_of_user['place_of_birth'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['birthDateLabel'];?></th>
                            <td><?php echo $data_of_user['birth_date'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['citizenshipLabel'];?></th>
                            <td>
                                <?php
                                    $countries = findCountries($language);
                                    for($i=0; $i<count($countries); $i++){
                                        if($countries[$i]['country_id'] == $data_of_user['country_id']){
                                            if($countries[$i]['status'] == 1){    
                                                echo $countries[$i]['country_name_'.$language];
                                            }
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['nationalityLabel'];?></th>
                            <td>   
                                <?php
                                    $nationalities = findNationality($language);
                                    for($i=0; $i<count($nationalities); $i++){
                                        if($nationalities[$i]['nationality_id'] == $data_of_user['nationality_id']){
                                            if($nationalities[$i]['status'] == 1){
                                                echo $nationalities[$i]['nationality_name_'.$language];
                                            }
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['passportNumberLabel'];?></th>
                            <td><?php echo $data_of_user['passport_number'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['issueDateLabel'];?></th>
                            <td><?php echo $data_of_user['issue_date_of_passport'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['expiryDateLabel'];?></th>
                            <td><?php echo $data_of_user['expiry_date_of_passport'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['addressOfResidenceLabel'];?></th>
                            <td><?php echo $data_of_user['address_of_residence'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['passportLabel'];?></th>
                            <td>
                                <form action="forData/actionsOfData.php?type=downloadUsersFile&file=pass" method="POST" style="margin: 0px;">
                                    <?php
                                        for($i = 0; $i < count($files_of_user); $i++){
                                            if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "copy_of_passport"){
                                                echo $files_of_user[$i]['file_name'];
                                            }
                                        }
                                    ?>
                                    <button type="submit" class="btn btn btn-outline-success pt-0 pb-1" style="border:0;" id="forPassport"><?php echo $moreDataPWOrds['btn'];?></button>
                                </form>
                            </td>
                        </tr>
                        <?php if($usersInfo['userType']==1){ ?>
                        <tr>
                            <th scope="row" class="ml-5 table-success text-center" colspan="2"><?php echo $applicationPWords['card2']; ?></th>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['universityLabel1'];?></th>
                            <td><?php echo $data_of_user['university'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['certificateOfEmploymentLabel'];?></th>
                            <td>
                                <form action="forData/actionsOfData.php?type=downloadUsersFile&file=cert" method="POST">
                                    <?php
                                        for($i = 0; $i < count($files_of_user); $i++){
                                            if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "certificate_of_employment"){
                                                echo $files_of_user[$i]['file_name'];
                                            }
                                        }
                                    ?>
                                    <button type="submit" class="btn btn btn-outline-success pt-0 pb-1" style="border:0;" id="forEmployment"><?php echo $moreDataPWOrds['btn'];?></button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="ml-5 table-success text-center" colspan="2"><?php echo $applicationPWords['card4']; ?></th>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['academicDegreeLabel'];?></th>
                            <td><?php echo $data_of_user['academicDegree'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['educationDocumentLabel'];?></th>
                            <td>
                                <form action="forData/actionsOfData.php?type=downloadUsersFile&file=educ" method="POST">
                                    <?php
                                        for($i = 0; $i < count($files_of_user); $i++){
                                            if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "education_document"){
                                                echo $files_of_user[$i]['file_name'];
                                            }
                                        }
                                    ?>
                                    <button type="submit" class="btn btn btn-outline-success pt-0 pb-1" style="border:0;" id="for_education_document"><?php echo $moreDataPWOrds['btn'];?></button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['CVLabel'];?></th>
                            <td>
                                <form action="forData/actionsOfData.php?type=downloadUsersFile&file=CV" method="POST">
                                    <?php
                                        for($i = 0; $i < count($files_of_user); $i++){
                                            if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "CV"){
                                                echo $files_of_user[$i]['file_name'];
                                            }
                                        }
                                    ?>
                                    <button type="submit" class="btn btn btn-outline-success pt-0 pb-1" style="border:0;" id="forCV"><?php echo $moreDataPWOrds['btn'];?></button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['publicationsLabel'];?></th>
                            <td>
                                <form action="forData/actionsOfData.php?type=downloadUsersFile&file=publ" method="POST">
                                    <?php
                                        for($i = 0; $i < count($files_of_user); $i++){
                                            if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "publications"){
                                                echo $files_of_user[$i]['file_name'];
                                            }
                                        }
                                    ?>
                                    <button type="submit" class="btn btn btn-outline-success pt-0 pb-1" style="border:0;" id="forPublications"><?php echo $moreDataPWOrds['btn'];?></button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                        }
                        if($usersInfo['userType']==2){ ?>
                        <tr>
                            <th scope="row" class="ml-5 table-success text-center" colspan="2"><?php echo $applicationPWords['card2']; ?></th>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['universityLabel2'];?></th>
                            <td><?php echo $data_of_user['sending_university'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['facultyFrom'];?></th>
                            <td><?php echo $data_of_user['faculty_from'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['degreeLabel'];?></th>
                            <td><?php echo $data_of_user['academic_degree'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['majorLabel'];?></th>
                            <td><?php echo $data_of_user['major'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['nominationLetterLabel'];?></th>
                            <td>
                                <form action="forData/actionsOfData.php?type=downloadUsersFile&file=nom_let" method="POST" style="margin: 0px;">
                                    <?php
                                        for($i = 0; $i < count($files_of_user); $i++){
                                            if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "nomination_letter"){
                                                echo $files_of_user[$i]['file_name'];
                                            }
                                        }
                                    ?>
                                    <button type="submit" class="btn btn btn-outline-success pt-0 pb-1" style="border:0;" id="for_education_document"><?php echo $moreDataPWOrds['btn'];?></button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['transcriptLabel'];?></th>
                            <td>
                                <form action="forData/actionsOfData.php?type=downloadUsersFile&file=transcript" method="POST" style="margin: 0px;">
                                    <?php
                                        for($i = 0; $i < count($files_of_user); $i++){
                                            if(isset($files_of_user[$i]['name_of_doc']) && $files_of_user[$i]['name_of_doc'] == "transcript"){
                                                echo $files_of_user[$i]['file_name'];
                                            }
                                        }
                                    ?>
                                    <button type="submit" class="btn btn btn-outline-success pt-0 pb-1" style="border:0;" id="for_education_document"><?php echo $moreDataPWOrds['btn'];?></button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th scope="row" class="ml-5 table-success text-center" colspan="2"><?php echo $applicationPWords['card3']; ?></th>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['purposeLabel'];?></th>
                            <td><?php echo $data_of_user['purpose'];?></td>
                        </tr>
                        <?php if($usersInfo['userType']==2){ ?>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['mobilityProgramLabel'];?></th>
                            <td><?php echo $data_of_user['mobility_program'];?></td>
                        </tr> 
                        <?php } ?>
                        <tr>
                            <th scope="row"><?php echo $requestsPWOrds['facultyLabel'];?></th>
                            <td>
                                <?php
                                    $faculties = findFaculties($language);
                                    for($i=0; $i<count($faculties); $i++){
                                        if($faculties[$i]['faculty_id'] == $data_of_user['faculty_to_id']){
                                            if($faculties[$i]['status'] == 1){
                                                echo $faculties[$i]['faculty_name_'.$language];
                                            }
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php
                            if($usersInfo['userType']==2){
                                for($i = 0; $i < count($files_of_user); $i++){
                                    if($files_of_user[$i]['name_of_doc'] == "agreement"){
                        ?>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['agreementLabel'];?></th>
                            <td>
                                <form action="forData/actionsOfData.php?type=downloadUsersFile&file=agr" method="POST" style="margin: 0px;">
                                    <?php echo $files_of_user[$i]['file_name']; ?>
                                    <button type="submit" class="btn btn btn-outline-success pt-0 pb-1" style="border:0;" id="for_education_document"><?php echo $moreDataPWOrds['btn'];?></button>
                                </form>
                            </td>
                        </tr>
                        <?php }}} ?>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['mobilityLabel'];?></th>
                            <td><?php echo $data_of_user['mobility_form'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $applicationPWords['periodLabel'];?></th>
                            <td><?php echo $applicationPWords['periodVar1']." ".$data_of_user['period_from']." ".$applicationPWords['periodVar2']." ".$data_of_user['period_to'];?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $moreDataPWOrds['visaSupportLabel'];?></th>
                            <td><?php echo $data_of_user['visa_support'];?></td>
                        </tr>
                        <?php if($usersInfo['userType']==2){ ?>
                        <tr>
                            <th scope="row"><?php echo $dataPWords['dormitoryLabel'];?></th>
                            <td><?php 
                                if($data_of_user['dormitory_need'] == 'Да' || 
                                    $data_of_user['dormitory_need'] == 'Yes' || 
                                    $data_of_user['dormitory_need'] == 'Иә'){
                                    echo $applicationPWords['supportVar1'];
                                }else{
                                    echo $applicationPWords['supportVar2'];
                                }?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="form-group mt-2  text-center">
                    <label class="text-primary"><?php echo $preSendPWords['warning']; ?></label>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <a type="button" class="btn btn-outline-success mt-4" href="resultOfData.php" <?php if($data_of_user['data_status'] == 1){ echo 'style="pointer-events: none; cursor: default;"'; } ?>><?php echo $preSendPWords['buttonChange'];?></a>
                    </div>
                    <div class="col-sm-6 text-center">
                        <form action="forData/actionsOfData.php?type=change_s" method="POST">
                            <button type="button" class="btn btn-outline-success mt-4" data-bs-toggle="modal" data-bs-target="#sendModal" 
                                <?php if($data_of_user['data_status'] == 1){ echo 'style="pointer-events: none; cursor: default;"'; } ?>
                            ><?php echo $preSendPWords['buttonSend'];?></button>
                            <div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-check">
                                            <input class="form-check-input form__input" type="checkbox" value="" id="checkbox" required>
                                            <?php echo $preSendPWords['modalWarning'];?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-outline-success" id="btn"><?php echo $preSendPWords['buttonConfirm'];?></button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php
        }else{
            header('Location:personalDataList.php?error=notHaveDataErr');
       }
    }else{
        header('Location:authAndREg.php?error=downloadAuthErr');
    }
?>