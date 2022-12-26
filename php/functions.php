<?php

session_start();
function check_login($con)
{
	if (isset($_SESSION['uid'])) {
		$prevarr = [];

		$id = $_SESSION['uid'];
		$query = "select * from auth where uid = '$id' limit 1";

		$result = mysqli_query($con, $query);
		if ($result && mysqli_num_rows($result) > 0) {

			$prevarr = mysqli_fetch_assoc($result);
		}

		$query = "select uprev from previlages where previd ='$prevarr[utype]' limit 1";
		$result = mysqli_query($con, $query);
		if ($result && mysqli_num_rows($result) > 0) {
			$array = mysqli_fetch_assoc($result);
			$arr = (array) json_decode($array['uprev']);
			$prevarr['can_add'] = (array) ($arr['can_add']);
			$prevarr['can_view'] = (array) ($arr['can_view']);
			$prevarr['can_block'] = (array) ($arr['can_block']);
			$prevarr['can_interact'] = (array) ($arr['can_interact']);
			$prevarr['products'] = $arr['products'];
			$prevarr['billing_history'] = $arr['billing_history'];
			$prevarr['billing'] = $arr['billing'];
			$prevarr['generate_bill'] = $arr['generate_bill'];
			return $prevarr;
		} else {
			echo "Previlage Error";
			die;
		}
	}

	//redirect to login

	echo "ERROR";
	// header("Location: /login.php");
	die;
}

function getproducts($creatordata, $product_name = "")
{
	$prevarr = [];
	require("connection.php");
	if ($creatordata['utype'] == 1) {
		if ($product_name == "") {
			$query = "select * from products ";
		} else {
			$query = "select * from products where product_name='$product_name' ";
		}
		$result = mysqli_query($con, $query);
		if ($result && mysqli_num_rows($result) > 0) {
			$prevarr = mysqli_fetch_assoc($result);
			return ($prevarr);
		}
	} else {
		if ($product_name != "") {
			$multiple = "select * from products where createdfor='{$creatordata['email']}' ";
		} else {
			$multiple = "select * from products where createdfor='{$creatordata['email']}' and product_name='$product_name' ";
		}
		$result = mysqli_query($con, $multiple);
		if ($result && mysqli_num_rows($result) > 0) {
			$prevarr = mysqli_fetch_assoc($result);
			return ($prevarr);
		}
	}
	return null;
}


function getdata($mail)
{
	require("connection.php");
	$creatordata = check_login($con);
	$getutype = "select * from auth where email='$mail'";
	
	$check = mysqli_query($con, $getutype);
	if ($check && mysqli_num_rows($check) > 0) {
		$user_data = mysqli_fetch_assoc($check);
		return $user_data;
	} else {
		return false;
	}
}

function number_to_word( $num = '' )
{
    $num    = ( string ) ( ( int ) $num );
   
    if( ( int ) ( $num ) && ctype_digit( $num ) )
    {
        $words  = array( );
       
        $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
       
        $list1  = array('','one','two','three','four','five','six','seven',
            'eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen');
       
        $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
            'seventy','eighty','ninety','hundred');
       
        $list3  = array('','thousand','million','billion','trillion',
            'quadrillion','quintillion','sextillion','septillion',
            'octillion','nonillion','decillion','undecillion',
            'duodecillion','tredecillion','quattuordecillion',
            'quindecillion','sexdecillion','septendecillion',
            'octodecillion','novemdecillion','vigintillion');
       
        $num_length = strlen( $num );
        $levels = ( int ) ( ( $num_length + 2 ) / 3 );
        $max_length = $levels * 3;
        $num    = substr( '00'.$num , -$max_length );
        $num_levels = str_split( $num , 3 );
       
        foreach( $num_levels as $num_part )
        {
            $levels--;
            $hundreds   = ( int ) ( $num_part / 100 );
            $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
            $tens       = ( int ) ( $num_part % 100 );
            $singles    = '';
           
            if( $tens < 20 ) { $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' ); } else { $tens = ( int ) ( $tens / 10 ); $tens = ' ' . $list2[$tens] . ' '; $singles = ( int ) ( $num_part % 10 ); $singles = ' ' . $list1[$singles] . ' '; } $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' ); } $commas = count( $words ); if( $commas > 1 )
        {
            $commas = $commas - 1;
        }
       
        $words  = implode( ', ' , $words );
       
        $words  = trim( str_replace( ' ,' , ',' , ucwords( $words ) )  , ', ' );
        if( $commas )
        {
            $words  = str_replace( ',' , ' and' , $words );
        }
       
        return $words;
    }
    else if( ! ( ( int ) $num ) )
    {
        return 'Zero';
    }
    return '';
}


function random_num($length)
{

	$text = "";
	if ($length < 5) {
		$length = 5;
	}

	$len = rand(4, $length);

	for ($i = 0; $i < $len; $i++) {
		# code...

		$text .= rand(0, 9);
	}

	return $text;
}
