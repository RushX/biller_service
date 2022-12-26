<?php

include("../php/connection.php");
include("../php/functions.php");

require  __DIR__ . '/sanitization.php';



$creatordata = check_login($con);
$sender_uid = $creatordata['uid'];




$fields = [
    'mail' => 'string',
    'due' => 'string',
];




$data = sanitize($_POST, $fields);
$mail = $data['mail'];
$user_data=getdata($mail);
$name=$user_data['user_name'];
$uid=$user_data['uid'];
$due = date('Y/m/d',strtotime($data['due']));
$arr=json_decode($_POST['products']);
$products_array=[];
$netprice=0;
$getutype = "select uid,phone,address from udat where uid='$uid'";

foreach($arr as $index => $arrays){
    $arr=[];
    // echo $arrays->quantity;
    $temp_arr=getproducts($creatordata,$arrays->name);
    $ptemp=(json_decode($temp_arr['pdata']));
    $arr['pid']=$temp_arr['pid'];
    $arr['name']=$temp_arr['product_name'];
    $arr['quantity']=$arrays->quantity;
    $arr['info']=($ptemp->info);
    $arr['price']=($ptemp->price);
    $arr['total']=($arrays->quantity)*($ptemp->price);
    array_push($products_array,$arr);

    var_dump($products_array);
}
foreach($products_array as $index=>$product){
    $netprice=$netprice+$product['total'];
}
$check = mysqli_query($con, $getutype);
if ($check && mysqli_num_rows($check) > 0) {
    $user_data = mysqli_fetch_assoc($check);
    $bill_data['address'] = json_decode($user_data['address']);
    $bill_data['phone'] = $user_data['phone'];
    $bill_data['email'] = $mail;
    $bill_data['username'] =$name;
    $bill_data['products_data']=$products_array;
    $bill_data['uid'] = $user_data['uid'];
    $billing_date = date('Y/m/d');
    $bill_data['pretax_amount']= $netprice;
    $bill_data['cgst']= 9%$bill_data['pretax_amount'];
    $bill_data['sgst']= 9%$bill_data['pretax_amount'];
    $bill_data['final_amount']= $netprice+$bill_data['cgst']+$bill_data['sgst'];
    $bill_data=json_encode($bill_data);
    // var_dump($bill_data);

} else {
    echo "User Previlage Error";
    die;
}

if ($creatordata['billing'] == 1) {
    $bid = time() . random_num(5);
    $query = "insert into bills (bid,uid,date,due,bill_data,status,createdby) values ('$bid','{$user_data['uid']}','$billing_date','$due','$bill_data','unpaid','{$creatordata['uid']}')";
    echo $query;
    $result = mysqli_query($con, $query);
    echo json_encode($result);
} else {
    echo "You cannot send a user with previlage level equal or more";
}
