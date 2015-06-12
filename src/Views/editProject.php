<div class="container">
    <h1>Projekt <?= $this->edit ? "bearbeiten" : "erstellen"; ?></h1>

    <form method="POST" action="<?= $this->edit ? "project/edit/{$this->project['id']}" : "project/new"; ?>">

        <input type="hidden" name="id"
               value="<?= $this->edit ? $this->escape($this->project['id']) : ''; ?>" />

        <div class="form-group">
            <label for="name">Name</label>
            <input id="name" class="form-control" type="text" name="name" maxlength="45" required="required"
                   value="<?=  $this->edit ? $this->escape($this->project['name']) : ''; ?>" />
        </div>

        <div class="form-group">
            <label for="description">Beschreibung</label>
            <textarea id="description" class="form-control" name="description" maxlength="256"
                      style="resize: vertical;" required="required"><?php
                echo $this->edit ? $this->escape($this->project['description']) : '';
            ?></textarea>
        </div>

        <div class="form-group">
            <label for="programmingLanguages">Verwendete Programmiersprachen</label>
            <select id="programmingLanguages" class="form-control">
                <option value=""></option>
                <?php foreach($this->langs as $language): ?>
                    <option value="<?=$this->escape($language['id'])?>"><?=$this->escape($language['name'])?></option>
                <?php endforeach; ?>
            </select>
            <table class="table">
                <tbody id="pltable">
                <?php if($this->edit): ?>
                    <?php foreach($this->projectLangs as $language): ?>
                        <tr>
                            <td data-id="<?=$this->escape($language['id'])?>" data-name="<?=$this->escape($language['name'])?>">
                                <?=$this->escape($language['name'])?>
                                <input type="hidden" value="<?=$this->escape($language['id'])?>" name="pl[]" />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <input type="submit" value="Speichern" class="btn btn-primary"/>

        <br/><br/>
    </form>

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
</div>
