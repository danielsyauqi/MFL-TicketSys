<?php
    session_start();
    include("config.php");

    if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<script>
                if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                }
            </script>";
       }
?>
<!DOCTYPE html>

<html>
    <head>
        <title>MFL TICKET</title>
            <link rel="stylesheet" href= "../css/style.css?<?php echo time(); ?>">
            <script src="../js/script.js" defer></script>
    </head>
    <body>
        <div class="banner">

            <header class ="header">
                <a href="index.php" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="index.php" >Home</a></li>
                    <li><a href="#" class="active">Standings</a></li>
                    <li><a href="../php/about.php">About</a>
                    </li>
                    <?php
                    if(isset($_SESSION['valid'])||isset($_SESSION['valid2'])||isset($_SESSION['valid3'])){
                        if(isset($_SESSION['valid'])){
                        echo "<li><a href='edit-profile-cust.php'>User</a>";
                        }
                        else if(isset($_SESSION['valid2'])){
                        echo "<li><a href='edit-profile-admin.php'>User</a>";
                        }
                        else if(isset($_SESSION['valid3'])){
                        echo "<li><a href='edit-profile-fa.php'>User</a>";
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
                                    echo "<li><a  href='fa-ticket.php#sec' id = 'ticket-req'>Ticket Request</a></li>";
                                    echo "<li><a href='sales-review-fa.php#sec'>Sales Review</a></li>";
                                    echo "<li><a href='logout.php'>Log Out</a></li>";
                            }
                            
                        echo "</ul>";
                    echo "</li>";
                    ?>
                </ul>
            </header>
        

            <div class="title">
                <h1>STANDINGS</h1>
            </div>
            
            <?php
            if(isset($_SESSION['valid2'])){
                echo "<div class='newsletter-box'>
                <div class='overlay'></div>
                <div id='newsletter'>
                <h1>Standings Update Form</h1>  
                    <p>Malaysia Football League Ticketing System</p>
                <form action='standings.php' class='inline-form' method='post'>
                        <select class='form-standings' name='home-standings' >
                        <option readonly>Home Team</option>";
                        $teamQuery = mysqli_query($conn,"SELECT*FROM FA");
                        while($result=mysqli_fetch_assoc($teamQuery)){$teamNameOption[]=$result['TEAM_NAME'];}
                        for($i=0; $i<13; $i++){
                                    echo "<option value='$i+1'>$teamNameOption[$i]</option>";
                                
                            } 
                    echo "<input type='number' class='number' name='home-score' placeholder='Home Score'>
                    </select>
                        <select class='form-standings' name='away-standings' >
                        <option readonly>Away Team</option>";
                        $teamQuery = mysqli_query($conn,"SELECT*FROM FA");
                        while($result=mysqli_fetch_assoc($teamQuery)){$teamNameOption[]=$result['TEAM_NAME'];}
                        for($i=0; $i<13; $i++){
                                    echo "<option value='$i+1'>$teamNameOption[$i]</option>";
                                
                            } 
                    echo "<input type='number' class='number' name='away-score' placeholder='Away Score'>
                    </select>
                    <input class= 'standings-btn' type='submit' name = 'submit' value='Submit' onclick= \"if (confirm('Are you sure to update?')){return true;}else{event.stopPropagation(); event.preventDefault();};\">
                </form>
                </div>
            </div>";

            }
            
            if(isset($_POST['submit'])){
                $home = $_POST['home-standings'];
                $away = $_POST['away-standings'];
                $homeScore = $_POST['home-score'];
                $awayScore = $_POST['away-score'];

                $standingsQueryHome = mysqli_query($conn,"SELECT * FROM STANDINGS WHERE FA_ID = $home");
                while($result = mysqli_fetch_assoc($standingsQueryHome)){
                    $gamesPlayedHome = $result['GAMES_PLAYED'];
                    $wonHome = $result['WON'];
                    $drawHome = $result['DRAW'];
                    $loseHome = $result['LOSE'];
                    $goalsScoredHome = $result['GOALS_SCORED'];
                    $goalsConcededHome = $result['GOALS_CONCEDED'];
                    $totalPointsHome = $result['TOTAL_POINTS'];

                }
                $standingsQueryAway = mysqli_query($conn,"SELECT * FROM STANDINGS WHERE FA_ID = $away");
                while($result = mysqli_fetch_assoc($standingsQueryAway)){
                    $gamesPlayedAway = $result['GAMES_PLAYED'];
                    $wonAway = $result['WON'];
                    $drawAway = $result['DRAW'];
                    $loseAway = $result['LOSE'];
                    $goalsScoredAway = $result['GOALS_SCORED'];
                    $goalsConcededAway = $result['GOALS_CONCEDED'];
                    $totalPointsAway = $result['TOTAL_POINTS'];

                }



                mysqli_query($conn,"UPDATE STANDINGS SET GAMES_PLAYED = $gamesPlayedHome+1 WHERE FA_ID = $home");
                mysqli_query($conn,"UPDATE STANDINGS SET GAMES_PLAYED = $gamesPlayedAway+1 WHERE FA_ID = $away");

                if($homeScore>$awayScore){
                    mysqli_query($conn,"UPDATE STANDINGS SET WON = $wonHome+1 WHERE FA_ID = $home");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_SCORED = $homeScore+$goalsScoredHome WHERE FA_ID = $home");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_CONCEDED = $awayScore+$goalsConcededHome WHERE FA_ID = $home");
                    mysqli_query($conn,"UPDATE STANDINGS SET TOTAL_POINTS = $totalPointsHome+3 WHERE FA_ID = $home");

                    mysqli_query($conn,"UPDATE STANDINGS SET LOSE = $loseAway+1 WHERE FA_ID = $away");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_SCORED = $awayScore+$goalsScoredAway WHERE FA_ID = $away");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_CONCEDED = $homeScore+$goalsConcededAway WHERE FA_ID = $away");

                    

                }

                else if($homeScore==$awayScore){
                    mysqli_query($conn,"UPDATE STANDINGS SET DRAW = $drawHome+1 WHERE FA_ID = $home");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_SCORED = $homeScore+$goalsScoredHome WHERE FA_ID = $home");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_CONCEDED = $awayScore+$goalsConcededHome WHERE FA_ID = $home");
                    mysqli_query($conn,"UPDATE STANDINGS SET TOTAL_POINTS = $totalPointsHome+1 WHERE FA_ID = $home");

                    mysqli_query($conn,"UPDATE STANDINGS SET DRAW = $drawAway+1 WHERE FA_ID = $away");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_SCORED = $awayScore+$goalsScoredAway WHERE FA_ID = $away");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_CONCEDED = $homeScore+$goalsConcededAway WHERE FA_ID = $away");
                    mysqli_query($conn,"UPDATE STANDINGS SET TOTAL_POINTS = $totalPointsAway+1 WHERE FA_ID = $away");

                }

                else if($homeScore<$awayScore){
                    mysqli_query($conn,"UPDATE STANDINGS SET LOSE = $loseHome+1 WHERE FA_ID = $home");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_SCORED = $homeScore+$goalsScoredHome WHERE FA_ID = $home");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_CONCEDED = $awayScore+$goalsConcededHome WHERE FA_ID = $home");

                    mysqli_query($conn,"UPDATE STANDINGS SET WON = $wonAway+1 WHERE FA_ID = $away");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_SCORED = $awayScore+$goalsScoredAway WHERE FA_ID = $away");
                    mysqli_query($conn,"UPDATE STANDINGS SET GOALS_CONCEDED = $homeScore+$goalsConcededAway WHERE FA_ID = $away");
                    mysqli_query($conn,"UPDATE STANDINGS SET TOTAL_POINTS = $totalPointsAway+3 WHERE FA_ID = $away");

                }

            }
            ?>
                            
                    <div class="container-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Team Name</th>
                                    <th>Games Played</th>
                                    <th>Win</th>
                                    <th>Draw</th>
                                    <th>Lose</th>
                                    <th>Goal Scored</th>
                                    <th>Goal Conceded</th>
                                    <th>Goal Difference</th>
                                    <th>Total Points</th>
                                </tr>
                            </thead>

                <?php



                    /**bubble sorting for standings */

                    echo "<tbody>";
                    $standingsQuery = mysqli_query($conn,"SELECT*,(GOALS_SCORED - GOALS_CONCEDED) AS GOALS_DIFF FROM FA F,STANDINGS S 
                    WHERE F.FA_ID = S.FA_ID
                    ORDER BY S.TOTAL_POINTS DESC, 
                    GOALS_DIFF DESC

                    
                    ");
                                $i =1;
                                while($result = mysqli_fetch_assoc($standingsQuery)){
                                echo "<tr>";
                                    echo "<td>"; echo $i; echo "</td>";
                                    echo "<td>"; echo $result['TEAM_NAME']; echo "</td>";
                                    echo "<td>"; echo $result['GAMES_PLAYED']; echo "</td>";
                                    echo "<td>"; echo $result['WON']; echo "</td>";
                                    echo "<td>"; echo $result['DRAW']; echo "</td>";
                                    echo "<td>"; echo $result['LOSE']; echo "</td>";
                                    echo "<td>"; echo $result['GOALS_SCORED']; echo "</td>";
                                    echo "<td>"; echo $result['GOALS_CONCEDED']; echo "</td>";
                                    echo "<td>"; echo $result['GOALS_DIFF']; echo "</td>";
                                    echo "<td>"; echo $result['TOTAL_POINTS']; echo "</td>";
                                echo "</tr>";
                                $i++;
                                }
                    ?>
                            </tbody>
                        </table>
                    </div>";


                    
            </div>
        </div>
    </body>

</html>