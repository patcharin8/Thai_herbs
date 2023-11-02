<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            $sql = "
            SELECT d.pro_id,t.orderID, SUM(total_price) AS total, DATE_FORMAT(reg_date, '%M-%Y') AS reg_date
            FROM order_detail AS d
            INNER JOIN table_order AS t ON d.orderID = t.orderID
            GROUP BY DATE_FORMAT(reg_date, '%M-%Y')
            ORDER BY DATE_FORMAT(reg_date, '%Y-%M-%D') DESC
            ";
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
            <h4 align="center">รายงานสั่งซื้อสินค้าประจำเดือน</h4>

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
                                label: 'รายงานรายได้ แยกตามเดือน (บาท)',
                                data: [<?php echo $total; ?>],
                                backgroundColor: [
                                    'rgba(75, 192, 19, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(75, 192, 100, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(255,99,132,1)',
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

            <div class="col-sm-7">
                <h3>ตารางรายได้</h3>
                <table class="table table-striped" border="1" cellpadding="0" cellspacing="0" align="center">
                    <thead>
                        <tr class="table-primary">
                            <th width="30%">เดือน</th>
                            <th width="70%">
                                <center>รายได้</center>
                            </th>
                        </tr>
                    </thead>

                    <?php
                    while ($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td> <?php echo $row['reg_date']; ?></td>
                            <td align="right"><?php echo number_format($row['total'], 2); ?> </td>
                        </tr>
                    <?php
                        @$amount_total += $row['total'];
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