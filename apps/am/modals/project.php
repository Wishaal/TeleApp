<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/Project.php";
$parentproject = Project::all(array('projectcode', 'parentprojectcode', 'projectnaam'));
$project = Project::find($_GET['id']);
?>
<form action="apps/<?php echo app_name; ?>/project.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Project</h4>
    </div>
    <div class="modal-body">
        <div class="form-group ">
            <label class="control-label requiredField" for="projectcode">
                Code <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="projectcode" name="projectcode" placeholder="Code" type="text"
                   value="<?php echo $project->projectcode; ?>"/>
        </div>

        <div class="form-group">
            <label class="control-label" for="parentprojectcode">Parent</label>
            <select class="select form-control" id="parentprojectcode" name="parentprojectcode">
                <option></option>
                <?php
                foreach ($parentproject as $r) {
                    if ($r->projectcode == $project->parentprojectcode) {
                        $sel = 'selected=selected';
                    } else {
                        $sel = '';
                    }
                    echo '<option ' . $sel . ' value=' . $r->projectcode . '>' . $r->projectcode . " - " . $r->projectnaam . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="projectnaam">
                Naam <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="projectnaam" type="text" name="projectnaam"
                   value="<?php echo $project->projectnaam; ?>"/>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>