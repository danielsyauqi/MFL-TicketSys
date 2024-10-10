<?php
    session_start();
    include("config.php");

    if (isset($_SESSION['valid'])){
        $id = $_SESSION['ID'];
        
        $query = mysqli_query($conn,"SELECT*FROM CUSTOMER WHERE CUST_ID = '$id'");
            while($result = mysqli_fetch_assoc($query)){
                $res_email = $result['CUST_EMAIL'];
                $res_icname = $result['CUST_IC_NAME'];
                $res_icnum = $result['CUST_IC_NUM'];
            
            }
    } else{header('location:index.php');}


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
                                    echo "<li><a href='#' class='active'>Ticket</a></li>";
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
                        <h3>UPCOMING TICKET</h3>
                    </div>

                    <?php
                        $queryHome = mysqli_query($conn,"SELECT * FROM PAYMENT P, TICKETMATCH M, FA F, TEMP_TICKET T WHERE
                        P.MATCH_ID = M.MATCH_ID AND
                        M.TEMP_ID = T.TEMP_ID AND
                        T.MATCH_HOME = F.FA_ID AND
                        CUST_ID = $id ORDER BY T.MATCH_DATE DESC");

                        $queryAway = mysqli_query($conn,"SELECT * FROM PAYMENT P, TICKETMATCH M, FA F, TEMP_TICKET T WHERE
                        P.MATCH_ID = M.MATCH_ID AND
                        M.TEMP_ID = T.TEMP_ID AND
                        T.MATCH_AWAY = F.FA_ID AND
                        CUST_ID = $id ORDER BY T.MATCH_DATE DESC");

                        while($result = mysqli_fetch_assoc($queryAway)){$matchAway[] = $result['TEAM_NAME'];}
                        $count=0;
                            while($result = mysqli_fetch_assoc($queryHome)){
                            echo "<div class=\"ag-courses_item\">";
                                    echo "<div class=\"ag-courses-item_link\">";
                                        echo "<div class=\"ag-courses-item_bg\"></div>";

                                        echo "<div class=\"ag-courses-item_title\">";
                                        echo $result['TEAM_NAME'];
                                        echo " vs "; 
                                        echo $matchAway[$count];
                                        echo "</div>";
                                        echo "<div class = \"ag-course-item-desc\">";
                                        echo "Date: <b>"; echo date("d F Y", strtotime($result['MATCH_DATE'])); echo "</b>";
                                        echo "<p class=\"b2\">";
                                        echo "Invoice Number: <b>";echo $result['PAYMENT_ID']; echo"</b><br>";
                                        echo "Quantity: <b >";echo $result['TICKET_QTY']; echo"</b><br>";
                                        echo"</b> </p>";
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
                                            echo "<a href = ../cust/receipt/";echo $id; echo "/"; echo $result['PAYMENT_ID']; echo".pdf class=\"btn-download\" download>";
                                            echo "<span class=\"download\">";
                                            echo "DOWNLOAD TICKET";
                                            echo"</span>";
                                            echo "</a>";
                                        echo "</div>";
                                    echo "</div>";
                            echo "</div>";
                            $count++;
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