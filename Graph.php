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
        if(!$this->_isdirected)
            return false;
        $topological = array();
        $this->DFS($topological);
        return $this->_assertAcyclic($topological);
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
    
    public function TopologicalSort($assertAC=false){
        if(!$this->_isdirected)
            throw new Exception("Can't do a Topological sort on a non Directional Graph");
        $topological = array();
        $this->DFS($topological);
        if(!$assertAC || $this->_assertAcyclic($topological))
            return $topological;
        else
            return false;
    }
    
    private function _assertAcyclic($t){
        foreach($t as $node){
            $p = $node->getAttr('p');
            while($p!==false){
                if($this->edgeExists($node->getKey(), $p->getKey()))
                        return false;
                $p = $p->getAttr('p');
            }
        }
        return true;
    }
    
    public function DFS(&$topological=false){
        // 1 => WHITE, 2 => GRAY, 3 => BLACK
        foreach($this->_nodes as $node)
            $node->setAttr('color',1)->setAttr('p',false)->setAttr('d',0);
        $time = 0;
        foreach($this->_nodes as $node)
            if($node->getAttr('color')==1)
                $this->_DFSvisit($node->getKey(),$time,$topological);
    }
    
    private function _DFSvisit($u,&$t,&$topological=false){
        $t++;
        $un = $this->_nodes[$u];
        $un->setAttr('d',$t)->setAttr('color',2);
        if(isset($this->_adjency[$u])){
            foreach($this->_adjency[$u] as $v=>$w){
                $vn =& $this->_nodes[$v];
                if($vn->getAttr('color')==1){
                    $vn->setAttr('p',$un);
                    $this->_DFSvisit($v, $t,$topological);
                }
            }
        }
        $un->setAttr('color',3);
        $t++;
        $un->setAttr('f',$t);
        if($topological!==false)
            array_unshift($topological,$un);
    }
    
    public function Dijkstra($s,$d=false,$wf=false){
        $this->_initSingleSource($s);
        $q = $this->_nodes;
        while(count($q)>0){
            $u = $this->_getMinDist($q); //Search and remove from $q
            if($d && $u->getKey()==$d)
                return $this->_pathTo($d);
            if($u->getAttr('d')===INF)
                break;
            foreach($this->_adjency[$u->getKey()] as $v=>$w){
                if(isset($q[$v])){
                    $this->_relax($u->getKey(), $v, $wf);
                    $q[$v] = $this->_nodes[$v];
                }
            }
        }
    }
    
    private function _pathTo($d){
        $s = array();
        $u = $this->_nodes[$d];
        $p = $u->getAttr('p');
        while($p!=false){
            array_unshift($s,$p);
            $p = $p->getAttr('p');
        }
        $s[] = $u;
        return $s;
    }
    
    private function _getMinDist(&$nodes){
        $mindist = INF;
        $minnode = false;
        foreach($nodes as $key=>$n){
            if($n->getAttr('d')<=$mindist){
                $mindist = $n->getAttr('d');
                $minnode = $key;
            }
        }
        $n = $nodes[$minnode];
        unset($nodes[$minnode]);
        return $n;
    }
    

}
$node = new GraphNode(1);
$g = new Graph(true);
$g->addNode($node);
$g->addNode(2);
$g->addNode(3)->addNode(4)->addNode(5);
//$g->addEdge(1,5)->addEdge(2,1)->addEdge(3,1)->addEdge(3,4)->addEdge(2,5)->addEdge(4,5);//Acyclic
$g->addEdge(1,2,10)->addEdge(2,4)->addEdge(4,3)->addEdge(3,2)->addEdge(5,2)->addEdge(3,5)->addEdge(1,3); //Cyclic
$g->printgraph();
/*echo "Is acyclic:";
var_dump($g->isAcyclic());
$t = $g->TopologicalSort();
if($t){
    foreach($t as $n)
        echo $n->getKey().",";
    echo "\n";
}*/
$nodes = $g->Dijkstra(1,5);
foreach($nodes as $n)
    echo $n->getKey()." -> ";
echo "\n";
$g->printNodes(array('d'));
/*$g->removeEdge(5,5);
$g->printgraph();
$g->removeNode(1);
$g->printgraph();
var_dump($g->isAcyclic());
var_dump($g->edgeExists(1, 5));
var_dump($g->edgeExists(2, 3));*/
?>
