<?php 
  require ("fpdf.php");
  include ("..\php\phpqrcode\qrlib.php");
  session_start();
    include ('../php/config.php');
        $ticketQty = $_POST['quantity'];
        $matchID = $_POST['match_id'];
    

    if (isset($_SESSION['valid'])){
    $id = $_SESSION['ID'];       
    $query = mysqli_query($conn,"SELECT*FROM CUSTOMER WHERE CUST_ID = '$id'");
    while($result = mysqli_fetch_assoc($query)){
        $res_email = $result['CUST_EMAIL'];
        $res_icname = strtoupper($result['CUST_IC_NAME']);
        $res_icnum = strtoupper($result['CUST_IC_NUM']);
        
    }

    }  

    $ticketQuery = mysqli_query($conn,"SELECT*FROM TICKETMATCH M, TEMP_TICKET T, FA F WHERE T.TEMP_ID = M.TEMP_ID
    AND F.FA_ID = T.MATCH_HOME AND M.MATCH_ID = '$matchID'");

    while($result = mysqli_fetch_assoc($ticketQuery)){
        $match_home = strtoupper($result['TEAM_NAME']);
        $match_price = $result['MATCH_PRICE'];
        $match_date = date("d F Y", strtotime($result['MATCH_DATE']));
        $match_time = date("h:i a", strtotime($result['MATCH_TIME']));
        $match_venue = strtoupper($result['MATCH_VENUE']);

        $totalPrice = $match_price*$ticketQty;
    }
    $ticketQueryAway = mysqli_query($conn,"SELECT*FROM TICKETMATCH M, TEMP_TICKET T, FA F WHERE T.TEMP_ID = M.TEMP_ID
    AND F.FA_ID = T.MATCH_AWAY AND M.MATCH_ID = '$matchID'");
    while($result2 = mysqli_fetch_assoc($ticketQueryAway)){$match_away = strtoupper($result2['TEAM_NAME']);}

    

  //customer and invoice details
  $info=[
    "customer"=>$_POST['name'],
    "email"=>$_POST['email'],
    "icnumber"=>$_POST['icnum'],
    "invoice_no"=>$_POST['invoice'],
    "invoice_date"=>date("d-m-Y"),
  ];

  $_SESSION['credential'] = $_POST['credential'];
  $_SESSION['credential'] = null;
  
  //invoice Products
  $products_info=[
    
    $matchTitle = "LIGA SUPER MALAYSIA 2024: ",

      "title"=>$matchTitle,
      "home"=>$_POST['home'],
      "away"=> $_POST['away'],
      "price"=>number_format($_POST['price'], 2),
      "qty"=>$_POST['quantity'],
      "total"=>number_format($_POST['totalPrice'], 2),
    

  ];
  
  $invoiceNum = $_POST['invoice'];
  $qty = $_POST['quantity'];
  $date = date("Y-m-d");
  $insertQuery = mysqli_query($conn,"INSERT INTO PAYMENT VALUES ('$invoiceNum','$qty','$date','$id','$matchID')");

  /**if(!is_dir("../pdf/customer/ticket/".$id)){
    mkdir("../pdf/customer/receipt/".$id);
  }*/

  class PDF extends FPDF
  {
        function one(){
      
      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,5,"MALAYSIA FOOTBALL LEAGUE",0,1);
      $this->SetFont('Arial','',13);
      $this->Cell(50,7,"TICKETING SYSTEM",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,3,"",0,1);
      $this->Cell(50,5,"Arena Futsal FAM, Jalan SS5A/9, Kelana Jaya,",0,1);
      $this->Cell(50,5,"Petaling Jaya,Malaysia.",0,1);
      $this->Cell(50,5,"PH : 03-7865 6996",0,1);
      
      //Display INVOICE text
      $this->SetY(32);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Image('../img/MFL LOGO.png',150,8,50,0);
      $this->Cell(60,10,"INVOICE",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info,$products_info){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,5,$info["customer"],0,1);
      $this->Cell(50,7,$info["email"],0,1);
      $this->Cell(50,5,$info["icnumber"],0,1);
      
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice No : ".$info["invoice_no"]);
      
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);
      
      //Display Table headings
      $this->SetY(95);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(80,9,"DESCRIPTION",1,0);
      $this->Cell(40,9,"PRICE",1,0,"C");
      $this->Cell(30,9,"QTY",1,0,"C");
      $this->Cell(40,9,"TOTAL",1,1,"C");
      $this->SetFont('Arial','',12);
      
      //Display table product rows

        $this->Cell(80,9,$products_info["title"],"LR",0);
        $this->Cell(40,9,$products_info["price"],"R",0,"R");
        $this->Cell(30,9,$products_info["qty"],"R",0,"C");
        $this->Cell(40,9,$products_info["total"],"R",1,"R");
        $this->SetFont('Arial','',10);
        $this->Cell(80,5,$products_info["home"],"LR",0);
        $this->Cell(40,5,"","R",0,"R");
        $this->Cell(30,5,"","R",0,"C");
        $this->Cell(40,5,"","R",1,"R");
        $this->Cell(80,5,"vs","LR",0);
        $this->Cell(40,5,"","R",0,"R");
        $this->Cell(30,5,"","R",0,"C");
        $this->Cell(40,5,"","R",1,"R");
        $this->Cell(80,5,$products_info["away"],"LR",0);
        $this->Cell(40,5,"","R",0,"R");
        $this->Cell(30,5,"","R",0,"C");
        $this->Cell(40,5,"","R",1,"R");

      
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(80,9,"","LR",0);
        $this->Cell(40,9,"","R",0,"R");
        $this->Cell(30,9,"","R",0,"C");
        $this->Cell(40,9,"","R",1,"R");
      }
      //Display table total row
      $this->SetFont('Arial','B',12);
      $this->Cell(150,9,"TOTAL",1,0,"R");
      $this->Cell(40,9,$products_info["total"],1,1,"R");
      
      //Display amount in words
      $this->SetY(225);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,9,"\"Majulah Sukan Untuk Negara\" ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(0,9,"With cooperation of Football Association Malaysia (FAM)",0,1);
      
    }
    function last(){
      
      //set footer position
      $this->SetY(-70);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,"CERTIFIED RECEIPT",0,1,"R");
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('Arial','',10);
      
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
    function Ticket($quantity){
      

      //Display Company Info
      $link = "localhost:8080/mfl/php/index.php";
      
      if(!is_dir("../cust/ticket/".$_POST['match_id'])){
        mkdir("../cust/ticket/".$_POST['match_id']);
        QRcode::png($link,'../cust/ticket/'.$_POST['match_id'].'/'.$_POST['ticket_id'.$quantity].'.png','H',4,4);
      }else{
      QRcode::png($link,'../cust/ticket/'.$_POST['match_id'].'/'.$_POST['ticket_id'.$quantity].'.png','H',4,4);
      }
        
      $this->SetLineWidth(0.3);
      $this->Cell(190,55,"",1,0,'C');
      
      $this->Cell(80,5,"",0,1);
      $this->SetFont('Arial','B',12);
      $this->Cell(67,5,"MALAYSIA FOOTBALL LEAGUE",0,0);
      $this->SetFont('Arial','',12);
      $this->Cell(80,5,"TICKETING SYSTEM",0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(30,5,"",0,1);
      $this->Cell(150,7,"LIGA SUPER MALAYSIA 2024:",0,1,'C');
      $this->SetFont('Arial','B',14);
      $this->Cell(150,5,$_POST['home'],0,1,'C');
      $this->Cell(150,5,"vs",0,1,'C');
      $this->Cell(150,5,$_POST['away'],0,1,'C');
      $this->SetFont('Arial','',12);
      $this->Cell(30,5,"",0,1);
      $this->Cell(20,5,"DATE: ",0,0,'R');
      $this->SetFont('Arial','B',12);
      $this->Cell(20,5,$_POST['date'],0,0,'L');
      $this->SetFont('Arial','',12);
      $this->Cell(50,5,"TIME: ",0,0,'R');
      $this->SetFont('Arial','B',12);
      $this->Cell(10,5,$_POST['time'],0,0,'L');
      $this->SetFont('Arial','',12);
      $this->Cell(50,5,"TICKET NO. ",0,0,'R');
      $this->SetFont('Arial','B',12);
      $this->Cell(10,5,$_POST['ticket_id'.$quantity],0,1,'L');
      $this->SetFont('Arial','',12);
      $this->Cell(23,5,"VENUE: ",0,0,'R');
      $this->SetFont('Arial','B',12);
      $this->Cell(60,5,$_POST['venue'],0,0,'L');
      $this->SetFont('Arial','',12);
      $this->SetFont('Arial','',12);
      $this->Cell(70,5,"SEAT:",0,0,'R');
      $this->SetFont('Arial','B',13);
      $this->Cell(20,5,"OPEN",0,0,'R');

      $this->Image('../img/MFL LOGO.png',150,13,40,0);
      $this->Image('../cust/ticket/'.$_POST['match_id'].'/'.$_POST['ticket_id'.$quantity].'.png',150,27,20,0);
      $this->Ln(30);
      
      //Display Horizontal line 
      
    }
  }

    
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->one();
  $pdf->body($info,$products_info);
  $pdf->last();
  for($i =0; $i<$_POST['quantity']; $i++){
    $pdf->AddPage();
    $pdf->Ticket($i); 
  }
  
  if(!is_dir("../cust/receipt/".$id)){
    mkdir("../cust/receipt/".$id);
  $pdf->Output('../cust/receipt/'.$id.'/'.$invoiceNum.'.pdf',"F");
  }else{
  $pdf->Output('../cust/receipt/'.$id.'/'.$invoiceNum.'.pdf',"F");
  }
?>