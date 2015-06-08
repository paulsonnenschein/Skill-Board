<!doctype html>
<html lang="de">
<head>
    <title>Skill-Board</title>
    <base href="<?=App::getBaseUrl() ?>"/>

    <!-- Meta tags-->
    <meta charset="UTF-8">
    <meta name="author" content="Skill-Board AG"/>
    <meta name="distributor" content="Skill-Board AG"/>
    <meta name="description" content="Skill-Board Projekt"/>
    <meta name="keywords" content="Skills, IT, information engineer, skill-board, skill"/>
    <meta name="copyright" content="&copy;2014 Skill-Board"/>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../public/assets/images/logo.png">
    <link rel="apple-touch-icon" href="../../public/assets/images/logo.png">

    <!-- Robots -->
    <meta name="googlebot" content="all"/>
    <meta name="robots" content="all"/>

    <!-- Icons -->
    <link rel="shortcut icon" href="img/icons/favicon/favicon.png">
    <link rel="apple-touch-icon" href="img/icons/appleTouch/apple-touch-icon.png">

    <!-- CSS -->
    <link rel="stylesheet" media="all" href="assets/css/style.css">
    <link rel="stylesheet" media="all" href="assets/css/bootstrap.min.css">

    <!-- JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="assets/javascript/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand-centered">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar">s</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand navbar-brand-centered">Skill-Board</div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-brand-centered">
                <ul class="nav navbar-nav">
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        <?php $this->yieldView(); // Render Page Content ?>
    </div>

</body>
</html>
