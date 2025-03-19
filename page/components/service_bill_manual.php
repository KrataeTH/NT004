<div id="manualModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 mt-20">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-2xl font-bold text-gray-800">คู่มือการใช้งานระบบ</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="overflow-y-auto flex-1 p-6">
            <div class="space-y-8">
                <!-- Page 1 -->
                <div class="manual-page block" id="page1">
                    <div class="prose max-w-none">
                        <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 1: ภาพรวมของระบบ</h3>
                        <p class="text-gray-700 text-gl leading-relaxed">
                        ระบบรายงานนี้ออกแบบมาเพื่อช่วยให้คุณสามารถดูข้อมูลลูกค้า บิล และอุปกรณ์ได้อย่างมีประสิทธิภาพ คู่มือนี้จะอธิบายวิธีการใช้งานฟังก์ชันต่างๆ บนหน้ารายงาน
                        </p>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <img src="../img/report/R0-1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                            
                            <div class="grid md:grid-cols-1 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <h4 class="font-semibold text-gray-800 mb-2">ส่วนประกอบหลัก:</h4>
                                    <ul class="list-disc pl-5 ">
                                        <li><strong>การเลือกประเภทรายงาน:</strong> แบ่งเป็น 3 รายงานหลัก</li>
                                            <ul class="list-disc pl-5 ">
                                                <li>ลูกค้าและจำนวนบิลทั้งหมด</li>
                                                <li>ลูกค้าและหมายเลขบิลที่เกี่ยวข้อง</li>
                                                <li>ลูกค้าและอุปกรณ์ที่เกี่ยวข้อง</li>
                                            </ul>
                                        <li><strong>การกรองข้อมูลตามเงื่อนไขต่างๆ:</strong> โดยตัวกรองจะมีรายละเอียดตามข้อรายงาน</li>
                                        <li><strong>การส่งออกข้อมูลเป็นไฟล์ Excel:</strong> หลังจากเลือกแลกรองข้อมูลที่ต้องการสามารกดนำออกมาเป็ฯรไฟล์ Excel ได้</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 2 -->
            <div class="manual-page block" id="page2">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 2: รายงานที่ 1 ลูกค้าและจำนวนบิลทั้งหมด</h3>
                    <img src="../img/report/R1-1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>แสดงข้อมูลลูกค้า ที่อยู่ จำนวนบิลทั้งหมด</li>
                                <li>แสดงมูลค่ารวมของราคาแพ็คเกจหลัก ราคา ICT และราคารวมทั้งหมด</li>
                                <li>เหมาะสำหรับการดูภาพรวมของลูกค้าและมูลค่ารวม</li>
                                <li>แถวสุดท้ายแสดงจำนวนลูกค้าทั้งหมดและมูลค่ารวมแยกตามประเภท</li>
                                <li>ข้อมูลราคาแสดงเฉพาะบริการที่มีสถานะ "ใช้งาน" เท่านั้น</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.1. การกรองข้อมูล</p>
                    <img src="../img/report/R1-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li><strong>กรองตามประเภทลูกค้า : </strong>เลือกประเภทลูกค้าที่ต้องการข้อมูล</li>
                                <li><strong>กรองตามอำเภอ : </strong>เลือกอำเภอที่ตั้งลูกค้าที่ต้องการข้อมูล</li>
                                <li><strong>ปุ่มค้นหา : </strong>หลังจากเลือกตัวกรองเสร็จกดค้นหา เพื่อำการกรองข้อมูล</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.2. การส่งออกข้อมูล</p>
                    <p class="text-gray-700 text-gl leading-relaxed">หลังจากกรองข้อมูลต้องให้กดปุ่ม ดังรูปนี้</p>
                    <img src="../img/report/R1-3.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">จะได้ไฟล์ ดังรูปนี้</p>
                    <img src="../img/report/R1-4.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                </div>
            </div>
            <!-- Page 3 -->
            <div class="manual-page block" id="page3">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 3: รายงานที่ 2  ลูกค้าและหมายเลขบิลที่เกี่ยวข้อง</h3>
                    <img src="../img/report/R2-1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>แสดงรายละเอียดลูกค้าและบิลที่เกี่ยวข้องทั้งหมด</li>
                                <li>แสดงข้อมูลประเภทบริการ รหัสบริการ และประเภทอุปกรณ์</li>
                                <li>เหมาะสำหรับการดูรายละเอียดบิลของลูกค้าแต่ละราย</li>
                                <li>รายงานมีการจัดกลุ่มตามลูกค้าและบิล</li>
                                <li>บรรทัดแรกของแต่ละกลุ่มแสดงชื่อลูกค้าและข้อมูลบิลแรก</li>
                                <li>บรรทัดถัดไปที่ว่างคอลัมน์ซ้ายหมายถึงเป็นบิล/บริการเพิ่มเติมของลูกค้าเดิม</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.1. การกรองข้อมูล</p>
                    <img src="../img/report/R2-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li><strong>กรองตามประเภทลูกค้า : </strong>เลือกประเภทลูกค้าที่ต้องการข้อมูล</li>
                                <li><strong>กรองตามอำเภอ : </strong>เลือกอำเภอที่ตั้งลูกค้าที่ต้องการข้อมูล</li>
                                <li><strong>กรองตามประเภทบริการ : </strong>เลือกประเภทบริการที่ต้องการข้อมูล</li>
                                <li><strong>กรองตามประเภทอุปกรณ์ : </strong>เลือกประเภทอุปกรณ์ที่ต้องการข้อมูล</li>
                                <li><strong>ปุ่มค้นหา : </strong>หลังจากเลือกตัวกรองเสร็จกดค้นหา เพื่อำการกรองข้อมูล</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.2. การส่งออกข้อมูล</p>
                    <p class="text-gray-700 text-gl leading-relaxed">หลังจากกรองข้อมูลต้องให้กดปุ่ม ดังรูปนี้</p>
                    <img src="../img/report/R1-3.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">จะได้ไฟล์ ดังรูปนี้</p>
                    <img src="../img/report/R1-4.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                </div>
            </div>
            <!-- Page 4 -->
            <div class="manual-page block" id="page4">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 4: รายงานที่ 3  ลูกค้าและอุปกรณ์ที่เกี่ยวข้อง</h3>
                    <img src="../img/report/R3-1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>แสดงข้อมูลลูกค้าและอุปกรณ์ทั้งหมดที่เกี่ยวข้อง</li>
                                <li>แสดงสถานะของอุปกรณ์และหมายเหตุ</li>
                                <li>เหมาะสำหรับการตรวจสอบอุปกรณ์ที่ลูกค้าใช้งานอยู่</li>
                                <li>รายงานแบ่งตามลูกค้าและแสดงอุปกรณ์ทั้งหมดที่เกี่ยวข้อง</li>
                                <li>ข้อมูลสถานะอุปกรณ์จะช่วยให้ทราบว่าอุปกรณ์ยังใช้งานอยู่หรือไม่</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.1. การกรองข้อมูล</p>
                    <img src="../img/report/R3-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li><strong>กรองตามประเภทลูกค้า : </strong>เลือกประเภทลูกค้าที่ต้องการข้อมูล</li>
                                <li><strong>กรองตามอำเภอ : </strong>เลือกอำเภอที่ตั้งลูกค้าที่ต้องการข้อมูล</li>
                                <li><strong>ปุ่มค้นหา : </strong>หลังจากเลือกตัวกรองเสร็จกดค้นหา เพื่อำการกรองข้อมูล</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.2. การส่งออกข้อมูล</p>
                    <p class="text-gray-700 text-gl leading-relaxed">หลังจากกรองข้อมูลต้องให้กดปุ่ม ดังรูปนี้</p>
                    <img src="../img/report/R1-3.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">จะได้ไฟล์ ดังรูปนี้</p>
                    <img src="../img/report/R1-4.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="border-t px-6 py-4 bg-gray-50">
            <div class="flex justify-between items-center">
                <button onclick="prevPage()" class="px-5 py-2.5 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    ก่อนหน้า
                </button>
                
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600">หน้า</span>
                    <span id="pageNumber" class="font-semibold text-blue-600 w-12 text-center">1 / 5</span>
                </div>

                <button onclick="nextPage()" class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors flex items-center">
                    ถัดไป
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar */
    #manualModal ::-webkit-scrollbar {
        width: 8px;
    }
    #manualModal ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    #manualModal ::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }
    #manualModal ::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }

    /* Warning box */
    .warning-box {
        @apply bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4;
    }
</style>