<?php
/**
 * LinkedList
 * Liked List implementation as taught in my college with dummy node and Point of Interest
 *
 * @author Martí
 */
include "ListNode.php";

class LinkedList {
    private $head;
    private $current;
    private $count;
    
    public function __construct() {
        $this->head = new ListNode(NULL); //Dummy node
        $this->current = $this->head;
        $this->count = 0;
    }
    
    public function __destruct() {
        while($this->head!=NULL){
            $aux = $this->head;
            $this->head = $this->head->getNext();
            unset($aux);
        }
    }
    
    public function insert($element){
        $aux = new ListNode($element);
        $aux->setNext($this->current->getNext());
        $this->current->setNext($aux);
        $this->current = $aux;
        $this->count++;
    }
    
    public function getElement(){
        $e = false;
        if($this->current->getNext()!=NULL)
            $e = $this->current->getNext()->getElement();
        return $e;
    }
    
    public function remove(){
        if($this->current->getNext()==NULL)
            return false;
        else{
            $aux = $this->current->getNext();
            $this->current->setNext($aux->getNext());
            unset($aux);
            if($this->count>0) $this->count--;
            return true;
        }
    }
    
    public function forward(){
        if($this->current->getNext()==NULL)
            return false;
        else{
            $this->current = $this->current->getNext();
            return true;
        }
    }
    
    public function end(){
        return $this->current->getNext()==NULL;
    }
    
    public function goBegin(){
        $this->current = $this->head;
    }
    
    public function clear(){
        $this->goBegin();
        while(!$this->end()){
            $this->remove();
            $this->forward();
        }
        $this->head = new ListNode(NULL); //Dummy node
        $this->current = $this->head;
        $this->count = 0;
    }
    
    public function getCount(){
        return $this->count;
    }
    
    public function isempty(){
        return $this->head->getNext()==NULL;
    }
    
    public function findElement($element){
        if($this->isempty())
            return false;
        else{
            $this->goBegin();
            if($this->getElement()==$element)
                $found = $this->getElement ();
            else
                $found = false;
            while($this->forward() && !$found){
                if($this->getElement()==$element)
                    $found = $this->getElement();
                $this->forward();
            }
            return $found;
        }
    }
}
?>
