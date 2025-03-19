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
                        ยินดีต้อนรับสู่แดชบอร์ดของระบบจัดการลูกค้าและการเงิน แดชบอร์ดนี้ออกแบบมาเพื่อช่วยให้คุณสามารถติดตามข้อมูลสำคัญเกี่ยวกับลูกค้า บิล และงานต่างๆ ได้อย่างง่ายดาย คู่มือนี้จะแนะนำฟีเจอร์หลักและวิธีการใช้งานต่างๆ เพื่อให้คุณใช้งานระบบได้อย่างมีประสิทธิภาพสูงสุด
                        </p>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <img src="../img/dashboard/D0-1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                            
                            <div class="grid md:grid-cols-1 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <h4 class="font-semibold text-gray-800 mb-2">ส่วนประกอบหลัก:</h4>
                                    <ul class="list-disc pl-5 ">
                                        <li><strong>กราฟแสดงข้อมูล:</strong> แสดงข้อมูลสรุปรายได้ลูกค้าและการใช้งานบิลในรูปแบบกราฟต่างๆ</li>
                                        <li><strong>ปฏิทิน:</strong> แสดงกำหนดการงานและวันหมดอายุของบิล</li>
                                        <li><strong>งานล่าสุด:</strong> แสดงรายการงานที่กำลังดำเนินการ</li>
                                        <li><strong>บิลใกล้หมดสัญญา:</strong> แสดงรายการบิลที่จะหมดอายุภายใน 60 วัน</li>
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
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 2: การแสดงผลสรุปข้อมูล</h3>
                    <p class="text-gray-700 leading-relaxed">
                            ส่วนนี้แสดงข้อมูลสรุปของบิลในรูปแบบกราฟ ช่วยให้คุณเห็นภาพรวมของผลการดำเนินงานของระบบได้อย่างรวดเร็ว
                    </p>
                    <img src="../img/dashboard/D1-1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="bg-gray-50 p-4 rounded-lg mb-6"> 
                        
                        <p class="text-gray-700 text-xl font-bold mt-2">2.1. การแสดงข้อมูลแบบผลรวมทั้งหมด</p>
                        <img src="../img/dashboard/D1-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <div class="grid md:grid-cols-1 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-2">ประกอบไปด้วย :</h4>
                                <ul class="list-disc pl-5 ">
                                    <li><strong>จำนวนลูกค้าทั้งหมด:</strong> แสดงข้อมูลลูกค้าทั้งหมดในฐานระบบ</li>
                                    <li><strong>จำนวนบิลที่ใช้งาน:</strong> แสดงข้อมูลของบิลที่มีการใช้งานอยู่ตอนนี้</li>
                                    <li><strong>รายได้ทั้งหมด:</strong> แสดงรายได้ทั้งหมดจากบิลที่ถูกใช้งาน</li>
                                    <li><strong>ประเภทของลูกค้า:</strong> แสดงประเภทของลูกค้าที่เยอะที่สุด 3 อันดับแรก</li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-gray-700 text-xl font-bold mt-2">2.2. การแสดงข้อมูลแบบกราฟ</p>
                        <img src="../img/dashboard/D1-3.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <div class="grid md:grid-cols-1 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-2">ประกอบไปด้วย :</h4>
                                <ul class="list-disc pl-5 ">
                                    <li><strong>สัดส่วนประเภทบิล:</strong> แสดงสัดส่วนประเภทบิลที่อยู่ในฐานระบบทั้งหมด</li>
                                    <li><strong>สถานะบิลทั้งหมด:</strong> แสดงสัดส่วนของบิลที่ใช้งานและไม่ใช้งาน</li>
                                    <li><strong>ประเภทลูกค้า:</strong> แสดงจำนวนสัดส่วนของประเภทลูกค้าทั้งหมดในฐานระบบ</li>
                                    <li><strong>รายได้จากลูกค้า:</strong> แสดงรายได้ทั้งหมดจากบิลที่ถูกใช้งานต่อลูกค้าคนนั้น</li>
                                    <li><strong>ประเภทของบริการ:</strong> แสดงสัดส่วนของบริการที่อยู่ในฐานระบบ</li>
                                    <li><strong>ประเภทของอุปกรณ์:</strong> แสดงสัดส่วนของประเภทอุปกรณ์ทั้งหมดในฐานระบบ</li>
                                </ul>
                                <h4 class="font-semibold text-gray-800 mb-2">วิธีการใช้งาน :</h4>
                                <ul class="list-disc pl-5 ">
                                    <li>คลิกที่กราฟเพื่อดูรายละเอียดเพิ่มเติม</li>
                                    <img src="../img/dashboard/D1-4.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                                    <li>กดคลิ๊กที่กราฟเพื่อขยายกราฟให้เห็นข้อมูลชัดเจนยิ่งขึ้น</li>
                                    <img src="../img/dashboard/D1-5.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 3 -->
            <div class="manual-page block" id="page3">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 3: การจัดการปฏิทิน</h3>
                    <p class="text-gray-700 leading-relaxed">
                    ปฏิทินแสดงกำหนดการและเหตุการณ์สำคัญทั้งงานและวันหมดอายุของบิล และสามารถเพิ่มเหตุการณ์ได้กำหนดผู้เกี่ยวข้องได้
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold mt-2">3.1. การแสดงข้อมูลปฏิทิน</p>
                    <p class="text-gray-700 text-gl leading-relaxed">ในปฏิทินจะแสดงข้อมูล 2 ประเภท คือ วันนัดหมายของงาน และหมดสัญญาบิล</p>
                    <img src="../img/dashboard/D1-6.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed mt-6">-แสดงข้อมูลวัดหมายหมายงาน จะแสดงแค่เฉพาะงานที่มีผู้เกี่ยวข้องเท่านั้น สามารถกดเข้าไปดูรายละเอียดได้</p>
                    <p class="text-gray-700 text-gl leading-relaxed "><strong>หมายเหตุ :</strong> หากงานนัดหมายนี้คุณไม่ได้สร้าง ไม่มีสิทธิ์ ลบออกได้</p>
                    <div class="flex gap-4">
                        <img src="../img/dashboard/D1-7.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200">
                        <img src="../img/dashboard/D1-8.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200">
                    </div>
                    <p class="text-gray-700 text-gl leading-relaxed mt-6">-แสดงวันหมดสัญญาบิล จะแสดงบิลที่หมดสัญญาในวันนั้น สามารถกดเข้าไปดูรายละเอียดได้เช่นกัน</p>
                    <div class="flex gap-4">
                    <img src="../img/dashboard/D1-9.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                    <img src="../img/dashboard/D1-10.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                    </div>
                    <p class="text-gray-700 text-xl font-bold mt-2">3.2. การจัดการกับงาน"</p>
                    <img src="../img/dashboard/D1-11.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">กรอกชื่อประเภทลูกค้าในฟอร์มที่ปรากฏ</p>
                    <img src="../img/dashboard/D1-12.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">กรอกข้อมูลตามรายละเอียดต่อไปนี้:</p>
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2 text-left">ประเภทข้อมูล</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">คำอธิบาย</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">ข้อกำหนด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">ชื่องาน</td>
                                <td class="border border-gray-300 px-4 py-2">ชื่อหัวข้องาน ที่นำแสดงในปฏิทิน</td>
                                <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">รายละเอียด</td>
                                <td class="border border-gray-300 px-4 py-2">รายระเอียดของงานที่ต้องทำ</td>
                                <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">วันที่เริ่ม</td>
                                <td class="border border-gray-300 px-4 py-2">วันที่ต้องเริ่มงานนั้น</td>
                                <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ห้ามเลือกวันที่น้อยกว่าวันปัจจุบัน</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">วันที่สิ้นสุด</td>
                                <td class="border border-gray-300 px-4 py-2">วันที่จบงานนั้น</td>
                                <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ห้ามเลือกวันที่น้อยกว่าวันที่เริ่ม<br>- เลือกวันเดียวกับวันที่เริ่มได้(ระยะเวลา 1 วัน)</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">แจ้งเตือนก่อน (วัน)</td>
                                <td class="border border-gray-300 px-4 py-2">สร้างการแจ้งเตือนในกระดิ่งก่อนวันเริ่มงาน</td>
                                <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ห้ามใส่ค่าติดลบ</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">มอบหมายให้</td>
                                <td class="border border-gray-300 px-4 py-2">การเลือกบุคคลที่สามารถรู้เกี่ยวกับงานนี้</td>
                                <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องเลือก<br>- สามารถเลือกมากกว่า<br>- ควรเลือกตัวเอง(user)ด้วย</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                        <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                            <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                            </svg>
                            ข้อควรระวัง
                        </h4>
                        <ul class="list-disc pl-8 text-gray-700 mt-2">
                            <li>ก่อนเพิ่มงานควรสังเกตว่ามีงานั้นอยู่แล้วหรือไม่เพื่อป้องกันการซ้ำซ้อนของงาน</li>
                            <li>หากมีรายละเอียดควรระบุให้เป้าหมายชัดเจน เพื่อให้ผผู้เกี่ยวข้องเข้าใจเนื้อหา</li>
                            <li>หากเพิ่มงานไปแล้วจะไม่สามารถแก้ไขได้ ทำได้เพียงลบเท่านั้น</li>
                            <li>คนที่มีสิทธิ์ลบงานนั้น มีเพียงคนที่เพิ่มหัวข้องานนั้นมา</li>
                            <li>กำหนดผู้ที่เกี่ยวข้องงานให้ครบถ้วน ก่อนทำการเพิ่มเข้าไป</li>
                            <li>ตัวงานจะไม่ถูกลบออก จนกว่าผู้ที่เพิ่มงานจะลบออกด้วยตนเอง</li>
                        </ul>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold">3.3. การติดตามงานและบิลใกล้หมดสัญญา"</p>
                    <img src="../img/dashboard/D1-13.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <h4 class="font-semibold text-gray-800">การจัดการงาน :</h4>
                        <p class="text-gray-700 text-gl leading-relaxed">ส่วน "งานล่าสุด" แสดงรายการงาน โดยแสดงเฉพาะงานที่เกี่ยวข้องกับผู้ใช้งานที่เข้าสู่ระบบเท่านั้น</p>
                        <ul class="list-disc pl-5">
                            <li>แสดงหัวข้องานและวันที่เริ่ม</li>
                            <li>แสดงหน่าละ 3 งานเพื่อโดยสามารถกดไปหน้าถัดไปหามมีมากกว่า 3 งาน</li>
                        </ul>
                        <h4 class="font-semibold text-gray-800 mt-4">บิลใกล้หมดสัญญา :</h4>
                        <p class="text-gray-700 text-gl leading-relaxed">ส่วน "บิลใกล้หมดสัญญา" แสดงรายการบิลที่จะหมดอายุภายใน 60 วัน เพื่อให้คุณสามารถติดตามและดำเนินการก่อนที่สัญญาจะหมดอายุ</p>
                        <ul class="list-disc pl-5 ">
                            <li>แสดงข้อมูลรายละเอียดที่ใกล้หมดสัญญาภายใน 60 วัน</li>
                            <li>แสดงหน่าละ 3 บิลเพื่อโดยสามารถกดไปหน้าถัดไปหามมีมากกว่า 3 บิล</li>
                        </ul>
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