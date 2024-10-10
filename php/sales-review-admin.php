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
        <?php
            
            

            $queryTicket = mysqli_query($conn,"SELECT * FROM TEMP_TICKET ORDER BY TEMP_ID DESC LIMIT 1");
            while($result = mysqli_fetch_assoc($queryTicket)){
                $res_latestTicketID = $result['TEMP_ID'];
            }
            ?>
            <header class ="header">
                <a href="../php/index.php" class="logo"><img src="../img/MFL LOGO.png" id="logo"></a>
                <ul>
                    <li><a href="../php/index.php" >Home</a></li>
                    <li><a href="../php/standings.php#sec">Standings</a></li>
                    <li><a href="../php/about.php">About</a>
                    </li>
                    <li><a href="admin-ticket.php#sec" id="user-bar" class="active">User</a>
                        <ul class="dropdown">
                            <?php
                                if(isset($_SESSION['valid2'])){
                                echo "<li><a href='edit-profile-admin.php#sec'>Edit Profile</a></li>";
                                echo "<li><a href='admin-ticket.php#sec'>Ticket Profile</a></li>";
                                echo "<li><a href='#sec'  class='active'>Sales Review</a></li>";
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

            <div class="container" id="container">
                
                <section class="first">
                    <h2 id="title">MALAYSIA FOOTBALL LEAGUE</h2>
                    <p id="subtitle"><i>TICKETING SYSTEM (ADMINISTRATOR MODE)</i></p>
                    <?php
                    if(isset($_SESSION['valid2'])){

                        echo "<p id= \"user-hola\" style=\"text-transform:uppercase\">WELCOME $res_username!</p>";
                    }
                    else{
                    echo "<p id= \"user-hola\" >WELCOME GUEST, PLEASE LOG IN FOR BOOKING THE TICKET! </p>";
                    }

                    ?>
                    <a href="#sec" id="btn" class ='btn-home' >Order Ticket</a>
                </section>

                <div class="sec" id="sec">

                    <div class="sec-title-2">
                        <h3>SALES REVIEW</h3>
                    </div>
                    
                    
                
                
                <?php

                    for($i = 0; $i < 12; $i++){
                        $salesQuery = mysqli_query($conn,"SELECT*,
                        SUM(P.TICKET_QTY*T.MATCH_PRICE) AS TOTAL_SUM_MONTH, MONTH(P.DATE_PAYMENT) AS MONTH_PAYMENT
                        FROM PAYMENT P,TICKETMATCH M, TEMP_TICKET T 
                        WHERE P.MATCH_ID = M.MATCH_ID AND M.TEMP_ID = T.TEMP_ID AND
                        MONTH(P.DATE_PAYMENT) = '$i'+1
                        GROUP BY MONTH_PAYMENT;
                        ");

                        $countRow = mysqli_num_rows($salesQuery);

                        if($countRow==0){
                            $monthSales[$i] = 0;}
                        else{
                            while($result = mysqli_fetch_assoc($salesQuery)){
                                    $monthSales[$i] = $result['TOTAL_SUM_MONTH'];
                                
                            }
                        }
                    }

                        $dataPoints = array(
                            
                            array("label"=> "January", "y"=> $monthSales[0]),
                            array("label"=> "February", "y"=> $monthSales[1]),
                            array("label"=> "March", "y"=> $monthSales[2]),
                            array("label"=> "April", "y"=> $monthSales[3]),
                            array("label"=> "May", "y"=> $monthSales[4]),
                            array("label"=> "June", "y"=> $monthSales[5]),
                            array("label"=> "July", "y"=> $monthSales[6]),
                            array("label"=> "August", "y"=> $monthSales[7]),
                            array("label"=> "September", "y"=> $monthSales[8]),
                            array("label"=> "October", "y"=> $monthSales[9]),
                            array("label"=> "November", "y"=> $monthSales[10]),
                            array("label"=> "December", "y"=> $monthSales[11]),

                        );

                        /** Week */
                        function dayOnly($year,$month,$day) {
                            $dto = new DateTime();
                            $dto->setDate($year,$month,$day);
                            for($i=0; $i<7; $i++){
                                $ret[''.$i.'']= $dto->format('d');
                                $dto->modify('+1 days');
                                
                            }
                            
                            return $ret;
                          }
                          function weekOnly($year,$month,$day) {
                            $dto = new DateTime();
                            $dto->setDate($year,$month,$day);
                            for($i=0; $i<7; $i++){
                                $ret[''.$i.'']= $dto->format('d-m-Y');
                                $dto->modify('+1 days');
                                
                            }
                            
                            return $ret;
                          }

                          

                          $year = date('Y',strtotime('-2 days'));
                          $month = date('m',strtotime('-2 days'));
                          $day = date('d',strtotime('-2 days'));
                          $week_array = dayOnly($year,$month,$day);
                          $week_display = weekOnly($year,$month,$day);

                        for($i=0; $i<7; $i++){
                            $week_day=$week_array[''.$i.''];

                            $weekQuery = mysqli_query($conn,"SELECT*,
                            SUM(P.TICKET_QTY*T.MATCH_PRICE) AS TOTAL_SUM_WEEK, DAY(P.DATE_PAYMENT) AS WEEK_PAYMENT
                            FROM PAYMENT P,TICKETMATCH M, TEMP_TICKET T
                            WHERE P.MATCH_ID = M.MATCH_ID AND M.TEMP_ID = T.TEMP_ID
                            AND DATE_PAYMENT between SUBDATE(NOW(),INTERVAL 1 WEEK) AND NOW() AND DAY(P.DATE_PAYMENT) = '$week_day'
                            GROUP BY DATE_PAYMENT ASC");

                            $countRowWeek = mysqli_num_rows($weekQuery);

                            if($countRowWeek==0){
                                $weekSales[$i] = 0;}
                            else{
                                while($result = mysqli_fetch_assoc($weekQuery)){
                                        $weekSales[$i] = $result['TOTAL_SUM_WEEK'];
                                    
                                }
                            }
                        

                        }


                        $dataPointsWeek = array(
                            
                            array("label"=> $week_display['0'], "y"=> $weekSales[0]),
                            array("label"=> $week_display['1'], "y"=> $weekSales[1]),
                            array("label"=> $week_display['2'], "y"=> $weekSales[2]),
                            array("label"=> $week_display['3'], "y"=> $weekSales[3]),
                            array("label"=> $week_display['4'], "y"=> $weekSales[4]),
                            array("label"=> $week_display['5'], "y"=> $weekSales[5]),
                            array("label"=> $week_display['6'], "y"=> $weekSales[6]),
                        );

                        
                    ?>
                <script>
                    window.onload = function () {
 
                    var chartMonth = new CanvasJS.Chart("chartContainer-month", {
                        animationEnabled: true,
                        exportEnabled: true,
                        theme: "light1", // "light1", "light2", "dark1", "dark2"
                        title:{
                            text: "Football Association Sales Review (Month)"
                        },
                        axisY:{
                            includeZero: true,
                            prefix: 'RM '
                        },
                        data: [{
                            type: "column", //change type to bar, line, area, pie, etc
                            //indexLabel: "{y}", //Shows y value on all Data Points
                            indexLabelFontColor: "#5A5757",
                            indexLabelPlacement: "outside",   
                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                        }]
                    });

                    var chartWeek= new CanvasJS.Chart("chartContainer-week", {
                        animationEnabled: true,
                        exportEnabled: true,
                        theme: "light1", // "light1", "light2", "dark1", "dark2"
                        title:{
                            text: "Football Association Sales Review (Week)"
                        },
                        axisY:{
                            includeZero: true,
                            prefix: 'RM '
                            
                        },
                        data: [{
                            type: "column", //change type to bar, line, area, pie, etc
                            //indexLabel: "{y}", //Shows y value on all Data Points
                            indexLabelFontColor: "#5A5757",
                            indexLabelPlacement: "outside",   
                            dataPoints: <?php echo json_encode($dataPointsWeek, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chartWeek.render();
                    chartMonth.render();
                    
                    }
                </script>

                    <div class="sales-container">
                        <div id="chartContainer-month"></div>
                        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                    </div>
                    <br><br>
                    <div class="sales-container">
                        <div id="chartContainer-week"></div>
                        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                    </div>
                </div>
            </div>
            <footer class = "footer-1">
                <div class="footer-text">
                    <h3>All Rights Reserved.</h3>
                    <a href="https://sites.google.com/view/danielsyauqi/home?authuser=0"><p>Made by Syauqi 2024.</p></a>
                </div>
            </footer>

        <?php ?>
    </body>
</html>