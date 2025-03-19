<!-- group_modal.php -->

<div id="groupModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 id="modalTitle" class="text-lg leading-6 font-medium text-gray-900">สร้างกลุ่ม</h3>
            <form id="groupForm" class="mt-2">
                <input type="hidden" id="id_group" name="id_group">
                <input type="hidden" id="id_bill" name="id_bill" value="<?php echo $id_bill; ?>">
                
                <!-- ส่วนกรอกชื่อกลุ่ม -->
                <div class="mb-4">
                    <label for="group_name" class="block text-sm font-medium text-gray-700">ชื่อกลุ่ม</label>
                    <input type="text" id="group_name" name="group_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- ส่วนเลือกบริการ -->
                <div class="mb-4">
                    <h4 class="text-md font-medium text-gray-700">บริการ</h4>
                    <button type="button" id="toggleAll" class="mb-2 px-4 py-2 bg-blue-500 text-white rounded">เลือกทั้งหมด</button>
                    <div id="serviceList" class="mt-2">
                        <?php foreach ($services as $service): ?>
                            <label class="block">
                                <input type="checkbox" name="services[]" value="<?php echo $service['id_service']; ?>">
                                <?php echo htmlspecialchars($service['code_service']); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <script>
                document.getElementById('toggleAll').addEventListener('click', function() {
                    var checkboxes = document.querySelectorAll('#serviceList input[type="checkbox"]');
                    var allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = !allChecked;
                    });
                    this.textContent = allChecked ? 'เลือกทั้งหมด' : 'ยกเลิกทั้งหมด';
                });
                </script>

                <!-- ส่วนเลือกอุปกรณ์ -->
            <div class="mb-4">
                <h4 class="text-md font-medium text-gray-700">อุปกรณ์</h4>
                <button type="button" id="toggleAllGedgets" class="mb-2 px-4 py-2 bg-blue-500 text-white rounded">เลือกทั้งหมด</button>
                <div id="gedgetList" class="mt-2">
                    <?php foreach ($gedgets as $gedget): ?>
                        <label class="block">
                            <input type="checkbox" name="gedgets[]" value="<?php echo $gedget['id_gedget']; ?>">
                            <?php echo htmlspecialchars($gedget['name_gedget']); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
            document.getElementById('toggleAllGedgets').addEventListener('click', function() {
                var checkboxes = document.querySelectorAll('#gedgetList input[type="checkbox"]');
                var allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = !allChecked;
                });
                this.textContent = allChecked ? 'เลือกทั้งหมด' : 'ยกเลิกทั้งหมด';
            });
            </script>

                <!-- ปุ่มดำเนินการ -->
                <div class="flex justify-end">
                    <button type="button" onclick="closeModalService('group')" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">ยกเลิก</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>