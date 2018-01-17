<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php 
  ob_start();
  include_once(dirname(__DIR__, 3)."/components/head-print.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ปพ.6";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>

<body class="A4">

  <nav class="navbar navbar-inverse navbar-top navbar-fixed-bottom" style="border-radius: 0;">
    <div class="container-fluid">
      <h3 class="navbar-text">ปพ.6</h3>
      <button class="btn btn-primary navbar-btn pull-right" id="printBtn"><i class="fas fa-print fa-fw"></i> Print</button>
    </div>
  </nav>

  <section class="sheet padding-10mm">
    <article class="row">

      <div class="col-xs-12">
        <img class="" src="../../../assets/img/logo.png" width="100" height="100" alt="logo" style="position: absolute;">
        <div class="col-xs-12" style="padding-left: 3mm;font-size: 20px;font-weight: bold;">
          <div class="col-xs-12 text-center">
            <span class="">รายงานการพัฒนาคุณภาพผู้เรียนเป็นรายบุคคล</span>
          </div>
          <div style="position: absolute;right: 5mm;">
            <span>ปพ.6</span>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="col-xs-12 text-center" style="font-size: 18px;font-weight: bold; margin-bottom: 3mm;">
            <span class="">โรงเรียนประชาภิบาล</span>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="col-xs-2 col-xs-offset-2 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">ชื่อ - สกุล</span>
          </div>
          <div class="col-xs-4 text-center" style="font-size: 16px;">
            <span>เด็กชายอะไร สักอย่าง</span>
          </div>
          <div class="col-xs-2 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">เลขประจำตัว</span>
          </div>
          <div class="col-xs-2 text-center" style="font-size: 16px;">
            <span>0000</span>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="col-xs-2 col-xs-offset-2 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">ชั้นประถมศึกษาปีที่</span>
          </div>
          <div class="col-xs-1" style="font-size: 16px;">
            <span>1/1</span>
          </div>
          <div class="col-xs-1 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">เลขที่</span>
          </div>
          <div class="col-xs-1 text-center">
            <span class="" style="font-size: 16px;font-weight: bold;">99</span>
          </div>
          <div class="col-xs-2 col-xs-offset-1 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">ปีการศึกษา</span>
          </div>
          <div class="col-xs-2 text-center" style="font-size: 16px;">
            <span>9999</span>
          </div>
        </div>

        <div class="col-xs-12">
          <table width="100%">
            <thead>
              <tr>
                <th>เวลาเรียน</th>
                <th>ป่วย (วัน)</th>
                <th>ลา (วัน)</th>
                <th>ขาด (วัน)</th>
                <th>มาเรียน (วัน)</th>
                <th>รวมมาเรียนตลอดปี</th>
                <th>คิดเป็นร้อยละ</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>ภาคเรียนที่ 1</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td rowspan="2">0</td>
                <td rowspan="2">0</td>
              </tr>
              <tr>
                <td>ภาคเรียนที่ 2</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 text-center" style="font-size: 16px;font-weight: bold;">
          <span>ผลการประเมินสาระการเรียนรู้</span>
        </div>

        <div class="col-xs-12">
          <table width="100%">
            <colgroup>
              <col>
              </col>
            </colgroup>
            <thead>
              <tr>
                <th rowspan="2">ที่</th>
                <th rowspan="2" colspan="3">รายวิชา</th>
                <th rowspan="2">รหัสวิชา</th>
                <th rowspan="2">น้ำหนัก</th>
                <th>คะแนน</th>
                <th>คะแนน</th>
                <th>ระดับ</th>
                <th rowspan="2">หมายเหตุ</th>
              </tr>
              <tr>
                <th>ภาคเรียนที่ 1</th>
                <th>ภาคเรียนที่ 2</th>
                <th>ผลการเรียน</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>0</th>
                <td colspan="3">subject</td>
                <td>sid</td>
                <td>credit</td>
                <td>score 1</td>
                <td>score 2</td>
                <td>grade</td>
                <td>type</td>
              </tr>
              <tr>
                <th>&nbsp;</th>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>&nbsp;</th>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>&nbsp;</th>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>&nbsp;</th>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>&nbsp;</th>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>&nbsp;</th>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>&nbsp;</th>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12">
          <table width="100%" style="border-top-style: hidden;">
            <tbody>
              <tr>
                <th>ตลอดปีการศึกษา</th>
                <td>000</td>
                <th>ชั่วโมง</th>
                <th>ผลการเรียนเฉลี่ย</th>
                <td>0.00</td>
                <th>รวมคะแนน</th>
                <td>000</td>
                <th>อันดับที่</th>
                <td>0</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 text-center" style="font-size: 16px;font-weight: bold;">
          <span>ผลการประเมินคุณลักษณะอันพึงประสงค์</span>
        </div>

        <div class="col-xs-12">
          <table width="100%">
            <thead>
              <tr>
                <th>ที่</th>
                <th>คุณลักษณะอันพึงประสงค์</th>
                <th>ภาคเรียนที่ 1</th>
                <th>ภาคเรียนที่ 2</th>
                <th>สรุปผลการประเมิน</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1</th>
                <td>รักชาติ ศาสน์ กษัตริย์</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>2</th>
                <td>ซื่อสัตย์สุจริต</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>3</th>
                <td>มีวินัย</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>4</th>
                <td>ไฝ่เรียนรู้</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>5</th>
                <td>อยู่อย่างพอเพียง</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>6</th>
                <td>มุ่งมั่นในการทำงาน</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>7</th>
                <td>รักความเป็นไทย</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <th>8</th>
                <td>มีจิตสาธารณะ</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12" style="padding-top: 1mm;">
          <table width="100%">
            <tbody>
              <tr>
                <th style="font-size: 16px;font-weight: bold;">ผลการประเมินการอ่าน คิดวิเคราะห์ และการเขียนสื่อความ</th>
                <td>ผลลลล</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 text-center" style="font-size: 16px;font-weight: bold;">
          <span>การประเมินกิจกรรมพัฒนาผู้เรียน</span>
        </div>

        <div class="col-xs-12">
          <table width="100%">
            <thead>
              <tr>
                <th>กิจกรรม</th>
                <th>ผลการประเมิน</th>
                <th>กิจกรรม</th>
                <th>ผลการประเมิน</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>กิจกรรม</th>
                <td>ผ่าน</td>
                <th></th>
                <td></td>
              </tr>
              <tr>
                <th>กิจกรรม</th>
                <td>ผ่าน</td>
                <th></th>
                <td></td>
              </tr>
              <tr>
                <th>กิจกรรม</th>
                <td>ผ่าน</td>
                <th></th>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </article>
  </section>

  <section class="sheet padding-10mm">
    <article class="row">

      <div class="col-xs-12">
        <table width="100%">
          <thead>
            <tr>
              <th>หัวข้อ</th>
              <th>ความคิดเห็นของครูประจำชั้น</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td rowspan="2">1. หน้าที่รับผิดชอบที่โรงเรียน</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">2. ความเอาใจใส่ในการเรียน</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">3. ความสัมพันธ์กับครูและเพื่อน</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">4. อุปนิสัย - บุคลิกภาพ</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">5. สุขภาพ</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">6. ควรส่งเสริมในด้าน</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">7. อื่น ๆ</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-xs-12" style="padding-top: 20mm;font-size:18px;font-weight: bold;">
        <div class="text-center">
          <span>ผลการตัดสินการเลื่อนระดับชั้น</span>
        </div>
        <div class="text-center">
          <i class="far fa-square fa-fw"></i> ได้เลื่อนขั้น
          <span style="padding-left:5mm;padding-right:5mm;"></span>
          <i class="far fa-square fa-fw"></i> ไม่ได้เลื่อนขั้น
        </div>
      </div>

      <div class="col-xs-12" style="padding-top: 15mm;">
        <div class="text-center">
          <p style="margin-bottom: 0;">............................................................................................</p>
          <p style="margin-bottom: 0;">(ชื่อ - นามสกุล)</p>
          <p style="margin-bottom: 0;">ครูประจำชั้น</p>
        </div>
      </div>

      <div class="col-xs-12" style="padding-top: 15mm;">
        <div class="text-center">
          <p style="margin-bottom: 0;">............................................................................................</p>
          <p style="margin-bottom: 0;">(นางสาวอาณิสา บุญคำ)</p>
          <p style="margin-bottom: 0;">รองผู้อำนวยการฝ่ายวิชาการ</p>
        </div>
      </div>

      <div class="col-xs-12" style="padding-top: 15mm;">
        <div class="text-center">
          <p style="margin-bottom: 0;">............................................................................................</p>
          <p style="margin-bottom: 0;">(ชื่อ - นามสกุล)</p>
          <p style="margin-bottom: 0;">ผู้อำนวยการโรงรียนประชาภิบาล</p>
        </div>
      </div>

    </article>
  </section>

  <?php require_once("./js.inc.php"); ?>
  <script>
    $('#printBtn').click(function() {
      window.print();
    });
  </script>
  
  <?php $conn = null ?>
</body>