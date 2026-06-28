<?php include 'db.php'; 
if(!isset($_SESSION['user'])) { header("Location: index.php"); exit(); }
$role = $_SESSION['role'];
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"><title>Dashboard</title></head>
<body>
    <?php if(isset($_GET['msg'])): ?><script>alert("<?php echo $_GET['msg']; ?>");</script><?php endif; ?>

    <nav class="navbar">
        <div class="nav-brand">ESPL AUTHORITY SYSTEM</div>
        <div>
            <span style="margin-right:15px;">👤 <?php echo strtoupper($user); ?> (<?php echo $role; ?>)</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container">
        <!-- Inquiry Form -->
        <div class="card">
            <h3>New Inquiry Registration</h3>
            <form action="process.php" method="POST" class="form-grid">
                <input type="text" name="client" placeholder="Client Name" required>
                <input type="text" name="mobile" placeholder="Mobile" required>
                <input type="text" name="work" placeholder="Work Details" required>
                <?php if($role != 'gatekeeper'): ?>
                    <input type="number" name="budget" placeholder="Budget (₹)">
                    <input type="number" name="team" placeholder="Team Size">
                    <input type="text" name="head" placeholder="Project Head">
                    <textarea name="remarks" placeholder="Remarks" style="grid-column: span 1;"></textarea>
                <?php endif; ?>
                <button type="submit" name="save_proj" class="btn-main">Save Record</button>
            </form>
        </div>

        <!-- Project Logs -->
        <?php if($role != 'gatekeeper'): ?>
        <div class="card">
            <h3>Project Estimation Logs</h3>
            <table>
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Work/Budget</th>
                        <th>Team/Head</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $res = mysqli_query($conn, "SELECT * FROM projects ORDER BY id DESC");
                    while($r = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td><b><?php echo $r['client_name']; ?></b><br><?php echo $r['mobile']; ?></td>
                        <td><?php echo $r['work_type']; ?><br><b>₹<?php echo number_format($r['budget']); ?></b></td>
                        <td><?php echo $r['team_size']; ?> People<br><?php echo $r['project_head']; ?></td>
                        <td><span class="badge <?php echo $r['status']; ?>"><?php echo strtoupper($r['status']); ?></span></td>
                        <td>
                            <?php if($role == 'admin'): ?>
                                <a href="edit_project.php?id=<?php echo $r['id']; ?>" style="color:blue;">Edit</a> | 
                                <a href="process.php?approve=<?php echo $r['id']; ?>" style="color:green;">Approve</a> | 
                                <a href="process.php?del_proj=<?php echo $r['id']; ?>" style="color:red;" onclick="return confirm('Delete?')">Del</a>
                            <?php else: ?> <span>No Action</span> <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- Staff List & Management (Admin Only) -->
        <?php if($role == 'admin'): ?>
        <div class="card">
            <h3>Staff Management</h3>
            <form action="process.php" method="POST" class="form-grid" style="margin-bottom:20px;">
                <input type="text" name="u" placeholder="New Username" required>
                <input type="text" name="p" placeholder="New Password" required>
                <select name="r"><option value="employee">Employee</option><option value="gatekeeper">Gatekeeper</option></select>
                <button type="submit" name="add_staff" class="btn-main" style="background:var(--dark);">Add Staff</button>
            </form>
            <h4>Current Staff</h4>
            <table>
                <?php $users = mysqli_query($conn, "SELECT * FROM users WHERE role != 'admin'");
                while($u = mysqli_fetch_assoc($users)) {
                    echo "<tr><td>{$u['username']}</td><td>{$u['role']}</td><td><a href='process.php?del_staff={$u['id']}' style='color:red;'>Remove Staff</a></td></tr>";
                } ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>