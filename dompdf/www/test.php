<?php
	require_once("../dompdf_config.inc.php");
	$old_limit = ini_set("memory_limit", "16M");
	  
	$dompdf = new DOMPDF();
	$dompdf->load_html('<html><body>TEST US GOOD</body></html>');
	$dompdf->set_paper('letter', 'portrait');
	$dompdf->render();

	$dompdf->stream("dompdf_out.pdf");

	// exit(0);
?>