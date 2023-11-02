<?php include 'condb.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Creating Dynamic Data Graph using PHP and Chart.js</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

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
    <script type="text/javascript" src="chart/js/jquery.min.js"></script>
    <script type="text/javascript" src="chart/js/Chart.min.js"></script>

</head>

<body>
    <?php include 'menu_ad.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4"></h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"></li>
                </ol>
                <div id="chart-container">
                    <canvas id="graphCanvas"></canvas>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                จำนวนคงเหลือ
                            </div>
                            <div class="card-body"><canvas id="graphCanvas" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Bar Chart Example
                            </div>
                            <div class="card-body"><canvas id="graphCanvas" width="100%" height="40"></canvas></div>
                        </div>
                    </div>


                    <script>
                        $(document).ready(function() {
                            showGraph();
                        });


                        function showGraph() {
                            {
                                $.post("data_product.php",
                                    function(data) {
                                        console.log(data);
                                        var name = [];
                                        var marks = [];

                                        for (var i in data) {
                                            name.push(data[i].pro_name);
                                            marks.push(data[i].amount);
                                        }

                                        var chartdata = {
                                            labels: name,
                                            datasets: [{
                                                label: 'จำนวนคงเหลือ',
                                                backgroundColor: '#550000',
                                                borderColor: '#000000',
                                                hoverBackgroundColor: '#CCCCCC',
                                                hoverBorderColor: '#666666',
                                                data: marks
                                            }]
                                        };

                                        var graphTarget = $("#graphCanvas");

                                        var barGraph = new Chart(graphTarget, {
                                            type: 'bar',
                                            data: chartdata
                                        });
                                    });
                            }
                        }
                    </script>
                    <?php include 'footer.php'; ?>
                </div>
            </div>
        </main>
    </div>
</body>

</html>