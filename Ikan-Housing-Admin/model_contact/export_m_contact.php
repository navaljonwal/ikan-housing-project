<?php
include('../../config.php');

// Force browser to download as Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=contact_data.xls");

echo "<table border='1'>";
echo "<tr>
    <th>Sr.No</th>
    <th>Phone</th>
    <th>Property</th>         
    <th>Date</th>
</tr>";

$query = "SELECT * FROM modal_contact ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
$sn = 1;

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$sn}</td>
        <td>{$row['phone_no']}</td>
        <td>{$row['property']}</td>
        <td>" . date('d-m-Y h:i A', strtotime($row['created_at'])) . "</td>
    </tr>";
    $sn++;
}

echo "</table>";
exit;
?>
