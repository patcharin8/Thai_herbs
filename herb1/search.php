<?php include 'condb.php'; 

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale-scale=1.0" />
    <title>Thai Herbs</title>
    <!-- Site Metas -->
    <link href="bootstrsp/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

</head>

<body>
<!-- <form action="index.php" method="GET">
            <input type="search" name="search" placeholder="ค้นหาสินค้า" class="search">
            <button type="submit"><i class="bi bi-search"></i></button>
        </form> -->
        <?php
        if (isset($_GET['search'])) {
            $searchKeyword = $_GET['search'];
            $sql_search = "SELECT *
                           FROM product, type, detail, pro_name
                           WHERE type.type_id = detail.type_name 
                           AND product.pro_id = detail.pro_id
                           AND product.pro_id = detail.pro_id 
                           AND product.pro_id = type.pro_id
                           AND (product.pro_name LIKE '%$searchKeyword%' OR detail.pro_name 
                           LIKE '%$searchKeyword%' OR type.type_name 
                           LIKE '%$searchKeyword%'OR product.pro_name 
                           LIKE '%$searchKeyword%' )";

                $result_search = mysqli_query($conn, $sql_search); ?>
                <div class="row">
                    <div><label for="" class="f2">ผลการค้นหา &nbsp;'<?= $searchKeyword ?>' </label></div>
                </div>
                <?php if (mysqli_num_rows($result_search) > 0) {
                    foreach ($result_search as $row) :
                        $id = $row['pro_id'];
                        $sql_avg = "SELECT ROUND(AVG(order_detail.Point_book), 1) AS avgpoint,COUNT(orders.Point_book) AS count
                            FROM orderID
                            JOIN book ON book.pro_id = orderID.pro_id
                            WHERE book.pro_id = '$id'
                            AND orderID.Review_book IS NOT NULL
                            AND orderID.Point_book IS NOT NULL";
                        $result_avg = mysqli_query($conn, $sql_avg);
                        $row_avg = mysqli_fetch_array($result_avg);
                        $avgpoint = $row_avg['avgpoint'] ?? 0;
                ?>

                        <div class="col-sm-3" style="margin-left: 40px; margin-top:30px;">

                            <div style="text-align: center;"><img src="../images/image/<?= $row['image'] ?>" width="170px" height="250px" class="image"></div><br>
                            <div class="bookname"><b><label class="fontinfo1"><?= $row['pro_name'] ?></label></b></div>
                            <div><label class="fontinfo" style="font-size: 13px;">โดย <?= $row['pro_name'] ?></label></div>
                            <div class="rating">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $row_avg['avgpoint']) { ?>
                                        <i class="fas fa-star" style="color: #FFD700; font-size: 15px;"></i>
                                    <?php } else { ?>
                                        <i class="fas fa-star" style="color: #ccc; font-size: 15px;"></i>
                                <?php   }
                                } ?>
                                <b><label for=""><?= $avgpoint ?></label></b>
                            </div>
                            <div><b><label class="fontinfo1"><?= $row['Price'] ?> บาท </label></b></div>
                            <?php if ($row['Quantity'] > 0) { ?>
                                    <div class="buttonview"><a href="viewbook.php?id=<?= $row['pro_id'] ?>"><button class="viewproduct">ดูสินค้า</button></a></div>
                                <?php } else { ?>
                                    <div class="buttonview"><a href="viewbook.php?id=<?= $row['pro_id'] ?>"><button class="viewproduct2" disabled>สินค้าหมด</button></a></div>
                                <?php }
                                ?>
                        </div>
                <?php
                    endforeach;
                } else {
                    echo "ไม่พบสินค้าที่ค้นหา";
                }
            }
                ?>
</body>
</html>