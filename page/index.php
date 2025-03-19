<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/config.php';
require_once '../function/functions.php';
// ดึงบิลทั้งหมด
$sql_all = "
    SELECT bc.number_bill, bc.end_date, bc.type_bill, bc.status_bill, c.name_customer, c.phone_customer 
    FROM bill_customer bc
    JOIN customers c ON bc.id_customer = c.id_customer
";
$result_all = $conn->query($sql_all);
$bills_all = [];
if ($result_all->num_rows > 0) {
    while ($row = $result_all->fetch_assoc()) {
        $bills_all[] = $row;
    }
}
// ดึงบิลที่หมดอายุใน 60 วัน
$sql_near_expiry = "
    SELECT bc.number_bill, bc.end_date, bc.type_bill, bc.status_bill, c.name_customer, c.phone_customer 
    FROM bill_customer bc
    JOIN customers c ON bc.id_customer = c.id_customer
    WHERE bc.end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 60 DAY)
";
$result_near_expiry = $conn->query($sql_near_expiry);

$bills_near_expiry = [];
if ($result_near_expiry->num_rows > 0) {
    while ($row = $result_near_expiry->fetch_assoc()) {
        $bills_near_expiry[] = $row;
    }
}
// Get tasks for the logged-in user
$user_id = $_SESSION['user_id']; // Assuming you store user_id in session
$task_sql = "
    SELECT DISTINCT t.* 
    FROM task t
    JOIN task_group tg ON t.id_task = tg.task_id
    WHERE tg.user_id = ?
";
$stmt = $conn->prepare($task_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$task_result = $stmt->get_result();

$tasks = [];
if ($task_result->num_rows > 0) {
    while ($row = $task_result->fetch_assoc()) {
        // Only add task if it's not already in the tasks array
        $tasks[] = $row;
    }
}
if (isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);

    // ดึงข้อมูล task จากฐานข้อมูล
    $task_sql = "SELECT * FROM task WHERE id_task = ?";
    $stmt = $conn->prepare($task_sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $task_result = $stmt->get_result();

    if ($task_result->num_rows > 0) {
        $task = $task_result->fetch_assoc();
    }
}
$limit = 3;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แดชบอร์ด</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #ffffff;
            color: #333333;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: auto;
            text-align: center;
        }
        .calendar-section {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        #calendar {
            max-width: 100%;
            height: 100%;
            margin: 0 auto;
        }
        .main-content {
            display: flex;
            flex-direction: row;
            gap: 20px;
            padding: 20px;
        }
        .timeline-section {
            flex: 2;
        }
        .calendar-section {
            flex: 1;
        }
        charts-container .chart-card {
            cursor: pointer;
            transition: transform 0.5s ease;
        }
        .charts-container .chart-card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <?php include './components/navbar.php'; ?>
    <?php include './components/index_manual.php'; ?>
    <!-- ปุ่มเปิดคู่มือ -->
    <button id="manualButton" class="fixed right-4 top-20 bg-blue-500 text-white px-3 py-2 rounded-md z-50 flex items-center group transition-all duration-300 w-10 hover:w-24 overflow-hidden">
        <i class="fas fa-question-circle text-xl"></i>
        <span class="ml-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">คู่มือ</span>
    </button>
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 main-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="col-span-1 lg:col-span-2">
                <!-- Hero Section -->
                <div class="bg-white text-gray-800 py-12 rounded-xl shadow-lg mb-6">
                    <div class="container mx-auto px-4">
                        <h1 class="text-3xl md:text-4xl font-bold mb-4">ยินดีต้อนรับ, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
                        <p class="text-lg text-gray-500 leading-relaxed font-light max-w-3xl">
                            ยินดีต้อนรับสู่แดชบอร์ดของระบบจัดการลูกค้าและการเงิน แดชบอร์ดนี้ออกแบบมาเพื่อช่วยให้คุณสามารถติดตามข้อมูลสำคัญเกี่ยวกับลูกค้า บิล และงานต่างๆ ได้อย่างง่ายดาย คู่มือนี้จะแนะนำฟีเจอร์หลักและวิธีการใช้งานต่างๆ เพื่อให้คุณใช้งานระบบได้อย่างมีประสิทธิภาพสูงสุด
                        </p>
                    </div>
                </div>
                <!-- Charts Section -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-yellow-400">
                    <?php include './components/charts.php'; ?>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-span-1 space-y-6">
                <!-- Calendar Section -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">ปฏิทิน</h2>
                        <button onclick="openTaskModal()" class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-lg transition-all">
                            <i class="fas fa-plus mr-2"></i>เพิ่มงานใหม่
                        </button>
                    </div>
                    <div id="calendar" class="w-full"></div>
                </div>

                <!-- Tasks Section -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="border-b-2 border-yellow-400 pb-2 mb-4">
                        <h3 class="text-xl font-bold text-gray-800">งานล่าสุด</h3>
                    </div>
                    <div class="space-y-4">
                        <?php if (!empty($tasks)): ?>
                            <?php $page = $_GET['task_page'] ?? 1;
                            $tasksToShow = array_slice($tasks, ($page - 1) * $limit, $limit);?>
                            
                            <?php foreach ($tasksToShow as $veiwtask): ?>
                                <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-yellow-400 hover:bg-gray-100 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($veiwtask['name_task']); ?></h4>
                                            <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($veiwtask['detail_task']); ?></p>
                                        </div>
                                        <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full"><?php echo date('d/m/Y', strtotime($veiwtask['end_date'])); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Pagination -->
                            <?php if (count($tasks) > $limit): ?>
                            <div class="flex justify-center gap-2 mt-4">
                                <a href="?task_page=<?php echo max(1, $page - 1); ?>" class="...">
                                <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="?task_page=<?php echo min(ceil(count($tasks) / $limit), $page + 1); ?>" class="...">
                                <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center py-4 text-gray-500">
                                <i class="fas fa-tasks fa-2x mb-2"></i>
                                <p>ไม่มีงานในขณะนี้</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Bills Section -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="border-b-2 border-red-400 pb-2 mb-4">
                        <h3 class="text-xl font-bold text-gray-800">บิลใกล้หมดสัญญา</h3>
                    </div>
                    <div class="space-y-4">
                        <?php if (!empty($bills_near_expiry)): ?>
                            <?php $billPage = $_GET['bill_page'] ?? 1;
                                $billsToShow = array_slice($bills_near_expiry, ($billPage - 1) * $limit, $limit); ?>
                            
                            <?php foreach ($billsToShow as $bill): ?>
                                <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500 hover:bg-red-100 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold text-red-800">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                                <?php echo htmlspecialchars($bill['number_bill']); ?>
                                            </h4>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <?php echo htmlspecialchars($bill['name_customer']); ?> · 
                                                <?php echo htmlspecialchars($bill['type_bill']); ?>
                                            </p>
                                        </div>
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full"><?php echo date('d/m/Y', strtotime($bill['end_date'])); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Pagination -->
                            <?php if (count($bills_near_expiry) > $limit): ?>
                            <div class="flex justify-center gap-2 mt-4">
                                <a href="?bill_page=<?php echo max(1, $billPage - 1); ?>" class="...">
                                <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="?bill_page=<?php echo min(ceil(count($bills_near_expiry) / $limit), $billPage + 1); ?>" class="...">
                                <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center py-4 text-gray-500">
                                <i class="fas fa-file-invoice fa-2x mb-2"></i>
                                <p>ไม่มีบิลใกล้หมดสัญญา</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include Modal -->
    <?php include './components/info_calender.php'; ?>
    <?php include './components/info_task.php'; ?>
    <?php include './components/task_modal.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($task)): ?>
                // แสดง modal info_task
                document.getElementById('taskDetailModal').classList.remove('hidden');
                document.getElementById('taskTitle').innerText = 'หัวข้อ: ' + '<?php echo htmlspecialchars($task['name_task']); ?>';
                document.getElementById('taskDetail').innerText = 'รายละเอียด: ' + '<?php echo htmlspecialchars($task['detail_task']); ?>';
                document.getElementById('taskDates').innerText = 'วันที่เริ่ม: ' + '<?php echo $task['start_date']; ?>' + 
                                                                '\nวันที่สิ้นสุด: ' + '<?php echo $task['end_date']; ?>';
            <?php endif; ?>
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    // Bill events
                    <?php foreach ($bills_all as $bill): ?>
                    {
                        title: 'หมดสัญญาบิล',
                        start: '<?php echo $bill['end_date']; ?>',
                        backgroundColor: '#FF5722',
                        extendedProps: {
                            type: 'bill',
                            phone: '<?php echo htmlspecialchars($bill['phone_customer']); ?>',
                            billnum: '<?php echo $bill['number_bill']; ?>',
                            billtype: '<?php echo $bill['type_bill']; ?>',
                            customername: '<?php echo htmlspecialchars($bill['name_customer']); ?>',
                            billstatus: '<?php echo htmlspecialchars($bill['status_bill']); ?>'
                        }
                    },
                    <?php endforeach; ?>
                    
                    // Task events
                    <?php foreach ($tasks as $task): ?>
                    {
                        title: '<?php echo htmlspecialchars($task['name_task']); ?>',
                        start: '<?php echo $task['start_date']; ?>',
                        end: '<?php echo $task['end_date']; ?>',
                        extendedProps: {
                            type: 'task',
                            detail: '<?php echo htmlspecialchars($task['detail_task']); ?>',
                            reminder: '<?php echo $task['reminder_date']; ?>',
                            task_id: '<?php echo $task['id_task']; ?>' // เพิ่ม task_id เข้าไป
                        }
                    },
                    <?php endforeach; ?>
                ],
                eventClick: function(info) {
                    if (info.event.extendedProps.type === 'bill') {
                        // Show bill modal
                        document.getElementById('modalCustomerName').innerText = 'ชื่อลูกค้า: ' + info.event.extendedProps.customername;
                        document.getElementById('modalBillCode').innerText = 'Bill Code: ' + info.event.extendedProps.billnum;
                        document.getElementById('modalBillType').innerText = 'ประเภทบิล: ' + info.event.extendedProps.billtype;
                        document.getElementById('modalPhone').innerText = 'เบอร์ติดต่อ: ' + info.event.extendedProps.phone;
                        document.getElementById('modalBillStatus').innerText = 'สถานะบิล: ' + info.event.extendedProps.billstatus;
                        document.getElementById('eventModal').classList.remove('hidden');
                    } else {
                        // Show task modal
                        document.getElementById('taskDetailModal').classList.remove('hidden');
                        document.getElementById('taskTitle').innerText = 'หัวข้อ: ' + info.event.title;
                        document.getElementById('taskDetail').innerText = 'รายละเอียด: ' + info.event.extendedProps.detail;
                        document.getElementById('taskDates').innerText = 'วันที่เริ่ม: ' + info.event.start.toLocaleDateString() + 
                                                                        '\nวันที่สิ้นสุด: ' + (info.event.end ? info.event.end.toLocaleDateString() : 'ไม่ระบุ');
                        
                        // ดึง task_id จาก extendedProps
                        const taskId = info.event.extendedProps.task_id;
                        
                        // ตัวอย่างการส่ง task_id ไปยังปุ่มลบ task
                        document.getElementById('deleteTaskButton').dataset.taskId = taskId;
                    }
                }
            });
            calendar.render();
            
            // Close modals
            document.getElementById('okBtn').addEventListener('click', function() {
                document.getElementById('eventModal').classList.add('hidden');
            });
            
            document.getElementById('closeTaskModal').addEventListener('click', function() {
                document.getElementById('taskDetailModal').classList.add('hidden');
            });
        });
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