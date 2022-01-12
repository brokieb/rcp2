
<?php
function timeDiff($start,$since){
    list($hoursfrom, $minutesfrom) = explode(':', $since);
    list($hoursto, $minutesto) = explode(':', $start);
    $minutesF = $hoursfrom * 60 + $minutesfrom;
    $minutesT = $hoursto * 60 + $minutesto;
    $ans = $minutesF-$minutesT;
    return sprintf("%02d",floor($ans/60)).":".sprintf("%02d",$ans % 60);
}
function createName($mail){
    $cutted = substr($mail, 0, strpos($mail, "@")); 
    if(strpos($cutted,'.')!==false){
        list($imie,$nazwisko) = explode('.', $cutted);
        $ans[0] = ucfirst($imie);
        $ans[1] = ucfirst($nazwisko);
        
        
    }else{
        $ans[0] = $cutted;
    }
    return $ans;
    

}
function czas_pracy($start,$stop){
    $start_minutes = 0;
    $stop_minutes = 0;
    foreach ($start as $time) {
        list($hours, $minutes) = explode(':', $time);
        $start_minutes += $hours * 60 + $minutes;
    }
    foreach ($stop as $time) {
        list($hours, $minutes) = explode(':', $time);
        $stop_minutes += $hours * 60 + $minutes;
    }
$stop_minutes." ---- ".$start_minutes."<br>";
    $minuty = $stop_minutes-$start_minutes;
    return sprintf("%02d",floor($minuty/60)).":".sprintf("%02d",$minuty % 60);
}


function AddTime($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        if($time!=NULL){
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;

                $minutes += $minute;
            
        }
        
    }
    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}
function minusTimes($times){
    $ans = NULL;
    $minutes = 0;
    foreach ($times as $time) {
        if($time!=NULL){
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
            $mins[] = ($hour * 60) + $minute;
        }
    }
    for($i=1;$i<=count($mins)-1;$i++){
        
        $minutes = $mins[$i-1]-$mins[$i];
    }
    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;
    return sprintf('%02d:%02d', $hours, $minutes);
}
function AddTimeTest($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        if($time!=NULL){
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
           
            
        }
        
    }
    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;
if($minutes>45){
    $minutes = 0;
    $hours += 1;
}
    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}
?>