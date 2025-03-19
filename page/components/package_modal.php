<!-- ./components/package_modal.php -->
<div id="packageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
    <div class="fixed inset-0 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">จัดการ Package และ Product</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="packageForm">
                <input type="hidden" id="id_package" name="id_package">
                <div class="mb-4">
                    <label for="name_package" class="block text-sm font-medium text-gray-700">ชื่อ Package</label>
                    <input type="text" id="name_package" name="name_package" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="info_package" class="block text-sm font-medium text-gray-700">ข้อมูล Package</label>
                    <textarea id="info_package" name="info_package" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <div class="mb-4">
                    <label for="create_at" class="block text-sm font-medium text-gray-700">วันที่สร้าง</label>
                    <input type="date" id="create_at" name="create_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <hr class="my-4">
                <h5 class="text-lg font-bold mb-4">Products</h5>
                <div id="productList" style="max-height: 300px; overflow-y: auto;">
                    <!-- Product fields will be dynamically added here -->
                </div>
                <button type="button" onclick="addProductField()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 mt-4">เพิ่ม Product</button>
            </form>
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">ปิด</button>
                <button onclick="savePackage()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 ml-2">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<script>
    // ฟังก์ชันเพิ่ม Product Field
    function addProductField() {
        const productList = document.getElementById('productList');
        const productField = `
            <div class="product-field mb-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <input type="text" name="name_product[]" placeholder="ชื่อ Product" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <textarea name="info_product[]" placeholder="ข้อมูล Product" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div>
                        <input type="number" name="mainpackage_price[]" placeholder="ราคา Main Package" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" oninput="calculateAllPrice(this)">
                    </div>
                    <div>
                        <input type="number" name="ict_price[]" placeholder="ราคา ICT Solution" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" oninput="calculateAllPrice(this)">
                    </div>
                </div>
                <div class="mt-2">
                    <input type="text" name="info_overide[]" placeholder="ข้อมูลเพิ่มเติม (ไม่จำเป็น)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <button type="button" onclick="removeProductField(this)" class="bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 mt-2">ลบ</button>
            </div>
        `;
        productList.insertAdjacentHTML('beforeend', productField);
    }

    // ฟังก์ชันลบ Product Field
    function removeProductField(button) {
        button.closest('.product-field').remove();
    }

    // ฟังก์ชันบันทึก Package
    function savePackage() {
        const formData = new FormData(document.getElementById('packageForm'));
        const products = [];
        formData.getAll('name_product[]').forEach((name, index) => {
            const mainpackagePrice = parseFloat(formData.getAll('mainpackage_price[]')[index]) || 0;
            const ictPrice = parseFloat(formData.getAll('ict_price[]')[index]) || 0;
            const allPrice = mainpackagePrice + ictPrice; // คำนวณ all_price

            products.push({
                name_product: name,
                info_product: formData.getAll('info_product[]')[index],
                mainpackage_price: mainpackagePrice,
                ict_price: ictPrice,
                all_price: allPrice, // ส่ง all_price ที่คำนวณแล้ว
                info_overide: formData.getAll('info_overide[]')[index] || null // เพิ่ม info_overide
            });
        });

        const packageData = {
            id_package: formData.get('id_package'),
            name_package: formData.get('name_package'),
            info_package: formData.get('info_package'),
            create_at: formData.get('create_at'),
            products: products,
            id_service: idService // ใช้ค่า idService จาก PHP
        };

        // ส่งข้อมูลไปยังเซิร์ฟเวอร์
        fetch('../function/save_package.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(packageData)
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('บันทึกข้อมูลสำเร็จ');
                window.location.reload();
            } else {
                alert('เกิดข้อผิดพลาด: ' + data.message);
            }
        });
    }

    function calculateAllPrice(input) {
        const productField = input.closest('.product-field');
        const mainpackagePrice = parseFloat(productField.querySelector('input[name="mainpackage_price[]"]').value) || 0;
        const ictPrice = parseFloat(productField.querySelector('input[name="ict_price[]"]').value) || 0;
        const allPrice = Number((mainpackagePrice + ictPrice).toFixed(2)); // บวกและให้ทศนิยม 2 หลัก
        // ไม่ต้องแสดง all_price ในฟอร์ม แต่จะส่งค่าไปยังเซิร์ฟเวอร์
    }
</script>