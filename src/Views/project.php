<h1>Projekte</h1>

<table class="table">
  <thead>
    <th>Name</th>
    <th>Beschreibung</th>
    <th>Erstelldatum</th>
  </thead>
  <tbody>
<?php
  foreach($this->projects as $project){
    $ep = array( 
      "id" => $project->getId(),
      "name" => htmlentities($project->get("name")),
      "description" => htmlentities($project->get("description")),
      "creationDate" => htmlentities($project->get("creationDate"))
    );
    echo <<<EOF
    <tr onclick="location.href='project/edit/$ep[id]'">
      <td>$ep[name]</td>
      <td>$ep[description]</td>
      <td>$ep[creationDate]</td>
    </tr>

EOF;
  }
?>
  </tbody>
</table>

<a class="btn btn-primary" href="project/new">Neues Projekt erstellen</a>

