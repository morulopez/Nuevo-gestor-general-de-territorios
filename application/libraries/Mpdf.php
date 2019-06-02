<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpdf{
	function pdf($html){
			$mpdf = new \Mpdf\Mpdf();
				$mpdf->WriteHTML($html);
				$mpdf->Output();
	}
}

