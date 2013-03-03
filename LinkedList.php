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
    private $previous;
    private $count;
    
    public function __construct() {
        $this->head = new ListNode(NULL); //Dummy node
        $this->previous = $this->head;
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
        $aux->setNext($this->previous->getNext());
        $this->previous->setNext($aux);
        $this->previous = $aux;
        $this->count++;
    }
    
    public function getElement(){
        $e = false;
        if($this->previous->getNext()!=NULL)
            $e = $this->previous->getNext()->getElement();
        return $e;
    }
    
    public function remove(){
        if($this->previous->getNext()==NULL)
            return false;
        else{
            $aux = $this->previous->getNext();
            $this->previous->setNext($aux->getNext());
            unset($aux);
            if($this->count>0) $this->count--;
            return true;
        }
    }
    
    public function forward(){
        if($this->previous->getNext()==NULL)
            return false;
        else{
            $this->previous = $this->previous->getNext();
            return true;
        }
    }
    
    public function end(){
        return $this->previous->getNext()==NULL;
    }
    
    public function goBegin(){
        $this->previous = $this->head;
    }
    
    public function clear(){
        $this->goBegin();
        while(!$this->end()){
            $this->remove();
            $this->forward();
        }
        $this->head = new ListNode(NULL); //Dummy node
        $this->previous = $this->head;
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
