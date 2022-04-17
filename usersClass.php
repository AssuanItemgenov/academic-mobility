<?php

class User {
    public $email;
    public $password;
    public $name;
    public $surname;
    public $userType;
    public $hash;
    public $email_confirmed;
    public $date;

    function __construct($data){
        $this->email = (isset($data['email'])) ? $data['email'] : "";
        $this->password = (isset($data['password'])) ? $data['password'] : "";
        $this->name = (isset($data['name'])) ? $data['name'] : "";
        $this->surname = (isset($data['surname'])) ? $data['surname'] : "";
        $this->userType = (isset($data['userType'])) ? $data['userType'] : "";
        $this->hash = (isset($data['hash'])) ? $data['hash'] : "";
        $this->email_confirmed = (isset($data['email_confirmed'])) ? $data['email_confirmed'] : "";
        $this->date = (isset($data['createDate'])) ? $data['createDate'] : "";
    }

    function findUser (){
        global $connection;
        $user = null;
        try {
            $query = $connection->prepare('SELECT * FROM users WHERE email = :u_email');
            $query -> execute(array('u_email'=>$this->email));
            $user = $query->fetch();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        return $user;
    }
    
    function findUserById ($id){
        global $connection;
        $user = null;
        try {
            $query = $connection->prepare('SELECT * FROM users WHERE id = :u_id');
            $query -> execute(array('u_id'=>$id));
            $user = $query->fetch();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        return $user;
    }

    function findUserByType ($type){
        global $connection;
        $user = null;
        try {
            $query = $connection->prepare('SELECT * FROM users WHERE userType = :u_userType');
            $query -> execute(array('u_userType'=>$type));
            $user = $query->fetchAll();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        return $user;
    }

    function findAllUsers (){
        global $connection;
        $user = null;
        try {
            $query = $connection->prepare('SELECT * FROM users');
            $query -> execute(array());
            $user = $query->fetchAll();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        return $user;
    }

    function register (){
        global $connection;
        $password = sha1($this->password);
        try{
            $query = $connection->prepare('INSERT INTO users (email, name, surname, userType, password, hash, email_confirmed, createDate) VALUES (:u_email, :u_name, :u_surname, :u_userType, :u_password, :u_hash, :u_email_confirmed, :u_createDate)');
    
            $query->execute(array('u_email' => $this->email, 'u_password' => $password, 'u_name' => $this->name, 'u_surname' => $this->surname, 'u_userType' => $this->userType, 'u_hash' => $this->hash, 'u_email_confirmed' => $this->email_confirmed, 'u_createDate' => $this->date));
        }catch(PDOException $e){
            echo $e -> getMessage ();
        }
    }

    function change_email_confirmed(){
        global $connection;
        try{
            $query = $connection->prepare('UPDATE users SET email_confirmed = :u_email_confirmed WHERE email = :u_email');
            
            $query->execute(array('u_email_confirmed'=>$this->email_confirmed, 'u_email' => $this->email));
    
        }catch(PDOException $e){
            echo $e->getMessage();
    
        }
    }

    function change_hash(){
        global $connection;
        try{
            $query = $connection->prepare('UPDATE users SET hash = :u_hash WHERE email = :u_email');
            
            $query->execute(array('u_hash'=>$this->hash, 'u_email' => $this->email));
    
        }catch(PDOException $e){
            echo $e->getMessage();
    
        }
    }

    function change_password(){
        global $connection;
        try{
            $query = $connection->prepare('UPDATE users SET password = :u_password WHERE email = :u_email');
            
            $query->execute(array('u_password'=>$this->password, 'u_email' => $this->email));
    
        }catch(PDOException $e){
            echo $e->getMessage();
    
        }
    }
}
