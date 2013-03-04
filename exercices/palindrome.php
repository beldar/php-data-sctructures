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
    nextpal(trim($op));
}
function nextpal($str){
    if(checknine($str)){
        $fh = str_replace ("9", "0", $fh);
        $fh[0] = "1";
        print $fh;
        print "1";
    }else{
        $n = strlen($str);
        $half = ceil(strlen($str)/2);
        $lsmall = false;
        $i = $half-1;
        $j = ($n%2)?$half+1:$half;
    }
    
}

function checknine($str){
    $isnine = true;
    for($i=0;$i<strlen($str);$i++){
        if($str[$i]!="9"){
            $isnine = false;
            break;
        }    
    }
    return $isnine;
}
/**
 * Version 4
 * function nextpal($str){
    $half = ceil(strlen($str)/2)-1;
    $fh = str_split($str, $half);
    $fh = $fh[0];
    $piv1 = intval($str[$half]);
    $piv2 = intval($str[++$half]);
    $in = false;
    if($piv1==9 && $piv2!=9)
        $piv = 9;
    elseif($piv1==9 && $piv2==9){
        $piv = 0;
        $in = checknine($str);
        if($in){
            $fh = str_replace ("9", "0", $fh);
            $fh[0] = "1";
            $piv = "0";
        }else{
            $a = $fh[strlen($fh)-1];
            $fh[strlen($fh)-1]=++$a;
        }
    }elseif($piv1>=$piv2){
        $piv=$piv1;
    }else
        $piv = $piv1+1;
    print $fh.$piv;
    if(strlen($str)%2==0)
        print $piv;
    if($in) 
        print $piv;
    print strrev($fh)."\n";
}

function checknine($str){
    $isnine = true;
    for($i=0;$i<strlen($str);$i++){
        if($str[$i]!="9"){
            $isnine = false;
            break;
        }    
    }
    return $isnine;
}*/
/**
 * Version 3
function nextpal($ints){
    $r=array();
    for($i=0;$i<ceil(count($ints)/2)-1;$i++){
        $r[]=$ints[$i];
        print $ints[$i];
    }
    $p=++$ints[$i];
    print $p;
    if(count($ints)%2==0)
        print $p;
    print implode("",$r)."\n";
}*/
/* Version 2
 * function nextpal($ints){
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
}*/
/* Version 1
 * function nextpal($ints){
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
