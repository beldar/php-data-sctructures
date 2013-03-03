<?php
/**
 * BiDirectional Linked List
 * 
 * With double dummy nodes and Point of Interest
 *
 * @author Martí
 */
require_once "BDListNode.php";

class BDLinkedList {
    private $head;
    private $tail;
    private $current;
    private $count;
    
    public function __construct() {
        $this->head = new BDListNode(NULL);
        $this->tail = new BDListNode(NULL);
        $this->current = $this->tail;
        $this->head->setPrevious(NULL);
        $this->head->setNext($this->tail);
        $this->tail->setPrevious($this->head);
        $this->tail->setNext(NULL);
        $this->count = 0;
    }
    
    public function __destruct() {
        while($this->head!=NULL){
            $aux = $this->head;
            $this->head = $this->head->getNext();
            unset($aux);
        }
    }
    
    public function insertBefore($el){
        if($this->current==$this->head)
            return false;
        else{
            $aux = new BDListNode($el);
            $aux->setNext($this->current);
            $aux->setPrevious($this->current->getPrevious());
            $this->current->getPrevious()->setNext($aux);
            $this->current->setPrevious($aux);
            $this->count++;
            return true;
        }
    }
    
    public function insertAfter($el){
        if($this->current==$this->tail)
            return false;
        else{
            $aux = new BDListNode($el);
            $aux->setPrevious($this->current);
            $aux->setNext($this->current->getNext());
            $this->current->getNext()->setPrevious($aux);
            $this->current->setNext($aux);
            $this->count++;
            return true;
        }
    }
    
    public function getElement(){
        $e = false;
        if($this->current!=$this->head && $this->current!=$this->tail)
            $e = $this->current->getElement();
        return $e;
    }
    
    public function remove(){
        if($this->current==$this->head || $this->current==$this->tail)
            return false;
        else{
            $aux = $this->current;
            $this->current->getPrevious()->setNext($aux->getNext());
            $this->current->getNext()->setPrevious($aux->getPrevious());
            $this->current = $aux->getNext();
            unset($aux);
            if($this->count>0) $this->count--;
            return true;
        }
    }
    
    public function forward(){
        if($this->current==$this->tail)
            return false;
        else{
            $this->current = $this->current->getNext();
            return true;
        }
    }
    
    public function backward(){
        if($this->current==$this->head)
            return false;
        else{
            $this->current = $this->current->getPrevious();
            return true;
        }
    }
    
    public function isTail(){
        return $this->current==$this->tail;
    }
    
    public function isHead(){
        return $this->current==$this->head;
    }
    
    public function goBegin(){
        $this->current = $this->head->getNext();
    }
    
    public function goEnd(){
        $this->current = $this->tail->getPrevious();
    }
    
    public function isEmpty(){
        return $this->head->getNext()==$this->tail;
    }
    
    public function getCount(){
        return $this->count;
    }
    
    public function clear(){
        $this->goBegin();
        while(!$this->isTail()){
            $this->remove();
            $this->forward();
        }
        $this->head = new BDListNode(NULL);
        $this->tail = new BDListNode(NULL);
        $this->current = $this->tail;
        $this->head->setPrevious(NULL);
        $this->head->setNext($this->tail);
        $this->tail->setPrevious($this->head);
        $this->tail->setNext(NULL);
        $this->count = 0;
    }
    
    public function printlist(){
        $this->goBegin();
        print $this->getElement();
        while($this->forward()){
            print $this->getElement();
        }
    }
}
/*$list = new BDLinkedList();
$list->goBegin();
$list->insertBefore(3);
$list->insertBefore(2);
$list->insertBefore(1);
$list->printlist();
$list = new BDLinkedList();
$list->goEnd();
$list->insertAfter(3);
$list->insertAfter(2);
$list->insertAfter(1);
$list->printlist();*/
?>
