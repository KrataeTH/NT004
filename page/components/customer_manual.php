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
                                ในหน้าการจัดการลูกค้า สามารถเพิ่ม ลบ แก้ไขข้อมูลลูกค้า และจัดการประเภทของลูกค้าได้
                        </p>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <img src="../img/customer/C0-1.png" alt="ภาพรวมระบบ" class="w-full rounded-lg border border-gray-200 mb-4">
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <h4 class="font-semibold text-gray-800 mb-2">ส่วนประกอบหลัก:</h4>
                                    <ul class="list-disc pl-5">
                                        <li>การจัดการลูกค้าในระบบ</li>
                                        <li>การจัดการประเภทของลูกค้า</li>
                                        <li>การนำเข้าข้อมูลลูกค้า</li>
                                        <li>การค้นหาลูกค้าด้วยตัวกรอง</li>
                                        <li>การแสดงข้อมูลลูกค้า</li>
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
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 2: การจัดการระบบลูกค้า</h3>
                    <p class="text-gray-700 leading-relaxed">
                            ในหน้าการจัดการลูกค้า สามารถเพิ่ม ลบ แก้ไขข้อมูลลูกค้า และจัดการประเภทของลูกค้าได้
                        </p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6"> 
                        
                        <p class="text-gray-700 text-xl font-bold mt-2">2.1. การเพิ่มลูกค้าโดยใช้ฟอร์ม จากปุ่มเพิ่มข้อมูลลูกค้า</p>
                        <img src="../img/customer/C1-1.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">ลักษณะของฟอร์มจะมีดังนี้:</p>
                        <img src="../img/customer/C1-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
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
                                        <td class="border border-gray-300 px-4 py-2">ชื่อลูกค้า</td>
                                        <td class="border border-gray-300 px-4 py-2">ชื่อหน่วยงานที่ใช้บริการ</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่เกิน 100 ตัวอักษร<br>- จำเป็นต้องกรอก<br>- ต้องไม่ซ้ำกับชื่อที่มีอยู่แล้วในระบบ</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">ประเภท</td>
                                        <td class="border border-gray-300 px-4 py-2">ประเภทของลูกค้าที่อยู่ในระบบ</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องเลือก</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">เบอร์โทรศัพท์</td>
                                        <td class="border border-gray-300 px-4 py-2">เบอร์โทรศัพท์และชื่อของลูกค้า</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก<br>- หากกรอกต้องมีอย่างน้อย 9 หลัก</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">สถานะ</td>
                                        <td class="border border-gray-300 px-4 py-2">สถานะการใช้งานของลูกค้า</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องเลือก</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">อำเภอ</td>
                                        <td class="border border-gray-300 px-4 py-2">อำเภอที่ตั้งหน่วยงาน</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องเลือก<br>- เลือกก่อนเพื่อกรองตำบล</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">ตำบล</td>
                                        <td class="border border-gray-300 px-4 py-2">ตำบลที่ตั้งหน่วยงาน</td>
                                        <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องเลือก</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">รายละเอียด</td>
                                        <td class="border border-gray-300 px-4 py-2">รายละเอียดเพิ่มเติมของหน่วยงาน</td>
                                        <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก</td>
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
                                    <li>ชื่อลูกค้าต้องไม่ซ้ำกับที่มีอยู่แล้วในระบบ</li>
                                    <li>เบอร์โทรศัพท์ต้องมีอย่างน้อย 9 หลัก (หากมีการกรอก)</li>
                                    <li>เบอร์โทรศัพท์สามารถใส่ข้อความตามหลังได้</li>
                                    <li>หากไม่มีเบอร์โทรศัพท์ไม่จำเป็นต้องกรอก</li>
                                    <li>เลือกอำเภอก่อนเพื่อระบบจะกรองตำบลในอำเภอนั้น</li>               
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-xl font-bold mt-2">2.2. การแก้ไขข้อมูลลูกค้าโดยใช้ฟอร์ม คลิกที่ปุ่มแก้ไข (ไอคอนดินสอ)</p>
                        <img src="../img/customer/C1-3.png" alt="การเพิ่มลูกค้า" class="w-1/2 mx-auto rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">แก้ไขข้อมูลในฟอร์มที่แสดงขึ้น:</p>
                        <img src="../img/customer/C1-4.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">แก้ไขข้อมูลตามต้องการ โดยยึดตามกฎเกณฑ์เดียวกับการเพิ่มข้อมูลลูกค้า และคลิกปุ่ม "บันทึก" เพื่อบันทึกการเปลี่ยนแปลง</p>
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                                <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                    <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                    </svg>
                                    ข้อควรระวัง
                                </h4>
                                <ul class="list-disc pl-8 text-gray-700 mt-2">
                                    <li>การแก้ไขข้อมูลลูกค้าต้องเปลี่ยนแปลงอย่างระมัดระวัง</li>
                                </ul>
                            </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-xl font-bold mt-2">2.3. การลบข้อมูลลูกค้า คลิกที่ปุ่มลบ (ไอคอนถังขยะ)</p>
                        <img src="../img/customer/C1-5.png" alt="การเพิ่มลูกค้า" class="w-1/2 mx-auto rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">ยืนยันการลบข้อมูลในกล่องข้อความที่ปรากฏและคลิกปุ่ม "ตกลง" เพื่อลบข้อมูลลูกค้า</p>
                        <img src="../img/customer/C1-6.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                            <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                </svg>
                                ข้อควรระวัง
                            </h4>
                            <ul class="list-disc pl-8 text-gray-700 mt-2">
                                <li>การลบข้อมูลลูกค้าไม่สามารถกู้คืนได้</li>
                                <li>ไม่สามารถลบข้อมูลลูกค้าที่ยังมีบิลหรือบริการอยู่ในระบบ</li>
                                <img src="../img/customer/C1-7.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                            </ul>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-xl font-bold mt-2">2.4. การเข้าถึงบิลลูกค้าเฉพาะ คลิกที่บิล (ไอคอนสีฟ้า)</p>
                        <img src="../img/customer/C1-6-1.png" alt="การเพิ่มลูกค้า" class="w-1/2 mx-auto rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-gl leading-relaxed">เป็นการเข้าถึงบิลทั้งหมดของลูกค้าคนนั้น รายละเอียดอธิบายต่อในคู่มือที่หน้า Bill</p>
                    </div>
                </div>
            </div>
            <!-- Page 3 -->
            <div class="manual-page block" id="page3">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 3: การจัดการประเภทลูกค้า</h3>
                    <p class="text-gray-700 leading-relaxed">
                    ในหน้าการจัดการประเภทลูกค้าลูกค้า สามารถเพิ่ม ลบ จัดการประเภทของลูกค้าได้
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold mt-2">3.1. คลิกที่เมนู "การจัดการลูกค้า" เพื่อไปที่หน้าจัดการประเภทลูกค้า</p>
                    <img src="../img/customer/C2-1.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">ระบบจะแสดงหน้าจัดการประเภทลูกค้า</p>
                    <img src="../img/customer/C2-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-xl font-bold mt-2">3.2. การเพิ่มประเภทลูกค้า คลิกที่ปุ่ม "เพิ่มประเภทลูกค้า"</p>
                    <img src="../img/customer/C2-3.png" alt="การเพิ่มลูกค้า" class="w-1/2 mx-auto rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">กรอกชื่อประเภทลูกค้าในฟอร์มที่ปรากฏ</p>
                    <img src="../img/customer/C2-4.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">คลิกปุ่ม "บันทึก" เพื่อบันทึกข้อมูลประเภทลูกค้า</p>
                    <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                        <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                            <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                            </svg>
                            ข้อควรระวัง
                        </h4>
                        <ul class="list-disc pl-8 text-gray-700 mt-2">
                            <li>ชื่อประเภทลูกค้าต้องไม่ซ้ำกับที่มีอยู่แล้วในระบบ</li>
                            <li>ควรตรวจสอบประเภทลูกค้าที่มีอยู่ก่อนเพื่อป้องกันข้อมูลซ้ำซ้อน</li>
                        </ul>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold mt-2">3.3. การแก้ไขประเภทลูกค้า คลิกที่ปุ่มแก้ไข (ไอคอนดินสอ)"</p>
                    <img src="../img/customer/C1-3.png" alt="การเพิ่มลูกค้า" class="w-1/2 mx-auto rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">แก้ไขชื่อประเภทลูกค้าในฟอร์มที่แสดงขึ้น และคลิกปุ่ม "บันทึก" เพื่อบันทึกการเปลี่ยนแปลง</p>
                    <p class="text-gray-700 text-gl leading-relaxed"><strong>หมายเหตุ:</strong>การแก้ไขประเภทลูกค้าจะเปลี่ยนแปลงชื่อประเภทสำหรับลูกค้าทุกรายที่ใช้ประเภทนั้น</p>
                    <img src="../img/customer/C2-5.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold mt-2">3.3. การลบประเภทลูกค้า คลิกที่ปุ่มลบ (ไอคอนถังขยะ)"</p>
                    <img src="../img/customer/C1-5.png" alt="การเพิ่มลูกค้า" class="w-1/2 mx-auto rounded-lg border border-gray-200 mb-4">
                    <p class="text-gray-700 text-gl leading-relaxed">ยืนยันการลบข้อมูลในกล่องข้อความที่ปรากฏ</p>
                    <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                        <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                            <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                            </svg>
                            ข้อควรระวัง
                        </h4>
                        <ul class="list-disc pl-8 text-gray-700 mt-2">
                            <li>สามารถลบประเภทลูกค้าได้เฉพาะกรณีที่ไม่มีลูกค้าใช้ประเภทนั้นอยู่ (จำนวนลูกค้า = 0)</li>
                            <li>ปุ่มลบจะเป็นสีแดงหากสามารถลบได้ และเป็นสีเทาหากไม่สามารถลบได้</li>
                            <img src="../img/customer/C2-6.png" alt="การตรวจสอบการลบ" class="w-full rounded-lg border border-gray-200 mb-4">
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Page 4 -->
            <div class="manual-page block" id="page4">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 4: การนำเข้าข้อมูลลูกค้า</h3>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    ในหน้าการนำเข้าข้อมูลลูกค้า สามารถนำเข้าข้อมูลลูกค้าจากไฟล์ Excel ได้
                </p>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold mt-2">4.1. คลิกที่ปุ่ม "เลือกไฟล์" เพื่อเลือกไฟล์ Excel</p>
                    <p class="text-gray-700 text-gl leading-relaxed">เลือกไฟล์ Excel และคลิกปุ่ม "นำเข้า และคลิกปุ่ม "นำเข้า excel" เพื่อเริ่มการนำเข้าข้อมูล"</p>
                    <img src="../img/customer/C3-1.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <img src="../img/customer/C3-2.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 text-xl font-bold mt-2">4.2. รูปแบบไฟล์ Excel ที่ถูกต้อง</p>
                    <p class="text-gray-700 text-gl leading-relaxed">ไฟล์ Excel ต้องมีรูปแบบและคอลัมน์ตามที่กำหนด:</p>
                    <img src="../img/customer/C3-3.png" alt="การเพิ่มลูกค้า" class="w-full max-w-none rounded-lg border border-gray-200 mb-4">
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
                                    <td class="border border-gray-300 px-4 py-2">Name</td>
                                    <td class="border border-gray-300 px-4 py-2">ชื่อหน่วยงานที่ใช้บริการ</td>
                                    <td class="border border-gray-300 px-4 py-2">- ไม่เกิน 100 ตัวอักษร<br>- จำเป็นต้องกรอก<br>- ต้องไม่ซ้ำกับชื่อที่มีอยู่แล้วในระบบ</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">Type</td>
                                    <td class="border border-gray-300 px-4 py-2">ประเภทของลูกค้า</td>
                                    <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ต้องตรงกับประเภทที่มีอยู่ในระบบ</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Phone</td>
                                    <td class="border border-gray-300 px-4 py-2">เบอร์โทรศัพท์และชื่อของลูกค้า</td>
                                    <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก<br>- หากกรอกต้องมีอย่างน้อย 9 หลัก<br>- สามารถใส่ชื่อตามท้ายได้</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Status</td>
                                    <td class="border border-gray-300 px-4 py-2">สถานะการใช้งานของลูกค้า</td>
                                    <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก("ใช้งาน" หรือ "ไม่ใช้งาน")</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Address</td>
                                    <td class="border border-gray-300 px-4 py-2">รายละเอียดเพิ่มเติมของหน่วยงาน</td>
                                    <td class="border border-gray-300 px-4 py-2">- ไม่จำเป็นต้องกรอก<br>- ใส่ข้อมูลเพิ่มเติมบ่งบอกถึงที่ตั้งของหน่วยงาน</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Tambon</td>
                                    <td class="border border-gray-300 px-4 py-2">อำเภอที่ตั้งหน่วยงาน</td>
                                    <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ใส่ตำบลให้ตรงกับในฐานระบบ(กาญจนบุรี)</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Amphure</td>
                                    <td class="border border-gray-300 px-4 py-2">ตำบลที่ตั้งหน่วยงาน</td>
                                    <td class="border border-gray-300 px-4 py-2">- จำเป็นต้องกรอก<br>- ใส่อำเภอให้ตรงกับในฐานระบบ(กาญจนบุรี) <br>- ใส่อำเภอให้ตรงกับตำบลที่เกี่ยวข้อง</td>
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
                                <li>ชื่อลูกค้าต้องไม่ซ้ำกับที่มีอยู่แล้วในระบบ</li>
                                <li>ประเภทของลูกค้ามีอยู่ในฐานระบบ</li>
                                <li>หากตรวจสอบเจอชื่อซ้ำในระบบ จะไม่นำเข้าข้อมูล</li>
                                <li>เบอร์โทรศัพท์สามารถใส่ข้อความตามหลังได้</li>
                                <li>หากไม่มีเบอร์โทรศัพท์ไม่จำเป็นต้องกรอก</li>
                                <li>เบอร์โทรศัพท์ต้องมีอย่างน้อย 9-10 หลัก</li>
                                <li>ใส่อำเภอและตำบลให้ถูกต้อง หากผิดพลาดจะไม่นำเข้าข้อูล</li>               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 5 -->
            <div class="manual-page hidden" id="page5">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">หน้าที่ 5: การกรองข้อมูลลูกค้า</h3>
                    <p class="text-gray-700 leading-relaxed">
                            ในหน้าการกรองข้อมูลลูกค้า สามารถกรองข้อมูลลูกค้าตามเงื่อนไขที่ต้องการได้ สามารถใช้เพื่อค้นหาข้อมูลลูกค้าที่ต้องการ โดยมีดังนี้
                    </p>
                    <img src="../img/customer/C3-4.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700 text-xl font-bold mt-2">5.1.การค้นหาด้วยชื่อ : สามารถพิมพ์ชื่อหน่วยงานเพื่อใช้ในการค้นหา</p>
                        <img src="../img/customer/C3-5.png" alt="การเพิ่มลูกค้า" class="w-full rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-xl font-bold mt-2">5.2.การค้นหาด้วยประเภท : เลือกประเภทของลูกค้าเพื่อกรองข้อมูลลูกค้าในประเภทนั้น</p>
                        <img src="../img/customer/C3-6.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-xl font-bold mt-2">5.3.การค้นหาด้วยอำเภอและตำบล : เลือกอำเภอและตำบลเพื่อกรองลูกค้าที่อยู่ในพื้นที่ดังกล่าว</p>
                        <img src="../img/customer/C3-7.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                        <p class="text-gray-700 text-xl font-bold mt-2">5.4.ปุ่มรีเช็ต : ไว้สำหรับรีเช็ตข้อมูลลูกค้าที่ใช้กรอง</p>
                        <img src="../img/customer/C3-8.png" alt="การเพิ่มลูกค้า" class="w-1/2 rounded-lg border border-gray-200 mb-4">
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500 mt-6">
                            <h4 class="text-lg font-bold text-yellow-700 flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.766-1.36 2.72-1.36 3.486 0l6.518 11.57c.746 1.325-.187 2.981-1.743 2.981H3.482c-1.556 0-2.489-1.656-1.743-2.981l6.518-11.57zM11 14a1 1 0 11-2 0 1 1 0 012 0zm-1-2a1 1 0 001-1V7a1 1 0 00-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                </svg>
                                ข้อควรระวัง
                            </h4>
                            <ul class="list-disc pl-8 text-gray-700 mt-2">
                                <li>การกรองข้อมูลลูกค้าจะต้องใช้ข้อมูลที่ถูกต้องเท่านั้น</li>
                                <li>หากไม่มีข้อมูลที่ตรงกับในระบบจะไม่แสดงข้อมูลใดๆ</li>              
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