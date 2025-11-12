<?php
session_start();
include("config.php");

header("Content-Type: application/json");

// Enable error reporting during debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = [
  "status" => "error",
  "message" => "Unknown error",
  "total" => 0,
  "liked" => false
];

try {
    if (!isset($_POST['post_id']) || !isset($_SESSION['UID'])) {
        throw new Exception("Missing required data.");
    }

    $post_id = intval($_POST['post_id']);
    $user_id = intval($_SESSION['UID']);

    // --- Get post owner and path ---
    $oidd = $conn->prepare("SELECT UserId, path FROM posts WHERE PostId = ?");
    $oidd->bind_param("i", $post_id);
    $oidd->execute();
    $oidd->bind_result($oid, $path);
    if (!$oidd->fetch()) {
        throw new Exception("Post not found.");
    }
    $oidd->close();

    // --- Get owner details ---
    $oiddd = $conn->prepare("SELECT UserName, Profile_picture FROM users WHERE UserId = ?");
    $oiddd->bind_param("i", $oid);
    $oiddd->execute();
    $oiddd->bind_result($toName, $ppf);
    $oiddd->fetch();
    $oiddd->close();

    // --- Check if user already liked the post ---
    $check = $conn->prepare("SELECT LikeId FROM likes WHERE PostId = ? AND UserId = ?");
    $check->bind_param("ii", $post_id, $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // --- Unlike ---
        $del = $conn->prepare("DELETE FROM likes WHERE PostId = ? AND UserId = ?");
        $del->bind_param("ii", $post_id, $user_id);
        $del->execute();
        $del->close();

        $delNot = $conn->prepare("DELETE FROM notifications WHERE PostId = ? AND fromId = ? AND label='Likes'");
        $delNot->bind_param("ii", $post_id, $user_id);
        $delNot->execute();
        $delNot->close();

        $liked = false;
    } else {
        // --- Like ---
        $ins = $conn->prepare("INSERT INTO likes (PostId, UserId) VALUES (?, ?)");
        $ins->bind_param("ii", $post_id, $user_id);
        $ins->execute();
        $ins->close();

        $insNot = $conn->prepare("
            INSERT INTO notifications 
            (fromId, toId, msg, postId, fromppf, postPreview, label, fromName) 
            VALUES (?, ?, 'liked your post', ?, ?, ?, 'Likes', ?)
        ");
        $insNot->bind_param("iiisss", $user_id, $oid, $post_id, $_SESSION['Profile_picture'], $path, $_SESSION['UserName']);
        $insNot->execute();
        $insNot->close();

        $liked = true;
    }

    $check->close();

    // --- Get updated like count ---
    $count = $conn->prepare("SELECT COUNT(*) FROM likes WHERE PostId = ?");
    $count->bind_param("i", $post_id);
    $count->execute();
    $count->bind_result($total);
    $count->fetch();
    $count->close();

    $response = [
        "status" => "success",
        "message" => "Operation completed",
        "total" => $total,
        "liked" => $liked
    ];

} catch (mysqli_sql_exception $e) {
    // Catches MySQLi errors
    $response['message'] = "Database error: " . $e->getMessage();
} catch (Exception $e) {
    // Catches general errors
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
