<div class="container">
    <h1>Projekte</h1>

    <table class="table">
        <thead>
        <th>Name</th>
        <th>Beschreibung</th>
        <th>Programmiersprachen</th>
        <th>Erstelldatum</th>
        </thead>
        <tbody>
        <?php foreach($this->projects as $project): ?>
            <tr onclick="location.href='project/edit/<?=$this->escape($project['id'])?>'">
                <td><?=$this->escape($project['name'])?></td>
                <td><?=$this->escape($project['description'])?></td>
                <td>
                    <?php foreach ($this->requirements[$project['id']] as $lang): ?>
                        <kbd><?= $this->escape($lang['name']) ?></kbd>
                    <?php endforeach; ?>
                </td>
                <td><?=$this->escape($project['creationDate'])?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a class="btn btn-primary" href="project/new">Neues Projekt erstellen</a>
</div>