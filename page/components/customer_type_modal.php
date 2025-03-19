<!-- Modal for managing customer types -->
<div id="customerTypeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">จัดการประเภทลูกค้า</h3>
            <form id="customerTypeForm" class="mt-2">
                <input type="hidden" id="id_customer_type" name="id_customer_type">
                <div class="mb-4">
                    <label for="type_customer" class="block text-sm font-medium text-gray-700">ประเภทลูกค้า</label>
                    <input type="text" id="type_customer" name="type_customer" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="mr-2 bg-gray-500 text-white p-2 rounded">ยกเลิก</button>
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(action, id = null) {
        const modal = document.getElementById('customerTypeModal');
        const form = document.getElementById('customerTypeForm');
        const title = document.getElementById('modalTitle');
        const typeCustomerInput = document.getElementById('type_customer');
        const idCustomerTypeInput = document.getElementById('id_customer_type');

        if (action === 'add') {
            title.innerText = 'เพิ่มประเภทลูกค้า';
            typeCustomerInput.value = '';
            idCustomerTypeInput.value = '';
        } else if (action === 'edit') {
            title.innerText = 'แก้ไขประเภทลูกค้า';
            // Fix the path to get_customer_type.php
            fetch(`../function/get_customer_type.php?id_customer_type=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        typeCustomerInput.value = data.type_customer;
                        idCustomerTypeInput.value = data.id_customer_type;
                    } else {
                        alert('ไม่พบข้อมูลประเภทลูกค้า');
                        closeModal();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('เกิดข้อผิดพลาดในการดึงข้อมูล');
                    closeModal();
                });
        }

        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('customerTypeModal');
        modal.classList.add('hidden');
    }

    document.getElementById('customerTypeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const action = formData.get('id_customer_type') ? 'update' : 'create';

        fetch(`../function/handle_customer_type.php?action=${action}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeModal();
                window.location.reload();
            } else {
                alert('เกิดข้อผิดพลาด: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
        });
    });
</script>