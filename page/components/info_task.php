<div id="taskDetailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="taskTitle"></h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500" id="taskDetail"></p>
                <p class="text-sm text-gray-500 mt-2" id="taskDates"></p>
            </div>
            <div class="mt-4">
                <button id="closeTaskModal" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    ปิด
                </button>
                <!-- เพิ่มปุ่มลบ task โดยตรวจสอบว่า user_id ตรงกับ user_id ใน task หรือไม่ -->
                <button id="deleteTaskButton" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 ml-2" data-task-id="">
                    ลบ task
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    // เพิ่ม event listener สำหรับปุ่มลบ task
    document.getElementById('deleteTaskButton')?.addEventListener('click', function() {
        const taskId = this.dataset.taskId; // ดึง task_id จาก data-task-id
        if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบ task นี้?')) {
            deleteTask(taskId); // Pass the taskId to the deleteTask function
        }
    });

    function deleteTask(taskId) {
        fetch('../function/delete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ task_id: taskId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('ลบ task สำเร็จ');
                window.location.reload(); // รีโหลดหน้าเพื่ออัปเดตข้อมูล
            } else {
                alert( data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>