<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <?php
    if(isset($_COOKIE['lang'])){
        if($_COOKIE['lang'] == 'kz'){
            require_once 'lang/kz.php';
        }elseif($_COOKIE['lang'] == 'ru'){
            require_once 'lang/ru.php';
        }elseif($_COOKIE['lang'] == 'en'){
            require_once 'lang/en.php';
        }
    }else{
        require_once 'lang/en.php';
    }
    ?>
    <title><?php echo $welPWords['title']; ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse  justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <b><?php echo $welPWords['lang']; ?></b>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if($welPWords['lang'] != 'KZ'){ ?>
                        <li><a class="dropdown-item" href="set.php?lang=kz">KZ</a></li>
                        <?php }
                            if($welPWords['lang'] != 'RU'){
                        ?>
                        <li><a class="dropdown-item" href="set.php?lang=ru">RU</a></li>
                        <?php }
                            if($welPWords['lang'] != 'EN'){
                        ?>
                        <li><a class="dropdown-item" href="set.php?lang=en">EN</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="authAndReg.php"><?php echo $welPWords['login']; ?></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
            </div>
        </div>
    </div>
</div>

    <footer class="py-5 bg-blue">
        <div class="container"><p class="m-0 text-center text-black">Copyright © Your Website 2021</p></div>
    </footer>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>