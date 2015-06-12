<h1>User List </h1><br>
<?php foreach($this->userList as $user): ?>
	<a href="user/<?= $user['id']?>"><?= $user['firstname'].' '.$user['lastname']?></a><br>

<?php endforeach; ?>
<h1>Project List </h1><br>
<?php foreach($this->projectList as $project): ?>
	<a href="project/<?= $project['id']?>"><?= $project['search']?></a><br>

<?php endforeach; ?>