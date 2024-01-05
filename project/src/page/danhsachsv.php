<?php include_once './layout/header.php' ?>
<?php include_once '../handle/checkAccount.php' ?>

<link rel="stylesheet" href="../../public/css/bootstrap.min.css">
<div class="row">
    <div class="col-lg-3 bg-menu">
        <?php include_once './layout/menu.php' ?>
    </div>
    <div class="col-lg-9 sdp tp" style="min-height: 1000px;">
        <div class="box">
            <div class="name">
                <i class="bi bi-people-fill"></i>Sinh viên
            </div>
            <div class="find">
                <div class="find-tang">
                    <div class="fs-15 fw-500">Tầng:</div>
                    <select class="form-select " aria-label="Default select example" id="fillter_t">
                        <option value="0">Tất cả</option>
                        <option value="1">Tầng 1</option>
                        <option value="2">Tầng 2</option>
                        <option value="3">Tầng 3</option>
                    </select>
                </div>
                <div class="ttp">
                    <div class="fs-15 fw-500">Tình trạng phòng:</div>
                    <nav class="navbar navbar-light">
                        <form action="" method="get" class="container-fluid justify-content-start pd-0"
                            id="form_fillter">
                            <a href="./danhsachsv.php?tt=0" class="mgr-10"><button class="btn me-2" type="button"
                                    id="tatca">Tất cả</button></a>
                            <a href="./danhsachsv.php?tt=2"><button class="btn me-2" type="button" id="dango"><img
                                        src="../../public/image/icon/audience.png" alt="" class="img-icon">Đang
                                    ở</button></a>
                            <a href="./danhsachsv.php?tt=1"><button class="btn me-2" type="button" id="daroidi"><img
                                        src="../../public/image/icon/null.png" alt="" class="img-icon">Đã rời
                                    đi</button></a>
                            <input type="text" class="btn me-2" placeholder="Tìm mã sinh viên" id="find_MP">
                            <input type="text" class="btn me-2" placeholder="Tên cột" id="find_column" value="#">
                        </form>
                    </nav>

                </div>
            </div>
            <div class="table-sv">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Phòng</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Ngày sinh</th>
                            <th scope="col">Ngày vào</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once '../handle/helper.php';
                        $result = null;
                        $page = 1;
                        $tt = "sinhvien.tinhTrang";
                        if (checkRequest($_GET, ["page"])) {
                            $page = $_GET["page"] * 1;
                        }
                        if (checkRequest($_GET, ["tt"], true)) {
                            switch ($_GET["tt"]) {
                                case "2":
                                    $tt = 2;
                                    break;
                                case "1":
                                    $tt = 1;
                                    break;
                            }
                        } else {

                        }
                        $sql = "SELECT sinhvien.id, anh, hoTen, maPhong, namSinh, ngayVao, tinhTrang.id as idtt, tinhTrang.tinhTrang FROM sinhvien JOIN tinhTrang on tinhTrang.id = sinhvien.tinhTrang where sinhvien.tinhtrang = $tt LIMIT ?,?";
                        $result = query_input($sql, [0, $page * 9]);
                        if ($result->num_rows == 0) {
                            echo '<div class="bi-text-center">Không có thông tin</div>';
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td scope="row" style="font-weight: bold;">
                                        <?php echo $row['id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['maPhong'] ?>
                                    </td>
                                    <td><img src="../../public/image/uploads/<?php echo $row['anh'] ?>.png "
                                            class="mini_img"></img>
                                        <?php echo $row['hoTen'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['namSinh'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['ngayVao'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        $class = null;
                                        switch ($row['idtt']) {
                                            case 1:
                                                $class = "bgr-no-ok";
                                                break;
                                            case 2:
                                                $class = "bgr-ok";
                                                break;
                                            case 3:
                                                $class = "bgr-info";
                                                break;
                                            case 4:
                                                $class = "bgr-wait";
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
                                        <a href="./thongtinsv.php?idsv=<?php echo $row['id'] ?>&action=show  " class="show">
                                            <div class="btn-tt d-inline-block bgr-ok">Xem</div>
                                        </a>
                                        <a href="#" class="show">
                                            <div class="btn-tt d-inline-block bgr-error">Xoá</div>
                                        </a>
                                    </td>

                                </tr>
                                <?php

                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="...">
                <ul class="pagination pagination-sm">
                    <?php
                    $sql = "SELECT CEILING(count(*)/9) as page FROM sinhvien";
                    $result = query_no_input($sql);
                    while ($row = $result->fetch_assoc()) {
                        $page = 1;
                        if (checkRequest($_GET, ["page"])) {
                            if (ceil($_GET["page"]) <= $row["page"]) {
                                $page = $_GET["page"];
                            }
                        }
                        for ($i = 1; $i <= $row["page"]; $i++) {
                            if ($i == $page) {
                                ?>
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link"><?php echo $i ?></span>
                                </li>
                                <?php
                            } else {
                                if(count($_GET) > 0) {
                                    ?> 
                                    <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['REQUEST_URI']."&page=$i"?>"><?php echo $i ?></a></li>
                                    <?php 
                                }else {
                                    ?> 
                                    <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['REQUEST_URI']."?page=$i"?>"><?php echo $i ?></a></li>
                                    <?php 
                                }
                                ?>
                                
                                <?php
                            }
                            ?>


                            <?php

                        }
                    }

                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include_once './layout/footer.php' ?>

<script>
    $(document).ready(function () {
        // lọc ô input
        $("#find_MP").on("change", () => {
            findTable($(".table")[0], $("#find_MP").val(), $("#find_column").val())
        })

        // // lọc button
        // let a = $("#fillter");
        // console.log(a);
        // $(form_fillter).find("button").each((index, element)=> {
        //     $(element).click(() => {
        //         switch($(element).attr("id")) {
        //             case "dango":
        //                 $(a).attr("href", "./danhsachsv.php?tt=2");
        //                 break;
        //             case "daroidi":
        //                 $(a).attr("href", "./danhsachsv.php?tt=1");
        //                 break;
        //             default:
        //                 $(a).attr("href", "./danhsachsv.php?tt=0");

        //         }
        //         $(form_fillter).submit();
        //     })
        // })


        // lọc select tầng
    })
    function findTable(table, value, column) {
        var index = findIndex(table, column);
        numColumn = $(table).find("thead").find("th").length;
        if (index) {
            index = index - 1;
            let tr = Array.from($(table).find("tbody").find("tr"));
            // nếu ô tìm kiếm rỗng hoặc bằng 0
            if (value == "" || value == 0) {
                for (let i = 0; i < tr.length; i++) {
                    // mở ẩn
                    $(tr[i]).removeClass("d-none");
                }
            } else {
                // lặp qua từng tr
                for (let i = 0; i < tr.length; i++) {
                    // mở ẩn
                    $(tr[i]).removeClass("d-none");
                    // lấy td của từng tr
                    let td = $(tr[i]).find("td");
                    // nếu khác với ô tìm kiếm thì ẩn
                    if ($(td[index]).text().trim().toUpperCase() != value.trim().toUpperCase()) {
                        $(tr[i]).addClass("d-none");
                    }
                }
            }
        } else {
            console.log("Không tìm thấy cột");
        }
    }

    // trả về index trong của thẻ th + 1 || không tìm thấy trả về 0
    function findIndex(table, column) {
        let columnIndex = 0;
        $(table).find("thead").find("th").each((index, element) => {
            if ($(element).text().trim().toUpperCase() == column.toUpperCase()) {
                columnIndex = index + 1;
            }
        });
        return columnIndex;
    }
</script>