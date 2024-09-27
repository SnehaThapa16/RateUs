<?php
require_once "../confiq/confiq.php";
require_once "../session/session.php";
require "../app/models/organization.php";


class organizationConstroller{
    private $orgModel;
    public function __construct($mysqli){
        $this->orgModel=new organization($mysqli);
    }
    public function organizationMethods(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            Session::start();
            $id=create_unique_id();
            $name=$_POST['name'];
            $address=$_POST['address'];
            $owner_id=Session::get('id');
            $logo=$this->uploadLogo($_FILES['logo']);
            if($logo=="too big"){
                echo json_encode([
                  'status'=>'error',
                  'message'=>'Logo size is too large'
                ]);
            }
            if($this->orgModel->addOrganization($id,$name,$address,$owner_id,$logo)){
                echo json_encode([
                    'status'=>'success',
                    'message'=>'Organization added successfully'
                ]);
            }
            else{
                echo json_encpode([
                    'status'=>'error',
                    'message'=>'Organization not added'
                ]);
            }
        }
        else if($_SERVER['REQUEST_METHOD']=='GET'){
            if(isset($_GET['action']) && $_GET['action']=='listOrganization'){
                return $this->orgModel->getAllOrganizations();
            }
            else if(isset($_GET['action']) && $_GET['action']=='searchOrg'){
             
                return $this->orgModel->getSearchOrg($_GET['query']);
            }
        }
    }
    public function uploadLogo($path){
        $logoName = $path['name'];
        $logoExt = $path['type'];
        $LogoSize = $path['size'];
        $logoName = filter_var($logoName, FILTER_SANITIZE_STRING);
        $logo_ext = pathinfo($logoName, PATHINFO_EXTENSION);
        $rename_logo = create_unique_id().'.'.$logo_ext;
        $logo_tmp_name = $path['tmp_name'];
        $image_folder = '../uploads/'.$rename_logo;
        if($LogoSize>5*1024*1024){
            return "too big";
        }
        if(move_uploaded_file($logo_tmp_name, $image_folder)){
            return $rename_logo;
        }
        else{
            return "error";
        }
    }
}


?>