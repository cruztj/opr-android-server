
<?php

function getBetween($string, $tag1, $tag2, $occurrence = 1) {
	$string = explode($tag1,$string);
	$string = explode($tag2,$string[$occurrence]);
	return $string[0];
}

function fetch() {
	// this is a time consuming job
	set_time_limit(0);
	$url = 'https://www.uplb.edu.ph/231-job-openings';

	$ch = curl_init($url);
	// $fp = fopen("UPLBJobOpenings.txt", "w");

	// curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$html = curl_exec($ch);

	if(curl_error($ch)) {
		echo 'error:' . curl_error($ch);
	}	
	
	curl_close($ch);
	// fclose($fp);

	// echo htmlspecialchars($html);
	

		$main = getBetween($html,'<table style="break-before: page; width: 500px; height: 771px;"><colgroup><col /><col /><col /><col /><col /><col /><col /><col /><col /></colgroup>','<table style="width: 1209px;">
<tbody>
<tr>
<td colspan="8" style="width: 1033px;">
<p>Interested and qualified applicants should signify their interest in writing. Attach the following documents to the application letter and send to the address below not later than <strong>January 15, 2018.</strong></p>');

		$partA = getBetween($main,'<td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
<p><strong>Due</strong></p>
</td>
<td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
<p><strong>Contact Person</strong></p>
</td>
</tr>
<tr>
<td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
<table style="width: 204px;">','<p style="margin-bottom: 0.35cm; line-height: 115%;"><span style="font-size: 14pt;"><strong>B. RESEARCH, EXTENSION, PROFESSIONAL STAFF (REPS)</strong></span></p>');
	$partA = preg_replace('/\s\s+/', ' ',$partA);
	$partA = str_replace('&nbsp;',' ',$partA);
	$partA = trim(preg_replace('/\s+/', ' ', $partA));
	$partA = trim(preg_replace('/\t+/', '', $partA));


	// echo htmlspecialchars($partA);

	// echo $partA;

	$cellsA = explode('<td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;',$partA);

	$count = 0;
	foreach ($cellsA as $cellA){
		$rawA = strip_tags($cellA);
		$rawA = str_replace('">',"",$rawA);
		$rawA = str_replace('text-align: center;',"",$rawA);
		$rawA = trim($rawA);
		//echo $rawA."<br><br><br>";
		if ($count == 0){
			$unit = $rawA;
			$count++;
		} else if ($count == 1){
			$position = $rawA;
			$count++;
		} else if ($count == 2){
			$itemnumber = $rawA;
			$count++;
		} else if ($count == 3){
			$mineducation = $rawA;
			$count++;
		} else if ($count == 4){
			$minexperience = $rawA;
			$count++;
		} else if ($count == 5){
			$mintraining = $rawA;
			$count++;
		} else if ($count == 6){
			$mineligibility = $rawA;
			$count++;
		} else if ($count == 7){
			$duedate = $rawA;
			$count++;
		} else if ($count == 8){
			$contactperson = $rawA;
			$count = 0;
			$temp = array(
				'unit' => $unit,
				'position' => $position,
				'itemnumber' => $itemnumber,
				'mineducation' => $mineducation,
				'minexperience' => $minexperience,
				'mintraining' => $mintraining,
				'mineligibility' => $mineligibility,
				'duedate' => $duedate,
				'contactperson' => $contactperson
			);

			$tableA[] = $temp;
		}
	}
	// echo '<pre>'; print_r($tableA); echo '</pre>';
	//output json format
	echo json_encode($tableA);







// 	$partB = getBetween($main,'<td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Due</strong></p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Contact Person</strong></p>
// </td>
// </tr>
// <tr>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <table style="width: 136px;">','<p>&nbsp;</p>
// <p><span style="font-size: 14pt;"><strong>C. ADMINISTRATIVE POSITION</strong></span></p>');
// 	$partB = preg_replace('/\s\s+/', ' ',$partB);
// 	$partB = str_replace('&nbsp;',' ',$partB);
// 	$partB = trim(preg_replace('/\s+/', ' ', $partB));
// 	$partB = trim(preg_replace('/\t+/', '', $partB));

// 	$cellsB = explode('<td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;',$partB);

// 	$count = 0;
// 	foreach ($cellsB as $cellB){
// 		$rawB = strip_tags($cellB);
// 		$rawB = str_replace('">',"",$rawB);
// 		$rawB = str_replace('text-align: center;',"",$rawB);
// 		$rawB = trim($rawB);
// 		//echo $rawA."<br><br><br>";
// 		if ($count == 0){
// 			$unit = $rawB;
// 			$count++;
// 		} else if ($count == 1){
// 			$position = $rawB;
// 			$count++;
// 		} else if ($count == 2){
// 			$itemnumber = $rawB;
// 			$count++;
// 		} else if ($count == 3){
// 			$mineducation = $rawB;
// 			$count++;
// 		} else if ($count == 4){
// 			$minexperience = $rawB;
// 			$count++;
// 		} else if ($count == 5){
// 			$mintraining = $rawB;
// 			$count++;
// 		} else if ($count == 6){
// 			$mineligibility = $rawB;
// 			$count++;
// 		} else if ($count == 7){
// 			$duedate = $rawB;
// 			$count++;
// 		} else if ($count == 8){
// 			$contactperson = $rawB;
// 			$count = 0;
// 			$temp = array(
// 				'unit' => $unit,
// 				'position' => $position,
// 				'itemnumber' => $itemnumber,
// 				'mineducation' => $mineducation,
// 				'minexperience' => $minexperience,
// 				'mintraining' => $mintraining,
// 				'mineligibility' => $mineligibility,
// 				'duedate' => $duedate,
// 				'contactperson' => $contactperson
// 			);

// 			$tableB[] = $temp;
// 		}
// 	}
// 	// echo '<pre>'; print_r($tableB); echo '</pre>';
// 	//output json format
	echo 'breaker';
// 	echo json_encode($tableB);


// 	$partC = getBetween($main,'<p><span style="font-size: 14pt;"><strong>C. ADMINISTRATIVE POSITION</strong></span></p>
// <table style="page-break-before: always; width: 1050px; height: 227px;"><colgroup><col /><col /><col /><col /><col /><col /><col /><col /><col /></colgroup>
// <tbody>
// <tr>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>College/Unit</strong></p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Position</strong></p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Item No.</strong></p>
// </td>
// <td colspan="6" style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Minimum Requirements</strong></p>
// </td>
// </tr>
// <tr>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p>&nbsp;</p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p>&nbsp;</p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p>&nbsp;</p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Education</strong></p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Experience</strong></p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Training</strong></p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Eligibility</strong></p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Due</strong></p>
// </td>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">
// <p><strong>Contact Person</strong></p>
// </td>
// </tr>
// <tr>
// <td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;">','<p style="margin-bottom: 0.35cm; line-height: 115%;">&nbsp;</p>
// <p style="margin-bottom: 0.35cm; line-height: 115%;">&nbsp;</p>
// <table style="width: 1209px;">
// <tbody>
// <tr>
// <td colspan="8" style="width: 1033px;">
// <p>Interested and qualified applicants should signify their interest in writing. Attach the following documents to the application letter and send to the address below not later than <strong>January 15, 2018.</strong></p>');

// 	$partC = preg_replace('/\s\s+/', ' ',$partC);
// 	$partC = str_replace('&nbsp;',' ',$partC);
// 	$partC = trim(preg_replace('/\s+/', ' ', $partC));
// 	$partC = trim(preg_replace('/\t+/', '', $partC));

// 	$cellsC = explode('<td style="border-style: solid; border-color: #00000a; padding: 0cm 0.19cm 0cm 0.2cm;',$partC);

// 	$count = 0;
// 	foreach ($cellsC as $cellC){
// 		$rawC = strip_tags($cellC);
// 		$rawC = str_replace('">',"",$rawC);
// 		$rawC = str_replace('text-align: center;',"",$rawC);
// 		$rawC = trim($rawC);
// 		//echo $rawA."<br><br><br>";
// 		if ($count == 0){
// 			$unit = $rawC;
// 			$count++;
// 		} else if ($count == 1){
// 			$position = $rawC;
// 			$count++;
// 		} else if ($count == 2){
// 			$itemnumber = $rawC;
// 			$count++;
// 		} else if ($count == 3){
// 			$mineducation = $rawC;
// 			$count++;
// 		} else if ($count == 4){
// 			$minexperience = $rawC;
// 			$count++;
// 		} else if ($count == 5){
// 			$mintraining = $rawC;
// 			$count++;
// 		} else if ($count == 6){
// 			$mineligibility = $rawC;
// 			$count++;
// 		} else if ($count == 7){
// 			$duedate = $rawC;
// 			$count++;
// 		} else if ($count == 8){
// 			$contactperson = $rawC;
// 			$count = 0;
// 			$temp = array(
// 				'unit' => $unit,
// 				'position' => $position,
// 				'itemnumber' => $itemnumber,
// 				'mineducation' => $mineducation,
// 				'minexperience' => $minexperience,
// 				'mintraining' => $mintraining,
// 				'mineligibility' => $mineligibility,
// 				'duedate' => $duedate,
// 				'contactperson' => $contactperson
// 			);

// 			$tableC[] = $temp;
// 		}
// 	}

// 	// echo '<pre>'; print_r($tableC); echo '</pre>';
// 	//output json format
	echo 'breaker';
// 	echo json_encode($tableC);




	// $tables = array(json_encode($tableA), json_encode($tableB), json_encode($tableC));
	// $tables = array($tableA, $tableB, $tableC);

	// print_r(json_encode($tableA));
	// print_r(json_encode($tables));

	/*foreach ($tableA as $each) {
		$unit = $each['unit'];
		$position = $each['position'];
		$itemnumber = $each['itemnumber'];
		$mineducation = $each['mineducation'];
		$minexperience = $each['minexperience'];
		$mintraining = $each['mintraining'];
		$mineligibility = $each['mineligibility'];
		$duedate = $each['duedate'];
		$contactperson = $each['contactperson'];
		// insert(databaseC);
	}

	foreach ($tableB as $each) {
		$unit = $each['unit'];
		$position = $each['position'];
		$itemnumber = $each['itemnumber'];
		$mineducation = $each['mineducation'];
		$minexperience = $each['minexperience'];
		$mintraining = $each['mintraining'];
		$mineligibility = $each['mineligibility'];
		$duedate = $each['duedate'];
		$contactperson = $each['contactperson'];
		// insert(databaseB);
	}

	foreach ($tableC as $each) {
		$unit = $each['unit'];
		$position = $each['position'];
		$itemnumber = $each['itemnumber'];
		$mineducation = $each['mineducation'];
		$minexperience = $each['minexperience'];
		$mintraining = $each['mintraining'];
		$mineligibility = $each['mineligibility'];
		$duedate = $each['duedate'];
		$contactperson = $each['contactperson'];
		// insert(databaseC);
	}*/

	// echo 'Done';
}

fetch();	