<?php  
require_once 'auth.php';  
requireLogin();  
include 'header.php';  
require 'config.php';  
  
$success = '';  
$error = '';  
  
// Handle form submission  
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_survivor'])) {  
    $name = trim($_POST['full_name']);  
    $dob = $_POST['date_of_birth'];  
    $gender = $_POST['gender'];  
    $contact = trim($_POST['contact_info']);  
    $location = trim($_POST['location']);  
  
    if ($name && $dob && $gender) {  
        $stmt = $conn->prepare("INSERT INTO survivors (full_name, date_of_birth, gender, contact_info, location) VALUES (?, ?, ?, ?, ?)");  
        if ($stmt) {  
            $stmt->bind_param("sssss", $name, $dob, $gender, $contact, $location);  
            $stmt->execute();  
            $success = "Survivor added successfully.";  
        } else {  
            $error = "Database error: " . $conn->error;  
        }  
    } else {  
        $error = "Please fill all required fields.";  
    }  
}  
  
// Handle delete  
if (isset($_GET['delete'])) {  
    $delete_id = $_GET['delete'];  
    $stmt = $conn->prepare("DELETE FROM survivors WHERE survivor_id = ?");  
    if ($stmt) {  
        $stmt->bind_param("i", $delete_id);  
        $stmt->execute();  
        $success = "Survivor record deleted.";  
    } else {  
        $error = "Delete failed: " . $conn->error;  
    }  
}  
  
// Fetch survivors  
$survivors = [];  
$result = $conn->query("SELECT * FROM survivors ORDER BY created_at DESC");  
  
if ($result && $result->num_rows > 0) {  
    while ($row = $result->fetch_assoc()) {  
        $survivors[] = $row;  
    }  
}  
?>  

<div class="container mt-5">  
    <h2 class="mb-4 text-primary">Survivor Records</h2>  

    <?php if ($success): ?>  
        <div class="alert alert-success"><?= $success ?></div>  
    <?php endif; ?>  
    <?php if ($error): ?>  
        <div class="alert alert-danger"><?= $error ?></div>  
    <?php endif; ?>  

    <div class="row">  
        <!-- Survivor Form -->  
        <div class="col-md-4">  
            <div class="card shadow">  
                <div class="card-header bg-primary text-white">  
                    Add New Survivor  
                </div>  
                <div class="card-body">  
                    <form method="POST">  
                        <div class="mb-3">  
                            <label class="form-label">Full Name*</label>  
                            <input type="text" name="full_name" class="form-control" required>  
                        </div>  
                        <div class="mb-3">  
                            <label class="form-label">Date of Birth*</label>  
                            <input type="date" name="date_of_birth" class="form-control" required>  
                        </div>  
                        <div class="mb-3">  
                            <label class="form-label">Gender*</label>  
                            <select name="gender" class="form-select" required>  
                                <option value="">Select Gender</option>  
                                <option value="female">Female</option>  
                                <option value="male">Male</option>  
                                <option value="non_binary">Non-Binary</option>  
                                <option value="other">Other</option>  
                            </select>  
                        </div>  
                        <div class="mb-3">  
                            <label class="form-label">Contact Info</label>  
                            <input type="text" name="contact_info" class="form-control">  
                        </div>  
                        <div class="mb-3">  
                            <label class="form-label">Location</label>  
                            <input type="text" name="location" class="form-control">  
                        </div>  
                        <button type="submit" name="add_survivor" class="btn btn-primary w-100">Add Survivor</button>  
                    </form>  
                </div>  
            </div>  
        </div>  

        <!-- Survivor List -->  
        <div class="col-md-8">  
            <div class="card shadow">  
                <div class="card-header bg-success text-white">  
                    All Registered Survivors  
                </div>  
                <div class="card-body">  
                    <?php if (count($survivors) > 0): ?>  
                    <div class="table-responsive">  
                        <table class="table table-bordered table-striped align-middle">  
                            <thead class="table-light">  
                                <tr>  
                                    <th>ID</th>  
                                    <th>Name</th>  
                                    <th>Date of Birth</th>  
                                    <th>Age</th>  
                                    <th>Gender</th>  
                                    <th>Contact</th>  
                                    <th>Location</th>  
                                    <th>Created At</th>  
                                    <th>Action</th>  
                                </tr>  
                            </thead>  
                            <tbody>  
                                <?php foreach ($survivors as $s): ?>  
                                    <tr>  
                                        <td><?= $s['survivor_id'] ?></td>  
                                        <td><?= htmlspecialchars($s['full_name']) ?></td>  
                                        <td><?= htmlspecialchars($s['date_of_birth']) ?></td>  
                                        <td>
                                            <?php  
                                                if (!empty($s['date_of_birth'])) {  
                                                    $dob = new DateTime($s['date_of_birth']);  
                                                    $now = new DateTime();  
                                                    echo $dob->diff($now)->y;  
                                                } else {  
                                                    echo 'N/A';  
                                                }  
                                            ?>  
                                        </td>  
                                        <td><?= ucfirst($s['gender']) ?></td>  
                                        <td><?= htmlspecialchars($s['contact_info']) ?></td>  
                                        <td><?= htmlspecialchars($s['location']) ?></td>  
                                        <td><?= $s['created_at'] ?></td>  
                                        <td>  
                                            <a href="?delete=<?= $s['survivor_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this survivor?')">Delete</a>  
                                        </td>  
                                    </tr>  
                                <?php endforeach; ?>  
                            </tbody>  
                        </table>  
                    </div>  
                    <?php else: ?>  
                        <p class="text-muted">No survivors found.</p>  
                    <?php endif; ?>  
                </div>  
            </div>  
        </div>  
    </div>  
</div>  

<?php include 'footer.php'; ?>