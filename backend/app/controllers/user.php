<?php
require_once "../confiq/confiq.php";
require "../app/models/user.php";

class UsersController{
    private $userModel;
    public function __construct($mysqli){
        $this->userModel=new users($mysqli);
    }
    public function userMethods(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['action']) && $_POST['action']=="register"){
                $name=$_POST['name'];
                $email=$_POST['email'];
                $contact=$_POST['contact'];
                $password=$_POST['password'];
                $id=create_unique_id();
                if($this->userModel->registerUser($id,$name,$email,$contact,$password)){
                    echo json_encode([
                        'status'=>'success',
                        'message'=>'User Registered Successfully'
                    ]);
                }
                else{
                    echo json_encode([
                        'status'=>'error',
                        'message'=>'User Registeration Failed'
                    ]);
                }
            }
            else if(isset($_POST['action']) && $_POST['action']=="login"){
                $email=$_POST['email'];
                $password=$_POST['password'];
                return $this->userModel->loginUser($email,$password);
            } 
            else if(isset($_POST['action']) && $_POST['action']=="logout"){
                return $this->userModel->logoutUser();
            } 
        }
        else if($_SERVER['REQUEST_METHOD']=='GET'){
            if(isset($_GET['action']) && $_GET['action']='details'){
                echo $this->userModel->getUserDetails();
            }
        }
    }
 

}

?>