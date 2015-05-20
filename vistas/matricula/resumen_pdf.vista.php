<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_dompdf/dompdf_config.inc.php";
$html = "
<p>".$_GET["id_matricula"]."</p>
<p>".$_GET["id_tipo_ensenanza"]."</p>
<p>".$_GET["periodo"]."</p>
";


$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("sample.pdf");

?>
 