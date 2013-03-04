<?php

/*
 * PHP implementation for problem: http://www.spoj.com/problems/PALIN/
 * 
A positive integer is called a palindrome if its representation in the decimal system is the same when read from left to right and from right to left. For a given positive integer K of not more than 1000000 digits, write the value of the smallest palindrome larger than K to output. Numbers are always displayed without leading zeros.

Input

The first line contains integer t, the number of test cases. Integers K are given in the next t lines.

Output

For each K, output the smallest palindrome larger than K.

Example

Input:
2
808
2133
Output:
818
2222
 */
$n = intval(fgets( STDIN ));
$fifo = array();
while($n>0){
    $in = fgets( STDIN );
    array_unshift($fifo,$in);
    $n--;
}
while($op = array_pop($fifo)){
    $ints = array();
    for($i=0;$i<strlen($op)-2;$i++)
        if($op[$i]!="") $ints[] = intval($op[$i]);
    $r = nextpal($ints);
    print implode("",$r)."\n";
}
function nextpal($ints){
    $parts = array_chunk($ints, ceil(count($ints)/2));
    if(count($parts[0])>count($parts[1])){
        $pivot = array_pop($parts[0]);
        $rev = array_reverse($parts[0]);
        $parts[0][]=++$pivot;
        $r = array_merge($parts[0],$rev);
    }else{
        $pivot = array_pop($parts[0]);
        $parts[0][]=++$pivot;
        $rev = array_reverse($parts[0]);
        $r = array_merge($parts[0],$rev);
    }
    unset($parts);
    return $r;
}
/*function nextpal($ints){
    $r = false;
    while(!$r && count($ints)<1000000){
        $ints = increment($ints,count($ints)-1);
        $i = 0;
        $j = count($ints)-1;
        $t = true;
        while($i<$j && $t){
            if($ints[$i]!=$ints[$j])
                $t = false;
            $i++;
            $j--;
        }
        if($t)
            $r = implode("",$ints);
    }
    return $r;
}
function increment($ints,$i){
    if($ints[$i]==9){
        $ints[$i] = 0;
        if($i>0)
            $ints = increment($ints,--$i);
        else{
            array_unshift($ints,0);
            $ints = increment($ints,$i);
        }
            
    }else
        $ints[$i]++;
    return $ints;
}*/
?>
