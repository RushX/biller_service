<?php
include("./php/connection.php");
include("./api/sanitization.php");
include("./php/functions.php");


$data=check_login($con);

if($data['utype']=="1"){
    header("Location: superadmin/index.php");
}
elseif($data['utype']=="2"){
    header("Location: admin/index.php");
}
elseif($data['utype']=="3"){
    header("Location: manager/index.php");
}
elseif($data['utype']=="4"){
    header("Location: user/index.php");
}
else{
    header("Location: login.php");

}