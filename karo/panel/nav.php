<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class='container-fluid'>
        <div class='d-sm-flex align-items-sm-center'>
            

<a href='?site=profile' class='nav-link d-sm-flex align-items-sm-center'> 

          <img
            src="img/avatars/avatar (<?=$user['user_avatar']?>).png"
            class="rounded-circle"
            height="40"

          />
          
          <strong class="d-none d-sm-block ms-1"><?=$user['user_name']?></strong>
          </a>
        </div>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
            data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                $_config = new mysqli("localhost","phpmyadmin","Damian#3","_config");
                         $sql = "SELECT * FROM con_system_nav WHERE nav_prv<=".$user['user_privilage']." AND `nav_group`=0 AND `nav_sort` IS NOT NULL ORDER BY nav_sort ASC";
                                    $result = mysqli_query($_config, $sql);
                                    while($row = mysqli_fetch_array($result)){

                                        if($_GET['site']==$row['nav_href']){
                                            ?>
                <li class='nav-item'>
                    <a class='nav-link active' aria-current="page"
                        href='?site=<?=$row['nav_href']?>'><?=$row['nav_subject']?></a>
                </li>
                <?php
                                        }else{
                                            ?>
                <li class='nav-item'>
                    <a class='nav-link' href='?site=<?=$row['nav_href']?>'><?=$row['nav_subject']?></a>
                </li>
                <?php
                                        }
                                
                                    }
                                   $sql = "SELECT * FROM `con_system_nav_custom` WHERE `nav_href` IN ('".$user['user_abs_prv']."')";
                                   $result = mysqli_query($conn, $sql);
                                   while($row = mysqli_fetch_array($result)){
                                    if($_GET['site']==$row['nav_href']){
                                                                                   ?>
                <li class='nav-item'>
                    <a class='nav-link active' aria-current="page"
                        href='?site=<?=$row['nav_href']?>'><?=$row['nav_subject']?></a>
                </li>
                <?php
                                    }else{
                                                                                   ?>
                <li class='nav-item'>
                    <a class='nav-link' href='?site=<?=$row['nav_href']?>'><?=$row['nav_subject']?></a>
                </li>
                <?php
                                    }
                                   }
                                  $sql = "SELECT * FROM con_system_nav_group WHERE group_prv<=".$user['user_privilage']." ORDER BY `group_order` ASC ";
                                    $result = mysqli_query($_config, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                                                           ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-mdb-toggle="dropdown" aria-expanded="false">
                        <?=$row['group_name']?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                                        $sql2 = "SELECT * FROM con_system_nav WHERE nav_group=".$row['group_id'];
                                        $result2 = mysqli_query($_config, $sql2);
                                        while($row2 = mysqli_fetch_array($result2)){
                                            ?>
                                            <li><a class="dropdown-item" href='?site=<?=$row2['nav_href']?>' > <?=$row2['nav_subject']?> </a></li>
                <?php
                                        }
                                        ?>
                                        </ul>



                <?php
                                    }
                            ?>
                <li class='nav-item' >
<a class='nav-link' href='destroy.php'>
                    Wyloguj się
                </a>
                                </li>
            </ul>
        </div>
    </div>
</nav>