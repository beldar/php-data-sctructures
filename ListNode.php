<?php
/**
 * ListNode
 * Node containing a data element and a "pointer" to the next element, NULL if not any
 *
 * @author Martí
 */
class ListNode {
    
    private $element;
    private $next;
    
    public function __construct($element){
        $this->element = $element;
        $this->next = NULL;
    }
    
    public function getElement() {
        return $this->element;
    }

    public function setElement($element) {
        $this->element = $element;
    }

    public function getNext() {
        return $this->next;
    }

    public function setNext($next) {
        $this->next = $next;
    }
}

?>
