<div class="jumbotron" id="loginJumbo">
    <div class="container">
        <div class="login-container">
            <div class="brand"></div>
            <div class="login-form-box">
                <form method="POST">
                    <input name="email" type="text" placeholder="E-Mail">
                    <input name="password" type="password" placeholder="Passwort">
                    <button class="btn btn-info btn-block login" type="submit">Login</button>
                </form>
            </div>
            <div><!-- Flashes -->
                <?php if(!empty($flashes = $this->flashes('error'))): ?>
                    <?php foreach($flashes as $flash): ?>
                        <?php  var_dump($flash); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <hr class="softHr">
            <p id="signUp">Not registered yet?<br><a href="signUp">SignUp now</a></p>
        </div>
    </div>
</div>
