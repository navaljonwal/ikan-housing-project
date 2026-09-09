<?php
include('../components/auth.php');
include('../../config.php');

$search = mysqli_real_escape_string($con, $_GET['search'] ?? '');
$page = (int)($_GET['page'] ?? 1);
$limit = 10;
$offset = ($page - 1) * $limit;

$where = "";
if (!empty($search)) {
    $where = "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%' OR position LIKE '%$search%'";
}

// Count total rows
$countQuery = "SELECT COUNT(*) as total FROM resume_submissions $where";
$countResult = mysqli_query($con, $countQuery);
$total = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($total / $limit);

// Fetch paginated data
$query = "SELECT * FROM resume_submissions $where ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<body>

<div class="wrapper">
    <?php include('../components/viewSidebar.php'); ?>
    <div class="main-panel">
        <div class="main-header">
            <?php include('../components/viewNavbar.php'); ?>
        </div>

        <div class="container">
            <div class="page-inner">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h3 class="fw-bold mb-3">Career List</h3>
                    <form method="GET" action="" class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control border-end-0" placeholder="Search applications...">
                        <button class="btn btn-white border border-start-0" type="submit"><i class="fas fa-search text-muted"></i></button>
                    </form>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Resume Submissions</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Age</th>
                                        <th>Position</th>
                                        <th>C.V</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sr = $offset + 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $cv = !empty($row['resume_path']) ? "<a href='../../uploads/{$row['resume_path']}' download target='_blank'>Download</a>" : "N/A";
                                        echo "<tr>
                                            <td>{$sr}</td>
                                            <td>{$row['name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['mobile']}</td>
                                            <td>{$row['age']}</td>
                                            <td>{$row['position']}</td>
                                            <td>$cv</td>
                                        </tr>";
                                        $sr++;
                                    }

                                    if ($sr == $offset + 1) {
                                        echo "<tr><td colspan='7' class='text-center'>No records found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Unified Premium Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                <nav>
                                    <ul class="pagination pagination-primary mb-0">
                                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-left"></i></a>
                                        </li>
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include('../components/viewFooter.php'); ?>
    </div>
</div>
</body>
</html>
