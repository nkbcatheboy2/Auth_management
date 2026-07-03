<?php
include 'db.php';


if(isset($_POST['save_proj'])){
    $stmt = $conn->prepare("INSERT INTO projects (client_name, mobile, work_type, budget, team_size, project_head, remarks) VALUES (?,?,?,?,?,?,?)");
    $bud = $_POST['budget'] ?? 0; $team = $_POST['team'] ?? 0; $head = $_POST['head'] ?? ''; $rem = $_POST['remarks'] ?? '';
    $stmt->bind_param("sssdiss", $_POST['client'], $_POST['mobile'], $_POST['work'], $bud, $team, $head, $rem);
    $stmt->execute();
    header("Location: dashboard.php?msg=Record Saved");
}


if(isset($_POST['add_staff'])){
    $u = $_POST['u'];
    $p = password_hash($_POST['p'], PASSWORD_DEFAULT);
    $r = $_POST['r'];
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$u'");
    if(mysqli_num_rows($check) > 0){ header("Location: dashboard.php?msg=User Already Exists"); }
    else {
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$u', '$p', '$r')");
        header("Location: dashboard.php?msg=Staff Created");
    }
}

if(isset($_GET['approve'])){
    mysqli_query($conn, "UPDATE projects SET status='approved' WHERE id=".$_GET['approve']);
    header("Location: dashboard.php?msg=Approved");
}

if(isset($_GET['del_proj'])){
    mysqli_query($conn, "DELETE FROM projects WHERE id=".$_GET['del_proj']);
    header("Location: dashboard.php?msg=Deleted");
}

if(isset($_GET['del_staff'])){
    mysqli_query($conn, "DELETE FROM users WHERE id=".$_GET['del_staff']);
    header("Location: dashboard.php?msg=Staff Removed");
}

// 4. Update Project
if(isset($_POST['update_proj'])){
    $id = $_POST['id']; $b = $_POST['budget']; $rem = $_POST['remarks'];
    mysqli_query($conn, "UPDATE projects SET budget='$b', remarks='$rem' WHERE id='$id'");
    header("Location: dashboard.php?msg=Updated");
}
?>
