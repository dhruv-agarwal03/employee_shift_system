<?php
include("header.php");
include("nav.php");
echo('<div class="container mt-4">');
$todayWeek = date('N'); 
$days = [
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
    7 => 'Sunday'
];

echo('<div class="h4 m-3">Choose the Day:</div><form method="post">');
for ($i = $todayWeek; $i <= 7; $i++) {
    echo('<button class="btn btn-success m-2" name="day" value="' . $i . '">' . $days[$i] . '</button>');
}
echo('</form>');
?>

<div>
    <?php 
    if (isset($_POST["day"])) { 
        $helpday = $_POST["day"];
        echo('<input type="text" id="searchInput" onkeyup="searchTable()" class="form-control " placeholder="Search employee name">');
        table($helpday);        
    }

    function table($reqday) {
        global $con, $id, $weekid, $days,$city;

        $res = $con->query("SELECT * FROM `schedule` WHERE day='$reqday' AND employeeId='$id' and weekID='$weekid'");
        $shift = '-1';

        if ($hol = $res->fetch_assoc()) {
            if ($hol["holiday"] == 1) {
                echo('<div class="text-danger h4 m-3">You are on Leave</div>');
                return;
            } else {
                echo('<div class="text-primary h4 m-3">Your shift is ' . $hol["shift"] . '</div>');
                $shift = $hol["shift"];
            }
        }

        $res = $con->query("SELECT s.*, e.*
                            FROM schedule s 
                            JOIN employees e ON s.employeeId = e.id 
                            WHERE s.day='$reqday' AND s.weekId='$weekid' AND s.shift != '$shift' AND e.city='$city' ");

        if ($res->num_rows > 0) {
            echo('<table class="table" id="employeeTable">');
            echo('<thead><tr><th>Employee Name</th><th>Day</th><th>Shift</th><th>Week ID</th><th>Action</th></tr></thead><tbody>');

            while ($row = $res->fetch_assoc()) {
                if ($row['employeeId'] == $id || $row["shift"] == $shift) continue;

                $toEmp = $row['employeeId'];
                $ischeck = $con->query("SELECT * FROM shiftrequest 
                                             WHERE from_emp = '$id' 
                                             AND to_emp = '$toEmp' 
                                             AND day = '$reqday' 
                                             AND week_id = '$weekid' 
                                             AND status = 'P'");
                $result = ($ischeck->num_rows > 0);

                echo('<tr>');
                echo('<td>' . $row['full_name'] . '</td>');
                echo('<td>' . $days[$reqday] . '</td>'); 
                echo('<td>' . $row['shift'] . '</td>');
                echo('<td>' . $row['weekID'] . '</td>');
                echo('<td><form method="post">');
                echo('<button class="btn btn-' . ($result ? 'secondary' : 'primary') . '" name="request" value="' . $reqday . ' ' . $toEmp . '" ' . ($result ? 'disabled' : '') . '>');
                echo($result ? 'Requested' : 'Request');
                echo('</button>');
                echo('</form></td>');
                echo('</tr>');
            }

            echo('</tbody></table>');
        } else {
            echo("<div class='text-muted'>No schedule found for the selected day and shift.</div>");
        }
    }

    if (isset($_POST["request"])) {
        $btnv = explode(' ', $_POST["request"]);
        $reqDay = $btnv[0]; 
        $employeeId = $btnv[1];
        $createDate = date('Y-m-d H:i:s'); 
        $status = 'P';

        $shiftQuery = $con->query("SELECT shift FROM `schedule` WHERE employeeId = '$employeeId' AND day = '$reqDay'");
        $shift = '';
        if ($shiftResult = $shiftQuery->fetch_assoc()) {
            $shift = $shiftResult['shift']; 
        }

        $insertQuery = "INSERT INTO `shiftrequest` (from_emp, to_emp, week_id, day, shift, status, create_date) 
                        VALUES ('$id', '$employeeId', '$weekid', '$reqDay', '$shift', '$status', '$createDate')";
        $con->query($insertQuery);
        echo('<script>alert("Request Sent!");</script>');
        table($reqDay);
    }
    ?>
</div>

<script>
function searchTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    let rows = document.querySelectorAll("#employeeTable tbody tr");

    rows.forEach(row => {
        let text = row.textContent;
        row.style.display = text.includes(filter) ? "" : "none";
    });
}
</script>

<?php
include("footer.php");
?>
