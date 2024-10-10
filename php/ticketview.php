<?php
    session_start();
    include("config.php");

    $_SESSION['credential'] = 'false';
    if (isset($_SESSION['valid'])){
        $id = $_SESSION['ID'];
        
        $query = mysqli_query($conn,"SELECT*FROM CUSTOMER WHERE CUST_ID = '$id'");



            while($result = mysqli_fetch_assoc($query)){
                $res_email = $result['CUST_EMAIL'];
                $res_icname = $result['CUST_IC_NAME'];
                $res_icnum = $result['CUST_IC_NUM'];
                $res_id = $result['CUST_ID'];
            
            }
    }else{header('location:login.php');}


    if(isset($_GET['view'])){
    $id = $_GET['view'];
    
        $viewQuery = mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA,TICKETMATCH WHERE TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TICKETMATCH.TEMP_ID = TEMP_TICKET.TEMP_ID AND TICKETMATCH.MATCH_ID = '$id'");
        while($result = mysqli_fetch_assoc($viewQuery)){
            $viewID = $result['TEMP_ID'];
            $viewMatchHome = $result['TEAM_NAME'];
            $viewMatchDate  = $result['MATCH_DATE'];
            $viewMatchTime  = $result['MATCH_TIME'];
            $viewMatchPrice  = $result['MATCH_PRICE'];
            $viewMatchVenue  = $result['MATCH_VENUE'];
            $viewFA_ID = $result['FA_ID'];
        }
        $viewQuery= mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA WHERE TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TEMP_TICKET.TEMP_ID = '$id'");
        while($result = mysqli_fetch_assoc($viewQuery)){$viewMatchAaway= $result['TEAM_NAME'];}

    }


    
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            MFL TICKET</title>
            <link rel="stylesheet" href= "../css/style.css?<?php echo time(); ?>">
            <script src="../js/script.js" defer></script>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
    </head>
    <body>
        <div class="banner">
            <header class ="header">
                <a href="index.php" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="../php/index.php" >Home</a></li>
                    <li><a href="../php/standings.php#sec">Standings</a></li>
                    <li><a href="../php/about.php">About</a>
                    </li>
                    <li><a href="#" class="active">User</a>
                        <ul class="dropdown">
                            <?php
                                if(isset($_SESSION['valid'])){
                                    echo "<li><a href='edit-profile-cust.php#sec'>Edit Profile</a></li>";
                                    echo "<li><a href='ticketCust.php#sec'>Ticket</a></li>";
                                    echo "<li><a href='logout.php'>Log Out</a></li>";
                                }
                            else{
                                echo "<li><a href='login.php'>Log In</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </header>

            <div class="container">

                <section class="first">
                    <h2 id="title">MALAYSIA FOOTBALL LEAGUE</h2>
                    <p id="subtitle"><i>TICKETING SYSTEM</i></p>
                    <?php
                    if(isset($_SESSION['valid'])){
                    echo "<p id= \"user-hola\" style=\"text-transform:uppercase\" >WELCOME HOME, $res_icname!</p>";
                    }
                    else{
                    echo "<p id= \"user-hola\" >WELCOME GUEST, PLEASE LOG IN FOR BOOKING THE TICKET! </p>";
                    }

                    ?>
                    <a href="#sec" id="btn" class ='btn-home' >Order Ticket</a>
                </section>

                <div class="sec" id="sec">

                    <div class="sec-title-2">
                        <h3>TICKET PAYMENT</h3>
                    </div>

                    <?php
                        $queryReqTicket = mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA,TICKETMATCH WHERE TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TICKETMATCH.TEMP_ID = TEMP_TICKET.TEMP_ID AND TICKETMATCH.MATCH_ID = '$id'");
                        $queryReqTicket2= mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA,TICKETMATCH WHERE TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TICKETMATCH.TEMP_ID = TEMP_TICKET.TEMP_ID AND TICKETMATCH.MATCH_ID = '$id'");
                         while($result = mysqli_fetch_assoc($queryReqTicket2)){$match_away_fetch= $result['TEAM_NAME'];}
                        $countReqTicket = mysqli_num_rows($queryReqTicket);
                        if($countReqTicket>0){
                            while($result = mysqli_fetch_assoc($queryReqTicket)){
                            echo "<div class=\"ag-courses_item-2\">";
                                    echo "<div class=\"ag-courses-item_link-2\">";
                                        echo "<div class=\"ag-courses-item_bg-2\" ></div>";

                                        echo "<div class=\"ag-courses-item_title\">";
                                        echo $result['TEAM_NAME'];
                                        echo " vs "; 
                                        echo $match_away_fetch;
                                        echo "</div>";
                                        echo "<div class = \"ag-course-item-desc\">";
                                        echo "Date: <b>"; echo date("d F Y", strtotime($result['MATCH_DATE'])); echo "</b>";
                                        echo "</br> Time: <b> ";
                                        echo date("h:i a", strtotime($result['MATCH_TIME']));
                                        echo "</b> </br> Venue: <b>"; 
                                        echo $result['MATCH_VENUE'];
                                        echo "</div>";
                                        echo "<div class=\"ag-courses-item_date-box\">";
                                        echo "Price: ";
                                            echo "<span class=\"ag-courses-item_date\">";
                                                echo "RM"; echo $result['MATCH_PRICE'];
                                            echo"</span>";
                                            echo "<p class='qty-title'>Quantity:</p>";
                                            echo "<form action = 'receiptGen.php' method='post' class='form-qty'>";
                                            echo "<input type='number' class='ticket-qty' name='qty' min='0' max='1000' step='1'>";
                                            echo "<input type='hidden' name='match_id' value='";echo $result['MATCH_ID']; echo"'>";
                                            echo "<button type='submit' name ='payment' class=\"btn-payment\" onclick=\"if (confirm('Are you confirm with the payment?')){return true;}else{event.stopPropagation(); event.preventDefault();};\">";
                                            echo "<span class=\"payment\">";
                                            echo "CONFIRM PAYMENT";
                                            echo"</span>";
                                            echo "</button>";
                                            echo "</form>";
                                            
                                        echo "</div>";
                                    echo "</div>";
                            echo "</div>";
                            }
                        }
                    ?>

                </div>
            </div>
            <?php
            
            ?>
            <footer class = "footer-1">
                <div class="footer-text">
                    <h3>All Rights Reserved.</h3>
                    <a href="https://sites.google.com/view/danielsyauqi/home?authuser=0"><p>Made by Syauqi 2024.</p></a>
                </div>
            </footer>
        <?php ?>
    </body>
</html>