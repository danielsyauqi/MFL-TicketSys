<?php
    session_start();
    include("config.php");

    if (isset($_SESSION['valid3'])){
        $id = $_SESSION['ID'];
        
        $query = mysqli_query($conn,"SELECT*FROM FA WHERE FA_ID = '$id'");

        while($result = mysqli_fetch_assoc($query)){
            $res_faemail = $result['FA_EMAIL'];
            $res_faname = $result['FA_NAME'];
            $res_fapass = $result['FA_PASSWORD'];
            $res_teamName = $result['TEAM_NAME'];
            $res_faid = $result['FA_ID'];
        
        }
        
    }   else{header('location:login.php');}

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $name = $_POST['name'];
        $team = $_POST['team'];
        $passN = $_POST['passwordN'];
        $passC = $_POST['passwordC'];

        if($passC == $res_fapass){
            if($email != $res_faemail){
                $emailQuery = mysqli_query($conn,"UPDATE FA SET FA_EMAIL = '$email' WHERE FA_ID = $id");
            }
            if($name != $res_faname){
                $nameQuery = mysqli_query($conn,"UPDATE FA SET FA_NAME = '$name' WHERE FA_ID = $id");
            }
            if($team != $res_teamName){
                $teamQuery = mysqli_query($conn,"UPDATE FA SET TEAM_NAME = \"$team\" WHERE FA_ID = $id");
            }
            if($passN != $res_fapass && $passN != null){
                $passQuery = mysqli_query($conn,"UPDATE FA SET ADMIN_PASS = '$passN' WHERE FA_ID = $id");
            }


            echo "<script>alert('Edit succesfully updated!')</script>";
            
        }else{
            
            echo "<script>alert('Password invalid! Please try again.')</script>";
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
                <a href="index.php" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="../php/index.php" >Home</a></li>
                    <li><a href="../php/standings.php">Standings</a></li>
                    <li><a href="../php/about.php">About</a>
                    </li>
                    <li><a href="fa-ticket.php#sec" class="active">User</a>
                        <ul class="dropdown">
                        <?php
                                if(isset($_SESSION['valid3'])){
                                    echo "<li><a href='edit-profile-fa.php#sec'>Edit Profile</a></li>";
                                    echo "<li><a  href='fa-ticket.php#sec' id = 'ticket-req'>Ticket Request</a></li>";
                                    echo "<li><a href='sales-review-fa.php#sec'>Sales Review</a></li>";
                                    echo "<li><a href='logout.php'>Log Out</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </header>

            <div class="container">

                <section class="first">
                    <h2 id="title">MALAYSIA FOOTBALL LEAGUE</h2>
                    <p id="subtitle"><i>TICKETING SYSTEM (FOOTBALL ASSOCIATION MODE)</i></p>
                    <?php
                    if(isset($_SESSION['valid3'])){
                        echo "<p id= \"user-hola\" style=\"text-transform:uppercase\" >WELCOME HOME, $res_faname!</p>";
                    }
                    else{
                    echo "<p id= \"user-hola\" >WELCOME GUEST, PLEASE LOG IN FOR BOOKING THE TICKET! </p>";
                    }

                    ?>
                    <a href="#sec" id="btn" class ='btn-home' >Order Ticket</a>
                </section>

                <div class="sec" id="sec">
                    <div class="regbox">
                        <div class="box form-box">
                        <h2>EDIT PROFILE</h2>
                   
                            <form action="" method="post">
                                <div class="field input">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="<?php echo $res_faname ?>" >
                                </div>
            
                                

                                <div class="field input">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" value="<?php echo $res_faemail ?>">
                                </div>

                                <div class="field input">
                                    <label for="team">Team Name</label>
                                    <input type="text" name="team" id="team" value="<?php echo $res_teamName ?>">
                                </div>

                                <hr>

                                <div class="field input">
                                    <label for="password">New Password</label>
                                    <input type="password" name="passwordN" id="password">
                                </div>

                                <div class="field input">
                                    <label for="password">Confirm Password</label>
                                    <input type="password" name="passwordC" id="password">
                                </div>
                                
                                <div class="field">
                                    <input type="submit" class="btn" name="submit" value="Submit" onclick="if (confirm('Are you sure to submit?')){return true;}else{event.stopPropagation(); event.preventDefault();};">
                                </div>
                                
                            </form>

                            <?php
                                
                                
                            ?>
                            
                        </div>
                    </div>
                    <?php
                        
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