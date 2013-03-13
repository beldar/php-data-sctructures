<?php

/**
 * Kind of similar to BST left child < parent, and right child > parent, 
 * but may not be true for the whole branch, see example below.
 * 
 * Pros: 
 *  * Implementation using array (similar to MaxHeap on this repo)
 *  * Faster insert and rotation (swaping elements)
 * 
 * Cons:
 *  * Search (Find) complexity is O(2*h), instead of O(h) of true BST (where h is tree height)
 *
 * @author Marti.Planellas
 */

class BST {
    private $a = array();
    private $hsize = 0;
    
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
        return floor(($i-1)/2);
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
        $this->a[] = $e;
        $this->hsize++;
        if($this->hsize>1)
            $this->_balance($this->hsize-1);
        return $this;
    }
    
    private function _balance($i){
        $p = $this->parent($i);
        if($p>=0){
            $l = $this->left($p);
            if($l<$this->hsize && $this->a[$p]<$this->a[$l]){
                $this->swap($l,$p);
                $this->_balance($p);
            }
            $r = $this->right($p);
            if($r<$this->hsize && $this->a[$p]>$this->a[$r]){
                $this->swap($r,$p);
                $this->_balance($p);
            }
        }
    }
    
    public function inorder($i){
        if($i<$this->hsize){
            $this->inorder($this->left($i));
            echo $this->a[$i]."  ";
            $this->inorder($this->right($i));
        }
    }
    
    public function find($e){ //O(2*h)
        $i = 0;
        $e = intval($e);
        if($this->a[$i]==$e)
            return 0;
        else{
            $l = $this->_find($e,$this->left($i));
            $r = $this->_find($e,$this->right($i));
            $s = ($l ? $l : $r);
            return $s;
        }
    }
    
    public function _find($e,$i){
        $s = false;
        while($i<$this->hsize && !$s){
            if($this->a[$i]==$e)
                $s = $i;
            else{
                if($e<$this->a[$i])
                    $i = $this->left($i);
                else
                    $i = $this->right($i);
            }
        }
        return $s;
    }
    
    public function printl(){
        $lvl = 0;
        $q = array();
        $q[0] = array();
        $q[0][] = $this->a[0];
        $this->_printl($this->left(0),$lvl+1,$q);
        $this->_printl($this->right(0),$lvl+1,$q);
        $out = "";
        $sp = pow(2,count($q))*2;
        $totalh = $this->height($this->hsize);
        foreach($q as $lvl=>$nodes){
            $sp = floor($sp/2);
            $sp2 = $sp-floor(count($nodes)/2);
            $i=1;
            foreach($nodes as $node){
                if($i%2==0) $sp2 += $sp2;
                else $sp2 = $sp-$totalh;
                if($sp2<4) $sp2+=2;
                $out .= sprintf("%".$sp."s%-".$sp2."s",$node," ");
                $i++;
            }
            $out .= "\n\n";
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
}
$bst = new BST();
$a = array(3,8,5,7,10,3,5,2,1,1,20,3,5);
foreach($a as $e)
    $bst->insert($e);
$bst->printl();
/*
               5

       5            7

   1     10      3      8

 2  3  1  20   3  5
 */
$s1 = $bst->find(20);
$s2 = $bst->find(4);
echo "Number 20 found in position: ".($s1?$s1:'Not found')."\n";
echo "Number 4 found in position: ".($s2?$s2:'Not found')."\n";
?>
