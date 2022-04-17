<?php

class Data_and_File{
    public $user_id;
    public $sex;
    public $birthDate;
    public $PlaceOfBirth;
    public $citizenship;
    public $nationality;
    public $passportNumber;
    public $issueDate;
    public $expiryDate;
    public $addressOfResidence;
    public $university;
    public $sendingUniversity;
    public $facultyFrom;
    public $academicDegree;
    public $major;
    public $purpose;
    public $radio3_data;
    public $mobilityProgram;
    public $radio7_data;
    public $faculty;
    public $mobility;
    public $periodFrom;
    public $periodTo;
    public $visaSupport;
    public $radio2_1_data;
    public $status;
    public $dormitory;
    public $dateOfdata;
    public $files;

    function __construct($user_id, $data, $file){
        $this->user_id = (isset($user_id)) ? $user_id : "";
        $this->sex = (isset($data['sex'])) ? $data['sex'] : "";
        $this->birthDate = (isset($data['birthDate'])) ? $data['birthDate'] : "";
        $this->PlaceOfBirth = (isset($data['PlaceOfBirth'])) ? $data['PlaceOfBirth'] : "";
        $this->citizenship = (isset($data['citizenship'])) ? $data['citizenship'] : "";
        $this->nationality = (isset($data['nationality'])) ? $data['nationality'] : "";
        $this->passportNumber = (isset($data['passportNumber'])) ? $data['passportNumber'] : "";
        $this->issueDate = (isset($data['issueDate'])) ? $data['issueDate'] : "";
        $this->expiryDate = (isset($data['expiryDate'])) ? $data['expiryDate'] : "";
        $this->addressOfResidence = (isset($data['addressOfResidence'])) ? $data['addressOfResidence'] : "";
        $this->university = (isset($data['university'])) ? $data['university'] : "";
        $this->sendingUniversity = (isset($data['sendingUniversity'])) ? $data['sendingUniversity'] : "";
        $this->facultyFrom = (isset($data['facultyFrom'])) ? $data['facultyFrom'] : "";
        $this->academicDegree = (isset($data['academicDegree'])) ? $data['academicDegree'] : "";
        $this->major = (isset($data['major'])) ? $data['major'] : "";
        $this->purpose = (isset($data['purpose'])) ? $data['purpose'] : "";
        $this->radio3_data = (isset($data['radio3_data'])) ? $data['radio3_data'] : "";
        $this->mobilityProgram = (isset($data['mobilityProgram'])) ? $data['mobilityProgram'] : "";
        $this->radio7_data = (isset($data['radio7_data'])) ? $data['radio7_data'] : "";
        $this->faculty = (isset($data['faculty'])) ? $data['faculty'] : "";
        $this->mobility = (isset($data['mobility'])) ? $data['mobility'] : "";
        $this->periodFrom = (isset($data['periodFrom'])) ? $data['periodFrom'] : "";
        $this->periodTo = (isset($data['periodTo'])) ? $data['periodTo'] : "";
        $this->visaSupport = (isset($data['visaSupport'])) ? $data['visaSupport'] : "";
        $this->radio2_1_data = (isset($data['radio2_1_data'])) ? $data['radio2_1_data'] : "";
        $this->status = (isset($data['data_status'])) ? $data['data_status'] : "";
        $this->dormitory = (isset($data['dormitory'])) ? $data['dormitory'] : "";
        $this->dormitory = (isset($data['dateOfdata'])) ? $data['dateOfdata'] : "";
        $this->files = (isset($file)) ? $file : "";
    }

    function findDataOfTeacher(){
        global $connection;
        $data = null;
        try {
            $query = $connection->prepare('SELECT * FROM teachers_data WHERE user_id = :d_user_id');
            $query -> execute(array('d_user_id'=>$this->user_id));
            $data = $query->fetch();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        return $data;
    }

    function findDataOfStudent(){
        global $connection;
        $data = null;
        try {
            $query = $connection->prepare('SELECT * FROM students_data WHERE user_id = :d_user_id');
            $query -> execute(array('d_user_id'=>$this->user_id));
            $data = $query->fetch();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        return $data;
    }

    function personalData(){
        global $connection;
        if(($this->purpose == 'on') && ($this->radio3_data != null)){
            $purpose = $this->radio3_data;
        }else{
            $purpose = $this->purpose;
        }

        if(($this->visaSupport == 'on') && ($this->radio2_1_data != null)){
            $visaSupport = $this->radio2_1_data;
        }else{
            $visaSupport = $this->visaSupport;
        }

        try{
            $query = $connection->prepare('INSERT INTO teachers_data (
                user_id, 
                sex, 
                birth_date, 
                place_of_birth, 
                country_id, 
                nationality_id, 
                passport_number, 
                issue_date_of_passport, 
                expiry_date_of_passport, 
                address_of_residence, 
                university, 
                academicDegree, 
                purpose, 
                faculty_to_id, 
                mobility_form, 
                period_from, 
                period_to, 
                visa_support, 
                data_status, 
                data_of_application) VALUES (
                    :d_user_id, 
                    :d_sex, 
                    :d_birth_date, 
                    :d_place_of_birth, 
                    :d_country_id, 
                    :d_nationality_id, 
                    :d_passport_number, 
                    :d_issue_date_of_passport, 
                    :d_expiry_date_of_passport, 
                    :d_address_of_residence, 
                    :d_university, 
                    :d_academicDegree, 
                    :d_purpose, 
                    :d_faculty_to_id, 
                    :d_mobility_form, 
                    :d_period_from, 
                    :d_period_to, 
                    :d_visa_support, 
                    :d_data_status, 
                    :d_data_of_application)');
    
            $query->execute(array('d_user_id' => $this->user_id, 
            'd_sex' => $this->sex, 
            'd_birth_date' => $this->birthDate, 
            'd_place_of_birth' => $this->PlaceOfBirth, 
            'd_country_id' => $this->citizenship, 
            'd_nationality_id' => $this->nationality, 
            'd_passport_number' => $this->passportNumber, 
            'd_issue_date_of_passport' => $this->issueDate, 
            'd_expiry_date_of_passport' => $this->expiryDate, 
            'd_address_of_residence' => $this->addressOfResidence, 
            'd_university' => $this->university, 
            'd_academicDegree' => $this->academicDegree, 
            'd_purpose' => $purpose, 
            'd_faculty_to_id' => $this->faculty, 
            'd_mobility_form' => $this->mobility, 
            'd_period_from' => $this->periodFrom, 
            'd_period_to' => $this->periodTo, 
            'd_visa_support' => $visaSupport, 
            'd_data_status' => $this->status, 
            'd_data_of_application' => $this->dateOfdata));
        }catch(PDOException $e){
            echo $e -> getMessage ();
        }
    }

    function insertDataOfStudent(){
        global $connection;
        if(($this->purpose == 'on') && ($this->radio3_data != null)){
            $purpose = $this->radio3_data;
        }else{
            $purpose = $this->purpose;
        }

        if(($this->visaSupport == 'on') && ($this->radio2_1_data != null)){
            $visaSupport = $this->radio2_1_data;
        }else{
            $visaSupport = $this->visaSupport;
        }

        if(($this->mobilityProgram == 'on') && ($this->radio7_data != null)){
            $mobilityProgram = $this->radio7_data;
        }else{
            $mobilityProgram = $this->mobilityProgram;
        }

        try{
            $query = $connection->prepare('INSERT INTO students_data (
                user_id, 
                sex, 
                birth_date, 
                place_of_birth, 
                country_id, 
                nationality_id, 
                passport_number, 
                issue_date_of_passport, 
                expiry_date_of_passport, 
                address_of_residence, 
                sending_university, 
                faculty_from, 
                academic_degree, 
                major, 
                purpose, 
                mobility_program, 
                faculty_to_id, 
                mobility_form, 
                period_from, 
                period_to, 
                visa_support, 
                dormitory_need, 
                data_status, 
                data_of_application) VALUES (
                    :d_user_id, 
                    :d_sex, 
                    :d_birth_date, 
                    :d_place_of_birth, 
                    :d_country_id, 
                    :d_nationality_id, 
                    :d_passport_number, 
                    :d_issue_date_of_passport, 
                    :d_expiry_date_of_passport, 
                    :d_address_of_residence, 
                    :d_sending_university, 
                    :d_faculty_from, 
                    :d_academic_degree, 
                    :d_major, 
                    :d_purpose, 
                    :d_mobility_program, 
                    :d_faculty_to_id, 
                    :d_mobility_form, 
                    :d_period_from, 
                    :d_period_to, 
                    :d_visa_support,
                    :d_dormitory_need,  
                    :d_data_status, 
                    :d_data_of_application)');
    
            $query->execute(array('d_user_id' => $this->user_id, 
            'd_sex' => $this->sex, 
            'd_birth_date' => $this->birthDate, 
            'd_place_of_birth' => $this->PlaceOfBirth, 
            'd_country_id' => $this->citizenship, 
            'd_nationality_id' => $this->nationality, 
            'd_passport_number' => $this->passportNumber, 
            'd_issue_date_of_passport' => $this->issueDate, 
            'd_expiry_date_of_passport' => $this->expiryDate, 
            'd_address_of_residence' => $this->addressOfResidence, 
            'd_sending_university' => $this->sendingUniversity, 
            'd_faculty_from' => $this->facultyFrom, 
            'd_academic_degree' => $this->academicDegree, 
            'd_major' => $this->major, 
            'd_purpose' => $purpose, 
            'd_mobility_program' => $mobilityProgram, 
            'd_faculty_to_id' => $this->faculty, 
            'd_mobility_form' => $this->mobility, 
            'd_period_from' => $this->periodFrom, 
            'd_period_to' => $this->periodTo, 
            'd_visa_support' => $visaSupport, 
            'd_dormitory_need' => $this->dormitory, 
            'd_data_status' => $this->status, 
            'd_data_of_application' => $this->dateOfdata));
        }catch(PDOException $e){
            echo $e -> getMessage ();
        }
    }

    function upPersonalDataOfTeacher (){
        global $connection;

        if(($this->purpose == 'on') && ($this->radio3_data != null)){
            $purpose = $this->radio3_data;
        }else{
            $purpose = $this->purpose;
        }

        if(($this->visaSupport == 'on') && ($this->radio2_1_data != null)){
            $visaSupport = $this->radio2_1_data;
        }else{
            $visaSupport = $this->visaSupport;
        }

        try{
            $query = $connection->prepare('UPDATE teachers_data SET sex = :d_sex, 
            birth_date = :d_birth_date, 
            place_of_birth = :d_place_of_birth, 
            country_id = :d_country_id, 
            nationality_id = :d_nationality_id, 
            passport_number = :d_passport_number, 
            issue_date_of_passport = :d_issue_date_of_passport, 
            expiry_date_of_passport = :d_expiry_date_of_passport, 
            address_of_residence = :d_address_of_residence, 
            university = :d_university, 
            academicDegree = :d_academicDegree, 
            purpose = :d_purpose, 
            faculty_to_id = :d_faculty_to_id, 
            mobility_form = :d_mobility_form, 
            period_from = :d_period_from, 
            period_to = :d_period_to, 
            visa_support = :d_visa_support WHERE user_id = :d_user_id');
    
            $query->execute(array('d_user_id' => $this->user_id, 
            'd_sex' => $this->sex, 
            'd_birth_date' => $this->birthDate, 
            'd_place_of_birth' => $this->PlaceOfBirth, 
            'd_country_id' => $this->citizenship, 
            'd_nationality_id' => $this->nationality, 
            'd_passport_number' => $this->passportNumber, 
            'd_issue_date_of_passport' => $this->issueDate, 
            'd_expiry_date_of_passport' => $this->expiryDate, 
            'd_address_of_residence' => $this->addressOfResidence, 
            'd_university' => $this->university, 
            'd_academicDegree' => $this->academicDegree, 
            'd_purpose' => $purpose, 
            'd_faculty_to_id' => $this->faculty, 
            'd_mobility_form' => $this->mobility, 
            'd_period_from' => $this->periodFrom, 
            'd_period_to' => $this->periodTo, 
            'd_visa_support' => $visaSupport));
        }catch(PDOException $e){
            echo $e -> getMessage ();
        }
    }

    function upPersonalDataOfStudent (){
        global $connection;

        if(($this->purpose == 'on') && ($this->radio3_data != null)){
            $purpose = $this->radio3_data;
        }else{
            $purpose = $this->purpose;
        }

        if(($this->visaSupport == 'on') && ($this->radio2_1_data != null)){
            $visaSupport = $this->radio2_1_data;
        }else{
            $visaSupport = $this->visaSupport;
        }

        if(($this->mobilityProgram == 'on') && ($this->radio7_data != null)){
            $mobilityProgram = $this->radio7_data;
        }else{
            $mobilityProgram = $this->mobilityProgram;
        }

        try{
            $query = $connection->prepare('UPDATE students_data SET sex = :d_sex, 
            birth_date = :d_birth_date, 
            place_of_birth = :d_place_of_birth, 
            country_id = :d_country_id, 
            nationality_id = :d_nationality_id, 
            passport_number = :d_passport_number, 
            issue_date_of_passport = :d_issue_date_of_passport, 
            expiry_date_of_passport = :d_expiry_date_of_passport, 
            address_of_residence = :d_address_of_residence, 
            sending_university = :d_sending_university, 
            faculty_from = :d_faculty_from, 
            academic_degree = :d_academic_degree, 
            major = :d_major, 
            purpose = :d_purpose, 
            mobility_program = :d_mobility_program, 
            faculty_to_id = :d_faculty_to_id, 
            mobility_form = :d_mobility_form, 
            period_from = :d_period_from, 
            period_to = :d_period_to, 
            visa_support = :d_visa_support, 
            dormitory_need = :d_dormitory_need WHERE user_id = :d_user_id');
    
            $query->execute(array('d_user_id' => $this->user_id, 
            'd_sex' => $this->sex, 
            'd_birth_date' => $this->birthDate, 
            'd_place_of_birth' => $this->PlaceOfBirth, 
            'd_country_id' => $this->citizenship, 
            'd_nationality_id' => $this->nationality, 
            'd_passport_number' => $this->passportNumber, 
            'd_issue_date_of_passport' => $this->issueDate, 
            'd_expiry_date_of_passport' => $this->expiryDate, 
            'd_address_of_residence' => $this->addressOfResidence, 
            'd_sending_university' => $this->university, 
            'd_faculty_from' => $this->facultyFrom, 
            'd_academic_degree' => $this->academicDegree, 
            'd_major' => $this->major, 
            'd_purpose' => $purpose, 
            'd_mobility_program' => $mobilityProgram, 
            'd_faculty_to_id' => $this->faculty, 
            'd_mobility_form' => $this->mobility, 
            'd_period_from' => $this->periodFrom, 
            'd_period_to' => $this->periodTo, 
            'd_visa_support' => $visaSupport, 
            'd_dormitory_need' => $this->dormitory));
        }catch(PDOException $e){
            echo $e -> getMessage ();
        }
    }

    function upDataStatusTeacher (){
        global $connection;

        try{
            $query = $connection->prepare('UPDATE teachers_data SET  data_status = :d_data_status, data_of_application = :d_data_of_application WHERE user_id = :d_user_id');
    
            $query->execute(array('d_user_id' => $this->user_id, 'd_data_of_application' => $this->dateOfdata, 'd_data_status' => $this->status));
        }catch(PDOException $e){
            echo $e -> getMessage ();
        }
    }

    function upDataStatusStudent (){
        global $connection;

        try{
            $query = $connection->prepare('UPDATE students_data SET  data_status = :d_data_status, data_of_application = :d_data_of_application WHERE user_id = :d_user_id');
    
            $query->execute(array('d_user_id' => $this->user_id, 'd_data_of_application' => $this->dateOfdata, 'd_data_status' => $this->status));
        }catch(PDOException $e){
            echo $e -> getMessage ();
        }
    }

    function find_files_of_user (){
        global $connection;
        $files_of_user = [];
        try {
            $query = $connection->prepare('SELECT * FROM upload_documents WHERE user_id = :d_user_id');
            $query -> execute(array('d_user_id'=>$this->user_id));
            $files_of_user = $query->fetchAll();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        return $files_of_user;
    }
     
    function add_files_data(){
        global $connection;
        foreach($this->files as $file_k => $file_v){
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file_v['tmp_name']);
            if($mime == 'application/pdf'){
                $file_address = "uploads/".$this->user_id;
                $name_of_doc = $file_k;
                $arr = explode('.',$file_v['name']);
                $ext = $arr[sizeof($arr)-1];
                $fileName = "$name_of_doc.$ext";
                try{
                    $query = $connection->prepare('INSERT INTO upload_documents (user_id, 
                    file_name, 
                    file_type, 
                    file_address, 
                    file_size, 
                    name_of_doc) VALUES (:f_user_id, 
                    :f_file_name, 
                    :f_file_type, 
                    :f_file_address, 
                    :f_file_size, 
                    :f_name_of_doc)');
            
                    $query->execute(array('f_user_id' => $this->user_id, 
                    'f_file_name' => $fileName, 
                    'f_file_type' => $file_v['type'], 
                    'f_file_address' => $file_address, 
                    'f_file_size' => $file_v['size'], 
                    'f_name_of_doc' => $name_of_doc));
                }catch(PDOException $e){
                    echo $e -> getMessage();
                }
            }
            
        }
        
    }

    function up_files_data($fileName, $name_of_doc){
        global $connection;
        try{
            $query = $connection->prepare('UPDATE upload_documents SET file_name = :f_file_name, file_type = :f_file_type, file_size = :f_file_size WHERE user_id = :f_user_id AND name_of_doc = :f_name_of_doc');

            $query->execute(array('f_user_id' => $this->user_id, 'f_name_of_doc' => $name_of_doc, 'f_file_name' => $fileName, 'f_file_type' => $this->files['type'], 'f_file_size' => $this->files['size']));
        }catch(PDOException $e){
            echo $e -> getMessage();
        }
    }

    function save_files_in_server(){
        foreach($this->files as $file_k => $file_v){
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file_v['tmp_name']);
            if($mime === 'application/pdf'){
                $name_of_doc = $file_k;
                $dir = '../uploads/'.$this->user_id;
                if(!is_dir($dir)){
                    mkdir($dir);
                }
                $arr = explode('.',$file_v['name']);
                $ext = $arr[sizeof($arr)-1];
                $fileName = "$name_of_doc.$ext";
                $target_dir = $dir."/";
                $target_file = $target_dir.basename($fileName);
                move_uploaded_file($file_v['tmp_name'], $target_file);
            }
        }
    }

    function resave_files_in_server($fileName){
        $target_dir = "../uploads/".$this->user_id."/";
        $target_file = $target_dir.basename($fileName);
        move_uploaded_file($this->files['tmp_name'], $target_file);   
    }
}
