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
 * 
 * Difficult test cases:
 * 7957 -> 7997
 * 9789 -> 9889
 * 1 -> 2
 * 999 -> 1001
 * 4599954 -> 4600064
 * 45874 -> 45954
 * 100100 -> 101101
 * 94187978322 -> 94188088149
 * 20899802 -> 20900902
 * 
 * ***
 * 
input : 
10 
3 
9 
53936 
53236 
67775 
99 
999 
6339 
875111 
6997 

output: 
4 
11 
54045 
53335 
67776 
101 
1001 
6446 
875578 
7007 
 * @author Martí Planellas <beldar.cat at gmail >
 * 
 */
$n = intval(fgets( STDIN ));
$fifo = array();

while($n>0){
    $in = fgets( STDIN );
    array_unshift($fifo,$in);
    $n--;
}

while($op = array_pop($fifo)){
    print nextpal(trim($op))."\n";
}

function nextpal($str){
    //If offlimits return
    if(strlen($str)>1000000) return;
    //If its a number < 10 and it's not 9 just increment and return
    if(strlen($str)==1 && $str!="9")
        return ++$str;
    //Check if all numbers are 9, if they are, replace all with 0 put the first position 1 and add 1 at the end
    // Example 999 -> 000 -> 100 -> 1001
    elseif(checknine($str)){
        //print "Case all nines\n";
        $str = str_replace ("9", "0", $str);
        $str[0] = "1";
        return $str."1";
    }else{
        $n = strlen($str);
        $h = floor(strlen($str)/2);
        $isodd = ($n%2==1);
        $i = $h-1;
        $j = $isodd?$h+1:$h;
        //If the center digits are different and not 9
        if($str[$i]!=$str[$j] && $str[$i]!=9 && $str[$j]!=9){
            if($str[$i]>$str[$j]){
                //Case the left side is larger
                return getmirror($str,$h,$isodd,false);
            }elseif($str[$i]<$str[$j] && $str[$i]!=9 && $str[$j]!=9){
                //Case the right side is larger
                return getmirror($str,$h,$isodd,true);
            }
        }else{
            //If the center numbers are equal or there're 9s;
            $ls = false;
            //If the center digits are equal, the number can be a palindrome
            //Find at what point stops being a palindrome
            while($i>0 && $str[$i]==$str[$j]){
                $i--;
                $j++;
            }
            //If it is a palindrome or the left side is smaller than right side ls=true
            if($i==0 || $str[$i]<$str[$j])
                $ls = true;
            //If it's a palindrome except for the first and last digit
            // And the left digit is larger than the right, just copy the left digit to the right and return
            // Example: 6772 -> 6776
            if($i==0 && $str[$i]>$str[$j]){
                $str[$j] = $str[0];
                return $str;
            }
            if($ls){
                //The left side is smaller or number is already a palindrome
                //We have to increment the middle digit and extend the carry both ways
                //This covers the middle digits being 9s too
                $carry = 1;
                $i=$h-1;
                if($isodd){
                    $aux = $str[$h]+$carry;
                    $carry = $aux/10;
                    $str[$h] = $aux%10;
                    $j = $h+1;
                }else
                    $j = $h;
                //Extend the carry both ways until we reach the end or we run out of carry
                while($i>=0 && $carry!=0){
                    $aux = $str[$i]+$carry;
                    $carry = $aux/10;
                    $str[$i] = $aux%10;
                    $str[$j++] = $str[$i--];
                }
                return $str;
            }else
                //Case the left side is larger
                return getmirror($str,$h,$isodd,false);
                
        }
    }
    
}

function getmirror($str,$h,$isodd,$ls){
    if($ls){
        if($isodd)
            $piv=$str[$h];
        else
            $piv=$str[$h1];
        $piv++;
        if(!$isodd)
            $str[$h-1] = $piv;
        else
            $str[$h] = $piv;
        for($i=$n-1;$i>=$h;$i--)
            $str[$i] = $str[$n-$i-1];
        return $str;
    }else{
        if($isodd)
            $str[$h+1] = $str[$h];
        for($i=$n-1;$i>=$h;$i--)
            $str[$i] = $str[$n-$i-1];
        return $str;
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
?>
