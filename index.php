<div id="main-content">
	<form accept-charset="UTF-8" name="userForm" class="daftar-form" action="index.php" method="post" enctype="multipart/form-data">
		<legend>
			Upload PDF Now !
		</legend>
		<input id="files" name="files" size="50" type="file" accept="application/pdf">
		<input name="commit" value="Upload" type="submit">
	</form>
	<?php

	## This project using pdftotext by propper-utils
	## By Mkhuda
	if(isset($_FILES['files'])){
		$uploaddir = 'tmp/';
		$temp = explode(".", $_FILES["file"]["name"]);

		# rename file into unique microtime;

		$newfilename = round(microtime(true)) . '.' . end($temp);
		if(move_uploaded_file($_FILES['files']['tmp_name'], $uploaddir.basename($newfilename.'pdf'))) {

			# make pdf and txt filename
			$filepdf = $newfilename.'pdf';
			$filetxt = $newfilename.'txt';

			# command line (linux only)
			$c = 'pdftotext /var/www/html/pdf/tmp/'.$filepdf.' /var/www/html/pdf/tmp/'.$filetxt;
			
			# execute the command
			exec($c,$output,$return);

			# returns of command
			if (!$return) { 
				
				# if success
				
				$lines = file('tmp/'.$filetxt);

				# Loop through our array, show HTML source as HTML source; and line numbers too.
				
				foreach ($lines as $line_num => $line) {
					echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
				}

				# Also print the array
				
				print_r($lines);

			} else {
				
				# if exec failed

				echo "Gagal";
			}

		} else {

			# If uploading failed

			echo "Gagal";
		}
	}
	?>
</div>