<?php
require_once 'auth.php';
requireLogin();
include 'header.php';
require 'config.php';

$success = '';
$error = '';

// ✅ Seed default GBV case types if not already present
$default_case_types = [
    ['type_name' => 'Sexual Violence', 'description' => 'Includes rape, sexual assault, and unwanted sexual advances.'],
    ['type_name' => 'Physical Abuse', 'description' => 'Includes hitting, slapping, or any form of physical harm.'],
    ['type_name' => 'Emotional Abuse', 'description' => 'Verbal abuse, threats, and psychological manipulation.'],
    ['type_name' => 'Economic Abuse', 'description' => 'Control over access to financial resources.'],
    ['type_name' => 'Child Marriage', 'description' => 'Marriage involving minors below legal age.'],
    ['type_name' => 'Female Genital Mutilation', 'description' => 'Cutting or removal of female genitalia.'],
    ['type_name' => 'Sexual Harassment', 'description' => 'Unwelcome sexual advances, requests for sexual favors, and other verbal or physical conduct.']
];

foreach ($default_case_types as $case_type) {
    $check = $conn->prepare("SELECT * FROM case_types WHERE type_name = ?");
    $check->bind_param("s", $case_type['type_name']);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows === 0) {
        $insert = $conn->prepare("INSERT INTO case_types (type_name, description) VALUES (?, ?)");
        $insert->bind_param("ss", $case_type['type_name'], $case_type['description']);
        $insert->execute();
    }
}

// ✅ Handle new case type submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_case_type'])) {
    $type_name = trim($_POST['type_name']);
    $description = trim($_POST['description']);

    if ($type_name !== '') {
        $stmt = $conn->prepare("INSERT INTO case_types (type_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $type_name, $description);
        $stmt->execute();
        $success = "Case type added successfully.";
    } else {
        $error = "Type name is required.";
    }
}

// ✅ Handle deletion
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $del_stmt = $conn->prepare("DELETE FROM case_types WHERE case_type_id = ?");
    $del_stmt->bind_param("i", $delete_id);
    $del_stmt->execute();
    $success = "Case type deleted.";
}

// ✅ Fetch all case types
$case_types = [];
$result = $conn->query("SELECT * FROM case_types ORDER BY case_type_id DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $case_types[] = $row;
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-3 text-primary">Manage GBV Case Types</h2>

    <p class="mb-4">
        Gender-Based Violence (GBV) comes in various forms, and accurately classifying them is essential to ensure proper reporting and response. Use this panel to manage all possible types of GBV cases that may be reported by survivors or converted from anonymous submissions.
    </p>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Add New Type Form -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Add New Case Type</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Type Name*</label>
                            <input type="text" name="type_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                        <button type="submit" name="add_case_type" class="btn btn-primary w-100">Add Case Type</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Display Case Types -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">Available Case Types</div>
                <div class="card-body">
                    <?php if (count($case_types) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Type Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($case_types as $type): ?>
                                        <tr>
                                            <td><?= $type['case_type_id'] ?></td>
                                            <td><?= htmlspecialchars($type['type_name']) ?></td>
                                            <td><?= nl2br(htmlspecialchars($type['description'])) ?></td>
                                            <td>
                                                <a href="?delete=<?= $type['case_type_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this type?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No case types defined yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>