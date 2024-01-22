<?php

    $servername="localhost";
    $username="root";
    $password="";
    $db="rabia_modal";


    $conn = mysqli_connect($servername,$username,$password,$db);

    if($conn)
    {
        echo "connected";
    }
    else {
        // # code...
        echo "failed";
    }

?>
