<div class="container">
    <h1>Profile Bearbeiten</h1>
    <form class="form-horizontal" action='profile/edit' method='post'>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">Vorname</label>
                <input class="form-control" type="text" id='firstName' name="firstName" value="<?php echo $this->user['data']['firstName']; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">Nachname</label>
                <input class="form-control" type="text" id='lastName' name="lastName" value="<?php echo $this->user['data']['lastName']; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">E-Mail</label>
                <input class="form-control" type="email" id='email' name="email" value="<?php echo $this->user['data']['email']; ?>" />
            </div>
        </div>
        <div class='form-group'>
            <div class='col-lg-10'>
                <label class='control-label'>Beschreibung</label><br>
                <textarea class='form-control' name='description' rows='5' maxlength='400' ".$required." ><?php echo nl2br($this->user['data']['description']); ?></textarea>
            </div>
        </div>
        <div class='form-group'>
            <div class='col-lg-10'>
                <label class='control-label'>Programmiersprachen (mit komma separieren)</label><br>
                <textarea class='form-control' name='programmingLanguages' rows='5' maxlength='400' ".$required." ><?php
                $skills = '';
                foreach($this->user['skill'] AS $skill){
                    $skills .= $skill['name'].',';
                }
                echo substr($skills,0,-1);
                ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">Passwort</label>
                <input class="form-control" type="password" id='password' name="password" value="" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">Passwort bestätigen</label>
                <input class="form-control" type="password" id='password2' name="password2" value="" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Er ist tot, Jim!</button>
        <button type="reset" class="btn btn-default">Nein, ich bin ein Knopf</button>
    </form>
    <br>
    <br>
</div>
