<?php 

/** include DbOperations to insert the data */
require_once '../includes/DbOperations.php';

$response = array();

/** Check if we are comming from a POST request */
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Check if there we provided the right fields  
  if (
       isset($_POST['username']) and 
       isset($_POST['password']) and
       isset($_POST['email']))
       {
           /**
            * dealing with the data based on $result 
            * $result == 1 : inserting user in the DATABASE
            * $result == 2 : return some error occurd !
            * $result == 0 : this means user already exists in the DATABASE 
            */
           $db = new DbOperation();
           $result = $db->createUser($_POST['username'], $_POST['password'], $_POST['email'] );
           if ($result == 1) {
                $response['error'] = false;
                $response['message'] = "User Created Successfully ";
            }elseif ($result == 2) {
                $response['error'] = true;
                $response['message'] = "Some Error Occured !";
           }elseif ($result == 0){
                $response['error'] = true;
                $response['message'] = "User Already Exist .. Try to Login instead";
           }
  // return error because of the missing fields  
  }else {
      $response['error'] = true;
      $response['message'] = "Required Fileds are missing !";
  }
// return Invalid request if we aren't comming from a POST request 
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request !";
    
}

// return a json object of $response 
echo json_encode($response);

?>