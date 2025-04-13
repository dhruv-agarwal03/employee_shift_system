<?php
    include("header.php");
    include("nav.php");
?>
<div>
    <h3>All Shift Change Requests</h3>
    <table class="table table-hover">
        <thead>
            <th>Requested Person ID</th>
            <th>Requested Person Name</th>
            <th>Date Requested</th>
            <th>Day</th>
            <th>Shift</th>
            <th>Status</th>
        </thead>
        <tbody>
        <?php
            $res = $con->query("SELECT sr.*, e.full_name as emp_name FROM `shiftrequest` sr
                                JOIN employees e ON sr.to_emp = e.id
                                WHERE sr.from_emp = '$id' AND sr.week_id = '$weekid'");

            if ($res && $res->num_rows > 0) {
                $days = [
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                    7 => 'Sunday'
                ];
                while ($row = $res->fetch_assoc()) {
                  echo '<tr class="border">';
                    echo "<td>" . $row['to_emp'] . "</td>";
                    echo "<td>" . $row['emp_name'] . "</td>";
                    echo "<td>" . $row['create_date'] . "</td>"; 
                    echo "<td>" . $days[$row['day']] . "</td>";
                    echo "<td>" . $row['shift'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No shift requests found.</td></tr>";
            }
        ?>
        </tbody>
    </table>
</div>

<div>
    <h3>All Holiday Requests</h3>
    <table class="table table-hover">
        <thead>
            <th>Requested Person ID</th>
            <th>Requested Person Name</th>
            <th>Date Requested</th>
            <th>From-Day</th>
            <th>To-Day</th>
            <th>Status</th>
        </thead>
        <tbody>
        <?php
            $res = $con->query("SELECT hr.*, e.full_name as emp_name FROM `holidayrequest` hr
                                JOIN employees e ON hr.to_emp = e.id
                                WHERE hr.from_emp = '$id' AND hr.week_id = '$weekid'");

            if ($res && $res->num_rows > 0) {
                $days = [
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                    7 => 'Sunday'
                ];
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['to_emp'] . "</td>";
                    echo "<td>" . $row['emp_name'] . "</td>";
                    echo "<td>" . $row['create_date'] . "</td>"; 
                    echo "<td>" . $days[$row['from_emp_shift']] . "</td>";
                    echo "<td>" . $days[$row['to_emp_shift']] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No holiday requests found.</td></tr>";
            }
        ?>
        </tbody>
    </table>
</div>

<?php
include("footer.php");
?>
