<?php
/*
 * BST
 */
class TreeNode{
    var $key = false;
    var $left = false;
    var $right = false;
    var $parent = false;
    
    public function __construct($key) {
        $this->key = $key;
    }
    
    public function __toString() {
        return (string)$this->key;
    }
}
class BST{
    var $root = false;
    var $count = 0;
    public function __construct($root=false) {
        if($root){
            $this->root = $root;
            $this->count++;
        }
    }
    
    public function insert($node){
        if(!$this->root){
            $this->root = $node;
            $this->count++;
        }else{
            $y = false;
            $x = $this->root;
            while($x!=false){
                $y = $x;
                if($node->key < $x->key)
                    $x = $x->left;
                else 
                    $x = $x->right;
            }
            $node->parent = $y;
            if($node->key < $y->key)
                $y->left = $node;
            else
                $y->right = $node;
            $this->count++;
        }
    }
    
    public function minimum($node=false){
        if(!$node) $node = $this->root;
        while($node->left)
            $node = $node->left;
        return $node;
    }
    
    public function maximum($node=false){
        if(!$node) $node = $this->root;
        while($node->right)
            $node = $node->right;
        return $node;
    }
    //search, mininum, maximum, predecessor, successor, insert, delete
    public function search($k, $node=false){
        if(!$node) $node = $this->root;
        if(!$node || $k==$node->key)
            return $node;
        if($k<$node->key)
            return $this->search($k, $node->left);
        else
            return $this->search($k, $node->right);
    }
    
    public function inorder($node){
        if($node){
            $this->inorder($node->left);
            print $node->key." ";
            $this->inorder($node->right);
        }
    }
    
    public function successor($node){
        if(!$node->right)
            return $this->minimum($node->right);
        $y = $node->parent;
        while($y && $node === $y->right){
            $node = $y;
            $y = $y->parent;
        }
        return $y;
    }
    
    public function delete($node){
        if(is_int($node))
            $node = $this->search($node);
        if(!$node->left)
            $this->transplant($node, $node->right);
        elseif(!$node->right)
            $this->transplant($node, $node->left);
        else{
            $y = $this->minimum($node->right);
            if($y->parent!=$node){
                $this->transplant($y, $y->right);
                $y->right = $node->right;
                $y->right->parent = $y;
            }
            $this->transplant($node, $y);
            $y->left = $node->left;
            $y->left->parent = $y;
            unset($node);
        }   
    }
    
    public function height(){
        return floor(log($this->count,2));
    }
    
    private function transplant($u,$v){
        if(!$u->parent)
            $this->root = $v;
        elseif($u === $u->parent->left)
            $u->parent->left = $v;
        else
            $u->parent->right = $v;
        if($v)
            $v->parent = $u->parent;
    }
    
    public function printl(){
        $lvl = 0;
        $q = array();
        $q[0] = array();
        $q[0][] = $this->root->key;
        $this->_printl($this->root->left,$lvl+1,$q);
        $this->_printl($this->root->right,$lvl+1,$q);
        $out = "";
        $sp = pow(2,count($q))*2;
        $totalh = $this->height();
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
    
    public function _printl($node,$lvl,&$q){
        if($node){
            if(!isset($q[$lvl])) $q[$lvl] = array();
            $q[$lvl][] = $node->key;
            if($node->left) $this->_printl($node->left,$lvl+1,$q);
            if($node->right) $this->_printl($node->right,$lvl+1,$q);
        }
    }
}
$bst = new BST();
$a = array(5,3,8,2,4,7,9,1,6);
foreach($a as $i){
    $node = new TreeNode($i);
    $bst->insert($node);
}
//var_dump($bst);
$bst->printl();
echo "Maximum: ".$bst->maximum()->key."\n";
echo "Minimum: ".$bst->minimum()->key."\n";
$bst->delete($bst->root);
$bst->printl();
$bst->delete(1);
$bst->printl();
$bst->inorder($bst->root);
echo "\n";

?>
