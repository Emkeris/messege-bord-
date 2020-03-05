<?php 
    @include '../config.php';
    @include '../classes/Post.php';
    $post = new Post($con);

    function sanitizeFormString($input) {
        $input = strip_tags($input);#
        $input = ucfirst(strtolower($input));
        return $input;
    }

    function sanitizeFormName($input) {
        $input = strip_tags($input);#
        $input = ucfirst($input);
        return $input;
    }

    if(isset($_POST['skelbtiBtn']))
    // skelbti Btn was pressed;
        $fullName = sanitizeFormName($_POST['fullname']);
        $birthdate = $_POST['birthdate'];
        $email = sanitizeFormString($_POST['email']);
        $message = sanitizeFormString(htmlspecialchars($_POST['message']));

        // echo $birthdate

        $SccessPost = $post->createMessage($fullName, $birthdate, $email, $message);

        if($SccessPost) {
            header("Location:../../index.php");
        }


        



?>