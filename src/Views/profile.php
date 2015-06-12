<div class="jumbotron" id="jumboProfile">
	<div id="hovercard">
		<div id="avatar">
			<img alt="" src="https://secure.gravatar.com/avatar/<?php echo $this->user['gravatar']; ?>?d=wavatar&s=150">
		</div>
	</div>
    <div id="info">
        <div id="title">
            <a target="_blank" href="#"><?php echo $this->user['name']; ?></a>
        </div>
    </div>
</div>
<br>
<div class="container">
	<div class ="col-lg-12">
		<div class="col-md-4 col-sm-6">
			<div class="panel panel-default">
			   <div class="panel-heading"><h4>Beschreibung</h4></div>
				<div class="panel-body">
					<p><?php echo nl2br($this->user['description']); ?></p>
				</div>
			 </div> 
		</div>
		<div class="col-md-4 col-sm-6">
			<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						  <h4>Projekte <span class="glyphicon glyphicon-menu-down"></span></h4>
						</a>
					  </h4>
					</div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <p>
                                <?php
                                $projects = '';
                                if(count($this->user['project']) > 0){
                                    foreach($this->user['project'] AS $project) {
                                        $projects .= '<dl class="dl-horizontal">';
                                        $projects .=     '<dt><a href="project/view/'.$project['id'].'">' . $project['name'] . '</a></dt>';
                                        $projects .=     '<!--<dd><span class="glyphicon glyphicon-calendar"><b>12.06.2015</b></span></dd>-->';
                                        $projects .= '</dl>';
                                    }
                                } else {
                                    $projects = 'Keine Projekte';
                                }
                                echo $projects;
                                ?>
                            </p>
                        </div>
                    </div>
				</div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h4>Matches <span class="glyphicon glyphicon-menu-down"></span></h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <p>
                                <?php
                                $matches = '';
                                if(count($this->user['match']) > 0) {
                                    foreach ($this->user['match'] AS $match) {
                                        $matches .= '<dl class="dl-horizontal">';
                                        $matches .= '<dt><a href="project/view/'.$match['id'].'">' . $match['name'] . '</a></dt>';
                                        $matches .= '<!--<dd><span class="glyphicon glyphicon-calendar"><b>12.06.2015</b></span></dd>-->';
                                        $matches .= '</dl>';
                                    }
                                } else {
                                    $matches = 'Keine Matches';
                                }
                                echo $matches;
                                ?>
                            </p>
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
							<?php
							$skills = '';
							foreach($this->user['skill'] AS $skill){
								$skills .= '<kbd>'.$skill['name'].'</kbd> ';
							}
							echo substr($skills,0,-1);
							?>
						</p>
					  </div>
					</div>
				</div>
			 </div>
		</div>
	</div>
</div>