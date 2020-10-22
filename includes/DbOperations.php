

<?php 

/** include DbConnect.php */
require_once dirname(__FILE__).'/DbConnect.php';

class DbOperation {
   
   private $con;

    /** Initialize the object when creating it 
     *  and get connected to the database
     */
   function __construct(){
      $db = new DbConnect();
      $this->con = $db->connect();
   }

    /** CRUD OPERATIONS */

    /** Create User Function 
     *  Creating a user and inserting it in the DATABASE
    */
   public function  createUser ($username, $pass, $email) {

         /** Check if user already exist ..if so return 0 
          * else insert user in database
         */
        if ($this->isUserExist($username,$email)){
            return 0;
        }else {

            /** Hashing the password 
            *  never store plain passwords in any database
            *  we are using md5 function ..you can change it later and add more security measures if you wish to ..(salting for example)
            */
            $password = md5($pass);
            // preparing the sql query
            $stmt = $this->con->prepare("INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES (NULL, ?, ?, ?); ");
            // bind params
            $stmt->bind_param("sss",$username,$password,$email);
            // check if successfully inserted : return either 1 or 2
            if ($stmt->execute()) {
                return 1;
            }else {
                return 2;
            }

        }


   }

   /** Check if User exist Already 
    * Check if the user already exists in the DATABASE 
    * This  returns either faslse or true
   */
   private function isUserExist($username, $email){
       $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
       $stmt->bind_param("ss", $username,$email);
       $stmt->execute();
       $stmt->store_result();
       return $stmt->num_rows > 0;

   }

   /** 
    * userLogin function 
    * See if there is a record in the DATABASE with provided username and password 
    */
   public function userLogin($username, $pass){
       $password = md5($pass);
       $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
       $stmt->bind_param("ss", $username, $password);
       $stmt->execute();
       $stmt->store_result();
       return $stmt->num_rows > 0;
   }
   /** 
    * getUserByUsername funtion
    * Getting the user from the DATABASE based on the username 
   */
   public function getUserByUsername($username){
       $stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
       $stmt->bind_param("s", $username);
       $stmt->execute();
       return $stmt->get_result()->fetch_assoc();

   }
}



?> 