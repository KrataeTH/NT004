<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/config.php';
require_once '../function/functions.php';

// ดึง user_id จาก session
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// ดึงการแจ้งเตือนจากตาราง notifications ที่ยังไม่ได้อ่าน (is_read = 0)
// Update the notifications query in navbar.php to include task notifications
$sql_notifications = "SELECT 
        n.id_notifications, 
        n.message, 
        n.created_at, 
        n.is_read, 
        n.task_id,
        n.id_bill,
        COALESCE(bc.number_bill, '') as number_bill, 
        COALESCE(c.name_customer, '') as name_customer,
        COALESCE(c.id_customer, '') as id_customer,
        COALESCE(t.name_task, '') as name_task, 
        COALESCE(t.start_date, '') as start_date,
        COALESCE(bc.end_date, '') as end_date
    FROM notifications n
    LEFT JOIN bill_customer bc ON n.id_bill = bc.id_bill
    LEFT JOIN customers c ON bc.id_customer = c.id_customer
    LEFT JOIN task t ON n.task_id = t.id_task
    WHERE n.id_user = ? AND n.is_read = 0
    ORDER BY n.created_at DESC";
$stmt_notifications = $conn->prepare($sql_notifications);
$stmt_notifications->bind_param("i", $user_id);
$stmt_notifications->execute();
$notifications = $stmt_notifications->get_result()->fetch_all(MYSQLI_ASSOC);

$near_expiry_count = count($notifications);

?>
    <style>
        .notification-dropdown {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 300px;
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            position: relative; /* กำหนดให้เป็น relative เพื่อให้ปุ่มอ่านแล้วอยู่ภายใน */
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s ease-in-out;
        }

        .notification-item:hover {
            background-color: #f7fafc;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-title {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
        }

        .notification-content {
            font-size: 0.875rem;  /* ขนาดตัวอักษรเล็กลง */
            font-weight: 400;  /* ตัวอักษรบางลง */
            color: #4a5568;  /* สีที่อ่อนกว่า */
        }

        .notification-days-left {
            font-size: 0.875rem;
            color: #4a5568;
        }

        .notification-date {
            font-size: 0.75rem;
            color: #718096;
        }


        /* สไตล์สำหรับปุ่มอ่านแล้ว (ไอคอนกากบาท) */
        .mark-as-read-button {
            position: absolute; /* กำหนดให้อยู่ที่มุมขวาบน */
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            color: #718096; /* สีเทา */
            font-size: 1.5rem; /* ปรับขนาดให้ใหญ่ขึ้น (ค่าเริ่มต้นคือ 1rem) */
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }

        .mark-as-read-button:hover {
            color: #dc2626; /* สีแดงเมื่อ hover */
        }
        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 1000; /* ให้ Navbar อยู่ด้านบนสุดของหน้าเว็บ */
        }

        /* สไตล์สำหรับหน้าจอเล็ก (Mobile) */
        @media (max-width: 768px) {
            .md\\:flex {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .mobile-menu-button {
                display: block;
            }

            .mobile-menu-items {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: #ffffff;
                border-top: 1px solid #e2e8f0;
                z-index: 1000;
            }

            .mobile-menu-items.active {
                display: block;
            }

            .mobile-menu-items a {
                display: block;
                padding: 1rem;
                text-align: center;
                border-bottom: 1px solid #e2e8f0;
            }
        }
    </style>
<nav class="bg-white shadow-md sticky-nav">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and Brand Name -->
            <div class="flex items-center">
                <img src="https://lh5.googleusercontent.com/proxy/dFSvkaJ3s6GRq3Idd5YLpPVIKmOewgsaR0OrEg0-yXWnQO-HME3H4Yg8kRtfKPwD0UiIsObjAobdvx3bicht" 
                    alt="Logo" 
                    class="h-10 w-auto">
                <a href="#" class="ml-2 text-xl font-semibold text-gray-800">โทรคมนาคมแห่งชาติ</a>
            </div>

            <!-- Hamburger Menu สำหรับหน้าจอเล็ก -->
            <div class="mobile-menu md:hidden">
                <button class="mobile-menu-button text-gray-700 hover:text-blue-600 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="index.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Main</a>
                <a href="customer.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Customer</a>
                <a href="bill.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Billing</a>
                <a href="report.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Report</a>
                <a href="quotation.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Quotation</a>
                
                <!-- ไอคอนกระดิ่งและรายการแจ้งเตือน -->
                <div class="relative">
                    <div class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300 relative cursor-pointer">
                        <i class="fas fa-bell"></i>
                        <?php if ($near_expiry_count > 0): ?>
                            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5"><?= $near_expiry_count ?></span>
                        <?php endif; ?>
                    </div>
                    <!-- Dropdown Menu สำหรับแสดงรายการแจ้งเตือน -->
                    <?php if ($near_expiry_count > 0): ?>
                        <div class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden notification-dropdown" id="notificationDropdown">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2">การแจ้งเตือน</h3>
                                <ul>
                                    <?php foreach ($notifications as $notification): ?>
                                        <li class="notification-item" data-notification-id="<?= htmlspecialchars($notification['id_notifications']) ?>">
                                            <div class="text-sm text-gray-700">
                                                <button onclick="markAsRead(<?= htmlspecialchars($notification['id_notifications']) ?>)" 
                                                        class="mark-as-read-button">
                                                    ×
                                                </button>
                                                
                                                <?php if (!empty($notification['id_bill'])): ?>
                                                    <p class="notification-title"><?= htmlspecialchars("สัญญาใกล้หมดอายุ") ?></p>
                                                    <p class="notification-content"><?= nl2br(htmlspecialchars($notification['message'])) ?></p>
                                                    <?php 
                                                        $end_date = new DateTime($notification['end_date']);
                                                        $current_date = new DateTime();
                                                        $end_date->modify('+1 day');
                                                        $interval = $current_date->diff($end_date);
                                                        $days_remaining = $interval->days;
                                                    ?>
                                                    <p class="notification-days-left text-orange-600">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        <?php if ($days_remaining == 0): ?>
                                                            หมดภายในวันนี้
                                                        <?php else: ?>
                                                            เหลือเวลาอีก <?= $days_remaining ?> วัน
                                                        <?php endif; ?>
                                                    </p>
                                                    <p class="notification-date">วันที่แจ้งเตือน: <?= date('Y-m-d H:i:s', strtotime($notification['created_at'])) ?></p>
                                                    <a href="bill.php" 
                                                        onclick="event.preventDefault(); document.getElementById('billForm<?= htmlspecialchars($notification['id_bill']) ?>').submit();" 
                                                        class="mt-2 inline-block bg-blue-500 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-600 transition duration-300">
                                                        ดูบิล
                                                    </a>
                                                    <form id="billForm<?= htmlspecialchars($notification['id_bill']) ?>" action="bill.php" method="POST" style="display: none;">
                                                        <input type="hidden" name="id_bill" value="<?= htmlspecialchars($notification['id_bill']) ?>">
                                                        <input type="hidden" name="id_customer" value="<?= htmlspecialchars($notification['id_customer']) ?>">
                                                    </form>
                                                <?php endif; ?>

                                                <?php if (!empty($notification['task_id'])): ?>
                                                    <p class="notification-title"><?= htmlspecialchars("นัดหมาย") ?></p>
                                                    <p class="notification-content"><?= nl2br(htmlspecialchars($notification['message'])) ?></p>
                                                    <?php 
                                                        $start_date = new DateTime($notification['start_date']);
                                                        $current_date = new DateTime();
                                                        $start_date->modify('+1 day');
                                                        $interval = $current_date->diff($start_date);
                                                        $days_until_start = $interval->days;
                                                    ?>
                                                    <p class="notification-days-left text-green-600">
                                                        <i class="fas fa-calendar-alt mr-1"></i>
                                                        <?php if ($days_until_start == 0): ?>
                                                            เริ่มวันนี้
                                                        <?php else: ?>
                                                            อีก <?= $days_until_start ?> วันจะถึงวันเริ่มงาน
                                                        <?php endif; ?>
                                                    </p>
                                                    <p class="notification-date">วันที่แจ้งเตือน: <?= date('Y-m-d H:i:s', strtotime($notification['created_at'])) ?></p>
                                                    <a href="index.php" 
                                                        onclick="event.preventDefault(); document.getElementById('taskForm<?= htmlspecialchars($notification['task_id']) ?>').submit();" 
                                                        class="mt-2 inline-block bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600 transition duration-300">
                                                            ดูงาน
                                                    </a>
                                                    <form id="taskForm<?= htmlspecialchars($notification['task_id']) ?>" action="index.php" method="POST" style="display: none;">
                                                        <input type="hidden" name="task_id" value="<?= htmlspecialchars($notification['task_id']) ?>">
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>

            <!-- Mobile Menu Items -->
            <div class="mobile-menu-items md:hidden">
                <a href="index.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Main</a>
                <a href="customer.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Customer</a>
                <a href="bill.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Billing</a>
                <a href="report.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Report</a>
                <a href="quotation.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Quotation</a>
                <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>
<script>
    function updateNotificationDropdown(notifications) {
        const dropdown = document.getElementById('notificationDropdown');
        if (!dropdown) return;

        const ul = dropdown.querySelector('ul');
        if (!ul) return;

        // Clear existing notifications
        ul.innerHTML = '';

        // Add new notifications
        notifications.forEach(notification => {
            if (!notification.is_read) {
                const li = document.createElement('li');
                li.className = 'notification-item';
                li.setAttribute('data-notification-id', notification.id_notifications);

                let content = '';
                if (notification.id_bill) {
                    // Bill notification
                    content = `
                        <div class="text-sm text-gray-700">
                            <p class="notification-title">${notification.message}</p>
                            <p class="notification-days-left text-orange-600">
                                <i class="fas fa-clock mr-1"></i>
                                เหลือเวลาอีก ${notification.days_remaining} วัน
                            </p>
                            <p class="notification-date">วันที่แจ้งเตือน: ${new Date(notification.created_at).toLocaleString()}</p>
                            <a href="bill.php?id_customer=${notification.id_customer}&id_bill=${notification.id_bill}" 
                            class="mt-2 inline-block bg-blue-500 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-600 transition duration-300">
                                ดูบิล
                            </a>
                        </div>`;
                } else if (notification.task_id) {
                    // Task notification
                    content = `
                        <div class="text-sm text-gray-700">
                            <p class="notification-title">${notification.message}</p>
                            <p class="notification-days-left text-green-600">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                อีก ${notification.days_until_start} วันจะถึงวันเริ่มงาน
                            </p>
                            <p class="notification-date">วันที่แจ้งเตือน: ${new Date(notification.created_at).toLocaleString()}</p>
                            <a href="#" onclick="showTaskDetails(${notification.task_id})" 
                            class="mt-2 inline-block bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600 transition duration-300">
                                ดูงาน
                            </a>
                        </div>`;
                }

                // Add mark as read button
                content += `
                    <button onclick="markAsRead(${notification.id_notifications})" 
                            class="mark-as-read-button">
                        ×
                    </button>`;

                li.innerHTML = content;
                ul.appendChild(li);
            }
        });
    }

    function checkAllNotifications() {
    Promise.all([
        fetch('../function/check_near_expiry.php').then(r => r.json().catch(() => ({ success: false, contracts: [] }))),
        fetch('../function/check_task_reminders.php').then(r => r.json().catch(() => ({ success: false, tasks: [] })))
    ])
        .then(([billData, taskData]) => {
            if (!billData.success && !taskData.success) {
                console.error('Failed to fetch notifications');
                return;
            }

            const notifications = [
                ...(billData.success ? billData.contracts : []),
                ...(taskData.success ? taskData.tasks : [])
            ];

            
        })
        .catch(error => {
            console.error('Error checking notifications:', error);
        });
    }

    // ตรวจสอบทุก 5 นาที
    setInterval(checkAllNotifications, 300000);
    checkAllNotifications(); // ตรวจสอบทันทีเมื่อโหลดหน้า

     // เปิด/ปิด dropdown menu เมื่อคลิกที่ไอคอนกระดิ่ง
    document.addEventListener('DOMContentLoaded', function() {
        const bellIcon = document.querySelector('.fa-bell');
        const notificationDropdown = document.getElementById('notificationDropdown');

        if (bellIcon && notificationDropdown) {
            bellIcon.addEventListener('click', function(e) {
                e.preventDefault();
                notificationDropdown.classList.toggle('hidden');
            });

            // ปิด dropdown เมื่อคลิกนอกพื้นที่
            document.addEventListener('click', function(e) {
                if (!bellIcon.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }
    });

    // เปิด/ปิดเมนูบนมือถือ
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenuItems = document.querySelector('.mobile-menu-items');

        if (mobileMenuButton && mobileMenuItems) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenuItems.classList.toggle('active');
            });

            // ปิดเมนูเมื่อคลิกนอกพื้นที่
            document.addEventListener('click', function(e) {
                if (!mobileMenuButton.contains(e.target) && !mobileMenuItems.contains(e.target)) {
                    mobileMenuItems.classList.remove('active');
                }
            });
        }
    });

    function markAsRead(notificationId) {
        fetch('../function/mark_as_read.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ notification_id: notificationId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // หา element ที่มี data-notification-id เท่ากับ notificationId
                const notificationItem = document.querySelector(`.notification-item[data-notification-id="${notificationId}"]`);
                if (notificationItem) {
                    // ลบรายการแจ้งเตือนที่ถูกอ่านแล้วออกจาก dropdown
                    notificationItem.remove();
                }

                // อัปเดตจำนวนการแจ้งเตือนที่แสดงบนไอคอนกระดิ่ง
                const notificationCount = document.querySelector('.fa-bell').nextElementSibling;
                if (notificationCount) {
                    const newCount = parseInt(notificationCount.textContent) - 1;
                    if (newCount > 0) {
                        notificationCount.textContent = newCount;
                    } else {
                        notificationCount.remove();
                    }
                }
            }
        });
    }
</script>