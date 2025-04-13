<?php
include("header.php");
include("nav.php");

$days = [
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
    7 =>'Sunday'
];
$today = date('N');
$today%=7;

echo '<div class="container mt-4">';
echo '<h4>Choose a Day to Request Holiday Change:</h4>';
echo '<form method="post" class="mt-3">';
for ($i = $today+1; $i <= 7; $i++) {
    echo '<button type="submit" name="day" value="' . $i . '" class="btn btn-success m-2">' . $days[$i] . '</button>';
}
echo '</form>';
echo '</div>';

if (isset($_POST["day"])) {
    $selectedDay = $_POST["day"];
    echo '<div class="container mt-4">';
    $res = $con->query('SELECT * FROM schedule WHERE employeeId="'.$id.'" AND weekId="'.$weekid.'" AND holiday!=1 AND day>'.$selectedDay.' ');
    if ($row = $res->fetch_array()) {
        
        displayTable($selectedDay);
    }
    echo '</div>';
}

if (isset($_POST["request"])) {
    list($reqDay, $toEmp) = explode(' ', $_POST["request"]);
    $check = $con->query("SELECT holiday FROM schedule WHERE employeeId = '$id' AND day = '$reqDay'");
    if ($row = $check->fetch_assoc()) {
        if ($row['holiday'] == 1) {
            echo '<script>alert("You already have a holiday on that day.");</script>';
            return;
        }
    }

    $existing = $con->query("SELECT * FROM holidayrequest WHERE from_emp = '$id' AND to_emp = '$toEmp' AND week_id = '$weekid'");
    if ($existing->num_rows != 0) {
        echo '<script>alert("Request already sent to this employee for the same day.");</script>';
        return;
    }

    $fromHoliday = 0;
    $toHoliday = 1;
    $resFrom = $con->query("SELECT * FROM schedule WHERE employeeId = '$id' AND holiday=1 AND weekID = '$weekid'");
    if ($row = $resFrom->fetch_assoc()) $fromHoliday = $row['day'];

    $resTo = $con->query("SELECT * FROM schedule WHERE employeeId = '$toEmp' AND holiday=1 AND weekID = '$weekid'");
    if ($row = $resTo->fetch_assoc()) $toHoliday = $row['day'];

    $con->query("INSERT INTO holidayrequest 
        (from_emp, to_emp, week_id, from_emp_shift, to_emp_shift, status, create_date, response_date) 
        VALUES 
        ('$id', '$toEmp', '$weekid', '$fromHoliday', '$toHoliday', 'P', NOW(), NULL)");

    echo '<script>alert("Holiday change request sent.");</script>';
    echo '<div class="container mt-4"></div>';
}

function displayTable($day)
{
    global $con, $id, $weekid, $days,$city;

    $myHoliday = -1;
    $res = $con->query("SELECT holiday FROM schedule WHERE day = '$day' AND employeeId ='$id' AND weekID='$weekid'");
    if ($row = $res->fetch_assoc()) {
        $myHoliday = $row['holiday'];
    }

    if ($myHoliday == 1) {
        echo '<div class="alert alert-warning">You already have a holiday on ' . $days[$day] . '.</div>';
        return;
    }

    $res = $con->query("SELECT s.employeeId, e.full_name, s.holiday, s.shift 
                        FROM schedule s
                        JOIN employees e ON s.employeeId = e.id
                        WHERE s.day = '$day' AND s.weekID = '$weekid' AND s.employeeId !='$id' AND e.city='$city'");
    if ($res->num_rows == 0) {
        echo '<div class="alert alert-danger">No employees scheduled for this day.</div>';
        return;
    }

    echo '<h5>Available Employees for Holiday Swap on <strong>' . $days[$day] . '</strong>:</h5>';
    echo('<input type="text" class="form-control m-2" onkeyup="search()" id="search" placeholder="Enter name..."/>');
    echo '<table class="table table-bordered mt-3 employeetable">';
    echo '<thead><tr><th>Employee Name</th><th>Shift</th><th>Action</th></tr></thead><tbody>';

    $hasAvailable = false;
    while ($row = $res->fetch_assoc()) {
        $empId = $row['employeeId'];
        $empName = $row['full_name']; 
        $empShift = $row['shift'];
        if ($empId == $id || $row['holiday'] == $myHoliday) continue;

        $hasAvailable = true;

        // Check if the request has already been sent to this employee for the same day
        $q = $con->query("SELECT * FROM holidayrequest WHERE from_emp = '$id' AND to_emp = '$empId' AND day = '$day' AND week_id = '$weekid'");
        
        // If request already exists, disable the button
        $disable = ($q->num_rows > 0) ? 'disabled' : '';

        echo '<tr>';
        echo '<td>' . $empName . '</td>'; // Display the employee's name
        echo '<td>' . $empShift . '</td>'; // Display the employee's shift
        echo '<td>';
        echo '<form method="post">';
        echo '<input type="hidden" name="day" value="' . $day . '">';
        echo '<button class="btn btn-primary btn-sm" name="request" value="' . $day . ' ' . $empId . '" ' . $disable . '>Request</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    if (!$hasAvailable) {
        echo '<tr><td colspan="4">No employees available to swap holidays with.</td></tr>';
    }

    echo '</tbody></table>';
}
?>
<script>
    function search() {
            let val = document.getElementById("search").value.trim();
            console.log(val);
            let aa=document.querySelectorAll("#employeetable tbody tr")
            aa.forEach(row=>{
                    let text = row.textContent;
                    row.style.display = text.includes(val) ? "" : "none";
            })
        }
</script>