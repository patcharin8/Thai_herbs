<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            $sql = "
            SELECT d.pro_id,t.orderID, SUM(total_price) AS total, YEAR(reg_date) AS reg_date 
            FROM order_detail AS d
            INNER JOIN table_order AS t ON d.orderID = t.orderID
            GROUP BY DATE_FORMAT(reg_date, '%Y%')
            ORDER BY DATE_FORMAT(reg_date, '%Y-%m-%d') DESC
            ";
            $result = mysqli_query($conn, $sql);
            $resultchart = mysqli_query($conn, $sql);
            //for chart
            $datesave = array();
            $total = array();
            while ($rs1 = mysqli_fetch_array($resultchart)) {
                $datesave[] = "\"" . $rs1['reg_date'] . "\"";
                $total[] = "\"" . $rs1['total'] . "\"";
            }
            $datesave = implode(",", $datesave);
            $total = implode(",", $total);

            ?>
            <h4 align="center">รายงานสั่งซื้อสินค้าประจำปี</h4>

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
                                label: 'รายงานรายได้ แยกตามปี (บาท)',
                                data: [<?php echo $total; ?>],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 256, 1)',
                                    'rgba(255,99,132,1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
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
            <div class="col-sm-4">
                <h3>ตารางรายได้</h3>
                <table class="table table-striped" border="1" cellpadding="0" cellspacing="0" align="center">
                    <thead>
                        <tr class="table-primary">
                            <th width="30%">ปี</th>
                            <th width="70%">
                                <center>รายได้</center>
                            </th>
                        </tr>
                    </thead>

                    <?php

                    while ($row1 = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?php echo $row1['reg_date']; ?></td>
                            <td align="right"><?php echo number_format($row1['total'], 2); ?></td>
                        </tr>
                    <?php
                        @$amount_total += $row1['total'];
                    }
                    ?>
                    <tr class="table-success">
                        <td align="center">รวม</td>
                        <td align="right"><b>
                                <?php echo number_format($amount_total, 2); ?>&nbsp;บาท</b></td>
                        </td>
                    </tr>
                </table>
            </div>
            <?php mysqli_close($conn); ?>
        </div>
    </div>
</div>