#include <iostream> 
#include <string>
#include <cstdlib>
#include <sstream>

using namespace std; 

bool checknine(string str){
    bool isnine = true;
    for(int i=0;i<str.length();i++){
        if(str[i]!='9'){
            isnine = false;
            break;
        }    
    }
    return isnine;
}

string nextpal(string str){
    istringstream ss(str);
    ostringstream os;
    if(str.length()==1 && str.compare("9")!=0){
        int a;
        ss >> a;
        a++;
        os << a;
        return os.str();
    }else{
        if(checknine(str))
            cout << "All nines!";

    }
        return str;
        
/*if(strlen($str)==1 && $str!="9")
        return ++$str;
    elseif(checknine($str)){
        //print "Case all nines\n";
        $str = str_replace ("9", "0", $str);
        $str[0] = "1";
        return $str."1";
    }else{
        $n = strlen($str);
        $h = floor(strlen($str)/2);
        $isodd = ($n%2==1);
        $i = $h-1;
        $j = $isodd?$h+1:$h;
        if($str[$i]!=$str[$j] && $str[$i]!=9 && $str[$j]!=9){
            if($str[$i]>$str[$j]){
                //print "Case left side largest\n";
                return getmirror($str,$h,$isodd,false);
            }elseif($str[$i]<$str[$j] && $str[$i]!=9 && $str[$j]!=9){
                //print "Case right side largest\n";
                return getmirror($str,$h,$isodd,true);
            }
        }else{
            //print "Case more complex\n";
            $ls = false;
            while($i>0 && $str[$i]==$str[$j]){
                $i--;
                $j++;
            }
            if($i==0 || $str[$i]<$str[$j])
                $ls = true;
            if($i==0 && $str[$i]>$str[$j]){
                $str[$j] = $str[$j]+1;
                return $str;
            }
            if($ls){
                $carry = 1;
                $i=$h-1;
                if($isodd){
                    $aux = $str[$h]+$carry;
                    $carry = $aux/10;
                    $str[$h] = $aux%10;
                    $j = $h+1;
                }else
                    $j = $h;
                while($i>=0 && $carry!=0){
                    $aux = $str[$i]+$carry;
                    $carry = $aux/10;
                    $str[$i] = $aux%10;
                    $str[$j++] = $str[$i--];
                }
                return $str;
            }else
                return getmirror($str,$h,$isodd,false);
                
        }
    }*/
}

int main(int argc, char *argv[]) 
{ 
    int n = 0;
    int i = 0;
    cin >> n;
    string ops[n];
    while(n>0){
        cin >> ops[i];
        i++;
        n--;
    }
    for(n=0;n<i;n++) cout << nextpal(ops[n]) << "\n";
    return 0; 
} 