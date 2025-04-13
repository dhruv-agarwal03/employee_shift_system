<?php
session_start();
    $con=mysqli_connect("localhost","root","","employee_shift_system");
    $date=date('Y-m-d');
    if (date('l') == "Sunday") {
        $date = date('Y-m-d'); // make sure $date is defined
        $row = $con->query("SELECT * FROM weeks WHERE start_date = '$date'");
    
        if ($res = $row->fetch_assoc()) {
            // week already exists, you may want to fetch week_id here
            $weekid = $res['week_id'];
        } else {
            // get number of rows and set new weekid
            $countResult = $con->query("SELECT COUNT(*) as total FROM weeks");
            $countRow = $countResult->fetch_assoc();
            $weekid = $countRow['total'] + 1;
    
            $end_date = date('Y-m-d', strtotime('+6 days', strtotime($date)));
    
            // corrected query - column names don't use single quotes
            $con->query("INSERT INTO weeks (week_id, start_date, end_date) VALUES ('$weekid', '$date', '$end_date')");
        }
    }
    
?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <script scr="js/bootstrap.bundle.min.js"></script>
        <script scr="js/bootstrap.min.js"></script>
    </head>
        <body>
            