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
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand" style="color:white;">Skill-Board</div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="">Home</a></li>
                    <li><a href="profile">Mein Profil</a></li>
                    <li><a href="search">Suche</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
					  <ul class="dropdown-menu" role="menu">
						<li><a data-toggle="modal" data-target="#profile"><span class="glyphicon glyphicon-pencil"></span> Profil bearbeiten</a></li>
						<li><a href="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					  </ul>
					</li>
                    <!--<li><a href="logout"><span class="glyphicon glyphicon-user"></span> Logout</a></li>-->
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
	<!-- Modal -->
	<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Profil bearbeiten</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" action='' method=''>
				<div class="form-group">
					<div class="col-lg-10">
						<label for="name" class="control-label">Vorname</label> 
						<input class="form-control" type="text" id='name' name="name" value="Max" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10">
						<label for="name" class="control-label">Nachname</label> 
						<input class="form-control" type="text" id='name' name="name" value="Mustermann" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10">
						<label for="name" class="control-label">E-Mail</label> 
						<input class="form-control" type="email" id='name' name="name" value="Max.Mustermann@gmail.com" />
					</div>
				</div>
				<div class='form-group'>
					<div class='col-lg-10'>
						<label class='control-label'>Beschreibung</label><br>
						<textarea class='form-control' name='description' rows='5' maxlength='400' ".$required." ></textarea>
					</div>
				</div>
				<div class='form-group'>
					<div class='col-lg-10'>
						<label class='control-label'>Programmiersprachen (mit komma separieren)</label><br>
						<textarea class='form-control' name='description' rows='5' maxlength='400' ".$required." ></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10">
						<label for="name" class="control-label">Passwort</label> 
						<input class="form-control" type="password" id='name' name="name" value="1234" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10">
						<label for="name" class="control-label">Passwort bestätigen</label> 
						<input class="form-control" type="password" id='name' name="name" value="" />
					</div>
				</div>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
			<button type="button" class="btn btn-primary">Änderungen speichern</button>
		  </div>
		</div>
	  </div>
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
    </div>

        <?php $this->yieldView(); // Render Page Content ?>

</body>
</html>
