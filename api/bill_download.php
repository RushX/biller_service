<?php

use Razorpay\Api\Api;
include "/Apps/XAMPP/htdocs/php/functions.php";
include "/Apps/XAMPP/htdocs/php/connection.php";
include "../api/RazorPay/Razorpay.php";
require  __DIR__ . '/sanitization.php';
$creatordata = check_login($con);

$fields = [
    'bid' => 'int',
    'mail' => 'string'
];


$data = sanitize($_POST, $fields);
$data['bid'] = 167200029794708;
$data['mail'] = 'user@biller.com';
$mail = $data['mail'];

$data = getdata($mail);

if ($creatordata['generate_bill'] == 1) {
    $multiple = "select * from bills where uid='{$data['uid']}' ";
    $check = mysqli_query($con, $multiple);
    if ($check && mysqli_num_rows($check) > 0) {
        $billing_data = mysqli_fetch_assoc($check);
        $bill_info = (array) json_decode($billing_data['bill_data']);
        $product_info = (($bill_info['products_data']));
    } else {
        echo "Billing Data not found";
        die;
    }
} else {
    echo "Unauthorized";
}

if ($creatordata['utype'] == 1) {



    $key_id = "rzp_test_rhMIjUVvMXbyMb";
    $key_secret = "Uyr1YPlxO92oFAVI75IMf5dH";
    $api = new Api($key_id, $key_secret);

    $orderData = [
        'receipt'         => $billing_data['bid'],
        'amount'          => (int) ($bill_info['final_amount'] . "00"),
        'currency'        => 'INR',
    ];
    $razorpayOrder = $api->order->create($orderData);
    $razorpayOrderId = $razorpayOrder['id'];

    $_SESSION['orderid'] = $razorpayOrderId;

    $rzpdata = [
        "key"               => $key_id,
        "amount"            => $razorpayOrder['amount'],
        "name"              => "Biller",
        "description"       => "Bill Payment for order {$billing_data['bid']}",
        "prefill"           => '0',
        "name"              => "{$bill_info['email']}",
        "email"             => "{$bill_info['username']}",
        "contact"           => "{$bill_info['phone']}",
        "notes"             => '',
        "address"           => "",
        "merchant_order_id" => "{$billing_data['bid']}",
        "theme"             => '',
        "color"             => "#99cc33",
        "order_id"          => $razorpayOrderId,

    ];


    $razorpayOrderId = $_SESSION['orderid'];
    $address_data = (array) $bill_info['address'];
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF GENERATION</title>
</head>

<body>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins&family=Ubuntu&display=swap');
        </style>
        <style>
            html {
                font-family: 'Poppins';
            }

            body {
                height: max-content;
            }

            .header {
                display: flex;
                margin-top: 50px;
                flex-direction: column;
                align-items: center;
                padding: 0px;
                position: relative;
            }

            .header h1 {
                margin: 0%;
            }

            .head_name {
                font-family: 'Poppins';
                font-style: normal;
                letter-spacing: 0.07em;
            }

            .head_sub {
                font-family: 'Poppins';
                font-style: normal;
                font-weight: 400;
            }

            .user_holder {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                padding: 0px;
                gap: 3px;

                position: relative;
                margin-left: 40px;

            }

            .user_holder p {
                margin: 4px;
            }

            .due_holder {
                display: flex;
                flex-direction: row;
                align-items: flex-start;
                padding: 10px;
                gap: 10px;
                margin-left: 37px;

                position: relative;

            }

            .table_holder {
                height: max-content;
                margin: 50px;
                position: relative;
                justify-content: center;
                display: flex;
                flex-wrap: wrap;
            }

            .table {
                border: solid;
                width: 50%;
            }

            table,
            td,
            th {
                border: 1px solid #ddd;
                text-align: left;
            }

            table {
                border-collapse: collapse;
            }

            th,
            td {
                padding: 15px;
                text-align: left;
            }

            .calc {
                margin-top: 40px;
                width: 100%;
                display: flex;
                flex-direction: column;
                flex-wrap: wrap;
                align-content: flex-end;
                gap: 2px;

            }

            .calc p {
                margin: 4px;
            }

            .ack {
                position: relative;
                margin-top: 20px;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-content: center;
            }

            .ack p {
                margin: 5px;
                font-size: 15px;
                margin-left: 50px;
            }

            .footer {
                display: flex;
                margin-top: 30px;
                flex-direction: column;
                align-items: center;
            }

            .footer h3,
            h6 {
                margin: 0;
            }

            .left {
                align-content: center;
                display: grid;
            }

            .rzp {
                display: flex;
                align-content: center;
                justify-content: center;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h1 class="head_name">BILLER.COM</h1>
            <h3 class="head_sub">ORDER INVOICE</h3>
        </div>
        <div class="user_holder">
            <p><b><?php echo  $bill_info['username'] ?></b></p>
            <p><?php echo ($address_data['house']) ?>,</p>
            <p><?php echo ($address_data['street']) ?>,</p>
            <p><?php echo ($address_data['landmark']) ?>,</p>
            <p><?php echo ($address_data['city']) ?>,</p>
            <p><?php echo ($address_data['district']) . ", " . $address_data['state'] . ", " . $address_data['pin'] ?></p>
        </div>
        <b class="due_holder">Due Date: <?php echo $billing_data['due'] ?></b>
        <div class="table_holder">
            <table class="table">
                <tbody>

                    <tr>
                        <th>Sr</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                    <?php
                    foreach ($product_info as $index => $product) { ?>
                        <tr>
                            <td><?php echo $product->pid ?></td>
                            <td><?php echo $product->name ?></td>
                            <td><?php echo $product->info ?></td>
                            <td>₹<?php echo $product->price ?></td>
                            <td><?php echo $product->quantity ?></td>
                            <td>₹<?php echo $product->total ?></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="calc">
            <p>Amount:₹<?php echo  $bill_info['pretax_amount'] ?></p>
            <p>CGST(9%):₹<?php echo  $bill_info['cgst'] ?></p>
            <p>SGST(9%):₹<?php echo  $bill_info['sgst'] ?></p>
            <p>Net Bill:₹<?php echo  $bill_info['final_amount'] ?></p>
            <p>In Words: <?php
                            echo number_to_word($bill_info['final_amount']) . ' Only' ?></p>
        </div>

        <div class="rzp">
        <?php if($billing_data['status']==="unpaid"){?>
            <button id="pay_init">Pay</button>
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <script>
                options = <?php echo json_encode($rzpdata);?>;
                options.handler = function(response) {
                    var id = response.razorpay_payment_id;
                    var sign = response.razorpay_signature;
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                };
                options.theme.image_padding = false;

                var rzp = new Razorpay(options);

                document.getElementById('pay_init').onclick = function(e) {
                    rzp.open();
                    e.preventDefault();
                }
            </script>
            <?php } ?>
            <?php if($billing_data['status']==="await"){?>
                Awaited Admin Approval
                <?php }?>
            <?php if($billing_data['status']==="paid"){?>
                
                Payment Successful <br>
                Payment Id: <?php echo $billing_data['pay_id'];?>
                                <?php }?>
        </div>

        <form action="" method="post" hidden>
            <input name='bid' id="bid" value="<?php echo $billing_data['bid']?>"></input>
            <input name='razorpay_payment_id' id="razorpay_payment_id"></input>
            <input name='razorpay_signature' id="razorpay_signature"></input></form>
        </form>
        <div class="ack">
            <div class="left">
                <p>Biller.com</p>
                <p>GSTIN 22AA0000XYZY</p>
                <p>HDFC Bank 6110192761909</p>
            </div>
            <div class="right">
                <div class="signature">
                    <div class="img"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAACDCAYAAAG/wGSnAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NTc3MiwgMjAxNC8wMS8xMy0xOTo0NDowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpkODkwZGE4Mi0yN2RiLTRlMzMtYjIzYS1iZjI1YjdkMjY5ODAiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODQxRjA3N0I3RUIzMTFFNUFENzNGMzAwQjUxQThDNzUiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODQxRjA3N0E3RUIzMTFFNUFENzNGMzAwQjUxQThDNzUiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4YWMxNTgxZC0xYjEyLTRhNjgtOWRhOC0xM2E5YmY1ZWZkOTYiIHN0UmVmOmRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDpkODFkYTM1YS1jNzE3LTExNzgtOTAz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" alt="" srcset=""></div>
                    <div class="text">
                        <?php echo $billing_data['createdby'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <h3>Thanks for shopping with us</h3>
            <h6>Please pay the bill before due date to avoid extra charges</h6>
        </div>
    </body>

    </html>

</body>

</html>