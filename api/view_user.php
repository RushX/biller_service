<?php
include("../php/connection.php");
include("../php/functions.php");

require  __DIR__ . '/sanitization.php';



$fields = [
    'email' => 'string'
];


$data = sanitize($_POST, $fields);
$view = $data['email'];
$creatordata = check_login($con);
$user_data=getdata($view);

if ($creatordata['can_view'][$utype] == 1) {
        echo json_encode($user_data);
} else {
    echo "You cannot view a user with previlage level equal or more";
}
