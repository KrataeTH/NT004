<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// ตรวจสอบว่ามีการเลือกประเภทรายงานหรือไม่
$report_type = isset($_GET['report_type']) ? $_GET['report_type'] : '';

// รับค่าตัวกรองจากฟอร์ม
$filter_customer_type = isset($_GET['filter_customer_type']) ? $_GET['filter_customer_type'] : '';
$filter_amphure = isset($_GET['filter_amphure']) ? $_GET['filter_amphure'] : '';

// ดึงข้อมูลประเภทลูกค้า
$customer_types = $conn->query("SELECT * FROM customer_types")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        .dataTables_filter {
            display: none;
        }
        .flex-wrap {
            gap: 0.5rem;
        }
        .border {
            border: 1px solid #e2e8f0;
        }
        .rounded-md {
            border-radius: 0.375rem;
        }
        table thead th {
            background-color: #4a5568;
            color: white;
            padding: 0.75rem;
        }
        table tbody tr {
            background-color: rgb(255, 255, 255);
        }
        table tbody tr:hover {
            background-color: rgb(198, 198, 198);
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include './components/navbar.php'; ?>
    <?php include './components/report_manual.php'; ?>
    <!-- ปุ่มเปิดคู่มือ -->
    <button id="manualButton" class="fixed right-4 top-20 bg-blue-500 text-white px-3 py-2 rounded-md z-50 flex items-center group transition-all duration-300 w-10 hover:w-24 overflow-hidden">
        <i class="fas fa-question-circle text-xl"></i>
        <span class="ml-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">คู่มือ</span>
    </button>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">รายงาน</h1>
        
        <!-- Control Panel -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <form method="GET" class="space-y-4">
                <!-- Report Selection and Export Button Row -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex-grow">
                        <select name="report_type" id="report_type" 
                                class="w-full p-2 border rounded-md bg-white" 
                                onchange="this.form.submit()">
                            <option value="">-- เลือกรายงาน --</option>
                            <option value="1" <?= $report_type == '1' ? 'selected' : '' ?>>รายงาน 1: ลูกค้าและจำนวนบิลทั้งหมด</option>
                            <option value="2" <?= $report_type == '2' ? 'selected' : '' ?>>รายงาน 2: ลูกค้าและหมายเลขบิลที่เกี่ยวข้อง</option>
                            <option value="3" <?= $report_type == '3' ? 'selected' : '' ?>>รายงาน 3: ลูกค้าและอุปกรณ์ที่เกี่ยวข้อง</option>
                        </select>
                    </div>
                    <button type="button" onclick="exportToExcel()" 
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-all duration-300">
                        <i class="fas fa-file-excel mr-2"></i>ส่งออกเป็น Excel
                    </button>
                </div>

                <?php if ($report_type): ?>
                <!-- Filters Row -->
                <div class="flex flex-wrap items-center gap-4">
                    <!-- Customer Type Filter -->
                    <div class="flex-grow">
                        <select name="filter_customer_type" id="filter_customer_type" class="w-full p-2 border rounded-md">
                            <option value="">ทุกประเภทลูกค้า</option>
                            <?php foreach ($customer_types as $type): ?>
                                <option value="<?= $type['id_customer_type'] ?>" 
                                    <?= $filter_customer_type == $type['id_customer_type'] ? 'selected' : '' ?>>
                                    <?= $type['type_customer'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Amphure Filter -->
                    <div class="flex-grow">
                        <select name="filter_amphure" id="filter_amphure" 
                                class="w-full p-2 border rounded-md">
                            <option value="">ทุกอำเภอ</option>
                            <?php
                            $sql_amphures = "SELECT * FROM amphures";
                            $result_amphures = $conn->query($sql_amphures);
                            while ($row_amphures = $result_amphures->fetch_assoc()) {
                                $selected = $filter_amphure == $row_amphures['id_amphures'] ? 'selected' : '';
                                echo "<option value='" . $row_amphures['id_amphures'] . "' $selected>" 
                                    . $row_amphures['name_amphures'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <?php if ($report_type == '2'): ?>
                    <!-- Service Type Filter -->
                    <div class="flex-grow">
                        <select name="filter_type_service" id="filter_type_service" 
                                class="w-full p-2 border rounded-md">
                            <option value="">ทุกประเภทบริการ</option>
                            <option value="Fttx" <?= isset($_GET['filter_type_service']) && $_GET['filter_type_service'] == 'Fttx' ? 'selected' : '' ?>>Fttx</option>
                            <option value="Fttx+ICT solution" <?= isset($_GET['filter_type_service']) && $_GET['filter_type_service'] == 'Fttx+ICT solution' ? 'selected' : '' ?>>Fttx+ICT solution</option>
                            <option value="SI service" <?= isset($_GET['filter_type_service']) && $_GET['filter_type_service'] == 'SI service' ? 'selected' : '' ?>>SI service</option>
                            <!-- Add other service types -->
                        </select>
                    </div>

                    <!-- Gadget Type Filter -->
                    <div class="flex-grow">
                        <select name="filter_type_gadget" id="filter_type_gadget" 
                                class="w-full p-2 border rounded-md">
                            <option value="">ทุกประเภทอุปกรณ์</option>
                            <option value="เช่า" <?= isset($_GET['filter_type_gadget']) && $_GET['filter_type_gadget'] == 'เช่า' ? 'selected' : '' ?>>เช่า</option>
                            <option value="ขาย" <?= isset($_GET['filter_type_gadget']) && $_GET['filter_type_gadget'] == 'ขาย' ? 'selected' : '' ?>>ขาย</option>
                            <option value="เช่าและขาย" <?= isset($_GET['filter_type_gadget']) && $_GET['filter_type_gadget'] == 'เช่าและขาย' ? 'selected' : '' ?>>เช่าและขาย</option>
                        </select>
                    </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-search mr-2"></i>ค้นหา
                        </button>
    
                    </div>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <?php
        if ($report_type == '1') {
            $sql = "SELECT 
                        c.id_customer, 
                        c.name_customer, 
                        c.phone_customer,
                        ct.type_customer, 
                        CONCAT(a.info_address, ' ต.', t.name_tambons, ' อ.', am.name_amphures) AS full_address,
                        COUNT(DISTINCT b.id_bill) AS total_bills,
                        COALESCE(ROUND(SUM(CASE WHEN sc.status_service = 'ใช้งาน' AND pl.status_package = 'ใช้งาน' 
                            AND pr.status_product = 'ใช้งาน' THEN o.mainpackage_price ELSE 0 END), 2), 0) AS mainpackage_price,
                        COALESCE(ROUND(SUM(CASE WHEN sc.status_service = 'ใช้งาน' AND pl.status_package = 'ใช้งาน' 
                            AND pr.status_product = 'ใช้งาน' THEN o.ict_price ELSE 0 END), 2), 0) AS ict_price,
                        COALESCE(ROUND(SUM(CASE WHEN sc.status_service = 'ใช้งาน' AND pl.status_package = 'ใช้งาน' 
                            AND pr.status_product = 'ใช้งาน' THEN o.all_price ELSE 0 END), 2), 0) AS all_price
                            FROM customers c 
                            LEFT JOIN customer_types ct ON c.id_customer_type = ct.id_customer_type
                            LEFT JOIN bill_customer b ON c.id_customer = b.id_customer 
                            LEFT JOIN address a ON c.id_address = a.id_address 
                            LEFT JOIN tambons t ON a.id_tambons = t.id_tambons 
                            LEFT JOIN amphures am ON a.id_amphures = am.id_amphures 
                            LEFT JOIN service_customer sc ON b.id_bill = sc.id_bill 
                            LEFT JOIN package_list pl ON sc.id_service = pl.id_service 
                            LEFT JOIN product_list pr ON pl.id_package = pr.id_package 
                            LEFT JOIN overide o ON pr.id_product = o.id_product 
                            WHERE b.status_bill = 'ใช้งาน'";
            if (!empty($filter_customer_type)) {
                $sql .= " AND c.id_customer_type = " . intval($filter_customer_type);
            }
        
            if (!empty($filter_amphure)) {
                $sql .= " AND a.id_amphures = " . intval($filter_amphure);
            }
        
            $sql .= " GROUP BY c.id_customer, c.name_customer, c.phone_customer, ct.type_customer, 
                      a.info_address, t.name_tambons, am.name_amphures";
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                echo "<h2 class='text-xl font-bold mt-4'>รายงาน 1: ลูกค้าและจำนวนบิลทั้งหมด</h2>";
                echo "<div class='overflow-x-auto mt-4'>";
                echo "<table class='w-full border-collapse border border-gray-300'>";
                echo "<thead><tr class='bg-gray-200'>
                        <th class='p-2 border border-gray-300'>ลำดับ</th>
                        <th class='p-2 border border-gray-300'>ชื่อลูกค้า</th>
                        <th class='p-2 border border-gray-300'>โทรศัพท์</th>
                        <th class='p-2 border border-gray-300'>ที่อยู่</th>
                        <th class='p-2 border border-gray-300'>จำนวนบิลทั้งหมด</th>
                        <th class='p-2 border border-gray-300'>ราคาแพ็คเกจหลัก</th>
                        <th class='p-2 border border-gray-300'>ราคา ICT</th>
                        <th class='p-2 border border-gray-300'>ราคารวม</th>
                      </tr></thead>";
                echo "<tbody>";
            
                $counter = 1; // เพิ่มตัวแปรนับจำนวน
                $total_customers = 0;
                $total_mainpackage = 0;
                $total_ict = 0;
                $total_allprice = 0;
            
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td class='p-2 border border-gray-300'>" . $counter . "</td>
                            <td class='p-2 border border-gray-300'>" . $row['name_customer'] . "</td>
                            <td class='p-2 border border-gray-300'>" . $row['phone_customer'] . "</td>
                            <td class='p-2 border border-gray-300'>" . $row['full_address'] . "</td>
                            <td class='p-2 border border-gray-300'>" . $row['total_bills'] . "</td>
                            <td class='p-2 border border-gray-300'>" . $row['mainpackage_price'] . "</td>
                            <td class='p-2 border border-gray-300'>" . $row['ict_price'] . "</td>
                            <td class='p-2 border border-gray-300'>" . $row['all_price'] . "</td>
                          </tr>";
            
                    $counter++; // เพิ่มค่าลำดับ
                    $total_customers++;
                    $total_mainpackage += $row['mainpackage_price'];
                    $total_ict += $row['ict_price'];
                    $total_allprice += $row['all_price'];
                }
            
                echo "<tr class='bg-gray-100 font-bold'>
                        <td class='p-2 border border-gray-300' colspan='4'>รวม</td>
                        <td class='p-2 border border-gray-300'>$total_customers ลูกค้า</td>
                        <td class='p-2 border border-gray-300'>$total_mainpackage บาท</td>
                        <td class='p-2 border border-gray-300'>$total_ict บาท</td>
                        <td class='p-2 border border-gray-300'>$total_allprice บาท</td>
                      </tr>";
            
                echo "</tbody></table></div>";
            } else {
                echo "<p class='mt-4'>ไม่พบข้อมูลสำหรับรายงาน 1</p>";
            }
        } elseif ($report_type == '2') {
            // รายงาน 2: แสดงลูกค้าและหมายเลขบิลที่เกี่ยวข้องทั้งหมด โดยไม่สนใจว่ามีบริการหรือไม่
            $sql = "SELECT 
                    c.id_customer, 
                    c.name_customer,
                    ct.type_customer,
                    b.number_bill, 
                    b.type_bill, 
                    b.create_at, 
                    b.end_date, 
                    sc.type_service, 
                    sc.code_service,
                    sc.type_gadget,
                    COALESCE(ROUND(SUM(CASE WHEN pl.status_package = 'ใช้งาน' AND pr.status_product = 'ใช้งาน' THEN o.mainpackage_price ELSE 0 END), 2), 0) AS mainpackage_price,
                    COALESCE(ROUND(SUM(CASE WHEN pl.status_package = 'ใช้งาน' AND pr.status_product = 'ใช้งาน' THEN o.ict_price ELSE 0 END), 2), 0) AS ict_price,
                    COALESCE(ROUND(SUM(CASE WHEN pl.status_package = 'ใช้งาน' AND pr.status_product = 'ใช้งาน' THEN o.all_price ELSE 0 END), 2), 0) AS all_price
                            FROM customers c 
                            LEFT JOIN customer_types ct ON c.id_customer_type = ct.id_customer_type
                            LEFT JOIN bill_customer b ON c.id_customer = b.id_customer 
                            LEFT JOIN service_customer sc ON b.id_bill = sc.id_bill 
                            LEFT JOIN package_list pl ON sc.id_service = pl.id_service 
                            LEFT JOIN product_list pr ON pl.id_package = pr.id_package 
                            LEFT JOIN overide o ON pr.id_product = o.id_product 
                            LEFT JOIN address a ON c.id_address = a.id_address 
                            WHERE b.status_bill = 'ใช้งาน'";
        
            // เพิ่มเงื่อนไขกรอง type_customer
            if (!empty($filter_customer_type)) {
                $sql .= " AND c.id_customer_type = " . intval($filter_customer_type);
            }
        
            // เพิ่มเงื่อนไขกรอง amphure
            if (!empty($filter_amphure)) {
                $sql .= " AND a.id_amphures = $filter_amphure";
            }
        
            // เพิ่มเงื่อนไขกรอง type_service
            if (!empty($_GET['filter_type_service'])) {
                $sql .= " AND sc.type_service = '{$_GET['filter_type_service']}'";
            }
        
            // เพิ่มเงื่อนไขกรอง type_gadget
            if (!empty($_GET['filter_type_gadget'])) {
                $sql .= " AND sc.type_gadget = '{$_GET['filter_type_gadget']}'";
            }
        
            $sql .= " GROUP BY c.id_customer, b.number_bill, sc.id_service
                      ORDER BY c.id_customer, b.number_bill, sc.id_service";
        
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                echo "<h2 class='text-xl font-bold mt-4'>รายงาน 2: ลูกค้าและหมายเลขบิลที่เกี่ยวข้อง</h2>";
                echo "<div class='overflow-x-auto mt-4'>";
                echo "<table class='w-full border-collapse border border-gray-300'>";
                echo "<thead><tr class='bg-gray-200'>
                        <th class='p-2 border border-gray-300'>ลำดับ</th>
                        <th class='p-2 border border-gray-300'>ชื่อลูกค้า</th>
                        <th class='p-2 border border-gray-300'>หมายเลขบิล</th>
                        <th class='p-2 border border-gray-300'>ประเภทบิล</th>
                        <th class='p-2 border border-gray-300'>วันที่สร้าง</th>
                        <th class='p-2 border border-gray-300'>วันที่สิ้นสุด</th>
                        <th class='p-2 border border-gray-300'>ประเภทบริการ</th>
                        <th class='p-2 border border-gray-300'>รหัสบริการ</th>
                        <th class='p-2 border border-gray-300'>ประเภทอุปกรณ์</th>
                        <th class='p-2 border border-gray-300'>ราคาแพ็คเกจหลัก</th>
                        <th class='p-2 border border-gray-300'>ราคา ICT</th>
                        <th class='p-2 border border-gray-300'>ราคารวม</th>
                    </tr></thead>";
                echo "<tbody>";
            
                $counter = 1; // เพิ่มตัวแปรนับจำนวน
                $current_customer_id = null;
                $current_customer_name = null;
                $current_bill_number = null;
                $total_mainpackage = 0;
                $total_ict = 0;
                $total_allprice = 0;
                $total_customers = 0;
                $unique_customers = [];
            
                while ($row = $result->fetch_assoc()) {
                    if (!in_array($row['id_customer'], $unique_customers)) {
                        $unique_customers[] = $row['id_customer'];
                        $total_customers++;
                    }
            
                    $total_mainpackage += $row['mainpackage_price'];
                    $total_ict += $row['ict_price'];
                    $total_allprice += $row['all_price'];
            
                    if ($current_customer_id !== $row['id_customer']) {
                        $current_customer_id = $row['id_customer'];
                        $current_customer_name = $row['name_customer'];
                        $current_bill_number = $row['number_bill'];
                        echo "<tr>
                                <td class='p-2 border border-gray-300'>" . $counter . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['name_customer'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['number_bill'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['type_bill'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['create_at'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['end_date'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['type_service'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['code_service'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['type_gadget'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['mainpackage_price'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['ict_price'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['all_price'] . "</td>
                              </tr>";
                        $counter++; // เพิ่มค่าลำดับ
                    } else {
                        if ($current_bill_number !== $row['number_bill']) {
                            $current_bill_number = $row['number_bill'];
                            echo "<tr>
                                    <td class='p-2 border border-gray-300' colspan='2'></td>
                                    <td class='p-2 border border-gray-300'>" . $row['number_bill'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['type_bill'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['create_at'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['end_date'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['type_service'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['code_service'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['type_gadget'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['mainpackage_price'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['ict_price'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['all_price'] . "</td>
                                  </tr>";
                        } else {
                            echo "<tr>
                                    <td class='p-2 border border-gray-300' colspan='6'></td>
                                    <td class='p-2 border border-gray-300'>" . $row['type_service'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['code_service'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['type_gadget'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['mainpackage_price'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['ict_price'] . "</td>
                                    <td class='p-2 border border-gray-300'>" . $row['all_price'] . "</td>
                                  </tr>";
                        }
                    }
                }
                echo "<tr class='bg-gray-100 font-bold'>
                        <td class='p-2 border border-gray-300' colspan='8'>รวม</td>
                        <td class='p-2 border border-gray-300'>$total_customers ลูกค้า</td>
                        <td class='p-2 border border-gray-300'>$total_mainpackage บาท</td>
                        <td class='p-2 border border-gray-300'>$total_ict บาท</td>
                        <td class='p-2 border border-gray-300'>$total_allprice บาท</td>
                      </tr>";
            } else {
                echo "<p class='mt-4'>ไม่พบข้อมูลสำหรับรายงาน 2</p>";
            }
        } elseif ($report_type == '3') {
            // รายงาน 3: แสดงข้อมูลลูกค้าและอุปกรณ์ที่เกี่ยวข้อง โดยที่บิลมีสถานะเป็น "ใช้งาน"
            $sql = "SELECT 
                        c.id_customer, 
                        c.name_customer,
                        ct.type_customer,
                        c.phone_customer, 
                        CONCAT(a.info_address, ' ต.', t.name_tambons, ' อ.', am.name_amphures) AS full_address, 
                        g.name_gedget, 
                        g.status_gedget,
                        g.create_at,
                        g.note
                      FROM customers c 
                    LEFT JOIN customer_types ct ON c.id_customer_type = ct.id_customer_type
                    LEFT JOIN bill_customer b ON c.id_customer = b.id_customer 
                    INNER JOIN gedget g ON b.id_bill = g.id_bill 
                    LEFT JOIN address a ON c.id_address = a.id_address 
                    LEFT JOIN tambons t ON a.id_tambons = t.id_tambons 
                    LEFT JOIN amphures am ON a.id_amphures = am.id_amphures 
                    WHERE b.status_bill = 'ใช้งาน'";
        
            // เพิ่มเงื่อนไขกรอง type_customer
            if (!empty($filter_customer_type)) {
                $sql .= " AND c.id_customer_type = " . intval($filter_customer_type);
            }
        
            // เพิ่มเงื่อนไขกรอง amphure
            if (!empty($filter_amphure)) {
                $sql .= " AND a.id_amphures = $filter_amphure";
            }
        
            $sql .= " ORDER BY c.id_customer, g.name_gedget";
        
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                echo "<h2 class='text-xl font-bold mt-4'>รายงาน 3: ลูกค้าและอุปกรณ์ที่เกี่ยวข้อง</h2>";
                echo "<div class='overflow-x-auto mt-4'>";
                echo "<table class='w-full border-collapse border border-gray-300'>";
                echo "<thead><tr class='bg-gray-200'>
                        <th class='p-2 border border-gray-300'>ลำดับ</th>
                        <th class='p-2 border border-gray-300'>ชื่อลูกค้า</th>
                        <th class='p-2 border border-gray-300'>โทรศัพท์</th>
                        <th class='p-2 border border-gray-300'>ที่อยู่</th>
                        <th class='p-2 border border-gray-300'>ชื่ออุปกรณ์</th>
                        <th class='p-2 border border-gray-300'>วันที่สร้าง</th>
                        <th class='p-2 border border-gray-300'>สถานะอุปกรณ์</th>
                        <th class='p-2 border border-gray-300'>หมายเหตุ</th>
                      </tr></thead>";
                echo "<tbody>";
            
                $counter = 1; // เพิ่มตัวแปรนับจำนวน
                $current_customer_id = null;
            
                while ($row = $result->fetch_assoc()) {
                    if ($current_customer_id !== $row['id_customer']) {
                        $current_customer_id = $row['id_customer'];
                        echo "<tr>
                                <td class='p-2 border border-gray-300'>" . $counter . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['name_customer'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['phone_customer'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['full_address'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['name_gedget'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['create_at'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['status_gedget'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['note'] . "</td>
                              </tr>";
                        $counter++; // เพิ่มค่าลำดับ
                    } else {
                        echo "<tr>
                                <td class='p-2 border border-gray-300' colspan='4'></td>
                                <td class='p-2 border border-gray-300'>" . $row['name_gedget'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['create_at'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['status_gedget'] . "</td>
                                <td class='p-2 border border-gray-300'>" . $row['note'] . "</td>
                              </tr>";
                    }
                }
            
                echo "</tbody></table></div>";
            } else {
                echo "<p class='mt-4'>ไม่พบข้อมูลสำหรับรายงาน 3</p>";
            }
        }
        ?>
    </div>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
    function exportToExcel() {
        // เลือกตารางที่ต้องการส่งออก
        const table = document.querySelector('table');
        
        // สร้าง Workbook และ Worksheet จากตาราง
        const workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet 1"});
        
        // สร้างไฟล์ Excel และดาวน์โหลด
        XLSX.writeFile(workbook, 'Report.xlsx');
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