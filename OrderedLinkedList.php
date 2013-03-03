<?php

/**
 * Description of OrderedLinkedList
 *
 * @author Martí
 */
include "LinkedList.php";

class OrderedLinkedList extends LinkedList{
    
    public function orderedinsert($element){
        $this->goBegin();
        $found = false;
        while(!$this->end() && !$found){
            if($this->getElement()<$element)
                $this->forward ();
            else
                $found = true;
        }
        $this->insert($element);
    }
}

?>
