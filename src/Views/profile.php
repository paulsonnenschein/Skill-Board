<div class="circletag"> </div>
	<div class="jumbotron" id="userBgJumbo">

	</div>
	
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-4">
				<div class="box">
					<h3><?php echo $this->user['name']; ?></h3>
					<p><?php echo $this->user['description']; ?></p>
				
				</div>
			</div>
			<div class="col-lg-4">
				<div class="box">
					<h3>Sprachen</h3>
					<ul>
                        <?php
                        if(count($this->user['skill']) > 0){
                            foreach($this->user['skill'] AS $skill){
                                echo '<li>'.$skill['name'].'</li>';
                            }
                        } else {
                            echo 'Keine Skills';
                        }
                        ?>
					</ul>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="box">
					<h3>Matches</h3>
					<ul>
						<li>XXX</li>
						<li>XXX</li>
						<li>XXX</li>
						<li>XXX</li>
						<li>XXX</li>
						<li>XXX</li>
					</ul>
				</div>
			</div>
			
		</div>
	</div>
</div>