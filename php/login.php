<?php
    session_start();
?>
<html>
    <head>
        <title>
            LOGIN MFL</title>
            <link rel="stylesheet" href= "../css/style.css?<?php echo time(); ?>">
    </head>
    <body>

        <div class="banner">
            <header class ="header">
                    <a href="index.php" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                    <ul>
                        <li><a href="#" class="active">Login</a></li>
                        <li><a href="standings.php#sec">Standings</a></li>
                        <li><a href="about.php">About</a>
                        </li>
                    </ul>
                </header>

            <div class="loginbox">
                <div class="box form-box">

                    <?php

                    include("config.php");
                    if(isset($_POST['submit'])) {
                    $email = mysqli_real_escape_string ($conn,$_POST['email']);
                    $password = mysqli_real_escape_string ($conn,$_POST['password']);


                        if(mysqli_query ($conn,"SELECT * FROM CUSTOMER WHERE CUST_EMAIL='$email' AND CUST_PASS='$password'") == TRUE) {
                        $result = mysqli_query ($conn,"SELECT * FROM CUSTOMER WHERE CUST_EMAIL='$email' AND CUST_PASS='$password'") or die("Select error");
                        $row = mysqli_fetch_assoc($result);

                            if(is_array($row) && !empty($row)){
                                $_SESSION['ID'] = $row['CUST_ID'];
                                $_SESSION['valid'] = $row['CUST_EMAIL'];
                                $_SESSION['CUST_PASS'] = $row['CUST_PASS'];
                                $_SESSION['CUST_IC_NAME'] = $row['CUST_IC_NAME'];
                                $_SESSION['CUST_IC_NUM'] = $row['CUST_IC_NUM'];
                                
                            }
                            elseif(mysqli_query ($conn,"SELECT * FROM ADMIN WHERE ADMIN_EMAIL='$email' AND ADMIN_PASS='$password'") == TRUE){
                                $result = mysqli_query ($conn,"SELECT * FROM ADMIN WHERE ADMIN_EMAIL='$email' AND ADMIN_PASS='$password'") or die("Select error");
                                $row = mysqli_fetch_assoc($result);
            
                                if(is_array($row) && !empty($row)){
                                    $_SESSION['ID'] = $row['ADMIN_ID'];
                                    $_SESSION['valid2'] = $row['ADMIN_EMAIL'];
                                    $_SESSION['ADMIN_PASS'] = $row['ADMIN_PASS'];
                                    $_SESSION['ADMIN_USERNAME'] = $row['ADMIN_USERNAME'];
                                    $_SESSION['ADMIN_POSITION'] = $row['ADMIN_POSITION'];
                                    
                                    
                                }

                                elseif(mysqli_query ($conn,"SELECT * FROM FA WHERE FA_EMAIL='$email' AND FA_PASSWORD='$password'") == TRUE){
                                    $result = mysqli_query ($conn,"SELECT * FROM FA WHERE FA_EMAIL='$email' AND FA_PASSWORD='$password'") or die("Select error");
                                    $row = mysqli_fetch_assoc($result);
                
                                    if(is_array($row) && !empty($row)){
                                        $_SESSION['ID'] = $row['FA_ID'];
                                        $_SESSION['valid3'] = $row['FA_EMAIL'];
                                        $_SESSION['FA_PASS'] = $row['FA_PASSWORD'];
                                        $_SESSION['FA_NAME'] = $row['FA_NAME'];
                                        $_SESSION['TEAM_NAME'] = $row['TEAM_NAME'];
                                        
                                        
                                    }
                                    else{
                                        echo "<div class='message'>
                                                <p>Wrong Email or Password.</p>
                                            </div><br>";
                                        echo "<a href='login.php'><button class='btn'>Go Back</button>";
                                    }
                                    
                                }
                                
                            }
                        
                        }
                        if(isset($_SESSION['valid'])){
                            header ("Location: index.php");
                            $_SESSION['valid2'] = null;
                            $_SESSION['valid3'] = null;
                        }
                        elseif(isset( $_SESSION['valid2'])){
                            header ("Location: index.php");
                            $_SESSION['valid'] = null;
                            $_SESSION['valid3'] = null;
                        }
                        elseif(isset( $_SESSION['valid3'])){
                            header ("Location: index.php");
                            $_SESSION['valid'] = null;
                            $_SESSION['valid2'] = null;
                        }
                    }else{
                          
                    ?>

                    <h2>LOGIN</h2>
                    <form action="" method="post">
                        <div class="field input">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" autocomplete="off" required>
                        </div>
    
                        <div class="field input">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password"  autocomplete="off" required>
                        </div>
                       
                        <div class="field">
                            <input type="submit" class="btn"name="submit" value="Login" required>
                        </div>
                       
                        <div class="links">
                            Don't have account? <a href="register.php">Sign Up</a> Now!</a>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>