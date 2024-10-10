<?php
    session_start();
    include("config.php");
 


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

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];

        $queryCount = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID AND TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TEMP_TICKET.TEMP_ID = '$id'");
        $matchCount = mysqli_num_rows($queryCount);
        while($result = mysqli_fetch_assoc($queryCount)){
            $match_home= $result['TEAM_NAME'];
            $match_awayID = $result['MATCH_AWAY'];
            $match_date = $result['MATCH_DATE'];
            $match_time = $result['MATCH_TIME'];
            $match_price = $result['MATCH_PRICE'];
            $match_venue = $result['MATCH_VENUE'];
            $match_url = $result['MATCH_URL'];
            $match_id = $result['MATCH_ID'];
            $fa_id = $result['MATCH_HOME'];

        $queryCount2= mysqli_query($conn,"SELECT * FROM TEMP_TICKET, FA WHERE TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TEMP_TICKET.TEMP_ID = '$id'");
        while($result = mysqli_fetch_assoc($queryCount2)){$match_away= $result['TEAM_NAME'];}
        }
    
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
                    <li><a href="../php/standings.php">Standings</a></li>
                    <li><a href="../php/about.php">About</a></li>
                    <li><a href="admin-ticket.php#sec" class="active">User</a>
                        <ul class="dropdown">
                            <?php
                                if(isset($_SESSION['valid2'])){
                                echo "<li><a href='edit-profile-admin.php#sec'>Edit Profile</a></li>";
                                echo "<li><a href='admin-ticket.php#sec' class='active'>Ticket Profile</a></li>";
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
                    <a href="#sec" id="btn" class="btn-home">Order Ticket</a>
                </section>

                <div class="sec" id="sec">

                    <div class="sec-title-2">
                        <h3>EDIT TICKET</h3>
                    </div>
                    <div class= "reqbox-2">
                        <div class="box form-box">
                            <h1> Ticket Details</h1>
                            <form action="" method="post" enctype="multipart/form-data">
                    
                                <div class="field input">
                                <label for="home_team">Home Team: </label>
                                <input type="text" id="home_team" name="home_team" value= "<?php echo $match_home ?>" readonly>
                                </div>

                                <div class="field input">
                                <label for="away_team">Away Team:</label>

                                <select id="away-team" name="match_away" >
                                    <option value="<?php echo $match_awayID;?>" readonly><?php echo $match_away;?></option>
                                    
                                    <?php 
                                    $teamQuery = mysqli_query($conn,"SELECT*FROM FA");
                                    while($result=mysqli_fetch_assoc($teamQuery)){$teamNameOption[]=$result['TEAM_NAME'];}
                                    for($i=0; $i<13; $i++){

                                            if(($i+1)==$faID){
                                                continue;
                                            }
                                            else{
                                                echo "<option value='$i+1'>$teamNameOption[$i]</option>";
                                            }
                                        } 
                                    ?>
                                </select>
                                </div>

                                <div class="field input">
                                <label for="match_date">Match Date:</label>
                                <input type="date" id="match_date" name="match_date" value ="<?php echo $match_date?>" >
                                </div>

                                <div class="field input">
                                <label for="match_time">Match Time:</label>
                                <input type="time" id="match_time" name="match_time" value ="<?php echo $match_time?>">
                                </div>

                                <div class="field input">
                                <label for="match_time">Ticket Price:</label>
                                <input type="number" id="ticket_price" name="ticket_price" min="0" 
                                max="1000" step="0.01" value ="<?php echo $match_price?>">
                                </div>

                                <div class="field input">
                                <label for="match_venue">Match Venue:</label>
                                <input type="text" id="match_venue" name="match_venue" value ="<?php echo $match_venue?>">
                                </div>

                                <div class="field input">
                                <label for="match_thumbnail">Match Thumbnail:</label>
                                <input type="file" id="fileToUpload" name="fileToUpload" value ="<?php echo $match_url?>">
                                </div>

                                <div class="field">
                                    <input type="submit" class="btn" name="submit" value="Submit" onclick= "if (confirm('Are you sure to submit?')){return true;}else{event.stopPropagation(); event.preventDefault();};"required>
                                </div>
                            </form>
                        </div>
                        <?php
                            if(isset($_POST['submit'])){
                                
                            

                                if($match_away!=$_POST['match_away']){
                                    $new_match_away = $_POST['match_away'];
                                    $match_away_query=mysqli_query($conn,"UPDATE TEMP_TICKET SET MATCH_AWAY = \"$new_match_away\" WHERE TEMP_ID = $id");
                                }

                                if($match_date!=$_POST['match_date']){
                                    $new_match_date = $_POST['match_date'];
                                    $match_date_query=mysqli_query($conn,"UPDATE TEMP_TICKET SET MATCH_DATE = \"$new_match_date\" WHERE TEMP_ID = $id");
                                }

                                if($match_time!=$_POST['match_time']){
                                    $new_match_time = $_POST['match_time'];
                                    $match_time_query=mysqli_query($conn,"UPDATE TEMP_TICKET SET MATCH_TIME = \"$new_match_time\" WHERE TEMP_ID = $id");
                                }

                                if($match_price!=$_POST['ticket_price']){
                                    $new_match_price = $_POST['ticket_price'];
                                    $match_price_query=mysqli_query($conn,"UPDATE TEMP_TICKET SET MATCH_PRICE = \"$new_match_price\" WHERE TEMP_ID = $id");
                                }

                                if($match_venue!=$_POST['match_venue']){
                                    $new_match_venue = $_POST['match_venue'];
                                    $match_venue_query=mysqli_query($conn,"UPDATE TEMP_TICKET SET MATCH_VENUE = \"$new_match_venue\" WHERE TEMP_ID = $id");
                                }
                                    
                                $target_dir = "../img/TICKET/";
                                $file_name = basename($_FILES["fileToUpload"]["name"]);
                                $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
                                $tempname=$_FILES["fileToUpload"]["tmp_name"];
                                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                                $old_url = $target_dir.$match_url;

                                if($file_name!=""){
                                    $new_match_url = $file_name;
                                    if($imageFileType != "jpg" && $imageFileType != "png"){
                                        echo "<script>alert(\"Sorry, only JPG and PNG format supported.\")</script>";
                                    }
                                    else{
                                        if(file_exists($file_name)){
                                            echo "<script>alert(\"Sorry, file already exists!\")</script>";
                                        }
                                        else{
                                            mysqli_query($conn,"UPDATE TICKETMATCH SET MATCH_URL = \"$new_match_url\" WHERE TEMP_ID = $id");
                                            $upload = move_uploaded_file($tempname,$target_file);

                                            
                                            if($old_url!=null){
                                                unlink($old_url);
                                            }

                                            if($upload){
                                                echo "<script>alert(\"Succesfully uploaded!\")</script>";
                                                
                                            }else{
                                                echo "<script>alert(\"Failed!\")</script>";
                                            }
                                        }
                                    }
                                }
                                echo "<script>self.history.back()</script>";
                                
                            }
                        ?>


                    
                    <div class="container-1">
                        <div class="deploy-status">
                            <h1>PREVIEW</h1>
                            <hr>
                            <?php
                            $queryCount = mysqli_query($conn,"SELECT*FROM TICKETMATCH, TEMP_TICKET WHERE TICKETMATCH.TEMP_ID = TEMP_TICKET.TEMP_ID AND TEMP_TICKET.TEMP_ID = $id");
                            $matchCount = mysqli_num_rows($queryCount);
                            $counter = 0;
                            
                                while($result = mysqli_fetch_assoc($queryCount)){
                                    echo "<h3>Deploy Status: "; echo $result['DEPLOY'];"</h3>";
                                    echo "<form action='' method='post' style='text-align:center'>";
                                    echo "<input type=\"submit\" class=\"btn-deploy\" style='margin-right:10px' name=\"deploy\" value=\"Deploy\" onclick= \"if (confirm('Are you sure to deploy?')){return true;}else{event.stopPropagation(); event.preventDefault();};\"required>";
                                    echo "<input type=\"submit\" class=\"btn-retract\" name=\"retract\" value=\"Retract\" onclick= \"if (confirm('Are you sure to retract?')){return true;}else{event.stopPropagation(); event.preventDefault();};\"required>";
                                    echo "</form>";
                                }

                                if(isset($_POST['deploy'])){
                                    mysqli_query($conn,"UPDATE TICKETMATCH SET DEPLOY = 'READY' WHERE TEMP_ID = $id");
                                    echo "<script>alert('Deploy status updated!')</script>";
                                    echo "<script>self.history.back()</script>";

                                
                                }
                                else if(isset($_POST['retract'])){
                                    mysqli_query($conn,"UPDATE TICKETMATCH SET DEPLOY = 'UNREADY' WHERE TEMP_ID = $id");
                                    echo "<script>alert('Deploy status updated!')</script>";
                                    echo "<script>self.history.back()</script>";
                                }
                            ?>
                        </div>
                    
                    
                        <div class="wrapper-2">
                            <div class='card'>
                                <a  class = "btn-popup"><img src="../img/TICKET/<?php echo $match_url?>">
                                <div class="descriptions">
                                    <h4 class="title-tour">LIGA SUPER MALAYSIA 2024</h4>
                                    <div class = "main-title">
                                        <div class = "title-match">
                                            <h1 style="text-transform:uppercase"><?php echo $match_home?></h1>
                                        </div>
                                        <h2 class= "vs">vs</h2>
                                        <div class = "title-match">
                                            <h1 style="text-transform:uppercase"><?php echo $match_away?></h1>
                                        </div>
                                    </div>
                                    <div class="match-desc">
                                        <h3 style="text-transform:uppercase"><?php echo date("d F Y", strtotime($match_date));?></h3>
                                        <h3 style="text-transform:uppercase"><?php echo date("h.i a", strtotime($match_time));?></h3>
                                        <h3 style="text-transform:uppercase"><?php echo $match_venue?></h3>
                                    </div>
                                    <div class="match-price">
                                        <h4>RM <?php echo $match_price?></h4>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    </div>
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