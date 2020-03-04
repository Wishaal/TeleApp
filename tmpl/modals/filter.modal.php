<form action="" method="get">
    <!-- Filter Modal -->
    <div class="modal fade filter-modal" tabindex="-1" role="dialog" aria-labelledby="FilterModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Filter Devices</h4>
                </div>
                <div class="modal-body">
                    <p> Display devices based on criteria below. </p>
                    <div class="form-group">
                        <label for="DeviceGroup">Device Group:</label>
                        <select name='groupType' id="groupType" class="form-control">
                            <option value=''>(ALL)</option>
                            <?php
                            foreach ($datagroup as $group) {
                                echo '<option value=' . $group['GroupID'] . '>' . $group['GroupDesc'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="DeviceSN">Device SN: </label>
                        <input type="text" name="query" id="query" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="DeviceDesc">Device Desc: </label>
                        <input type="text" name="desc" id="desc" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="DeviceNum">Device Num: </label>
                        <input type="text" name="num" id="num" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Submit"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>