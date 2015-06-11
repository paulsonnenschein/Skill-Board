<div class="jumbotron" id="loginJumbo">
    <div class="container">
        <div class="login-container">
            <div class="brand"></div>
            <div class="login-form-box">
                <form method="POST">
                    <input name="email" placeholder="E-Mail" autofocus="autofocus">
                    <input name="password" type="password" placeholder="Passwort">
                    <button class="btn btn-info btn-block login" type="submit">Login</button>
                </form>
            </div>
            <div><!-- Flashes -->
                <?php if(!empty($flashes = $this->flashes('login-error'))): ?>
                    <hr/>
                    <div class="alert alert-danger" role="alert">
                    <?php foreach($flashes as $flash): ?>
                        <?=$flash ?>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <hr class="hr">
            <p id="signUp">Not registered yet?<br><a href="signup">Sign Up now</a></p>
        </div>
    </div>
</div>
