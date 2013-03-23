<?php
/*
 * Solution to problem: http://www.spoj.com/problems/ONP/
 * Accepted! 0.52 sec, 14M MEM
4. Transform the Expression

Problem code: ONP

Transform the algebraic expression with brackets into RPN form (Reverse Polish Notation). Two-argument operators: +, -, *, /, ^ (priority from the lowest to the highest), brackets ( ). Operands: only letters: a,b,...,z. Assume that there is only one RPN form (no expressions like a*b*c).

Input

t [the number of expressions <= 100]
expression [length <= 400]
[other expressions]
Text grouped in [ ] does not appear in the input file.

Output

The expressions in RPN form, one per line.
Example

Input:
3
(a+(b*c))
((a+b)*(z+x))
((a+t)*((b+(a+c))^(c+d)))

Output:
abc*+
ab+zx+*
at+bac++cd+^*
 */
$pri = array();
$pri['+'] = 0;
$pri['-'] = 1;
$pri['*'] = 2;
$pri['/'] = 3;
$pri['^'] = 4;
$pri['('] = -1;
$ops = array_keys($pri);
$n = intval(fgets(STDIN));
while($n>0){
    $expr = fgets(STDIN);
    echo rpn($expr,$ops,$pri)."\n";
    $n--;
}

function rpn($expr,$ops,$pri){
    $outq = array();
    $opq = array();
    for($i=0;$i<strlen($expr);$i++){
        $t = $expr[$i];
        if($t!=')' && !in_array($t, $ops)){
            $outq[] = $t;
        }elseif($t!=')'){
            $top = end($opq);
            if($top!='(' && $t!='(' &&count($opq)>0 && $pri[$top]>$pri[$t]){
                //echo "$top>$t\n";
                $outq[] = array_pop($opq);
            }
            $opq[] = $t;
        }elseif($t==')'){
            $top = end($opq);
            while($top!='('){
                $outq[] = array_pop($opq);
                $top = end($opq);
            }
            array_pop($opq); //( 
        }
    }
    while(count($opq)>0)
        $outq[] = array_pop($opq);
    return implode($outq);
}
?>
