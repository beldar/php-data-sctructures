<?php
/**
 * BiDirectional List Node
 *
 * @author Martí
 */
include "ListNode.php";

class BDListNode extends ListNode{
    protected $previous;
    
    public function __construct($element) {
        parent::__construct($element);
        $this->previous = NULL;
    }
    
    public function getPrevious() {
        return $this->previous;
    }

    public function setPrevious($previous) {
        $this->previous = $previous;
    }

}

?>
