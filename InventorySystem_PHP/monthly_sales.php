<?php
  $page_title = 'Monthly Sales';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

// Fetch monthly sales data
$current_month = date('n'); // Use 'n' to get the month without leading zeros
$current_year = date('Y');
$sales = monthlySales($current_month, $current_year);

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo $msg; ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Monthly Sales</span>
        </strong>
        <a href="monthlysalesreport.php?year=<?php echo $current_year ?>&month=<?php echo $current_month ?>&day=<?php echo date('d'); ?>" class="btn btn-primary pull-right">Generate Report</a>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Product name</th>
              <th class="text-center" style="width: 15%;">Quantity sold</th>
              <th class="text-center" style="width: 15%;">Total (₱)</th>
              <th class="text-center" style="width: 15%;">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($sales) : ?>
              <?php foreach ($sales as $sale): ?>
                <tr>
                  <td class="text-center"><?php echo count_id();?></td>
                  <td><?php echo remove_junk($sale['name']); ?></td>
                  <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
                  <td class="text-center">₱ <?php echo remove_junk($sale['total_saleing_price']); ?></td>
                  <td class="text-center"><?php echo $sale['date']; ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">No sales for the current month.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
