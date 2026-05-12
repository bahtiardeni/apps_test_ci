
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url("public/plugins/jquery-confirm/jquery-confirm.css")?>" rel="stylesheet"/>
    <link href="<?=base_url("public/plugins/jquery.Wload/jquery.Wload.css")?>" rel="stylesheet"/>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/5.0/examples/sign-in/signin.css" rel="stylesheet">
</head>
<body class="text-center">

<main class="form-signin">
    <form  method="post" id="form-login">
        <img class="mb-4" src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
            <input type="email" class="form-control" name="email" id="input_email" placeholder="name@example.com">
            <label for="input_email">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password" id="input_password" placeholder="Password">
            <label for="input_password">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" id="btn-sign" type="button">Sign in</button>
    </form>
</main>

<script type="application/javascript">
    var base_url       = "<?=base_url()?>";
</script>
<script src="<?=base_url("public/plugins/jquery/jquery-1.11.3.min.js")?>" type="text/javascript"></script>
<script src="<?=base_url("public/plugins/jquery-confirm/jquery-confirm.js")?>"></script>
<script src="<?=base_url("public/plugins/jquery.Wload/jquery.Wload.js")?>"></script>
<script src="<?=base_url("public/js/common.js?v=".date("YmdHis"))?>" type="text/javascript"></script>
<script src="<?=base_url("public/js/auth.js?v=".date("YmdHis"))?>" type="text/javascript"></script>

</body>
</html>
