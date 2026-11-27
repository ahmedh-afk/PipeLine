<?php
    session_start();
    $_SESSION=[];
    session_destroy();
    header("location: index.php");
    exit;
    /*the "click" part is html: 
    the logout button is just a link,
    <a href="logout.php">Log out</a>. 
    click it, the page loads, php runs, they're out and redirected
    */
?>