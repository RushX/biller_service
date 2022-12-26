<?php
include("../php/connection.php");
include("../php/functions.php");

require  __DIR__ . '/sanitization.php';



$fields = [
    'title' => 'string',
    'to'=>'email',
    'message' => 'string',
    'priority'=>'string'
];


$data = sanitize($_POST, $fields);
$msg['title'] = $data['title'];
$msg['message'] = $data['message'];
$priority = $data['priority'];
$reciever = $data['to'];
$creatordata = check_login($con);
$sender_uid=$creatordata['uid'];
$msg=json_encode($msg);


$user_data =getdata($reciever);

    $utype = $user_data['utype'];
    $reciever_uid=$user_data['uid'];

if ($creatordata['can_interact'][$utype] == 1) {
    $mid = time() . random_num(5);
            $query = "insert into messages (mid,sender,reciever,text,priority) values ('$mid','$sender_uid','$reciever_uid','$msg','$priority')";

            $result = mysqli_query($con, $query);
            echo json_encode($result);
} else {
    echo "You cannot send a user with previlage level equal or more";
}
