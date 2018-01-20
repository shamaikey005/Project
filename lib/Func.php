<?php 

class Func {

  public function weekday($day) : string {
    switch ($day) {
      case 1:
        return 'วันจันทร์';
        break;
      
      case 2:
        return 'วันอังคาร';
        break;

      case 3:
        return 'วันพุธ';
        break;

      case 4:
        return 'วันพฤหัสบดี';
        break;

      case 5:
        return 'วันศุกร์';
        break;

      default:
        return 'Error';
        break;
    }
  }

  public function scheduleStatusText($status) : string {
    $res;
    switch ($status) {
      case 0:
        $res = "ยังไม่เปิดสอน";
        break;
      
      case 1:
        $res = "เปิดสอน";
        break;

      case 2:
        $res = "ส่งเกรดแล้ว";
        break;

      case 3:
        $res = "จบการสอน";
        break;
    }

    return $res;
  }

  public function scheduleStatusPanel($status) : string {
    $panel;
    switch ($status) {
      case 0:
        $panel = "danger";
        break;
      
      case 1:
        $panel = "primary";
        break;

      case 2:
        $panel = "warning";
        break;

      case 3:
        $panel = "success";
        break;
    }

    return $panel;
  }

  public function checkSex($data) : string {
    $sex;
    switch ($data) {
      case 0:
       $sex = "ไม่ระบุ";
       break;

      case 1:
       $sex = "ชาย";
       break;

      case 2:
       $sex = "หญิง";
       break;
    }

    return $sex;
  }

  public function checkSex2($data) : string {
    $sex;
    switch ($data) {

      case 1:
       $sex = "เด็กชาย";
       break;

      case 2:
       $sex = "เด็กหญิง";
       break;
    }

    return $sex;
  }

  public function checkStatusUser($data) : string {
    $status;
    switch ($data) {
      case 0:
        $status = "ปิด";
        break;

      case 1:
        $status = "เปิด";
        break;
    }

    return $status;
  }

  public function checkSubjectsType($data) : string {
    $type;
    switch ($data) {
      case 0:
        $type = "ไม่ระบุ";
        break;
      
      case 1:
        $type = "พื้นฐาน";
        break;

      case 2:
        $type = "เพิ่มเติม";
        break;
      
      case 3:
        $type = "กิจกรรม";
        break;
    }

    return $type;
  }

  public function grade($data) {
    $grade;
    switch (true) {
      case ($data >= 80) :
        $grade = 4;
        break;
      
        case ($data < 80 && $data >= 75) :
        $grade = 3.5;
        break;

        case ($data < 75 && $data >= 70) :
        $grade = 3;
        break;

        case ($data < 70 && $data >= 65) :
        $grade = 2.5;
        break;

        case ($data < 65 && $data >= 60) :
        $grade = 2;
        break;

        case ($data < 60 && $data >= 55) :
        $grade = 1.5;
        break;

        case ($data < 55 && $data >= 50) :
        $grade = 1;
        break;

        case ($data < 50) :
        $grade = 0;
        break;

    }

    return $grade;
  }

  public function traitResult ($data) : string {
    $res;
    switch (true) {
      case ($data <= 5 && $data > 4) :
      $res = "ดีเยี่ยม";
      break;

      case ($data <= 4 && $data > 3) :
      $res = "ดี";
      break;

      case ($data <= 3 && $data > 2) :
      $res = "ปานกลาง";
      break;

      case ($data <= 2 && $data > 1) :
      $res = "แย่";
      break;

      case ($data <= 1 && $data > 0) :
      $res = "แย่มาก";
      break;

      default :
      $res = "";
      break;
    }

    return $res;
  }

}

?>