<?php 

/** include DbOperations to insert the data */
require_once '../includes/DbOperations.php';

$response = array();

/** Check if we are comming from a POST request */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Check if there we provided the right fields 
    if (isset($_POST['username']) and isset($_POST['password'])) {
        $db = new DbOperation();

        if ( $db->userLogin($_POST['username'], $_POST['password'])) {
            $user = $db->getUserByUsername($_POST['username']);
            $response['error'] = false;
            $response['id'] = $user['id'];
            $response['email'] = $user['email'];
            $response['username'] = $user['username'];

        }else {
            $response['error'] = true;
            $response['message'] = "Invalid username or Password !";
        }


    }else {
        $response['error'] = true;
        $response['message'] = "Required Fileds are missing !";
    }

} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request !";
}

echo json_encode($response);

?>