<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            $sql = "
            SELECT order_detail.pro_id,table_order.orderID, SUM(orderPrice) AS total, DATE_FORMAT(reg_date, '%Y-%M-%D') AS reg_date
            FROM order_detail
            INNER JOIN table_order ON order_detail.orderID = table_order.orderID
            GROUP BY DATE_FORMAT(reg_date, '%m')
            ORDER BY DATE_FORMAT(reg_date, '%Y-%m-%d') DESC";

            $result = mysqli_query($conn, $sql);
            $resultchart = mysqli_query($conn, $sql);
            //for chart
            $datesave = array();
            $total = array();
            while ($rs = mysqli_fetch_array($resultchart)) {
                $datesave[] = "\"" . $rs['reg_date'] . "\"";
                $total[] = "\"" . $rs['total'] . "\"";
            }
            $datesave = implode(",", $datesave);
            $total = implode(",", $total);

            ?>
            <h4 align="center">รายงานสั่งซื้อสินค้า</h4>

            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
            <hr>
            <p align="center">
                <!--devbanban.com-->
                <canvas id="myChart" width="800px" height="300px"></canvas>
                <script>
                    var ctx = document.getElementById("myChart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: [<?php echo $datesave; ?>

                            ],
                            datasets: [{
                                label: 'รายงานรายได้ทั้งหมด (บาท)',
                                data: [<?php echo $total; ?>],
                                backgroundColor: [
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255,99,132,1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                </script>
            </p>
            <div class="col-sm-12">
                <h3>ตารางรายได้</h3>
                <table class="table table-striped" border="1" cellpadding="0" cellspacing="0" align="center">
                    <thead>
                        <tr class="table-primary">
                            <th width="20%">วัน/เดือน/ปี (เวลาสั่งซื้อ)</th>
                            <th width="50%">รหัสสั่งซื้อ</th>
                            <th width="10%">รายได้</th>
                        </tr>
                    </thead>


                    <?php

                    $sql = "
            SELECT order_detail.total, table_order.reg_date,table_order.total_price, table_order.orderID,order_detail.orderID,order_detail.orderPrice
            FROM order_detail
            INNER JOIN table_order ON order_detail.orderID = table_order.orderID
            ORDER BY pro_id DESC";
                    $result2 = mysqli_query($conn, $sql);
                    while ($row2 = mysqli_fetch_array($result2)) {

                    ?>
                        <tr>
                            <td><?php echo $row2['reg_date']; ?></td>
                            <td><?php echo $row2['orderID']; ?></td>
                            <td align="right"><?php echo number_format($row2['orderPrice'], 2); ?></td>
                        </tr>
                    <?php
                        @$amount_total += $row2['total_price'];
                    }
                    ?>
                    <tr class="table-success">
                        <td align="center"></td>
                        <td align="center">รวม</td>
                        <td align="right"> <b>
                                <?php echo number_format($amount_total, 2); ?> บาท</b></td>
                        </td>
                    </tr>
                </table>
            </div>
            <?php mysqli_close($conn); ?>
        </div>
    </div>
</div>