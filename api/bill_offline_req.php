<?php 
include("../php/connection.php");
include("../php/functions.php");

require  __DIR__ . '/sanitization.php';


$creatordata = check_login($con);
if ($creatordata['utype']==3){   
    $pid = time() . random_num(5);
    $query="UPDATE bills SET status='await',pay_id='$pid' WHERE bid='{$_POST['bid']}'" ;
    mysqli_query($con, $query);
}