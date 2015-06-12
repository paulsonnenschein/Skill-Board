<div class="container">
    <form class="form-horizontal" action='' method=''>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">Vorname</label>
                <input class="form-control" type="text" id='prename' name="prename" value="" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">Nachname</label>
                <input class="form-control" type="text" id='surname' name="surname" value="" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">E-Mail</label>
                <input class="form-control" type="email" id='email' name="email" value="" />
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
                <textarea class='form-control' name='programmingLanguages' rows='5' maxlength='400' ".$required." ></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <label for="name" class="control-label">Passwort</label>
                <input class="form-control" type="password" id='name' name="name" value="" />
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
