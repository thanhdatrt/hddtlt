<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="public/src/images/logo1.png">
    <link rel="icon" type="image/png" sizes="16x16" href="public/src/images/logo1.png">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="public/login/fonts/icomoon/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="public/login/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="public/login/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="public/login/css/style.css">

    
  </head>
  <body>
  

  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="public/src/images/logo1.png" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3 class="center">Sign In</h3>
              
            </div>
            <?php
                $message = Session::get('message');
                if($message) {
                    echo '<span class="warning_mes">'.$message.'</span>';
                    Session::put('message', null);
                }
            ?>
            <form action="{{URL::to('/dashboard')}}" method="post">
              {{ csrf_field() }}
              <div class="form-group first">
                <label for="username">Email</label>
                <input type="email" name="email" class="form-control" id="username">

              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password">
                
              </div>

              <input type="submit" value="Log In" name="login" class="btn btn-block btn-primary">

              <span class="d-block text-left my-4 text-muted">&mdash; or login with &mdash;</span>
              
              <div class="social-login">
                <a href="#" class="facebook">
                  <span class="icon-facebook mr-3"></span> 
                </a>
                <a href="#" class="twitter">
                  <span class="mr-3"><i class="fa-brands fa-windows"></i></span> 
                </a>
                <a href="#" class="google">
                  <span class="icon-google mr-3"></span> 
                </a>
              </div>
            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  
    <script src="public/login/js/jquery-3.3.1.min.js"></script>
    <script src="public/login/js/popper.min.js"></script>
    <script src="public/login/js/bootstrap.min.js"></script>
    <script src="public/login/js/main.js"></script>
  </body>
</html>