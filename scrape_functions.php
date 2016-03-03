<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function ss($baseUrl, $xpathrow, $xpathrowurl, $baseUrlbase, $xpathclassrow, $university_id, $term_id){

	$curl = curl_init($baseUrl);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	//var_dump(strlen($data));

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	$xpath = new DOMXPath($dom);

	$urls = array();
	$majors = array();

	$elements = $xpath->query($xpathrow);
	if (!is_null($elements)) {
		foreach ($elements as $element) {

			$nodes = $element->childNodes;
			foreach ($nodes as $node) {
				if($node->nodeName == "#text"){
					echo $node->textContent;
					echo "<br>";
				}
				//echo $node->textContent;
				//echo "<br>";
				$majors[] = $node->textContent;
			}
		}
	}
	//check majors and fill in majorlisttable with major_id and major_name
	for($z = 0; $z < count($majors); $z++)
	{
		$tmp = mysql_real_escape_string($majors[$z]);
		
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id'");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET major_name = '$tmp' 
			WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id' ") or die(mysql_error());
		} else {
			mysql_query("INSERT INTO Majors (major_id, major_name, university_id, term_id) 
				VALUES('$z', '$tmp', '$university_id', $term_id ) ") or die(mysql_error()); 
		} 
		
	}

	$elements = $xpath->query($xpathrowurl);
	if (!is_null($elements)) {
	  foreach ($elements as $element) {

	    $nodes = $element->childNodes;
	    foreach ($nodes as $node) {
	      $urls[] = $baseUrlbase . $node->nodeValue;
	    }
	  }
	}


	//go back and fill in the major_classes urls
	for($z = 0; $z < count($urls); $z++)
	{
		$tmp = mysql_real_escape_string($urls[$z]);
		
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id'");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET url = '$tmp' 
			WHERE major_id = '$z' AND term_id = '$term_id'") or die(mysql_error());
		} else { 
		} 
		
	}
	for($z = 0; $z < count($urls); $z++)
	{
		$asdf = array();
		$curl = curl_init($urls[$z]);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
		$html = curl_exec($curl);
		curl_close($curl);

		if (!$html) {
		    die("something's wrong!");
		}

		$dom = new DOMDocument();
		@$dom->loadHTML($html);

		$xpath = new DOMXPath($dom);

		$elements = $xpath->query($xpathclassrow);
		foreach($elements as $element){
			echo $element->getElementsByTagName("td")->nodeValue . "<br>";
			$crn = mysql_real_escape_string($element->getElementsByTagName("td")->item(1)->nodeValue);
			$crn = utf8_decode($crn);
			$regex = "/^\d+?/";
			if (!preg_match($regex, $crn)) {

			} else {
				echo $crn;
				$course = mysql_real_escape_string($element->getElementsByTagName("td")->item(2)->nodeValue);
				echo $course;
				$section = mysql_real_escape_string($element->getElementsByTagName("td")->item(3)->nodeValue);
				echo $section;
				$title = mysql_real_escape_string($element->getElementsByTagName("td")->item(4)->nodeValue);
				echo $title;
				$instructor = mysql_real_escape_string($element->getElementsByTagName("td")->item(6)->nodeValue);
				echo $instructor;
				echo $university_id;

				echo "<br>";
				
				$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND  university_id = '$university_id' AND term_id = '$term_id'");
				if(mysql_num_rows($result) != 0){
					$trow = mysql_fetch_array($result);
					$class_id = $trow['class_id'];
					mysql_query("UPDATE Classes SET course = '$course', section = '$section', title = '$title', instructor = '$instructor', major = '$z' 
					WHERE class_id = '$class_id' ") or die(mysql_error());
				} else {
					mysql_query("INSERT INTO Classes (crn, course, section, title, instructor, major, university_id, term_id) 
						VALUES('$crn', '$course', '$section', '$title', '$instructor', '$z', '$university_id', $term_id) ") or die(mysql_error()); 
				} 
				
				

			}
		}

	}
}

function ss1($baseUrl, $xpathrow, $xpathrowurl, $baseUrlbase, $xpathclassrow, $university_id, $term_id){
//function ss($baseUrl, $xpathrow, $xpathrowurl){

	$curl = curl_init($baseUrl);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	//var_dump(strlen($data));

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	$xpath = new DOMXPath($dom);

	$urls = array();
	$majors = array();

	$elements = $xpath->query($xpathrow);
	if (!is_null($elements)) {
		foreach ($elements as $element) {

			$nodes = $element->childNodes;
			foreach ($nodes as $node) {
				if($node->nodeName == "#text"){
					//echo $node->textContent;
					//echo "<br>";
					$majors[] = $node->textContent;
				}
				//echo $node->textContent;
				//echo "<br>";
			}
		}
	}

	//check majors and fill in majorlisttable with major_id and major_name
	for($z = 0; $z < count($majors); $z++)
	{
		$tmp = mysql_real_escape_string($majors[$z]);
		
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id'");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET major_name = '$tmp' 
			WHERE major_id = '$z' AND university_id ='$university_id' AND term_id ='$term_id'") or die(mysql_error());
		} else {
			mysql_query("INSERT INTO Majors (major_id, major_name, university_id, term_id) 
				VALUES('$z', '$tmp', '$university_id', $term_id ) ") or die(mysql_error()); 
		} 
		
	}


	$elements = $xpath->query($xpathrowurl);
	if (!is_null($elements)) {
		foreach ($elements as $element) {

			$nodes = $element->childNodes;
			foreach ($nodes as $node) {
				//echo $node->textContent . "<br>";
				$urls[] =  $node->nodeValue;
			}
		}
	}

	//go back and fill in the major_classes urls
	for($z = 0; $z < count($urls); $z++)
	{
		$tmp = mysql_real_escape_string($urls[$z]);
		
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id'");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET url = '$tmp' 
			WHERE major_id = '$z' AND university_id ='$university_id'  AND term_id = '$term_id'") or die(mysql_error());
		} else { 
		} 
		
	}

	
	for($z = 0; $z < count($urls); $z++)
	{
		$asdf = array();
		$curl = curl_init($urls[$z]);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
		$html = curl_exec($curl);
		curl_close($curl);

		if (!$html) {
	    	die("something's wrong!");
		}
		//echo $html;
		$dom = new DOMDocument();
		@$dom->loadHTML($html);

		$xpath = new DOMXPath($dom);

		$elements = $xpath->query($xpathclassrow);
		foreach($elements as $element){
			//echo "new class";
			//echo $element->getElementsByTagName("a")->item(0)->nodeValue;
			//echo "<br>";
			//echo $element->getElementsByTagName("a")->item(0)->nodeValue;
			$e = preg_split("/: /", $element->getElementsByTagName("a")->item(0)->nodeValue);

			$nodes = $element->getElementsByTagName("tr");
			$first = 0;
			foreach($nodes as $node){
				if($first == 0){
					$first = 1;
				} else {
					$course = mysql_real_escape_string($e[0]);
					$title = mysql_real_escape_string($e[1]);
					$tmp = $node->getElementsByTagName("td");
					$crn = mysql_real_escape_string($node->getElementsByTagName("td")->item(0)->nodeValue);
					$regex = "/^\d+?/";
					if (!preg_match($regex, $crn) || $tmp->length < 3) {

					} else {
						echo $tmp->length . "asdf";

						$section = mysql_real_escape_string($node->getElementsByTagName("td")->item(1)->nodeValue);
						if($tmp->length == 10){
							$instructor = mysql_real_escape_string($node->getElementsByTagName("td")->item(6)->nodeValue);
						} else {
							$instructor = mysql_real_escape_string($node->getElementsByTagName("td")->item(7)->nodeValue);
						}
						echo $crn;
						//$course = mysql_real_escape_string($element->getElementsByTagName("td")->item(2)->nodeValue);
						echo $course;
						//$section = mysql_real_escape_string($element->getElementsByTagName("td")->item(3)->nodeValue);
						echo $section;
						//$title = mysql_real_escape_string($element->getElementsByTagName("td")->item(4)->nodeValue);
						echo $title;
						//$instructor = mysql_real_escape_string($element->getElementsByTagName("td")->item(6)->nodeValue);
						echo $instructor;
						//echo $university_id;

						echo "<br>";
						
						$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND  university_id = '$university_id' AND term_id = '$term_id' AND major_id = '$z'");
						if(mysql_num_rows($result) != 0){
							$trow = mysql_fetch_array($result);
							$class_id = $trow['class_id'];
							mysql_query("UPDATE Classes SET course = '$course', section = '$section', title = '$title', instructor = '$instructor', major = '$z' 
							WHERE class_id = '$class_id' ") or die(mysql_error());
						} else {
							mysql_query("INSERT INTO Classes (crn, course, section, title, instructor, major, university_id, term_id) 
								VALUES('$crn', '$course', '$section', '$title', '$instructor', '$z', '$university_id', $term_id) ") or die(mysql_error()); 
						} 
						
						

					}
				}
			}
		}

	}

}

function ss2($baseUrl, $xpathrow, $xpathrowurl, $baseUrlbase, $xpathclassrow, $university_id, $term_id){

	$curl = curl_init($baseUrl);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	//var_dump(strlen($data));

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	$xpath = new DOMXPath($dom);

	$urls = array();
	$majors = array();

	$elements = $xpath->query($xpathrow);
	if (!is_null($elements)) {
		foreach ($elements as $element) {

			$nodes = $element->childNodes;
			foreach ($nodes as $node) {
				$majors[] = $node->textContent;
			}
		}
	}
	
	//check majors and fill in majorlisttable with major_id and major_name
	for($z = 1; $z < count($majors); $z++)
	{
		$tmp = mysql_real_escape_string($majors[$z]);
		echo $tmp;
		echo "<br>";
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id'");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET major_name = '$tmp' 
			WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id' ") or die(mysql_error());
		} else {
			mysql_query("INSERT INTO Majors (major_id, major_name, university_id, term_id) 
				VALUES('$z', '$tmp', '$university_id', $term_id ) ") or die(mysql_error()); 
		} 
		
	}

	foreach ($majors as $major) {
		$urls[] = "http://osoc.berkeley.edu/OSOC/osoc?x=62&p_term=SU&p_classif=--+Choose+a+Course+Classification+--&p_session=--+Choose+a+Session+--&p_deptname=" . urlencode($major) . "&p_presuf=--+Choose+a+Course+Prefix%2fSuffix+--&y=6";
	}

	//go back and fill in the major_classes urls
	for($z = 0; $z < count($urls); $z++)
	{
		$tmp = mysql_real_escape_string($urls[$z]);
		
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id ='$university_id' ");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET url = '$tmp' 
			WHERE major_id = '$z' AND term_id = '$term_id' AND university_id ='$university_id' ") or die(mysql_error());
		} else { 
		} 
		
	}

	
	for($z = 0; $z < count($urls); $z++)
	{
		echo $urls[$z];
		echo "<br>";
		$asdf = array();
		$curl = curl_init($urls[$z]);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
		$html = curl_exec($curl);
		curl_close($curl);

		if (!$html) {
		    die("something's wrong!");
		}

		$dom = new DOMDocument();
		@$dom->loadHTML($html);

		$xpath = new DOMXPath($dom);

		$elements = $xpath->query('//table');
		foreach($elements as $element){
			$nodes = $element->getElementsByTagName("tr");
			if($nodes->length == 12){
				$course = mysql_real_escape_string($nodes->item(0)->getElementsByTagName("td")->item(2)->nodeValue);
				echo $course;
				echo "<br>";
				$title = mysql_real_escape_string($nodes->item(1)->getElementsByTagName("td")->item(1)->nodeValue);
				echo $title;
				echo "<br>";
				$instructor = mysql_real_escape_string($nodes->item(3)->getElementsByTagName("td")->item(1)->nodeValue);
				echo $instructor;
				echo "<br>";
				$crn = mysql_real_escape_string($nodes->item(5)->getElementsByTagName("td")->item(1)->nodeValue);
				echo $crn;
				echo "<br>";
				$seats_avail = mysql_real_escape_string($nodes->item(10)->getElementsByTagName("td")->item(1)->nodeValue);
				$seats_avail = substr($seats_avail,strpos($seats_avail, "Seats:") + 6,strlen($seats_avail));
				echo $seats_avail;
				echo "<br>";
				echo $z;
				echo "<br>";
				echo "<br>";
				$section = '';
				$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND  university_id = '$university_id' AND term_id = '$term_id'");
				if(mysql_num_rows($result) != 0){
					$trow = mysql_fetch_array($result);
					$class_id = $trow['class_id'];
					mysql_query("UPDATE Classes SET course = '$course', section = '$section', title = '$title', instructor = '$instructor', major = '$z' 
					WHERE class_id = '$class_id' ") or die(mysql_error());
				} else {
					mysql_query("INSERT INTO Classes (crn, course, section, title, instructor, major, university_id, term_id) 
						VALUES('$crn', '$course', '$section', '$title', '$instructor', '$z', '$university_id', $term_id) ") or die(mysql_error()); 
				} 
			}
			
			
			//}
		}

	}
	
}

function ss3($baseUrl, $xpathrow, $xpathrowurl, $baseUrlbase, $xpathclassrow, $university_id, $term_id){

	$curl = curl_init($baseUrl);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	//var_dump(strlen($data));

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	$xpath = new DOMXPath($dom);

	$urls = array();
	$majors = array();

	$elements = $xpath->query($xpathrow);
	if (!is_null($elements)) {
		foreach ($elements as $element) {
			//echo $element->textContent;
			//echo "<br>";
			$majors[] = $element->textContent;
		}
	}
	
	//check majors and fill in majorlisttable with major_id and major_name
	for($z = 1; $z < count($majors); $z++)
	{
		$tmp = mysql_real_escape_string($majors[$z]);
		echo $tmp;
		echo "<br>";
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id'");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET major_name = '$tmp' 
			WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id' ") or die(mysql_error());
		} else {
			mysql_query("INSERT INTO Majors (major_id, major_name, university_id, term_id) 
				VALUES('$z', '$tmp', '$university_id', $term_id ) ") or die(mysql_error()); 
		} 
		
	}
	

	$elements = $xpath->query($xpathrowurl);
	if (!is_null($elements)) {
	  foreach ($elements as $element) {
	  	$tmp = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201404&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&sel_subj=" . $element->nodeValue . "&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=%25&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a&submit_btn=Show+Classes";
	  	//echo $tmp;
	  	$urls[] = $tmp;
	  	//echo "<br>";
	    
	  }
	}

	//go back and fill in the major_classes urls
	for($z = 0; $z < count($urls); $z++)
	{
		$tmp = mysql_real_escape_string($urls[$z]);
		
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id ='$university_id' ");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET url = '$tmp' 
			WHERE major_id = '$z' AND term_id = '$term_id' AND university_id ='$university_id' ") or die(mysql_error());
		} else { 
		} 
		
	}
	
	for($z = 0; $z < count($urls); $z++)
	{
		echo $urls[$z];
		echo "<br>";
	
		$asdf = array();
		$curl = curl_init($urls[$z]);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
		$html = curl_exec($curl);
		curl_close($curl);

		if (!$html) {
		    die("something's wrong!");
		}

		$dom = new DOMDocument();
		@$dom->loadHTML($html);

		$xpath = new DOMXPath($dom);

		$elements = $xpath->query('//table[@class="datadisplaytable"]//tr');	
		foreach($elements as $element){

			//echo $element->getElementsByTagName("td")->length;
			if($element->getElementsByTagName("td")->length == 2){
				if(replaceSpecial($element->getElementsByTagName("td")->item(0)->textContent) != 'Grading Options:'){
					$course = mysql_real_escape_string(replaceSpecial($element->getElementsByTagName("td")->item(0)->textContent));
					$title = $course;
				}
			}
			if($element->getElementsByTagName("td")->length == 9){
				$crn = mysql_real_escape_string($element->getElementsByTagName("td")->item(1)->nodeValue);
				$seats_avail = mysql_real_escape_string($element->getElementsByTagName("td")->item(2)->nodeValue);
				$instructor = mysql_real_escape_string($element->getElementsByTagName("td")->item(7)->nodeValue);
				if($crn != 'CRN'){
					//echo $course;
					//echo $crn;
					//echo $seats_avail;
					//echo $instructor;
					//echo "<br>";

					$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND  university_id = '$university_id' AND term_id = '$term_id' AND major = '$z'");
					if(mysql_num_rows($result) != 0){
						echo "it already exists:";
						echo "<br>";
						$trow = mysql_fetch_array($result);
						$class_id = $trow['class_id'];
						mysql_query("UPDATE Classes SET course = '$course', title = '$title', instructor = '$instructor', major = '$z' 
						WHERE class_id = '$class_id' ") or die(mysql_error());
					} else {
						//echo $course;
						echo "insert new";
						echo $crn;
						//echo $seats_avail;
						//echo $instructor;
						echo $z;
						echo "<br>";
						//echo "<br>";
						mysql_query("INSERT INTO Classes (crn, course, title, instructor, major, university_id, term_id) 
							VALUES('$crn', '$course', '$title', '$instructor', '$z', '$university_id', $term_id) ") or die(mysql_error()); 
					} 
				}
				
			}



			
		}
	}
	
}

function ss4($baseUrl, $xpathrow, $xpathrowurl, $baseUrlbase, $xpathclassrow, $university_id, $term_id){

	$curl = curl_init($baseUrl);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	//var_dump(strlen($data));

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	$xpath = new DOMXPath($dom);

	$urls = array();
	$majors = array();

	$elements = $xpath->query($xpathrow);
	if (!is_null($elements)) {
		foreach ($elements as $element) {
		$major = replaceSpecial($element->textContent);
			//echo $major;
			//echo "<br>";
			//echo "<br>";
			$majors[] = $element->textContent;
		}
	}
	
	
	
	//check majors and fill in majorlisttable with major_id and major_name
	for($z = 1; $z < count($majors); $z++)
	{
		$tmp = mysql_real_escape_string($majors[$z]);
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id'");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET major_name = '$tmp' 
			WHERE major_id = '$z' AND university_id = '$university_id' AND term_id = '$term_id' ") or die(mysql_error());
		} else {
			mysql_query("INSERT INTO Majors (major_id, major_name, university_id, term_id) 
				VALUES('$z', '$tmp', '$university_id', $term_id ) ") or die(mysql_error()); 
		} 
		
	}
	

	$elements = $xpath->query($xpathrowurl);
	if (!is_null($elements)) {
	  foreach ($elements as $element) {

	  	$tmp = "fuseaction=search&ACAD_CAREER=all&TERM=3640&session_code=&SCHOOL=&SUBJECT=" . $element->nodeValue . "&catalog_num=&ncoperator=or&instructor_name1=&days1=&START_TIME1=&START_TIME2=&submit_search=search+%C2%BB";
	  	//echo $tmp;
	  	//echo "<br>";
	  	$urls[] = $tmp;
	  	//echo "<br>";
	    
	  }
	}
	
	
	//go back and fill in the major_classes urls
	for($z = 1; $z < count($urls); $z++)
	{
		$tmp = mysql_real_escape_string($urls[$z]);
		
		$result = mysql_query("SELECT major_id FROM Majors WHERE major_id = '$z' AND university_id ='$university_id' ");
		if(mysql_num_rows($result) != 0){
			mysql_query("UPDATE Majors SET url = '$tmp' 
			WHERE major_id = '$z' AND term_id = '$term_id' AND university_id ='$university_id' ") or die(mysql_error());
		} else { 
		} 
		
	}
	
	for($z = 1; $z < count($urls); $z++)
	{
		$url = "http://www.scu.edu/courseavail/search/index.cfm";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_POST, 1);
		// adding the post variables to the request
		curl_setopt($curl, CURLOPT_POSTFIELDS, $urls[$z]);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
		$html = curl_exec($curl);
		curl_close($curl);
		// adding the post variables to the request
		if (!$html) {
		    die("something's wrong!");
		}

		$dom = new DOMDocument();
		@$dom->loadHTML($html);

		$xpath = new DOMXPath($dom);

		$elements = $xpath->query('//table[@id="zebra"]//tr');	
		foreach($elements as $element){
			if($element->getElementsByTagName("td")->length == 8){
				echo $course = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(0)->textContent));
				echo $crn = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(1)->textContent));
				echo $section = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(2)->textContent));
				echo $title = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(3)->textContent));
				echo $instructor = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(6)->textContent));
				echo $seats_avail = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(7)->textContent));		
				echo "<br>";

				$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND  university_id = '$university_id' AND term_id = '$term_id' AND major = '$z'");
				if(mysql_num_rows($result) == 0){
					mysql_query("INSERT INTO Classes (crn, course, title, instructor, major, university_id, term_id) 
						VALUES('$crn', '$course', '$title', '$instructor', '$z', '$university_id', $term_id) ") or die(mysql_error()); 
					echo "create new";
				} else {
					$row = mysql_fetch_array($result);
					echo "already exists";
					mysql_query("UPDATE Classes SET course = '$course', title = '$title', instructor = '$instructor', major = '$z' 
						WHERE class_id = '{$row['class_id']}'") or die(mysql_error());
				}
			}
		}


	}
	
}



function scrape_seats_for_specific_class($url, $xpathclassrow, $seatscolumnnumber, $uni_id, $term_id, $major){
	$asdf = array();
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	$elements = $xpath->query($xpathclassrow);
	foreach($elements as $element){
		$crn = mysql_real_escape_string($element->getElementsByTagName("td")->item(1)->nodeValue);
		$crn = utf8_decode($crn);
		$regex = "/^\d+?/";
		if (!preg_match($regex, $crn)) {
		} else {
			echo $crn;
			$seats_avail = mysql_real_escape_string($element->getElementsByTagName("td")->item($seatscolumnnumber)->nodeValue);
			echo $seats_avail;
			

			echo "<br>";

			$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'");
			if(mysql_num_rows($result) != 0){
				//echo $uni_id;
				mysql_query("UPDATE Classes SET seats_avail = '$seats_avail'
				WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'") or die(mysql_error());
			} else {
			} 
		}
	}
	mysql_query("UPDATE Majors SET updated_recently = '1'
				WHERE url = '$url' ") or die(mysql_error());


}

function scrape_seats_for_specific_class1($url, $xpathclassrow, $seatscolumnnumber, $uni_id, $term_id, $major){
	$asdf = array();
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	$elements = $xpath->query($xpathclassrow);
	foreach($elements as $element){
		//echo "new class";
		//echo $element->getElementsByTagName("a")->item(0)->nodeValue;
		//echo "<br>";
		//echo $element->getElementsByTagName("a")->item(0)->nodeValue;
		$e = preg_split("/: /", $element->getElementsByTagName("a")->item(0)->nodeValue);

		$nodes = $element->getElementsByTagName("tr");
		$first = 0;
			foreach($nodes as $node){
				if($first == 0){
					$first = 1;
				} else {
					$course = mysql_real_escape_string($e[0]);
					$title = mysql_real_escape_string($e[1]);
					$tmp = $node->getElementsByTagName("td");
					$crn = mysql_real_escape_string($node->getElementsByTagName("td")->item(0)->nodeValue);
					$regex = "/^\d+?/";
				if (!preg_match($regex, $crn) || $tmp->length < 3) {

				} else {
					//$instructor = mysql_real_escape_string($element->getElementsByTagName("td")->item(6)->nodeValue);
					echo $crn;
					if($tmp->length == 10){
						$seats_avail_string = mysql_real_escape_string($node->getElementsByTagName("td")->item(5)->nodeValue);
					} else {
						$seats_avail_string = mysql_real_escape_string($node->getElementsByTagName("td")->item(6)->nodeValue);
					}
					//echo $university_id;
					//echo $class_avail_string;
					$s_a = preg_split("/ of /", $seats_avail_string);
					$seats_avail = $s_a[1] - $s_a[0];
					echo $seats_avail;
					echo "<br>";


					$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'");
					if(mysql_num_rows($result) != 0){
						//echo $uni_id;
						mysql_query("UPDATE Classes SET seats_avail = '$seats_avail'
						WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'") or die(mysql_error());
					} else {
					} 
					

				}
				}
			}
		}
	mysql_query("UPDATE Majors SET updated_recently = '1'
				WHERE url = '$url' ") or die(mysql_error());


}

function scrape_seats_for_specific_class2($url, $xpathclassrow, $seatscolumnnumber, $uni_id, $term_id, $major){
	
	$asdf = array();
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	$elements = $xpath->query($xpathclassrow);

	foreach($elements as $element){
		$nodes = $element->getElementsByTagName("tr");
		if($nodes->length == 12){
			$crn = mysql_real_escape_string($nodes->item(5)->getElementsByTagName("td")->item(1)->nodeValue);
			echo $crn;
			$seats_avail = mysql_real_escape_string($nodes->item(10)->getElementsByTagName("td")->item(1)->nodeValue);
			$seats_avail = substr($seats_avail,strpos($seats_avail, "Seats:") + 6,strlen($seats_avail));
			echo $seats_avail;
			echo "<br>";
			echo "<br>";
			//if(!isset($section){
			$section = '';
			$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'");
			if(mysql_num_rows($result) != 0){
				//echo $uni_id;
				mysql_query("UPDATE Classes SET seats_avail = '$seats_avail'
				WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'") or die(mysql_error());
			} else {
			

			
			}
		}
		
	}	
	mysql_query("UPDATE Majors SET updated_recently = '1'
		WHERE url = '$url' ") or die(mysql_error());
				
	

}


function scrape_seats_for_specific_class3($url, $xpathclassrow, $seatscolumnnumber, $uni_id, $term_id, $major){
	
	$asdf = array();
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);

	if (!$html) {
	    die("something's wrong!");
	}

	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	$elements = $xpath->query($xpathclassrow);

		foreach($elements as $element){
			//echo $element->getElementsByTagName("td")->length;
			if($element->getElementsByTagName("td")->length == 2){
				if(replaceSpecial($element->getElementsByTagName("td")->item(0)->textContent) != 'Grading Options:'){
					$course = replaceSpecial($element->getElementsByTagName("td")->item(0)->textContent);
				}
			}
			if($element->getElementsByTagName("td")->length == 9){
				$crn = $element->getElementsByTagName("td")->item(1)->nodeValue;
				$seats_avail = $element->getElementsByTagName("td")->item(2)->nodeValue;
				$instructor = $element->getElementsByTagName("td")->item(7)->nodeValue;
				if($crn != 'CRN'){
					echo $course;
					echo $crn;
					echo $seats_avail;
					echo $instructor;
					echo "<br>";

					$section = '';
					$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'");
					if(mysql_num_rows($result) != 0){
						//echo $uni_id;
						mysql_query("UPDATE Classes SET seats_avail = '$seats_avail'
						WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'") or die(mysql_error());
					} else {
					

					
					}
				}
			}
		}
	mysql_query("UPDATE Majors SET updated_recently = '1'
		WHERE url = '$url' ") or die(mysql_error());
				
	

}

function scrape_seats_for_specific_class4($url, $xpathclassrow, $seatscolumnnumber, $uni_id, $term_id, $major){
	
	$curl = curl_init("http://www.scu.edu/courseavail/search/index.cfm");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	// adding the post variables to the request
	curl_setopt($curl, CURLOPT_POSTFIELDS, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	$html = curl_exec($curl);
	curl_close($curl);
	// adding the post variables to the request
	if (!$html) {
	    die("something's wrong!");
	}
	
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	$elements = $xpath->query('//table[@id="zebra"]//tr');	
	foreach($elements as $element){
		if($element->getElementsByTagName("td")->length == 8){
			//echo $course = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(0)->textContent));
			echo $crn = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(1)->textContent));
			echo $seats_avail = mysql_real_escape_string(trim($element->getElementsByTagName("td")->item(7)->textContent));		
			echo "<br>";
			$section = '';
			
			$result = mysql_query("SELECT class_id FROM Classes WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'");
			if(mysql_num_rows($result) != 0){
				//echo $uni_id;
				mysql_query("UPDATE Classes SET seats_avail = '$seats_avail'
				WHERE crn = '$crn' AND university_id = '$uni_id' AND term_id = '$term_id' AND major = '$major'") or die(mysql_error());
			} else {
			

			
			}
			
		}
	}
	//mysql_query("UPDATE Majors SET updated_recently = '1'
	//	WHERE url = '$url' ") or die(mysql_error());
				
	

}



function replaceSpecial($str){
	$chunked = str_split($str,1);
	$str = ""; 
	foreach($chunked as $chunk){
	    $num = ord($chunk);
	    // Remove non-ascii & non html characters
	    if ($num >= 32 && $num <= 123){
	            $str.=$chunk;
	    }
	}   
	return $str;
} 


function scrape_the_right_seats($url, $uni_id, $term_id, $major){
	$sql = "SELECT * FROM Terms WHERE term_id = $term_id";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['scrape_type'] == '0'){
		if($uni_id == '1'){
			scrape_seats_for_specific_class($url, '//table[@class="listOfClasses"]/tr', '7', $uni_id, $term_id, $major);
		} else {
			scrape_seats_for_specific_class($url, '//table[@class="listOfClasses"]/tr', '8', $uni_id, $term_id, $major);
		}
	} 
	if($row['scrape_type'] == '1'){
		scrape_seats_for_specific_class1($url, '//div[@class="course-info expandable"]', '7', $uni_id, $term_id, $major);
	}
	if($row['scrape_type'] == '2'){
		scrape_seats_for_specific_class2($url, '//table', NULL, $uni_id, $term_id, $major);
	}
	if($row['scrape_type'] == '3'){
		scrape_seats_for_specific_class3($url, '//table[@class="datadisplaytable"]//tr', NULL, $uni_id, $term_id, $major);
	}
	if($row['scrape_type'] == '4'){
		scrape_seats_for_specific_class4($url, '//table[@class="datadisplaytable"]//tr', NULL, $uni_id, $term_id, $major);
	}
}
?>