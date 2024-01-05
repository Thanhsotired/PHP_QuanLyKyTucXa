<?php include './layout/header.php' ; 
// include_once '../handle/checkAccount.php'?>
<div class="row">
    <div class="col-lg-3 bg-menu">
        <?php include './layout/menu.php' ?>
    </div>
    <div class="col-lg-9 sdp tp" style="min-height: 1000px;">
        <div class="box">
            <div class="name">
                <i class="bi bi-building-add"></i>Danh sách thẻ

            </div>
            <div class="ttp">
                <div class="fs-15 fw-500">Tình trạng phòng:</div>
                <nav class="navbar navbar-light ">
                    <form class="container-fluid justify-content-start pd-0">
                        <a href="#" class="mgr-10"><button class="btn me-2" type="button">Tất cả</button></a>
                        <a href="#"><button class="btn me-2" type="button"><img src="../../public/image/icon/audience.png" alt="" class="img-icon">Đang ở</button></a>
                        <a href="#"><button class="btn me-2" type="button"><img src="../../public/image/icon/null.png" alt="" class="img-icon">Phòng trống</button></a>
                    </form>
                </nav>
            </div>
            <div class="table-sv">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Chủ Xe</th>
                            <th scope="col">Biển số xe</th>
                            <th scope="col">Loại xe</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $sql = "SELECT thexe.id, sinhvien.hoTen, bienSo, tenXe, tinhTrang.tinhTrang, tinhtrang.id as idtt FROM `thexe` JOIN sinhvien ON sinhvien.id = thexe.chuXe JOIN tinhtrang ON tinhtrang.id = thexe.tinhTrang;";
                        $result = query_no_input($sql);
                        if ($result->num_rows == 0) {
                            echo '<div class="bi-text-center">Không có thông tin</div>';
                        } else {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row["id"] ?></td>
                                    <td>
                                        <?php echo $row["hoTen"] ?>
                                    </td>
                                    <td><?php echo $row["bienSo"] ?></td>
                                    <td><?php echo $row["tenXe"] ?></td>
                                   
                                    <td><?php
                                        $class = null;
                                        switch ($row['idtt']) {
                                            case 11:
                                                $class = "bgr-no-ok";
                                                break;
                                            case 15:
                                                $class = "bgr-ok";
                                                break;
                                            case 14:
                                                $class = "bgr-error";
                                                break;
                                            default:
                                                $class = "bgr-wait";
                                                break;
                                        }
                                        ?>
                                        <div class="btn-tt <?php echo $class; ?>">
                                            <?php echo $row['tinhTrang'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="thongtinthe.php?id=<?php echo $row['id']?>"><div class="btn-tt d-inline-block bgr-info">Xem</div></a>
                                        <?php 
                                        if($row["idtt"] == 14 ){
                                            ?>
                                            <a href="../handle/mothe.php?id=<?php echo $row ['id']?>"><div class="btn-tt d-inline-block bgr-ok">Mở khoá</div></a>
                                            <?php

                                        }else{
                                            ?>
                                            <a href="../handle/khoathe.php?id=<?php echo $row ['id']?>"><div class="btn-tt d-inline-block bgr-error">Khoá thẻ</div></a>
                                            <?php
                                        }
                                        ?>
                                        
                                        
                                    </td>

                                </tr>
                        <?php

                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include './layout/footer.php' ?>