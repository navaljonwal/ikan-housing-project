<?php
include('../components/auth.php');
include('../../config.php');

// Force browser to download as Excel
$filename = "Site_Visits_" . date('Y-m-d_His') . ".xls";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr style='background-color:#c02a7c; color:#ffffff;'>
    <th>Sr.No</th>
    <th>Customer Name</th>
    <th>Phone Number</th>
    <th>Email</th>
    <th>Target Property</th>
    <th>Scheduled Date</th>
    <th>Time Slot</th>
    <th>Status</th>
    <th>Booking Created At</th>
</tr>";

$query = "SELECT * FROM site_visits ORDER BY visit_date ASC, id DESC";
$result = mysqli_query($con, $query);
$sn = 1;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $visit_date = !empty($row['visit_date']) ? date('d-m-Y', strtotime($row['visit_date'])) : '-';
        $created_at = !empty($row['created_at']) ? date('d-m-Y h:i A', strtotime($row['created_at'])) : '-';
        
        echo "<tr>
            <td>{$sn}</td>
            <td>" . htmlspecialchars($row['name']) . "</td>
            <td>" . htmlspecialchars($row['phone']) . "</td>
            <td>" . htmlspecialchars($row['email'] ?? '') . "</td>
            <td>" . htmlspecialchars($row['property_name']) . "</td>
            <td>{$visit_date}</td>
            <td>" . htmlspecialchars($row['time_slot']) . "</td>
            <td>" . htmlspecialchars($row['status']) . "</td>
            <td>{$created_at}</td>
        </tr>";
        $sn++;
    }
}

echo "</table>";
exit();
