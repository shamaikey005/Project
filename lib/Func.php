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
        $res = "เปิดสอนตามปกติ";
        break;

      case 2:
        $res = "ประเมินผลการเรียน";
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

}

?>