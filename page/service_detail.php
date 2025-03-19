<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/config.php';
require_once '../function/functions.php';

$id_customer = isset($_POST['id_customer']) ? intval($_POST['id_customer']) : 0;
$id_service = isset($_POST['id_service']) ? intval($_POST['id_service']) : 0;
$id_bill = isset($_POST['id_bill']) ? intval($_POST['id_bill']) : 0;

if ($id_service > 0) {
    // ดึงข้อมูล service
    $sql = "SELECT sc.id_service, sc.code_service, sc.type_service, sc.type_gadget, sc.status_service,
    COALESCE(ROUND(SUM(o.mainpackage_price + o.ict_price), 2), 0) AS total_price
    FROM service_customer sc
    LEFT JOIN package_list pl ON sc.id_service = pl.id_service AND pl.status_package = 'ใช้งาน'
    LEFT JOIN product_list pr ON pl.id_package = pr.id_package AND pr.status_product = 'ใช้งาน'
    LEFT JOIN overide o ON pr.id_product = o.id_product
    WHERE sc.id_service = ?
    GROUP BY  sc.id_service;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_service);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();

    if (!$service) {
        header('Location: service_bill.php');
        exit;
    }

    // ดึงข้อมูล package ที่เกี่ยวข้องกับ service นี้
    $packages = getPackagesByServiceId($id_service);
} else {
    header('Location: service_bill.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* ซ่อนปุ่มค้นหาของ DataTables */
        .dataTables_filter {
            display: none;
        }

        /* เพิ่มสีพื้นหลังให้หัวตาราง */
        .common-table thead th {
            background-color: #4a5568; /* สีเทาเข้ม */
            color: white; /* สีตัวอักษรขาว */
        }

        /* ปรับสีพื้นหลังของแถวตาราง */
        .common-table tbody tr {
            background-color: rgb(255, 255, 255); /* สีขาว */
        }

        /* ปรับสีพื้นหลังของแถวตารางเมื่อโฮเวอร์ */
        .common-table tbody tr:hover {
            background-color: rgb(198, 198, 198); /* สีเทาอ่อน */
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include './components/navbar.php'; ?>
    <?php include './components/service_detail_manual.php'; ?>
    <!-- ปุ่มเปิดคู่มือ -->
    <button id="manualButton" class="fixed right-4 top-20 bg-blue-500 text-white px-3 py-2 rounded-md z-50 flex items-center group transition-all duration-300 w-10 hover:w-24 overflow-hidden">
        <i class="fas fa-question-circle text-xl"></i>
        <span class="ml-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">คู่มือ</span>
    </button>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">รายละเอียดบริการ: <?php echo htmlspecialchars($service['code_service']); ?></h1>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <p><strong>ประเภทบริการ:</strong> <?php echo htmlspecialchars($service['type_service']); ?></p>
            <p><strong>ประเภทอุปกรณ์:</strong> <?php echo htmlspecialchars($service['type_gadget']); ?></p>
            <p><strong>สถานะบริการ:</strong> <?php echo htmlspecialchars($service['status_service']); ?></p>
            <p><strong>ราคาเช่า:</strong> <?php echo htmlspecialchars($service['total_price'] ?? '0'); ?></p>
        </div>

        <!-- ปุ่มเปิด Modal -->
        <div class="mt-6">
            <button type="button" onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                เพิ่ม Package
            </button>   
            <form action="service_bill.php" method="POST" style="display: inline;">
                <input type="hidden" name="id_bill" value="<?php echo $id_bill; ?>">
                <input type="hidden" name="id_customer" value="<?php echo $id_customer; ?>">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                    กลับ
                </button>
            </form>
        </div>

        <!-- ตารางแสดง Package -->
        <div class="mt-6">
            <h2 class="text-xl font-bold mb-4">Package</h2>
            <div class="overflow-x-auto">
                <table id="packageTable" class="common-table min-w-full bg-white rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">ลำดับที่</th>
                            <th class="px-4 py-2">ชื่อ Package</th>
                            <th class="px-4 py-2">ข้อมูล Package</th>
                            <th class="px-4 py-2">สถานะ</th>
                            <th class="px-4 py-2">วันที่เริ่ม</th>
                            <th class="px-4 py-2">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($packages)) : ?>
                            <?php foreach ($packages as $package) : ?>
                                <tr class="border-b">
                                    <td class="px-4 py-2 text-center"></td>
                                    <td class="px-4 py-2 text-center"><?php echo htmlspecialchars($package['name_package']); ?></td>
                                    <td class="px-4 py-2 text-center"><?php echo htmlspecialchars($package['info_package']); ?></td>
                                    <td class="px-4 py-2 text-center"><?php echo htmlspecialchars($package['status_package']); ?></td>
                                    <td class="px-4 py-2 text-center"><?php echo htmlspecialchars($package['create_at']); ?></td>
                                    <td class="px-4 py-2 text-center">
                                        <button onclick="viewProducts(<?php echo $package['id_package']; ?>)" class="bg-green-500 text-white px-2 py-1 rounded-lg hover:bg-green-600">View Products</button>
                                        <button onclick="editPackage(<?php echo $package['id_package']; ?>)" class="bg-blue-500 text-white px-2 py-1 rounded-lg hover:bg-blue-600">Edit</button>
                                        <button onclick="deletePackage(<?php echo $package['id_package']; ?>)" class="bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center">ไม่มีข้อมูล Package</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ตารางแสดง Product (จะแสดงเมื่อเลือก Package) -->
        <div id="productTable" class="mt-6 hidden">
            <h2 class="text-xl font-bold mb-4">Products</h2>
            <div class="overflow-x-auto">
                <table id="productTableInner" class="common-table min-w-full bg-white rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">ชื่อ Product</th>
                            <th class="px-4 py-2">ข้อมูล Product</th>
                            <th class="px-4 py-2">ราคา MainPackage</th>
                            <th class="px-4 py-2">ราคา ICT_solution(ถ้ามี)</th>
                            <th class="px-4 py-2">รวม</th>
                            <th class="px-4 py-2">รายละเอียด</th>
                            <th class="px-4 py-2">วันที่เริ่ม</th>
                        </tr>
                    </thead>
                    <tbody id="productListBody">
                        <!-- Product data will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal สำหรับเพิ่ม Package -->
        <?php include './components/package_modal.php'; ?>
    </div>

    <!-- jQuery และ DataTables JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // ฟังก์ชันสำหรับตั้งค่า DataTables
            function initializeDataTable(tableId) {
                // ตรวจสอบว่ามีตารางอยู่จริง
                const tableElement = $(`#${tableId}`);
                if (!tableElement.length) return;

                // ตรวจสอบว่ามีข้อมูลในตารางหรือไม่
                const hasData = tableElement.find('tbody tr').length > 0 && 
                            !tableElement.find('tbody tr td[colspan]').length;

                const config = {
                    "pageLength": 10,
                    "lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "ทั้งหมด"]],
                    "language": {
                        "search": "ค้นหา:",
                        "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ แถว",
                        "infoEmpty": "ไม่มีข้อมูลที่แสดง",
                        "emptyTable": "ไม่มีข้อมูลในตาราง",
                        "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                        "paginate": {
                            "first": "แรก",
                            "last": "สุดท้าย",
                            "next": "ถัดไป",
                            "previous": "ก่อนหน้า"
                        }
                    },
                    "ordering": hasData, // เปิดการเรียงลำดับเฉพาะเมื่อมีข้อมูล
                    "paging": hasData,   // เปิดการแบ่งหน้าเฉพาะเมื่อมีข้อมูล
                    "info": hasData,     // แสดงข้อมูลเพิ่มเติมเฉพาะเมื่อมีข้อมูล
                    "searching": hasData, // เปิดการค้นหาเฉพาะเมื่อมีข้อมูล
                    "columnDefs": hasData ? [
                        {
                            "targets": 0,
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        }
                    ] : []
                };

                const table = tableElement.DataTable(config);

                // จัดการกรณีไม่มีข้อมูล
                if (!hasData) {
                    tableElement.find('tbody').addClass('empty-table');
                }

                return table;
            }

            // สร้าง instance ของ DataTable สำหรับแต่ละตาราง
            const packageTable = initializeDataTable('packageTable');
            const productTable = initializeDataTable('productTableInner');

            // อัพเดทลำดับเมื่อมีการเปลี่ยนหน้าหรือค้นหา
            if (packageTable) {
                packageTable.on('draw', function() {
                    updateRowNumbers(this);
                });
            }
            if (productTable) {
                productTable.on('draw', function() {
                    updateRowNumbers(this);
                });
            }
        });

        // ฟังก์ชันอัพเดทลำดับแถว
        function updateRowNumbers(table) {
            $(table).find('tbody tr').each(function(index) {
                const firstCell = $(this).find('td:first');
                if (!firstCell.attr('colspan')) {
                    firstCell.text(index + 1);
                }
            });
        }

        const idService = <?php echo $id_service; ?>;
        // ฟังก์ชันเปิด Modal
        function openModal() {
            // เคลียร์ฟอร์ม
            document.getElementById('packageForm').reset();
            document.getElementById('productList').innerHTML = ''; // ล้างข้อมูล Product ที่แสดงอยู่
            document.getElementById('id_package').value = ''; // เคลียร์ค่า id_package

            // เปิด Modal
            document.getElementById('packageModal').classList.remove('hidden');
        }

        // ฟังก์ชันปิด Modal
        function closeModal() {
            document.getElementById('packageModal').classList.add('hidden');
        }

        // ฟังก์ชันแสดง Product ของ Package ที่เลือก
        function viewProducts(id_package) {
            fetch(`../function/get_products.php?id_package=${id_package}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // แปลงเป็น JSON
            })
            .then(data => {
                const productListBody = document.getElementById('productListBody');
                productListBody.innerHTML = ''; // ล้างข้อมูลเก่า

                if (data.length > 0) {
                    data.forEach(product => {
                        const row = `
                            <tr class="border-b">
                                <td class="px-4 py-2 text-center">${product.name_product}</td>
                                <td class="px-4 py-2 text-center">${product.info_product}</td>
                                <td class="px-4 py-2 text-center">${product.mainpackage_price}</td>
                                <td class="px-4 py-2 text-center">${product.ict_price}</td>
                                <td class="px-4 py-2 text-center">${product.all_price}</td> <!-- แสดง all_price ที่คำนวณแล้ว -->
                                <td class="px-4 py-2 text-center">${product.info_overide || '-'}</td> <!-- แสดง info_overide -->
                                <td class="px-4 py-2 text-center">${product.create_at}</td>
                            </tr>
                        `;
                        productListBody.insertAdjacentHTML('beforeend', row);
                    });
                    document.getElementById('productTable').classList.remove('hidden');
                } else {
                    productListBody.innerHTML = '<tr><td colspan="7" class="px-4 py-2 text-center">ไม่มีข้อมูล Product</td></tr>';
                    document.getElementById('productTable').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('เกิดข้อผิดพลาดในการดึงข้อมูล Product');
            });
        }
        // ฟังก์ชันแก้ไข Package
        function editPackage(id_package) {
            fetch(`../function/get_package.php?id_package=${id_package}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    // เคลียร์ฟอร์มก่อนเติมข้อมูล
                    document.getElementById('packageForm').reset();
                    document.getElementById('productList').innerHTML = '';

                    // เติมข้อมูล Package ลงในฟอร์ม
                    document.getElementById('id_package').value = data.id_package;
                    document.getElementById('name_package').value = data.name_package;
                    document.getElementById('info_package').value = data.info_package;
                    document.getElementById('create_at').value = data.create_at;

                    // ดึงข้อมูล Products ของ Package นี้
                    fetch(`../function/get_products.php?id_package=${id_package}`)
                    .then(response => response.json())
                    .then(products => {
                        const productList = document.getElementById('productList');
                        productList.innerHTML = ''; // ล้างข้อมูลเก่า

                        products.forEach(product => {
                            const productField = `
                                <div class="product-field mb-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <input type="text" name="name_product[]" placeholder="ชื่อ Product" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="${product.name_product}" required>
                                        </div>
                                        <div>
                                            <textarea name="info_product[]" placeholder="ข้อมูล Product" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">${product.info_product}</textarea>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mt-2">
                                        <div>
                                            <input type="number" name="mainpackage_price[]" placeholder="ราคา Main Package" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="${product.mainpackage_price}" oninput="calculateAllPrice(this)">
                                        </div>
                                        <div>
                                            <input type="number" name="ict_price[]" placeholder="ราคา ICT Solution" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="${product.ict_price}" oninput="calculateAllPrice(this)">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input type="text" name="info_overide[]" placeholder="ข้อมูลเพิ่มเติม (ไม่จำเป็น)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="${product.info_overide || ''}">
                                    </div>
                                    <button type="button" onclick="removeProductField(this)" class="bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 mt-2">ลบ</button>
                                </div>
                            `;
                            productList.insertAdjacentHTML('beforeend', productField);
                        });
                    });

                    // เปิด Modal
                    document.getElementById('packageModal').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('เกิดข้อผิดพลาดในการดึงข้อมูล Package');
            });
        }

        // ฟังก์ชันลบ Package
        function deletePackage(id_package) {
            if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบ Package นี้?')) {
                fetch(`../function/delete_package.php?id_package=${id_package}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('ลบ Package สำเร็จ');
                        window.location.reload();
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('เกิดข้อผิดพลาดในการลบ Package');
                });
            }
        }
        // ฟังก์ชันเปิด modal สำหรับคู่มือ
        function openManual() {
            document.getElementById('manualModal').classList.remove('hidden');
            currentPage = 0;
            showPage(currentPage);
        }

        // ฟังก์ชันปิด modal สำหรับคู่มือ
        function closeModalA() {
            document.getElementById('manualModal').classList.add('hidden');
        }

        // ฟังก์ชันแสดงหน้าที่เลือกในคู่มือ
        let currentPage = 0;

        function showPage(page) {
            const pages = document.querySelectorAll('.manual-page');
            pages.forEach((pageElem, index) => {
                pageElem.classList.add('hidden'); // ซ่อนทุกหน้า
                if (index === page) {
                    pageElem.classList.remove('hidden'); // แสดงหน้า
                }
            });
            // อัปเดตเลขหน้า
            document.getElementById('pageNumber').textContent = `${page + 1} / ${pages.length}`;
        }

        // ฟังก์ชันสำหรับหน้าถัดไป
        function nextPage() {
            const pages = document.querySelectorAll('.manual-page');
            if (currentPage < pages.length - 1) {
                currentPage++;
                showPage(currentPage);
            }
        }

        // ฟังก์ชันสำหรับหน้าก่อนหน้า
        function prevPage() {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        }

        // เพิ่มการเปิด modal คู่มือเมื่อคลิกปุ่ม
        document.getElementById('manualButton').addEventListener('click', openManual);
    </script>
</body>
</html>