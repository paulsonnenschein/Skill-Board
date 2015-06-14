<div class="jumbotron" id="jumboProfile">
    <div id="hovercard">
        <div id="avatar">
            <img alt="" src="https://secure.gravatar.com/avatar/<?=$this->user['gravatar'];?>?d=wavatar&s=150">
        </div>
    </div>
    <div id="info">
        <div id="title">
            <h2>
                <?=$this->escape($this->user['name']); ?>
                <br/>
                <?php if($this->user['id'] === $_SESSION['user_id']): ?>
                    <a href="profile/edit">
                        <span class="glyphicon glyphicon-cog"></span>
                    </a>
                    <a href="project/new">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                <?php endif; ?>
            </h2>
        </div>
    </div>
</div>
<br/>
<br/>
<div class="container">
    <div class="col-lg-12">
        <div class="col-md-4 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Beschreibung</h4></div>
                <div class="panel-body">
                    <p><?=nl2br($this->escape($this->user['description'])); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" aria-expanded="true"aria-controls="collapseOne">
                                <h4>Projekte <span class="glyphicon glyphicon-menu-down"></span></h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <?php if (count($this->user['project']) > 0): ?>
                            <table class="table">
                                <tbody>
                                    <?php foreach ($this->user['project'] as $project): ?>
                                        <tr>
                                            <td>
                                                <a href="project/<?= $this->escape($project['id']) ?>">
                                                    <?=$this->escape($project['name']) ?>
                                                </a>
                                            </td>
                                            <td>
                                            <?php if($project['statusUser'] === 'DECLINED'): ?>
                                                <span class="label label-danger">Du hast abgelehnt</span>
                                            <?php elseif ($project['statusProject'] === 'DECLINED'): ?>
                                                <span class="label label-danger">Du wurdest abgelehnt</span>
                                            <?php elseif ($project['statusUser'] === 'ACCEPTED' && $project['statusProject'] === 'UNDECIDED'): ?>
                                                <span class="label label-primary">Angefragt</span>
                                            <?php elseif ($project['statusProject'] === 'ACCEPTED' && $project['statusUser'] === 'UNDECIDED' ): ?>
                                                <a href="profile/respondproject/<?= $this->escape($project['id']) ?>/ACCEPTED" class="btn btn-success btn-xs">
                                                    Annehmen
                                                </a>
                                                <a href="profile/respondproject/<?= $this->escape($project['id']) ?>/DECLINED" class="btn btn-danger btn-xs">
                                                    Ablehnen
                                                </a>
                                            <?php elseif ($project['statusProject'] === 'ACCEPTED' && $project['statusUser'] === 'ACCEPTED'): ?>
                                                <span class="label label-success">Teilnehmer</span>
                                            <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <p>Keine Projekte!</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                <h4>Matches <span class="glyphicon glyphicon-menu-down"></span></h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <?php if (count($this->user['match']) > 0): ?>
                            <table class="table">
                                <tbody>
                                <?php foreach ($this->user['match'] as $match): ?>
                                    <tr>
                                        <td>
                                            <a href="project/<?= $this->escape($match['id']) ?>">
                                                <?=$this->escape($match['name']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="profile/applyproject/<?= $this->escape($match['id']) ?>" class="btn btn-primary btn-xs">
                                                Anfragen
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <p>Keine passenden Projekte!</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <h4>Skills <span class="glyphicon glyphicon-menu-down"></span></h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <p>
                                <?php foreach ($this->user['skill'] as $skill): ?>
                                    <kbd><?=$this->escape($skill['name']) ?></kbd>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>