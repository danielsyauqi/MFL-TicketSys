<?php
    session_start();
    include("config.php");

    if(isset($_SESSION['valid3'])){
        $faID = $_SESSION['ID'];
        $teamName = $_SESSION['TEAM_NAME'];
    }else{header('location:login.php');}

    if(isset($_GET['id'])) {
        echo "<script>if (confirm('Are you sure to deelte this request?')){return true;}else{event.stopPropagation(); event.preventDefault();};</script>";
        $id = $_GET['id'];
        $delete= mysqli_query($conn,"DELETE FROM TEMP_TICKET WHERE TEMP_ID = '$id'");
        if($delete){
            echo "<script>alert(\"Data deleted Successfully\")</script>";
        }
        else{
            echo "<script>alert(\"Failed!\")</script>";
        }
        echo "<script>self.history.back()</script>";
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
        <?php
            
            include("config.php");
            if (isset($_SESSION['valid3'])){
            $id = $_SESSION['ID'];
            
            $query = mysqli_query($conn,"SELECT*FROM FA WHERE FA_ID = '$id'");



            while($result = mysqli_fetch_assoc($query)){
                $res_email = $result['FA_EMAIL'];
                $res_name = $result['FA_NAME'];
                $res_pass = $result['FA_PASSWORD'];
                $res_id = $result['FA_ID'];
            
            }
            }

            $queryTicket = mysqli_query($conn,"SELECT * FROM TEMP_TICKET ORDER BY TEMP_ID DESC LIMIT 1");
            while($result = mysqli_fetch_assoc($queryTicket)){
                $res_latestTicketID = $result['TEMP_ID'];
            }
            ?>
            <header class ="header">
                <a href="../php/index.php" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="../php/index.php" >Home</a></li>
                    <li><a href="../php/standings.php">Standings</a></li>
                    <li><a href="../php/about.php">About</a>
                    </li>
                    <li><a href="#" id="user-bar" class="active">User</a>
                        <ul class="dropdown">
                            <?php
                                if(isset($_SESSION['valid3'])){
                                echo "<li><a href='edit-profile-fa.php#sec'>Edit Profile</a></li>";
                                echo "<li><a href='fa.php#sec' class= 'active' id = 'ticket-req'>Ticket Request</a></li>";
                                echo "<li><a href='sales-review-fa.php#sec'>Sales Review</a></li>";
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

            <div class="container" id="container">
                
                <section class="first">
                    <h2 id="title">MALAYSIA FOOTBALL LEAGUE</h2>
                    <p id="subtitle"><i>TICKETING SYSTEM (FOOTBALL ASSOCIATION MODE)</i></p>
                    <?php
                    if(isset($_SESSION['valid3'])){

                        echo "<p id= \"user-hola\" style=\"text-transform:uppercase\">WELCOME $res_name!</p>";
                    }
                    else{
                    echo "<p id= \"user-hola\" >WELCOME GUEST, PLEASE LOG IN FOR BOOKING THE TICKET! </p>";
                    }

                    ?>
                    <a href="#sec" id="btn" class ='btn-home' >Order Ticket</a>
                </section>

                <div class="sec" id="sec">

                    <div class="sec-title-2">
                        <h3>APPROVAL FORM</h3>
                    </div>

                    <div class= "reqbox">
                        <div class="box form-box">

                        <h1> Ticket Approval Request</h1>

                            <form action="fa-ticket.php#third" method="post">

                                <div class="field input">
                                <label for="home_team">Home Team:</label>
                                <input type="text" id="home_team" name="home_team" value="<?php echo $teamName?>" readonly>
                                </div>

                                <div class="field input">
                                <label for="away_team">Away Team:</label>

                                <select id="away-team" name="match_away" >
                                    <option value="" disabled selected>Choose away team</option>
                                    
                                    <?php 
                                    $teamQuery = mysqli_query($conn,"SELECT*FROM FA");
                                    while($result=mysqli_fetch_assoc($teamQuery)){$teamNameOption[]=$result['TEAM_NAME'];}
                                    for($i=0; $i<13; $i++){
                                        $j = $i+1;
                                            if(($i+1)==$faID){
                                                continue;
                                            }
                                            else{
                                                echo "<option value='$j'>$teamNameOption[$i] </option>";
                                            }
                                        } 
                                    ?>
                                </select>
                                </div>

                                <div class="field input">
                                <label for="match_date">Match Date:</label>
                                <input type="date" id="match_date" name="match_date">
                                </div>

                                <div class="field input">
                                <label for="match_time">Match Time:</label>
                                <input type="time" id="match_time" name="match_time">
                                </div>

                                <div class="field input">
                                <label for="match_time">Ticket Price:</label>
                                <input type="number" id="ticket_price" name="ticket_price" min="0" 
                                max="1000" step="0.01">
                                </div>

                                <div class="field input">
                                <label for="match_venue">Match Venue:</label>
                                <input type="text" id="match_venue" name="match_venue">
                                </div>

                                <div class="field">
                                    <input type="submit" class="btn" name="submit" value="Submit" onclick= "if (confirm('Are you sure to submit?')){return true;}else{event.stopPropagation(); event.preventDefault();};"required>
                                </div>

                            </form>
                            <?php
                                include("config.php");
                                if(isset($_POST['submit'])){
                                    $homeTeam= $faID;
                                    $awayTeam = $_POST['match_away'];
                                    $matchDate = $_POST['match_date'];
                                    $matchTime = $_POST['match_time'];
                                    $ticketPrice = $_POST['ticket_price'];
                                    $matchVenue = $_POST['match_venue'];
                                    $dateReq = date("Y-m-d");
                                    $timeReq = date("h:i");
                                    $status = "PENDING";

                                    $queryPost = mysqli_query($conn, "INSERT INTO TEMP_TICKET(MATCH_HOME,MATCH_AWAY,MATCH_DATE,MATCH_TIME,MATCH_PRICE,
                                    MATCH_VENUE, DATE_REQUEST,TIME_REQUEST,STATUS) VALUES( \"$homeTeam\",\"$awayTeam\",\"$matchDate\",\"$matchTime\",\"$ticketPrice\",\"$matchVenue\",\"$dateReq\",\"$timeReq\",\"$status\")") or die ("Error Occured.");
                                    if($queryPost){
                                        echo "<script>alert(\"Data Inserted Successfully\")</script>";
                                        
                                    }
                                    else{
                                        echo "<script>alert(\"Failed!\")</script>";
                                    }
                                  
                                }
                                
                            ?>
                            
                        </div>
                    </div>
                </div>
                <div class="third" id="third">
                    <div class="sec-title-2">
                        <h3>TICKET REQUESTED</h3>
                    </div>

                    <div class = 'btn-all-container'>
                    <a href="fa-ticket.php?approved#third" id="btn-all" class='btn-all'>Approved</a>";
                    <a href="fa-ticket.php?pending#third" id="btn-all" class='btn-all'>Pending</a>";
                    </div>

                    
                    <?php
                        if(isset($_GET['pending'])){
                        $queryReqTicket = mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA WHERE FA.FA_ID = TEMP_TICKET.MATCH_HOME AND FA_ID = '$res_id' AND TEMP_TICKET.STATUS = 'PENDING'");
                        $countReqTicket = mysqli_num_rows($queryReqTicket);
                        if($countReqTicket>0){
                            while($result = mysqli_fetch_assoc($queryReqTicket)){
                            echo "<div class=\"ag-courses_item\">";
                                    echo "<div class=\"ag-courses-item_link\">";
                                        echo "<div class=\"ag-courses-item_bg\"></div>";

                                        echo "<div class=\"ag-courses-item_title\">";
                                        echo $result['TEAM_NAME'];
                                        echo "vs "; 
                                        $tempID = $result['TEMP_ID'];
                                        $queryReqTicket2 = mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA WHERE FA.FA_ID = TEMP_TICKET.MATCH_AWAY AND TEMP_TICKET.TEMP_ID = $tempID");
                                        while($result2 = mysqli_fetch_assoc($queryReqTicket2)){echo $result2['TEAM_NAME'];}                    
                                        echo "</div>";
                                        echo "<div class = \"ag-course-item-desc\">";
                                        echo "Date: <b>"; echo date("d F Y", strtotime($result['MATCH_DATE'])); echo "</b>";
                                        echo "<p class=\"b2\">";
                                        echo "Date Requested: <b>";echo date("d F Y", strtotime($result['DATE_REQUEST'])); echo"</b><br>";
                                        echo "Time Requested: <b >";echo date("h:i a", strtotime($result['TIME_REQUEST'])); echo"</b><br>";
                                        echo "Status: <b class=\"status\">";echo $result['STATUS']; echo"</b><br>";
                                        echo"</b> </p>";
                                        echo "</br> Time: <b> ";
                                        echo date("h:i a", strtotime($result['MATCH_TIME']));
                                        echo "</b> </br> Venue: <b>"; 
                                        echo $result['MATCH_VENUE'];
                                        echo "</div>";
                                        echo "<div class=\"ag-courses-item_date-box\">";
                                        echo "Price: ";
                                            echo "<span class=\"ag-courses-item_date\">";
                                                echo "RM"; echo $temp_price[] = $result['MATCH_PRICE'];
                                            echo"</span>";
                                            echo "<a href=\"fa-ticket.php?id=";echo $result['TEMP_ID']; echo "\" class=\"btn-req\">";
                                            echo "<span class=\"ag-courses-item_date\">";
                                            echo "Delete Request";
                                            echo"</span>";

                                            echo "</a>";
                                        echo "</div>";
                                    echo "</div>";
                            echo "</div>";
                            }
                        }
                        }

                        else if(isset($_GET['approved'])){
                            $queryReqTicket = mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA WHERE FA.FA_ID = TEMP_TICKET.MATCH_HOME AND FA_ID = '$res_id' AND TEMP_TICKET.STATUS = 'APPROVED'");
                            $countReqTicket = mysqli_num_rows($queryReqTicket);
                            if($countReqTicket>0){
                                while($result = mysqli_fetch_assoc($queryReqTicket)){
                                echo "<div class=\"ag-courses_item\">";
                                        echo "<div class=\"ag-courses-item_link\">";
                                            echo "<div class=\"ag-courses-item_bg\"></div>";
    
                                            echo "<div class=\"ag-courses-item_title\">";
                                            echo $result['TEAM_NAME'];
                                            echo "vs "; 
                                            $tempID = $result['TEMP_ID'];
                                            $queryReqTicket2 = mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA WHERE FA.FA_ID = TEMP_TICKET.MATCH_AWAY AND TEMP_TICKET.TEMP_ID = $tempID");
                                            while($result2 = mysqli_fetch_assoc($queryReqTicket2)){echo $result2['TEAM_NAME'];}                    
                                            echo "</div>";
                                            echo "<div class = \"ag-course-item-desc\">";
                                            echo "Date: <b>"; echo date("d F Y", strtotime($result['MATCH_DATE'])); echo "</b>";
                                            echo "<p class=\"b2\">";
                                            echo "Date Requested: <b>";echo date("d F Y", strtotime($result['DATE_REQUEST'])); echo"</b><br>";
                                            echo "Time Requested: <b >";echo date("h:i a", strtotime($result['TIME_REQUEST'])); echo"</b><br>";
                                            echo "Status: <b class=\"status\">";echo $result['STATUS']; echo"</b><br>";
                                            echo"</b> </p>";
                                            echo "</br> Time: <b> ";
                                            echo date("h:i a", strtotime($result['MATCH_TIME']));
                                            echo "</b> </br> Venue: <b>"; 
                                            echo $result['MATCH_VENUE'];
                                            echo "</div>";
                                            echo "<div class=\"ag-courses-item_date-box\">";
                                            echo "Price: ";
                                                echo "<span class=\"ag-courses-item_date\">";
                                                    echo "RM"; echo $temp_price[] = $result['MATCH_PRICE'];
                                                //echo"</span>";
                                                //echo "<a href=\"fa-ticket.php?id=";echo $result['TEMP_ID']; echo "\" class=\"btn-req\">";
                                                //echo "<span class=\"ag-courses-item_date\">";
                                                //echo "Delete Request";
                                                //echo"</span>";
    
                                                echo "</a>";
                                            echo "</div>";
                                        echo "</div>";
                                echo "</div>";
                                }
                            }
                            }

                    ?>
                    </div>
                </div>
            <footer class = "footer-2">
                <div class="footer-text">
                    <h3>All Rights Reserved.</h3>
                    <a href="https://sites.google.com/view/danielsyauqi/home?authuser=0"><p>Made by Syauqi 2024.</p></a>
                </div>
            </footer>

        <?php ?>
    </body>
</html>