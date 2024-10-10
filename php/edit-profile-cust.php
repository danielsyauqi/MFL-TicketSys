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
                $res_pass = $result['CUST_PASS'];
            
            }
    } else{header('location:login.php');}


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
                    <li><a href="ticketCust.php#sec'" class="active">User</a>
                        <ul class="dropdown">
                        <?php
                                if(isset($_SESSION['valid'])){
                                    echo "<li><a href='#' class='active'>Edit Profile</a></li>";
                                    echo "<li><a href='ticketCust.php#sec' >Ticket</a></li>";
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
                    <div class="regbox">
                        <div class="box form-box">
                        <h2>EDIT PROFILE</h2>
                   
                            <form action="" method="post">
                                <div class="field input">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" value="<?php echo $res_email ?>" >
                                </div>
            
                                

                                <div class="field input">
                                    <label for="IC_NAME">Full Name as IC</label>
                                    <input type="text" name="IC_NAME" id="IC_NAME" placeholder="<?php echo $res_icname ?>"readonly>
                                </div>

                                <div class="field input">
                                    <label for="IC_NUM">IC Number</label>
                                    <input type="text" name="IC_NUM" id="IC_NUM" placeholder="<?php echo $res_icnum ?>" readonly>
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
                                if(isset($_POST['submit'])){
                                    $email = $_POST['email'];
                                    $passN = $_POST['passwordN'];
                                    $passC = $_POST['passwordC'];

                                    if($passC = $res_pass){
                                        if($email != $res_email){
                                            $emailQuery = mysqli_query($conn,"UPDATE CUSTOMER SET CUST_EMAIL = '$email' WHERE CUST_ID = $id");
                                        }
                                        if($passN != $res_pass || $passN == null){
                                            $passQuery = mysqli_query($conn,"UPDATE CUSTOMER SET CUST_PASS = '$passN' WHERE CUST_ID = $id");
                                        }

                                        if($emailQuery||$passQuery){
                                            echo "<script>alert('Edit succesfully updated!')</script>";
                                        }

                                    }else{
                                        echo "<script>alert('Password invalid! Please try again.')</script>";
                                    }
                                    echo "<script>self.history.back()</script>";
                                }
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