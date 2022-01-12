<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class='modal-dialog modal-xl'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row justify-content-between">
                
            </div>
    </div>
</div>

</div>
<main class='min-vh-100 my-3 d-flex justify-content-center align-items-center'>
    <?php

if(isset($_GET['site'])){
    $sql = "SELECT * FROM con_system_nav WHERE nav_href='".$_GET['site']."' AND nav_prv<=".$user['user_privilage']." LIMIT 1";
    $result = mysqli_query($_config, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(empty($row)){
        $sql2 = "SELECT * FROM `con_system_nav_custom` WHERE `nav_href` IN ('".$_GET['site']."')";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
        if(empty($row2)){
            include("nav/default.php");
        }else{
            include("nav/".$row2['nav_href']."/index.php");
        }
    }else{
        include("nav/".$_GET['site'].".php");

}
}else{
    $sql1 = "SELECT nav_href FROM `con_system_nav` WHERE nav_prv<=".$user['user_privilage']." LIMIT 1";
    $sql2 = "SELECT nav_href FROM `con_system_nav_custom` WHERE nav_href IN ('".$user['user_abs_prv']."') LIMIT 1";
    $result1 = mysqli_query($_config, $sql1);
    $row2 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
    $result2 = mysqli_query($conn, $sql2);
    $row1 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    if($row1 && $row2){
        $row = array_merge($row1,$row2);
    }else if($row1){
        $row = $row1;
    }else if($row2){
        $row = $row2;
    }
    echo "<script>window.location.replace('index.php?site=".$row['nav_href']."');</script>";
}
?>
</main>