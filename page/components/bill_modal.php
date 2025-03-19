<div id="createBillModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <button type="button" onclick="closeCreateBillModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">สร้างบิลใหม่</h3>
            <form id="createBillForm" method="POST" action="bill.php" class="mt-2">
                <input type="hidden" name="id_bill" id="id_bill">
    

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="number_bill" class="block text-sm font-medium text-gray-700">หมายเลขบิล</label>
                       <input type="text" name="number_bill" id="number_bill" placeholder="ใส่หมายเลขบิล" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                    </div>  
                    <?php if (!isset($id_customer) || $id_customer == 0): ?>
                    <div>
                        <label for="id_customer" class="block text-sm font-medium text-gray-700">เลือกลูกค้า</label>
                            <select name="id_customer" id="id_customer" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="" disabled selected>กรุณาเลือกลูกค้า</option>
                                <?php
                                $customer_sql = "SELECT id_customer, name_customer FROM customers ORDER BY name_customer";
                                $customer_result = $conn->query($customer_sql);
                                while ($customer = $customer_result->fetch_assoc()) {
                                    echo "<option value='" . $customer['id_customer'] . "'>" . 
                                        htmlspecialchars($customer['name_customer']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <?php else: ?>
                        <input type="hidden" name="id_customer" id="id_customer" value="<?= $id_customer ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="create_at" class="block text-sm font-medium text-gray-700">วันที่เริ่มสัญญา</label>
                        <input type="date" name="create_at" id="create_at" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="date_count" class="block text-sm font-medium text-gray-700">ระยะสัญญา (เดือน)</label>
                        <input type="number" name="date_count" id="date_count" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="type_bill" class="block text-sm font-medium text-gray-700">ประเภทบิล</label>
                        <select name="type_bill" id="type_bill" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="" disabled selected>เลือกประเภทบิล</option>    
                            <option value="CIP+">CIP+</option>
                            <option value="Special Bill">Special Bill</option>
                            <option value="Nt1">Nt1</option>
                        </select>
                    </div>

                    <div>
                        <label for="status_bill" class="block text-sm font-medium text-gray-700">สถานะบิล</label>
                        <select name="status_bill" id="status_bill" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="" disabled selected>เลือกสถานะบิล</option>
                            <option value="ใช้งาน">ใช้งาน</option>
                            <option value="ยกเลิกใช้งาน">ยกเลิกใช้งาน</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeCreateBillModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2 hover:bg-gray-600 transition duration-300">ยกเลิก</button>
                    <button type="submit" name="create_bill" id="createBillButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">สร้างบิล</button>
                    <button type="submit" name="update_bill" id="updateBillButton" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300 hidden">อัปเดตบิล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal สำหรับจัดการสัญญา -->
<div id="contractModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-md mx-auto mt-20">
        <h2 class="text-xl font-bold mb-4">จัดการสัญญา</h2>
        <form id="contractForm" action="../function/update_contract.php" method="POST">
            <input type="hidden" id="contract_id_bill" name="id_bill">
            <div class="mb-4">
                <label for="contract_action" class="block text-sm font-medium text-gray-700">การดำเนินการ</label>
                <select id="contract_action" name="contract_action" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    <option value="" disabled selected>กรุณาเลือกการดำเนินการ</option>
                    <option value="ต่อสัญญา">ต่อสัญญา</option>
                    <option value="ยกเลิกสัญญา">ยกเลิกสัญญา</option>
                </select>
                </div>
                <div id="contract_duration_field" class="mb-4 hidden">
                    <label for="contract_duration" class="block text-sm font-medium text-gray-700">ระยะสัญญา (เดือน)</label>
                    <input type="number" id="contract_duration" name="contract_duration" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeContractModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">ยกเลิก</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">บันทึก</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openCreateBillModal() {
        document.getElementById('createBillModal').classList.remove('hidden');
        document.getElementById('createBillButton').classList.remove('hidden');
        document.getElementById('updateBillButton').classList.add('hidden');
    }
</script>