<?php
/*
 * The longest Increasing Subsequence (LIS) problem is to find the length of the 
 * longest subsequence of a given sequence such that all elements of the subsequence 
 * are sorted in increasing order. For example, length of LIS for { 10, 22, 9, 33, 21, 50, 41, 60, 80 } 
 * is 6 and LIS is {10, 22, 33, 50, 60, 80}.
 * 
 * @author Martí Planellas
 */

/**
 * Naive recursive implementation (O(n))
 */
function _reclis($arr, $n, &$max_ref){
    if($n==1)
        return 1;
    $res=1;
    $maxending=1;
    /* Recursively get all LIS ending with arr[0], arr[1] ... ar[n-2]. If 
       arr[i-1] is smaller than arr[n-1], and max ending with arr[n-1] needs
       to be updated, then update it */
    for($i=1;$i<$n;$i++){
        $res = _reclis($arr,$i,$max_ref);
        if($arr[$i-1] < $arr[$n-1] && $res+1>$maxending)
            $maxending = $res+1;        
    }
    // Compare max_ending_here with the overall max. And update the
    // overall max if needed
    if($max_ref < $maxending)
        $max_ref = $maxending;
    // Return length of LIS ending with arr[n-1]
    return $maxending;
}
function reclis($arr,$n){
    $max = 1;
    _reclis($arr,$n,$max);
    return $max;
}

/**
 * Dynamic Programming implementation (O(n^2))
 */
function dplis($arr,$n){
    $i=$j=$max=0;
    $lis = array();
    
    /* Initialize LIS values for all indexes */
    for($i=0;$i<$n;$i++)
        $lis[$i]=1;
    /* Compute optimized LIS values in bottom up manner */
    for($i=1;$i<$n;$i++)
        for($j=0;$j<$i;$j++)
            if($arr[$i]>$arr[$j] && $lis[$i] < $lis[$j]+1)
                $lis[$i]=$lis[$j]+1;
    /* Pick maximum of all LIS values */
    for($i=0;$i<$n;$i++)
        if($max<$lis[$i])
            $max = $lis[$i];
    
    return $max;
          
}

/**
 * Using binary search (O(nlogn)) 
 */
function bslis(&$a,&$b){
    $p = array();
    if(empty($a)) return;
    $b[] = 0;
    for($i=0;$i<count($a);$i++){
        // If next element a[i] is greater than last element 
        // of current longest subsequence a[b.back()], 
        // just push it at back of "b" and continue
        if($a[end($b)] < $a[$i]){
            $p[$i] = end($b);
            $b[] = $i;
            continue;
        }
        
        // Binary search to find the smallest element referenced by b which is just bigger than a[i]
        // Note : Binary search is performed on b (and not a). Size of b is always <=k 
        // and hence contributes O(log k) to complexity.  
        for($u=0,$v=count($b)-1;$u<$v;){
            $c = floor(($u+$v)/2);
            if($a[$b[$c]] < $a[$i])
                $u = $c+1;
            else
                $v = $c;
        }
        
        // Update b if new value is smaller then previously referenced value 
        if($a[$i] < $a[$b[$u]]){
            if($u>0)
                $p[$i] = $b[$u-1];
            $b[$u] = $i;
        }
    }
    $v = end($b);
    for($u=count($b), $v=end($b);$u--;$v=$p[$v]) $b[$u]=$v;
}
$arr = array(10,22,9,33,21,50,41,60,3,40,65,30,70,71,20,40);
$n = count($arr);
$bt = microtime(true);
echo "Reclis = ".reclis($arr,$n)."\n";
$at = microtime(true);
echo "Recursive Algorithm toke ".($at-$bt)." seconds to complete\n";
$bt = microtime(true);
echo "DPlis = ".dplis($arr, $n)."\n";
$at = microtime(true);
echo "Dynamic Programming Algorithm toke ".($at-$bt)." seconds to complete\n";
$bt = microtime(true);
$b = array();
@bslis($arr,$b);
echo "BSlis = ".count($b)."\n";
$at = microtime(true);
echo "Binary Search Algorithm toke ".($at-$bt)." seconds to complete\n";
echo "LIS: ";
foreach($b as $i) echo $arr[$i]." ";
echo "\n";
?>
