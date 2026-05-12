<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Astro v5.13.2">
    <title><?=$title?></title>
    <?=$_css?>
    <link rel="apple-touch-icon" href="https://getbootstrap.com//docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com//docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com//docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com//docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com//docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="https://getbootstrap.com//docs/5.3/assets/img/favicons/favicon.ico">

    <meta name="theme-color" content="#712cf9">
    <style>.bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item"><a class="nav-link" href="<?=base_url()?>"><i class="fa fa-home me-1"></i>HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="<?=base_url("pegawai")?>"><i class="fa fa-user me-1"></i>PEGAWAI</a></li>
                <li class="nav-item"><a class="nav-link" href="<?=base_url("users")?>"><i class="fa fa-user me-1"></i>USER</a></li>

            </ul>
            <form class="d-flex" role="search">
                <a href="<?=base_url("auth/logout")?>" class="btn btn-outline-danger" >LOGOUT</a>
            </form>
        </div>
    </div>
</nav>

<main class="container" id="<?=($_page_id)?>" style="margin-top: 70px">
    <h4 class="mb-15"><?=$title?></h4>
    <?=$this->renderSection("content")?>


    <div class="modal" tabindex="-1" id="modal-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="modal-preview">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="modal-viewer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    var base_url = "<?=base_url()?>";
    var CONFIG      = {
        AJAX_RESULT_SUCCESS : "success",
        AJAX_RESULT_ERROR   : "error",
        AJAX_RESULT_HOLD    : "hold",
        AJAX_RESULT_ABORT   : "abort",
    };
</script>
<?=$_js?>
</body>
</html>