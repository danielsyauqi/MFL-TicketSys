<?php
    session_start();
    include("config.php");

    $todayDate=date("Y-m-d");
    if (isset($_SESSION['valid2'])){
        $id = $_SESSION['ID'];
        
        $query = mysqli_query($conn,"SELECT*FROM ADMIN WHERE ADMIN_ID = '$id'");



        while($result = mysqli_fetch_assoc($query)){
            $res_email = $result['ADMIN_EMAIL'];
            $res_username = $result['ADMIN_USERNAME'];
            $res_pos = $result['ADMIN_POSITION'];
            $res_id = $result['ADMIN_ID'];
        
        }
    }else{header('location:login.php');}


    if(isset($_GET['approve'])){
    $id = $_GET['approve'];
    
    $approveReqQuery = mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA WHERE TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TEMP_TICKET.TEMP_ID = '$id'");
    while($result = mysqli_fetch_assoc($approveReqQuery)){
        $approve_tempID = $result['TEMP_ID'];
        $approve_tempMatchHome = $result['TEAM_NAME'];
        $approve_tempMatchDate  = $result['MATCH_DATE'];
        $approve_tempMatchTime  = $result['MATCH_TIME'];
        $approve_tempMatchPrice  = $result['MATCH_PRICE'];
        $approve_tempMatchVenue  = $result['MATCH_VENUE'];
        $approve_tempFA_ID = $result['MATCH_HOME'];
    }

    $approveReqQuery2 = mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA WHERE TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TEMP_TICKET.TEMP_ID = '$id'");
    while($result = mysqli_fetch_assoc($approveReqQuery2)){
        $approve_tempMatchAway  = $result['TEAM_NAME'];
    }
    mysqli_query($conn,"INSERT INTO APPROVAL (FA_ID,ADMIN_ID,TEMP_ID) VALUES('$approve_tempFA_ID','$res_id','$id')");
    $approvalIDQuery= mysqli_query($conn,"SELECT * FROM APPROVAL WHERE TEMP_ID = '$id'");
    while($result = mysqli_fetch_assoc($approvalIDQuery)){
        $approvalID = $result['APPROVAL_ID'];
    }

    $approve= mysqli_query($conn,"INSERT INTO TICKETMATCH (APPROVAL_ID,TEMP_ID,DEPLOY) VALUES ('$approvalID','$id','UNREADY')");
    $approve2= mysqli_query($conn,"UPDATE TEMP_TICKET SET STATUS = 'APPROVED' WHERE TEMP_ID = '$id'");
    if($approve && $approve2){
        echo "<script>alert(\"Data submit successfully\")</script>";
        echo "<script>window.location.assign(\"admin-ticket.php\")</script>";
    }
    else{
        echo "<script>alert(\"Failed!\")</script>";
        echo "<script>window.location.assign(\"admin-ticket.php\")</script>";
    }
    }
    

    else if(isset($_GET['reject'])){
        $id = $_GET['reject'];

        $rejected = mysqli_query($conn, "UPDATE TEMP_TICKET SET STATUS = 'REJECTED' WHERE TEMP_ID = '$id'");
        if($rejected){
            echo "<script>alert(\"Data reject successfully\")</script>";
            echo "<script>window.location.assign(\"admin-ticket.php\")</script>";
        }
        else{
            echo "<script>alert(\"Failed!\")</script>";
            echo "<script>window.location.assign(\"admin-ticket.php\")</script>";
        }
    }

    if(isset($_GET['delete'])){
        $deleteID = $_GET['delete'];
        $deleteQuery = mysqli_query($conn,"SELECT*FROM TEMP_TICKET T, TICKETMATCH M, APPROVAL A WHERE M.TEMP_ID = T.TEMP_ID 
        AND A.TEMP_ID = T.TEMP_ID AND T.TEMP_ID = $deleteID");
        while($result = mysqli_fetch_assoc($deleteQuery)){
            $deleteStatus = $result['DEPLOY'];
            $deleteLink = $result['MATCH_URL'];
            $appID = $result['APPROVAL_ID'];
            $matchIDdelete = $result ['MATCH_ID'];
        }
        if($deleteStatus == 'READY'){
            echo "<script>alert(\"Please retract the ticket from live server!\")</script>";

        }
        else{
            $target_dir = "../img/TICKET/".$deleteLink;   
            $deleteM = mysqli_query($conn,"DELETE FROM TICKETMATCH WHERE MATCH_ID = $matchIDdelete");
            $deleteA = mysqli_query($conn,"DELETE FROM APPROVAL WHERE APPROVAL_ID = $appID");
            $deleteQ = mysqli_query($conn,"DELETE FROM TEMP_TICKET WHERE TEMP_ID = $deleteID");   
            if($deletQ && $deleteA&& $deleteM){
                if($unlink){
                    $unlink=unlink($target_dir);
                    echo "<script>alert(\"Delete succesfully!\")</script>";
                }else{echo "<script>alert(\"Delete succesfully!\")</script>";}
            }else{
                echo "<script>alert(\"Delete failed!\")</script>";}
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
            <header class ="header">
                <a href="index.php"  class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="../php/index.php" >Home</a></li>
                    <li><a href="../php/standings.php#sec">Standings</a></li>
                    <li><a href="../php/about.php">About</a></li>
                    <li><a href="#" class="active">User</a>
                        <ul class="dropdown">
                            <?php
                                if(isset($_SESSION['valid2'])){
                                echo "<li><a href='edit-profile-admin.php#sec'>Edit Profile</a></li>";
                                echo "<li><a href='#' class='active'>Ticket Profile</a></li>";
                                echo "<li><a href='sales-review-admin.php#sec'>Sales Review</a></li>";
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
                    <p id="subtitle"><i>TICKETING SYSTEM (ADMINISTRATOR MODE)</i></p>
                    <?php
                    if(isset($_SESSION['valid2'])){
                    echo "<p id= \"user-hola\" style=\"text-transform:uppercase\" >WELCOME HOME, $res_username!</p>";
                    }
                    else{
                    echo "<p id= \"user-hola\" >WELCOME GUEST, PLEASE LOG IN FOR BOOKING THE TICKET! </p>";
                    }

                    ?>
                    <a href="#sec" id="btn" class ='btn-home' >Order Ticket</a>
                </section>

                <div class="sec" id="sec">

                    <div class="sec-title-2">
                        <h3>TICKET APPROVAL REQUEST</h3>
                    </div>
                    

                    <?php
                        $queryReqTicketPending = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET WHERE TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TEMP_TICKET.STATUS = 'PENDING' ORDER BY TEMP_ID DESC");
                        $queryReqTicketPending2= mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET WHERE TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TEMP_TICKET.STATUS = 'PENDING' ORDER BY TEMP_ID DESC");
                        $countReqTicketPending = mysqli_num_rows($queryReqTicketPending);
                        while($result = mysqli_fetch_assoc($queryReqTicketPending2)){$match_away_fetch_pending[] = $result['TEAM_NAME'];}
                        $countPending=0;
                        if($countReqTicketPending>0){
                            while($result = mysqli_fetch_assoc($queryReqTicketPending)){
                            echo "<div class=\"ag-courses_item\">";
                                    echo "<div class=\"ag-courses-item_link\">";
                                        echo "<div class=\"ag-courses-item_bg\"></div>";

                                        echo "<div class=\"ag-courses-item_title\">";
                                        echo $result['TEAM_NAME'];
                                        echo " vs "; 
                                        echo $match_away_fetch_pending[$countPending];
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
                                                echo "RM"; echo $result['MATCH_PRICE'];
                                            echo"</span>";
                                            echo"<div class='container-2'>";
                                            echo "<a  href = admin-ticket.php?approve="; echo $result['TEMP_ID']; echo" class=\"btn-approve\" onclick=\"if (confirm('Are you sure to approve this request?')){return true;}else{event.stopPropagation(); event.preventDefault();};\">";
                                            echo "<span class=\"approve\">";
                                            echo "APPROVE";
                                            echo"</span>";
                                            echo "</a>";
                                            echo "<a href = admin-ticket.php?reject="; echo $result['TEMP_ID']; echo" class=\"btn-reject\" onclick=\"if (confirm('Are you sure to reject this request?')){return true;}else{event.stopPropagation(); event.preventDefault();};\">";
                                            echo "<span class=\"reject\">";
                                            echo "REJECT";
                                            echo"</span>";
                                            echo "</a>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                            echo "</div>";
                            $countPending++;
                            }
                        }
                    ?>

                </div>

                <div class = "third" id="third">

                    <div class="sec-title-2">
                        <h3>APPROVED TICKET</h3>
                    </div>
                    <div class = 'btn-all-container'>
                    <a href="admin-ticket.php?unready#third" id="btn-all" class='btn-all'>Unready</a>";
                    <a href="admin-ticket.php?ready#third" id="btn-all" class='btn-all'>Ready</a>";
                    </div>
                    


                    <?php
                        if(isset($_GET['unready'])){
                            $queryReqTicket = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID AND TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TEMP_TICKET.STATUS = 'APPROVED' AND TICKETMATCH.DEPLOY = 'UNREADY'");
                            $queryReqTicket2= mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET,TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID AND TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TEMP_TICKET.STATUS = 'APPROVED'  AND TICKETMATCH.DEPLOY = 'UNREADY'");
                            $countReqTicket = mysqli_num_rows($queryReqTicket);
                            while($result = mysqli_fetch_assoc($queryReqTicket2)){$match_away_fetch[] = $result['TEAM_NAME'];}
                            $countApproved=0;
                        if($countReqTicket>0){                                  
                            while($result = mysqli_fetch_assoc($queryReqTicket)){
                            echo "<div class=\"ag-courses_item\">";
                                    echo "<div class=\"ag-courses-item_link\">";
                                        echo "<div class=\"ag-courses-item_bg\"></div>";
                                        echo "<div class=\"ag-courses-item_title\">";
                                        echo $result['TEAM_NAME'];
                                        echo " vs "; 
                                        echo $match_away_fetch[$countApproved];
                                        echo "</div>";
                                        echo "<div class = \"ag-course-item-desc\">";
                                        echo "Date: <b>"; echo date("d F Y", strtotime($result['MATCH_DATE'])); echo "</b>";
                                        echo "<p class=\"b2\">";
                                        echo "Date Requested: <b>";echo date("d F Y", strtotime($result['DATE_REQUEST'])); echo"</b><br>";
                                        echo "Time Requested: <b>";echo date("h:i a", strtotime($result['TIME_REQUEST'])); echo"</b><br>";
                                        echo "Status: <b class=\"status\">";echo $result['STATUS']; echo"</b><br>";
                                        echo"</p>";
                                        echo "</br> Time: <b> ";
                                        echo date("h:i a", strtotime($result['MATCH_TIME']));
                                        echo "</b> </br> Price: <b>"; 
                                        echo "<span class=\"ag-courses-item_date\">";
                                                echo "RM"; echo $result['MATCH_PRICE'];
                                            echo"</span>";
                                        
                                        echo "</div>";
                                        echo "<div class=\"ag-courses-item_date-box\">";
                                        echo "Venue: ";
                                        echo $result['MATCH_VENUE'];
                                                $matchDateDelete = $result['MATCH_DATE'];
                                                echo"<div class='container-2'>";
                                                if($result['DEPLOY']=='UNREADY'){
                                                    echo "<a  href = 'admin-ticket.php?delete="; echo $result['TEMP_ID']; echo"#third' class=\"btn-delete\" onclick= \"if (confirm('Are you sure to delete?')){return true;}else{event.stopPropagation(); event.preventDefault();};\">";
                                                    echo "<span class=\"delete\">";
                                                    echo "DELETE";
                                                    echo"</span>";
                                                    echo "</a>";

                                                }      
                                                
                                                
                                            echo "<a  href = 'admin-edit-ticket.php?edit="; echo $result['TEMP_ID']; echo"#sec' class=\"btn-edit\">";
                                            echo "<span class=\"edit\">";
                                            echo $result['DEPLOY'];
                                            echo"</span>";
                                            echo "</a>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                            echo "</div>";
                            $countApproved++;
                            }
                        }
                    }
                        elseif(isset($_GET['ready'])){
                            $queryReqTicket = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID AND TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TEMP_TICKET.STATUS = 'APPROVED' AND TICKETMATCH.DEPLOY = 'READY'");
                            $queryReqTicket2= mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET,TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID AND TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TEMP_TICKET.STATUS = 'APPROVED'  AND TICKETMATCH.DEPLOY = 'READY'");
                            $countReqTicket = mysqli_num_rows($queryReqTicket);
                            while($result = mysqli_fetch_assoc($queryReqTicket2)){$match_away_fetch[] = $result['TEAM_NAME'];}
                            $countApproved=0;
                        if($countReqTicket>0){                                  
                            while($result = mysqli_fetch_assoc($queryReqTicket)){
                            echo "<div class=\"ag-courses_item\">";
                                    echo "<div class=\"ag-courses-item_link\">";
                                        echo "<div class=\"ag-courses-item_bg\"></div>";
                                        echo "<div class=\"ag-courses-item_title\">";
                                        echo $result['TEAM_NAME'];
                                        echo " vs "; 
                                        echo $match_away_fetch[$countApproved];
                                        echo "</div>";
                                        echo "<div class = \"ag-course-item-desc\">";
                                        echo "Date: <b>"; echo date("d F Y", strtotime($result['MATCH_DATE'])); echo "</b>";
                                        echo "<p class=\"b2\">";
                                        echo "Date Requested: <b>";echo date("d F Y", strtotime($result['DATE_REQUEST'])); echo"</b><br>";
                                        echo "Time Requested: <b>";echo date("h:i a", strtotime($result['TIME_REQUEST'])); echo"</b><br>";
                                        echo "Status: <b class=\"status\">";echo $result['STATUS']; echo"</b><br>";
                                        echo"</p>";
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
                                                $matchDateDelete = $result['MATCH_DATE'];
                                                echo"<div class='container-2'>";
                                                if($result['DEPLOY']=='UNREADY'){
                                                    echo "<a  href = 'admin-ticket.php?delete="; echo $result['TEMP_ID']; echo"#third' class=\"btn-delete\" onclick= \"if (confirm('Are you sure to delete?')){return true;}else{event.stopPropagation(); event.preventDefault();};\">";
                                                    echo "<span class=\"delete\">";
                                                    echo "DELETE";
                                                    echo"</span>";
                                                    echo "</a>";
                                                }
                                                
                                                
                                            echo "<a  href = 'admin-edit-ticket.php?edit="; echo $result['TEMP_ID']; echo"#sec' class=\"btn-edit\">";
                                            echo "<span class=\"edit\">";
                                            echo $result['DEPLOY'];
                                            echo"</span>";
                                            echo "</a>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                            echo "</div>";
                            $countApproved++;
                            }
                        }
                    }
                        
                        
                        

                        
                    ?>
                </div>
            </div>
            <?php
            
            ?>
            <footer class = "footer-2">
                <div class="footer-text">
                    <h3>All Rights Reserved.</h3>
                    <a href="https://sites.google.com/view/danielsyauqi/home?authuser=0"><p>Made by Syauqi 2024.</p></a>
                </div>
            </footer>
        <?php ?>
    </body>
</html>