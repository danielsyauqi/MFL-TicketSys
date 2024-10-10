<!DOCTYPE html>
<html>
    <head>
        <title>
            MFL REGISTER</title>
            <link rel="stylesheet" href= "../css/style.css?<?php echo time(); ?>">
    </head>
    <body>

        <div class="banner">
        <header class ="header">
                <a href="index.php" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="#" class="active">Register</a></li>
                    <li><a href="standings.php#sec">Standings</a></li>
                    <li><a href="about.php">About</a>
                    </li>
                </ul>
            </header>
            
            <div class="regbox">
                <div class="box form-box">
                
                <?php 

                include ("config.php");
                if(isset($_POST["submit"])){
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $IC_NAME = $_POST['IC_NAME'] ;
                    $IC_NUM = $_POST['IC_NUM'] ;

                //verifying the unique email

                $verify_query = mysqli_query($conn, "SELECT CUST_EMAIL FROM CUSTOMER WHERE CUST_EMAIL='$email'");
                if(mysqli_num_rows($verify_query) != 0){
                    echo "<div class='message'>
                            <p>This email is used, Try another one please.</p>
                        </div><br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                }
                else{
                    mysqli_query($conn,"INSERT INTO customer(CUST_EMAIL, CUST_PASS, CUST_IC_NAME, CUST_IC_NUM) VALUES('$email','$password','$IC_NAME','$IC_NUM')") or die ("Error Occured.");

                    echo "<div class='message'>
                            <p>Registration Succesful. You can order ticket now!</p>
                        </div><br>";
                    echo "<a href='login.php'><button class='btn'>Login Now</button>";
                }
                }else{

                ?>

                    <h2>REGISTER</h2>
                   
                    <form action="" method="post">
                        <div class="field input">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required>
                        </div>
    
                        <div class="field input">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" required>
                        </div>

                        <div class="field input">
                            <label for="IC_NAME">Full Name as IC</label>
                            <input type="text" name="IC_NAME" id="IC_NAME" required>
                        </div>

                        <div class="field input">
                            <label for="IC_NUM">IC Number</label>
                            <input type="text" name="IC_NUM" id="IC_NUM" required>
                        </div>
                       
                        <div class="field">
                            <input type="submit" class="btn" name="submit" value="Register" required>
                        </div>
                       
                        <div class="links">
                            Already have account? <a href="login.php">Log In</a> Now!</a>
                        </div>
                    </form>
                </div>
                <?php } 
                
                ?>

            </div>
        </div>
    </body>
</html>