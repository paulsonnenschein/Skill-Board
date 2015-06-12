<div class="jumbotron" id="loginJumbo">
    <div class="container">
        <div class="signup-container">
            <div class="brand"></div>
            <div class="signup-form-box">
                <form method="POST">
                    <input class="top" name="firstName" type="text" placeholder="Vorname">
                    <input class="middle" name="lastName" placeholder="Nachname">
                    <input class="bottom" name="email" placeholder="E-Mail">
                    <hr class="hr">
                    <input class="top" name="password" type="password" placeholder="Passwort">
                    <input class="bottom" name="confirmPassword" type="password" placeholder="Passwort Bestätigen">
                    <button class="btn btn-info btn-block login" type="submit">Sign Up</button>
                </form>
            </div>
            <div><!-- Flashes -->
                <?php if(!empty($flashes = $this->flashes('signup-error'))): ?>
                    <hr class="hr"/>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach($flashes as $flash): ?>
                            <?=$flash ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <hr class="hr">
            <p id="login">
                Already have an Account?
                <br>
                <a href="login">Login now</a>
            </p>
        </div>
    </div>
</div>
