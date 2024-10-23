<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username','password');
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);
function authenticate_v2($username, $password) {
  global $db;

  $sql = "SELECT id, username, password, user_level, status FROM users WHERE username = '{$username}' LIMIT 1";
  $result = $db->query($sql);

  if ($db->num_rows($result)) {
      $user = $db->fetch_assoc($result);

      // Debug output
      error_log("Username: {$username}, Status: {$user['status']}");

      // Check if the user is deactivated
      if ((int)$user['status'] === 0) {
          return false; // User is deactivated
      }

      // Verify password
      if (password_verify($password, $user['password'])) {
          return $user; // Return user details if authenticated
      }
  }

  return false; // Return false if no match or deactivated
}

if(empty($errors)) {

    $user = authenticate_v2($username, $password);
    
    if($user):
        // Create session with id
        $session->login($user['id']);
        // Update Sign in time
        updateLastLogIn($user['id']);
        // Redirect user to group home page by user level
        if($user['user_level'] === '1'):
            $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
            redirect('admin.php', false);
        elseif ($user['user_level'] === '2'):
            $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
            redirect('special.php', false);
        else:
            $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
            redirect('home.php', false);
        endif;

    else:
        // Adjust message to indicate deactivation
        $session->msg("d", "Sorry, your account may be deactivated or the username/password is incorrect.");
        redirect('index.php', false);
    endif;

} else {
    $session->msg("d", $errors);
    redirect('login_v2.php', false);
}
?>
