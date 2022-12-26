<?php

include("../php/connection.php");
include("../php/functions.php");

require  __DIR__ . '/sanitization.php';



$fields = [
    'product_name' => 'string',
    'product_info'=>'string',
    'price' => 'int',
    'discount_amount' => 'int',
    'discount_till' => 'string',
    'discount_type'=>'string'
];


$data = sanitize($_POST, $fields);
var_dump($data);
$product['name'] = $data['product_name'];
$product['info'] = $data['product_info'];
$product['price'] = $data['price'];
$product['discount']['amount'] = $data['discount_amount'];
$product['discount']['till'] = $data['discount_till'];
$product['discount']['type'] = $data['discount_type'];
$creatordata = check_login($con);
$product=json_encode($product);
echo json_encode($creatordata);
if ($creatordata['products']== 1) {
    $pid = time() . random_num(5);
    $multiple = "select product_name from products where product_name='{$data['product_name']}' ";
    $check = mysqli_query($con, $multiple);
    if ($check && mysqli_num_rows($check) == 0) {

        if (!empty($product)) {

            //save to database
            $query = "insert into products (pid,product_name,pdata,createdby) values ('$pid','{$data['product_name']}','$product','{$creatordata['uid']}')";

            $result = mysqli_query($con, $query);
            echo json_encode($result);
        } else {
            echo "Please enter some valid information!";
        }
    } else{
        echo "Product Already Exists ";
    }
} else {
    echo "You cannot add a user with previlage level equal or more";
}

