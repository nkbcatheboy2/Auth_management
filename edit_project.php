<?php include 'db.php'; 
$id = $_GET['id'];
$r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM projects WHERE id='$id'"));
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"><title>Edit</title></head>
<body>
    <div class="container" style="max-width:500px;">
        <div class="card">
            <h3>Edit Record: <?php echo $r['client_name']; ?></h3>
            <form action="process.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <p>Budget:</p><input type="number" name="budget" value="<?php echo $r['budget']; ?>">
                <p>Remarks:</p><textarea name="remarks"><?php echo $r['remarks']; ?></textarea>
                <button type="submit" name="update_proj" class="btn-main" style="margin-top:15px;">Update Now</button>
            </form>
        </div>
    </div>
</body>
</html>