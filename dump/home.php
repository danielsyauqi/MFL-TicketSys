<!DOCTYPE html>

<html>
    <head>
        <title>
            MFL TICKET</title>
            <link rel="stylesheet" href= "../css/home.css?<?php echo time(); ?>">
            <script src="../js/main.js" defer></script>
    </head>
    <body>
        <div class="banner">
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
            ?>
            <header>
                <div class="navbar">
                    <a href="home.php"><img alt src="../img/MFL LOGO.png" class="logo"></a>
                    <ul>
                        <li><a href="standings.php">Standings</a></li>
                        <li>
                            <a href="#">About Us</a>
                                <div class="dropdown-about"></a>
                                    <ul>
                                        <li><a href="#">MFL History</a></li>
                                        <li><a href="#">Team Information</a></li>
                                    </ul>
                                </div>
                        </li>
                        <li>
                            <img alt src="../img/user svg.svg" class="userlogo">
                            <div class="dropdown-user">
                                <ul>
                                    <?php
                                        if(isset($_SESSION['valid'])){
                                     echo "<li><a href='#'>Edit Profile</a></li>";
                                     echo "<li><a href='#'>Ticket</a></li>";
                                     echo "<li><a href='logout.php'>Log Out</a></li>";
                                    }
                                    else{
                                        echo "<li><a href='login.php'>Log In</a></li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </header>
            
            <div class=""

            <div class="username">
            
                <?php
                if(isset($_SESSION['valid'])){
                echo "<h1>WELCOME HOME!</h1>";
                echo "<hr>";
                echo "<p> $res_icname </p>";
                }
                else{
                echo "<h1>WELCOME GUEST!</h1>";
                echo "<hr>";
                echo "<p>Please Log In for booking the ticket</p>";
                }

                ?>
            </div>
            
            <div class="content">
                <h1>MALAYSIAN FOOTBALL LEAGUE</h1>
                <p>Ticketing System</p>
            </div>

            <div class="ticket-content-title">
                <h1>TICKET AVAILABLE</h1>
            </div>
            
            <div class="ticket-content">
                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                        <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                            <div class="ticket-overlay">
                                <div class="ticket-text">
                                <h1>Info</h1>
                                <br>
                                <h2>Johor Darul Ta'zim</h2>
                                <p>vs</p>
                                <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                <div class = "ticket-container">
                    <a href="#"><img src="../img/MFL TICKET BANNER DRAFT.png" alt="" class="ticket-content-image">
                        <div class="ticket-overlay">
                            <div class="ticket-text">
                            <h1>Info</h1>
                            <br>
                            <h2>Johor Darul Ta'zim</h2>
                            <p>vs</p>
                            <h2>Selangor F.C.</h2>
                            </div> 
                        </div>
                    </a>
                </div>

                
            </div>
            

            <?php ?>
        </div>
    </body>

    <footer id="footer">

        <div class="footer-text">
            <h3>All Rights Reserved.</h3>
            <p>Made by Syauqi 2024.</p>
        </div>

    </footer>

</html>