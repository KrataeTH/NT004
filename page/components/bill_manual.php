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
                            ในหน้าการจัดการบิลลูกค้า สามารถเพิ่ม ลบ แก้ไขข้อมูลบิลลูกค้า แบ่งออกเป็น 2 กรณี
                        </p>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <div class="grid md:grid-cols-1 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <h4 class="font-semibold text-gray-800 mb-2">กรณีที่ เข้าผ่านเมนู Bill</h4>
                                    <img src="../img/bill/b0-3.png" alt="ภาพรวมระบบ" class="w-1/4 rounded-lg border border-gray-200 mb-4">
                                    <img src="../img/bill/b0-1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                                    <h4 class="font-semibold text-gray-800 mb-2">ส่วนประกอบหลัก: </h4>
                                    <ul class="list-disc pl-5">
                                        <li>การจัดการบิลลูกค้าทั้งหมดในระบบ</li>
                                        <li>การค้นหาบิลลูกค้าด้วยตัวกรอง</li>
                                        <li>แสดงรายการบิลทั้งหมดของลูกค้า</li>
                                        <li>การต่อสัญญาเมื่อบิลใกล้หมดอายุ</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <div class="grid md:grid-cols-1 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <h4 class="font-semibold text-gray-800 mb-2">กรณีที่ เข้าบิล ในหน้า customer</h4>
                                    <img src="../img/bill/b0-4.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                                    <img src="../img/bill/b0-2.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                                    <h4 class="font-semibold text-gray-800 mb-2">ส่วนประกอบหลัก: </h4>
                                    <ul class="list-disc pl-5">
                                        <li>การจัดการบิลลูกค้าเจาะจงในระบบ</li>
                                        <li>การนำเข้าข้อมูลบิลและบริการลูกค้า</li>
                                        <li>การค้นหาบิลลูกค้าด้วยตัวกรอง</li>
                                        <li>การต่อสัญญาเมื่อบิลใกล้หมดอายุ</li>
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
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 2: การจัดการระบบบิลลูกค้า</h3>
                    <p class="text-gray-700 leading-relaxed">
                            ในหน้าการจัดการบิลลูกค้า สามารถเพิ่ม ลบ แก้ไขข้อมูลลูกค้า
                        </p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6"> 
                        
                        <p class="text-gray-700 text-xl font-bold mt-2">2.1. การเพิ่มบิลลูกค้าโดยใช้ฟอร์ม จากปุ่มเพิ่มข้อมูลลูกค้า</p>
                        <img src="../img/bill/B1-1.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">ลักษณะของฟอร์มจะมีดังนี้:</p>
                        <p class="text-gray-700 text-gl leading-relaxed">-กรณีเข้าผ่านหน้าบิล</p>
                        <img src="../img/bill/B1-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">-กรณีเข้าผ่านหน้าลูกค้า :</p>
                        <img src="../img/bill/B1-3.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">กรอกข้อมูลตามรายละเอียดต่อไปนี้:</p>
                        <!-- ตารางแสดงข้อมูล -->
                        <div class="overflow-x-auto">
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
                                        <td class="border border-gray-300 px-4 py-2">หมายเลขบิล</td>
                                        <td class="border border-gray-300 px-4 py-2">เลขเสียภาษีอากรประจำตัวขอลูกค้า</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่เกิน 50 ตัวอักษร<br>- จำเป็นต้องกรอก<br>- ต้องไม่ซ้ำกับชื่อที่มีอยู่แล้วในระบบ <br>- สามาระบุเลขครั้งต่อหลังได้(ไม่ซ้ำ)</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">เลือกลูกค้า (กรณีที่เข้าผ่าน bill)</td>
                                        <td class="border border-gray-300 px-4 py-2">ประเภทของลูกค้าที่อยู่ในระบบ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องเลือก</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">วันที่เริ่มสัญญา</td>
                                        <td class="border border-gray-300 px-4 py-2">วันที่เริ่มสัญญาบิล</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ระบุวันที่ให้ถูกต้อง(วันที่เริ่มบริการตัวแรกสุด)</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">ระยะสัญญา (เดือน)</td>
                                        <td class="border border-gray-300 px-4 py-2">ระบุจำนวนเดือนของระยะสัญญา</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก <br>- ไม่ใส่จำนวนติดลบ <br>- ใส่เป็นเลขจำนวนเต็ม <br>- ระยะสัญญาจะนำไปคำนวณหาวันสิ้นสุดของสัญญา</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">ประเภทของบิล</td>
                                        <td class="border border-gray-300 px-4 py-2">ประเภทของบิลท่อยู่ในระบบ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องเลือก</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">สถานะของบิล</td>
                                        <td class="border border-gray-300 px-4 py-2">สถานะปัจจุบันของบิลนี้</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องเลือก </td>
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
                                <ul class="list-disc pl-6 text-gray-700 mt-2">
                                    <li><strong>หมายเลขบิล</strong>ควรใส่หมายเลขของผู้เสียอากร(tax-id) ตามด้วยลำดับบิล เช่น 0994002450289-01 0994002450289-02</li>
                                    <li>ไม่ระบุเลขบิลที่ซ้ำกับในระบบ</li>
                                    <li>วันเริ่มสัญญาควรเลือกวันที่เริ่มต้นบริการที่นานที่สุดในบิลนั้น</li>
                                    <li><strong>ระยะสัญญาบิล</strong>จะถูกคำนวณเป็นจำนวน การกรอกจะคำนวณแค่เดือนเท่านั้นโดยจะนำไปคำนวณวันที่เริ่มสัญญา</li>
                                    <li><strong>สถานะบิล</strong>จะส่งต่อรายงาน การสรุปผลรายได้ หากบิลนั้นถูกยกเลิกไปหมายถึง ไม่ได้รับรายได้หรือหมดสัญญาบิลนั้นไปแล้ว</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-xl font-bold mt-2">2.2. การแก้ไขข้อมูลลูกค้าโดยใช้ฟอร์ม คลิกที่ปุ่มแก้ไข (ไอคอนดินสอ)</p>
                        <img src="../img/customer/C1-3.png" alt="การเพิ่มลูกค้า" class="w-1/2 mx-auto rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">ลักษณะของฟอร์มจะมีดังนี้:</p>
                        <p class="text-gray-700 text-gl leading-relaxed">-กรณีเข้าผ่านหน้าบิล</p>
                        <img src="../img/bill/B1-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">-กรณีเข้าผ่านหน้าลูกค้า :</p>
                        <img src="../img/bill/B1-3.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">แก้ไขข้อมูลตามต้องการ โดยยึดตามกฎเกณฑ์เดียวกับการเพิ่มข้อมูลบิลลูกค้า และคลิกปุ่ม "บันทึก" เพื่อบันทึกการเปลี่ยนแปลง:</p>
                        <p class="text-gray-700 text-gl leading-relaxed"><strong>หมายเหตุ:</strong>การเปลี่ยนประเภทบิล การเปลี่ยนลูกค้า และสถานะบิลจะส่งผลให้มีการเปลี่ยนแปลของรายงานและการสรุปผล</p>
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                            <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                </svg>
                                ข้อควรระวัง
                            </h4>
                            <ul class="list-disc pl-6 text-gray-700 mt-2">
                                <li>การเปลี่ยนหมายเลขบิลอาจส่งผลกระทบให้รูปแบบไม่ถูกต้อง แนะนำให้เรียงลำดับจากเก่าไปใหม่</li>
                                <li>การเปลี่ยนลูกค้านั้นปกติไม่ควรทำ เพราะหมายถึงการนำบิลรายการนี้ไปอยู่ในลูกค้าที่เปลี่ยนใหม่</li>
                                <li>การเปลี่ยนวันเริ่มสัญญานั้นปกติไม่ควรทำ ยกเว้นหากใส่ผิดหรือต้องการเปลี่ยนให้ตรงกับบิลใหม่</li>
                                <li>หากมีการเปลี่ยนแปลงการทำ soultion โดยใช้บิลให้วันเริ่มสัญญาใช้วันที่เริ่ม soultion นั้น</li>
                                <li>การเปลี่ยนแปลงระยะสัญญา จะถูกคำนวณใหม่กับววันที่เริ่มสัญญาใหม่ ทำให้ได้วันที่สิ้นสุดสัญญาใหม่</li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-xl font-bold mt-2">2.3. การลบข้อมูลบิลลูกค้า คลิกที่ปุ่มลบ (ไอคอนถังขยะ)</p>
                        <img src="../img/customer/C1-5.png" alt="การเพิ่มลูกค้า" class="w-1/2 mx-auto rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">ยืนยันการลบข้อมูลในกล่องข้อความที่ปรากฏและคลิกปุ่ม "ตกลง" เพื่อลบข้อมูลบิลลูกค้า</p>
                        <img src="../img/bill/B1-6.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                            <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                </svg>
                                ข้อควรระวัง
                            </h4>
                            <ul class="list-disc pl-8 text-gray-700 mt-2">
                                <li>การลบข้อมูลบิลลูกค้าไม่สามารถกู้คืนได้</li>
                                <li>ไม่สามารถลบข้อมูลบิลลูกค้าที่ยังบริการและอุปกรณ์ที่เกี่ยวข้องอยู่ในระบบ</li>
                                <img src="../img/bill/B1-7.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                            </ul>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-xl font-bold mt-2">2.4. การเข้าถึงบริการลูกค้าเฉพาะ คลิกที่ info (ไอคอนสีฟ้า)</p>
                        <img src="../img/bill/B1-8.png" alt="การเพิ่มลูกค้า" class="w-1/4 mx-auto rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">เป็นการเข้าถึงบริการทั้งหมดของลูกค้าคนนั้น รายละเอียดอธิบายต่อในคู่มือที่หน้า Services</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-xl font-bold mt-2">2.5. การต่อสัญญา คลิ่กทีต่อสัญญา (ไอคอนสีเขียว)</p>
                        <img src="../img/bill/B1-9.png" alt="การเพิ่มลูกค้า" class="w-1/4 mx-auto rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed"><strong>เงื่อนไขการแสดง : </strong>ต้องเป็นบิลที่มีวันที่สิ้นสุดภายในระยะ 60 วัน โดยจะมีให้เลือก "ต่อสัญญา" หรือ "ยกเลิกสัญญา"</p>
                        <img src="../img/bill/b1-10.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                        <div class="grid md:grid-cols-1 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-2">กรณีต่อสัญญา จะต้องระบุระยะสัญญาใหม่</h4>
                                <img src="../img/bill/b1-11.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">ผลลัพธ์: </h4>
                                <ul class="list-disc pl-5">
                                    <li>สถานะของบิลยังคงเป็นใช้งาน</li>
                                    <li>วันสิ้นสุดของบิลจะถูกคำนวณใหม่</li>
                                    <li>วันที่เริ่มสัญญาจะเปลี่ยนแปลง</li>
                                </ul>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-1 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-2">กรณีไม่ต่อสัญญา เลือก ยกสัญญา กดตกลง</h4>
                                <img src="../img/bill/b1-12.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">ผลลัพธ์: </h4>
                                <ul class="list-disc pl-5">
                                    <li>สถานะของบิลยังเป็นไม่ใช้งานอัตโนมัติ</li>
                                    <li>ระบบจะถือว่าบิลถูกยกเลิกและไม่นำไปคำนวณรายได้</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 3 -->
            <div class="manual-page block" id="page3">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 3: การนำเข้าข้อมูลบิลและบริการลูกค้า</h3>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    ในหน้าการนำเข้าข้อมูลลูกค้า สามารถนำเข้าข้อมูลลูกค้าจากไฟล์ Excel ได้ โดยมี บิล บริการ อุปกรณ์ แพ็คเก็จ
                </p>
                <p class="text-gray-700 leading-relaxed"><strong>หมายเหตุ : </strong>การนำเข้าไฟล์ Excel ทำได้เฉพาะกรณีกดบิลในหน้า customer</p>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold mt-2">4.1. คลิกที่ปุ่ม "เลือกไฟล์" เพื่อเลือกไฟล์ Excel</p>
                    <p class="text-gray-700 text-gl leading-relaxed">เลือกไฟล์ Excel และคลิกปุ่ม "นำเข้า และคลิกปุ่ม "นำเข้า excel" เพื่อเริ่มการนำเข้าข้อมูล"</p>
                    <img src="../img/bill/B2-1.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <img src="../img/bill/B2-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold mt-2">4.2. รูปแบบไฟล์ Excel ที่ถูกต้อง</p>
                    <p class="text-gray-700 text-gl leading-relaxed">ไฟล์ Excel ต้องมีรูปแบบและคอลัมน์ตามที่กำหนด โดยจะมี 4 หัวข้อดังนี้้ :</p>
                    <h4 class="font-semibold text-gray-800 mb-2">ชื่อตารางดังนี้้ : </h4>
                        <ul class="list-disc pl-5">
                            <li>Bill : จำเป็น</li>
                            <li>Services : ไม่จำเป็น</li>
                            <li>Gedget : ไม่จำเป็น</li>
                            <li>Package : ไม่จำเป็นแต่ต้องมี Services ก่อนถึงจะสามารถมีได้</li>
                        </ul>
                    <img src="../img/bill/B2-3.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-gl leading-relaxed"><strong>ตาราง Bill(บังคับ) : </strong>ตารางข้อมูลรายละเอียดเกี่ยวข้องกับบิล</p>
                        <img src="../img/bill/B2-4.png" alt="การเพิ่มลูกค้า" class="w-full max-w-none rounded-lg border border-gray-200 mb-4">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-300 px-4 py-2 text-left">ชื่อหัวตาราง</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">คำอธิบาย</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">ข้อกำหนด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Number</td>
                                        <td class="border border-gray-300 px-4 py-2">เลขเสียภาษีอากรประจำตัวขอลูกค้า</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่เกิน 50 ตัวอักษร<br>- จำเป็นต้องกรอก<br>- หากซ้ำกับระบบจะเป็นการอัปเดตข้อมูลแทน <br>- สามาระบุเลขครั้งต่อหลังได้(ไม่ซ้ำ)</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">Type</td>
                                        <td class="border border-gray-300 px-4 py-2">ประเภทของลูกค้าที่อยู่ในระบบ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องตรงกับประเภทที่มีอยู่ในระบบ ('CIP+','Special Bill','Nt1')</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Status</td>
                                        <td class="border border-gray-300 px-4 py-2">สถานะของบิลนี้</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- จำเป็นต้องกรอก("ใช้งาน" หรือ "ยกเลิกใช้งาน")</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Start</td>
                                        <td class="border border-gray-300 px-4 py-2">วันที่เริ่มสัญญาบิล</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องเป็นรูปแบบวันที่ที่ถูกต้อง (ปี-เดือน-วัน)</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Contact(Month)</td>
                                        <td class="border border-gray-300 px-4 py-2">ระบุจำนวนเดือนของระยะสัญญา</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>-  ต้องเป็นจำนวนเต็มที่เป็นบวก</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                            <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                </svg>
                                ข้อควรระวัง
                            </h4>
                            <ul class="list-disc pl-8 text-gray-700 mt-2">
                                <li>หากตรวจพบหมายเลขบิลในระบบ จะทำการอัปเดตข้อมูล</li>
                                <li>ประเภทของลูกค้ามีอยู่ในฐานระบบ</li>
                                <li>หากพบข้อผิดพลาดจะไม่สามารถนำข้อมูลเข้าได้</li>       
                            </ul>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-gl leading-relaxed"><strong>ตาราง Services(ไม่บังคับ) : </strong>ตารางข้อมูลรายละเอียดเกี่ยวข้องกับบริการ ไม่จำเป็นต้องมีตารางนี้สามารถนำเข้าข้อมูลได้ปกติ</p>
                        <img src="../img/bill/B2-5.png" alt="การเพิ่มลูกค้า" class="w-full max-w-none rounded-lg border border-gray-200 mb-4">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-300 px-4 py-2 text-left">ชื่อหัวตาราง</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">คำอธิบาย</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">ข้อกำหนด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Number</td>
                                        <td class="border border-gray-300 px-4 py-2">เลขเสียภาษีอากรประจำตัวขอลูกค้า(ไว้เชื่อมกับตาราง Bill ก่อนหน้า)</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่เกิน 50 ตัวอักษร<br>- จำเป็นต้องกรอก <br>- สามาระบุเลขครั้งต่อหลังได้(ไม่ซ้ำ)<br>- ต้องตรงกับ Excel ตาราง Bill</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">Code</td>
                                        <td class="border border-gray-300 px-4 py-2">รหัสบริการ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- หากซ้ำกับระบบจะเป็นการอัปเดตข้อมูลแทน </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Type</td>
                                        <td class="border border-gray-300 px-4 py-2">ประเภทของบริการที่อยู่ในระบบ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องตรงกับประเภทที่มีอยู่ในระบบ เช่น Fttx, Fttx+ICT solution, IP phone</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Gadget</td>
                                        <td class="border border-gray-300 px-4 py-2">ประเภทของอุปกรณ์</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องตรงกับประเภทที่มีอยู่ในระบบ ('เช่า','ขาย','เช่าและขาย')</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Status</td>
                                        <td class="border border-gray-300 px-4 py-2">สถานะของบบริการนี้</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- จำเป็นต้องกรอก("ใช้งาน" หรือ "ยกเลิกใช้งาน")</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Start</td>
                                        <td class="border border-gray-300 px-4 py-2">วันที่เริ่มใช้บริการ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องเป็นรูปแบบวันที่ที่ถูกต้อง (ปี-เดือน-วัน)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                            <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                </svg>
                                ข้อควรระวัง
                            </h4>
                            <ul class="list-disc pl-8 text-gray-700 mt-2">
                                <li>ระบุหมายเลขบิลให้ตรงกับในตาราง Bill หากไม่ตรงจะไม่สามารถเพิ่มข้อมูลได้</li>
                                <li>ระบุรหัสบริการใให้ตรงกับหมายเลขบิลนั้น</li>
                                <li>หากตรวจพบรหัสบริการในบิลนั้นของระบบ จะทำการอัปเดตข้อมูล</li>
                                <li>หากหมายเลขบริการของบิลเดียววกันซ้ำ ระบบจะอัปเดตข้อมูลแถวล่าสุด</li>
                                <li>หากพบข้อผิดพลาดจะไม่สามารถนำข้อมูลเข้าได้</li>
                                <li>ใส่ประเภทของบริการและอุปกรณ์ให้ถูกต้อง</li>         
                            </ul>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-gl leading-relaxed"><strong>ตาราง Gedget(ไม่บังคับ) : </strong>ตารางข้อมูลรายละเอียดเกี่ยวข้องกับอุปกรณ์ ไม่จำเป็นต้องมีตารางนี้สามารถนำเข้าข้อมูลได้ปกติ</p>
                        <img src="../img/bill/B2-7.png" alt="การเพิ่มลูกค้า" class="w-full max-w-none rounded-lg border border-gray-200 mb-4">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-300 px-4 py-2 text-left">ชื่อหัวตาราง</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">คำอธิบาย</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">ข้อกำหนด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Number</td>
                                        <td class="border border-gray-300 px-4 py-2">เลขเสียภาษีอากรประจำตัวขอลูกค้า(ไว้เชื่อมกับตาราง Bill ก่อนหน้า)</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่เกิน 50 ตัวอักษร<br>- จำเป็นต้องกรอก<br>- สามาระบุเลขครั้งต่อหลังได้(ไม่ซ้ำ)<br>- ต้องตรงกับ Excel ตาราง Bill</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Name Device</td>
                                        <td class="border border-gray-300 px-4 py-2">ชื่อของอุปกรณ์</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ไม่เกิน 100 ตัวอักษร <br>- หากมีอุปกรณ์มากกว่าให้ระบบุลำดับตามท้าย</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Start</td>
                                        <td class="border border-gray-300 px-4 py-2">วันที่เริ่มใช้อุปกรณ์</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องเป็นรูปแบบวันที่ที่ถูกต้อง (ปี-เดือน-วัน)</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Detail</td>
                                        <td class="border border-gray-300 px-4 py-2">รายละเอียดของอุปกรณ์</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก<br>- ระบุรายละเกี่ยวกับตัวอุปกรณ์(หากมี)</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Status</td>
                                        <td class="border border-gray-300 px-4 py-2">สถานะของอุปกรณ์</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- จำเป็นต้องกรอก("ใช้งาน" หรือ "ยกเลิก")</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                            <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                </svg>
                                ข้อควรระวัง
                            </h4>
                            <ul class="list-disc pl-8 text-gray-700 mt-2">
                                <li>ระบุหมายเลขบิลให้ตรงกับในตาราง Bill หากไม่ตรงจะไม่สามารถเพิ่มข้อมูลได้</li>
                                <li>ระบุบชื่ออุปกรณ์ให้ตรงกับหมายเลขบิลนั้น</li>
                                <li>หากตรวจพบชื่ออุปกรณที่ตรงในบิลนั้นของระบบ จะทำการอัปเดตข้อมูล</li>
                                <li>หากชื่ออุปกรณ์ของบิลเดียวกันซ้ำ ระบบจะอัปเดตข้อมูลแถวล่าสุด</li>
                                <li>หากพบข้อผิดพลาดจะไม่สามารถนำข้อมูลเข้าได้</li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-gl leading-relaxed"><strong>ตาราง Package(ไม่บังคับ) : </strong>ตารางข้อมูลรายละเอียดเกี่ยวข้องกับแพ็คเกจ โปรดักและราคา ไม่จำเป็นต้องมีตารางนี้สามารถนำเข้าข้อมูลได้ปกติ</p>
                        <p class="text-gray-700 text-gl leading-relaxed"><strong>หมายเหตุ :</strong> ตารางนี้จะต้องมี Services ก่อนถึงจะสามารถนำเข้าได้</p>
                        <img src="../img/bill/B2-8.png" alt="การเพิ่มลูกค้า" class="w-full max-w-none rounded-lg border border-gray-200 mb-4">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-300 px-4 py-2 text-left">ชื่อหัวตาราง</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">คำอธิบาย</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">ข้อกำหนด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">Code</td>
                                        <td class="border border-gray-300 px-4 py-2">รหัสบริการ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องตรงกับ Excel ตาราง Service </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Package Name</td>
                                        <td class="border border-gray-300 px-4 py-2">ชื่อแพ็คเกจ</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่เกิน 100 ตัวอักษร<br>- จำเป็นต้องกรอก<br></td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Package Detail</td>
                                        <td class="border border-gray-300 px-4 py-2">รายละเอียดแพ็คเกจ</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก<br>- ระบุรายละเกี่ยวกับแพ็คเกจ(หากมี)</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Status Package</td>
                                        <td class="border border-gray-300 px-4 py-2">สถานะของแพ็คเกจ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- จำเป็นต้องกรอก("ใช้งาน" หรือ "ยกเลิก")</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Product Name</td>
                                        <td class="border border-gray-300 px-4 py-2">ชื่อสินค้าในแพ็คเกจ</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่เกิน 100 ตัวอักษร<br>- จำเป็นต้องกรอก<br></td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Product Detail</td>
                                        <td class="border border-gray-300 px-4 py-2">รายละเอียดสินค้าในแพ็คเกจ</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก<br>- ระบุรายละเกี่ยวกับแพ็คเกจ(หากมี)</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Status Product</td>
                                        <td class="border border-gray-300 px-4 py-2">สถานะของแพ็คเกจ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- จำเป็นต้องกรอก("ใช้งาน" หรือ "ยกเลิก")</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Main Package</td>
                                        <td class="border border-gray-300 px-4 py-2">ราคา Main Package</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- จำนวนสามารถเป็นทศนิยม <br>- ห้ามเป็นจำนวนติดลบ</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">ICT</td>
                                        <td class="border border-gray-300 px-4 py-2">ราคา ICT</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- จำนวนสามารถเป็นทศนิยม <br>- ห้ามเป็นจำนวนติดลบ <br>- หากไม่มีให้ใส่ 0</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Override Detail</td>
                                        <td class="border border-gray-300 px-4 py-2">รายละเอียดของราคา</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก<br>- ระบุรายละเกี่ยวกับราคา(หากมี)</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">Start</td>
                                        <td class="border border-gray-300 px-4 py-2">วันที่เริ่มต้นProduct</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องเป็นรูปแบบวันที่ที่ถูกต้อง (ปี-เดือน-วัน)</td>   
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                            <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                </svg>
                                ข้อควรระวัง
                            </h4>
                            <ul class="list-disc pl-8 text-gray-700 mt-2">
                                <li>ระบุรหัสบริการให้ตรงกับในตาราง Service หากไม่ตรงจะไม่สามารถเพิ่มข้อมูลได้</li>
                                <li>ระบุชื่อแพ็คเกจใให้ตรงกับรหัสบริการนั้้นนั้น</li>
                                <li>หากชื่อแพ็คเกจเดียยวกันจะตรวจสอบรายละเอียด หากรายละเอียดเหมือนกันจะอัปเดตแทน</li>
                                <li>หากพบข้อผิดพลาดจะไม่สามารถนำข้อมูลเข้าได้</li>
                                <li>ใส่ราคาของแพ็คเกจให้ถูกต้อง</li>
                                <li>ใน 1 แพ็คเกจนั้นจะมีหลายโปรดัก แต่ระบบจะทำการบังคับให้มีแค่ 1 โปรดักที่ใช้งานโดยจะแถวที่โปรดักใช้งานแถวล่าสุด</li>
                                <li>สถานะต้องใส่ให้ถูกต้องตามที่กำหนด</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 4 -->
            <div class="manual-page hidden" id="page5">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 4: การกรองข้อมูลบิลลูกค้า</h3>
                    <p class="text-gray-700 leading-relaxed">
                            ในหน้าการกรองข้อมูลบิลลูกค้า สามารถกรองข้อมูลลูกค้าตามเงื่อนไขที่ต้องการได้ สามารถใช้เพื่อค้นหาข้อมูลบิลลูกค้าที่ต้องการ โดยมี 2 กรณีดังนี้
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="grid md:grid-cols-1 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-2">กรณีที่ เข้าผ่านเมนู Bill</h4>
                                <img src="../img/bill/B2-10.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">ส่วนประกอบหลัก: </h4>
                                <ul class="list-disc pl-5">
                                    <li><strong>1.ค้นหาด้วยชื่อลูกค้า </strong> ใส่ชื่อลูกค้า</li>
                                    <li><strong>2.ค้นหาด้วยหมายเลขบิล </strong>ใส่เลขเสียภาษีอากรลูกค้าตามด้วยลำดับที่ต้องการเข้าถึง</li>
                                    <li><strong>3.กรองประเภทบบิล </strong>เลือกประเภทของบิล</li>
                                    <li><strong>4.กรองสถานการใช้งาน </strong>เลือกสถานะของบิล</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="grid md:grid-cols-1 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-2">กรณีที่ เข้าบิล ในหน้า customer</h4>
                                <img src="../img/bill/B2-9.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">ส่วนประกอบหลัก: </h4>
                                <ul class="list-disc pl-5">
                                    <li><strong>1.ค้นหาด้วยหมายเลขบิล </strong>ใส่เลขเสียภาษีอากรลูกค้าตามด้วยลำดับที่ต้องการเข้าถึง</li>
                                    <li><strong>2.กรองประเภทบบิล </strong>เลือกประเภทของบิล</li>
                                    <li><strong>3.กรองสถานการใช้งาน </strong>เลือกสถานะของบิล</li>
                                </ul>
                            </div>
                        </div>
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