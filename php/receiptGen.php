<?php
session_start();
include ('../php/config.php');
    
    if(!isset($_SESSION['credential'])){
        header("Location:index.php");
    }

    if(isset($_POST['payment'])){
        $ticketQty = $_POST['qty'];
        $matchID = $_POST['match_id'];
    }

    if (isset($_SESSION['valid'])){
    $id = $_SESSION['ID'];       
    $query = mysqli_query($conn,"SELECT*FROM CUSTOMER WHERE CUST_ID = '$id'");
    while($result = mysqli_fetch_assoc($query)){
        $res_email = $result['CUST_EMAIL'];
        $res_icname = strtoupper($result['CUST_IC_NAME']);
        $res_icnum = strtoupper($result['CUST_IC_NUM']);
        
    }

    }else{header("Location:index.php");}  

    $ticketQuery = mysqli_query($conn,"SELECT*FROM TICKETMATCH M, TEMP_TICKET T, FA F WHERE T.TEMP_ID = M.TEMP_ID
    AND F.FA_ID = T.MATCH_HOME AND M.MATCH_ID = '$matchID'");

    while($result = mysqli_fetch_assoc($ticketQuery)){
        $match_home = strtoupper($result['TEAM_NAME']);
        $match_price = $result['MATCH_PRICE'];
        $match_date = date("d F Y", strtotime($result['MATCH_DATE']));
        $match_time = date("h:i a", strtotime($result['MATCH_TIME']));
        $match_venue = strtoupper($result['MATCH_VENUE']);

        $totalPrice = $match_price*$ticketQty;
    }
    $ticketQueryAway = mysqli_query($conn,"SELECT*FROM TICKETMATCH M, TEMP_TICKET T, FA F WHERE T.TEMP_ID = M.TEMP_ID
    AND F.FA_ID = T.MATCH_AWAY AND M.MATCH_ID = '$matchID'");
    while($result2 = mysqli_fetch_assoc($ticketQueryAway)){$match_away = strtoupper($result2['TEAM_NAME']);}

    
/**
 * Created by PhpStorm.
 * User: Hitesh
 * Date: 25-Dec-17
 * Time: 7:55 PM
 */
?>
<style>
    .price{
        width: 100px;
    }
</style>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Invoice</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div id="wrap"><div>
        <h1>Checkout</h1>
        <form method="post" action="create_receipt.php">
            <fieldset>
                <legend>User Details</legend>
                <div class="col">
                    <p>
                        <label for="name">Name</label>
                        <input type="text" name="name" value="<?php echo $res_icname?>" readonly/>
                    </p>
                    <p>
                        <label for="email">Email Address</label>
                        <input type="text" name="email" value="<?php echo $res_email?>" readonly/>
                    </p>
                    <p>
                        <label for="username">IC Number</label>
                        <input type="text" name="icnum" value="<?php echo $res_icnum?>" readonly/>
                    </p>
                    <p>
                        <label for="league">League</label>
                        <input type="text" name="league" value="LIGA SUPER MALAYSIA 2024" readonly/>
                    </p>
                    <p>
                        <label for="venue">Venue</label>
                        <input type="text" name="venue" value="<?php echo $match_venue?>" readonly/>
                    </p>
                </div>
                <div class="col">
                    <p>
                        <label for="home">Home Team</label>
                        <input type="text" name="home" value="<?php echo $match_home?>" readonly/>
                    </p>
                    <p>
                        <label for="away">Away Team</label>
                        <input type="text" name="away" value="<?php echo $match_away?>" readonly/>
                    </p>
                    <p>
                        <label for="date">Date</label>
                        <input type="text" name="date" value="<?php echo $match_date?>" readonly/>
                    </p>
                    <p>
                        <label for="time">Time</label>
                        <input type="text" name="time" value="<?php echo $match_time?>" readonly/>
                    </p>
                    <?php if($ticketQty>1){
                            for($i = 0; $i<$ticketQty;$i++){
                                $ticketNum[$i]= (rand(10,10000));
                                echo "<p><input type = 'hidden' name ='ticket_id"; echo $i; echo "' value='"; echo $ticketNum[$i]; echo "'></p>";
                            }
                        }else{
                            $ticketNum= (rand(10,10000));
                            echo "<p><input type = 'hidden' name ='ticket_id0' value='"; echo $ticketNum; echo "'></p>";
                        }
                        ?>
                </div>
            </fieldset>
            <fieldset>
                <legend>Your Order</legend>
                <table>
                    <thead>
                    <tr><td>Price</td><td>Quantity</td><td></td><td>Total Price</td></tr>
                    <thead>
                    <tbody>
                    <tr>
                        <td>RM <input type='text' class = 'price' value='<?php echo $match_price; ?>' name='price' readonly/></td>
                        <td><input type='text' class = 'quantity' value='<?php echo $ticketQty; ?>' name='quantity' readonly/></td>
                        <td></td>
                        <td>RM <input type='text' class = 'totalPrice' value='<?php echo $totalPrice; ?>' name='totalPrice' readonly/></td>
                        <?php $invoiceNum=(rand(10,10000));?>
                        <input type = 'hidden' name ='invoice' value='<?php echo $invoiceNum?>'>
                        <input type = 'hidden' name='credential' value = 'true'>
                        <input type = 'hidden' name ='match_id' value=<?php echo $matchID?>>
                        
                    </tr>
                    </tbody>
                </table>
            </fieldset>
            <button type="submit" name="submit">Submit Order</button>
        </form>
    </div></div>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
<script type="text/javascript">
    $('button').click(function () {
        $.post('create_receipt.php', $('form').serialize(), function () {
            $('div#wrap div').fadeOut( function () {
                $(this).empty().html("<h2>Thank you!</h2><p>Thank you for your order. Please <a href='../cust/receipt/<?php echo $id;?>/<?php echo $invoiceNum;?>.pdf'>download your reciept</a>. </p>").fadeIn();
            });
        });
        return false;
    });
</script>
</html>