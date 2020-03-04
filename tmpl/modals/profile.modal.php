<?php
$userprofile = querySelectPDO($mis_connPDO, "SELECT *  FROM users a left join werknemers b on a.badge=b.Code where a.id= '" . $_SESSION['mis']['user']['id'] . "'"); ?>
<form action="profileUpdate.php" method="post" autocomplete='off'>
    <!-- Filter Modal -->
    <div class="modal fade profile-modal" tabindex="-1" role="dialog" id="ProfileModal" aria-labelledby="ProfileModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">My Profile</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-check"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <b>Alert!</b>Alleen nummers toegestaan! | Uitzendkrachten dienen hun badgenr zonder de “w”; in
                        te voeren
                    </div>
                    <p> Set your user profile properties.</p>
                    <div class="form-group">
                        <label for="FirstName">Badgenr: </label>
                        <input type="text" name="Badge" id="Badge" required class="form-control"
                               value="<?php echo $userprofile['badge']; ?>">
                        <input type="hidden" name="badgeEmpty" id="badgeEmpty"
                               value="<?php echo empty($userprofile['badge']) ? "true" : "false"; ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="Username">Username: </label>
                        <input type="text" name="Username" disabled id="Username" autocomplete="off"
                               class="form-control" value="<?php echo $userprofile['username']; ?>">
                        <input type="hidden" name="ProfileUpdate" id="ProfileUpdate" value="true">
                    </div>
                    <div class="form-group">
                        <label for="FirstName">First Name: </label>
                        <input type="text"
                               name="FirstName" <?php echo empty($userprofile['badge']) ? "disabled" : ""; ?>
                               id="FirstName" class="form-control" value="<?php echo $userprofile['FirstName']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="LastName">Last Name: </label>
                        <input type="text" name="LastName" <?php echo empty($userprofile['badge']) ? "disabled" : ""; ?>
                               id="LastName" class="form-control" value="<?php echo $userprofile['Name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email: </label>
                        <input type="text" required name="Email" id="Email" class="form-control"
                               value="<?php echo $userprofile['email']; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save Changes"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>