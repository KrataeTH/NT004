<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/config.php';
require_once '../function/functions.php';

$id_bill = isset($_POST['id_bill']) ? intval($_POST['id_bill']) : 0;
$id_customer = isset($_POST['id_customer']) ? intval($_POST['id_customer']) : 0;

if ($id_bill > 0  ) {
    // ดึงข้อมูลบิล
    $sql = "SELECT * FROM bill_customer WHERE id_bill = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bill);
    $stmt->execute();
    $result = $stmt->get_result();
    $bill = $result->fetch_assoc();

    // ดึงข้อมูลบริการที่เกี่ยวข้องกับบิล
    $sql = "SELECT * FROM service_customer WHERE id_bill = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bill);
    $stmt->execute();
    $services = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // ดึงข้อมูล gedget
    $sql = "SELECT * FROM gedget WHERE id_bill = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bill);
    $stmt->execute();
    $gedgets = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT * FROM service_customer WHERE id_bill = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bill);
    $stmt->execute();
    $services = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // ดึงข้อมูล gedget
    $sql = "SELECT * FROM gedget WHERE id_bill = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bill);
    $stmt->execute();
    $gedgets = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // ดึงข้อมูลบริการที่เกี่ยวข้องกับบิล
    $sql = "SELECT sc.id_service, sc.code_service, sc.type_service, sc.type_gadget, sc.status_service,
        COALESCE(ROUND(SUM(o.mainpackage_price + o.ict_price), 2), 0) AS total_price
    FROM service_customer sc
    LEFT JOIN package_list pl ON sc.id_service = pl.id_service AND pl.status_package = 'ใช้งาน'
    LEFT JOIN product_list pr ON pl.id_package = pr.id_package AND pr.status_product = 'ใช้งาน'
    LEFT JOIN overide o ON pr.id_product = o.id_product
    WHERE sc.id_bill = ?
    GROUP BY sc.id_service";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bill);
    $stmt->execute();
    $services = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    header('Location: bill.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Bill</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .dataTables_filter {
            display: none;
        }
        .common-table thead th {
            background-color: #4a5568;
            color: white;
        }
        .common-table tbody tr {
            background-color: rgb(255, 255, 255);
        }
        .common-table tbody tr:hover {
            background-color: rgb(198, 198, 198);
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include './components/navbar.php'; ?>
    <?php include './components/service_bill_manual.php'; ?>
    <!-- ปุ่มเปิดคู่มือ -->
    <button id="manualButton" class="fixed right-4 top-20 bg-blue-500 text-white px-3 py-2 rounded-md z-50 flex items-center group transition-all duration-300 w-10 hover:w-24 overflow-hidden">
        <i class="fas fa-question-circle text-xl"></i>
        <span class="ml-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">คู่มือ</span>
    </button>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">ข้อมูลบริการสำหรับบิล: <?php echo htmlspecialchars($bill['number_bill']); ?></h1>
        <div class="mt-6">
            <h2 class="text-xl font-bold mb-4">ข้อมูลหมายเลขบริการบิลนี้</h2>
                <div class="flex justify-between items-center mb-4">
                    <!-- ปุ่มเพิ่มบริการ -->
                     <div>
                        <button onclick="openModal('service')" class="bg-blue-500 text-white px-4 py-2 rounded-md">เพิ่มบริการ</button>
                        <form action="bill.php"  method="POST" style="display: inline;">
                            <input type="hidden" name="id_customer" value="<?php echo $id_customer; ?>">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">กลับ</button>
                        </form>
                     </div>

                    <!-- ตัวค้นหาและตัวกรอง -->
                    <div class="flex items-center">
                        <div class="relative">
                            <input type="text" id="serviceSearch" placeholder="ค้นหาจากรหัสบริการ" class="border p-2 rounded-md pl-10 mr-2">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i> <!-- ไอคอนค้นหา -->
                        </div>
                        <select id="serviceTypeFilter" class="p-2 border rounded-md mr-2">
                            <option value="">ทั้งหมด (ประเภทบริการ)</option>
                            <option value="Fttx">Fttx</option>
                            <option value="Fttx+ICT solution">Fttx+ICT solution</option>
                            <option value="Fttx 2+ICT solution">Fttx 2+ICT solution</option>
                            <option value="SI service">SI service</option>
                            <option value="วงจเช่า">วงจเช่า</option>
                            <option value="IP phone">IP phone</option>
                            <option value="Smart City">Smart City</option>
                            <option value="WiFi">WiFi</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                        <select id="serviceGadgetFilter" class="p-2 border rounded-md mr-2">
                            <option value="">ทั้งหมด (ประเภทอุปกรณ์)</option>
                            <option value="เช่า">เช่า</option>
                            <option value="ขาย">ขาย</option>
                            <option value="เช่าและขาย">เช่าและขาย</option>
                        </select>
                        <select id="serviceStatusFilter" class="p-2 border rounded-md mr-2">
                            <option value="">ทั้งหมด (สถานะบริการ)</option>
                            <option value="ใช้งาน">ใช้งาน</option>
                            <option value="ยกเลิก">ยกเลิก</option>
                        </select>
                        <button onclick="resetServiceFilters()" class="bg-gray-500 text-white px-4 py-2 rounded-md"> <i class="fas fa-sync-alt"></i></button>
                    </div>
                </div>
            <table id="serviceTable" class="common-table min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ลำดับที่</th>
                        <th class="py-2 px-4 border-b">รหัสบริการ</th>
                        <th class="py-2 px-4 border-b">ประเภทบริการ</th>
                        <th class="py-2 px-4 border-b">ประเภทอุปกรณ์</th>
                        <th class="py-2 px-4 border-b">สถานะบริการ</th>
                        <th class="py-2 px-4 border-b">ราคา</th>
                        <th class="py-2 px-4 border-b">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td class="py-2 px-4 border-b text-center"></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($service['code_service']); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($service['type_service']); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($service['type_gadget']); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($service['status_service']); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($service['total_price'] ?? '0'); ?></td> <!-- แสดงราคา -->
                                <td class="py-2 px-4 border-b text-center">
                                    <button onclick="openModal('service', <?php echo $service['id_service']; ?>)" class="bg-yellow-500 text-white px-2 py-1 rounded"> <i class="fas fa-edit"></i></button>
                                    <button onclick="deleteItem('service', <?php echo $service['id_service']; ?>)" class="bg-red-500 text-white px-2 py-1 rounded"><i class="fas fa-trash"></i></button>
                                    <form action="service_detail.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="id_customer" value="<?php echo $id_customer; ?>">
                                        <input type="hidden" name="id_service" value="<?php echo $service['id_service']; ?>">
                                        <input type="hidden" name="id_bill" value="<?php echo $bill['id_bill']; ?>"> <!-- เพิ่มส่วนนี้ -->
                                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded-md"> 
                                            <i class="fas fa-info-circle"></i> Info
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-2 px-4 border-b text-center">ไม่มีข้อมูลบริการ</td> <!-- ปรับ colspan เป็น 7 -->
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold mb-4">ข้อมูลอุปกรณ์ของบิลนี้</h2>
                <div class="flex justify-between items-center mb-4">
                    <button onclick="openModal('gedget')" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">เพิ่มอุปกรณ์</button>
                    <div class="flex justify-between items-center mb-4">
                        <div class="relative">
                            <input type="text" id="gedgetSearch" placeholder="ค้นหาจากชื่ออุปกรณ์" class="border p-2 rounded-md pl-10 mr-2">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i> <!-- ไอคอนค้นหา -->
                        </div>
                        <button onclick="resetGedgetFilters()" class="bg-gray-500 text-white px-4 py-2 rounded-md"> <i class="fas fa-sync-alt"></i></button>
                    </div>
                </div>
            <table id="gedgetTable" class="common-table min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ลำดับที่</th>
                        <th class="py-2 px-4 border-b">ชื่อ Gedget</th>
                        <th class="py-2 px-4 border-b">วันที่เริ่มใช้อุปกรณ์</th>
                        <th class="py-2 px-4 border-b">สถานะอุปกรณ์</th>
                        <th class="py-2 px-4 border-b">หมายเหตุ</th>
                        <th class="py-2 px-4 border-b">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($gedgets)): ?>
                        <?php foreach ($gedgets as $gedget): ?>
                            <tr>
                                <td class="py-2 px-4 border-b text-center"><?php echo $gedget['id_gedget']; ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($gedget['name_gedget']); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($gedget['create_at']); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($gedget['status_gedget']); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo $gedget['note'] !== null ? htmlspecialchars($gedget['note']) : '-'; ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button onclick="openModal('gedget', <?php echo $gedget['id_gedget']; ?>)" class="bg-yellow-500 text-white px-2 py-1 rounded"> <i class="fas fa-edit"></i></button>
                                    <button onclick="deleteItem('gedget', <?php echo $gedget['id_gedget']; ?>)" class="bg-red-500 text-white px-2 py-1 rounded"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-2 px-4 border-b text-center">ไม่มีข้อมูล Gedget</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <button onclick="openModal('group')" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">สร้างกลุ่ม</button>
            <h2 class="text-xl font-bold mb-4">ข้อมูลกลุ่ม</h2>
            <table id="groupTable" class="common-table min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ลำดับที่</th>
                        <th class="py-2 px-4 border-b">ชื่อกลุ่ม</th>
                        <th class="py-2 px-4 border-b">บริการ</th>
                        <th class="py-2 px-4 border-b">อุปกรณ์</th>
                        <th class="py-2 px-4 border-b">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM group_service WHERE id_bill = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_bill);
                    $stmt->execute();
                    $groups = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                    if (!empty($groups)): ?>
                        <?php foreach ($groups as $group): ?>
                            <?php
                            $sql = "SELECT * FROM group_servicedetail WHERE id_group = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $group['id_group']);
                            $stmt->execute();
                            $groupDetails = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                            $servicesInGroup = [];
                            $gedgetsInGroup = [];

                            foreach ($groupDetails as $detail) {
                                if ($detail['id_service']) {
                                    $sql = "SELECT * FROM service_customer WHERE id_service = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $detail['id_service']);
                                    $stmt->execute();
                                    $service = $stmt->get_result()->fetch_assoc();
                                    if ($service) {
                                        $servicesInGroup[] = $service['code_service'];
                                    }
                                }
                                if ($detail['id_gedget']) {
                                    $sql = "SELECT * FROM gedget WHERE id_gedget = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $detail['id_gedget']);
                                    $stmt->execute();
                                    $gedget = $stmt->get_result()->fetch_assoc();
                                    if ($gedget) {
                                        $gedgetsInGroup[] = $gedget['name_gedget'];
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td class="py-2 px-4 border-b text-center"><?php echo $group['id_group']; ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($group['group_name']); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo implode(', ', $servicesInGroup); ?></td>
                                <td class="py-2 px-4 border-b text-center"><?php echo implode(', ', $gedgetsInGroup); ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button onclick="openModal('group', <?php echo $group['id_group']; ?>)" class="bg-yellow-500 text-white px-2 py-1 rounded"> <i class="fas fa-edit"></i></button>
                                    <button onclick="deleteItem('group', <?php echo $group['id_group']; ?>)" class="bg-red-500 text-white px-2 py-1 rounded"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-2 px-4 border-b text-center">ไม่มีข้อมูลกลุ่ม</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include './components/service_modal.php'; ?>
    <?php include './components/gedget_modal.php'; ?>
    <?php include './components/group_modal.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            function initializeDataTable(tableId) {
                const tableElement = $(`#${tableId}`);
                if (!tableElement.length) return;

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
                    "ordering": hasData,
                    "paging": hasData,
                    "info": hasData,
                    "searching": hasData,
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

                if (!hasData) {
                    tableElement.find('tbody').addClass('empty-table');
                }

                return table;
            }

            const serviceTable = initializeDataTable('serviceTable');
            const gedgetTable = initializeDataTable('gedgetTable');
            const groupTable = initializeDataTable('groupTable');

            if (serviceTable) {
                serviceTable.on('draw', function() {
                    updateRowNumbers(this);
                });
            }
            if (gedgetTable) {
                gedgetTable.on('draw', function() {
                    updateRowNumbers(this);
                });
            }
            if (groupTable) {
                groupTable.on('draw', function() {
                    updateRowNumbers(this);
                });
            }
        });

        $(document).ready(function() {
            // ฟังก์ชันสำหรับการค้นหาและกรองข้อมูล service
            $('#serviceSearch, #serviceTypeFilter, #serviceGadgetFilter, #serviceStatusFilter').on('input change', function() {
                const searchText = $('#serviceSearch').val().toLowerCase();
                const typeFilter = $('#serviceTypeFilter').val();
                const gadgetFilter = $('#serviceGadgetFilter').val();
                const statusFilter = $('#serviceStatusFilter').val();

                $('#serviceTable tbody tr').each(function() {
                    const codeService = $(this).find('td:eq(1)').text().toLowerCase();
                    const typeService = $(this).find('td:eq(2)').text();
                    const typeGadget = $(this).find('td:eq(3)').text();
                    const statusService = $(this).find('td:eq(4)').text();

                    const matchSearch = codeService.includes(searchText);
                    const matchType = typeFilter === '' || typeService === typeFilter;
                    const matchGadget = gadgetFilter === '' || typeGadget === gadgetFilter;
                    const matchStatus = statusFilter === '' || statusService === statusFilter;

                    if (matchSearch && matchType && matchGadget && matchStatus) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // ฟังก์ชันสำหรับการค้นหาและกรองข้อมูล gedget
            $('#gedgetSearch').on('input', function() {
                const searchText = $(this).val().toLowerCase();

                $('#gedgetTable tbody tr').each(function() {
                    const nameGedget = $(this).find('td:eq(1)').text().toLowerCase();

                    if (nameGedget.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        function updateRowNumbers(table) {
            $(table).find('tbody tr').each(function(index) {
                const firstCell = $(this).find('td:first');
                if (!firstCell.attr('colspan')) {
                    firstCell.text(index + 1);
                }
            });
        }

         // ฟังก์ชันรีเซ็ตตัวกรองสำหรับ service
        function resetServiceFilters() {
            // รีเซ็ตค่าช่องค้นหาและตัวกรอง
            $('#serviceSearch').val('');
            $('#serviceTypeFilter').val('');
            $('#serviceGadgetFilter').val('');
            $('#serviceStatusFilter').val('');

            // แสดงข้อมูลทั้งหมดในตาราง service
            $('#serviceTable tbody tr').show();
        }

        // ฟังก์ชันรีเซ็ตตัวกรองสำหรับ gedget
        function resetGedgetFilters() {
            // รีเซ็ตค่าช่องค้นหา
            $('#gedgetSearch').val('');

            // แสดงข้อมูลทั้งหมดในตาราง gedget
            $('#gedgetTable tbody tr').show();
        }

        function openModal(type, id = null) {
            const modalTitle = document.getElementById('modalTitle');
            const modalForm = document.getElementById(`${type}Form`);
            const modalElement = document.getElementById(`${type}Modal`);
            const quantityField = document.getElementById('quantityField');
            const createDateField = document.getElementById('createDateField');
            const statusField = document.getElementById('statusField');
            const quantityGedgetInput = document.getElementById('quantity_gedget');

            if (id) {
                if (createDateField) {
                    createDateField.style.display = 'none'; // ซ่อนฟิลด์วันที่สร้างในโหมดแก้ไข
                }
                if (quantityField) {
                    quantityField.style.display = 'none';
                }
                if (createDateField) {
                    createDateField.style.display = 'none';
                }
                if (statusField) {
                    statusField.classList.remove('hidden');
                }
                if (quantityGedgetInput) {
                    quantityGedgetInput.removeAttribute('required');
                }
                fetch(`../function/get_${type}.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        modalTitle.innerText = `แก้ไข ${type === 'service' ? 'บริการ' : type === 'gedget' ? 'อุปกรณ์' : 'กลุ่ม'}`;
                        modalForm.reset();
                        if (type === 'group') {
                            // จัดการข้อมูลกลุ่ม
                            if (data.group) {
                                modalForm.querySelector('[name="id_group"]').value = data.group.id_group;
                                modalForm.querySelector('[name="group_name"]').value = data.group.group_name;
                            }
                            
                            // จัดการ checkboxes สำหรับ services
                            if (data.services) {
                                data.services.forEach(serviceId => {
                                    const checkbox = modalForm.querySelector(`input[name="services[]"][value="${serviceId}"]`);
                                    if (checkbox) checkbox.checked = true;
                                });
                            }
                            
                            // จัดการ checkboxes สำหรับ gedgets
                            if (data.gedgets) {
                                data.gedgets.forEach(gedgetId => {
                                    const checkbox = modalForm.querySelector(`input[name="gedgets[]"][value="${gedgetId}"]`);
                                    if (checkbox) checkbox.checked = true;
                                });
                            }
                        } else {
                            // จัดการข้อมูลสำหรับ service และ gedget
                            Object.keys(data).forEach(key => {
                                const input = modalForm.querySelector(`[name="${key}"]`);
                                if (input) {
                                    input.value = data[key];
                                }
                            });
                        }
                        
                        modalElement.classList.remove('hidden');
                    });
            } else {
                // แสดงฟิลด์จำนวนและวันที่สร้าง
                if (quantityField) {
                    quantityField.style.display = 'block';
                }
                if (createDateField) {
                    createDateField.style.display = 'block';
                }
                // ซ่อนฟิลด์สถานะ
                if (statusField) {
                        statusField.classList.add('hidden');
                }
                if (quantityGedgetInput) {
                    quantityGedgetInput.setAttribute('required', true);
                }
                modalTitle.innerText = `สร้าง ${type === 'service' ? 'บริการ' : type === 'gedget' ? 'อุปกรณ์' : 'กลุ่ม'}`;
                modalForm.reset();
                modalElement.classList.remove('hidden');
            }
        }

        function closeModalService(type) {
            const modalElement = document.getElementById(`${type}Modal`);
            modalElement.classList.add('hidden');
        }

        function deleteItem(type, id) {
            if (!id || isNaN(id)) {
                alert('ID ไม่ถูกต้อง');
                return;
            }
            const itemName = type === 'service' ? 'บริการ' : type === 'gedget' ? 'อุปกรณ์' : 'กลุ่ม';
            if (confirm(`คุณแน่ใจหรือไม่ว่าต้องการลบ ${itemName} นี้?`)) {
                fetch(`../function/delete_${type}.php?id=${id}`, { method: 'DELETE' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message); // แสดงข้อความสำเร็จ
                            location.reload(); // รีเฟรชหน้า
                        } else {
                            alert(data.message); // แสดงข้อความผิดพลาด
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
                    });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const serviceForm = document.getElementById('serviceForm');
            const gedgetForm = document.getElementById('gedgetForm');
            const groupForm = document.getElementById('groupForm');

            if (serviceForm) {
                serviceForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    handleFormSubmit('service', this);
                });
            }
            if (gedgetForm) {
                gedgetForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    handleFormSubmit('gedget', this);
                });
            }
            if (groupForm) {
                groupForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    handleFormSubmit('group', this);
                });
            }
        });

        function handleFormSubmit(type, form) {
            // สำหรับกรณี group
            if (type === 'group') {
                const formData = new FormData(form);
                const data = {
                    id_bill: <?php echo $id_bill; ?>,
                    group_name: formData.get('group_name'),
                    services: [],
                    gedgets: []
                };

                // เช็คว่ามีการกรอกชื่อกลุ่มหรือไม่
                if (!data.group_name) {
                    alert('กรุณากรอกชื่อกลุ่ม');
                    return;
                }
                
                // รวบรวมค่า checkbox ที่ถูกเลือก
                form.querySelectorAll('input[name="services[]"]:checked').forEach(checkbox => {
                    data.services.push(parseInt(checkbox.value));
                });
                
                form.querySelectorAll('input[name="gedgets[]"]:checked').forEach(checkbox => {
                    data.gedgets.push(parseInt(checkbox.value));
                });

                // เช็คว่าเลือกอย่างน้อย 1 รายการ
                if (data.services.length === 0 && data.gedgets.length === 0) {
                    alert('กรุณาเลือกอย่างน้อย 1 บริการหรืออุปกรณ์');
                    return;
                }

                // กรณีแก้ไข
                const id_group = formData.get('id_group');
                if (id_group) {
                    data.id_group = parseInt(id_group);
                }

                // ส่งข้อมูลแบบ JSON
                const url = id_group ? '../function/update_group.php' : '../function/create_group.php';
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        location.reload();
                    } else {
                        alert(result.message || `เกิดข้อผิดพลาดในการ${id_group ? 'แก้ไข' : 'บันทึก'}ข้อมูล`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
                });
                
                return;
            }

            // สำหรับกรณี service และ gedget
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            data.id_bill = <?php echo $id_bill; ?>;

            // ตรวจสอบข้อมูลตามประเภท
            if (type === 'gedget') {
                if (!data.name_gedget || (!data.create_at && !data.id_gedget)) {
                    alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                    return;
                }
            }

            const isEdit = formData.get(`id_${type}`) ? true : false;
            const url = isEdit ? 
                `../function/update_${type}.php` : 
                `../function/create_${type}.php`;

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    location.reload();
                } else {
                    alert(result.message || `เกิดข้อผิดพลาดในการ${isEdit ? 'แก้ไข' : 'บันทึก'}ข้อมูล`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
            });
        }
        // ฟังก์ชันเปิด modal สำหรับคู่มือ
        function openManual() {
            document.getElementById('manualModal').classList.remove('hidden');
            currentPage = 0;
            showPage(currentPage);
        }

        // ฟังก์ชันปิด modal สำหรับคู่มือ
        function closeModal() {
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