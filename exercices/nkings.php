<?php
/*
You have an N x N chessboard and you wish to place N kings on it. 
Each row and column should contain exactly one king, and no two kings should attack each other 
(two kings attack each other if they are present in squares which share a corner).

The kings in the first K rows of the board have already been placed. You are given the positions of these kings as an array pos[ ]. 
pos[i] is the column in which the king in the ith row has already been placed. 
All indices are 0-indexed. In how many ways can the remaining kings be placed?

Input:
The first line contains the number of test cases T. T test cases follow. Each test case contains N and K on the first line, followed by a line having K integers,
denoting the array pos[ ] as described above.

Output:
Output the number of ways to place kings in the remaining rows satisfying the above conditions. Output all numbers modulo 1000000007.

Constraints:
1 <= T <= 20
1 <= N <= 16
0 <= K <= N
0 <= pos_i < N
The kings specified in the input will be in different columns and not attack each other.

Sample Input:
5
4 1
2
3 0
5 2
1 3
4 4
1 3 0 2
6 1
2

Sample Output:
1
0
2
1
18

Explanation:
For the first example, there is a king already placed at row 0 and column 2. The king in the second row must belong to column 0. 
The king in the third row must belong to column 3, and the last king must beong to column 1. Thus there is only 1 valid placement.

For the second example, there is no valid placement.
 * 
 * @author Martí Planellas
 * Note: Not fast nor optimal solution, didn't pass the extra tests...
 */
$n = intval(fgets( STDIN ));

while($n>0){
    $op = fgets( STDIN );
    $nk = explode(" ",$op);
    $nn = intval($nk[0]);
    $k = intval($nk[1]);
    if($k>0){
        $poses = fgets( STDIN );
        $poses = explode(" ",$poses);
    }elseif($k==0)
        fgets( STDIN );
    foreach($poses as &$p) $p = intval($p);
    $pos = array();
    $col = false;
    for($i=0;$i<$k;$i++){
        $col = array_shift($poses);
        $pos[$i][$col] = true;
    }
    $s = new Solution($pos,$nn);
    $r = $s->solve($k-1);
    echo ($r%1000000007)."\n";
    $n--;
}

class Solution{
    var $b = array();
    var $ocu = array();
    
    public function __construct($board,$n) {
        $this->b = $board;
        for($i=0;$i<$n;$i++)
            for($j=0;$j<$n;$j++)
                if(isset($this->b[$i][$j]))
                    $this->ocu[$j] = $j;
                else
                    $this->b[$i][$j] = false;
                
        
    }
    
    public function solve($k){
        $bl = count($this->b);
        if($k==$bl-1)
            return 1;
        $total = 0;
        for($i=0;$i<$bl;++$i){
            $w = 1;
            if(!$this->Attack($k+1,$i)){
                $this->b[$k+1][$i] = true;
                $this->ocu[$i] = $i;
                $w *= $this->solve($k+1);
                $this->b[$k+1][$i] = false;
                unset($this->ocu[$i]); 
            }else
                $w = 0;
            $total += $w;
        }
        return $total;
    }
    
    public function Attack($r,$c){
        if(isset($this->ocu[$c]))
            return true;
        if(($c>0 && $r>0 && $this->b[$r-1][$c-1]) 
           ||  ($c<count($this->b)-1 && $r>0 && $this->b[$r-1][$c+1])){
            return true;
        }
        return false;
    }
    
}
?>
