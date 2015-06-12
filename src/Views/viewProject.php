<div class="container">
    <h1>
        Projekt: <?=$this->escape($this->project['project']['name'])?>
        <a href="project/edit/<?=$this->escape($this->project['project']['id'])?>">
            <span class="glyphicon glyphicon-cog"></span>
        </a>
    </h1>

    <b>Beschreibung:</b>
    <p><?=$this->escape($this->project['project']['description'])?></p>

    <b>Ersteller:</b>
    <p>
        <a href="profile/<?=$this->escape($this->project['project']['owner_id'])?>">
            <?=$this->escape($this->project['project']['owner'])?>
        </a>
    </p>

    <b>Verwendete Programmiersprachen:</b>
    <p>
        <?php foreach ($this->project['languages'] as $lang): ?>
            <kbd><?= $this->escape($lang['name']) ?></kbd>
        <?php endforeach; ?>
    </p>

    <h1>Entwickler</h1>
    <?php if(count($this->project['developers']) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($this->project['developers'] as $dev): ?>
            <tr>
                <td>
                    <a href="profile/<?=$this->escape($dev['id'])?>">
                        <?=$this->escape($dev['firstName'] . ' ' . $dev['lastName'])?>
                    </a>
                </td>
                <td>Todo Status</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Noch keine Entwickler eingetragen:</p>
    <?php endif; ?>
    <h1>Entwickler die passen könnten</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($this->project['recomendet_devs'] as $dev): ?>
            <tr>
                <td>
                    <a href="profile/<?=$this->escape($dev['id'])?>">
                        <?=$this->escape($dev['firstName'] . ' ' . $dev['lastName'])?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
