<?php

include("../php/connection.php");
include("../php/functions.php");

require  __DIR__ . '/sanitization.php';



$fields = [
    'email' => 'email',
    'setstate' => 'string'
];

//SAMPLE INPUT
//email=admin@biller.com
//setstate='blocked'/'active'
$data = sanitize($_POST, $fields);
$email = $data['email'];
$setstate = $data['setstate'];
$creatordata = check_login($con);
$utype = "";
$getutype = "select utype from auth where email='$email'";

$check = mysqli_query($con, $getutype);
if ($check && mysqli_num_rows($check) > 0) {
    $user_data = mysqli_fetch_assoc($check);
    $utype = $user_data['utype'];
} else {
    echo "User Previlage Error";
    die;
}

if ($creatordata['can_block'][$utype] == 1) {
    if (!empty($email) && !empty($setstate)) {

        //save to database
        if ($setstate == 'block') {
            $query = "UPDATE auth SET status='blocked' WHERE email='$email'";
        }
        if ($setstate == 'active') {
            $query = "UPDATE auth SET status='active' WHERE email='$email'";
        }

        $result = mysqli_query($con, $query);
        echo json_encode($result);
    } else {
        echo "Please enter some valid information!";
    }
} else {
    echo "You cannot block/unblock a user with previlage level equal or more";
}
