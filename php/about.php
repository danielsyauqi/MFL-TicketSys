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
                    $res_id = $result['CUST_ID'];
                
                }
            }

            elseif (isset($_SESSION['valid2'])){
                $id = $_SESSION['ID'];
                
                $query = mysqli_query($conn,"SELECT*FROM ADMIN WHERE ADMIN_ID = '$id'");
    
    
    
                while($result = mysqli_fetch_assoc($query)){
                    $res_email = $result['ADMIN_EMAIL'];
                    $res_username = $result['ADMIN_USERNAME'];
                    $res_pos = $result['ADMIN_POSITION'];
                    $res_id = $result['ADMIN_ID'];
                
                }
            }

            else if (isset($_SESSION['valid3'])){
                $id = $_SESSION['ID'];
                
                $query = mysqli_query($conn,"SELECT*FROM FA WHERE FA_ID = '$id'");
    
    
    
                while($result = mysqli_fetch_assoc($query)){
                    $res_faemail = $result['FA_EMAIL'];
                    $res_faname = $result['FA_NAME'];
                    $res_fapass = $result['FA_PASSWORD'];
                    $res_faid = $result['FA_ID'];
                
                }
            }

            

?>

<!doctype html>

<html>
    <head>
        <title>MFL Ticketing System</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css?<?php echo time(); ?>">
        <script src="../js/script.js" defer></script>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        
    </head>


    <body>
            <header class ="header">
                <a href="index.php" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="../php/index.php" >Home</a></li>
                    <li><a href="../php/standings.php">Standings</a></li>
                    <li><a href="#" class="active">About</a>
                    </li>
                    <?php
                    if(isset($_SESSION['valid'])||isset($_SESSION['valid2'])||isset($_SESSION['valid3'])){
                        if(isset($_SESSION['valid'])){
                        echo "<li><a href='ticketCust#sec.php'>User</a>";
                        }
                        else if(isset($_SESSION['valid2'])){
                        echo "<li><a href='admin-ticket#sec.php'>User</a>";
                        }
                        else if(isset($_SESSION['valid3'])){
                        echo "<li><a href='fa-ticket.php#sec'>User</a>";
                        }
                        echo "<ul class='dropdown'>";
                    }
                    else{
                        echo "<li><a href='login.php'>Login/Signup</a>";
                        echo "<ul class='dropdown'>";
                    }
                    
                            
                            if(isset($_SESSION['valid'])){
                                echo "<li><a href='edit-profile-cust#sec.php'>Edit Profile</a></li>";
                                echo "<li><a href='ticketCust#sec.php'>Ticket</a></li>";
                                echo "<li><a href='logout.php'>Log Out</a></li>";
                            }

                            elseif(isset($_SESSION['valid2'])){
                                echo "<li><a href='edit-profile-admin#sec.php'>Edit Profile</a></li>";
                                echo "<li><a href='admin-ticket#sec.php'>Ticket Profile</a></li>";
                                echo "<li><a href='sales-review-admin.php#sec'>Sales Review</a></li>";
                                echo "<li><a href='logout.php'>Log Out</a></li>";
                            }

                            else if(isset($_SESSION['valid3'])){
                                    echo "<li><a href='edit-profile-fa#sec.php'>Edit Profile</a></li>";
                                    echo "<li><a  href='fa-ticket.php#sec' id = 'ticket-req'>Ticket Request</a></li>";
                                    echo "<li><a href='sales-review-fa.php#sec'>Sales Review</a></li>";
                                    echo "<li><a href='logout.php'>Log Out</a></li>";
                            }
                            
                        echo "</ul>";
                    echo "</li>";
                    ?>
                </ul>
            </header>

            <div class="container">

                <section class="first">
                    <h2 id="title-no-js">MALAYSIA FOOTBALL LEAGUE</h2>
                    <p id="subtitle-no-js"><i>TICKETING SYSTEM</i></p>
                    <div class="slideshow">
  
                        <div class="slideshow-part slideshow-part-one">
                            <img src="../img/SLIDESHOW/1.jpg" >
                        </div>
                            
                        <!-- Photo 2 -->
                        <div class="slideshow-partt slideshow-part-two">
                            <img src="../img/SLIDESHOW/2.jpg" >
                        </div>

                        <!-- Photo 3 -->
                        <div class="slideshow-part slideshow-part-three">
                            <img src="../img/SLIDESHOW/3.jpg" >
                        </div>

                        <!-- Photo 4 -->
                        <div class="slideshow-part slideshow-part-four">
                            <img src="../img/SLIDESHOW/4.jpg" >
                        </div>

                    </div>

                    <div class = "text-desc">
                        <p>The history of Malaysian football league, particularly the Malaysia Super League (MSL), traces back to its establishment in 2004, succeeding the former top-tier league. Over the years, the league has evolved, becoming a focal point of Malaysian football with its competitive format and growing fanbase. 
                            Teams like Johor Darul Ta'zim FC (JDT), Selangor FC, and Pahang FA have emerged as dominant forces, consistently vying for the league title. The league has not only served as a platform for local talent but has also attracted foreign players, enriching its diversity and raising the level of competition. 
                            Despite facing challenges such as financial sustainability and occasional issues with infrastructure, the MSL remains pivotal in the development and promotion of football in Malaysia, contributing significantly to the nation's sporting culture and international football presence.</p>
                    </div>
                    
                </section>

                
            <footer class = "footer-1">
                <div class="footer-text">
                    <h3>All Rights Reserved.</h3>
                    <a href="https://sites.google.com/view/danielsyauqi/home?authuser=0"><p>Made by Syauqi 2024.</p></a>
                </div>
            </footer>

        <?php ?>
    </body>
</html>