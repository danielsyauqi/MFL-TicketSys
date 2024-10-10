<!doctype html>

<html>
    <head>
        <title>MFL Ticketing System</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css?<?php echo time(); ?>">
        <script src="../js/script.js" defer></script>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>


    <body>


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
            
            if(isset($_GET['all'])){
                $_POST['search'] = null;
            }

            ?>


            <header class ="header">
                <a href="#" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="../php/index.php" class="active">Home</a></li>
                    <li><a href="../php/standings.php#sec">Standings</a></li>
                    <li><a href="../php/about.php">About</a>

                    </li>
                    <?php
                    if(isset($_SESSION['valid'])||isset($_SESSION['valid2'])||isset($_SESSION['valid3'])){
                        if(isset($_SESSION['valid'])){
                        echo "<li><a href='ticketCust.php#sec'>User</a>";
                        }
                        else if(isset($_SESSION['valid2'])){
                        echo "<li><a href='admin-ticket.php#sec'>User</a>";
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
                                echo "<li><a href='edit-profile-cust.php#sec'>Edit Profile</a></li>";
                                echo "<li><a href='ticketCust.php#sec'>Ticket</a></li>";
                                echo "<li><a href='logout.php'>Log Out</a></li>";
                            }

                            elseif(isset($_SESSION['valid2'])){
                                echo "<li><a href='edit-profile-admin.php#sec'>Edit Profile</a></li>";
                                echo "<li><a href='admin-ticket.php#sec'>Ticket Profile</a></li>";
                                echo "<li><a href='sales-review-admin.php#sec'>Sales Review</a></li>";
                                echo "<li><a href='logout.php'>Log Out</a></li>";
                            }

                            else if(isset($_SESSION['valid3'])){
                                    echo "<li><a href='edit-profile-fa.php#sec'>Edit Profile</a></li>";
                                    echo "<li><a href='fa-ticket.php#sec' id = 'ticket-req'>Ticket Request</a></li>";
                                    echo "<li><a href='sales-review-fa.php#sec'>Sales Review</a></li>";
                                    echo "<li><a href='logout.php'>Log Out</a></li>";
                            }
                            
                        echo "</ul>";
                    echo "</li>";
                    ?>
                </ul>
            </header>

            <div class="container" id="container">


                <section class="first">
                    
                    <?php
                    if(isset($_SESSION['valid'])){
                        echo "<h2 id=\"title\">MALAYSIA FOOTBALL LEAGUE</h2>";
                        echo "<p id=\"subtitle\"><i>TICKETING SYSTEM</i></p>";
                        echo "<a href=\"#sec\" id=\"btn\" class='btn-home'>Order Ticket</a>";
                        echo "<p id= \"user-hola\" style=\"text-transform:uppercase\">WELCOME HOME, $res_icname!</p>";
                    }
                    else if(isset($_SESSION['valid2'])){
                        echo "<h2 id=\"title\">MALAYSIA FOOTBALL LEAGUE</h2>";
                        echo "<p id=\"subtitle\"><i>TICKETING SYSTEM (ADMINISTRATOR MODE)</i></p>";
                        echo "<a href=\"#sec\" id=\"btn\" class='btn-home'>Order Ticket</a>";
                        echo "<p id= \"user-hola\" style=\"text-transform:uppercase\">WELCOME HOME, $res_username!</p>";  
                    }
                    else if(isset($_SESSION['valid3'])){
                        echo "<h2 id=\"title\">MALAYSIA FOOTBALL LEAGUE</h2>";
                        echo "<p id=\"subtitle\"><i>TICKETING SYSTEM (FOOTBALL ASSOCIATION MODE)</i></p>";
                        echo "<a href=\"#sec\" id=\"btn\" class='btn-home'>Order Ticket</a>";
                        echo "<p id= \"user-hola\" style=\"text-transform:uppercase\">WELCOME HOME, $res_faname!</p>";
                    }
                    else{
                        echo "<h2 id=\"title\">MALAYSIA FOOTBALL LEAGUE</h2>";
                        echo "<p id=\"subtitle\"><i>TICKETING SYSTEM </i></p>";
                        echo "<a href=\"#sec\" id=\"btn\" class='btn-home'>Order Ticket</a>";
                        echo "<p id= \"user-hola\" >WELCOME GUEST, PLEASE LOG IN FOR BOOKING THE TICKET! </p>";
                    }

                    ?>
                    
                </section>

                <div class="sec" id="sec">

                    <div class="sec-title"> 
                        <h2>TICKET AVAILABLE</h2>
                    </div>

                    <div class="search-box">
                        <form action = "index.php#sec" method="post">
                        <button type="submit" name="search" class="btn-search"><img src='../img/search-bar.png'></button>
                        <input type="text" name="searchString" class="input-search" placeholder="Type to Search...">
                        </form>
                    </div>
                <div class = 'btn-all-container'>
                    <a href="index.php?all#sec" id="btn-all" class='btn-all'>All Ticket</a>";
                    </div>

                    <div class="wrapper">
                        <?php 
                            if(isset($_POST['search'])&&$_POST['searchString']!=""){
                                $searchString = $_POST['searchString'];
                                $queryCountSearch = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID 
                                AND TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TICKETMATCH.DEPLOY = 'READY'  
                                AND TEAM_NAME LIKE '%$searchString%'");
                                $queryCountSearch2 = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID 
                                AND TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TICKETMATCH.DEPLOY = 'READY'  
                                AND TEAM_NAME LIKE '%$searchString%'");

                                
                                    while($result = mysqli_fetch_assoc($queryCountSearch)){
                                    echo "<div class='card'>";
                                    if(!isset($_SESSION['valid'])){
                                        echo "<a  class = \"btn-popup\"><img src=\"../img/TICKET/";echo $result['MATCH_URL'];echo"\">";
                                    }
                                    else{
                                        echo "<a  href=ticketview.php?view="; echo$result['MATCH_ID']; echo"#sec><img src=\"../img/TICKET/";echo $result['MATCH_URL'];echo"\">";
                                    }
                                        echo "<div class=\"descriptions\">";
                                            echo "<h4 class=\"title-tour\">LIGA SUPER MALAYSIA 2024</h4>";
                                            echo "<div class = \"main-title\">";
                                                echo "<div class = \"title-match\">";
                                                    echo "<h1 style=\"text-transform:uppercase\">";echo $result['TEAM_NAME']; echo " </h1>";
                                                echo "</div>";
                                                echo "<h2 class= \"vs\">vs</h2>";
                                                echo "<div class = \"title-match\">";
                                                $matchID = $result['MATCH_ID'];
                                                $queryAway = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID 
                                                AND TEMP_TICKET.MATCH_AWAY = FA.FA_ID  AND MATCH_ID = $matchID");
                                                while($result2 = mysqli_fetch_assoc($queryAway)){echo "<h1 style=\"text-transform:uppercase\">";echo $result2['TEAM_NAME']; echo " </h1>";}
                                                    
                                                echo "</div>";
                                            echo "</div>";
                                            echo "<div class=\"match-desc\">";
                                                echo "<h3 style=\"text-transform:uppercase\">";echo date("d F Y", strtotime($result['MATCH_DATE'])); echo " </h3>";
                                                echo "<h3 style=\"text-transform:uppercase\">";echo date("h:i a", strtotime($result['MATCH_TIME'])); echo " </h3>";
                                                echo "<h3 style=\"text-transform:uppercase\">";echo $result['MATCH_VENUE']; echo " </h3>";
                                            echo "</div>";  
                                            echo "<div class=\"match-price\">";
                                                echo "<h4>RM ";echo $result['MATCH_PRICE']; echo "</h4>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                    echo "</a>";
                                    
                                    }
                                    while($result = mysqli_fetch_assoc($queryCountSearch2)){
                                        echo "<div class='card'>";
                                        if(!isset($_SESSION['valid'])){
                                            echo "<a  class = \"btn-popup\"><img src=\"../img/TICKET/";echo $result['MATCH_URL'];echo"\">";
                                        }
                                        else{
                                            echo "<a  href=ticketview.php?view="; echo$result['MATCH_ID']; echo"#sec><img src=\"../img/TICKET/";echo $result['MATCH_URL'];echo"\">";
                                        }
                                            echo "<div class=\"descriptions\">";
                                                echo "<h4 class=\"title-tour\">LIGA SUPER MALAYSIA 2024</h4>";
                                                echo "<div class = \"main-title\">";
                                                    echo "<div class = \"title-match\">";
                                                        echo "<h1 style=\"text-transform:uppercase\">";echo $result['TEAM_NAME']; echo " </h1>";
                                                    echo "</div>";
                                                    echo "<h2 class= \"vs\">vs</h2>";
                                                    echo "<div class = \"title-match\">";
                                                    $matchID = $result['MATCH_ID'];
                                                    $queryAway = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID 
                                                    AND TEMP_TICKET.MATCH_AWAY = FA.FA_ID  AND MATCH_ID = $matchID");
                                                    while($result2 = mysqli_fetch_assoc($queryAway)){echo "<h1 style=\"text-transform:uppercase\">";echo $result2['TEAM_NAME']; echo " </h1>";}
                                                        
                                                    echo "</div>";
                                                echo "</div>";
                                                echo "<div class=\"match-desc\">";
                                                    echo "<h3 style=\"text-transform:uppercase\">";echo date("d F Y", strtotime($result['MATCH_DATE'])); echo " </h3>";
                                                    echo "<h3 style=\"text-transform:uppercase\">";echo date("h:i a", strtotime($result['MATCH_TIME'])); echo " </h3>";
                                                    echo "<h3 style=\"text-transform:uppercase\">";echo $result['MATCH_VENUE']; echo " </h3>";
                                                echo "</div>";  
                                                echo "<div class=\"match-price\">";
                                                    echo "<h4>RM ";echo $result['MATCH_PRICE']; echo "</h4>";
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";
                                        echo "</a>";
                                        
                                        }
                            
                                }
                            else{
                                $queryMatch = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID 
                                AND TEMP_TICKET.MATCH_HOME = FA.FA_ID AND TICKETMATCH.DEPLOY = 'READY' ");

                                
                                    while($result = mysqli_fetch_assoc($queryMatch)){
                                    echo "<div class='card'>";
                                    if(!isset($_SESSION['valid'])){
                                        echo "<a  class = \"btn-popup\"><img src=\"../img/TICKET/";echo $result['MATCH_URL'];echo"\">";}
                                    else{
                                        echo "<a  href=ticketview.php?view="; echo$result['MATCH_ID']; echo"#sec><img src=\"../img/TICKET/";echo $result['MATCH_URL'];echo"\">";
                                    }
                                        echo "<div class=\"descriptions\">";
                                            echo "<h4 class=\"title-tour\">LIGA SUPER MALAYSIA 2024</h4>";
                                            echo "<div class = \"main-title\">";
                                                echo "<div class = \"title-match\">";
                                                    echo "<h1 style=\"text-transform:uppercase\">";echo $result['TEAM_NAME']; echo " </h1>";
                                                echo "</div>";
                                                echo "<h2 class= \"vs\">vs</h2>";
                                                echo "<div class = \"title-match\">";
                                                $matchID = $result['MATCH_ID'];
                                                $queryAway = mysqli_query($conn,"SELECT * FROM FA, TEMP_TICKET, TICKETMATCH WHERE TEMP_TICKET.TEMP_ID = TICKETMATCH.TEMP_ID 
                                                AND TEMP_TICKET.MATCH_AWAY = FA.FA_ID AND TICKETMATCH.DEPLOY = 'READY' AND MATCH_ID = $matchID");
                                                while($result2 = mysqli_fetch_assoc($queryAway)){echo "<h1 style=\"text-transform:uppercase\">";echo $result2['TEAM_NAME']; echo " </h1>";}
                                                echo "</div>";
                                            echo "</div>";
                                            echo "<div class=\"match-desc\">";
                                                echo "<h3 style=\"text-transform:uppercase\">";echo date("d F Y", strtotime($result['MATCH_DATE'])); echo " </h3>";
                                                echo "<h3 style=\"text-transform:uppercase\">";echo date("h:i a", strtotime($result['MATCH_TIME'])); echo " </h3>";
                                                echo "<h3 style=\"text-transform:uppercase\">";echo $result['MATCH_VENUE']; echo " </h3>";
                                            echo "</div>";
                                            echo "<div class=\"match-price\">";
                                                echo "<h4>RM ";echo $result['MATCH_PRICE']; echo "</h4>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                    echo "</a>";

                                    
                                }
                            
                            }
                        ?>   
                    </div>
                </div>
                
            </div>
                <?php
                    if(!isset($_SESSION['valid'])){
                        echo "<div class=\"modal-parent\" id=\"modal-parent\">";
                                echo "<div class=\"modal\" id=\"modal\">";
                                    echo "<p class=\"modal-text-bg\">Please log in to customer account first!</p>";
                                    echo "<a class=\"X\" id=\"X\"draggable=\"true\">&times;</a>";
                                echo "</div>";
                        echo "</div>";
                    }
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