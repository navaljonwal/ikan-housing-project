<?php
include('../../config.php');

// Force browser to download as Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=subscriber_data.xls");

echo "<table border='1'>";
echo "<tr>
    <th>Sr.no</th>
    <th>Subscribe Email</th>
    <th>Date</th>
</tr>";

$query = "SELECT * FROM subscribe_us ORDER BY subscribed_at DESC";
$result = mysqli_query($con, $query);
$sn = 1;

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$sn}</td>
        <td>{$row['email']}</td>
        <td>" . date('d-m-Y h:i A', strtotime($row['subscribed_at'])) . "</td>
    </tr>";
    $sn++;
}

echo "</table>";
exit;
?>
