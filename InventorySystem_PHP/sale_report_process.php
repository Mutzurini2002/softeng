<?php
$page_title = 'Sales Report';
$results = '';
require_once('includes/load.php');
// Check user permissions
page_require_level(3);

if (isset($_POST['submit'])) {
    $req_dates = array('start-date', 'end-date');
    validate_fields($req_dates);

    if (empty($errors)) {
        $start_date = remove_junk($db->escape($_POST['start-date']));
        $end_date = remove_junk($db->escape($_POST['end-date']));
        $category = remove_junk($db->escape($_POST['category'])); // New category filter

        // Build the query for the report
        $sql = "SELECT sales.*, products.name, products.buy_price, products.sale_price, 
               CAST(products.quantity AS UNSIGNED) AS total_sales, 
               (CAST(products.quantity AS UNSIGNED) * products.sale_price) AS total_saleing_price 
        FROM sales 
        JOIN products ON sales.product_id = products.id 
        WHERE sales.date BETWEEN '{$start_date}' AND '{$end_date}'";

if (!empty($category)) {
    $sql .= " AND products.categorie_id = '{$category}'"; // Use categorie_id here
}


        // Fetch results
        $results = $db->query($sql);
        
        if ($results && $results->num_rows > 0) {
            // Your report generation code
        } else {
            $session->msg("d", "No sales found for the selected criteria.");
            redirect('sales_report.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('sales_report.php', false);
    }
} else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
}

?>
<!doctype html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Sales Report</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="libs/css/report.css">
</head>
<body>
  <?php if($results): ?>
    <div class="page-break">
      <div class="sale-head">
          <h1>Sales Inventory System - Sales Report</h1>
          <strong><?php if(isset($start_date)){ echo $start_date;}?> TILL DATE <?php if(isset($end_date)){echo $end_date;}?> </strong>
      </div>
      <!-- Print Button -->
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Product Title</th>
              <th>Buying Price</th>
              <th>Selling Price</th>
              <th>Total Quantity</th>
              <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $result): ?>
          <tr>
              <td class=""><?php echo remove_junk($result['date']);?></td>
              <td class="desc">
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td class="text-right">₱ <?php echo remove_junk($result['buy_price']);?></td>
              <td class="text-right">₱ <?php echo remove_junk($result['sale_price']);?></td>
              <td class="text-right"><?php echo remove_junk($result['total_sales']);?></td>
              <td class="text-right">₱ <?php echo remove_junk($result['total_saleing_price']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr class="text-right">
              <td colspan="4"></td>
              <td colspan="1">Grand Total</td>
              <td> ₱ <?php echo number_format(totals_price($results)[0], 2); ?></td>
          </tr>
          <tr class="text-right">
              <td colspan="4"></td>
              <td colspan="1">Profit</td>
              <td> ₱ <?php echo number_format(totals_price($results)[1], 2); ?></td>
          </tr>
          
        </tfoot>
      </table>
      <div class="text-right">
    <button class="btn btn-primary print-btn" onclick="printReport()">Print Report</button>
  </div>
    </div>

  <?php
    else:
        $session->msg("d", "Sorry no sales has been found.");
        redirect('sales_report.php', false);
    endif;
  ?>
  <script type="text/javascript">
    function printReport() {  
      window.print();
    }
  </script>



</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
