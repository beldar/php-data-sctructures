<?php
/*
 * Find the longest palindrome in a string in O(n) time
 */
function longestpal($seq){
    $seqlen = strlen($seq);
    $l = array();
    $i = 0;
    $s = 0;
    $e = 0;
    $plen = 0;
    $longest = 0;
    $li = 0;
    while($i<$seqlen){
        if($i>$plen && $seq[$i-$plen-1]==$seq[$i]){
            $plen += 2;
            $i++;
            $li = $i;
            continue;
        }
        $l[] = $plen;
        $longest = max($longest,$plen);
        $s = count($l)-2;
        $e = $s-$plen;
        $found = false;
        for($j=$s;$j>$e;$j--){
            $d = $j-$e-1;
            if($l[$j]==$d){
                $plen = $d;
                $found = true;
                break;
            }
            $l[] = min($d,$l[$j]);
        }
        if(!$found){
            $plen = 1;
            $i++;
        }
    }
    $l[] = $plen;
    $longest = max($longest,$plen);
    $sq = array();
    if($li!=0)
        $i = ($li-$longest)+floor($longest/2);
    if($seq[$i]==$seq[$i-1]){ //Odd palindrome
        $j = $i-1;
        $n = floor($longest/2);
    }else{ //not odd
        $sq = array();
        $sq[] = $seq[$i];
        $j = $i;
        $j--;$i++;
        $n = floor($longest/2);
    }
    
    while($n>0){
        array_unshift($sq, $seq[$j]);
        $sq[] = $seq[$i];
        $i++;$j--;
        $n--;
    }
    echo implode($sq)."\n"; //Echo the longest palindrome
    return $longest; //Return the longest length, we can do it the other way around
}
$seq = "HYTBCABADEFGHABCDEDCBAGHTFYW123456789987654321ZWETYGDE";
//$seq = "asffaabaa";
var_dump(longestpal($seq));
?>
