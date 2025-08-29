<?php
require_once 'auth.php';
requireLogin();
include 'header.php';
require 'config.php';

$success = '';
$error = '';

// Handle new perpetrator form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_perpetrator'])) {
    $name = trim($_POST['full_name']);
    $relationship = trim($_POST['relationship_to_survivor']);
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    if ($name && $relationship && $age && $gender) {
        $stmt = $conn->prepare("INSERT INTO perpetrators (full_name, relationship_to_survivor, age, gender) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $relationship, $age, $gender]);
        $success = "Perpetrator added successfully.";
    } else {
        $error = "Please fill all required fields.";
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $conn->prepare("DELETE FROM perpetrators WHERE perpetrator_id = ?")->execute([$delete_id]);
    $success = "Perpetrator deleted.";
}

// Fetch all perpetrators
$perpetrators = [];
$result = $conn->query("SELECT * FROM perpetrators ORDER BY created_at DESC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $perpetrators[] = $row;
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-primary">Perpetrator Records</h2>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Perpetrator Form -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-danger text-white">
                    Add New Perpetrator
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name*</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Relationship to Survivor*</label>
                            <input type="text" name="relationship_to_survivor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Age*</label>
                            <input type="number" name="age" class="form-control" required min="1" max="120">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender*</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                                <option value="non_binary">Non-Binary</option>
                                <option value="unknown">Unknown</option>
                            </select>
                        </div>
                        <button type="submit" name="add_perpetrator" class="btn btn-danger w-100">Add Perpetrator</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Perpetrator List -->
        <div class="col-md-8">
            <div class="card shadow h-100">
                <div class="card-header bg-secondary text-white">
                    All Perpetrators
                </div>
                <div class="card-body">
                    <?php if (count($perpetrators) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Relationship</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($perpetrators as $p): ?>
                                <tr>
                                    <td><?= $p['perpetrator_id'] ?></td>
                                    <td><?= htmlspecialchars($p['full_name']) ?></td>
                                    <td><?= htmlspecialchars($p['relationship_to_survivor']) ?></td>
                                    <td><?= $p['age'] ?></td>
                                    <td><?= $p['gender'] ?></td>
                                    <td><?= $p['created_at'] ?></td>
                                    <td>
                                        <a href="?delete=<?= $p['perpetrator_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <p class="text-muted">No perpetrators recorded yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>