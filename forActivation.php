<?php
if(isset($_GET)){
    $email = $_GET['email'];
    $hash = $_GET['hash'];
    $note = isset($_GET['note'])?$_GET['note']:'';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <title><?php echo $activationPWords['title']; ?></title>
</head>
<body>
<div class="container">
	<div class="row justify-content-center pt-5">
		<div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    
                    <form method="POST" action="forUsers/confirm.php?
                    <?php
                    echo "hash=$hash&email=$email";
                    if(!empty($note)){
                        echo "&note=$note";
                    }
                    ?>
                    ">
                        <div class="p-5 mb-4 bg-light rounded-3">
                            <div class="container-fluid py-5">
                            <h1 class="display-5 fw-bold">
                            <?php
                                if(!empty($note)){
                                    echo $activationPWords['passMessage'];
                                }else{
                                    echo $activationPWords['regMessage'];
                                }
                            ?>
                            </h1>
                            <p class="col-md-8 fs-4"><?php echo $activationPWords['infoString']; ?></p>
                            <button class="btn btn-primary btn-lg" type="submit"><?php echo $activationPWords['button']; ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php
}else{
    header("Location:index.php");
}
?>
