<?php
session_start();
require_once "../db.php";
require_once "../user.php";
require_once "dataClass.php";
require_once "../forUsers/usersClass.php";
require_once "functionsOfData.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_COOKIE['lang'])){
    $language = $_COOKIE['lang'];
    if($_COOKIE['lang'] == 'kz'){
        require_once '../lang/kz.php';
    }elseif($_COOKIE['lang'] == 'ru'){
        require_once '../lang/ru.php';
    }elseif($_COOKIE['lang'] == 'en'){
        require_once '../lang/en.php';
    }
}else{
    $language = 'en';
    require_once '../lang/en.php';
}

$location = '../welcome.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_GET['type'])){
            switch($_GET['type']){
                case 'personalDates1': //teacher
                    if(isset($_POST['sex']) && 
                    isset($_POST['birthDate']) && 
                    isset($_POST['PlaceOfBirth']) && 
                    isset($_POST['citizenship']) && 
                    isset($_POST['nationality']) && 
                    isset($_POST['passportNumber']) && 
                    isset($_POST['issueDate']) && 
                    isset($_POST['expiryDate']) && 
                    isset($_POST['addressOfResidence']) && 
                    isset($_POST['university']) && 
                    isset($_POST['academicDegree']) && 
                    isset($_POST['purpose']) && 
                    isset($_POST['faculty']) && 
                    isset($_POST['mobility']) && 
                    isset($_POST['periodFrom']) && 
                    isset($_POST['periodTo']) && 
                    isset($_POST['visaSupport']) && 
                    ($_FILES['copy_of_passport']['error'] == 0) && 
                    ($_FILES['certificate_of_employment']['error'] == 0) && 
                    ($_FILES['education_document']['error'] == 0) && 
                    ($_FILES['CV']['error'] == 0) && 
                    ($_FILES['publications']['error'] == 0)){
                        $user_id = $_SESSION['id'];
                        $dataAndFile = new Data_and_File($user_id, $_POST,$_FILES);
                        $data_of_user = $dataAndFile->findDataOfTeacher();
                        $file_of_user = $dataAndFile->find_files_of_user();
                        if(($data_of_user != null) && ($file_of_user != null)){
                            $location = '../preSendData.php?error=haveDataErr';
                            }else{
                                $dataAndFile->status = 0;
                                $dataAndFile->dateOfdata = "-";
                                $dataAndFile->personalData();
                                $dataAndFile->add_files_data();
                                $dataAndFile->save_files_in_server();
                                $location = '../preSendData.php';
                            }
                    }else{
                        $location = '../personalDataList.php?error=fillAllerr';
                    }
                break;
                case 'personalDates2': //student
                    if(isset($_POST['sex']) && 
                    isset($_POST['birthDate']) && 
                    isset($_POST['PlaceOfBirth']) && 
                    isset($_POST['citizenship']) && 
                    isset($_POST['nationality']) && 
                    isset($_POST['passportNumber']) && 
                    isset($_POST['issueDate']) && 
                    isset($_POST['expiryDate']) && 
                    isset($_POST['addressOfResidence']) && 
                    isset($_POST['sendingUniversity']) && 
                    isset($_POST['facultyFrom']) && 
                    isset($_POST['academicDegree']) && 
                    isset($_POST['major']) && 
                    isset($_POST['purpose']) && 
                    isset($_POST['mobilityProgram']) && 
                    isset($_POST['faculty']) && 
                    isset($_POST['mobility']) && 
                    isset($_POST['periodFrom']) && 
                    isset($_POST['periodTo']) && 
                    isset($_POST['visaSupport']) && 
                    isset($_POST['dormitory']) && 
                    ($_FILES['copy_of_passport']['error'] == 0) && 
                    ($_FILES['nomination_letter']['error'] == 0) && 
                    ($_FILES['transcript']['error'] == 0) && 
                    ($_FILES['agreement']['error'] == 0)){
                        $user_id = $_SESSION['id'];
                        $dataAndFile = new Data_and_File($user_id, $_POST,$_FILES);
                        $data_of_user = $dataAndFile->findDataOfStudent();
                        $file_of_user = $dataAndFile->find_files_of_user();
                        if(($data_of_user != null) && ($file_of_user != null)){
                            $location = '../preSendData.php?error=haveDataErr';
                            }else{
                                $dataAndFile->status = 0;
                                $dataAndFile->dateOfdata = "-";
                                $dataAndFile->insertDataOfStudent();
                                $dataAndFile->add_files_data();
                                $dataAndFile->save_files_in_server();
                                $location = '../preSendData.php';
                            }
                    }else{
                        $location = '../personalDataList.php?error=fillAllerr';
                    }
                break;
                case 'updatePersonalDates':
                    $user = new User($_SESSION);
                    $user_info = $user->findUser();
                    if($user_info['userType']==1){
                        if(isset($_POST['sex']) && 
                        isset($_POST['birthDate']) && 
                        isset($_POST['PlaceOfBirth']) && 
                        isset($_POST['citizenship']) && 
                        isset($_POST['nationality']) && 
                        isset($_POST['passportNumber']) && 
                        isset($_POST['issueDate']) && 
                        isset($_POST['expiryDate']) && 
                        isset($_POST['addressOfResidence']) && 
                        isset($_POST['university']) && 
                        isset($_POST['academicDegree']) && 
                        isset($_POST['purpose']) && 
                        isset($_POST['faculty']) && 
                        isset($_POST['mobility']) && 
                        isset($_POST['periodFrom']) && 
                        isset($_POST['periodTo']) && 
                        isset($_POST['visaSupport'])){
                            $user_id = $_SESSION['id'];
                            $dataAndFile_forUp = new Data_and_File($user_id, $_POST, '');
                            print_r($_POST);
                            $data_of_user = $dataAndFile_forUp->findDataOfTeacher();
                            if($data_of_user != null){
                                $dataAndFile_forUp->upPersonalDataOfTeacher();
                                $location = '../preSendData.php?error=upDataErr';
                            }else{
                                $location = '../personalDataList.php?error=notHaveDataErr'; 
                            }      
                        }else{
                            $location = '../resultOfData.php?error=fillAllErr'; 
                        }
                    }elseif($user_info['userType']==2){
                        if(isset($_POST['sex']) && 
                        isset($_POST['birthDate']) && 
                        isset($_POST['PlaceOfBirth']) && 
                        isset($_POST['citizenship']) && 
                        isset($_POST['nationality']) && 
                        isset($_POST['passportNumber']) && 
                        isset($_POST['issueDate']) && 
                        isset($_POST['expiryDate']) && 
                        isset($_POST['addressOfResidence']) && 
                        isset($_POST['university']) && 
                        isset($_POST['facultyFrom']) && 
                        isset($_POST['academicDegree']) && 
                        isset($_POST['major']) && 
                        isset($_POST['purpose']) && 
                        isset($_POST['mobilityProgram']) && 
                        isset($_POST['faculty']) && 
                        isset($_POST['mobility']) && 
                        isset($_POST['periodFrom']) && 
                        isset($_POST['periodTo']) && 
                        isset($_POST['visaSupport']) && 
                        isset($_POST['dormitory'])){
                            $user_id = $_SESSION['id'];
                            $dataAndFile_forUp = new Data_and_File($user_id, $_POST, '');
                            $data_of_user = $dataAndFile_forUp->findDataOfStudent();
                            if($data_of_user != null){
                                print_r($dataAndFile_forUp);
                                $dataAndFile_forUp->upPersonalDataOfStudent();
                                $location = '../preSendData.php?error=upDataErr';
                            }else{
                                $location = '../personalDataList.php?error=notHaveDataErr'; 
                            }      
                        }else{
                            $location = '../resultOfData.php?error=fillAllErr'; 
                        }
                    }
                break;
                case 'updatePersonalFiles':
                    foreach($_FILES as $file_k => $file_v){
                        $name_of_doc = $file_k;
                        if($name_of_doc == 'copy_of_passport' && $file_v['error'] == 0){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $file_v['tmp_name']);
                            if($mime === 'application/pdf'){
                                $user_id = $_SESSION['id'];
                                $dataAndFile_forUp = new Data_and_File($user_id, '', $file_v);
                                $data_of_filesForDelete = $dataAndFile_forUp->find_files_of_user();
                                for($i=0; $i<count($data_of_filesForDelete); $i++){
                                    if($data_of_filesForDelete[$i]['name_of_doc'] == 'copy_of_passport'){
                                        if(file_exists('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name'])){
                                            unlink('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name']);
                                        }
                                    }
                                }
                                $arr = explode('.',$file_v['name']);
                                $ext = $arr[sizeof($arr)-1];
                                $fileName = "$name_of_doc.$ext";
                                $dataAndFile_forUp->up_files_data($fileName, $name_of_doc);
                                $dataAndFile_forUp->resave_files_in_server($fileName);
                            }  
                        }

                        if($name_of_doc == 'certificate_of_employment' && $file_v['error'] == 0){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $file_v['tmp_name']);
                            if($mime === 'application/pdf'){
                                $user_id = $_SESSION['id'];
                                $dataAndFile_forUp = new Data_and_File($user_id, '', $file_v);
                                $data_of_filesForDelete = $dataAndFile_forUp->find_files_of_user();
                                for($i=0; $i<count($data_of_filesForDelete); $i++){
                                    if($data_of_filesForDelete[$i]['name_of_doc'] == 'certificate_of_employment'){
                                        if(file_exists('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name'])){
                                            unlink('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name']);
                                        }
                                    }
                                }
                                $arr = explode('.',$file_v['name']);
                                $ext = $arr[sizeof($arr)-1];
                                $fileName = "$name_of_doc.$ext";
                                $dataAndFile_forUp->up_files_data($fileName, $name_of_doc);
                                $dataAndFile_forUp->resave_files_in_server($fileName);
                            }
                        }

                        if($name_of_doc == 'education_document' && $file_v['error'] == 0){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $file_v['tmp_name']);
                            if($mime === 'application/pdf'){
                                $user_id = $_SESSION['id'];
                                $dataAndFile_forUp = new Data_and_File($user_id, '', $file_v);
                                $data_of_filesForDelete = $dataAndFile_forUp->find_files_of_user();
                                for($i=0; $i<count($data_of_filesForDelete); $i++){
                                    if($data_of_filesForDelete[$i]['name_of_doc'] == 'education_document'){
                                        if(file_exists('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name'])){
                                            unlink('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name']);
                                        }
                                    }
                                }
                                $arr = explode('.',$file_v['name']);
                                $ext = $arr[sizeof($arr)-1];
                                $fileName = "$name_of_doc.$ext";
                                $dataAndFile_forUp->up_files_data($fileName, $name_of_doc);
                                $dataAndFile_forUp->resave_files_in_server($fileName);
                            }
                        }

                        if($name_of_doc == 'CV' && $file_v['error'] == 0){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $file_v['tmp_name']);
                            if($mime === 'application/pdf'){
                                $user_id = $_SESSION['id'];
                                $dataAndFile_forUp = new Data_and_File($user_id, '', $file_v);
                                $data_of_filesForDelete = $dataAndFile_forUp->find_files_of_user();
                                for($i=0; $i<count($data_of_filesForDelete); $i++){
                                    if($data_of_filesForDelete[$i]['name_of_doc'] == 'CV'){
                                        if(file_exists('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name'])){
                                            unlink('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name']);
                                        }
                                    }
                                }
                                $arr = explode('.',$file_v['name']);
                                $ext = $arr[sizeof($arr)-1];
                                $fileName = "$name_of_doc.$ext";
                                $dataAndFile_forUp->up_files_data($fileName, $name_of_doc);
                                $dataAndFile_forUp->resave_files_in_server($fileName);
                            }
                        }

                        if($name_of_doc == 'publications' && $file_v['error'] == 0){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $file_v['tmp_name']);
                            if($mime === 'application/pdf'){
                                $user_id = $_SESSION['id'];
                                $dataAndFile_forUp = new Data_and_File($user_id, '', $file_v);
                                $data_of_filesForDelete = $dataAndFile_forUp->find_files_of_user();
                                for($i=0; $i<count($data_of_filesForDelete); $i++){
                                    if($data_of_filesForDelete[$i]['name_of_doc'] == 'publications'){
                                        if(file_exists('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name'])){
                                            unlink('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name']);
                                        }
                                    }
                                }
                                $arr = explode('.',$file_v['name']);
                                $ext = $arr[sizeof($arr)-1];
                                $fileName = "$name_of_doc.$ext";
                                $dataAndFile_forUp->up_files_data($fileName, $name_of_doc);
                                $dataAndFile_forUp->resave_files_in_server($fileName);
                            } 
                        }

                        if($name_of_doc == 'nomination_letter' && $file_v['error'] == 0){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $file_v['tmp_name']);
                            if($mime === 'application/pdf'){
                                $user_id = $_SESSION['id'];
                                $dataAndFile_forUp = new Data_and_File($user_id, '', $file_v);
                                $data_of_filesForDelete = $dataAndFile_forUp->find_files_of_user();
                                for($i=0; $i<count($data_of_filesForDelete); $i++){
                                    if($data_of_filesForDelete[$i]['name_of_doc'] == 'nomination_letter'){
                                        if(file_exists('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name'])){
                                            unlink('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name']);
                                        }
                                    }
                                }
                                $arr = explode('.',$file_v['name']);
                                $ext = $arr[sizeof($arr)-1];
                                $fileName = "$name_of_doc.$ext";
                                $dataAndFile_forUp->up_files_data($fileName, $name_of_doc);
                                $dataAndFile_forUp->resave_files_in_server($fileName);
                            } 
                        }

                        if($name_of_doc == 'transcript' && $file_v['error'] == 0){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $file_v['tmp_name']);
                            if($mime === 'application/pdf'){
                                $user_id = $_SESSION['id'];
                                $dataAndFile_forUp = new Data_and_File($user_id, '', $file_v);
                                $data_of_filesForDelete = $dataAndFile_forUp->find_files_of_user();
                                for($i=0; $i<count($data_of_filesForDelete); $i++){
                                    if($data_of_filesForDelete[$i]['name_of_doc'] == 'transcript'){
                                        if(file_exists('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name'])){
                                            unlink('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name']);
                                        }
                                    }
                                }
                                $arr = explode('.',$file_v['name']);
                                $ext = $arr[sizeof($arr)-1];
                                $fileName = "$name_of_doc.$ext";
                                $dataAndFile_forUp->up_files_data($fileName, $name_of_doc);
                                $dataAndFile_forUp->resave_files_in_server($fileName);
                            } 
                        }

                        if($name_of_doc == 'agreement' && $file_v['error'] == 0){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $file_v['tmp_name']);
                            if($mime === 'application/pdf'){
                                $user_id = $_SESSION['id'];
                                $dataAndFile_forUp = new Data_and_File($user_id, '', $file_v);
                                $data_of_filesForDelete = $dataAndFile_forUp->find_files_of_user();
                                for($i=0; $i<count($data_of_filesForDelete); $i++){
                                    if($data_of_filesForDelete[$i]['name_of_doc'] == 'agreement'){
                                        if(file_exists('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name'])){
                                            unlink('../uploads/'.$user_id.'/'.$data_of_filesForDelete[$i]['file_name']);
                                        }
                                    }
                                }
                                $arr = explode('.',$file_v['name']);
                                $ext = $arr[sizeof($arr)-1];
                                $fileName = "$name_of_doc.$ext";
                                $dataAndFile_forUp->up_files_data($fileName, $name_of_doc);
                                $dataAndFile_forUp->resave_files_in_server($fileName);
                            } 
                        }
                    }

                    $location = '../preSendData.php?error=upFilesErr';
                break;
                case 'downloadFile':
                    if(isset($_SESSION['email'])){
                        $email = $_SESSION['email'];
                        $user = new User($_SESSION);
                        $currentUser = $user->findUser();
                        if($currentUser['userType'] == 3){
                            if(isset($_GET['userId'])){
                                $userD_id = $_GET['userId'];
                                $dataAndFile = new Data_and_File($userD_id, '','');
                                $file_of_userD = $dataAndFile->find_files_of_user();
                                if($file_of_userD != null){
                                    for($i=0; $i<count($file_of_userD); $i++){
                                        if($_GET['file'] == 'pass'){
                                            if($file_of_userD[$i]['name_of_doc'] == 'copy_of_passport'){
                                                $fileName = $file_of_userD[$i]['file_name'];
                                                $file = "../uploads/$userD_id/$fileName";
                                                if(!file_exists($file)){
                                                    $location = '../dataOfUser.php?error=fileNotFound';
                                                }else{
                                                    header("Cache-Control: public");
                                                    header("Content-Description: File Transfer");
                                                    header("Content-Disposition: attachment; filename=$fileName");
                                                    header("Content-Type: application/pdf");
                                                    header("Content-Transfer-Encoding: binary");
                                                    readfile($file);
                                                }
                                            }
                                        }

                                        if($_GET['file'] == 'cert'){
                                            if($file_of_userD[$i]['name_of_doc'] == 'certificate_of_employment'){
                                                $fileName = $file_of_userD[$i]['file_name'];
                                                $file = "../uploads/$userD_id/$fileName";
                                                if(!file_exists($file)){
                                                    $location = '../dataOfUser.php?error=fileNotFound';
                                                }else{
                                                    header("Cache-Control: public");
                                                    header("Content-Description: File Transfer");
                                                    header("Content-Disposition: attachment; filename=$fileName");
                                                    header("Content-Type: application/pdf");
                                                    header("Content-Transfer-Encoding: binary");
                                                    readfile($file);
                                                }
                                            }
                                        }

                                        if($_GET['file'] == 'educ'){
                                            if($file_of_userD[$i]['name_of_doc'] == 'education_document'){
                                                $fileName = $file_of_userD[$i]['file_name'];
                                                $file = "../uploads/$userD_id/$fileName";
                                                if(!file_exists($file)){
                                                    $location = '../dataOfUser.php?error=fileNotFound';
                                                }else{
                                                    header("Cache-Control: public");
                                                    header("Content-Description: File Transfer");
                                                    header("Content-Disposition: attachment; filename=$fileName");
                                                    header("Content-Type: application/pdf");
                                                    header("Content-Transfer-Encoding: binary");
                                                    readfile($file);
                                                }
                                            }
                                        }

                                        if($_GET['file'] == 'CV'){
                                            if($file_of_userD[$i]['name_of_doc'] == 'CV'){
                                                $fileName = $file_of_userD[$i]['file_name'];
                                                $file = "../uploads/$userD_id/$fileName";
                                                if(!file_exists($file)){
                                                    $location = '../dataOfUser.php?error=fileNotFound';
                                                }else{
                                                    header("Cache-Control: public");
                                                    header("Content-Description: File Transfer");
                                                    header("Content-Disposition: attachment; filename=$fileName");
                                                    header("Content-Type: application/pdf");
                                                    header("Content-Transfer-Encoding: binary");
                                                    readfile($file);
                                                }
                                            }
                                        }

                                        if($_GET['file'] == 'publ'){
                                            if($file_of_userD[$i]['name_of_doc'] == 'publications'){
                                                $fileName = $file_of_userD[$i]['file_name'];
                                                $file = "../uploads/$userD_id/$fileName";
                                                if(!file_exists($file)){
                                                    $location = '../dataOfUser.php?error=fileNotFound';
                                                }else{
                                                    header("Cache-Control: public");
                                                    header("Content-Description: File Transfer");
                                                    header("Content-Disposition: attachment; filename=$fileName");
                                                    header("Content-Type: application/pdf");
                                                    header("Content-Transfer-Encoding: binary");
                                                    readfile($file);
                                                }
                                            }
                                        }

                                        if($_GET['file'] == 'nom_let'){
                                            if($file_of_userD[$i]['name_of_doc'] == 'nomination_letter'){
                                                $fileName = $file_of_userD[$i]['file_name'];
                                                $file = "../uploads/$userD_id/$fileName";
                                                if(!file_exists($file)){
                                                    $location = '../dataOfUser.php?error=fileNotFound';
                                                }else{
                                                    header("Cache-Control: public");
                                                    header("Content-Description: File Transfer");
                                                    header("Content-Disposition: attachment; filename=$fileName");
                                                    header("Content-Type: application/pdf");
                                                    header("Content-Transfer-Encoding: binary");
                                                    readfile($file);
                                                }
                                            }
                                        }

                                        if($_GET['file'] == 'transcript'){
                                            if($file_of_userD[$i]['name_of_doc'] == 'transcript'){
                                                $fileName = $file_of_userD[$i]['file_name'];
                                                $file = "../uploads/$userD_id/$fileName";
                                                if(!file_exists($file)){
                                                    $location = '../dataOfUser.php?error=fileNotFound';
                                                }else{
                                                    header("Cache-Control: public");
                                                    header("Content-Description: File Transfer");
                                                    header("Content-Disposition: attachment; filename=$fileName");
                                                    header("Content-Type: application/pdf");
                                                    header("Content-Transfer-Encoding: binary");
                                                    readfile($file);
                                                }
                                            }
                                        }

                                        if($_GET['file'] == 'agr'){
                                            if($file_of_userD[$i]['name_of_doc'] == 'agreement'){
                                                $fileName = $file_of_userD[$i]['file_name'];
                                                $file = "../uploads/$userD_id/$fileName";
                                                if(!file_exists($file)){
                                                    $location = '../dataOfUser.php?error=fileNotFound';
                                                }else{
                                                    header("Cache-Control: public");
                                                    header("Content-Description: File Transfer");
                                                    header("Content-Disposition: attachment; filename=$fileName");
                                                    header("Content-Type: application/pdf");
                                                    header("Content-Transfer-Encoding: binary");
                                                    readfile($file);
                                                }
                                            }
                                        }
                                    }
                                }else{
                                    $location = '../dataOfUser.php?error=notFoud';
                                }
                            }
                        }else{
                            $location = '../welcome.php?error=admissionErr';
                        }
                    }else{
                        $location = '../authAndReg.php?error=downloadAuthErr';
                    }
                break;
                case 'downloadUsersFile':
                    $user_id = $_SESSION['id'];
                    $dataAndFile = new Data_and_File($user_id, '','');
                    $file_of_user = $dataAndFile->find_files_of_user();
                    if($file_of_user != null){
                        for($i=0; $i<count($file_of_user); $i++){
                            if($_GET['file'] == 'pass'){
                                if($file_of_user[$i]['name_of_doc'] == 'copy_of_passport'){
                                    $fileName = $file_of_user[$i]['file_name'];
                                    $file = "../uploads/$user_id/$fileName";
                                    if(!file_exists($file)){
                                        $location = '../preSendData.php?error=fileNotFound';
                                    }else{
                                        header("Cache-Control: public");
                                        header("Content-Description: File Transfer");
                                        header("Content-Disposition: attachment; filename=$fileName");
                                        header("Content-Type: application/pdf");
                                        header("Content-Transfer-Encoding: binary");
                                        readfile($file);
                                    }
                                }
                            }
                            if($_GET['file'] == 'cert'){
                                if($file_of_user[$i]['name_of_doc'] == 'certificate_of_employment'){
                                    $fileName = $file_of_user[$i]['file_name'];
                                    $file = "../uploads/$user_id/$fileName";
                                    if(!file_exists($file)){
                                        $location = '../preSendData.php?error=fileNotFound';
                                    }else{
                                        header("Cache-Control: public");
                                        header("Content-Description: File Transfer");
                                        header("Content-Disposition: attachment; filename=$fileName");
                                        header("Content-Type: application/pdf");
                                        header("Content-Transfer-Encoding: binary");
                                        readfile($file);
                                    }
                                }
                            }
                            if($_GET['file'] == 'educ'){
                                if($file_of_user[$i]['name_of_doc'] == 'education_document'){
                                    $fileName = $file_of_user[$i]['file_name'];
                                    $file = "../uploads/$user_id/$fileName";
                                    if(!file_exists($file)){
                                        $location = '../preSendData.php?error=fileNotFound';
                                    }else{
                                        header("Cache-Control: public");
                                        header("Content-Description: File Transfer");
                                        header("Content-Disposition: attachment; filename=$fileName");
                                        header("Content-Type: application/pdf");
                                        header("Content-Transfer-Encoding: binary");
                                        readfile($file);
                                    }
                                }
                            }
                            if($_GET['file'] == 'CV'){
                                if($file_of_user[$i]['name_of_doc'] == 'CV'){
                                    $fileName = $file_of_user[$i]['file_name'];
                                    $file = "../uploads/$user_id/$fileName";
                                    if(!file_exists($file)){
                                        $location = '../preSendData.php?error=fileNotFound';
                                    }else{
                                        header("Cache-Control: public");
                                        header("Content-Description: File Transfer");
                                        header("Content-Disposition: attachment; filename=$fileName");
                                        header("Content-Type: application/pdf");
                                        header("Content-Transfer-Encoding: binary");
                                        readfile($file);
                                    }
                                }
                            }
                            if($_GET['file'] == 'publ'){
                                if($file_of_user[$i]['name_of_doc'] == 'publications'){
                                    $fileName = $file_of_user[$i]['file_name'];
                                    $file = "../uploads/$user_id/$fileName";
                                    if(!file_exists($file)){
                                        $location = '../preSendData.php?error=fileNotFound';
                                    }else{
                                        header("Cache-Control: public");
                                        header("Content-Description: File Transfer");
                                        header("Content-Disposition: attachment; filename=$fileName");
                                        header("Content-Type: application/pdf");
                                        header("Content-Transfer-Encoding: binary");
                                        readfile($file);
                                    }
                                }
                            }
                            if($_GET['file'] == 'nom_let'){
                                if($file_of_user[$i]['name_of_doc'] == 'nomination_letter'){
                                    $fileName = $file_of_user[$i]['file_name'];
                                    $file = "../uploads/$user_id/$fileName";
                                    if(!file_exists($file)){
                                        $location = '../preSendData.php?error=fileNotFound';
                                    }else{
                                        header("Cache-Control: public");
                                        header("Content-Description: File Transfer");
                                        header("Content-Disposition: attachment; filename=$fileName");
                                        header("Content-Type: application/pdf");
                                        header("Content-Transfer-Encoding: binary");
                                        readfile($file);
                                    }
                                }
                            }
                            if($_GET['file'] == 'transcript'){
                                if($file_of_user[$i]['name_of_doc'] == 'transcript'){
                                    $fileName = $file_of_user[$i]['file_name'];
                                    $file = "../uploads/$user_id/$fileName";
                                    if(!file_exists($file)){
                                        $location = '../preSendData.php?error=fileNotFound';
                                    }else{
                                        header("Cache-Control: public");
                                        header("Content-Description: File Transfer");
                                        header("Content-Disposition: attachment; filename=$fileName");
                                        header("Content-Type: application/pdf");
                                        header("Content-Transfer-Encoding: binary");
                                        readfile($file);
                                    }
                                }
                            }
                            if($_GET['file'] == 'agr'){
                                if($file_of_user[$i]['name_of_doc'] == 'agreement'){
                                    $fileName = $file_of_user[$i]['file_name'];
                                    $file = "../uploads/$user_id/$fileName";
                                    if(!file_exists($file)){
                                        $location = '../preSendData.php?error=fileNotFound';
                                    }else{
                                        header("Cache-Control: public");
                                        header("Content-Description: File Transfer");
                                        header("Content-Disposition: attachment; filename=$fileName");
                                        header("Content-Type: application/pdf");
                                        header("Content-Transfer-Encoding: binary");
                                        readfile($file);
                                    }
                                }
                            }
                        }
                    }else{
                            $location = '../preSendData.php?error=notFoud';
                        }
                break;
                case 'downloadAllFiles':
                    if(isset($_SESSION['email'])){
                        $email = $_SESSION['email'];
                        $user = new User($_SESSION);
                        $currentUser = $user->findUser();
                        if($currentUser['userType'] == 3){
                            if(isset($_GET['userId'])){
                                $userD_id = $_GET['userId'];
                                $dataAndFile = new Data_and_File($userD_id, '','');
                                $file_of_userD = $dataAndFile->find_files_of_user();
                                if($file_of_userD != null){
                                    $file_folder = "../uploads/$userD_id/"; // папка с файлами
                                    $currentUser = new User('');
                                    $currentUserInfo = $currentUser->findUserById($userD_id);
                                    $error = "";
                                    if(extension_loaded('zip')){
                                        $zip = new ZipArchive(); // подгружаем библиотеку zip
                                        $zip_name = $currentUserInfo['name'].$currentUserInfo['surname'].".zip"; // имя файла
                                        $res = $zip->open($zip_name, ZIPARCHIVE::CREATE);
                                        for($i=0; $i<count($file_of_userD); $i++){
                                            $fileName = $file_of_userD[$i]['file_name'];
                                            $file = $file_folder.$fileName;
                                            copy($file, $fileName); // копируем в текущую директорию
                                            if(!file_exists($fileName)){
                                                $location = '../dataOfUser.php?error=fileNotFound';
                                            }else{
                                                $zip->addFile($fileName); // добавляем файлы в zip архив
                                            }
                                        }
                                        $zip->close();
                                        for($i=0; $i<count($file_of_userD); $i++){
                                            $fileName = $file_of_userD[$i]['file_name'];
                                            unlink($fileName);
                                        }
                                        if(file_exists($zip_name)){
                                            // отдаём файл на скачивание
                                            header('Content-type: application/zip');
                                            header('Content-Disposition: attachment; filename="'.$zip_name.'"');
                                            readfile($zip_name);
                                            // удаляем zip файл если он существует
                                            unlink($zip_name);
                                        }
                                        $location = '../dataOfUser.php';
                                    }else{
                                        $error .= "* You dont have ZIP extension";
                                    }
                                }else{
                                    $location = '../dataOfUser.php?error=notFoud';
                                }
                            }
                        }else{
                            $location = '../welcome.php?error=admissionErr';
                        }
                    }else{
                        $location = '../authAndReg.php?error=downloadAuthErr';
                    }
                break;
                case 'change_s':
                    $user_id = $_SESSION['id'];
                    $dataAndFile = new Data_and_File($user_id, '', '');
                    $file_of_user = $dataAndFile->find_files_of_user();
                    $user = new User($_SESSION);
                    $usersInfo = $user->findUser();
                    if($usersInfo['userType']==1){
                        $data_of_user = $dataAndFile->findDataOfTeacher();
                        if(($data_of_user != null) && ($file_of_user != null)){
                            $dataAndFile->status = 1;
                            $dataAndFile->dateOfdata = date('Y-m-d');
                            $dataAndFile->upDataStatusTeacher();
                            $location = '../preSendData.php?error=dataSent';
                        }else{
                            $location = '../preSendData.php?error=fillErr';
                        }
                    }elseif($usersInfo['userType']==2){
                        $data_of_user = $dataAndFile->findDataOfStudent();
                        if(($data_of_user != null) && ($file_of_user != null)){
                            $dataAndFile->status = 1;
                            $dataAndFile->dateOfdata = date('Y-m-d');
                            $dataAndFile->upDataStatusStudent();
                            $location = '../preSendData.php?error=dataSent';
                        }else{
                            $location = '../preSendData.php?error=fillErr';
                        }
                    }
                    
                break;
                case 'exportToExel':
                    if(isset($_GET['userType'])){
                        if($_GET['userType'] == 1){
                            $users = new User('');
                            $usersInfo = $users->findUserByType($_GET['userType']);
                            $dataToExel = array();
                            $j = 0;
                            $m = 1;
                            for($i = 0; $i < count($usersInfo); $i++){
                                if(isset($usersInfo[$i]['email_confirmed'])){
                                    if($usersInfo[$i]['email_confirmed'] == 1){
                                        $dataAndFile = new Data_and_File($usersInfo[$i]['id'], '', '');
                                        $dataOfUser = $dataAndFile->findDataOfTeacher();
                                        if(isset($dataOfUser)){
                                            if(isset($dataOfUser['data_status'])){
                                                if($dataOfUser['data_status'] == 1){
                                                    $dataToExel[$j]['№'] = $m;
                                                    $dataToExel[$j]['name'] = $usersInfo[$i]['name'];
                                                    $dataToExel[$j]['surname'] = $usersInfo[$i]['surname'];
                                                    $dataToExel[$j]['email'] = $usersInfo[$i]['email'];
                                                    $dataToExel[$j]['userType'] = $usersInfo[$i]['userType'];
                                                    $dataToExel[$j]['regDate'] = $usersInfo[$i]['createDate'];
                                                    $country = findCountries($_COOKIE['lang']);
                                                    for($k = 0; $k < count($country); $k++){
                                                        if($country[$k]['country_id'] == $dataOfUser['country_id']){
                                                            $dataToExel[$j]['citizenship'] = $country[$k]['country_name_'.$language];;
                                                        }
                                                    }
                                                    $dataToExel[$j]['purpose'] = $dataOfUser['purpose'];
                                                    $faculties = findFaculties($_COOKIE['lang']);
                                                    for($n = 0; $n < count($faculties); $n++){
                                                        if($faculties[$n]['faculty_id'] == $dataOfUser['faculty_to_id']){
                                                            $dataToExel[$j]['facultyToGo'] = $faculties[$n]['faculty_name_'.$language];;
                                                        }
                                                    }
                                                    $dataToExel[$j]['mobilityForm'] = $dataOfUser['mobility_form'];
                                                    $dataToExel[$j]['period'] = $applicationPWords['periodVar1'].' '.$dataOfUser['period_from'].' '.$applicationPWords['periodVar2'].' '.$dataOfUser['period_to']; 
                                                    $dataToExel[$j]['dateOfData'] = $dataOfUser['data_of_application'];
                                                    $j++;
                                                    $m++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            //Создаем экземпляр класса электронной таблицы
                            $spreadsheet = new Spreadsheet();
                            //Получаем текущий активный лист
                            $sheet = $spreadsheet->getActiveSheet();
                            // Записываем в ячейки данные
                            $FL = 'A';
                            $X = 1;
                            $sheet->setCellValue($FL.$X, '#');
                            $sheet->setCellValue(++$FL.$X, $authAndRegPWords['name']);
                            $sheet->setCellValue(++$FL.$X, $authAndRegPWords['surname']);
                            $sheet->setCellValue(++$FL.$X, 'email');
                            $sheet->setCellValue(++$FL.$X, $authAndRegPWords['userType']);
                            $sheet->setCellValue(++$FL.$X, $requestsPWOrds['regDateLabel']);
                            $sheet->setCellValue(++$FL.$X, $applicationPWords['citizenshipLabel']);
                            $sheet->setCellValue(++$FL.$X, $applicationPWords['purposeLabel']);
                            $sheet->setCellValue(++$FL.$X, $requestsPWOrds['facultyLabel']);
                            $sheet->setCellValue(++$FL.$X, $applicationPWords['mobilityLabel']);
                            $sheet->setCellValue(++$FL.$X, $applicationPWords['periodLabel']);
                            $sheet->setCellValue(++$FL.$X, $requestsPWOrds['dateOfData']);
                            
                            for($g=0; $g<count($dataToExel); $g++){
                                $FL2 = 'A';
                                ++$X;
                                $sheet->setCellValue($FL2.$X, $dataToExel[$g]['№']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['name']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['surname']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['email']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['userType']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['regDate']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['citizenship']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['purpose']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['facultyToGo']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['mobilityForm']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['period']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['dateOfData']);
                            }
                            $writer = new Xlsx($spreadsheet);
                            //Сохраняем файл в текущей папке, в которой выполняется скрипт.
                            //Чтобы указать другую папку для сохранения. 
                            //Прописываем полный путь до папки и указываем имя файла
                            $listName = 'list.xlsx';
                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment; filename="'. urlencode($listName).'"');
                            $writer->save('php://output');
                            exit();
                        }elseif($_GET['userType'] == 2){
                            $users = new User('');
                            $usersInfo = $users->findUserByType($_GET['userType']);
                            $dataToExel = array();
                            $j = 0;
                            $m = 1;
                            for($i = 0; $i < count($usersInfo); $i++){
                                if(isset($usersInfo[$i]['email_confirmed'])){
                                    if($usersInfo[$i]['email_confirmed'] == 1){
                                        $dataAndFile = new Data_and_File($usersInfo[$i]['id'], '', '');
                                        $dataOfUser = $dataAndFile->findDataOfStudent();
                                        if(isset($dataOfUser)){
                                            if(isset($dataOfUser['data_status'])){
                                                if($dataOfUser['data_status'] == 1){
                                                    $dataToExel[$j]['№'] = $m;
                                                    $dataToExel[$j]['name'] = $usersInfo[$i]['name'];
                                                    $dataToExel[$j]['surname'] = $usersInfo[$i]['surname'];
                                                    $dataToExel[$j]['email'] = $usersInfo[$i]['email'];
                                                    $dataToExel[$j]['userType'] = $usersInfo[$i]['userType'];
                                                    $dataToExel[$j]['regDate'] = $usersInfo[$i]['createDate'];
                                                    $country = findCountries($_COOKIE['lang']);
                                                    for($k = 0; $k < count($country); $k++){
                                                        if($country[$k]['country_id'] == $dataOfUser['country_id']){
                                                            $dataToExel[$j]['citizenship'] = $country[$k]['country_name_'.$language];;
                                                        }
                                                    }
                                                    $dataToExel[$j]['purpose'] = $dataOfUser['purpose'];
                                                    $faculties = findFaculties($_COOKIE['lang']);
                                                    for($n = 0; $n < count($faculties); $n++){
                                                        if($faculties[$n]['faculty_id'] == $dataOfUser['faculty_to_id']){
                                                            $dataToExel[$j]['facultyToGo'] = $faculties[$n]['faculty_name_'.$language];;
                                                        }
                                                    }
                                                    $dataToExel[$j]['mobilityForm'] = $dataOfUser['mobility_form'];
                                                    $dataToExel[$j]['period'] = $applicationPWords['periodVar1'].' '.$dataOfUser['period_from'].' '.$applicationPWords['periodVar2'].' '.$dataOfUser['period_to']; 
                                                    $dataToExel[$j]['dateOfData'] = $dataOfUser['data_of_application'];
                                                    $j++;
                                                    $m++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            //Создаем экземпляр класса электронной таблицы
                            $spreadsheet = new Spreadsheet();
                            //Получаем текущий активный лист
                            $sheet = $spreadsheet->getActiveSheet();
                            // Записываем в ячейки данные
                            $FL = 'A';
                            $X = 1;
                            $sheet->setCellValue($FL.$X, '#');
                            $sheet->setCellValue(++$FL.$X, $authAndRegPWords['name']);
                            $sheet->setCellValue(++$FL.$X, $authAndRegPWords['surname']);
                            $sheet->setCellValue(++$FL.$X, 'email');
                            $sheet->setCellValue(++$FL.$X, $authAndRegPWords['userType']);
                            $sheet->setCellValue(++$FL.$X, $requestsPWOrds['regDateLabel']);
                            $sheet->setCellValue(++$FL.$X, $applicationPWords['citizenshipLabel']);
                            $sheet->setCellValue(++$FL.$X, $applicationPWords['purposeLabel']);
                            $sheet->setCellValue(++$FL.$X, $requestsPWOrds['facultyLabel']);
                            $sheet->setCellValue(++$FL.$X, $applicationPWords['mobilityLabel']);
                            $sheet->setCellValue(++$FL.$X, $applicationPWords['periodLabel']);
                            $sheet->setCellValue(++$FL.$X, $requestsPWOrds['dateOfData']);
                            
                            for($g=0; $g<count($dataToExel); $g++){
                                $FL2 = 'A';
                                ++$X;
                                $sheet->setCellValue($FL2.$X, $dataToExel[$g]['№']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['name']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['surname']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['email']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['userType']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['regDate']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['citizenship']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['purpose']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['facultyToGo']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['mobilityForm']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['period']);
                                $sheet->setCellValue(++$FL2.$X, $dataToExel[$g]['dateOfData']);
                            }
                            $writer = new Xlsx($spreadsheet);
                            //Сохраняем файл в текущей папке, в которой выполняется скрипт.
                            //Чтобы указать другую папку для сохранения. 
                            //Прописываем полный путь до папки и указываем имя файла
                            $listName = 'list.xlsx';
                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment; filename="'. urlencode($listName).'"');
                            $writer->save('php://output');
                            exit();
                        }
                    }
                break;
            }
        } 
}

//header("Location:$location");