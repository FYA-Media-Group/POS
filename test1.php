<?php require_once 'setting.fya'; ?>
<?php 
// $books = array(array('title'=>'Bname of book'),
// array('title'=>'Abook2'));

// $filtered_books = array_multi_search( $books, 'title', '/^B/i' );
// function array_multi_search( $array, $index, $pattern, $invert = FALSE )
// {

    // $output = array();

    // foreach ( $array as $i => $arr )
    // {

        // The index must exist and match the pattern
        // if ( isset( $arr[ $index ] ) && ( bool ) $invert !== ( bool ) preg_match( $pattern, $arr[ $index ] ) )
        // {
            // $output[ $i ] = $arr;
        // }

    // }

    // print_r($output);

// }  
// $strAdminID='177';
// $strStoreID=2;
// $date=date('y-m-d');
	// $timestamp =  date("H:i:s", time());
// $DB = Connect();
	// $insertopen="SELECT * FROM `tblOpenNClose` WHERE `DateNTime`='$date' and StoreID='$strStoreID'";
	// echo $insertopen."<br>";
		// $RSf = $DB->query($insertopen);
		// if ($RSf->num_rows > 0) 
		// {
			// echo "In if<br>";
		// }
		// else
		// {	
			// echo "In else<br>";
?>			
			<!--<a href="test1.php?opening=1" class="btn btn-lg btn-primary" id="OpenDay" onClick="disablelink();" >Day Opening</a>-->
<?php			
		// }

// if(isset($_GET['opening']))
// {
	// $date=date('y-m-d');
	// $timestamp =  date("H:i:s", time());
	// $GetUID=$_GET["opening"];
	// $insertopen="SELECT * FROM `tblOpenNClose` WHERE `DateNTime`='$date' and StoreID='$strStoreID'";
	// echo $insertopen."<br>";
			// $RSf = $DB->query($insertopen);
			// if ($RSf->num_rows > 0) 
			// {
				// echo "In if No Execution<br>";
			// }
			// else
			// {
				// echo "In else In Execution<br>";
					// $UpdateOpenTime="Insert into tblOpenNClose(DateNTime,OpenTime,AdminID,StoreID,Status)VALUES('".$date."','".$date."','".$strAdminID."','".$strStoreID."',1)";
						// echo $UpdateOpenTime;
					 // echo $UpdateOpenTime."<br>";
					// ExecuteNQ($UpdateOpenTime);
			// }

			
	// die();
	// echo("<script>$('#OpenDay').hide();</script>"); 
// echo("<script>location.href='Salon-Dashboard.php';</script>"); 
	
// }	
		$timestamp =  date("H:i:s", time());
		$date1=$timestamp;
		echo $date1."<br>";
		$PQR="18:00:00";
		$datetime_from = date($date1, strtotime("-45 minutes", strtotime($timestamp)))
		$compairedate=date("H:i:s", strtotime("-45 minutes", $PQR));
		echo $compairedate."<br>";
		
?>





