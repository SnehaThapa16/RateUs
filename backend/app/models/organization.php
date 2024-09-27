<?php
// require_once "../confiq/confiq.php";
require_once "../session/session.php";
class organization{
    private $mysqli;
    public function __construct($mysqli){
        $this->mysqli=$mysqli;
    }
    public function addOrganization($id,$name,$address,$owner_id,$logo){

        $query = "INSERT INTO organisation (id,name,address,owner_id,logo) VALUES(?,?,?,?,?)";
        $stmt=$this->mysqli->prepare($query);
        $stmt->bind_param("sssss",$id,$name,$address,$owner_id,$logo);
        if($stmt->execute()){
            return true;
        }
        else{
            echo "Error : ".$this->mysqli->error;
            return false;
        }
    }
    public function getAllOrganizations(){
        Session::start();
        $owner=Session::get('id');
        $query="SELECT Name,Address,Logo FROM organisation WHERE owner_id=?";
        $stmt=$this->mysqli->prepare($query);
        $stmt->bind_param("s",$owner);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows>0){
            $stmt->bind_result($name,$address,$logo);
            $organizations=[];
            while($stmt->fetch()){
                $organizations[]=[
                    'name'=>$name,
                    'address'=>$address,
                    'logo'=>$logo
                ];
            }
            echo json_encode([
                'status'=>'success',
                'data'=>$organizations
            ]);
        }
        else{
            echo json_encode([
                'status' => 'Warning',
                'message'=>'No such organization found'
            ]);
        }
    }
    public function getSearchOrg($query){
        $sql="SELECT ID,Name FROM organisation WHERE NAME LIKE ?";
        $stmt=$this->mysqli->prepare($sql);
        $new_query=$query.'%';
        $stmt->bind_param("s",$new_query);      
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows>0){
            $stmt->bind_result($id,$name);
            $response=[];
            while($stmt->fetch()){
                $response[]=['id'=>$id,'name'=>$name];
            }
            echo json_encode([
                'status'=>'success',
                'data'=>$response
            ]);
        }
        else{
            echo json_encode([
                'status'=>'success',
                'message'=>'No Search Result'
            ]);
        }
    }
}

?>