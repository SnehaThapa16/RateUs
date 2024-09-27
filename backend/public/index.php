<?php
require_once "../confiq/confiq.php";
require_once "../session/session.php";
require_once "../app/controllers/user.php";
require_once "../app/controllers/organization.php";


$controller="";
$action="";

if(isset($_GET['controller']) && isset($_GET['action'])) {
    $controller=$_GET['controller'];
    $action=$_GET['action'];
}elseif(isset($_POST['action'])) {
    $action=$_POST['action'];
    if($action=='register'||$action=='login'||$action=='logout'){
        $controller='users';  // Route to UsersController for user-related actions
    } 
    elseif ($action=='addOrganization') {
        $controller='organizations';  // Route to OrganizationsController
    }
}

switch($controller) {
    case 'users':
        $usersController = new UsersController($mysqli);
        $usersController->userMethods();
        break;

    case 'organizations':
        $organizationsController = new organizationConstroller($mysqli);
        if($action=='addOrganization') {
            $organizationsController->organizationMethods();
        }
        else if($action=='listOrganization'){
            $organizationsController->organizationMethods();
        }
        else if($action=='searchOrg'){
            $organizationsController->organizationMethods();
        }
        break;

    default:
        echo "No route found";
        break;
}
?>