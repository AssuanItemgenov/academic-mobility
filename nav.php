<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #d1e7dd;">
        <div class="container-fluid">
        <a class="navbar-brand" href="welcome.php">AcademM*</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php
            if(isset($usersInfo['userType']) && ($usersInfo['userType'] != 3) ){
            ?>
            <li class="nav-item">
                <a class="nav-link" href="personalDataList.php" <?php if($data_of_user != null){ echo 'style="pointer-events: none; cursor: default;"'; } ?>><?php echo $welcomePWords['linkToFillIn']; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="preSendData.php" <?php if(!isset($data_of_user['data_status'])){ echo 'style="pointer-events: none; cursor: default;"'; } ?>><?php echo $welcomePWords['linkToResult']; ?></a>
            </li>
            <?php
            }
            if(isset($usersInfo['userType']) && ($usersInfo['userType'] == 3) ){
            ?>
            <li class="nav-item">
                <a class="nav-link" href="requests.php"><?php echo $welcomePWords['linkToRequests']; ?></a>
            </li>
            <?php
            }
            ?>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
            <div class="container-fluid">
                <span class="navbar" href="#">
                <img src="/img/bag.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
                <?php echo $_SESSION['email']; ?>
                </span>
            </div>
            </ul>
            <ul class="navbar-nav mx-lg">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    <b><?php echo $welPWords['lang']; ?></b>
                </a>
                <ul class="dropdown-menu">
                    <?php if($welPWords['lang'] != 'kz'){ ?>
                    <li><a class="dropdown-item" href="set.php?lang=kz">KZ</a></li>
                    <?php }
                        if($welPWords['lang'] != 'ru'){
                    ?>
                    <li><a class="dropdown-item" href="set.php?lang=ru">RU</a></li>
                    <?php }
                        if($welPWords['lang'] != 'en'){
                    ?>
                    <li><a class="dropdown-item" href="set.php?lang=en">EN</a></li>
                    <?php } ?>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="clear.php"><?php echo $welcomePWords['button']; ?></a>
            </li>
            </ul>
        </div>
        </div>
    </nav>