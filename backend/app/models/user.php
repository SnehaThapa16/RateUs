<?php
// require_once "../confiq/confiq.php";
require_once "../session/session.php";

class Users{
    private $conn;
    public function __construct($mysqli){
        $this->conn=$mysqli;
    }
    public function registerUser($id,$name,$email,$contact,$password){
        $hashed_password=password_hash($password,PASSWORD_DEFAULT);

        $query="INSERT INTO user_ (ID,Name,Email,Contact,Password) VALUES(?,?,?,?,?)";
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param("sssss",$id,$name,$email,$contact,$hashed_password);
        if($stmt->execute()){
            $this->addSessionData($id,$name,$contact,$email);
            return true;
        }               
        else{
            echo "Registration Error";
            return false;
        } 
    }
    public function loginUser($email,$password){
        $query="SELECT ID,Name,Contact,Password FROM user_ WHERE Email=?";
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->bind_result($id,$name,$contact,$hashed_password);
        if($stmt->fetch()){
            if(password_verify($password,$hashed_password)){
                $this->addSessionData($id,$name,$contact,$email);
                echo json_encode([
                    'status'=>'success',
                    'message'=>'Login Successfull'
                ]);
            }
            else{
                echo json_encode([
                    'status'=>'error',
                    'message'=>'Password Not Matched'
                ]);
            }

        }
        else{
            echo json_encode([
                'status'=>'error',
                'message'=>'email not found'
            ]);
        }
    }
    public function logoutUser(){
        Session::start();
        Session::destroy();
        echo json_encode([
            'status'=>'success',
            'message'=>'logout Successful'
        ]);
    }
    public function getUserDetails(){
        Session::start();
        echo json_encode([
            'name'=>Session::get('name'),
            'email'=>Session::get('email'),
            'contact'=>Session::get('contact')
        ]);
    }
    public function addSessionData($id,$name,$contact,$email){
        Session::start();
        Session::add('loggedIn',true);
        Session::add('id',$id);
        Session::add('name',$name);
        Session::add('contact',$contact);
        Session::add('email',$email);
    }

}

?>