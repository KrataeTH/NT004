<div id="gedgetModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 id="modalTitle" class="text-lg leading-6 font-medium text-gray-900"></h3>
            <form id="gedgetForm" class="mt-2">
                <input type="hidden" id="id_gedget" name="id_gedget">
                <input type="hidden" id="id_bill" name="id_bill" value="<?php echo $id_bill; ?>">

                <!-- ชื่อ Gedget (แสดงทั้งโหมดสร้างและแก้ไข) -->
                <div class="mb-4">
                    <label for="name_gedget" class="block text-sm font-medium text-gray-700">ชื่อ Gedget</label>
                    <input type="text" id="name_gedget" name="name_gedget" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <!-- จำนวน Gedget (แสดงเฉพาะโหมดสร้าง) -->
                <div id="quantityField" class="mb-4">
                    <label for="quantity_gedget" class="block text-sm font-medium text-gray-700">จำนวน Gedget</label>
                    <input type="number" name="quantity_gedget" id="quantity_gedget" class="mt-1 p-2 border rounded-md w-full focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- วันที่สร้าง (แสดงเฉพาะโหมดสร้าง) -->
                <div id="createDateField" class="mb-4">
                    <label for="create_at" class="block text-sm font-medium text-gray-700">วันที่สร้าง</label>
                    <input type="date" id="create_at" name="create_at" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <!-- หมายเหตุ (แสดงทั้งโหมดสร้างและแก้ไข) -->
                <div class="mb-4">
                    <label for="note" class="block text-sm font-medium text-gray-700">หมายเหตุ</label>
                    <textarea id="note" name="note" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>

                <!-- สถานะ (แสดงเฉพาะโหมดแก้ไข) -->
                <div id="statusField" class="mb-4 hidden">
                    <label for="status_gedget" class="block text-sm font-medium text-gray-700">สถานะ</label>
                    <select id="status_gedget" name="status_gedget" class="mt-1 p-2 w-full border rounded-md">
                        <option value="ใช้งาน">ใช้งาน</option>
                        <option value="ยกเลิก">ยกเลิก</option>
                    </select>
                </div>

                <!-- ปุ่มยกเลิกและบันทึก (แสดงทั้งโหมดสร้างและแก้ไข) -->
                <div class="flex justify-end">
                    <button type="button" onclick="closeModalService('gedget')" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">ยกเลิก</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>