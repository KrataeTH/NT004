<!-- Modal สำหรับสร้างและแก้ไขบริการ -->
<div id="serviceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 id="modalTitle" class="text-lg leading-6 font-medium text-gray-900"></h3>
            <form id="serviceForm" class="mt-2">
                <input type="hidden" id="id_service" name="id_service">
                <input type="hidden" id="id_bill" name="id_bill" value="<?php echo $id_bill; ?>">
                <div class="mb-4">
                    <label for="code_service" class="block text-sm font-medium text-gray-700">รหัสบริการ</label>
                    <input type="text" id="code_service" name="code_service" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="type_service" class="block text-sm font-medium text-gray-700">ประเภทบริการ</label>
                    <select id="type_service" name="type_service" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                </div>
                <div class="mb-4">
                    <label for="type_gadget" class="block text-sm font-medium text-gray-700">ประเภทอุปกรณ์</label>
                    <select id="type_gadget" name="type_gadget" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="เช่า">เช่า</option>
                        <option value="ขาย">ขาย</option>
                        <option value="เช่าและขาย">เช่าและขาย</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="status_service" class="block text-sm font-medium text-gray-700">สถานะบริการ</label>
                    <select id="status_service" name="status_service" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="ใช้งาน">ใช้งาน</option>
                        <option value="ยกเลิก">ยกเลิก</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModalService('service')" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">ยกเลิก</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>