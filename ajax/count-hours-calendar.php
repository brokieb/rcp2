<?php
include ("default.php");
$sql = "SELECT *,`accepted_days`.`accept_id` as `id_prim` FROM `accepted_days` LEFT JOIN add_time ON `accepted_days`.accept_id=`add_time`.accept_id WHERE `user_id`=".$_SESSION['user_id']." AND EXTRACT(MONTH FROM accept_date)=".$_GET['month']."  ORDER BY accept_date ASC";
$result = mysqli_query($conn, $sql);
$times = [];
$answer = [];

$times = [];
while($row = mysqli_fetch_array($result)){
    $plus = [];
    switch($row['accept_type']){
        case "0":
            $ans = "NIEZAAKCEPTOWANOXX";
            $color = "red";
            $type = "1";
            break;
            case "1":
                if($row['addtime_id']!='0'){
                   switch($row['znak']){
                        case '0':
                            $plus[] = $row['accept_hours'];
                            $plus[] = $row['addtime_time'];
                             $this_czas  = minusTimes($plus);//minus
                             $times[]  = $this_czas;
                        break;
                        case '1':
                            $plus[] = $row['accept_hours'];
                            $plus[] = $row['addtime_time'];
                            $this_czas = addTime($plus);
                            $times[]  = $this_czas;
                        break;
                        default:
                        $this_czas = $row['accept_hours'];
                    $times[]  = $this_czas;
                        break;
                   }
                }else{
                    $this_czas = $row['accept_hours'];
                    $times[]  = $this_czas;
                }
              $ans = "ZAAKCEPTOWANXO";
              $color = "green";
              $type = "2";
              
            break;
    }
$answer[]=[
  "id"=> $row['id_prim'],
  "name"=> $ans,
  "date"=> $row['accept_date'],
  "type"=> $type,
  "color"=> $color,
  "description"=> "godziny: ". $this_czas,
  "comment"=> $row['accept_comment']
];
}


$sql2 = "SELECT * FROM `records` LEFT JOIN accepted_days ON records.user_id=accepted_days.user_id AND records.record_date=accepted_days.accept_date WHERE records.`user_id`=".$_SESSION['user_id'] ." AND record_date!=CURDATE() AND EXTRACT(MONTH FROM record_date)=".$_GET['month']." AND `record_date`<='2021-03-25' AND accept_id  IS NULL GROUP BY record_date" ;
$result2 = mysqli_query($conn, $sql2);

while($row2 = mysqli_fetch_array($result2)){


$sql = "SELECT *  FROM `records` WHERE records.`user_id`=".$_SESSION['user_id'] ." AND record_date='".$row2['record_date']."' AND (`record_type`=1 OR `record_type`=0)";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){//oczekujące



    $praca[] = timeDiff($row['record_in_time'],$row['record_out_time']);
    
    
}
$answer[]=[
  "id"=> $row2['record_id'],
  "name"=> "OCZEKUJE",
  "date"=> $row2['record_date'],
  "type"=> "0",
  "color"=> "yellow",
  "description"=> "godziny: ".addTime($praca),
  "comment"=> $row2['record_comment']
];

}




$sql2 = "SELECT * FROM `records_new` LEFT JOIN accepted_days ON records_new.user_id=accepted_days.user_id AND records_new.record_date=accepted_days.accept_date WHERE records_new.`user_id`=".$_SESSION['user_id'] ." AND record_date!=CURDATE() AND `record_date`>='2021-03-26' AND EXTRACT(MONTH FROM record_date)=".$_GET['month']." AND accept_id IS NULL GROUP BY record_date" ;
$result2 = mysqli_query($conn, $sql2);

while($row2 = mysqli_fetch_array($result2)){
    $praca = [];


$sql = "SELECT *  FROM `records_new` WHERE records_new.`user_id`=".$_SESSION['user_id'] ." AND record_date='".$row2['record_date']."' AND `record_event`=1";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){//oczekujące



    $praca[] = timeDiff($row['record_in_time'],$row['record_out_time']);
    
    
}
$answer[]=[
  "id"=> $row2['record_id'],
  "name"=> "OCZEKUJE",
  "date"=> $row2['record_date'],
  "type"=> "0",
  "color"=> "yellow",
  "description"=> "godziny: ".addTime($praca),
  "comment"=> $row['record_comment']
];

}

$sql2 = "SELECT * FROM `absent` WHERE `user_id`=".$_SESSION['user_id'].";";
$result2 = mysqli_query($conn, $sql2);

while($row2 = mysqli_fetch_array($result2)){
    $answer[]=[
        "id"=> "A".$row2['abs_id'],
        "name"=> "PLAN. NIEOBECNOŚĆ",
        "date"=> [$row2['abs_from'],$row2['abs_to']],
        "type"=> "3",
        "color"=> "purple",
        "description"=> "ADD",
        "comment" => "Dodatkowa informaj"
      ];
}

$ans=["ids"=>$answer,"czas"=>AddTime($times)];
echo json_encode($ans);
?>