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
                        ระบบประมาณต้นทุนการขายนี้ได้รับการออกแบบเพื่ออำนวยความสะดวกในการนำเข้าข้อมูลเข้าสู่ระบบคำนวณ ซึ่งจะประมวลผลและแสดงข้อมูลการขายใน 3 รูปแบบ ช่วยให้คุณสามารถวิเคราะห์และตัดสินใจเลือกกำหนดราคาที่เหมาะสมได้อย่างมีประสิทธิภาพ
                        </p>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <img src="../img/quoatation/Q0.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                                
                            <!-- เพิ่ม div ข้อควรระวังที่นี่ -->
                            <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                                <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                    <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                    </svg>
                                    ข้อควรระวัง
                                </h4>
                                <ul class="list-disc pl-8 text-gray-700 mt-2">
                                    <li>ตรวจสอบข้อมูลให้ถูกต้องก่อนจะทำการคำนวณเสมอ</li>
                                    <li>หากกรอกข้อมูลเสร็จสิ้นแล้วแต่อยากให้ข้อมูลยังแสดงผลอยู่นั้นพนักงานไม่ควรกดรีเฟรชเพราะข้อมูลปัจจุบันนั้นหายไปได้</li>
                                </ul>

                            </div>
                            <div class="grid md:grid-cols-1 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <h4 class="font-semibold text-gray-800 mb-2">ส่วนประกอบหลัก:</h4>
                                    <ul class="list-disc pl-5 ">
                                        <li><strong>ระบบประมาณต้นทุน:</strong> แบ่งเป็น 5 ระบบหลักดังนี้</li>
                                            <ul class="list-disc pl-5 ">
                                                <li>ราคาประมาณ</li>
                                                <li>สรุปรายการขายขาด ISI</li>
                                                <li>สรุปรายการแบบเช่า(ลงทุนเอง)</li>
                                                <li>สรุปรายการแบบเช่า(เก็บค่าติดตั้ง)</li>
                                                <li>สรุปผลรายการประมาณต้นทุนทั้งหมด</li>
                                            </ul>
                                        <li><strong>การเลือกลูกค้า:</strong>พนักงานสามารถเลือกลูกค้าผ่านการกดปุ่มเพื่อเลือกลูกค้าได้</li>
                                        <li><strong>การใส่รายละเอียดโครงการ:</strong>พนักงานสามารถระบุโครงการต่่างๆลงในฟอร์มได้</li>
                                        <li><strong>การส่งออกข้อมูลเป็นไฟล์ Excel:</strong>หลังจากเลือกแลกรองข้อมูลที่ต้องการสามารกดนำออกมาเป็ฯรไฟล์ Excel ได้</li>
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
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 2: หน้างบประมาณการลงทุน</h3>
                    <img src="../img/quoatation/Q1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>แสดงฟอร์มการกรอกการประมาณต้นทุนตามหมวดหมู่</li>
                                <li>แสดงจำนวนมูลค่าประมาณการต้นทุนค่าอุปกรณ์Solution โดยแยกเป็น 1.กลุ่มค่าอุปกรณ์Solutionใหม่ 2.กลุ่มค่าอุปกรณ์ทดแทนSolutionเดิม 3.กลุ่มค่าอุปกรณ์Solution เดิม</li>
                                <li>พนักงานสามารถกรอกช้อมูลพร้อมกับดูผลลัพธ์ไปพร้อมๆกันได้</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.1. การเลือกและการใส่ข้อมูล</p>
                    <img src="../img/quoatation/Q2.png" alt="การเพิ่มข้อมูลในโครงการ" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li><strong>เลือกกลุ่มลูกค้า : </strong>เลือกประเภทลูกค้าที่ต้องการทำระบบประมาณต้นทุน</li>
                                <li><strong>กรอกข้อมูลโครงการ : </strong>กรอกขข้อมูลที่เกี่ยวข้องกับโครงการของลูกค้านั้นๆ</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.2. การเพิ่มข้อมูลสำหรับการคำนวณงบประมาณการลงทุน</p>
                    <img src="../img/quoatation/Q3.png" alt="การเพิ่มข้อมูลงบประมาณการลงทุน" class="w-2/2 rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>พนักงานสามารถกดปุ่มสีฟ้าเพื่อเพิ่มช่องในการใส่ข้อมูล</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">2.3. การลบข้อมูล</p>
                    <img src="../img/quoatation/Q4.png" alt="การลบช่องข้อมูล" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>พนักงานสามารถกดไอคอนถังขยะเพื่อทำการลบแต่ละแถวของข้อมูลได้</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 3 -->
            <div class="manual-page block" id="page3">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 3: สรุปรายการขายขาด ISI</h3>
                    <img src="../img/quoatation/Q5.png" alt="ภาพการขายISI" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>แสดงข้อมูลค่าอุปกรณ์ Solution ที่คิดมาจากหน้าคำนวณงบประมาณการลงทุน</li>
                                <li>แสดงข้อมูลการคำนวณต้นทุนโดยคิดจากค่าดำเนินการติดตั้ง</li>
                                <li>พนักงานสามารถปรับเพิ่มหรือลดการคิดภาษี(Vat)ได้</li>
                                <li>แสดงหน้าสรุปต้นทุน การขาย และกำไรที่องค์กรจะได้รับ </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 4 -->
            <div class="manual-page block" id="page4">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 4: สรุปการขายเช่า (แบบลงทุนเอง)</h3>
                    <img src="../img/quoatation/Q6.png" alt="ภาพแบบเช่า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>แสดงข้อมูลการคำนวณรวมโครงการโดยเริ่มคิดจาก ต้นทุนโครงการ งบประมาณที่ขอใช้
                                รายได้ขั้นต่ำ (บาท/โครงการ) โดยแบ่งเป็น ค่าบริการรายเดือน	จำนวนรอบบิล และจุดคุ้มทุนต่อเดือน
                                </li>
                                <li>แสดงข้อมูลการคำนวณอัตตราค่าบริการและปันส่วนรายได้(รายเดือน)โดยเริ่มคิดจาก
                                รายการโปรโมชั่น/แพ็คเกจ	ค่าบริการรายเดือนตามโปรโมชั่น	ค่าบริการอื่นๆ(ถ้ามี)	ค่าเช่า ICT&MA ขั้นต่ำ	ค่าเช่าเพิ่มตามดุลพินิจ	รายได้ขั้นค่าบริการ(บาท/เดือน)
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">4.1. การกรอกข้อมูล</p>
                    <img src="../img/quoatation/Q7.png" alt="การกรอกข้อมูลการประมาณต้นทุนแบบเช่า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>พนักงานสามารถเพิ่ม-ลบช่องรายการสำหรับการกรอกข้อมูลได้โดยกดปุ่มสีฟ้าเพื่อเพิ่มและกดไอคอนถังขยะเพื่อลบช่องรายการ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page 5 -->
         <div class="manual-page block" id="page5">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 5: สรุปการขายเช่า (แบบเก็บค่าติดตั้ง)</h3>
                    <img src="../img/quoatation/Q8.png" alt="ภาพแบบเช่าเก็บค่าติดตั้ง" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>แสดงข้อมูลการคำนวณรวมโครงการโดยเริ่มคิดจาก ต้นทุนโครงการ งบประมาณที่ขอใช้
                                รายได้ขั้นต่ำรวมทั้งโครงการ โดยแบ่งเป็น ค่าดำเนินการชำระครั้งเดียว	ค่าบริการรายเดือน	จำนวนรอบบิล และจุดคุ้มทุนต่อเดือน
                                </li>
                                <li>แสดงข้อมูลการคำนวณอัตตราค่าบริการและปันส่วนรายได้ (รายเดือน) โดยเริ่มคิดจาก
                                รายการโปรโมชั่น/แพ็คเกจ	ค่าบริการรายเดือนตามโปรโมชั่น	ค่าบริการอื่นๆ(ถ้ามี)	ค่าเช่า ICT&MA ขั้นต่ำ	ค่าเช่าเพิ่มตามดุลพินิจ	รายได้ขั้นค่าบริการ(บาท/เดือน)
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">5.1. การกรอกข้อมูล</p>
                    <img src="../img/quoatation/Q9.png" alt="การกรอกข้อมูลการประมาณต้นทุนแบบเช่า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>พนักงานสามารถเพิ่ม-ลบช่องรายการสำหรับการกรอกข้อมูลได้โดยกดปุ่มสีฟ้าเพื่อเพิ่มและกดไอคอนถังขยะเพื่อลบช่องรายการ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Page 6 -->
         <div class="manual-page block" id="page6">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 6: สรุปการขายทั้ง 3 แบบ</h3>
                    <img src="../img/quoatation/Q10.png" alt="ภาพสรุปการขายทั้งหมด" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>ในหน้านี้จะสรุปผลการขายทั้ง 3 แบบได้แก่ การขายแบบ ISI การสรุปผลเช่า (ลงทุน) และ สรุปผลเช่า (แบบเก็บค่าติดตั้ง)</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">6.1. การดาวน์โหลดไฟล์ในรูปแบบ Excel</p>
                    <img src="../img/quoatation/Q11.png" alt="การกรอกข้อมูลการประมาณต้นทุนแบบเช่า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="grid md:grid-cols-1 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด :</h4>
                            <ul class="list-disc pl-5 ">
                                <li>พนักงานสามารถกดปุ่มเพื่อดาวน์โหลดไฟล์เป็นรูปแบบExcel โดยในไฟล์จะประกอบไปด้วย ราคาประมาณ ราคาขาย ISI 
                                    สรุปการเช่า (ลงทุน) สรุปการเช่า(แบบเก็บค่าติดตั้ง) และสรุปทั้งหมด
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 7 -->
         <div class="manual-page block" id="page7">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 7: การสอนใช้งานระบบประมาณการต้นทุน</h3>
                    <video controls class="w-full rounded-lg border border-gray-200 mb-4">
                        <source src="http://localhost/NT/img/quoatation/q01.mp4" type="video/mp4">
                        เบราว์เซอร์ของคุณไม่รองรับการเล่นวิดีโอ
                    </video>
                    <div class="grid md:grid-cols-1 gap-4">
                    </div>
                    <div class="grid md:grid-cols-1 gap-4">
                       
                    </div>
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