<h1>Projekt <?php echo $this->project->getId()?"bearbeiten":"erstellen"; ?></h1>

<form method="post" action="project/save" enctype="multipart/form-data">

  <input type="hidden" name="id"
    value="<?php echo htmlentities($this->project->getId()); ?>"
  />

  <div class="form-group">
    <label for="i1">Name</label>
    <input id="i1" class="form-control" type="text" name="name" maxlength="45" required="required"
      value="<?php echo htmlentities($this->project->get("name")); ?>"
    />
  </div>

  <div class="form-group">
    <label for="i3">Description</label>
    <textarea id="i3" class="form-control" type="text" name="description" maxlength="256" style="resize: vertical;" required="required"><?php
      echo htmlentities($this->project->get("description"));
    ?></textarea>
  </div>

  <input type="submit" value="Speichern" class="btn btn-primary" />

</form>