<?php
include('../../config.php');

// Force browser to download as Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=contact_data.xls");

echo "<table border='1'>";
echo "<tr>
    <th>Sr.No</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Property</th>         
    <th>Date</th>
</tr>";

$query = "SELECT * FROM right_contact ORDER BY id DESC";
$result = mysqli_query($con, $query);
$sn = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $dateVal = $row['created_At'] ?? ($row['created_at'] ?? '');
    $dateFormatted = !empty($dateVal) ? date('d-m-Y h:i A', strtotime($dateVal)) : 'N/A';
    $propertyName = !empty($row['property_name']) ? $row['property_name'] : ($row['property_slug'] ?? 'General Inquiry');
    echo "<tr>
        <td>{$sn}</td>
        <td>" . htmlspecialchars($row['name'] ?? '') . "</td>
        <td>" . htmlspecialchars($row['email'] ?? '') . "</td>
        <td>" . htmlspecialchars($row['phone'] ?? '') . "</td>
        <td>" . htmlspecialchars($propertyName) . "</td>
        <td>{$dateFormatted}</td>
    </tr>";
    $sn++;
}

echo "</table>";
exit;
?>
