<?php require_once('../../php/conf/config.php');

$groups = querySelect($db, "SELECT * FROM tblGroup where AccountID='" . $_SESSION['gps']['user']['accountID'] . "'");
$drivers = querySelect($db, "SELECT * FROM tblDriver where AccountID='" . $_SESSION['gps']['user']['accountID'] . "'");
$account = querySelect($db, "SELECT * FROM tblAccount where AccountID='" . $_SESSION['gps']['user']['accountID'] . "'");
$device = querySelect($db, "SELECT * FROM tblDevice where DeviceID='" . $_GET['id'] . "'");
$alerts = querySelect($db, "SELECT * FROM tblAlertOpt");
$deviceType = querySelectlist($db, "SELECT * FROM tblDeviceType");

?>
<div class="modal-header">Details of Device <?php echo $_GET['id']; ?></div>
<form action="" class="form-horizontal">
    <div class="modal-body">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
                <li><a href="#tab_2" data-toggle="tab">Alerts</a></li>
                <li><a href="#tab_3" data-toggle="tab">Vehicle</a></li>
                <li><a href="#tab_4" data-toggle="tab">Owner</a></li>
                <li><a href="#tab_5" data-toggle="tab">Status</a></li>
                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label col-xs-4" style="text-align: left;">Description</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="description" name="description"
                                           value="<?php echo $device['DeviceDesc']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group" class="control-label col-xs-4"
                                       style="text-align: left;">Group</label>
                                <div class="col-xs-8">
                                    <select name="groupid" id="groupid" class="form-control">
                                        <?php
                                        foreach ($groups as $group) {
                                            echo '<option value=' . $group['GroupID'] . '>' . $group['GroupDesc'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="driver" class="control-label col-xs-4"
                                       style="text-align: left;">Driver</label>
                                <div class="col-xs-8">
                                    <select name="driverid" id="driverid" class="form-control">
                                        <?php
                                        foreach ($drivers as $driver) {
                                            echo '<option value=' . $driver['DriverID'] . '>' . $driver['FirstName'] . ' ' . $driver['LastName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="general1" class="control-label col-xs-4"
                                       style="text-align: left;"><?php echo $account['CustomGeneral1']; ?> </label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="general1" name="general1"
                                           placeholder="General-1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="general2" class="control-label col-xs-4"
                                       style="text-align: left;"><?php echo $account['CustomGeneral2']; ?></label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="general2" name="general2"
                                           placeholder="General-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="createdby" class="control-label col-xs-4" style="text-align: left;">Created
                                    By</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo getUserName($db, $device['CreatedUserID']); ?></label><br>
                                    <label class="control-label"><?php echo $device['CreatedDate']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Revised By" class="control-label col-xs-4" style="text-align: left;">Revised
                                    By</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo getUserName($db, $device['RevisedUserID']); ?></label><br>
                                    <label class="control-label"><?php echo $device['RevisedDate']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="DeviceNumber" class="control-label col-xs-4" style="text-align: left;">Device
                                    Number</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo $device['DeviceID']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="DeviceStatus" class="control-label col-xs-4" style="text-align: left;">Device
                                    Status</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo getDeviceStatus($db, $device['DeviceStatusID']); ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="DeviceActivated" class="control-label col-xs-4" style="text-align: left;">Device
                                    Activated</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo $device['DeviceActivationDate']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ActivationCode" class="control-label col-xs-4" style="text-align: left;">Activation
                                    Code</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo $device['DeviceActivationCode']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="devicetype" class="control-label col-xs-4" style="text-align: left;">Device
                                    Type</label>
                                <div class="col-xs-8">
                                    <select name="devicetype" id="devicetype" class="form-control">
                                        <?php
                                        foreach ($deviceType as $devicetp) {
                                            echo '<option value=' . $devicetp['DeviceTypeID'] . '>' . $devicetp['DeviceTypeDesc'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="DeviceSN" class="control-label col-xs-4" style="text-align: left;">Device
                                    S/N</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="devicesn"
                                           value="<?php echo $device['DeviceSN']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="DeviceImei" class="control-label col-xs-4" style="text-align: left;">Device
                                    IMEI</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="deviceimei"
                                           value="<?php echo $device['DeviceIMEI']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-md-6">
                            <label> ALERT HANDLING </label><br>
                            <div class="input-group" style='margin-bottom:10px'>
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Geofence</button>
								</span>
                                <select name="geofence" id="geofence" class="form-control">
                                    <?php
                                    foreach ($alerts as $alert) {
                                        echo '<option ' . ($alert['AlertOptID'] == $device['AlertOptGeofence'] ? 'selected="selected"' : '') . ' value=' . $alert['AlertOptID'] . '>' . $alert['AlertOptDesc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group" style='margin-bottom:10px'>
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Battery</button>
								</span>
                                <select name="battery" id="battery" class="form-control">
                                    <?php
                                    foreach ($alerts as $alert) {
                                        echo '<option ' . ($alert['AlertOptID'] == $device['AlertOptBattery'] ? 'selected="selected"' : '') . ' value=' . $alert['AlertOptID'] . '>' . $alert['AlertOptDesc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group" style='margin-bottom:10px'>
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Speed</button>
								</span>
                                <select name="speed" id="speed" class="form-control">
                                    <?php
                                    foreach ($alerts as $alert) {
                                        echo '<option ' . ($alert['AlertOptID'] == $device['AlertOptSpeed'] ? 'selected="selected"' : '') . ' value=' . $alert['AlertOptID'] . '>' . $alert['AlertOptDesc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group" style='margin-bottom:10px'>
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Tow</button>
								</span>
                                <select name="tow" id="tow" class="form-control">
                                    <?php
                                    foreach ($alerts as $alert) {
                                        echo '<option ' . ($alert['AlertOptID'] == $device['AlertOptTow'] ? 'selected="selected"' : '') . ' value=' . $alert['AlertOptID'] . '>' . $alert['AlertOptDesc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group" style='margin-bottom:10px'>
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Ignition State</button>
								</span>
                                <select name="ignitionstate" id="ignitionstate" class="form-control">
                                    <?php
                                    foreach ($alerts as $alert) {
                                        echo '<option ' . ($alert['AlertOptID'] == $device['AlertOptIgnition'] ? 'selected="selected"' : '') . ' value=' . $alert['AlertOptID'] . '>' . $alert['AlertOptDesc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group" style='margin-bottom:10px'>
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Motion Alarm</button>
								</span>
                                <select name="alarm" id="alarm" class="form-control">
                                    <?php
                                    foreach ($alerts as $alert) {
                                        echo '<option ' . ($alert['AlertOptID'] == $device['AlertOptMotionAlarm'] ? 'selected="selected"' : '') . ' value=' . $alert['AlertOptID'] . '>' . $alert['AlertOptDesc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- right column -->
                        <div class="col-md-6">
                            <label> ALERT NOTIFICATION </label><br>
                            <div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Email #1</button>
								</span>
                                <input type="text" name="email" class="form-control"
                                       value="<?php echo $device['AlertEmail1']; ?>">
                            </div>
                            <br>
                            <div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Email #2</button>
								</span>
                                <input type="text" name="email2" class="form-control"
                                       value="<?php echo $device['AlertEmail2']; ?>">
                            </div>
                            <br>
                            <div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>Email #3</button>
								</span>
                                <input type="text" name="email3" class="form-control"
                                       value="<?php echo $device['AlertEmail3']; ?>">
                            </div>
                            <br>
                            <div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>SMS #1</button>
								</span>
                                <input type="text" name="sms1" class="form-control"
                                       value="<?php echo $device['AlertSMS1']; ?>">
                            </div>
                            <br>
                            <div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>SMS #2</button>
								</span>
                                <input type="text" name="sms2" class="form-control"
                                       value="<?php echo $device['AlertSMS2']; ?>">
                            </div>
                            <br>
                            <div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-inverse" type="button" style='width:125px; text-align:left'>SMS #3</button>
								</span>
                                <input type="text" name="sms3" class="form-control"
                                       value="<?php echo $device['AlertSMS3']; ?>">
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputVIN" class="control-label col-xs-4"
                                       style="text-align: left;">VIN</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="vin" name="vin"
                                           value="<?php echo $device['VIN']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="plateState" class="control-label col-xs-4" style="text-align: left;">Plate
                                    State</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="platestate" name="platestate"
                                           value="<?php echo $device['PlateState']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="PlateNumber" class="control-label col-xs-4" style="text-align: left;">Plate
                                    Number</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="PlateNumber" name="PlateNumber"
                                           value="<?php echo $device['PlateNumber']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="vehicle1" class="control-label col-xs-4"
                                       style="text-align: left;">Vehicle-1</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="vehicle1" name="vehicle1"
                                           value="<?php echo $device['VehicleCustom1']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="vehicle2" class="control-label col-xs-4"
                                       style="text-align: left;">Vehicle-2</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="vehicle2" name="vehicle2"
                                           value="<?php echo $device['VehicleCustom2']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputYear" class="control-label col-xs-4"
                                       style="text-align: left;">Year</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="year" name="year"
                                           value="<?php echo $device['VehicleYear']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputMake" class="control-label col-xs-4"
                                       style="text-align: left;">Make</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="make" name="make"
                                           value="<?php echo $device['VehicleMake']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputModal" class="control-label col-xs-4"
                                       style="text-align: left;">Modal</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="modal" name="modal"
                                           value="<?php echo $device['VehicleModal']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputStyle" class="control-label col-xs-4"
                                       style="text-align: left;">Style</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="style" name="style"
                                           value="<?php echo $device['VehicleStyle']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputColor" class="control-label col-xs-4"
                                       style="text-align: left;">Color</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="color" name="color"
                                           value="<?php echo $device['VehicleColor']; ?>">
                                </div>
                            </div>
                        </div>
                    </div><!-- /. -->
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="OwnerFirstName" class="control-label col-xs-4" style="text-align: left;">First
                                    Name</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerFirstName" name="OwnerFirstName"
                                           value="<?php echo $device['OwnerFirstName']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OwnerLastName" class="control-label col-xs-4" style="text-align: left;">Last
                                    Name</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerLastName" name="OwnerLastName"
                                           value="<?php echo $device['OwnerLastName']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OwnerPhone" class="control-label col-xs-4"
                                       style="text-align: left;">Phone</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerPhone" name="OwnerPhone"
                                           value="<?php echo $device['OwnerPhone']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OwnerMobile" class="control-label col-xs-4"
                                       style="text-align: left;">Mobile</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerMobile" name="OwnerMobile"
                                           value="<?php echo $device['OwnerMobile']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OwnerEmail" class="control-label col-xs-4"
                                       style="text-align: left;">Email</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerEmail" name="OwnerEmail"
                                           value="<?php echo $device['OwnerEmail']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="OwnerAddrLn1" class="control-label col-xs-4" style="text-align: left;">Addr
                                    Line 1</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerAddrLn1" name="OwnerAddrLn1"
                                           value="<?php echo $device['OwnerAddrLn1']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OwnerAddrLn2" class="control-label col-xs-4" style="text-align: left;">Addr
                                    Line 2</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerAddrLn2" name="OwnerAddrLn2"
                                           value="<?php echo $device['OwnerAddrLn2']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OwnerCity" class="control-label col-xs-4"
                                       style="text-align: left;">City</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerCity" name="OwnerCity"
                                           value="<?php echo $device['OwnerCity']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OwnerCustom1" class="control-label col-xs-4" style="text-align: left;">Driver-1</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerCustom1" name="OwnerCustom1"
                                           value="<?php echo $device['OwnerCustom1']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OwnerCustom2" class="control-label col-xs-4" style="text-align: left;">Driver-2</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="OwnerCustom2" name="OwnerCustom2"
                                           value="<?php echo $device['OwnerCustom2']; ?>">
                                </div>
                            </div>
                        </div>
                    </div><!-- /. -->
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="LastEvent" class="control-label col-xs-4" style="text-align: left;">Last
                                    Event</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo $device['LastEventDate']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="LastEventType" class="control-label col-xs-4" style="text-align: left;">Last
                                    Event Type</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo getEventName($db, $device['LastEventTypeID']); ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="LastReported" class="control-label col-xs-4" style="text-align: left;">Last
                                    Reported</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo $device['LastResponseDate']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="LastNearestAddress" class="control-label col-xs-4"
                                       style="text-align: left;">Last Nearest Address</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo $device['LastNearestAddress']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="LatLing" class="control-label col-xs-4" style="text-align: left;">Last
                                    Lat/Lng</label>
                                <div class="col-xs-8">
                                    <label class="control-label"><?php echo $device['LastLatitude']; ?>
                                        ,<?php echo $device['LastLongitude']; ?></label>
                                </div>
                            </div>
                        </div>
                    </div><!-- /. -->
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="SleepMode" class="control-label col-xs-6" style="text-align: left;">Sleep
                                    Mode</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['SleepOpt']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="BatteryWarnings" class="control-label col-xs-6" style="text-align: left;">Battery
                                    Warnings</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['BatteryOpt']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Spee" class="control-label col-xs-6" style="text-align: left;">Speed</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['SpeedOpt']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MotionAlarm" class="control-label col-xs-6" style="text-align: left;">Motion
                                    Alarm</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['MotionAlarmOpt']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="AutoReport" class="control-label col-xs-6" style="text-align: left;">Auto
                                    Report</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['AutoRptOpt']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="IgnitionSense" class="control-label col-xs-6" style="text-align: left;">Ignition
                                    Sense</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['IgnSenseOpt']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="StarterState" class="control-label col-xs-6" style="text-align: left;">Starter
                                    State</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['StarterOpt']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MovementTracking" class="control-label col-xs-6" style="text-align: left;">Movement
                                    Tracking</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['MovementOpt']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Ignition" class="control-label col-xs-6"
                                       style="text-align: left;">Ignition</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['IgnSenseOpt']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Door" class="control-label col-xs-6" style="text-align: left;">Door</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['SpeedOpt']; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Town" class="control-label col-xs-6" style="text-align: left;">Tow</label>
                                <div class="col-xs-6">
                                    <label class="control-label"><?php echo $device['TowingOpt']; ?></label>
                                </div>
                            </div>
                        </div>
                    </div><!-- /. -->

                </div><!-- /.tab-pane -->
            </div>
        </div> <!-- nav-tabs-custom -->
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" type="submit">Save Changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>