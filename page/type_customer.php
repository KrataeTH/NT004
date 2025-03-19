<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/config.php';
require_once '../function/functions.php';

$customerTypes = getCustomerTypes();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Type Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        /* ซ่อนปุ่มค้นหาของ DataTables */
        .dataTables_filter {
            display: none;
        }
        .flex-wrap {
            gap: 0.5rem; /* ระยะห่างระหว่างองค์ประกอบ */
        }
        .border {
            border: 1px solid #e2e8f0; /* สีเส้นขอบ */
        }
        .rounded-md {
            border-radius: 0.375rem; /* มุมโค้ง */
        }
        /* เพิ่มสีพื้นหลังให้หัวตาราง */
        #customerTypeTable thead th {
            background-color: #4a5568; /* สีเทาเข้ม */
            color: white; /* สีตัวอักษรขาว */
        }

        /* ปรับสีพื้นหลังของแถวตาราง */
        #customerTypeTable tbody tr {
            background-color:rgb(255, 255, 255); /* สีขาว */
        }

        /* ปรับสีพื้นหลังของแถวตารางเมื่อโฮเวอร์ */
        #customerTypeTable tbody tr:hover {
            background-color:rgb(198, 198, 198); /* สีเทาอ่อน */
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include './components/navbar.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">ประเภทลูกค้า</h1>
        
        <!-- ปุ่มเพิ่มประเภทลูกค้าและฟิลด์ค้นหา -->
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="flex flex-wrap items-center gap-2">
                <!-- ปุ่มเพิ่มประเภทลูกค้า -->
                <button onclick="openModal('add')" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-plus"></i> เพิ่มประเภทลูกค้า
                </button>
            </div>

            <!-- ฟิลด์ค้นหา -->
            <div class="flex flex-wrap gap-2">
                <div class="relative">
                    <input type="text" id="searchType" placeholder="ค้นหาประเภทลูกค้า..." class="border p-2 rounded-md pl-10">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i> <!-- ไอคอนค้นหา -->
                </div>
                <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-sync-alt"></i> <!-- ไอคอนรีเซ็ต -->
                </button>
            </div>
        </div>

        <!-- ตารางข้อมูลประเภทลูกค้า -->
        <table id="customerTypeTable" class="min-w-full">
            <thead>
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">ประเภทลูกค้า</th>
                    <th class="py-2">จำนวนประเภทลูกค้า</th>
                    <th class="py-2">การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customerTypes as $type): ?>
                    <?php $customerCount = getCustomerCountByType($type['id_customer_type']); ?>
                    <tr>
                        <td class="py-2 text-center"><?= $type['id_customer_type'] ?></td>
                        <td class="py-2 text-center"><?= $type['type_customer'] ?></td>
                        <td class="py-2 text-center">
                            <?= $customerCount ?> คน
                        </td>
                        <td class="py-2 text-center">
                            <button onclick="openModal('edit', <?= $type['id_customer_type'] ?>)" class="bg-yellow-500 text-white px-2 py-1 rounded-md">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if ($customerCount == 0): ?>
                                <button onclick="deleteCustomerType(<?= $type['id_customer_type'] ?>)" class="bg-red-500 text-white px-2 py-1 rounded-md ml-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php else: ?>
                                <button class="bg-gray-400 text-white px-2 py-1 rounded-md ml-2" title="ไม่สามารถลบได้เนื่องจากมีลูกค้าใช้งานอยู่" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include './components/customer_type_modal.php'; ?>

    <!-- jQuery และ DataTables JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script>
    // เรียกใช้ DataTables
    $(document).ready(function() {
        var table = $('#customerTypeTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "ทั้งหมด"]],
            "language": {
                "search": "ค้นหา:",
                "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ แถว",
                "paginate": {
                    "first": "แรก",
                    "last": "สุดท้าย",
                    "next": "ถัดไป",
                    "previous": "ก่อนหน้า"
                }
            }
        });

        // ค้นหาจากประเภทลูกค้า (แสดงผลทันทีเมื่อพิมพ์)
        $('#searchType').on('keyup', function() {
            table.column(1).search(this.value).draw();
        });
    });

    // ฟังก์ชัน reset การค้นหา
    function resetSearch() {
        $('#searchType').val('');
        $('#customerTypeTable').DataTable().search('').columns().search('').draw();
    }

    function deleteCustomerType(id) {
        if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบประเภทลูกค้านี้?')) {
            fetch(`../function/handle_customer_type.php?action=delete&id_customer_type=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + data.message);
                    }
                });
        }
    }
    </script>
</body>
</html>