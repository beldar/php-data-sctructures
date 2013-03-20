<?php

function row(&$a,&$m,$c){
    $i = 0;
    $j = count($a)-1;
    $zero = false;
    while($i<count($a)-1){
        if($a[$i]==0 || $a[$j]==0){
            $zero = true;
        }
        if($c!=0){
            if($m[$c-1][$i]==0){ 
                $a[$i]=0;
                $m[$c][$i]=0;
            }
            if($m[$c-1][$j]==0){
                $a[$j]=0;
                $m[$c][$j]=0;
            }
        }
        if($zero){
            $a[$i]=0; 
            $a[$j]=0;
        }
        if($i>=$j && !$zero) 
            break;
        $i++;$j--;
    }
}
$m = array(
    array(1,2,0),
    array(0,1,1),
    array(1,1,1)
);
$im = $m;
foreach($m as $c=>&$row)
    row($row,$im,$c);
var_dump($m);
?>
