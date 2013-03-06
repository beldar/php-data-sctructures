<?php
/*
 * Test problem from http://www.spoj.com/problems/TEST/
 */
$show = true;
while($show){
	$in = trim(fgets(STDIN));
	if($in=="42") $show=false;
	if($show)
		print $in."\n";
}
?>
