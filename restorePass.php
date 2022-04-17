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
    <title><?php echo $restorePassPWords['title']; ?></title>
</head>
<body>
<div class="container">
	<div class="row justify-content-center pt-5">
		<div class="col-lg-5">
            <div class="card shadow">
                <div class="card-body">
                        <form method="POST" action="forUsers/action.php?type=passRestore" >
                            <div class="form-group mb-2">
                            <label class=""><?php echo $restorePassPWords['information']; ?></label>
                            </div>
                            <?php
                            if(isset($_GET['error'])){
                                if($_GET['error'] == 'notFoundEmailErr'){
                                    $message = $restorePassPWords['notFoundEmailErr'];
                                }elseif($_GET['error'] == 'mismatchErr'){
                                    $message = $restorePassPWords['mismatchErr'];
                                }elseif($_GET['error'] == 'logAndPassErr'){
                                    $message = $restorePassPWords['LogAndPassErr'];
                                }elseif($_GET['error'] == 'restoreErr'){
                                    $message = $restorePassPWords['LogAndPassErr'];
                                }
                            ?>
                            <div class="form-group mb-2">
                            <label class="text-warning"><?php echo $message; ?></label>
                            </div>
                            <?php    
                            }
                            ?>
                            <div class="form-group">
                                <label for="exampleInputEmail1">E-mail</label>
                                <input required name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E-mail" value="<?php if(isset($_GET['email'])){ echo $_GET['email'];} ?>">
                            </div>
                            <div class="form-group mt-1">
                                <label for="exampleInputPassword1"><?php echo $restorePassPWords['newPassTitle']; ?></label>
                                <input required name="password" type="password" class="form-control" placeholder="<?php echo $restorePassPWords['password']; ?>" minlength="6">
                            </div>
                            <div class="form-group mt-1">
                                <label for="passwordConfirm"><?php echo $restorePassPWords['newConfPassTitle']; ?></label>
                                <input required name="passwordConfirm" id="passwordConfirm" type="password" class="form-control" placeholder="<?php echo $restorePassPWords['password']; ?>" minlength="6">
                            </div>
                            <div class="form-group mt-1">
                            <button type="submit" class="btn btn-primary mt-2"><?php echo $restorePassPWords['button']; ?></button>
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