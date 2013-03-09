<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MaxHeap{
    private $a = array();
    private $hsize = 0;
    private $length = 0;
    
    public function __construct($a=false) {
        if($a){
            $this->a = $a;
            $this->buildmaxheap();
        }
    }
    public function size(){
        return $this->hsize;
    }
    
    public function getA(){
        return $this->a;
    }
    
    public function left($i){
        return 2*$i+1;
    }
    
    public function right($i){
        return 2*$i+2;
    }
    
    public function parent($i){
        return floor($i/2);
    }
    
    public function height($i){
        return floor(log($i,2));
    }
    
    private function swap($i,$j){
        if(isset($this->a[$i]) && isset($this->a[$j])){
            $aux = $this->a[$i];
            $this->a[$i] = $this->a[$j];
            $this->a[$j] = $aux;
        }
    }
    
    public function insert($e){
        array_unshift($this->a,$e);
        $this->hsize++;
        $this->length++;
        $this->maxheapify(0);
    }
    
    public function printl(){
        $lvl = 0;
        $s = $this->a[0];
        $q = array();
        $q[0] = array();
        $q[0][] = $this->a[0];
        $this->_printl($this->left(0),$lvl+1,$q);
        $this->_printl($this->right(0),$lvl+1,$q);
        $out = "";
        $sp = pow(2,count($q))*2;
        foreach($q as $lvl=>$nodes){
            $sp = floor($sp/2);
            $sp2 = $sp-floor(count($nodes)/2);
            $i=1;
            //if($lvl==count($nodes)-1) $sp = $sp2;
            //echo $sp."\n";
            foreach($nodes as $node){
                if($i%2==0) $sp2 += $sp2;
                else $sp2 = $sp-floor(count($nodes)/2);
                $out .= sprintf("%".$sp."s%-".$sp2."s",$node," ");
                $i++;
            }
            $out .= "\n";
        }
        echo $out;
    }
    public function _printl($i,$lvl,&$q){
        if($i<$this->hsize){
            if(!isset($q[$lvl])) $q[$lvl] = array();
            $q[$lvl][] = $this->a[$i];
            $this->_printl($this->left($i),$lvl+1,$q);
            $this->_printl($this->right($i),$lvl+1,$q);
        }
    }
    
    public function maxheight($i){
        $lh = $this->maxheight($this->left($i));
        $rh = $this->maxheight($this->right($i));
        return ($lh>$rh)?$lh+1:$rh+1;
    }
    
    public function maxheapify($i){ //O(logn)
        $l = $this->left($i);
        $r = $this->right($i);
        if($l<$this->hsize && $this->a[$l]>$this->a[$i])
            $largest = $l;
        else
            $largest = $i;
        if($r<$this->hsize && $this->a[$r]>$this->a[$largest])
            $largest = $r;
        if($largest!=$i){
            $this->swap($i,$largest);
            $this->maxheapify($largest);
        }
    }
    
    public function buildmaxheap(){ //O(n)
        $this->length = count($this->a);
        $this->hsize = $this->length;
        for($i=floor($this->length/2)-1;$i>=0;$i--)
            $this->maxheapify($i);
    }
    
    public function heapsort(){ //O(nlogn)
        for($i=$this->length;$i>0;$i--){
            $this->swap(0,$i);
            $this->hsize--;
            $this->maxheapify(0);
        }
        return $this->a;
    }  
}
$a = array(4,1,3,2,16,9,10,14,8,7,3,2,1,5,7,8,10,23);
var_dump($a);
$mh = new MaxHeap($a);
var_dump($mh->getA());
//$mh->insert(20);
//var_dump($mh->getA());
$mh->printl();
//var_dump($mh->heapsort());

?>
