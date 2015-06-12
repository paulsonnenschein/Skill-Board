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
              </tbody>
            </table>
            <h3>Vorgeschlagene Entwickler</h3>
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Status</th>
                  <td class="symbols"></td>
                </tr>
              </thead>
              <tbody>
<?php
  $users = $this->project->getMatchingUsers();
  foreach($users as $user){
      $e = [
        'uid' => $user['id'],
        'pid' => $this->project->getId(),
        'name' => htmlentities($user['firstName']." ".$user['lastName']),
        'status' => [
          'ACCEPTED'  => 'Beigetreten',
          'UNDECIDED' => 'Angefragt',
          'DECLINED' => 'Abgelehnt',
          '' => '',
        ][$user['statusUser']]
      ];
      echo <<<EOF
        <tr>
          <td>$e[name]</td>
          <td>$e[status]</td>
          <td class="symbols"><a href="project/$e[pid]/addDeveloper/$e[uid]" class="btn btn-default glyphicon glyphicon-plus"></a></td>
        </tr>
EOF;
}
?>
              </tbody>
            </table>
        </div>

    </form>
</div>
