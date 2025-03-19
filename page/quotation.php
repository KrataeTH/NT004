<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php?error=not_logged_in');
    exit;
}

require_once '../config/config.php';
require_once '../function/functions.php';


$groupNames = ['ค่าอุปกรณ์ Solution ใหม่', 'ค่าอุปกรณ์ทดแทน Solution เดิม', 'ค่าอุปกรณ์ Solution เดิม', 'ต้นทุนการดำเนินการ'];
$sql = "SELECT id_customer, name_customer FROM customers";
$result = $conn->query($sql);

$customers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสนอราคา</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include './components/navbar.php'; ?>
    <?php include './components/quotation_manual.php'; ?>
    <!-- ปุ่มเปิดคู่มือ -->
    <button id="manualButton" class="fixed right-4 top-20 bg-blue-500 text-white px-3 py-2 rounded-md z-50 flex items-center group transition-all duration-300 w-10 hover:w-24 overflow-hidden">
        <i class="fas fa-question-circle text-xl"></i>
        <span class="ml-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">คู่มือ</span>
    </button>
    <div class="container mx-auto p-4">
        <!-- Tab Buttons -->
        <div class="flex mb-4">
            <button id="quote-tab" onclick="saveGroupData();saveSalesData();switchTab('quote-form')" 
                    class="px-4 py-2 rounded-t-lg bg-gray-200 ml-1 hover:bg-gray-300">
                ราคาประมาณ
            </button>
            <button id="summary-tab" onclick="saveGroupData();saveSalesData();switchTab('summary')" 
                    class="px-4 py-2 rounded-t-lg bg-gray-200 ml-1 hover:bg-gray-300">
                ขายขาด ISI (สรุป)
            </button>
            <button id="investment-rental-tab" onclick="saveGroupData();saveSalesData();switchTab('investment-rental')" 
                    class="px-4 py-2 rounded-t-lg bg-gray-200 ml-1 hover:bg-gray-300">
                เช่า(ลงทุนเอง)
            </button>
            <button id="installation-rental-tab" onclick="saveGroupData();saveSalesData();switchTab('installation-rental')" 
                    class="px-4 py-2 rounded-t-lg bg-gray-200 ml-1 hover:bg-gray-300">
                เช่า(เก็บค่าติดตั้ง)
            </button>
            <button id="summarize-tab" onclick="saveGroupData();saveSalesData();switchTab('summarize')" 
                    class="px-4 py-2 rounded-t-lg bg-gray-200 ml-1 hover:bg-gray-300">
                สรุปทั้งหมด
            </button>
        </div>

        <!-- Tab Content -->
        <div id="quote-form" class="tab-content bg-white p-4 rounded-b-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">งบประมาณการลงทุน</h2>
                <div class="mb-4 p-4 border rounded bg-gray-50">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- เลือกลูกค้า -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ลูกค้า:</label>
                            <select id="customer-select" class="w-full p-2 border rounded mt-1">
                                <option value="">-- เลือกลูกค้า --</option>
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer['id_customer'] ?>"><?= htmlspecialchars($customer['name_customer']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">โครงการ:</label>
                            <input type="text" id="project-name" class="w-full p-2 border rounded mt-1" placeholder="ระบุชื่อโครงการ..." >
                        </div>
                    </div>
                </div>
                <!-- Groups 1-3 Combined -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                    <h2 class="text-lg font-semibold mb-4">รายละเอียดประมาณการต้นทุนค่าอุปกรณ์ Solution</h2>
                    <table class="w-full mb-4 border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-2 px-3 border border-gray-300 text-left">รายการ</th>
                                <th class="py-2 px-3 border border-gray-300">ราคาต่อหน่วย(บาท)</th>
                                <th class="py-2 px-3 border border-gray-300">จำนวน(หน่วย)</th>
                                <th class="py-2 px-3 border border-gray-300">หมายเหตุ</th>
                                <th class="py-2 px-3 border border-gray-300">เป็นเงินบาท(ไม่รวม vat)</th>
                            </tr>
                        </thead>
                        <?php foreach (array_slice($groupNames, 0, 3) as $index => $groupName): 
                            $groupId = $index + 1;
                        ?>
                            <tbody>
                                <tr class="bg-gray-100">
                                    <th colspan="5" class="text-left py-2 px-3">กลุ่ม <?= $groupName ?></th>
                                </tr>
                            </tbody>
                            <tbody id="group<?= $groupId ?>-items"></tbody>
                            <tbody>
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="text-right font-semibold py-2 px-3 border border-gray-300">รวมกลุ่ม <?= $groupName ?></td>
                                    <td id="group<?= $groupId ?>-total" class="font-semibold py-2 px-3 border border-gray-300">0.00</td>
                                    <td class="py-2 px-3 border border-gray-300"></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td colspan="3" class="text-right font-semibold py-2 px-3 border border-gray-300">รวมทังสิ้น</td>
                                <td id="combined-total" class="font-semibold py-2 px-3 border border-gray-300">0.00 บาท</td>
                                <td class="py-2 px-3 border border-gray-300"></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <?php foreach (array_slice($groupNames, 0, 3) as $index => $groupName): 
                            $groupId = $index + 1;
                        ?>
                            <button onclick="addItem(<?= $groupId ?>)" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                + เพิ่มรายการ<?= $groupName ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Group 4 -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                    <h2 class="text-lg font-semibold mb-4">รายละเอียดประมาณการต้นทุนค่าดำเนินการ</h2>
                    <table class="w-full mb-4 border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-2 px-3 border border-gray-300 text-left">รายการ</th>
                                <th class="py-2 px-3 border border-gray-300">ราคาต่อหน่วย(บาท)</th>
                                <th class="py-2 px-3 border border-gray-300">จำนวน(หน่วย)</th>
                                <th class="py-2 px-3 border border-gray-300">หมายเหตุ</th>
                                <th class="py-2 px-3 border border-gray-300">บาท(ไม่รวม vat)</th>
                            </tr>
                        </thead>
                        <tbody id="group4-items"></tbody>
                            <tr class="bg-gray-100">
                                <th colspan="5" class="text-left py-2 px-3">กลุ่ม <?= $groupNames[3] ?></th>
                            </tr>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td colspan="3" class="text-right font-semibold py-2 px-3 border border-gray-300">รวมทั้งหมด</td>
                                <td id="group4-total" class="font-semibold py-2 px-3 border border-gray-300">0.00 บาท</td>
                                <td class="py-2 px-3 border border-gray-300"></td>
                            </tr>
                        </tfoot>
                    </table>
                    <button onclick="addItem(4)" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg w-full">
                        + เพิ่มรายการ<?= $groupNames[3] ?>
                    </button>
                </div>
                <!-- เพิ่ม Block สำหรับต้นทุนรวมโครงการและงบประมาณที่ขอใช้ -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                    <table class="w-full mb-4 border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-2 px-3 border border-gray-300 text-left">รายละเอียด</th>
                                <th class="py-2 px-3 border border-gray-300">จำนวนเงิน (บาทไม่รวม vat)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-gray-100">
                                <td class="text-left py-2 px-3">ต้นทุนรวมโครงการทั้งโครงการ</td>
                                <td id="project-total" class="font-semibold py-2 px-3 border border-gray-300">0.00</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="text-left py-2 px-3">งบประมาณที่ขอใช้</td>
                                <td id="requested-budget" class="font-semibold py-2 px-3 border border-gray-300">0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="summary" class="tab-content hidden bg-white p-4 rounded-b-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">สรุปรายการขายขาด ISI</h2>
            
            <!-- Update the summary tables HTML structure -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2"><?= $groupNames[0] ?></h3>
                <div class="flex">
                    <table class="w-5/6 border-collapse border border-gray-200">
                        <!-- Existing table header and content -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-3 border" rowspan="2">รายการ</th>
                                <th class="py-2 px-3 border" rowspan="2">จำนวน</th>
                                <th class="py-2 px-3 border" colspan="2">ต้นทุนขาย</th>
                                <th class="py-2 px-3 border" colspan="2">ราคาขาย ISI</th>
                                <th class="py-2 px-3 border" rowspan="2">ผลต่าง</th>
                            </tr>
                            <tr>
                                <th class="py-2 px-3 border">ราคาทุนต่อหน่วย</th>
                                <th class="py-2 px-3 border">รวมต้นทุน</th>
                                <th class="py-2 px-3 border">ราคาขายต่อหน่วย</th>
                                <th class="py-2 px-3 border">รวมขาย</th>
                            </tr>
                        </thead>
                        <tbody id="group1-summary" class="text-center"></tbody>
                        <tfoot>
                            <tr class="bg-gray-50 font-semibold">
                                <td colspan="3" class="py-2 px-3 border text-right">รวมทั้งสิ้น</td>
                                <td id="group1-total-cost" class="py-2 px-3 border"></td>
                                <td class="py-2 px-3 border"></td>
                                <td id="group1-total-sales" class="py-2 px-3 border"></td>
                                <td id="group1-total-difference" class="py-2 px-3 border"></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="w-1/6 p-4 bg-gray-50 border-r border-t border-b">
                        <div class="text-lg font-semibold mb-2">% กำไร</div>
                        <div id="group1-profit-percentage" class="text-2xl font-bold text-green-600">0.00%</div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2"><?= $groupNames[3] ?></h3>
                <div class="flex">
                    <table class="w-5/6 border-collapse border border-gray-200">
                        <!-- Existing table header and content -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-3 border" rowspan="2">รายการ</th>
                                <th class="py-2 px-3 border" rowspan="2">จำนวน</th>
                                <th class="py-2 px-3 border" colspan="2">ต้นทุนขาย</th>
                                <th class="py-2 px-3 border" colspan="2">ราคาขาย ISI</th>
                                <th class="py-2 px-3 border" rowspan="2">ผลต่าง</th>
                            </tr>
                            <tr>
                                <th class="py-2 px-3 border">ราคาทุนต่อหน่วย</th>
                                <th class="py-2 px-3 border">รวมต้นทุน</th>
                                <th class="py-2 px-3 border">ราคาขายต่อหน่วย</th>
                                <th class="py-2 px-3 border">รวมขาย</th>
                            </tr>
                        </thead>
                        <tbody id="group4-summary" class="text-center"></tbody>
                        <tfoot>
                            <tr class="bg-gray-50 font-semibold">
                                <td colspan="3" class="py-2 px-3 border text-right">รวมทั้งสิ้น</td>
                                <td id="group4-total-cost" class="py-2 px-3 border"></td>
                                <td class="py-2 px-3 border"></td>
                                <td id="group4-total-sales" class="py-2 px-3 border"></td>
                                <td id="group4-total-difference" class="py-2 px-3 border"></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="w-1/6 p-4 bg-gray-50 border-r border-t border-b">
                        <div class="text-lg font-semibold mb-2">% กำไร</div>
                        <div id="group4-profit-percentage" class="text-2xl font-bold text-green-600">0.00%</div>
                    </div>
                </div>
            </div>

            <!-- Add grand total section -->
             <!-- Add VAT rate control -->
            <div class="mb-4 p-4 bg-white rounded-lg shadow">
                <label class="font-semibold">อัตรา VAT:</label>
                <select id="vat-rate" class="ml-2 p-2 border rounded" onchange="updateGrandTotals()"></select>
            </div>
                            
            <!-- Update grand total section with VAT calculations -->
            <div class="mt-8 bg-white p-6 rounded-xl border shadow-md">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Cost Section -->
                    <div class="border-r pr-6">
                        <h3 class="font-bold text-xl mb-4">ต้นทุน</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">รวมต้นทุน (ก่อน VAT):</span>
                                <span id="grand-total-cost" class="font-semibold"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">VAT:</span>
                                <span id="cost-vat" class="font-semibold"></span>
                            </div>
                            <div class="flex justify-between border-t pt-2 font-bold text-lg">
                                <span>รวมต้นทุนทั้งหมด (รวม VAT):</span>
                                <span id="grand-total-cost-with-vat"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Section -->
                    <div class="pl-6">
                        <h3 class="font-bold text-xl mb-4">การขาย</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">รวมยอดขาย (ก่อน VAT):</span>
                                <span id="grand-total-sales" class="font-semibold"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">VAT:</span>
                                <span id="sales-vat" class="font-semibold"></span>
                            </div>
                            <div class="flex justify-between border-t pt-2 font-bold text-lg">
                                <span>รวมยอดขายทั้งหมด (รวม VAT):</span>
                                <span id="grand-total-sales-with-vat"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profit Section -->
                <div class="mt-8 pt-6 border-t">
                    <h3 class="font-bold text-xl mb-4">กำไร</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">กำไรขั้นต้น (ก่อน VAT):</span>
                            <span id="total-profit" class="font-semibold text-green-600"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">กำไรขั้นต้น (รวม VAT):</span>
                            <span id="total-profit-with-vat" class="font-semibold text-green-600"></span>
                        </div>
                        <div class="flex justify-between border-t pt-2 font-bold text-lg text-green-600">
                            <span>% กำไร (รวม VAT):</span>
                            <span id="total-profit-percentage-with-vat"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="investment-rental" class="tab-content hidden bg-white p-4 rounded-b-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">แบบเช่า(ลงทุนเอง)</h2>

            <!-- ตาราง รวมโครงการ -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-semibold mb-2">รวมโครงการ</h3>
                <table class="w-full border-collapse border">
                    <thead>
                        <tr>
                            <th class="py-2 px-3 border" rowspan="2">รายการ</th>
                            <th class="py-2 px-3 border" rowspan="2">รวมต้นทุนโครงการ</th>
                            <th class="py-2 px-3 border" rowspan="2">งบประมาณที่ขอใช้</th>
                            <th class="py-2 px-3 border" colspan="2">รายได้ขั้นต่ำ (บาท/โครงการ)</th>
                            <th class="py-2 px-3 border" rowspan="2">จุดคุ้มทุน(เดือน)</th>
                        </tr>
                        <tr>
                            <th class="py-2 px-3 border">ค่าบริการรายเดือน</th>
                            <th class="py-2 px-3 border">จำนวนรอบบิล</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-3 border">
                                <div id="investment-rental-total">0.00</div>
                            </td>
                            <td class="py-2 px-3 border">
                                <div id="investment-rental-budget">0.00</div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold">
                            <td class="py-2 px-3 border text-right" colspan="3">รวมทั้งสิ้น</td>
                            <td colspan="2">
                                <div id="investment-rental-summarize">0.00</div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-semibold mb-2">อัตตราค่าบริการและปันส่วนรายได้(รายเดือน)</h3>
                <table id="investment-rentals" class="w-full border-collapse border">
                    <thead>
                        <tr>
                            <th class="py-2 px-3 border">รายการโปรโมชั่น/แพ็คเกจ</th>
                            <th class="py-2 px-3 border">ค่าบริการรายเดือนตามโปรโมชั่น</th>
                            <th class="py-2 px-3 border">ค่าบริการอื่นๆ(ถ้ามี)</th>
                            <th class="py-2 px-3 border">ค่าเช่า ICT&MA ขั้นต่ำ</th>
                            <th class="py-2 px-3 border">ค่าเช่าเพิ่มตามดุลพินิจ</th>
                            <th class="py-2 px-3 border">รายได้ขั้นค่าบริการ(บาท/เดือน)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Service rows will be dynamically added here -->
                    </tbody>
                    
                </table>
                <button onclick="addServiceRow('investment-rentals')" 
                        class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    + เพิ่มรายการบริการ
                </button>
            </div>
        </div>
        <div id="installation-rental" class="tab-content hidden bg-white p-4 rounded-b-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">แบบเช่า(เก็บค่าติดตั้ง)</h2>
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-semibold mb-2">รวมโครงการ</h3>
                <table class="w-full border-collapse border">
                    <thead>
                        <tr>
                            <th class="py-2 px-3 border" rowspan="2">รายการ</th>
                            <th class="py-2 px-3 border" rowspan="2">รวมต้นทุนโครงการ</th>
                            <th class="py-2 px-3 border" rowspan="2">งบประมาณที่ขอใช้</th>
                            <th class="py-2 px-3 border" colspan="3">รายได้ขั้นต่ำรวมทั้งโครงการ</th>
                            <th class="py-2 px-3 border" rowspan="2">จุดคุ้มทุน(เดือน)</th>
                        </tr>
                        <tr>
                            <th class="y-2 px-3 border">ค่าดำเนินการชำระครั้งเดียว</th>
                            <th class="y-2 px-3 border">ค่าบริการรายเดือน</th>
                            <th class="y-2 px-3 border">จำนวนรอบบิล</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-3 border">
                                <div id="installation-rental-total">0.00</div>
                            </td>
                            <td class="py-2 px-3 border">
                                <div id="installation-rental-budget">0.00</div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold">
                            <td class="py-2 px-3 border text-right" colspan="3">รวมทั้งสิ้น</td>
                            <td id="installation-rental-onetime">0.00</td>
                            <td class="py-2 px-3 border" colspan="2">
                                <div id="installation-rental-allmonthly">0.00</div>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 font-semibold">
                            <td class="py-2 px-3 border text-right" colspan="3">รวมรายได้ทั้งโครงการ</td>
                            <td class="py-2 px-3 border" colspan="3">
                                <div id="installation-rental-summarize">0.00</div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-semibold mb-2">อัตตราค่าบริการและปันส่วนรายได้(รายเดือน)</h3>
                <table id="installation-rentals" class="w-full border-collapse border">
                    <thead>
                        <tr>
                            <th class="py-2 px-3 border">รายการโปรโมชั่น/แพ็คเกจ</th>
                            <th class="py-2 px-3 border">ค่าบริการรายเดือนตามโปรโมชั่น</th>
                            <th class="py-2 px-3 border">ค่าบริการอื่นๆ(ถ้ามี)</th>
                            <th class="py-2 px-3 border">ค่าเช่า ICT&MA ขั้นต่ำ</th>
                            <th class="py-2 px-3 border">ค่าเช่าเพิ่มตามดุลพินิจ</th>
                            <th class="py-2 px-3 border">รายได้ขั้นค่าบริการ(บาท/เดือน)</th>
                        </tr>
                    </thead>
                    <tbody>
                            
                    </tbody>
                </table>
                <button onclick="addServiceRow('installation-rentals')" 
                        class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    + เพิ่มรายการบริการ
                </button>
            </div>
        </div>

        <div id="summarize" class="tab-content hidden bg-white p-4 rounded-b-lg shadow-md">
    
        </div>
    </div>
    <script>
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
        const vatSelect = document.getElementById("vat-rate");
        // สร้างตัวเลือก VAT ตั้งแต่ 0% ถึง 100%
        for (let i = 0; i <= 100; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = `${i}%`;
            vatSelect.appendChild(option);
        }
        // ตั้งค่าเริ่มต้นเป็น 7%
        vatSelect.value = "7"

        function addItem(groupId) {
            const itemRow = `
                <tr>
                    <td><input type="text" class="item-name w-full p-1 border rounded" oninput="calculateTotal(${groupId})"></td>
                    <td><input type="number" class="item-price w-full p-1 border rounded" oninput="calculateTotal(${groupId})"></td>
                    <td><input type="number" class="item-quantity w-full p-1 border rounded" oninput="calculateTotal(${groupId})"></td>
                    <td><input type="text" class="w-full p-1 border rounded" placeholder="หมายเหตุ..."></td>
                    <td><span class="item-total">0.00</span></td>
                    <td><button onclick="removeItem(this, ${groupId})" class="text-red-500"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            document.getElementById(`group${groupId}-items`).insertAdjacentHTML('beforeend', itemRow);
            calculateTotal(groupId);
        }

        function removeItem(button, groupId) {
            const row = button.closest('tr');
            row.remove();
            calculateTotal(groupId);
        }

        function calculateTotal(groupId) {
            const rows = document.querySelectorAll(`#group${groupId}-items tr`);
            let total = 0;

            rows.forEach(row => {
                const priceInput = row.querySelector('.item-price');
                const quantityInput = row.querySelector('.item-quantity');

                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseFloat(quantityInput.value) || 0;

                const itemTotal = price * quantity;
                row.querySelector('.item-total').textContent = itemTotal.toFixed(2);
                total += itemTotal;
            });

            document.getElementById(`group${groupId}-total`).textContent = total.toFixed(2) ;

            // Update combined total for groups 1-3
            if (groupId >= 1 && groupId <= 3) {
                updateCombinedTotal();
            }

            // Update total for group 4
            if (groupId === 4) {
                updateProjectTotal();
            }
        }

        function updateCombinedTotal() {
            const group1 = parseFloat(document.getElementById('group1-total').textContent) || 0;
            const group2 = parseFloat(document.getElementById('group2-total').textContent) || 0;
            const group3 = parseFloat(document.getElementById('group3-total').textContent) || 0;
            const total = group1 + group2 + group3;
            document.getElementById('combined-total').textContent = total.toFixed(2) ;

            // Update requested budget (group 1 + 2)
            const requestedBudget = group1 + group2;
            document.getElementById('requested-budget').textContent = requestedBudget.toFixed(2) ;
        }

        function updateProjectTotal() {
            const group1 = parseFloat(document.getElementById('group1-total').textContent) || 0;
            const group2 = parseFloat(document.getElementById('group2-total').textContent) || 0;
            const group3 = parseFloat(document.getElementById('group3-total').textContent) || 0;
            const group4 = parseFloat(document.getElementById('group4-total').textContent) || 0;

            const total = group1 + group2 + group3 + group4;
            document.getElementById('project-total').textContent = total.toFixed(2) ;
        }
        function switchTab(tabId) {
            // ซ่อนเนื้อหาทั้งหมดและรีเซ็ตสไตล์แท็บ
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Reset all tab buttons to default style
            const quoteBtnTab = document.getElementById('quote-tab');
            const summaryBtnTab = document.getElementById('summary-tab');
            const investmentRentalTab = document.getElementById('investment-rental-tab');
            const installationRentalTab = document.getElementById('installation-rental-tab');
            const summarizeTab = document.getElementById('summarize-tab');
            
            [quoteBtnTab, summaryBtnTab, investmentRentalTab, installationRentalTab, summarizeTab].forEach(btn => {
                if (btn) {
                    btn.classList.replace('bg-blue-500', 'bg-gray-200');
                    btn.classList.replace('text-white', 'text-black');
                }
            });

            // แสดงเนื้อหาที่เลือก
            const selectedContent = document.getElementById(tabId);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }

            // อัปเดตสไตล์แท็บที่เลือก
            let activeTabBtn;
            if (tabId === 'quote-form') {
                activeTabBtn = quoteBtnTab;
            } else if (tabId === 'summary') {
                activeTabBtn = summaryBtnTab;
            } else if (tabId === 'investment-rental') {
                activeTabBtn = investmentRentalTab;
            } else if (tabId === 'installation-rental') {
                activeTabBtn = installationRentalTab;
            } else if (tabId === 'summarize') {
                activeTabBtn = summarizeTab;
                populateSummarizeTab();
                updateSummarizeTab();
            }

            if (activeTabBtn) {
                activeTabBtn.classList.replace('bg-gray-200', 'bg-blue-500');
                activeTabBtn.classList.replace('text-black', 'text-white');
            }

            // หากเป็นแท็บสรุปให้โหลดข้อมูล
            if (tabId === 'summary') {
                loadGroupData();
            } else if (tabId === 'investment-rental' || tabId === 'installation-rental') {
                loadProjectTotals();
            }
        }
        // ฟังก์ชันสำหรับบันทึกราคาขาย
        function saveGroupData() {
            // Calculate totals for all groups before saving
            for (let i = 1; i <= 4; i++) {
                calculateTotal(i);
            }
            updateCombinedTotal();
            updateProjectTotal();
            saveProjectTotals();

            let group1Data = [];
            let group4Data = [];

            // Get data from group 1
            document.querySelectorAll("#group1-items tr").forEach(row => {
                let item = {
                    name: row.querySelector(".item-name")?.value || "",
                    price: row.querySelector(".item-price")?.value || 0,
                    quantity: row.querySelector(".item-quantity")?.value || 0,
                    total: row.querySelector(".item-total")?.textContent || "0.00",
                    salesPrice: 0,
                    salesTotal: 0
                };
                group1Data.push(item);
            });

            // Get data from group 4 and combine into one item
            let group4Item = {
                name: "ค่าดำเนินการติดตั้ง",
                price: 0,
                quantity: 1,
                total: 0,
                salesPrice: 0,
                salesTotal: 0
            };

            document.querySelectorAll("#group4-items tr").forEach(row => {
                let price = parseFloat(row.querySelector(".item-price")?.value || 0);
                let total = parseFloat(row.querySelector(".item-total")?.textContent || "0.00");

                group4Item.price += price;
                group4Item.total += total;
            });

            group4Data.push(group4Item);

            // Save to localStorage
            localStorage.setItem("group1Data", JSON.stringify(group1Data));
            localStorage.setItem("group4Data", JSON.stringify(group4Data));
        }
        function saveSalesData() {
            const group1Data = JSON.parse(localStorage.getItem("group1Data")) || [];
            const group4Data = JSON.parse(localStorage.getItem("group4Data")) || [];

            // Save sales data for group 1
            document.querySelectorAll('#group1-summary tr').forEach((row, index) => {
                if (index < group1Data.length) {
                    const salesPriceInput = row.querySelector('.sales-price');
                    const salesTotalCell = row.querySelector('.sales-total');
                    if (salesPriceInput && salesTotalCell) {
                        group1Data[index].salesPrice = parseFloat(salesPriceInput.value) || 0;
                        group1Data[index].salesTotal = parseFloat(salesTotalCell.textContent.replace(/,/g, '')) || 0;
                    }
                }
            });

            // Save sales data for group 4
            document.querySelectorAll('#group4-summary tr').forEach((row, index) => {
                if (index < group4Data.length) {
                    const salesPriceInput = row.querySelector('.sales-price');
                    const salesTotalCell = row.querySelector('.sales-total');
                    if (salesPriceInput && salesTotalCell) {
                        group4Data[index].salesPrice = parseFloat(salesPriceInput.value) || 0;
                        group4Data[index].salesTotal = parseFloat(salesTotalCell.textContent.replace(/,/g, '')) || 0;
                    }
                }
            });

            // Update all totals
            updateGrandTotals();
            // Save updated data back to localStorage
            localStorage.setItem("group1Data", JSON.stringify(group1Data));
            localStorage.setItem("group4Data", JSON.stringify(group4Data));
        }
        function loadGroupData() {
            // ดึงข้อมูลจาก localStorage
            const group1Data = JSON.parse(localStorage.getItem("group1Data")) || [];
            const group4Data = JSON.parse(localStorage.getItem("group4Data")) || [];

            // สร้างแถวตารางสำหรับกลุ่ม 1
            const group1Summary = document.getElementById("group1-summary");
            let group1TotalCost = 0;
            let group1TotalSales = 0;

            group1Summary.innerHTML = group1Data.map((item, index) => {
                const cost = parseFloat(item.total);
                const quantity = parseFloat(item.quantity) || 0;
                const salesPrice = parseFloat(item.salesPrice) || 0;
                const salesTotal = quantity * salesPrice;  // คำนวณ salesTotal ใหม่จาก quantity และ salesPrice
                group1TotalCost += cost;
                group1TotalSales += salesTotal;
                const difference = salesTotal - cost;
                
                return `
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-3 border">${item.name}</td>
                        <td class="py-2 px-3 border">${quantity}</td>
                        <td class="py-2 px-3 border">${parseFloat(item.price).toLocaleString()}</td>
                        <td class="py-2 px-3 border">${cost.toLocaleString()}</td>
                        <td class="py-2 px-3 border">
                            <input type="number" 
                                class="sales-price w-full p-1 border rounded text-right" 
                                data-group="1" 
                                data-index="${index}" 
                                data-quantity="${quantity}"
                                value="${salesPrice}"
                                oninput="calculateSalesTotal(this)">
                        </td>
                        <td class="py-2 px-3 border sales-total font-semibold">
                            ${salesTotal.toLocaleString()}
                        </td>
                        <td class="py-2 px-3 border difference">${difference.toLocaleString()}</td>
                    </tr>
                `;
            }).join('');

            // สร้างแถวตารางสำหรับกลุ่ม 4
            const group4Summary = document.getElementById("group4-summary");
            let group4TotalCost = 0;
            let group4TotalSales = 0;

            group4Summary.innerHTML = group4Data.map((item, index) => {
                const cost = parseFloat(item.total);
                const quantity = parseFloat(item.quantity) || 0;
                const salesPrice = parseFloat(item.salesPrice) || 0;
                const salesTotal = quantity * salesPrice;  // คำนวณ salesTotal ใหม่จาก quantity และ salesPrice
                group4TotalCost += cost;
                group4TotalSales += salesTotal;
                const difference = salesTotal - cost;
                
                return `
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-3 border">${item.name}</td>
                        <td class="py-2 px-3 border">${quantity}</td>
                        <td class="py-2 px-3 border">${parseFloat(item.price).toLocaleString()}</td>
                        <td class="py-2 px-3 border">${cost.toLocaleString()}</td>
                        <td class="py-2 px-3 border">
                            <input type="number" 
                                class="sales-price w-full p-1 border rounded text-right" 
                                data-group="4" 
                                data-index="${index}" 
                                data-quantity="${quantity}"
                                value="${salesPrice}"
                                oninput="calculateSalesTotal(this)">
                        </td>
                        <td class="py-2 px-3 border sales-total font-semibold">
                            ${salesTotal.toLocaleString()}
                        </td>
                        <td class="py-2 px-3 border difference">${difference.toLocaleString()}</td>
                    </tr>
                `;
            }).join('');

            // แสดงยอดรวมทั้งหมด
            document.getElementById('group1-total-cost').textContent = group1TotalCost.toLocaleString();
            document.getElementById('group1-total-sales').textContent = group1TotalSales.toLocaleString();
            document.getElementById('group1-total-difference').textContent = (group1TotalSales - group1TotalCost).toLocaleString();

            document.getElementById('group4-total-cost').textContent = group4TotalCost.toLocaleString();
            document.getElementById('group4-total-sales').textContent = group4TotalSales.toLocaleString();
            document.getElementById('group4-total-difference').textContent = (group4TotalSales - group4TotalCost).toLocaleString();

            updateGrandTotals();
        }
        function calculateSalesTotal(input) {
            const row = input.closest('tr');
            const quantity = parseFloat(input.dataset.quantity);
            const salesPrice = parseFloat(input.value) || 0;
            const salesTotal = quantity * salesPrice;
            const cost = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace(/,/g, '')) || 0;
            const difference = salesTotal - cost;

            row.querySelector('.sales-total').textContent = salesTotal.toLocaleString();
            row.querySelector('.difference').textContent = difference.toLocaleString();
            
            updateGrandTotals();
            saveSalesData();
        }
        function updateGrandTotals() {
            // Get VAT rate
            const vatRate = parseFloat(document.getElementById('vat-rate').value) / 100;

            // Calculate base totals
            const group1Cost = parseFloat(document.getElementById('group1-total-cost').textContent.replace(/,/g, '')) || 0;
            const group4Cost = parseFloat(document.getElementById('group4-total-cost').textContent.replace(/,/g, '')) || 0;
            const grandTotalCost = group1Cost + group4Cost;

            let group1Sales = 0;
            let group4Sales = 0;
            
            document.querySelectorAll('#group1-summary .sales-total').forEach(cell => {
                group1Sales += parseFloat(cell.textContent.replace(/,/g, '')) || 0;
            });
            
            document.querySelectorAll('#group4-summary .sales-total').forEach(cell => {
                group4Sales += parseFloat(cell.textContent.replace(/,/g, '')) || 0;
            });

            const grandTotalSales = group1Sales + group4Sales;

            // Calculate VAT amounts
            const costVat = grandTotalCost * vatRate;
            const salesVat = grandTotalSales * vatRate;

            // Calculate totals with VAT
            const grandTotalCostWithVat = grandTotalCost + costVat;
            const grandTotalSalesWithVat = grandTotalSales + salesVat;

            // Calculate profits
            const totalProfit = grandTotalSales - grandTotalCost;
            const totalProfitWithVat = grandTotalSalesWithVat - grandTotalCostWithVat;

            // Calculate profit percentages
            const totalProfitPercentage = grandTotalCost !== 0 ? ((grandTotalSales * 100) / grandTotalCost) - 100 : 0;
            const totalProfitPercentageWithVat = grandTotalCostWithVat !== 0 ? 
                ((grandTotalSalesWithVat * 100) / grandTotalCostWithVat) - 100 : 0;

            // Update group totals (remain unchanged)
            const group1Difference = group1Sales - group1Cost;
            const group4Difference = group4Sales - group4Cost;
            
            document.getElementById('group1-total-sales').textContent = group1Sales.toLocaleString();
            document.getElementById('group4-total-sales').textContent = group4Sales.toLocaleString();
            document.getElementById('group1-total-difference').textContent = group1Difference.toLocaleString();
            document.getElementById('group4-total-difference').textContent = group4Difference.toLocaleString();

            // Update group profit percentages
            const group1ProfitPercentage = group1Cost !== 0 ? ((group1Sales * 100) / group1Cost) - 100 : 0;
            const group4ProfitPercentage = group4Cost !== 0 ? ((group4Sales * 100) / group4Cost) - 100 : 0;
            
            document.getElementById('group1-profit-percentage').textContent = group1ProfitPercentage.toFixed(2) + '%';
            document.getElementById('group4-profit-percentage').textContent = group4ProfitPercentage.toFixed(2) + '%';

            // Update all totals
            document.getElementById('grand-total-cost').textContent = grandTotalCost.toLocaleString() + ' บาท';
            document.getElementById('cost-vat').textContent = costVat.toLocaleString() + ' บาท';
            document.getElementById('grand-total-cost-with-vat').textContent = grandTotalCostWithVat.toLocaleString() + ' บาท';

            document.getElementById('grand-total-sales').textContent = grandTotalSales.toLocaleString() + ' บาท';
            document.getElementById('sales-vat').textContent = salesVat.toLocaleString() + ' บาท';
            document.getElementById('grand-total-sales-with-vat').textContent = grandTotalSalesWithVat.toLocaleString() + ' บาท';

            document.getElementById('total-profit').textContent = totalProfit.toLocaleString() + ' บาท';
            document.getElementById('total-profit-with-vat').textContent = totalProfitWithVat.toLocaleString() + ' บาท';
            document.getElementById('total-profit-percentage-with-vat').textContent = totalProfitPercentageWithVat.toFixed(2) + '%';
        }
        function saveProjectTotals() {
            const projectTotal = document.getElementById('project-total').textContent;
            const requestedBudget = document.getElementById('requested-budget').textContent;

            localStorage.setItem('projectTotal', projectTotal);
            localStorage.setItem('requestedBudget', requestedBudget);
        }

        function loadProjectTotals() {
            const projectTotal = localStorage.getItem('projectTotal') || '0.00';
            const requestedBudget = localStorage.getItem('requestedBudget') || '0.00';

            // You can add code here to populate the rental tabs with these values
            // For example:
            document.getElementById('investment-rental-total').textContent = projectTotal;
            document.getElementById('installation-rental-total').textContent = projectTotal;
            document.getElementById('investment-rental-budget').textContent = requestedBudget;
            document.getElementById('installation-rental-budget').textContent = requestedBudget;
        }
        // Update the HTML for investment-rental tab (inside the table tbody)
        document.querySelector('#investment-rental tbody').innerHTML = `
            <tr>
                <td class="py-2 px-3 border">รวมโครงการ</td>
                <td class="py-2 px-3 border">
                    <div id="investment-rental-total">0.00</div>
                </td>
                <td class="py-2 px-3 border">
                    <div id="investment-rental-budget">0.00</div>
                </td>
                <td class="py-2 px-3 border">
                    <input type="number" 
                        id="investment-monthly-fee" 
                        class="w-full p-1 border rounded" 
                        oninput="calculateInvestmentBreakeven()" 
                        placeholder="ระบุค่าบริการรายเดือน...">
                </td>
                <td class="py-2 px-3 border">
                    <input type="number" 
                        id="investment-billing-cycles" 
                        class="w-full p-1 border rounded" 
                        oninput="calculateInvestmentBreakeven()" 
                        placeholder="ระบุจำนวนรอบ...">
                </td>
                <td class="py-2 px-3 border">
                    <div id="investment-breakeven">0.00</div>
                </td>
            </tr>
        `;

        // Update the HTML for installation-rental tab (inside the table tbody)
        document.querySelector('#installation-rental tbody').innerHTML = `
            <tr>
                <td class="py-2 px-3 border">รวมโครงการ</td>
                <td class="py-2 px-3 border">
                    <div id="installation-rental-total">0.00</div>
                </td>
                <td class="py-2 px-3 border">
                    <div id="installation-rental-budget">0.00</div>
                </td>
                <td class="py-2 px-3 border">
                    <input type="number" 
                        id="installation-one-time-fee" 
                        class="w-full p-1 border rounded" 
                        oninput="calculateInstallationBreakeven()" 
                        placeholder="ระบุค่าดำเนินการ...">
                </td>
                <td class="py-2 px-3 border">
                    <input type="number" 
                        id="installation-monthly-fee" 
                        class="w-full p-1 border rounded" 
                        oninput="calculateInstallationBreakeven()" 
                        placeholder="ระบุค่าบริการรายเดือน...">
                </td>
                <td class="py-2 px-3 border">
                    <input type="number" 
                        id="installation-billing-cycles" 
                        class="w-full p-1 border rounded" 
                        oninput="calculateInstallationBreakeven()" 
                        placeholder="ระบุจำนวนรอบ...">
                </td>
                <td class="py-2 px-3 border">
                    <div id="installation-breakeven">0.00</div>
                </td>
            </tr>
        `;

        // Add calculation functions
        function calculateInvestmentBreakeven() {
            const budget = parseFloat(document.getElementById('investment-rental-budget').textContent.replace(/,/g, '')) || 0;
            const monthlyFee = parseFloat(document.getElementById('investment-monthly-fee').value) || 0;
            const billingCycles = parseFloat(document.getElementById('investment-billing-cycles').value) || 0;
            
            // Calculate summarized values
            const totalIncome = monthlyFee * billingCycles;
            let breakeven = 0;
            
            if (monthlyFee > 0) {
                breakeven = budget / monthlyFee;
            }
            
            // Update elements
            document.getElementById('investment-breakeven').textContent = breakeven.toFixed(2);
            document.getElementById('investment-rental-summarize').textContent = totalIncome.toLocaleString('en-US', { minimumFractionDigits: 2 });
            
            // Save to localStorage
            localStorage.setItem('investment-monthly-fee', monthlyFee);
            localStorage.setItem('investment-billing-cycles', billingCycles);
        }

        function calculateInstallationBreakeven() {
            const budget = parseFloat(document.getElementById('installation-rental-budget').textContent.replace(/,/g, '')) || 0;
            const oneTimeFee = parseFloat(document.getElementById('installation-one-time-fee').value) || 0;
            const monthlyFee = parseFloat(document.getElementById('installation-monthly-fee').value) || 0;
            const billingCycles = parseFloat(document.getElementById('installation-billing-cycles').value) || 0;
            
            // Calculate summarized values
            const monthlyIncome = monthlyFee * billingCycles;
            const totalIncome = oneTimeFee + monthlyIncome;
            let breakeven = 0;
            
            if (monthlyFee > 0) {
                breakeven = (budget - oneTimeFee) / monthlyFee;
            }
            
            // Update elements
            document.getElementById('installation-breakeven').textContent = breakeven.toFixed(2);
            document.getElementById('installation-rental-onetime').textContent = oneTimeFee.toLocaleString('en-US', { minimumFractionDigits: 2 });
            document.getElementById('installation-rental-allmonthly').textContent = monthlyIncome.toLocaleString('en-US', { minimumFractionDigits: 2 });
            document.getElementById('installation-rental-summarize').textContent = totalIncome.toLocaleString('en-US', { minimumFractionDigits: 2 });
            
            // Save to localStorage
            localStorage.setItem('installation-one-time-fee', oneTimeFee);
            localStorage.setItem('installation-monthly-fee', monthlyFee);
            localStorage.setItem('installation-billing-cycles', billingCycles);
        }


        // Modify loadProjectTotals to include loading saved values
        function loadProjectTotals() {
            const projectTotal = localStorage.getItem('projectTotal') || '0.00';
            const requestedBudget = localStorage.getItem('requestedBudget') || '0.00';

            // Load values for investment rental
            const investmentMonthly = parseFloat(localStorage.getItem('investment-monthly-fee')) || 0;
            const investmentCycles = parseFloat(localStorage.getItem('investment-billing-cycles')) || 0;
            document.getElementById('investment-rental-summarize').textContent = (investmentMonthly * investmentCycles).toLocaleString('en-US', { minimumFractionDigits: 2 });
            document.getElementById('investment-rental-total').textContent = projectTotal;
            document.getElementById('investment-rental-budget').textContent = requestedBudget;
            document.getElementById('investment-monthly-fee').value = localStorage.getItem('investment-monthly-fee') || '';
            document.getElementById('investment-billing-cycles').value = localStorage.getItem('investment-billing-cycles') || '';
            calculateInvestmentBreakeven();

            // Load values for installation rental
            const installOneTime = parseFloat(localStorage.getItem('installation-one-time-fee')) || 0;
            const installMonthly = parseFloat(localStorage.getItem('installation-monthly-fee')) || 0;
            const installCycles = parseFloat(localStorage.getItem('installation-billing-cycles')) || 0;
            document.getElementById('installation-rental-onetime').textContent = installOneTime.toLocaleString('en-US', { minimumFractionDigits: 2 });
            document.getElementById('installation-rental-allmonthly').textContent = (installMonthly * installCycles).toLocaleString('en-US', { minimumFractionDigits: 2 });
            document.getElementById('installation-rental-summarize').textContent = (installOneTime + (installMonthly * installCycles)).toLocaleString('en-US', { minimumFractionDigits: 2 });
            document.getElementById('installation-rental-total').textContent = projectTotal;
            document.getElementById('installation-rental-budget').textContent = requestedBudget;
            document.getElementById('installation-one-time-fee').value = localStorage.getItem('installation-one-time-fee') || '';
            document.getElementById('installation-monthly-fee').value = localStorage.getItem('installation-monthly-fee')     || '';
            document.getElementById('installation-billing-cycles').value = localStorage.getItem('installation-billing-cycles') || '';
            calculateInstallationBreakeven();
        }
        window.onload = function() {
            // Clear all localStorage data
            localStorage.removeItem('group1Data');
            localStorage.removeItem('group4Data');
            localStorage.removeItem('projectTotal');
            localStorage.removeItem('requestedBudget');
            localStorage.removeItem('investment-monthly-fee');
            localStorage.removeItem('investment-billing-cycles');
            localStorage.removeItem('installation-one-time-fee');
            localStorage.removeItem('installation-monthly-fee');
            localStorage.removeItem('installation-billing-cycles');

            // Reset all form fields and calculated values
            resetAllForms();
        };

        function resetAllForms() {
            // Reset quote form
            for (let i = 1; i <= 4; i++) {
                const itemsContainer = document.getElementById(`group${i}-items`);
                if (itemsContainer) {
                    itemsContainer.innerHTML = '';
                }
                
                const totalElement = document.getElementById(`group${i}-total`);
                if (totalElement) {
                    totalElement.textContent = '0.00';
                }
            }

            // Reset combined total
            const combinedTotal = document.getElementById('combined-total');
            if (combinedTotal) {
                combinedTotal.textContent = '0.00';
            }

            // Reset project totals
            const projectTotal = document.getElementById('project-total');
            if (projectTotal) {
                projectTotal.textContent = '0.00';
            }

            const requestedBudget = document.getElementById('requested-budget');
            if (requestedBudget) {
                requestedBudget.textContent = '0.00';
            }

            // Reset summary tab
            const summaryElements = [
                'group1-total-cost', 'group1-total-sales', 'group1-total-difference',
                'group4-total-cost', 'group4-total-sales', 'group4-total-difference',
                'group1-profit-percentage', 'group4-profit-percentage',
                'grand-total-cost', 'cost-vat', 'grand-total-cost-with-vat',
                'grand-total-sales', 'sales-vat', 'grand-total-sales-with-vat',
                'total-profit', 'total-profit-with-vat', 'total-profit-percentage-with-vat'
            ];

            summaryElements.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = '0.00';
                }
            });

            // Reset VAT rate to default
            const vatRate = document.getElementById('vat-rate');
            if (vatRate) {
                vatRate.value = '7';
            }

            // Reset customer select
            const customerSelect = document.getElementById('customer-select');
            if (customerSelect) {
                customerSelect.value = '';
            }

            // Reset project name
            const projectName = document.getElementById('project-name');
            if (projectName) {
                projectName.value = '';
            }

            // Reset investment rental tab
            const investmentElements = {
                'investment-rental-total': '0.00',
                'investment-rental-budget': '0.00',
                'investment-monthly-fee': '',
                'investment-billing-cycles': '',
                'investment-breakeven': '0.00'
            };

            Object.entries(investmentElements).forEach(([id, value]) => {
                const element = document.getElementById(id);
                if (element) {
                    if (element.tagName === 'INPUT') {
                        element.value = value;
                    } else {
                        element.textContent = value;
                    }
                }
            });

            // Reset installation rental tab
            const installationElements = {
                'installation-rental-total': '0.00',
                'installation-rental-budget': '0.00',
                'installation-one-time-fee': '',
                'installation-monthly-fee': '',
                'installation-billing-cycles': '',
                'installation-breakeven': '0.00'
            };

            Object.entries(installationElements).forEach(([id, value]) => {
                const element = document.getElementById(id);
                if (element) {
                    if (element.tagName === 'INPUT') {
                        element.value = value;
                    } else {
                        element.textContent = value;
                    }
                }
            });

            // Reset summary tables
            const group1Summary = document.getElementById('group1-summary');
            const group4Summary = document.getElementById('group4-summary');
            if (group1Summary) group1Summary.innerHTML = '';
            if (group4Summary) group4Summary.innerHTML = '';
        }
        function addServiceRow(tableId) {
            const tbody = document.querySelector(`#${tableId} tbody`);
            const newRow = `
                <tr class="service-row">
                    <td class="py-2 px-3 border">
                        <input type="text" class="w-full p-1 border rounded promotion-name" placeholder="ชื่อโปรโมชั่น/แพ็คเกจ">
                    </td>
                    <td class="py-2 px-3 border">
                        <input type="number" class="w-full p-1 border rounded monthly-service-fee" placeholder="ค่าบริการรายเดือน" oninput="calculateServiceIncome(this)">
                    </td>
                    <td class="py-2 px-3 border">
                        <input type="number" class="w-full p-1 border rounded other-services-fee" placeholder="ค่าบริการอื่นๆ" oninput="calculateServiceIncome(this)">
                    </td>
                    <td class="py-2 px-3 border">
                        <input type="number" class="w-full p-1 border rounded ict-ma-base-fee" placeholder="ค่าเช่า ICT&MA ขั้นต่ำ" oninput="calculateServiceIncome(this)">
                    </td>
                    <td class="py-2 px-3 border">
                        <input type="number" class="w-full p-1 border rounded ict-ma-additional-fee" placeholder="ค่าเช่าเพิ่มตามดุลพินิจ" oninput="calculateServiceIncome(this)">
                    </td>
                    <td class="py-2 px-3 border service-income">0.00</td>
                    <td class="py-2 px-3 border">
                        <button onclick="removeServiceRow(this)" class="text-red-500"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', newRow);
        }

        function calculateServiceIncome(input) {
            const row = input.closest('tr');
            
            // Get input values
            const monthlyServiceFee = parseFloat(row.querySelector('.monthly-service-fee').value) || 0;
            const otherServicesFee = parseFloat(row.querySelector('.other-services-fee').value) || 0;
            const ictMaBaseFee = parseFloat(row.querySelector('.ict-ma-base-fee').value) || 0;
            const ictMaAdditionalFee = parseFloat(row.querySelector('.ict-ma-additional-fee').value) || 0;
            
            // Calculate total service income
            const serviceIncome = monthlyServiceFee + otherServicesFee + ictMaBaseFee + ictMaAdditionalFee;
            
            // Update service income cell
            row.querySelector('.service-income').textContent = serviceIncome.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function removeServiceRow(button) {
            const row = button.closest('tr');
            row.remove();
        }

        // Add event listeners to existing service rows
        function attachServiceRowListeners() {
            document.querySelectorAll('.service-row input').forEach(input => {
                input.addEventListener('input', function() {
                    calculateServiceIncome(this);
                });
            });
        }
        function populateSummarizeTab() {
            // Clear existing content
            const summarizeTab = document.getElementById('summarize');
            summarizeTab.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">สรุปผล</h2>
                    <button onclick="exportAllToExcel()" 
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg flex items-center">
                        <i class="fas fa-file-excel mr-2"></i>Export ข้อมูลทั้งหมดเป็น Excel
                    </button>
                </div>
                <!-- Sales Summary (Sell Outright ISI) -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h3 class="text-xl font-semibold mb-4">สรุปผลขายขาด ISI</h3>
                    <table class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-3 border">รายการ</th>
                                <th class="py-2 px-3 border">มูลค่า (บาท)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-3 border">รวมยอดขาย (ก่อน VAT)</td>
                                <td id="summarize-total-sales" class="py-2 px-3 border text-right"></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-3 border">VAT ขาย</td>
                                <td id="summarize-sales-vat" class="py-2 px-3 border text-right"></td>
                            </tr>
                            <tr class="font-bold bg-gray-50">
                                <td class="py-2 px-3 border">รวมยอดขายทั้งหมด (รวม VAT)</td>
                                <td id="summarize-total-sales-with-vat" class="py-2 px-3 border text-right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Investment Rental Summary -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h3 class="text-xl font-semibold mb-4">สรุปผลเช่า (ลงทุน)</h3>
                    <table id="summarize-investment-rental" class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-3 border">รายการโปรโมชั่น</th>
                                <th class="py-2 px-3 border">รายได้ขั้นค่าบริการ (บาท/เดือน)</th>
                                <th class="py-2 px-3 border">VAT</th>
                                <th class="py-2 px-3 border">รายได้รวม VAT</th>
                            </tr>
                        </thead>
                        <tbody id="summarize-investment-rental-body">
                            <!-- Rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>

                <!-- Installation Rental Summary -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">สรุปผลเช่า (เก็บค่าติดตั้ง)</h3>
                    <table id="summarize-installation-rental" class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-3 border">รายการโปรโมชั่น</th>
                                <th class="py-2 px-3 border">รายได้ขั้นค่าบริการ (บาท/เดือน)</th>
                                <th class="py-2 px-3 border">VAT</th>
                                <th class="py-2 px-3 border">รายได้รวม VAT</th>
                            </tr>
                        </thead>
                        <tbody id="summarize-installation-rental-body">
                            <!-- Rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>
            `;
        }

        function updateSummarizeTab() {
            const vatRate = parseFloat(document.getElementById('vat-rate').value) / 100;
            // Update sales summary
            const grandTotalSales = document.getElementById('grand-total-sales').textContent;
            const salesVat = document.getElementById('sales-vat').textContent;
            const grandTotalSalesWithVat = document.getElementById('grand-total-sales-with-vat').textContent;

            document.getElementById('summarize-total-sales').textContent = grandTotalSales;
            document.getElementById('summarize-sales-vat').textContent = salesVat;
            document.getElementById('summarize-total-sales-with-vat').textContent = grandTotalSalesWithVat;

            // Populate Investment Rental Services
            const investmentRentalBody = document.getElementById('summarize-investment-rental-body');
            investmentRentalBody.innerHTML = '';
            document.querySelectorAll('#investment-rentals .service-row').forEach(row => {
                const promotionName = row.querySelector('.promotion-name').value;
                const serviceIncome = parseFloat(row.querySelector('.service-income').textContent.replace(/,/g, '')) || 0;
                
                // Calculate VAT
                const serviceVat = serviceIncome * vatRate;
                const serviceIncomeWithVat = serviceIncome + serviceVat;
                
                if (promotionName) {
                    investmentRentalBody.innerHTML += `
                        <tr>
                            <td class="py-2 px-3 border">${promotionName}</td>
                            <td class="py-2 px-3 border text-right">${serviceIncome.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                            <td class="py-2 px-3 border text-right">${serviceVat.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                            <td class="py-2 px-3 border text-right">${serviceIncomeWithVat.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        </tr>
                    `;
                }
            });

            // Populate Installation Rental Services
            const installationRentalBody = document.getElementById('summarize-installation-rental-body');
            installationRentalBody.innerHTML = '';
            document.querySelectorAll('#installation-rentals .service-row').forEach(row => {
                const promotionName = row.querySelector('.promotion-name').value;
                const serviceIncome = parseFloat(row.querySelector('.service-income').textContent.replace(/,/g, '')) || 0;
                
                // Calculate VAT
                const serviceVat = serviceIncome * vatRate;
                const serviceIncomeWithVat = serviceIncome + serviceVat;
                
                if (promotionName) {
                    installationRentalBody.innerHTML += `
                        <tr>
                            <td class="py-2 px-3 border">${promotionName}</td>
                            <td class="py-2 px-3 border text-right">${serviceIncome.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                            <td class="py-2 px-3 border text-right">${serviceVat.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                            <td class="py-2 px-3 border text-right">${serviceIncomeWithVat.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        </tr>
                    `;
                }
            });
        }
        // Call this when the page loads
        window.addEventListener('DOMContentLoaded', attachServiceRowListeners);
        window.addEventListener('DOMContentLoaded', populateSummarizeTab)
        

        function exportAllToExcel() {
            const wb = XLSX.utils.book_new();
            
            // Get project info
            const customerName = document.querySelector('#customer-select option:checked')?.text || 'N/A';
            const projectName = document.getElementById('project-name').value || 'N/A';

            // 1. Create Investment Budget Sheet (งบประมาณการลงทุน)
            const investmentData = [
                ['ข้อมูลโครงการ'],
                ['ลูกค้า:', customerName],
                ['โครงการ:', projectName],
                [''],
                ['รายละเอียดประมาณการต้นทุนค่าอุปกรณ์ Solution'],
                ['รายการ', 'ราคาต่อหน่วย (บาท)', 'จำนวน (หน่วย)', 'หมายเหตุ', 'เป็นเงินบาท (ไม่รวม VAT)']
            ];

            // Add items from each group
            for (let groupId = 1; groupId <= 4; groupId++) {
                const groupName = groupId <= 3 ? 
                    ['ค่าอุปกรณ์ Solution ใหม่', 'ค่าอุปกรณ์ทดแทน Solution เดิม', 'ค่าอุปกรณ์ Solution เดิม'][groupId - 1] 
                    : 'ต้นทุนการดำเนินการ';
                
                investmentData.push(['']);
                investmentData.push([`กลุ่ม ${groupName}`]);
                
                document.querySelectorAll(`#group${groupId}-items tr`).forEach(row => {
                    investmentData.push([
                        row.querySelector('.item-name')?.value || '',
                        row.querySelector('.item-price')?.value || '',
                        row.querySelector('.item-quantity')?.value || '',
                        row.querySelector('input[placeholder="หมายเหตุ..."]')?.value || '',
                        row.querySelector('.item-total')?.textContent || ''
                    ]);
                });
                
                investmentData.push([
                    `รวมกลุ่ม ${groupName}`,
                    '',
                    '',
                    '',
                    document.getElementById(`group${groupId}-total`)?.textContent || '0.00'
                ]);
            }

            investmentData.push(['']);
            investmentData.push([
                'ต้นทุนรวมโครงการทั้งโครงการ',
                '',
                '',
                '',
                document.getElementById('project-total').textContent
            ]);
            investmentData.push([
                'งบประมาณที่ขอใช้',
                '',
                '',
                '',
                document.getElementById('requested-budget').textContent
            ]);

            // 2. Create Sales Summary Sheet (ขายขาด ISI)
            const salesData = [
                ['สรุปรายการขายขาด ISI'],
                [''],
                ['ค่าอุปกรณ์ Solution ใหม่'],
                ['รายการ', 'จำนวน', 'ราคาทุนต่อหน่วย', 'รวมต้นทุน', 'ราคาขายต่อหน่วย', 'รวมขาย', 'ผลต่าง']
            ];

            // Add Group 1 sales data
            document.querySelectorAll('#group1-summary tr').forEach(row => {
                salesData.push([
                    row.cells[0]?.textContent || '',
                    row.cells[1]?.textContent || '',
                    row.cells[2]?.textContent || '',
                    row.cells[3]?.textContent || '',
                    row.querySelector('.sales-price')?.value || '',
                    row.querySelector('.sales-total')?.textContent || '',
                    row.querySelector('.difference')?.textContent || ''
                ]);
            });

            salesData.push(['']);
            salesData.push(['ต้นทุนการดำเนินการ']);
            salesData.push(['รายการ', 'จำนวน', 'ราคาทุนต่อหน่วย', 'รวมต้นทุน', 'ราคาขายต่อหน่วย', 'รวมขาย', 'ผลต่าง']);

            // Add Group 4 sales data
            document.querySelectorAll('#group4-summary tr').forEach(row => {
                salesData.push([
                    row.cells[0]?.textContent || '',
                    row.cells[1]?.textContent || '',
                    row.cells[2]?.textContent || '',
                    row.cells[3]?.textContent || '',
                    row.querySelector('.sales-price')?.value || '',
                    row.querySelector('.sales-total')?.textContent || '',
                    row.querySelector('.difference')?.textContent || ''
                ]);
            });

            // Add VAT summary
            salesData.push(['']);
            salesData.push(['สรุปยอดรวม']);
            salesData.push(['รายการ', 'มูลค่า']);
            salesData.push([''])
            salesData.push(['รวมต้นทุน (ก่อน VAT)', document.getElementById('grand-total-cost').textContent]);
            salesData.push(['VAT ทุน', document.getElementById('cost-vat').textContent]);
            salesData.push(['รวมต้นทุนทั้งหมด (รวม VAT)', document.getElementById('grand-total-cost-with-vat').textContent]);
            salesData.push([''])
            salesData.push(['รวมยอดขาย (ก่อน VAT)', document.getElementById('grand-total-sales').textContent]);
            salesData.push(['VAT ขาย', document.getElementById('sales-vat').textContent]);
            salesData.push(['รวมยอดขายทั้งหมด (รวม VAT)', document.getElementById('grand-total-sales-with-vat').textContent]);
            salesData.push([''])
            salesData.push(['กำไรขั้นต้น (ก่อน VAT)', document.getElementById('total-profit').textContent]);
            salesData.push(['กำไรขั้นต้น (รวม VAT)', document.getElementById('total-profit-with-vat').textContent]);
            salesData.push(['% กำไร', document.getElementById('total-profit-percentage-with-vat').textContent]);

            // 3. Create Investment Rental Sheet (เช่า-ลงทุนเอง)
            const investmentRentalData = [
                ['แบบเช่า (ลงทุนเอง)'],
                [''],
                ['รวมโครงการ'],
                ['รายการ', 'รวมต้นทุนโครงการ', 'งบประมาณที่ขอใช้', 'ค่าบริการรายเดือน', 'จำนวนรอบบิล', 'จุดคุ้มทุน (เดือน)'],
                [
                    'รวมโครงการ',
                    document.getElementById('investment-rental-total').textContent,
                    document.getElementById('investment-rental-budget').textContent,
                    document.getElementById('investment-monthly-fee').value,
                    document.getElementById('investment-billing-cycles').value,
                    document.getElementById('investment-breakeven').textContent
                ],
                [''],
                ['อัตราค่าบริการและปันส่วนรายได้ (รายเดือน)'],
                ['รายการโปรโมชั่น/แพ็คเกจ', 'ค่าบริการรายเดือน', 'ค่าบริการอื่นๆ', 'ค่าเช่า ICT&MA ขั้นต่ำ', 'ค่าเช่าเพิ่ม', 'รายได้รวม']
            ];

            // Add investment rental services
            document.querySelectorAll('#investment-rentals .service-row').forEach(row => {
                investmentRentalData.push([
                    row.querySelector('.promotion-name').value || '',
                    row.querySelector('.monthly-service-fee').value || '',
                    row.querySelector('.other-services-fee').value || '',
                    row.querySelector('.ict-ma-base-fee').value || '',
                    row.querySelector('.ict-ma-additional-fee').value || '',
                    row.querySelector('.service-income').textContent || ''
                ]);
            });

            // 4. Create Installation Rental Sheet (เช่า-เก็บค่าติดตั้ง)
            const installationRentalData = [
                ['แบบเช่า (เก็บค่าติดตั้ง)'],
                [''],
                ['รวมโครงการ'],
                ['รายการ', 'รวมต้นทุนโครงการ', 'งบประมาณที่ขอใช้', 'ค่าดำเนินการ', 'ค่าบริการรายเดือน', 'จำนวนรอบบิล', 'จุดคุ้มทุน (เดือน)'],
                [
                    'รวมโครงการ',
                    document.getElementById('installation-rental-total').textContent,
                    document.getElementById('installation-rental-budget').textContent,
                    document.getElementById('installation-one-time-fee').value,
                    document.getElementById('installation-monthly-fee').value,
                    document.getElementById('installation-billing-cycles').value,
                    document.getElementById('installation-breakeven').textContent
                ],
                [''],
                ['อัตราค่าบริการและปันส่วนรายได้ (รายเดือน)'],
                ['รายการโปรโมชั่น/แพ็คเกจ', 'ค่าบริการรายเดือน', 'ค่าบริการอื่นๆ', 'ค่าเช่า ICT&MA ขั้นต่ำ', 'ค่าเช่าเพิ่ม', 'รายได้รวม']
            ];

            // Add installation rental services
            document.querySelectorAll('#installation-rentals .service-row').forEach(row => {
                installationRentalData.push([
                    row.querySelector('.promotion-name').value || '',
                    row.querySelector('.monthly-service-fee').value || '',
                    row.querySelector('.other-services-fee').value || '',
                    row.querySelector('.ict-ma-base-fee').value || '',
                    row.querySelector('.ict-ma-additional-fee').value || '',
                    row.querySelector('.service-income').textContent || ''
                ]);
            });

            // 5. Create Summary Sheet (สรุปผล)
            const summaryData = [
                ['สรุปผลโครงการ'],
                [''],
                ['สรุปผลขายขาด ISI'],
                ['รายการ', 'มูลค่า (บาท)'],
                ['รวมยอดขาย (ก่อน VAT)', document.getElementById('summarize-total-sales').textContent],
                ['VAT ขาย', document.getElementById('summarize-sales-vat').textContent],
                ['รวมยอดขายทั้งหมด (รวม VAT)', document.getElementById('summarize-total-sales-with-vat').textContent],
                [''],
                ['สรุปผลเช่า (ลงทุน)'],
                ['รายการโปรโมชั่น', 'รายได้ขั้นค่าบริการ (บาท/เดือน)', 'VAT', 'รายได้รวม VAT']
            ];

            // Add investment rental summary
            document.querySelectorAll('#summarize-investment-rental-body tr').forEach(row => {
                summaryData.push([
                    row.cells[0].textContent,
                    row.cells[1].textContent,
                    row.cells[2].textContent,
                    row.cells[3].textContent
                ]);
            });

            summaryData.push(['']);
            summaryData.push(['สรุปผลเช่า (เก็บค่าติดตั้ง)'],['รายการโปรโมชั่น', 'รายได้ขั้นค่าบริการ (บาท/เดือน)', 'VAT', 'รายได้รวม VAT']);

            // Add installation rental summary
            document.querySelectorAll('#summarize-installation-rental-body tr').forEach(row => {
                summaryData.push([
                    row.cells[0].textContent,
                    row.cells[1].textContent,
                    row.cells[2].textContent,
                    row.cells[3].textContent
                ]);
            });

            // Create worksheets with array data
            const wsInvestment = XLSX.utils.aoa_to_sheet(investmentData);
            const wsSales = XLSX.utils.aoa_to_sheet(salesData);
            const wsInvestmentRental = XLSX.utils.aoa_to_sheet(investmentRentalData);
            const wsInstallationRental = XLSX.utils.aoa_to_sheet(installationRentalData);
            const wsSummary = XLSX.utils.aoa_to_sheet(summaryData);

            // Add column widths and cell styles
            const worksheets = {
                'งบประมาณการลงทุน': wsInvestment,
                'ขายขาด ISI': wsSales,
                'เช่า (ลงทุนเอง)': wsInvestmentRental,
                'เช่า (เก็บค่าติดตั้ง)': wsInstallationRental,
                'สรุปผล': wsSummary
            };

            // Apply formatting to all worksheets
            Object.entries(worksheets).forEach(([name, ws]) => {
                // Set column widths
                const cols = [];
                for (let i = 0; i < 10; i++) {
                    cols.push({ wch: 20 }); // Set default width for all columns
                }
                ws['!cols'] = cols;

                // Add worksheets to workbook
                XLSX.utils.book_append_sheet(wb, ws, name);
            });

            // Generate Excel file with current date and customer name
            const date = new Date().toISOString().split('T')[0];
            const fileName = `quotation_${customerName}_${date}.xlsx`;
            XLSX.writeFile(wb, fileName);
        }

        // Add export button when the page loads
        window.addEventListener('DOMContentLoaded', addExportButton);
    </script>
</body>
</html>