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
    <?php include 'header1.php'; ?>
    <div class="container">
        <br><br>
        <div class="row">
           
            <?php 
            //ค้นหาสินค้า
            $key_word = @$_GET['keyword'];
            if ($key_word !=""){
                $sql = "SELECT * FROM product WHERE pro_id='$key_word'or
                pro_name like '%$key_word%' or
                detail like '%$key_word%' ORDER BY pro_id";
            }else{
                $sql = "SELECT * FROM product ORDER BY pro_id";
            }

            //คำสั่งเเสดงข้อมูล
            
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $price = $row['price'];
            ?>


                <div class="col-sm-3">
                    <div class="text-center">
                        <img src="<?= $row['image'] ?>" width="200" height="250" class="mt-5 p-2 my-2 border"> <br>
                        ID: <?= $row['pro_id'] ?><br>
                        <h5 class="text-success"><?= $row['pro_name'] ?></h5>
                        ราคา <?= $row['price'] ?> บาท <br>
                        <a class="btn btn-outline-primary" href="sh_product_detail.php?action=show&id=<?= $row['pro_id'] ?>">รายละเอียด </a>
                    </div>
                </div>
                <br>
            <?php
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>

</html>