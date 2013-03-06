<?php
/*
 * Iterate over a singly linked list backwards. Call print on each node.
 * 
 * @author Martí Planellas
 */
function reverselist($list){
    $cur = $list->current();
    $list->next();
    if($list->current()==NULL){
        echo $cur.'->';
        return;
    }
    reverselist($list);
    echo $cur.'->';
}
function printlist(&$list){
    $list->rewind();
    $cur = $list->current();
    while($list->key()!=$list->count()){
        echo $cur.'->';
        $list->next();
        $cur = $list->current();
    }
    print "\n";
}

$list = new SplDoublyLinkedList(); //Using it as a singly linked
for($i=0;$i<10;$i++)
    $list->push($i);
printlist($list);
$list->rewind();
reverselist($list);


?>
