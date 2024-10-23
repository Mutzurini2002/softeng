<?php
  require_once('includes/load.php'); // Load database connection and any necessary files

  $image_dir = 'uploads/products/';
  $files = array_diff(scandir($image_dir), array('.', '..'));

  foreach ($files as $file) {
      $file_type = mime_content_type($image_dir . $file);
      $query = "INSERT INTO media (file_name, file_type) VALUES ('$file', '$file_type')";
      $db->query($query);
  }

  echo "Media files have been synced.";
?>
