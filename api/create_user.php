<?php

include("../php/connection.php");
include("../php/functions.php");

require  __DIR__ . '/sanitization.php';



$fields = [
    'email' => 'email',
    'pass' => 'string',
    'utype' => 'int'
];


$data = sanitize($_POST, $fields);
$email = $data['email'];
$password = $data['pass'];
$utype = $data['utype'];
$creatordata = check_login($con);
echo json_encode($creatordata);
if ($creatordata['can_add'][$utype] == 1) {
    $uid = time() . random_num(5);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $multiple = getdata($email);
    if (!$multiple) {

        if (!empty($email) && !empty($password) && !empty($utype)) {

            //save to database
            $query = "insert into auth (uid,email,pass,utype,createdby,status) values ('$uid','$email','$hash','$utype','{$creatordata['uid']}','active')";

            $result = mysqli_query($con, $query);
            echo json_encode($result);
        } else {
            echo "Please enter some valid information!";
        }
    } else{
        echo "User Already Exists ";
    }
} else {
    echo "You cannot add a user with previlage level equal or more";
}
