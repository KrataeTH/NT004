<?php
// ในส่วนการดึงข้อมูล
$billTypeSql = "SELECT type_bill, COUNT(*) as count FROM bill_customer GROUP BY type_bill";
$billTypeResult = $conn->query($billTypeSql);
$billTypes = [];
while($row = $billTypeResult->fetch_assoc()) {
    $billTypes[] = $row;
}
$billStatusSql = "SELECT status_bill, COUNT(*) as count FROM bill_customer GROUP BY status_bill";
$billStatusResult = $conn->query($billStatusSql);

$billStatuses = [];
while ($row = $billStatusResult->fetch_assoc()) {
    $billStatuses[$row['status_bill']] = $row['count'];
}
// กำหนดค่าให้แน่ใจว่ามีครบทุกสถานะ
$activeCount = $billStatuses['ใช้งาน'] ?? 0;
$inactiveCount = $billStatuses['ยกเลิกใช้งาน'] ?? 0;
$customerTypeSql = "SELECT ct.type_customer, COUNT(c.id_customer) as count 
                   FROM customers c 
                   JOIN customer_types ct ON c.id_customer_type = ct.id_customer_type 
                   GROUP BY ct.type_customer";
$customerTypeResult = $conn->query($customerTypeSql);
$customerTypes = [];
while($row = $customerTypeResult->fetch_assoc()) {
    $customerTypes[] = $row;
}
$revenueSql = "SELECT c.id_customer, c.name_customer, 
                      SUM(CASE WHEN bc.status_bill = 'ใช้งาน' THEN o.all_price ELSE 0 END) as active_revenue,
                      SUM(CASE WHEN bc.status_bill = 'ยกเลิกใช้งาน' THEN o.all_price ELSE 0 END) as inactive_revenue
               FROM customers c
               JOIN bill_customer bc ON c.id_customer = bc.id_customer
               JOIN service_customer sc ON bc.id_bill = sc.id_bill
               JOIN package_list pl ON sc.id_service = pl.id_service
               JOIN product_list pr ON pl.id_package = pr.id_package
               JOIN overide o ON pr.id_product = o.id_product
               GROUP BY c.id_customer, c.name_customer
               ORDER BY active_revenue DESC, inactive_revenue DESC";
$revenueResult = $conn->query($revenueSql);
$customers = [];
$activeRevenues = [];
$inactiveRevenues = [];
while ($row = $revenueResult->fetch_assoc()) {
    $customers[] = $row['name_customer'];
    $activeRevenues[] = $row['active_revenue'];
    $inactiveRevenues[] = $row['inactive_revenue'];
}
// เพิ่มส่วนดึงข้อมูลประเภทบริการ
$serviceTypeSql = "SELECT type_service, COUNT(*) as count FROM service_customer GROUP BY type_service";
$serviceTypeResult = $conn->query($serviceTypeSql);
$serviceTypes = [];
while($row = $serviceTypeResult->fetch_assoc()) {
    $serviceTypes[] = $row;
}

// เพิ่มส่วนดึงข้อมูลประเภทอุปกรณ์
$deviceTypeSql = "SELECT type_gadget, COUNT(*) as count 
                  FROM service_customer 
                  GROUP BY type_gadget";
$deviceTypeResult = $conn->query($deviceTypeSql);

$deviceTypes = [];
while ($row = $deviceTypeResult->fetch_assoc()) {
    $deviceTypes[] = $row;
}

// จัดกลุ่มข้อมูลให้อยู่ในโครงสร้างที่ใช้กับ Chart.js
$labels = array_unique(array_column($deviceTypes, 'type_gadget'));  // ค่าของ labels คือชื่อของแต่ละประเภท gadget

// สร้าง array ที่ใช้เก็บข้อมูลตาม type_gadget
$formattedData = [];
foreach ($deviceTypes as $row) {
    $formattedData[$row['type_gadget']] = (int) $row['count'];
}

// New query to get total customer count
$totalCustomerSql = "SELECT COUNT(*) as total_customers FROM customers";
$totalCustomerResult = $conn->query($totalCustomerSql);
$totalCustomers = $totalCustomerResult->fetch_assoc()['total_customers'];

// New query to get total active bills
$totalBillsSql = "SELECT COUNT(*) as total_bills FROM bill_customer WHERE status_bill = 'ใช้งาน'";
$totalBillsResult = $conn->query($totalBillsSql);
$totalBills = $totalBillsResult->fetch_assoc()['total_bills'];

// New query to get total revenue from active bills
$totalRevenueSql = "SELECT SUM(o.all_price) as total_revenue
                    FROM bill_customer bc
                    JOIN service_customer sc ON bc.id_bill = sc.id_bill
                    JOIN package_list pl ON sc.id_service = pl.id_service
                    JOIN product_list pr ON pl.id_package = pr.id_package
                    JOIN overide o ON pr.id_product = o.id_product
                    WHERE bc.status_bill = 'ใช้งาน'";
$totalRevenueResult = $conn->query($totalRevenueSql);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'];

// Query to get top 3 customer types by count
$topCustomerTypesSql = "SELECT ct.type_customer, COUNT(c.id_customer) as count 
                        FROM customers c 
                        JOIN customer_types ct ON c.id_customer_type = ct.id_customer_type 
                        GROUP BY ct.type_customer
                        ORDER BY count DESC
                        LIMIT 3";
$topCustomerTypesResult = $conn->query($topCustomerTypesSql);
$topCustomerTypes = [];
while($row = $topCustomerTypesResult->fetch_assoc()) {
    $topCustomerTypes[] = $row;
}
?>
<style>
#chartModal .modal-content {
    width: 90%;
    height: 90%;
    margin: 2% auto;
    position: relative;
}
#fullScreenChart {
    width: 100% !important;
    height: 85% !important; /* ไว้พื้นที่สำหรับหัวข้อและปุ่มปิด */
    min-height: 0; /* ป้องกันการล้นใน Flex container */
}
#modalChartTitle {
    margin-bottom: 20px;
    font-size: 1.5rem;
}
</style>
<div class="summary-stats grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat-card bg-white p-4 rounded-lg shadow-md border-l-4 border-blue-500">
        <h4 class="text-gray-600 text-sm mb-2">จำนวนลูกค้าทั้งหมด</h4>
        <p class="text-2xl font-bold text-blue-800"><?= number_format($totalCustomers) ?></p>
    </div>
    <div class="stat-card bg-white p-4 rounded-lg shadow-md border-l-4 border-green-500">
        <h4 class="text-gray-600 text-sm mb-2">จำนวนบิลที่ใช้งาน</h4>
        <p class="text-2xl font-bold text-green-800"><?= number_format($totalBills) ?></p>
    </div>
    <div class="stat-card bg-white p-4 rounded-lg shadow-md border-l-4 border-purple-500">
        <h4 class="text-gray-600 text-sm mb-2">รายได้รวมทั้งหมด</h4>
        <p class="text-2xl font-bold text-purple-800"><?= number_format($totalRevenue, 2) ?> บาท</p>
    </div>
    <div class="stat-card bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-500">
        <h4 class="text-gray-600 text-sm mb-2">ประเภทลูกค้าสูงสุด 3 อันดับ</h4>
        <ul class="text-sm">
            <?php foreach($topCustomerTypes as $type): ?>
                <li class="flex justify-between">
                    <span class="text-gray-700"><?= $type['type_customer'] ?></span>
                    <span class="font-bold text-indigo-800"><?= number_format($type['count']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="charts-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="chart-card bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-4 text-gray-800">สัดส่วนประเภทบิล</h3>
        <canvas id="billTypeChart" class="w-full h-64"></canvas>
    </div>

    <div class="chart-card bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-4 text-gray-800">สถานะบิลทั้งหมด</h3>
        <canvas id="billStatusChart" class="w-full h-64"></canvas>
    </div>

    <div class="chart-card bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-4 text-gray-800">ประเภทลูกค้า</h3>
        <canvas id="customerTypeChart" class="w-full h-64"></canvas>
    </div>

    <div class="chart-card bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-4 text-gray-800">รายได้ต่อลูกค้า</h3>
        <canvas id="revenueChart" class="w-full h-64"></canvas>
    </div>

    <div class="chart-card bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-4 text-gray-800">ประเภทของบริการ</h3>
        <canvas id="serviceTypeChart" class="w-full h-64"></canvas>
    </div>

    <div class="chart-card bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-4 text-gray-800">ประเภทของอุปกรณ์</h3>
        <canvas id="deviceTypeChart" class="w-full h-64"></canvas>
    </div>
</div>

<!-- Modal for Full Screen Chart -->
<div id="chartModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg w-11/12 h-5/6 relative">
        <button id="closeModalBtn" class="absolute top-4 right-4 text-2xl font-bold text-gray-700 hover:text-gray-900">
            &times;
        </button>
        <h2 id="modalChartTitle" class="text-2xl font-bold mb-4 text-center text-gray-800"></h2>
        <canvas id="fullScreenChart" class="w-full h-full"></canvas>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
Chart.register(ChartDataLabels);
const balancedColorPalette = [
    '#8dd3c7',
    '#fb8072',
    '#bebada',
    '#ffffb3',
    '#80b1d3',
    '#fdb462',
    '#b3de69',
    '#fccde5',
    '#d9d9d9',
    '#bc80bd',
    '#ccebc5',
    '#ffed6f'
];
const chartConfigs = {
    billTypeChart: {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($billTypes, 'type_bill')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($billTypes, 'count')) ?>,
                backgroundColor: balancedColorPalette.slice(0, <?= count($billTypes) ?>)
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                },
                datalabels: {
                    color: '#fff',
                    font: { size: 14 },
                    formatter: (value) => value
                }
            }
        }
    },
    billStatusChart: {
        type: 'bar',
        data: {
            labels: ["สถานะบิล"], // ใช้ label กลางเดียวกัน
            datasets: [
                {
                    label: "ใช้งาน",
                    data: [<?= $activeCount ?>], // ใช้งาน
                    backgroundColor: balancedColorPalette[4],
                    borderColor: '#1D4ED8',
                    borderWidth: 1
                },
                {
                    label: "ไม่ใช้งาน",
                    data: [<?= $inactiveCount ?>], // ไม่ใช้งาน
                    backgroundColor: balancedColorPalette[1],
                    borderColor: '#DC2626',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'จำนวนบิล' }, ticks: { precision: 0 } },
            },
            plugins: {
                legend: { display: true }, // เปิด Legend เพื่อให้เห็น "ใช้งาน" กับ "ไม่ใช้งาน"
                datalabels: { 
                    anchor: 'end', 
                    align: 'top', 
                    color: '#000', 
                    font: { size: 12 },
                    formatter: (value) => value // แสดงค่าเลขปกติ
                }
            }
        }
    },
    customerTypeChart: {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($customerTypes, 'type_customer')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($customerTypes, 'count')) ?>,
                backgroundColor: balancedColorPalette.slice(4, 4 + <?= count($customerTypes) ?>)
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                },
                datalabels: {
                    color: '#fff',
                    font: { size: 14 },
                    formatter: (value) => value
                }
            }
        }
    },
    revenueChart: {
        type: 'bar',
        data: {
            labels: <?= json_encode($customers) ?>,
            datasets: [
                {
                    label: 'รายได้จากบิลที่ใช้งาน',
                    data: <?= json_encode($activeRevenues) ?>,
                    backgroundColor: '#80b1d3',
                    borderColor: '#4F46E5',
                    borderWidth: 1
                },
                {
                    label: 'รายได้จากบิลที่ยกเลิกใช้งาน',
                    data: <?= json_encode($inactiveRevenues) ?>,
                    backgroundColor: '#fb8072',
                    borderColor: '#E11D48',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {display: true, text: 'รายได้ (บาท)'},
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('th-TH') + ' บาท';
                        }
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const datasetLabel = context.dataset.label || '';
                            const value = context.parsed.y || 0;
                            return datasetLabel + ': ' + value.toLocaleString('th-TH') + ' บาท';
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    rotation: -90,
                    color: '#000',
                    font: {
                        size: 10,
                        weight: 'bold'
                    },
                    offset: 4,
                    formatter: (value) => {
                        return parseFloat(value).toLocaleString('th-TH');
                    },
                    display: function(context) {
                        return context.dataset.data[context.dataIndex] > 0; // Only show labels for non-zero values
                    }
                }
            }
        }
    },
    serviceTypeChart: {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($serviceTypes, 'type_service')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($serviceTypes, 'count')) ?>,
                backgroundColor: balancedColorPalette.slice(6, 6 + <?= count($serviceTypes) ?>)
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                },
                datalabels: {
                    color: '#fff', 
                    font: { size: 14 },
                    formatter: (value) => value
                }
            }
        }
    },
    deviceTypeChart: {
        type: 'bar',
        data: {
            labels: ["ประเภทอุปกรณ์"], // ใช้ label กลางเดียวกัน
            datasets: Object.keys(<?= json_encode($formattedData) ?>).map((label, index) => ({
                label: label,
                data: [<?= json_encode($formattedData) ?>[label]],
                backgroundColor: balancedColorPalette[index % balancedColorPalette.length],
                borderColor: balancedColorPalette[index % balancedColorPalette.length],
                borderWidth: 1
            }))
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            scales: {
                x: {
                    stacked: false, // ปรับให้ไม่ซ้อนกัน
                    beginAtZero: true,
                    title: { 
                        display: true, 
                        text: 'จำนวน',
                        font: { weight: 'bold' }
                    },
                    ticks: { precision: 0 }
                },
                y: {
                    stacked: false, // ปรับให้ไม่ซ้อนกัน
                    title: { 
                        display: false
                    }
                }
            },
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'right',
                    color: '#000000',
                    font: { 
                        size: 12, 
                        weight: 'bold' 
                    },
                    formatter: (value) => value > 0 ? value : '',
                    offset: 0
                },
                tooltip: {
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].dataset.label;
                        },
                        label: function(context) {
                            return 'จำนวน: ' + context.parsed.x + ' เครื่อง';
                        }
                    }
                }
            }
        }
    },

};
const chartInstances = {};
// Initialize all charts
Object.keys(chartConfigs).forEach(chartId => {
    const ctx = document.getElementById(chartId).getContext('2d');
    chartInstances[chartId] = new Chart(ctx, chartConfigs[chartId]);
    
    // Add click event to each chart to open full screen
    document.getElementById(chartId).addEventListener('click', () => openFullScreenChart(chartId));
});

// Full Screen Chart Functionality
const chartModal = document.getElementById('chartModal');
const fullScreenChart = document.getElementById('fullScreenChart');
const modalChartTitle = document.getElementById('modalChartTitle');
const closeModalBtn = document.getElementById('closeModalBtn');

function openFullScreenChart(chartId) {
    const originalChart = chartConfigs[chartId];
    const modalCtx = fullScreenChart.getContext('2d');
    
    // Clear previous chart if exists
    if (window.fullScreenChartInstance) {
        window.fullScreenChartInstance.destroy();
    }
    
    // Get chart title
    const chartTitle = document.querySelector(`#${chartId}`).closest('.chart-card').querySelector('h3').textContent;
    modalChartTitle.textContent = chartTitle;
    
    // Create new chart instance in modal with modified options
    window.fullScreenChartInstance = new Chart(modalCtx, {
        type: originalChart.type,
        data: originalChart.data,
        options: {
            ...originalChart.options,
            responsive: true,
            maintainAspectRatio: false, // สำคัญ! ป้องกันการรักษาสัดส่วนเดิม
            animation: {
                duration: 800, // เพิ่ม animation duration
                easing: 'easeOutQuart'
            },
            plugins: {
                ...originalChart.options?.plugins,
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 20,
                        font: {
                            size: 14 // ปรับขนาดตัวอักษรสำหรับ full screen
                        }
                    }
                }
            },
            layout: {
                padding: 10 // เพิ่ม padding ให้กราฟ
            }
        }
    });

    // Show modal
    chartModal.classList.remove('hidden');
}

// Additional event listener to handle modal resizing
window.addEventListener('resize', () => {
    if (!chartModal.classList.contains('hidden') && window.fullScreenChartInstance) {
        window.fullScreenChartInstance.resize();
    }
});

// Close modal
closeModalBtn.addEventListener('click', () => {
    chartModal.classList.add('hidden');
    if (window.fullScreenChartInstance) {
        window.fullScreenChartInstance.destroy();
    }
});
</script>