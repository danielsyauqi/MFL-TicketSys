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
            $res_pass = $result['ADMIN_PASS'];
        
        }
    } else{header('location:login.php');}

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $username = $_POST['username'];
        $position = $_POST['position'];
        $passN = $_POST['passwordN'];
        $passC = $_POST['passwordC'];

        if($passC == $res_pass){
            if($email != $res_email){
                $emailQuery = mysqli_query($conn,"UPDATE ADMIN SET ADMIN_EMAIL = '$email' WHERE ADMIN_ID = $id");
            }
            if($username != $res_username){
                $unameQuery = mysqli_query($conn,"UPDATE ADMIN SET ADMIN_USERNAME = '$username' WHERE ADMIN_ID = $id");
            }
            if($position != $res_pos){
                $posQuery = mysqli_query($conn,"UPDATE ADMIN SET ADMIN_POSITION = '$position' WHERE ADMIN_ID = $id");
            }
            if($passN != $res_pass && $passN != null){
                $passQuery = mysqli_query($conn,"UPDATE ADMIN SET ADMIN_PASS = '$passN' WHERE ADMIN_ID = $id");
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
                    <li><a href="../php/standings.php#sec">Standings</a></li>
                    <li><a href="../php/about.php">About</a>
                    </li>
                    <li><a href="admin-ticket.php#sec" class="active">User</a>
                        <ul class="dropdown">
                        <?php
                                if(isset($_SESSION['valid2'])){
                                    echo "<li><a href='#' class='active'>Edit Profile</a></li>";
                                    echo "<li><a href='admin-ticket.php#sec' >Ticket Profile</a></li>";
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
                    <div class="regbox">
                        <div class="box form-box">
                        <h2>EDIT PROFILE</h2>
                   
                            <form action="" method="post">
                                <div class="field input">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" value="<?php echo $res_username ?>" >
                                </div>
            
                                

                                <div class="field input">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" value="<?php echo $res_email ?>">
                                </div>

                                <div class="field input">
                                    <label for="position">Position</label>
                                    <input type="text" name="position" id="position" value="<?php echo $res_pos ?>">
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