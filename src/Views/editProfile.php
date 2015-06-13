<div class="container">
    <div class="col-lg-10">
        <h1>Profile Bearbeiten</h1>
        <form class="form" action="profile/edit" method="POST">
            <div class="form-group">
                <label for="firstName" class="control-label">Vorname</label>
                <input class="form-control" type="text" id="firstName" name="firstName" value="<?=$this->escape($this->user['firstName'])?>" />
            </div>
            <div class="form-group">
                <label for="lastName" class="control-label">Nachname</label>
                <input class="form-control" type="text" id="lastName" name="lastName" value="<?=$this->escape($this->user['lastName'])?>" />
            </div>
            <div class="form-group">
                <label for="email" class="control-label">E-Mail</label>
                <input class="form-control" type="email" id="email" name="email" value="<?=$this->escape($this->user['email'])?>" />
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Beschreibung</label><br>
                <textarea class="form-control" id="description" name="description" rows="5" maxlength="400" ><?php
                    echo $this->escape($this->user['description']);
                    ?></textarea>
            </div>
            <div class="form-group">
                <label for="programmingLanguages">Programmiersprachen</label>
                <select id="programmingLanguages" class="form-control">
                    <option value=""></option>
                    <?php foreach($this->langs as $language): ?>
                        <option value="<?=$this->escape($language['id'])?>"><?=$this->escape($language['name'])?></option>
                    <?php endforeach; ?>
                </select>
                <table class="table">
                    <tbody id="pltable">
                    <?php foreach($this->userLangs as $language): ?>
                        <tr>
                            <td data-id="<?=$this->escape($language['id'])?>" data-name="<?=$this->escape($language['name'])?>">
                                <?=$this->escape($language['name'])?>
                                <input type="hidden" value="<?=$this->escape($language['id'])?>" name="pl[]" />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!--<div class="form-group">
                <div class="col-lg-10">
                    <label for="name" class="control-label">Passwort</label>
                    <input class="form-control" type="password" id="name" name="name" value="" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10">
                    <label for="name" class="control-label">Passwort bestätigen</label>
                    <input class="form-control" type="password" id="name" name="name" value="" />
                </div>
            </div>-->
            <button type="submit" class="btn btn-primary">Speichern!</button>
        </form>
    </div>
</div>

<script>
    (function () {
        var programmingLanguages = document.getElementById("programmingLanguages");
        var pltable = document.getElementById("pltable");
        programmingLanguages.addEventListener("change", function (event) {
            var tr = document.createElement("tr");
            var td = document.createElement("td");
            var input = document.createElement("input");
            var name = this.options[this.selectedIndex].text;
            pltable.appendChild(tr);
            tr.appendChild(td);
            td.appendChild(document.createTextNode(name));
            td.appendChild(input);
            input.value = this.value;
            input.type = "hidden";
            input.name = "pl[]";
            td.setAttribute("data-id", this.value);
            td.setAttribute("data-name", name);
            this.remove(this.selectedIndex);
            this.value = '';
        });
        pltable.addEventListener("click", function (event) {
            var entry = event.target;
            do if (entry.getAttribute("data-id"))
                break;
            while (entry = entry.parentElement);
            if (!entry)
                return;
            entry.parentElement.removeChild(entry);
            var id = entry.getAttribute("data-id");
            var name = entry.getAttribute("data-name");
            var option = document.createElement("option");
            option.text = name;
            option.value = id;
            programmingLanguages.add(option);
        });
    })();
</script>
