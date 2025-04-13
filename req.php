<?php
include("header.php");
include("nav.php");

if (isset($_POST['accept_shift']) && $_POST['accept_shift']) {
    $shiftRequestId = $_POST['accept_shift'];

    $con->query("UPDATE shiftrequest SET status = 'A' WHERE shiftChangeId = '$shiftRequestId'");

    $result = $con->query("SELECT * FROM shiftrequest WHERE shiftChangeId = '$shiftRequestId'");

    if ($row = $result->fetch_assoc()) {
        $fromreq = $row["from_emp"];
        $toreq = $row["to_emp"];
        $weekid = $row["week_id"];
        $shift = $row["shift"];
        $sday = $row["day"];
        $toshift = -1;
        $shiftResult = $con->query("SELECT shift FROM schedule WHERE employeeId = '$fromreq' AND weekID = '$weekid' AND day = '$sday'");
        if ($shiftRow = $shiftResult->fetch_array()) {
            $toshift = $shiftRow[0];
        }

        $con->query("UPDATE shiftrequest SET status = 'R' WHERE from_emp = '$fromreq' AND week_id = '$weekid' AND day = '$sday' AND to_emp != '$toreq'");
        $con->query("UPDATE schedule SET shift = '$shift' WHERE employeeId = '$fromreq' AND day = '$sday' AND weekID = '$weekid'");
        $con->query("UPDATE schedule SET shift = '$toshift' WHERE employeeId = '$toreq' AND day = '$sday' AND weekID = '$weekid'");
        // echo("UPDATE schedule SET shift = '$toshift' WHERE employeeId = '$fromreq' AND day = '$sday' AND weekID = '$weekid'"); 
        // echo("UPDATE schedule SET shift = '$shift' WHERE employeeId = '$toreq' AND day = '$sday' AND weekID = '$weekid'");

        echo "<p class='m-2 text-success'>Shift request ID $shiftRequestId has been accepted and schedule updated.</p>";
    }
}

if (isset($_POST['reject_shift']) && $_POST['reject_shift']) {
    $shiftRequestId = $_POST['reject_shift'];
    $con->query("UPDATE shiftrequest SET status = 'R' WHERE shiftChangeId = '$shiftRequestId'");
    echo "<p class='m-2 text-danger'>Shift request ID $shiftRequestId has been rejected.</p>";
}

if (isset($_POST['accept_holiday']) && $_POST['accept_holiday']) {
    $holidayRequestId = $_POST['accept_holiday'];

    $con->query("UPDATE holidayrequest SET status = 'A' WHERE holidayChangeId = '$holidayRequestId'");

    $res = $con->query("SELECT * FROM holidayrequest WHERE holidayChangeId = '$holidayRequestId'");

    if ($row = $res->fetch_assoc()) {
        $fromreq = $row["from_emp"];
        $toreq = $row["to_emp"];
        $fromreqday = $row["from_emp_shift"];
        $toreqday = $row["to_emp_shift"];
        $weekid = $row["week_id"];

        echo "<p class='m-2 text-success'>Holiday request ID $holidayRequestId has been accepted.</p>";

        $con->query("UPDATE holidayrequest SET status = 'D' WHERE holidayChangeId != '$holidayRequestId' AND from_emp = '$fromreq' AND from_emp_shift = '$fromreqday'");

        // Update schedule
        $con->query("UPDATE schedule SET holiday = 0 WHERE employeeId = '$fromreq' AND day = '$fromreqday' AND weekID = '$weekid'");
        $con->query("UPDATE schedule SET holiday = 0 WHERE employeeId = '$toreq' AND day = '$toreqday' AND weekID = '$weekid'");
        $con->query("UPDATE schedule SET holiday = 1 WHERE employeeId = '$toreq' AND day = '$fromreqday' AND weekID = '$weekid'");
        $con->query("UPDATE schedule SET holiday = 1 WHERE employeeId = '$fromreq' AND day = '$toreqday' AND weekID = '$weekid'");
        // echo("UPDATE schedule SET holiday = 0 WHERE employeeId = '$fromreq' AND day = '$fromreqday' AND weekID = '$weekid'");
        // echo("UPDATE schedule SET holiday = 1 WHERE employeeId = '$toreq' AND day = '$toreqday' AND weekID = '$weekid'");
        // echo("UPDATE schedule SET holiday = 0 WHERE employeeId = '$toreq' AND day = '$fromreqday' AND weekID = '$weekid'");
        // echo("UPDATE schedule SET holiday = 1 WHERE employeeId = '$fromreq' AND day = '$toreqday' AND weekID = '$weekid'");
    }
}

// === Reject Holiday Request ===
if (isset($_POST['reject_holiday']) && $_POST['reject_holiday']) {
    $holidayRequestId = $_POST['reject_holiday'];

    $con->query("UPDATE holidayrequest SET status = 'R' WHERE holidayChangeId = '$holidayRequestId'");

    $res = $con->query("SELECT * FROM holidayrequest WHERE holidayChangeId = '$holidayRequestId'");

    if ($row = $res->fetch_assoc()) {
        $fromreq = $row["from_emp"];
        $toreq = $row["to_emp"];
        $fromreqsh = $row["from_emp_shift"];
        $toreqsh = $row["to_emp_shift"];
        $weekid = $row["week_id"];

        $con->query("UPDATE schedule SET holiday = 0 WHERE employeeId = '$fromreq' AND day = '$fromreqsh' AND holiday = 1");
        $con->query("UPDATE schedule SET holiday = 1 WHERE employeeId = '$toreq' AND day = '$toreqsh' AND holiday = 0");
    }

    echo "<p class='m-2 text-danger'>Holiday request ID $holidayRequestId has been rejected.</p>";
}

$shiftRes = $con->query("SELECT * FROM shiftrequest WHERE to_emp = '$id' AND status != 'R'");
$holidayRes = $con->query("SELECT * FROM holidayrequest WHERE status != 'R' AND to_emp = '$id'");
?>

<div class="m-3">
    <h3>All Shift Change Requests</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Requested Person ID</th>
                <th>Date Requested</th>
                <th>Day</th>
                <th>Shift</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $days = [7=>'Sunday',1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday'];
        if ($shiftRes && $shiftRes->num_rows > 0):
            while ($row = $shiftRes->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['from_emp'] ?></td>
                    <td><?= $row['create_date'] ?></td>
                    <td><?= $days[$row['day']] ?? $row['day'] ?></td>
                    <td><?= $row['shift'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <?php if (strtoupper($row['status']) === 'P'): ?>
                            <form method="post" style="display:inline;">
                                <button class="btn btn-success btn-sm" name="accept_shift" value="<?= $row['shiftChangeId'] ?>">Accept</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <button class="btn btn-danger btn-sm" name="reject_shift" value="<?= $row['shiftChangeId'] ?>">Reject</button>
                            </form>
                        <?php else: ?>
                            <span><?= $row['status'] ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile;
        else: ?>
            <tr><td colspan="6">No shift change requests found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="m-3">
    <h3>All Holiday Requests</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Requested Person ID</th>
                <th>Date Requested</th>
                <th>From Shift</th>
                <th>To Shift</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($holidayRes && $holidayRes->num_rows > 0):
            while ($row = $holidayRes->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['from_emp'] ?></td>
                    <td><?= $row['create_date'] ?></td>
                    <td><?= $days[$row['from_emp_shift']] ?? $row['from_emp_shift'] ?></td>
                    <td><?= $days[$row['to_emp_shift']] ?? $row['to_emp_shift'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <?php if ($row['status'] === 'P'): ?>
                            <form method="post" style="display:inline;">
                                <button class="btn btn-success btn-sm" name="accept_holiday" value="<?= $row['holidayChangeId'] ?>">Accept</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <button class="btn btn-danger btn-sm" name="reject_holiday" value="<?= $row['holidayChangeId'] ?>">Reject</button>
                            </form>
                        <?php else: ?>
                            <span><?= $row['status'] ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile;
        else: ?>
            <tr><td colspan="6">No holiday requests found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include("footer.php"); ?>
