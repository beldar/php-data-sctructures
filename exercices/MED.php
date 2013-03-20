<?php

class MinEditDist{
    private $delCost = 1;
    private $insCost = 1;
    private $subCost = 2;
    private $distMatrix = array();
    private $str1 = "";
    private $str2 = "";
    
    public function __construct($str1,$str2,$delCost=1,$insCost=1,$subCost=2) {
        $this->str1 = $str1;
        $this->str2 = $str2;
        $this->delCost = $delCost;
        $this->insCost = $insCost;
        $this->subCost = $subCost;
        $this->_buildMatrix();
    }
    
    private function _buildMatrix(){
        $this->distMatrix = array();
        $this->distMatrix[0][0] = 0;
        for($i=1;$i<strlen($this->str1)+1;$i++)
            $this->distMatrix[$i][0] = $this->distMatrix[$i-1][0] + 1;
        for($i=1;$i<strlen($this->str2)+1;$i++)
            $this->distMatrix[0][$i] = $this->distMatrix[0][$i-1] + 1;
    }
    
    public function getDelCost() {
        return $this->delCost;
    }

    public function setDelCost($delCost) {
        $this->delCost = $delCost;
    }

    public function getInsCost() {
        return $this->insCost;
    }

    public function setInsCost($insCost) {
        $this->insCost = $insCost;
    }

    public function getSubCost() {
        return $this->subCost;
    }

    public function setSubCost($subCost) {
        $this->subCost = $subCost;
    }

    public function getStr1() {
        return $this->str1;
    }

    public function setStr1($str1) {
        $this->str1 = $str1;
        $this->_buildMatrix();
    }

    public function getStr2() {
        return $this->str2;
    }

    public function setStr2($str2) {
        $this->str2 = $str2;
        $this->_buildMatrix();
    }
    
    public function newStrings($str1,$str2){
        $this->str1 = $str1;
        $this->str2 = $str2;
        $this->_buildMatrix();
    }
   
    public function getMinDist(){
        for($i=1;$i<strlen($this->str1)+1;$i++){
            for($j=1;$j<strlen($this->str2)+1;$j++){
                if($this->str1[$i-1] == $this->str2[$j-1])
                    $this->distMatrix[$i][$j] = $this->distMatrix[$i-1][$j-1];
                else{
                    $this->distMatrix[$i][$j] = min(
                                $this->distMatrix[$i-1][$j] + $this->delCost,
                                $this->distMatrix[$i][$j-1] + $this->insCost,
                                $this->distMatrix[$i-1][$j-1] + $this->subCost
                            );
                }
            }
        }
        return $this->distMatrix[strlen($this->str1)][strlen($this->str2)];
    }
    
    private function _backtrace(){
        $bt = array();
        $i = strlen($this->str1);
        $j = strlen($this->str2);
        while(true){
            $bt[] = array($i,$j);
            if($i==1 && $j==1) break;
            elseif($i==1 && $j>1) $j--;
            elseif($j==1 && $i>1) $i--;
            else{
                if($this->distMatrix[$i-1][$j] < $this->distMatrix[$i-1][$j-1])
                    $i--;
                elseif($this->distMatrix[$i][$j-1] < $this->distMatrix[$i-1][$j-1])
                    $j--;
                else{
                    $i--;
                    $j--;
                }
            }
        }
        $bt = array_reverse($bt);
        return $bt;
    }
    
    public function printAlign(){
        $bt = $this->_backtrace();
        $out = "";
        $out2 = "";
        $out3 = "";
        foreach($bt as $pair){
            $out .= $this->str1[$pair[0]-1];
            $out3 .= $this->str2[$pair[1]-1];
            if($this->str1[$pair[0]-1] == $this->str2[$pair[1]-1])
                $out2 .= "|";
            else
                $out2 .= " ";
        }
        echo $out."\n".$out2."\n".$out3;
    }
    
    public function printDM(){
        $out = "      ";
        for($i=0;$i<strlen($this->str2);$i++)
            $out .= $this->str2[$i]."  ";
        $out .= "\n";
        for($i=0;$i<count($this->distMatrix);$i++){
            if($i==0) $out .= "   ";
            else $out .= $this->str1[$i-1]."  ";
            for($j=0;$j<count($this->distMatrix[$i]);$j++)
                $out .= $this->distMatrix[$i][$j].
                        ($this->distMatrix[$i][$j]>9 ? " ": "  ");
            $out .= "\n";
        }
        echo $out;
    }

}
$med = new MinEditDist("intention", "execution");
echo $med->getMinDist()."\n";
$med->printDM();
//$med->printAlign();
$med->newStrings("abcd", "abd");
echo $med->getMinDist()."\n";

?>
