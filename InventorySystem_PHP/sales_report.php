<?php
  $page_title = 'Sale Report';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

  // Fetch all categories from the database
  $all_categories = find_all('categories'); 
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">
        <!-- Panel heading content (optional) -->
      </div>
      <div class="panel-body">
        <form class="clearfix" method="post" action="sale_report_process.php">
          <!-- Date range filter -->
          <div class="form-group">
            <label class="form-label">Date Range</label>
            <div class="input-group">
              <input type="text" class="datepicker form-control" name="start-date" placeholder="From">
              <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
              <input type="text" class="datepicker form-control" name="end-date" placeholder="To">
            </div>
          </div>

          <!-- Category filter -->
          <div class="form-group">
            <label class="form-label">Category</label>
            <select class="form-control" name="category">
              <option value="">Select Category (Optional)</option>
              <?php foreach ($all_categories as $category): ?>
                <option value="<?php echo (int)$category['id']; ?>">
                  <?php echo $category['name']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Submit button -->
          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Generate Report</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
