<div class="container">
    <h1>Projekt <?php echo $this->project->getId()?"":"erstellen"; ?></h1>

    <form method="post" action="project/save" enctype="multipart/form-data">

        <input type="hidden" name="id"
               value="<?php echo htmlentities($this->project->getId()); ?>"
               />

        <div class="form-group">
            <label for="name">Name</label><br>
            <?php echo htmlentities($this->project->get("name")); ?>
        </div>

        <div class="form-group">
            <label for="description">Beschreibung</label><br>
            <?php
echo htmlentities($this->project->get("description"));
                ?>
        </div>

        <div class="form-group">
            <label for="programmingLanguages">Verwendete Programmiersprachen</label><br>
            <table class="table">
                <tbody id="pltable">
                    <?php
$requirements = $this->project->getRequirements();
foreach($requirements as $requirement){
    $pl = $requirement->getProgrammingLanguage();
    $epl = [
        'id' => $pl->getId(),
        'name' => htmlentities($pl->get('name'))
    ];
    echo <<<EOF
        <tr>
          <td data-id="$epl[id]" data-name="$epl[name]">
            $epl[name]
            <input type="hidden" value="$epl[id]" name="pl[]" />
          </td>
        </tr>
EOF;
}
                    ?>
                </tbody>
            </table>
        </div>


        <br/><br/>
        <div class="form-group" style="display: <?php echo $this->project->getId()?"block":"none"; ?>;">
            <h1>Entwickler</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$developers = $this->project->getDevelopers([
    'statusProject' => 'ACCEPTED'
]);
foreach($developers as $developer){
    $user = $developer->getUser();
    $euser = [
        'id' => $user['id'],
        'name' => htmlentities($user['firstName']." ".$user['lastName']),
        'status' => [
            'ACCEPTED'  => 'Beigetreten',
            'UNDECIDED' => 'Angefragt',
            'DECLINED' => 'Abgelehnt',
        ][$developer->get('statusUser')]
    ];
    echo <<<EOF
        <tr data-id="$euser[id]">
          <td>$euser[name]</td>
          <td>$euser[status]</td>
        </tr>
EOF;
}
                    ?>
            </table>
        </div>

    </form>

    <script>
        (function(){
            var programmingLanguages = document.getElementById("programmingLanguages");
            var pltable  = document.getElementById("pltable" );
            programmingLanguages.addEventListener("change",function(event){
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
                td.setAttribute("data-id",this.value);
                td.setAttribute("data-name",name);
                this.remove(this.selectedIndex);
                this.value='';
            });
            pltable.addEventListener("click",function(event){
                var entry = event.target;
                do if(entry.getAttribute("data-id"))
                    break;
                while(entry=entry.parentElement);
                if(!entry)
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
