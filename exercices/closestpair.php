<?php
/*
 * http://www.spoj.com/problems/CPP/ accepted!! suspicious 0k MEM and 0.0 seconds ?¿
 * 9740. Closest Pair Problem

Problem code: CPP

Given n points on the plane, each represented by (x, y) coordinates, find a pair of points withthe smallest distance between them.

Input
The first line of input will contain the number of points, n (2 <= n <= 30,000). Each of the next n lines will contain two integers x and y (-1,000,000 <= x, y <= 1,000,000). The ith line contains the coordinates for the ith point.

Output

Print to the ouput a single floating point number d, denoting the distance between the closest pair of points. d should contain exactly 6 digits after the decimal.

Example

Input:
5
0 0
-4 1
-7 -2
4 5
1 1


Output:
1.414214
 * 
 * @author Martí Planellas
 */

$n = intval(fgets(STDIN));

$pointsx = array();
//$pointsy = array();
while($n>0){
    $p = fgets(STDIN);
    $p = explode(" ",$p);
    $p[0] = intval($p[0]);
    $p[1] = intval($p[1]);
    $pointsx[] = $p;
    //$pointsy[] = array($p[1],$p[0]);
    $n--;
}
sort($pointsx);
//sort($pointsy);
echo findclosest($pointsx)."\n";

function findclosest($xp){
    $n = count($xp);
    $cd = INF;
    if($n<=3){
        for($i=0;$i<$n;$i++){
            for($j=$i;$j<$n;$j++){
                $x = $xp[$i][0]-$xp[$j][0];
                $y = $xp[$i][1]-$xp[$j][1];
                $d = sqrt($x*$x+$y*$y);
                //echo "New d=$d\n";
                if($d!=0 && $d<$cd){
                    $cd = $d;
                }
            }
        }
        return round($cd,6);
    }else{
        $parts = array_chunk($xp,2);
        $xm = floor($n/2);
        $xl = $parts[0];
        $xr = $parts[1];
        $cdl = findclosest($xl);
        $cdr = findclosest($xr);
        $dmin = min($cdl,$cdr);
        $cd = $dmin;
        for($i=0;$i<$n;$i++){
            if(abs($xm-$xp[$i][0])<$dmin){
                for($j=$i;$j<$n;$j++){
                    if(abs($xp[$i][1]-$xp[$j][1])<$dmin){
                        $x = $xp[$i][0]-$xp[$j][0];
                        $y = $xp[$i][1]-$xp[$j][1];
                        $d = sqrt($x*$x+$y*$y);
                        if($d!=0 && $d<$cd){
                            $cd = $d;
                        }
                    }
                }
            }
        }
        return $cd; 
    }
}


?>
