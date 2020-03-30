<?php

echo "<h1>Dutch Xonotic GIT beta statistics</h1>";

function method1($a,$b) 
{
	return ($a[0] <= $b[0]) ? 1 : -1;
}

function delete_row(&$array, $offset) {
    return array_splice($array, $offset, 1);
}

function delete_col(&$array, $offset) {
    return array_walk($array, function (&$v) use ($offset) {
        array_splice($v, $offset, 1);
    });
}

function html_table($data = array())
{
    $rows = array();
    foreach ($data as $row) {
        $cells = array();
        foreach ($row as $cell) {
            $cells[] = "<td>{$cell}</td>";
        }
        $rows[] = "<tr>" . implode('', $cells) . "</tr>";
    }
    return "<table class='hci-table'>" . implode('', $rows) . "</table>";
}

$filename = 'score.txt';

// The nested array to hold all the arrays
$the_big_array = []; 

// Open the file for reading
if (($h = fopen("{$filename}", "r")) !== FALSE) 
{
  // Each line in the file is converted into an individual array that we call $data
  // The items of the array are comma separated
  while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
  {
    // Each individual array is being pushed into the nested array
    $the_big_array[] = $data;		
  }

  // Close the file
  fclose($h);
}

// Display the code in a readable format
//echo "<pre>";
//var_dump($the_big_array);
//echo "</pre>";

for ($x = 0; $x <= 6; $x++)
{
	delete_col($the_big_array, 1);
}

for ($x = 0; $x <= 18; $x++)
{
	delete_col($the_big_array, 2);
}

for ($x = 0; $x <= 13; $x++)
{
	delete_col($the_big_array, 3);
}


$array = array_chunk($the_big_array, 1);
$mapname = array();
$header = array();
$playerdata = array();
$totalarray = array();


foreach($array as $chunk)
{
    foreach($chunk as $subarray)
    {
	if(strpos($subarray[0], ':scores:') !== false)
	{
                        echo "<pre>";
//                      echo "START";
                        $subarray[0] = str_replace(":scores:", "Map ", $subarray[0]);
                        $subarray[0] = str_replace(":", ", playtime: ", $subarray[0]);
                        $mapname = $subarray;
	}
	if(strpos($subarray[0], ':teamscores:') !== false)
	{
		/* ignore team scores.*/
	}
	else if(sizeof($subarray) == 1)
	{
		if(!strcmp($subarray[0],":end"))
        	{
			if(sizeof($playerdata) > 0)
			{
				usort($playerdata, "method1");
				array_unshift($playerdata, $header);
				echo $mapname[0];
				echo html_table($playerdata);
        			echo "</pre>";
        			echo "<p>...</p>";
			}
			$totalarray = array();
			$mapname = array();
			$header = array();
			$playerdata = array();
			// todo sort and print
//                	echo "EIND";

        	}
//		else
//		{
//        		echo "<pre>";
////			echo "START";
//			$subarray[0] = str_replace(":scores:", "Map ", $subarray[0]);
//			$subarray[0] = str_replace(":", ", playtime: ", $subarray[0]);
//			$mapname = $subarray;
//		}
	}
	else
	{
		$subarray[0] = str_replace(":labels:player:score!!", "score", $subarray[0]);
		$subarray[0] = str_replace(":player:see-labels:", "", $subarray[0]);
		if(!strcmp($subarray[0],"score"))
		{
			//header
			$subarray[1] = "deaths";
			$subarray[2] = "kills";
			$subarray[3] = "suicides";
			$subarray[4] = "teamkills";
			$subarray[5] = "playtime";
			$subarray[6] = "player";
			$header = $subarray;
		}
		else
		{
			// score data
			$player = array();
			$player = explode(":",$subarray[4]);
			$subarray[4] = $player[0];
			$subarray[5] = $player[1];
			$subarray[6] = $player[3];

			array_push($playerdata, $subarray);
		}

	}

//	echo html_table($totalarray);
	//print_r ($totalarray);
	
	//if(strcmp($subarray[0],":end"))
	//{
	//	echo html_table($subarray);
	//}
        //echo "</pre>";
    } 

}


?>
