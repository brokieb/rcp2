
<nav>
        <div class='responsive'>
            <h1><?=$user['user_name']?> <div class='status-led'></div></h1>
            <div class='desktop-menu' data-site='<?=$_GET['site']?>'>
                <?php
                // if(!isset($_GET['site'])){
                //     header("location:index.php?site=checks");
                // }
                         $sql = "SELECT * FROM con_system_nav WHERE nav_prv<=".$_SESSION['prv']." AND `nav_group`=0 ORDER BY nav_sort ASC";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){

                                        if($_GET['site']==$row['nav_href']){
                                            echo "<a href='?site=".$row['nav_href']."' class='active'><i class='fa-2x fa-".$row['nav_icon']."'></i><span>".$row['nav_subject']."</span></a> ";
                                        }else{

                                            echo "<a href='?site=".$row['nav_href']."'><i class='fa-2x fa-".$row['nav_icon']."'></i><span>".$row['nav_subject']."</span></a> ";
                                        }
                                
                                    }
                                   $sql = "SELECT * FROM `con_system_nav_custom` WHERE `nav_href` IN ('".$user['user_abs_prv']."')";
                                   $result = mysqli_query($conn, $sql);
                                   while($row = mysqli_fetch_array($result)){
                                    if($_GET['site']==$row['nav_href']){
                                        echo "<a href='?site=".$row['nav_href']."' class='active'><i class='fa-2x fa-".$row['nav_icon']."'></i><span>".$row['nav_subject']."</span></a> ";
                                    }else{

                                        echo "<a href='?site=".$row['nav_href']."'><i class='fa-2x fa-".$row['nav_icon']."'></i><span>".$row['nav_subject']."</span></a> ";
                                    }
                                   }
                                  $sql = "SELECT * FROM con_system_nav_group WHERE group_prv<=".$_SESSION['prv']." ORDER BY `group_order` ASC ";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<span class='group-toggle'><a class='group-link' href='#' ><i class='fa-2x fa-".$row['group_icon']."'></i><span></span></a> ";
                                        $sql2 = "SELECT * FROM con_system_nav WHERE nav_group=".$row['group_id'];
                                        $result2 = mysqli_query($conn, $sql2);
                                        echo "<ul style='display:none'>";
                                        while($row2 = mysqli_fetch_array($result2)){
                                            ?>
                                            <li><a href='?site=<?=$row2['nav_href']?>'><i class='fa-2x fa-<?=$row2['nav_icon']?>'></i><?=$row2['nav_subject']?></a></li>
                                            <?php
                                        }
                                        echo "</ul></span>";
                                        ?>
                                        
                                            

                                        <?php
                                    }
                            ?>
                            <a href='destroy.php'><i class="fas fa-2x fa-power-off"></i></a>
            </div>          
            <i class="mobile-menu fas fa-bars fa-2x menu-toggle"></i>
            <div class='slidingMenu'>
                <div class='slideDefault'>
                    <div class='links'>

                                                        <p>Witaj <strong><?=$_SESSION['user_name']?></strong></p>
<?php
                            $sql = "SELECT * FROM con_system_nav WHERE nav_prv<=".$_SESSION['prv']." ";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        if($_GET['site']==$row['nav_href']){
                                            echo "<a href='?site=".$row['nav_href']."' class='active'><i class='fas fa-2x fa-".$row['nav_icon']."'></i><span>".$row['nav_subject']."</span></a> ";
                                        }else{

                                            echo "<a href='?site=".$row['nav_href']."'><i class='fas fa-2x fa-".$row['nav_icon']."'></i><span>".$row['nav_subject']."</span></a> ";
                                        }
                                    }
                    ?>
                    <a href='destroy.php'>Wyloguj się</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>