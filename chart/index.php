<!DOCTYPE html>
<html>
<head>
<title>Creating Dynamic Data Graph using PHP and Chart.js</title>
<style type="text/css">
BODY {
    width: 550PX;
}

#chart-container {
    width: 100%;
    height: auto;
}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>


</head>
<body>
    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>
                    var ctx = document.getElementById('myChart').getContext('2d');

                    // Extract data from PHP and format it for the chart
                    // สร้างตัวแปรเพื่อเก็บข้อมูลวันที่และรายได้
                    var orderDates = [];
                    var revenues = [];

                    <?php
                    $sql_cart = "SELECT Orer_date,SUM(orders.Quantity_order) as qty,SUM(orders.Price_order) as price
                    FROM orders,book
                    WHERE DATE_FORMAT(orders.Orer_date, '%Y-%m') = '$date'
                    AND book.Book_id = orders.Book_id
                    AND orders.Status_id != 0
                    GROUP BY Orer_date
                        ORDER BY Orer_date DESC";
                    $result_cart = mysqli_query($conn, $sql_cart);

                    while ($row_chart = mysqli_fetch_array($result_cart)) {
                        echo "orderDates.push('" . $row_chart['Orer_date'] . "');\n"; // ใช้ DATE_FORMAT ใน SQL เพื่อจัดรูปแบบวันที่ในรูปแบบเดือน
                        echo "revenues.push(" . $row_chart['price'] . ");\n";
                    }
                    ?>
                    var ctx = document.getElementById('myChart').getContext('2d');

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: orderDates, // วันที่แนวนอน
                            datasets: [{
                                label: 'ยอดขาย (บาท)',
                                data: revenues, // รายได้แนวตั้ง
                                backgroundColor: 'rgb(159, 111, 156)',
                                // borderColor: 'rgba(75, 192, 192, 1)',
                                // borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'วันที่'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'ยอดขาย (บาท)'
                                    }
                                }
                            }
                        }
                    });
                    var ctx2 = document.getElementById('myChart2').getContext('2d');

                    // Extract data from PHP and format it for the chart
                    var orderDates2 = [];
                    var totalQuantities = [];

                    <?php
                    $sql_cart2 = "SELECT Orer_date,SUM(orders.Quantity_order) as qty
                    FROM orders,book
                    WHERE DATE_FORMAT(orders.Orer_date, '%Y-%m') = '$date'
                    AND book.Book_id =orders.Book_id
                    AND orders.Status_id != 0
                    GROUP BY Orer_date
                    ORDER BY Orer_date DESC";
                    $result_cart2 = mysqli_query($conn, $sql_cart2);

                    while ($row_chart2 = mysqli_fetch_array($result_cart2)) {
                        echo "orderDates2.push('" . $row_chart2['Orer_date'] . "');\n";
                        echo "totalQuantities.push(" . $row_chart2['qty'] . ");\n";
                    }
                    ?>

                    var ctx2 = document.getElementById('myChart2').getContext('2d');

                    var myChart2 = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: orderDates2, // วันที่แนวนอน
                            datasets: [{
                                label: 'ยอดขายหนังสือ (เล่ม)',
                                data: totalQuantities, // จำนวนสั่งซื้อแนวตั้ง
                                backgroundColor: 'rgb(255, 159, 64)',
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'วันที่'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'ยอดขายหนังสือ (เล่ม)'
                                    }
                                }
                            }
                        }
                    });
                </script> 

</body>
</html>