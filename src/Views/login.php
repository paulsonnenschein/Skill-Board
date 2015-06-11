<div class="jumbotron" id="loginJumbo">
    <div class="container">
        <div class="login-container">
            <div class="brand"></div>
            <div class="form-box">
                <form method="POST">
                    <input name="email" placeholder="E-Mail">
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
        </div>
    </div>
</div>
