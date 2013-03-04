<?php

/**
 * PHP Implementation for problem http://www.spoj.com/problems/PRIME1/
 * 
 * 
Peter wants to generate some prime numbers for his cryptosystem. Help him! Your task is to generate all prime numbers between two given numbers!

Input

The input begins with the number t of test cases in a single line (t<=10). In each of the next t lines there are two numbers m and n (1 <= m <= n <= 1000000000, n-m<=100000) separated by a space.

Output

For every test case print all prime numbers p such that m <= p <= n, one number per line, test cases separated by an empty line.

Example

Input:
2
1 10
3 5

Output:
2
3
5
7

3
5
 * @author Martí Planellas
 */

$n = intval(fgets( STDIN ));
$fifo = array();
$max = 0;
while($n>0){
    $in = fgets( STDIN );
    array_unshift($fifo,$in);
    $bin = explode(" ",$in);
    $m = intval($bin[1]);
    if($m>$max) $max = $m;
    $n--;
}
$bt = microtime(true);
$pr = primes($max);
sort($pr);
$at = microtime(true);
$tt = $at-$bt;
while($op = array_pop($fifo)){
    $bounds = explode(" ",$op);
    $infbound = intval($bounds[0]);
    $supbound = intval($bounds[1]);
    foreach($pr as $p)
        if($p>=$infbound && $p<=$supbound)
            print $p."\n";
    print "\n";
}

print "Generated primes from 2 to $max in $tt seconds\n";

function primes($lim){
    $sqrtlim = sqrt($lim);
    $pp = 2;
    $ss = array();
    $ss[] = $pp;
    $ep = array();
    $ep[] = $pp;
    $pp++;
    $rss = array();
    $rss[] = $ss[0];
    $tp = array();
    $tp[] = $pp;
    $i = 0;
    $rss[] = $rss[$i]*$tp[0];
    $xp = array();
    $pp+=$ss[0];
    $npp = $pp;
    $tp[] = $npp;
    while($npp<$lim){
        $i++;
        while($npp<$rss[$i]+1){
            foreach($ss as $n){
                $npp=$pp+$n;
                if($npp>$lim)
                    break;
                if($npp<=$rss[$i]+1)
                    $pp = $npp;
                $sqrtnpp = sqrt($npp);
                $test=true;
                foreach($tp as $q){
                    if($sqrtnpp<$q)
                        break;
                    elseif($npp%$q==0){
                        $test=false;
                        break;
                    }
                }
                if($test){
                    if($npp<=$sqrtlim)
                        $tp[] = $npp;
                    else
                        $xp[] = $npp;
                }
            }
            if($npp>$lim)
                break;
        }
        if($npp>$lim)
            break;
        $lrpp=$pp;
        $nss = array();
        while($pp<($rss[$i]+1)*2-1){
            foreach($ss as $n){
                $npp=$pp+$n;
                if($npp>$lim)
                    break;
                $sqrtnpp=sqrt($npp);
                $test = true;
                foreach($tp as $q){
                    if($sqrtnpp<$q)
                        break;
                    elseif($npp%$q==0){
                        $test=false;
                        break;
                    }
                }
                if($test){
                    if($npp<=$sqrtlim)
                        $tp[] = $npp;
                    else
                        $xp[] = $npp;
                }
                if($npp%$tp[0]!=0){
                    $nss[] = $npp-$lrpp;
                    $lrpp=$npp;
                }
                $pp=$npp;
            }
            if($npp>$lim)
                break;
        }
        if($npp>$lim)
            break;
        $ss=$nss;
        $ep[] = $tp[0];
        array_shift($tp);
        $rss[] = $rss[$i]*$tp[0];
        $npp=$lrpp;
    }
    $i=$nss=$npp=$n=$sqrtnpp=$test=$q=$r=$lrpp=$rss=$ss=$pp=$sqrtlim=0;
    $ep = array_reverse($ep);
    foreach($ep as $a) $tp[]=$a;
    $tp = array_reverse($tp);
    foreach($tp as $a) $xp[]=$a;
    $ep=$tp=$a=$tt=$lim=0;
    return $xp;
}
?>
