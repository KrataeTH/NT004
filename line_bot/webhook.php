<?php
// ตั้งค่า LINE API
$access_token = 'B8AzbBkCr10BHDCpTxeSPBRiiPefrRjwkdY0b6ChBiTaxMk99Jd3QjcyVwXsC7Nv+ErF90h0GAEaGsIdMo/eh0Hb+zcIMkSG43ItQgp7sX3FyLCIMD1yl+4CMBrGnlZW5KcijlCTZcjg5GzJWWVoYwdB04t89/1O/w1cDnyilFU='; 
$login_url = 'https://4a35-125-26-7-18.ngrok-free.app/NT004/page/login.php';

// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$db_host = 'localhost'; 
$db_user = 'root';     
$db_pass = '';         
$db_name = 'ntdb';     

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูล JSON จาก webhook
$json = file_get_contents('php://input');
$events = json_decode($json, true);

if (!empty($events['events'])) {
    foreach ($events['events'] as $event) {
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            $replyToken = $event['replyToken'];
            $userMessage = trim($event['message']['text']); // ไม่ต้องแปลงเป็นตัวเล็ก

            if (strcasecmp($userMessage, 'login') == 0) {
                sendReply($replyToken, "🔑 กรุณาเข้าสู่ระบบโดยกดที่ลิงก์นี้: \n" . $login_url, $access_token);
            } 
            elseif (strcasecmp($userMessage, 'bill') == 0 || strcasecmp($userMessage, 'บิล') == 0) {
                sendBillMessage($replyToken, $conn, $access_token);
            }
            elseif (strcasecmp($userMessage, 'income') == 0 || strcasecmp($userMessage, 'รายได้') == 0) {
                sendIncomeMessage($replyToken, $conn, $access_token);
            }
            // เพิ่มเงื่อนไขใหม่สำหรับการค้นหาชื่อลูกค้า
            elseif (preg_match('/^[ก-๙]+$/u', $userMessage)) { // ตรวจสอบว่าข้อความเป็นภาษาไทย
                searchCustomerByName($replyToken, $userMessage, $conn, $access_token);
            }
            // เพิ่มเงื่อนไขสำหรับการดูรายละเอียดเลขหมาย
            elseif (strpos($userMessage, 'detail_number_') === 0) {
                $serviceId = str_replace('detail_number_', '', $userMessage);
                sendServiceDetails($replyToken, $serviceId, $conn, $access_token);
            }
            else {
                sendMenu($replyToken, $access_token);
            }
        }
    }
}

// ฟังก์ชันดึงข้อมูลบิล
function sendBillMessage($replyToken, $conn, $accessToken) {
    $sql = "SELECT type_bill, COUNT(*) as count FROM bill_customer GROUP BY type_bill";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $totalBills = 0;
        $message = "📄 จำนวนบิลทั้งหมด:\n";
        while ($row = $result->fetch_assoc()) {
            $totalBills += $row['count'];
            $message .= "- " . $row['type_bill'] . ": " . $row['count'] . " บิล\n";
        }
        $message = "📄 บิลทั้งหมดมี $totalBills บิล\n" . $message;
    } else {
        $message = "❌ ไม่พบข้อมูลบิล";
    }
    
    sendReply($replyToken, $message, $accessToken);
}

// ฟังก์ชันแปลงเดือนเป็นภาษาไทย
function getThaiMonth($month) {
    $months = [
        '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม',
        '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน',
        '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน',
        '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
    ];
    return $months[$month];
}

// ฟังก์ชันส่งข้อความรายได้
function sendIncomeMessage($replyToken, $conn, $accessToken) {
    $sql = "SELECT DATE_FORMAT(bc.create_at, '%Y-%m') as month, SUM(o.all_price) as monthly_revenue
            FROM customers c
            JOIN bill_customer bc ON c.id_customer = bc.id_customer
            JOIN service_customer sc ON bc.id_bill = sc.id_bill
            JOIN package_list pl ON sc.id_service = pl.id_service
            JOIN product_list pr ON pl.id_package = pr.id_package
            JOIN overide o ON pr.id_product = o.id_product
            GROUP BY DATE_FORMAT(bc.create_at, '%Y-%m')
            ORDER BY month ASC";
    $result = $conn->query($sql);
    
    $totalRevenue = 0;
    $message = "";
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $totalRevenue += $row['monthly_revenue'];
        }
        
        $message .= "📊 รายได้รวมทั้งหมด: " . number_format($totalRevenue, 2) . " บาท\n";
        $message .= "รายได้ของแต่ละเดือน:\n";
        
        $result->data_seek(0); 
        $currentYear = null;
        
        while ($row = $result->fetch_assoc()) {
            list($year, $monthNum) = explode('-', $row['month']);
            $thaiMonth = getThaiMonth($monthNum);
            $thaiYear = intval($year) + 543;

            if ($currentYear !== $thaiYear) {
                $message .= "\n🗓 ปี $thaiYear\n";
                $currentYear = $thaiYear;
            }

            $revenue = $row['monthly_revenue'];
            $revenueFormatted = (intval($revenue) == $revenue) ? number_format($revenue) : number_format($revenue, 2);
            $message .= "- $thaiMonth: " . $revenueFormatted . " บาท\n";
        }
    } else {
        $message = "❌ ไม่พบข้อมูลรายได้";
    }

    sendReply($replyToken, $message, $accessToken);
}

function searchCustomerByName($replyToken, $customerName, $conn, $accessToken) {
    // ค้นหาข้อมูลลูกค้า
    $sql = "SELECT c.id_customer, c.name_customer, 
                   SUM(o.all_price) as total_revenue, 
                   COUNT(sc.id_service) as service_count
            FROM customers c
            LEFT JOIN bill_customer bc ON c.id_customer = bc.id_customer
            LEFT JOIN service_customer sc ON bc.id_bill = sc.id_bill
            LEFT JOIN package_list pl ON sc.id_service = pl.id_service
            LEFT JOIN product_list pr ON pl.id_package = pr.id_package
            LEFT JOIN overide o ON pr.id_product = o.id_product
            WHERE c.name_customer LIKE '%$customerName%'
            GROUP BY c.id_customer";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $totalRevenue = $customer['total_revenue'];
        $serviceCount = $customer['service_count'];

        // สร้างข้อความสรุป
        $message = "🔍 ชื่อลูกค้า: " . $customer['name_customer'] . "\n";
        $message .= "📊 รายได้รวมทั้งหมด: " . number_format($totalRevenue, 2) . " บาท\n";
        $message .= "📞 จำนวนเลขหมายทั้งหมด: $serviceCount เลข\n\n";
        $message .= "เลือกเลขหมายที่ต้องการดูรายละเอียด:";

        // ดึงข้อมูลเลขหมายทั้งหมดของลูกค้า
        $sql = "SELECT sc.id_service, sc.service_number
                FROM service_customer sc
                JOIN bill_customer bc ON sc.id_bill = bc.id_bill
                WHERE bc.id_customer = " . $customer['id_customer'];
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $actions = [];
            while ($row = $result->fetch_assoc()) {
                $serviceId = $row['id_service'];
                $serviceNumber = $row['service_number'];
                $actions[] = [
                    "type" => "message",
                    "label" => "เลขหมาย $serviceNumber",
                    "text" => "detail_number_$serviceId"
                ];
            }

            // ส่งข้อความพร้อมปุ่มเลือกเลขหมาย
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                'messages' => [
                    [
                        "type" => "text",
                        "text" => $message
                    ],
                    [
                        "type" => "template",
                        "altText" => "เลือกเลขหมาย",
                        "template" => [
                            "type" => "buttons",
                            "text" => "เลือกเลขหมายที่ต้องการดูรายละเอียด",
                            "actions" => $actions
                        ]
                    ]
                ]
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/json\r\nAuthorization: Bearer $accessToken\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data),
                ],
            ];

            $context = stream_context_create($options);
            file_get_contents($url, false, $context);
        } else {
            sendReply($replyToken, "❌ ไม่พบเลขหมายสำหรับลูกค้า $customerName", $accessToken);
        }
    } else {
        sendReply($replyToken, "❌ ไม่พบข้อมูลลูกค้าสำหรับชื่อ $customerName", $accessToken);
    }
}

function sendServiceDetails($replyToken, $serviceId, $conn, $accessToken) {
    // ดึงรายละเอียดเลขหมาย
    $sql = "SELECT sc.service_number, 
                   SUM(o.all_price) as total_revenue, 
                   GROUP_CONCAT(pr.name SEPARATOR ', ') as products
            FROM service_customer sc
            LEFT JOIN package_list pl ON sc.id_service = pl.id_service
            LEFT JOIN product_list pr ON pl.id_package = pr.id_package
            LEFT JOIN overide o ON pr.id_product = o.id_product
            WHERE sc.id_service = $serviceId
            GROUP BY sc.id_service";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
        $message = "📞 เลขหมาย: " . $service['service_number'] . "\n";
        $message .= "💰 รายได้รวม: " . number_format($service['total_revenue'], 2) . " บาท\n";
        $message .= "📦 อุปกรณ์: " . $service['products'] . "\n";
    } else {
        $message = "❌ ไม่พบรายละเอียดเลขหมาย #$serviceId";
    }

    sendReply($replyToken, $message, $accessToken);
}

// ฟังก์ชันตอบกลับข้อความ
function sendReply($replyToken, $message, $accessToken) {
    $url = 'https://api.line.me/v2/bot/message/reply';
    $data = [
        'replyToken' => $replyToken,
        'messages' => [
            [
                'type' => 'text',
                'text' => $message
            ]
        ]
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\nAuthorization: Bearer $accessToken\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// ฟังก์ชันส่งเมนูช่วยเหลือ
function sendMenu($replyToken, $accessToken) {
    $url = 'https://api.line.me/v2/bot/message/reply';
    
    $menu = [
        "type" => "template",
        "altText" => "เมนูช่วยเหลือ",
        "template" => [
            "type" => "buttons",
            "text" => "เลือกบริการที่ต้องการ",
            "actions" => [
                ["type" => "message", "label" => "👁️ ดูข้อมูลบิล", "text" => "bill"],
                ["type" => "message", "label" => "📊 ดูรายได้", "text" => "income"],
                ["type" => "message", "label" => "🔑 เข้าสู่ระบบ", "text" => "login"]
            ]
        ]
    ];
    
    $data = [
        'replyToken' => $replyToken,
        'messages' => [$menu]
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\nAuthorization: Bearer $accessToken\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

echo "OK";
?>