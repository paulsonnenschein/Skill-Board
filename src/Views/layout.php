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
    <link rel="shortcut icon" href="assets/images/logo.png">
    <link rel="apple-touch-icon" href="assets/images/logo.png">

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
    <script src="assets/javascript/jquery.min.js"></script>
    <script type="text/javascript" src="assets/javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/javascript/bluring.js"></script>
</head>
<body>
    <div class="menu" id="menu">
        <ul class="list-inline">
            <span>
                <img src="assets/images/logo.png" width="100px">
            </span>
            <li><a href="">Home</a></li>
            <li><a href="profile">Mein Profil</a></li>
            <li><a href="search">Suche</a></li>
        </ul>
    </div>

    <div class="container">
        <div><!-- Flashes -->
            <?php if(!empty($flashes = $this->flashes('error'))): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach($flashes as $flash): ?>
                        <?=$flash ?><br/>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($flashes = $this->flashes('info'))): ?>
                <div class="alert alert-info" role="alert">
                    <?php foreach($flashes as $flash): ?>
                        <?=$flash ?><br/>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php $this->yieldView(); // Render Page Content ?>
    </div>

</body>
</html>
