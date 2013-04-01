<?php


/**
 *Question 1
 *
Given n distinct chars, want to output all the permutations of the string
a b c,
output:
abc
acb
bac
bca
cab
cba 
 */
function perm($str,$i,$n){
    if($i==$n)
        echo "$str\n";
    else{
        for($j=$i;$j<$n;$j++){
            //Swap str[i] <-> str[j]
            $t = $str[$i];
            $str[$i] = $str[$j];
            $str[$j] = $t;
            perm($str, $i+1,$n);
            //Swap str[i] <-> str[j]
            $t = $str[$i];
            $str[$i] = $str[$j];
            $str[$j] = $t;
        }
    }
}

$str = "abc";
perm($str,0,strlen($str));
/**
 *
 * Question 2
 * 
given m*n matrix of intergers,
some of them are 0, 
set all the rows and columns to 0 if there is a 0 there orginally

1 2 0
0 1 1
1 1 1

0 0 0 
0 0 0 
0 1 0
 */
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
/*$m = array(
    array(1,2,0),
    array(0,1,1),
    array(1,1,1)
);
$im = $m;
foreach($m as $c=>&$row)
    row($row,$im,$c);
var_dump($m);*/
?>
