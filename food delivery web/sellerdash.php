<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("location:login.php");
    exit;
}
$host='localhost';
$dbname='wedding_planner';
$password='';
try{
    $pdo=new PDO("My sql:host=$host;dbname=$dbname",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}Catch(PDOException $e){
    die("connection failed:".$e->getmessage());
}
$stmt=$pdo->prepare("select*FROMusers");
$stmt->execute();
$users=$stmt->fetchall();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <h2>Welcome,
        <?php echo $_session['admin_username'];?>!
    </h2>
    <p>You're logged in asan admin.</p>
    <a href="logout.php">logout</a>
    <h3>user list</h3>
    <table>
    ?></td>
?></td>
?></td>
<thead>
<tr>
<th>ID</th>
<th>Username</th>
<th>Email</th>
<th>Created At</th>
</tr>
</thead>
<tbody>
<?php if (count($users) > 0): ?>
<?php foreach ($users as $user): ?>
<tr>
<td><?php echo htmlspecialchars($user['id']); ?></td> <td><?php echo htmlspecialchars($user['name']);
<td><?php echo htmlspecialchars($user['email']);
<td><?php echo htmlspecialchars($user['created_at']);
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="4">No users found.</td> </tr>
<?php endif; ?>
</tbody>
</table>
</body>
</html>