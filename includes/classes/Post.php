<?php 
    class Post {

        private $con;
        private $invalidEmail;

        public function __construct($con) {
            $this->con = $con;
            $this->invalidEmail = array();
        }

        public function createMessage($fn, $bd, $em, $text) {
            $this->validateEmail($em);
            echo $em;

            // if email is valid then check if full name, birthdate and text is not empty.
            if(empty($this->invalidEmail)) {
                if(!empty($fn) && !empty($text) && !empty($bd)){
                    $msgDate = date('Y-m-d H:i');
                    // add info to DataBase
                    mysqli_query($this->con, "INSERT INTO messages (fullName, birthdate, email, msg, msgDate) VALUES ('$fn', '$bd', '$em', '$text', '$msgDate')") or die(mysqli_error($this->con));
                    return true;
                } else {
                    return false;
                }  
            // if email is valid then check if not then make it empty
            } else {
                if(!empty($fn) && !empty($text) && !empty($bd)){
                    $em = "";
                    $msgDate = date('Y-m-d H:i');
                    // add info to DataBase
                    mysqli_query($this->con, "INSERT INTO messages (fullName, birthdate, email, msg, msgDate) VALUES ('$fn', '$bd', '$em', '$text', '$msgDate')") or die(mysqli_error($this->con));
                    return true;
                } else {
                    return false;
                }
            } 

        }

        private function validateEmail($em) {
            if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->invalidEmail, "invalid email");
                return;
            } 
        }
    }
?>

<!-- FullName validation = not needed
    birthdate validation = kind a needed. use date format to create date then use function to to minus todays date and get actual age (will be done in index.php)
    email validation = check if email is valid if not return empty array
    text validation not needed -->