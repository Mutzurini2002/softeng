<?php
require_once('includes/load.php');
require_once('auth_v2.php');

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = remove_junk($db->escape($_POST['username']));
    $password = remove_junk($db->escape($_POST['password']));

    // Query the database for the user's details
    $sql  = "SELECT id, username, password, user_level, status ";
    $sql .= "FROM users ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "LIMIT 1";
    $result = $db->query($sql);

    if ($db->num_rows($result)) {
        $user = $db->fetch_assoc($result);

        // Check if the user is deactivated
        if ((int)$user['status'] === 0) {  // Using integer comparison for status
            $session->msg('d', 'Your account has been deactivated. Please contact the administrator.');
            redirect('login.php', false);
        }

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, log the user in
            $session->login($user['id']);
            $session->name = $user->name; // After user is authenticated
            $session->name = $user['username']; // Store user's name in session
            $session->msg('s', 'Welcome ' . $user['username']);
            redirect('home.php', false);
        } else {
            $session->msg('d', 'Invalid username or password.');
            redirect('login.php', false);
        }
    } else {
        $session->msg('d', 'Invalid username or password.');
        redirect('login.php', false);
    }
} else {
    redirect('login.php', false);
}
?>
