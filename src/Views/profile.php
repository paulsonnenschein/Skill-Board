<div class="jumbotron" id="jumboProfile">
    <div id="hovercard">
        <div id="avatar">
            <img alt="" src="https://secure.gravatar.com/avatar/<?php echo $this->user['gravatar']; ?>?d=wavatar&s=150">
        </div>
    </div>
    <div id="info">
        <div id="title">
            <h2>
                <?php echo $this->escape($this->user['name']); ?>
                <br/>
                <a href="profile/edit">
                    <span class="glyphicon glyphicon-cog"></span>
                </a>
                <a href="project/new">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
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
                    <p><?= nl2br($this->escape($this->user['description'])); ?></p>
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
                            <ul class="list-unstyled">
                                <?php if (count($this->user['project']) > 0): ?>
                                    <?php foreach ($this->user['project'] as $project): ?>
                                        <li>
                                            <a href="project/view/<?= $this->escape($project['id']) ?>">
                                                <?= $this->escape($project['name']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Keine Projekte!</p>
                                <?php endif; ?>
                            </ul>
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
                            <ul class="list-unstyled">
                                <?php if (count($this->user['match']) > 0): ?>
                                    <?php foreach ($this->user['match'] as $match): ?>
                                        <li>
                                            <a href="project/view/<?= $this->escape($match['id']) ?>">
                                                <?= $this->escape($match['name']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Keine passenden Projekte!</p>
                                <?php endif; ?>
                            </ul>
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
                                    <kbd><?= $this->escape($skill['name']) ?></kbd>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>