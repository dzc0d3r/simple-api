<?php


class DbConnect {
    
    /** declare a connection var to return ot later */
    private $con;
    /**
     * Initialize the object when creating it
     */
    function __construct() {

    }

    /** Function to connect to the database */
    function connect() {
        
        /** Include Contants.php where the connection params resides */
        include_once dirname(__FILE__).'/Constants.php';
        
        /** connect using mysqli */
        $this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        /** Check for errors and print them if any */
        if (mysqli_connect_errno()){
          echo "Failed to connect to databse".mysqli_connect_err();

        }
        /** lastly return the connection */
        // TODO: Don't forget to close connection later in wehn dealing with the db
        return $this->con;
    }

}


?>