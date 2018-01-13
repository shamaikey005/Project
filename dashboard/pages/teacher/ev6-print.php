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
      <h4 class="navbar-text">ปพ.6</h4>
      <button class="btn btn-primary navbar-btn pull-right" id="printBtn"><i class="fas fa-print fa-fw"></i> Print</button>
    </div>
  </nav>

  <section class="sheet padding-10mm">
    <article>
      Hello
    </acticle>
  </section>

  <section class="sheet padding-10mm">
    <article>
      Hello
    </acticle>
  </section>

  <?php require_once("./js.inc.php"); ?>
  <script>
    $('#printBtn').click(function() {
      window.print();
    });
  </script>
  
  <?php $conn = null ?>
</body>