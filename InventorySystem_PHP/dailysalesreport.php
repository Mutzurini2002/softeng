<?php
$page_title = 'Daily Sales';
require_once('includes/load.php');
?>

<!doctype html>
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sales Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="libs/css/report.css">
</head>
<script type="text/javascript">
    function printReport() {  
      window.print();
    }
  </script>
<body>
    <?php
    // Retrieve parameters from the URL
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $day = isset($_GET['day']) ? $_GET['day'] : date('d');

    // Get sales data for the specified date
    $sales = dailySales($year, $month, $day);
    ?>
    <div class="page-break">
        <div class="sale-head">
            <h1>Sales Inventory System - Daily Sales Report</h1>
            <strong><?php echo "Date: $year-$month-$day"; ?></strong>
        </div>

        <?php if (!empty($sales)): ?>
            <table class="table table-border">
                <thead>
                    <tr>
                        <th>Product Title</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Total Quantity</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $result): ?>
                        <tr>
                            <td class="desc">
                                <h6><?php echo remove_junk(ucfirst($result['name'])); ?></h6>
                            </td>
                            <td class="text-right">
                            ₱ <?php echo isset($result['buy_price']) ? remove_junk($result['buy_price']) : ''; ?>
                            </td>
                            <td class="text-right">
                            ₱ <?php echo isset($result['sale_price']) ? remove_junk($result['sale_price']) : ''; ?>
                            </td>
                            <td class="text-right"><?php echo remove_junk($result['qty']); ?></td>
                            <td class="text-right">₱ <?php echo remove_junk($result['total_saleing_price']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="text-right">
                        <td colspan="3"></td>
                        <td colspan="1">Grand Total</td>
                        <td> ₱ <?php echo number_format(total_price($sales)[0], 2); ?></td>
                    </tr>
                    <tr class="text-right">
                        <td colspan="3"></td>
                        <td colspan="1">Profit</td>
                        <td> ₱ <?php echo number_format(total_price($sales)[1], 2); ?></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-right">
              <button class="btn btn-primary print-btn" onclick="printReport()">Print Report</button>
            </div>
        <?php else: ?>
            <p>No sales found for the specified date.</p>
        <?php endif; ?>
    </div>
</body>
</html>
