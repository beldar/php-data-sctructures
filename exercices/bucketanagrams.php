<?php
/*
 * Write a function that takes a list of words as input, and returns a list of those words bucketized by anagrams.
 * @author Martí Planellas
 */

function bucketize($words){
    $r = array();
    foreach($words as $word){
        $ps = str_split(strtolower($word));
        sort($ps,SORT_STRING);
        $hash = implode($ps);
        if(!isset($r[$hash])) $r[$hash] = array();
        $r[$hash][] = $word;
    }
    return $r;
}
$words = array("arras", "raras", "sarar", "tla", "tal", "sort", "tros", "ram", "mar", "alone");
var_dump(bucketize($words));
/*
 * Output
array(5) {
  ["aarrs"]=>
  array(3) {
    [0]=>
    string(5) "arras"
    [1]=>
    string(5) "raras"
    [2]=>
    string(5) "sarar"
  }
  ["alt"]=>
  array(2) {
    [0]=>
    string(3) "tla"
    [1]=>
    string(3) "tal"
  }
  ["orst"]=>
  array(2) {
    [0]=>
    string(4) "sort"
    [1]=>
    string(4) "tros"
  }
  ["amr"]=>
  array(2) {
    [0]=>
    string(3) "ram"
    [1]=>
    string(3) "mar"
  }
  ["aelno"]=>
  array(1) {
    [0]=>
    string(5) "alone"
  }
}
 */
?>
