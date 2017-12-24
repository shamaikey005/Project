<?php 

class Func {

  public function weekday($day) {
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

  

}

?>