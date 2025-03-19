<?php
// components/customer_modal.php
$amphures = getAmphures();
$customerTypes = getCustomerTypes(); // ฟังก์ชันใหม่เพื่อดึงข้อมูลประเภทลูกค้าจากฐานข้อมูล
?>

<div id="customerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <!-- เพิ่มปุ่มปิดที่มุมขวาบน -->
        <button type="button" onclick="closeCustomerModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">เพิ่มลูกค้า</h3>
            <form id="customerForm" class="mt-2">
                <input type="hidden" id="id_customer" name="id_customer">

                <!-- ชื่อและประเภทอยู่ในแถวเดียวกัน -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- ชื่อลูกค้า -->
                    <div>
                        <label for="name_customer" class="block text-sm font-medium text-gray-700">ชื่อลูกค้า</label>
                        <input type="text" name="name_customer" id="name_customer" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" placeholder="กรอกชื่อลูกค้า" required>
                        <p class="text-sm text-gray-500 mt-1">กรอกชื่อเต็มของลูกค้า</p>
                    </div>

                    <!-- ประเภทลูกค้า -->
                    <div>
                        <label for="id_customer_type" class="block text-sm font-medium text-gray-700">ประเภท</label>
                        <select name="id_customer_type" id="id_customer_type" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="" disabled selected>เลือกประเภท</option>
                            <?php foreach ($customerTypes as $type): ?>
                                <option value="<?= $type['id_customer_type'] ?>"><?= $type['type_customer'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">เลือกประเภทลูกค้า</p>
                    </div>
                </div>

                <!-- เบอร์โทรและสถานะอยู่ในแถวเดียวกัน -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- เบอร์โทรศัพท์ -->
                    <div>
                        <label for="phone_customer" class="block text-sm font-medium text-gray-700">เบอร์โทรศัพท์</label>
                        <input type="text" name="phone_customer" id="phone_customer" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" placeholder="กรอกเบอร์โทรศัพท์">
                        <p class="text-sm text-gray-500 mt-1">กรอกเบอร์โทรศัพท์ที่ถูกต้อง</p>
                    </div>

                    <!-- สถานะลูกค้า -->
                    <div>
                        <label for="status_customer" class="block text-sm font-medium text-gray-700">สถานะ</label>
                        <select name="status_customer" id="status_customer" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="" disabled selected>เลือกสถานะ</option>
                            <option value="ใช้งาน">ใช้งาน</option>
                            <option value="ไม่ได้ใช้งาน">ไม่ได้ใช้งาน</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">เลือกสถานะลูกค้า</p>
                    </div>
                </div>

                <!-- อำเภอและตำบลอยู่ในแถวเดียวกัน -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- อำเภอ -->
                    <div>
                        <label for="id_amphures" class="block text-sm font-medium text-gray-700">อำเภอ</label>
                            <select name="id_amphures" id="id_amphures" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" onchange="loadTambons(this.value)" required>
                                <option value="" disabled selected>เลือกอำเภอ</option>
                                <?php foreach ($amphures as $amphure): ?>
                                    <option value="<?= $amphure['id_amphures'] ?>"><?= $amphure['name_amphures'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <p class="text-sm text-gray-500 mt-1">เลือกอำเภอ</p>
                    </div>

                    <!-- ตำบล -->
                    <div>
                        <label for="id_tambons" class="block text-sm font-medium text-gray-700">ตำบล</label>
                            <select name="id_tambons" id="id_tambons" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="" disabled selected>เลือกตำบล</option>
                            </select>
                        <p class="text-sm text-gray-500 mt-1">เลือกตำบล</p>
                    </div>
                </div>

                <!-- ข้อมูลที่อยู่เพิ่มเติม -->
                <div class="mb-4">
                    <label for="info_address" class="block text-sm font-medium text-gray-700">ข้อมูลที่อยู่เพิ่มเติม</label>
                    <textarea name="info_address" id="info_address" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" placeholder="กรอกข้อมูลที่อยู่เพิ่มเติม"></textarea>
                    <p class="text-sm text-gray-500 mt-1">กรอกข้อมูลที่อยู่เพิ่มเติม</p>
                </div>

                <!-- ปุ่มดำเนินการ -->
                <div class="flex justify-end">
                    <button type="button" onclick="closeCustomerModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2 hover:bg-gray-600 transition duration-300">ยกเลิก</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">บันทึก</button>
                </div>
                <input type="hidden" name="id_address" id="id_address" value="">
            </form>
        </div>
    </div>
</div>

<script>
// แก้ไขฟังก์ชัน loadTambons ใน customer_modal.php
function loadTambons(id_amphures) {
    return new Promise((resolve, reject) => {
        if (id_amphures) {
            fetch(`../function/get_tambons.php?id_amphures=${id_amphures}`)
                .then(response => response.json())
                .then(data => {
                    const tambonSelect = document.getElementById('id_tambons');
                    tambonSelect.innerHTML = '<option value="" disabled selected>เลือกตำบล</option>';
                    data.forEach(tambon => {
                        tambonSelect.innerHTML += `<option value="${tambon.id_tambons}">${tambon.name_tambons}</option>`;
                    });
                    resolve();
                })
                .catch(error => reject(error));
        } else {
            resolve();
        }
    });
}
function closeCustomerModal() {
    document.getElementById('customerModal').classList.add('hidden');
}
document.getElementById('customerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const nameCustomer = document.getElementById('name_customer').value.trim();
    const idCustomerType = document.getElementById('id_customer_type').value.trim();
    const statusCustomer = document.getElementById('status_customer').value.trim();
    const idAmphures = document.getElementById('id_amphures').value.trim();
    const idTambons = document.getElementById('id_tambons').value.trim();

    // ตรวจสอบว่าข้อมูลทุกช่องถูกกรอกครบถ้วน (ยกเว้น info_address)
    if (!nameCustomer || !idCustomerType || !statusCustomer || !idAmphures || !idTambons) {
        alert('กรุณากรอกข้อมูลทุกช่องให้ครบถ้วน');
        return;
    }
});
</script>