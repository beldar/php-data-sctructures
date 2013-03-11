<?php

/**
 * Graph implementation using dynamic adjency matrix, similar to linked list
 *
 * @author Marti.Planellas
 */
class GraphNode{
    private $key;
    private $data;
    private $attributes;
    
    public function __construct($key,$data=false, $attrs=array()) {
        if(!$data) $data = $key;
        $this->key = $key;
        $this->data = $data;
        $this->attributes = $attrs;
    }
    
    public function __toString() {
        $out = "\n\t".$this->key." => ";
        foreach($this->attributes as $k=>$v)
            $out .= $k."=".$v.",";
        return $out."\n";
    }
    
    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function setAttributes($attributes) {
        $this->attributes = $attributes;
    }
    
    public function setAttr($key,$value){
        $this->attributes[$key] = $value;
        return $this;
    }
    
    public function getAttr($key){
        if(!isset($this->attributes[$key]))
            return false;
        else
            return $this->attributes[$key];
    }
    
    public function remAttr($key){
        if(isset($this->attributes[$key]))
            unset($this->attributes[$key]);
    }
}
class Graph {
    private $_nodes = array();
    private $_adjency = array();
    private $_isdirected = false;
    
    public function __construct($directed=false) {
        if($directed) $this->_isdirected = true;
    }
    
    public function addNode($newnode){
        if(is_int($newnode)) $newnode = new GraphNode($newnode);
        $key = $newnode->getKey();
        if(isset($this->_nodes[$key]))
            throw new Exception('Node key already exists, remove it if you want to add this one');
        else{
            $this->_nodes[$key] = $newnode;
        }
        
        return $this;
    }
    
    public function addEdge($source,$dest,$value=1){
        if(!isset($this->_adjency[$source])) $this->_adjency[$source] = array();
        if(!isset($this->_adjency[$dest]) && !$this->_isdirected) $this->_adjency[$dest] = array();
        $this->_adjency[$source][$dest] = $value;
        if(!$this->_isdirected)
            $this->_adjency[$dest][$source] = $value;
        
        return $this;
    }
    
    public function removeEdge($source,$dest){
        if(!isset($this->_adjency[$source][$dest]))
            throw new Exception("Edge doesn't exist");
        else{
            unset($this->_adjency[$source][$dest]);
            if(!$this->_isdirected)
                unset($this->_adjency[$dest][$source]);
        }
        
        return $this;
    }
    
    public function edgeExists($source,$dest){
        return (isset($this->_adjency[$source]) && isset($this->_adjency[$source][$dest]));
    }
    
    public function nodeExists($key){
        return isset($this->_nodes[$key]);
    }
    
    public function getNode($key){
        if(!isset($this->_nodes[$key]))
            throw new Exception("Node doesn't exist");
        else
            return $this->_nodes[$key];
    }
    
    public function removeNode($key){
        if(!isset($this->_nodes[$key]))
            throw new Exception("Node doesn't exist");
        else{
            foreach($this->_adjency as &$adj)
                if(isset($adj[$key]))
                    unset($adj[$key]);
            unset($this->_adjency[$key]);
            unset($this->_nodes[$key]);
        }
        
        return $this;
    }
    
    public function resetNodeAttrs(){
        foreach($this->_nodes as $node)
            $node->setAttributes(array());
    }
    
    public function printgraph($d=false,$f=false){
        foreach($this->_adjency as $key=>$adj)
            foreach($adj as $dest=>$value)
                if($value!=0)
                    if(!$d) echo "$key -> $dest\n";
                    elseif(!$f) echo "$key (".$this->_nodes[$key]->getAttr('d').") -> $dest (".$this->_nodes[$dest]->getAttr('d').")\n";
                    else echo "$key (".$this->_nodes[$key]->getAttr('d')."/".$this->_nodes[$key]->getAttr('f').") -> $dest (".$this->_nodes[$dest]->getAttr('d')."/".$this->_nodes[$dest]->getAttr('f').")\n";
        echo "\n";
    }
    
    public function printNodes($print=false){
        foreach($this->_nodes as $node){
            $out = $node->getKey()." => ";
            if(!$print){
                foreach($node->getAttributes() as $k=>$v)
                    $out .= "$k=$v,";
            }else{
                foreach($print as $pa)
                    $out .= "$pa=".$node->getAttr($pa).",";
            }
            echo $out."\n";
        }
    }
    
    public function dumpadj(){
        var_dump($this->_adjency);
    }
    
    public function dumpnodes(){
        var_dump($this->_nodes);
    }
    
    public function isAcyclic(){
        if(!$this->_isdirected) return false;
        else{
            foreach($this->_adjency as $s=>$ds)
                foreach($ds as $d=>$v)
                    if($d!=$s)
                        $this->_nodes[$d]->setAttr('visited',true);
            $cyclic = true;
            foreach($this->_nodes as $node){
                if(!$node->getAttr('visited'))
                    $cyclic = false;
                $node->remAttr('visited');
            }
                
            return !$cyclic;
        }
    }
    
    private function _initSingleSource($s){
        if(!isset($this->_nodes[$s]))
            throw new Exception("Node doesn't exist");
        else{
            foreach($this->_nodes as $n)
                $n->setAttr('d',INF)->setAttr('p',false);
            $this->_nodes[$s]->setAttr('d',0);
        }    
    }
    
    private function _relax($u,$v,$wf=false){
        if(!isset($this->_adjency[$u][$v]))
            throw new Exception("Edge doesn't exist");
        else{
            if($wf)
                $w = $wf($u,$v);
            else
                $w = $this->_adjency[$u][$v];
            $ud = $this->_nodes[$u]->getAttr('d');
            $vd = $this->_nodes[$v]->getAttr('d');
            if($vd > $ud+$w){
                $this->_nodes[$v]->setAttr('d', $ud+$w);
                $this->_nodes[$v]->setAttr('p', $this->_nodes[$u]);
            }
        }
    }
    
    public function BellmanFord($s,$wf=false){
        $this->_initSingleSource($s);
        foreach($this->_adjency as $u=>$adj)
            foreach($adj as $v=>$w)
                $this->_relax ($u, $v);
        foreach($this->_adjency as $u=>$adj){
            foreach($adj as $v=>$w){
                $ud = $this->_nodes[$u]->getAttr('d');
                $vd = $this->_nodes[$v]->getAttr('d');
                if($wf)
                    $w = $wf($u,$d);
                else
                    $w = $this->_adjency[$u][$v];
                if($vd > $ud + $w)
                    return false;
            }
        }
        return true;            
    }
    
    public function TopologicalSort(){
        //TODO
    }
    
    public function DFS(){
        // 1 => WHITE, 2 => GRAY, 3 => BLACK
        foreach($this->_nodes as $node)
            $node->setAttr('color',1)->setAttr('p',false)->setAttr('d',0);
        $time = 0;
        foreach($this->_nodes as $node)
            if($node->getAttr('color')==1)
                $this->_DFSvisit($node->getKey(),$time);
    }
    
    private function _DFSvisit($u,&$t){
        $t++;
        $un = $this->_nodes[$u];
        $un->setAttr('d',$t)->setAttr('color',2);
        foreach($this->_adjency[$u] as $v=>$w){
            $vn =& $this->_nodes[$v];
            if($vn->getAttr('color')==1){
                $vn->setAttr('p',$un);
                $this->_DFSvisit($v, $t);
            }
        }
        $un->setAttr('color',3);
        $t++;
        $un->setAttr('f',$t);
    }
    
    

}
$node = new GraphNode(1);
$g = new Graph(true);
$g->addNode($node);
$g->addNode(2);
$g->addNode(3)->addNode(4);
$g->addEdge(1, 2)->addEdge(2, 4)->addEdge(4, 3)->addEdge(3,1);
$g->printgraph();
var_dump($g->isAcyclic());
//$g->dumpnodes();
$g->addNode(5)->addEdge(5,1)->addEdge(1,5);
$g->printgraph();
var_dump($g->isAcyclic());
$g->DFS();
$g->printNodes(array('d','f'));
/*$g->removeEdge(5,5);
$g->printgraph();
$g->removeNode(1);
$g->printgraph();
var_dump($g->isAcyclic());
var_dump($g->edgeExists(1, 5));
var_dump($g->edgeExists(2, 3));*/
?>
