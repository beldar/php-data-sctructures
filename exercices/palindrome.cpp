/*
 * PHP implementation for problem: http://www.spoj.com/problems/PALIN/
 * Accepted! Time 1.79, Mem: 2.8M
 * 
A positive integer is called a palindrome if its representation in the decimal system is the same when read from left to right and from right to left. For a given positive integer K of not more than 1000000 digits, write the value of the smallest palindrome larger than K to output. Numbers are always displayed without leading zeros.

Input

The first line contains integer t, the number of test cases. Integers K are given in the next t lines.

Output

For each K, output the smallest palindrome larger than K.

Example

Input:
2
808
2133
Output:
818
2222
 * 
 * Difficult test cases:
 * 7957 -> 7997
 * 9789 -> 9889
 * 1 -> 2
 * 999 -> 1001
 * 4599954 -> 4600064
 * 45874 -> 45954
 * 100100 -> 101101
 * 94187978322 -> 94188088149
 * 20899802 -> 20900902
 * 
 * ***
 * 
input : 
10 
3 
9 
53936 
53236 
67775 
99 
999 
6339 
875111 
6997 

output: 
4 
11 
54045 
53335 
67776 
101 
1001 
6446 
875578 
7007 
 * @author Martí Planellas <beldar.cat at gmail >
 * 
 */

#include <iostream> 
#include <string>
#include <cstdlib>
#include <cstdio>

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
string getmirror(string str, int h, bool isodd, bool ls){
    int n = str.length();
    if(ls){
        int piv = 0;
        int h1 = h-1;
        if(isodd)
            piv=str[h];
        else
            piv=str[h1];

        piv++;
        if(!isodd)
            str[h1] = piv;
        else
            str[h] = piv;
        for(int i=n-1;i>=h;i--)
            str[i] = str[n-i-1];
        return str;
        
    }else{
        if(isodd)
            str[h+1] = str[h];
        for(int i=n-1;i>=h;i--)
            str[i] = str[n-i-1];
        return str;
    }
}

char *itoa(int value,char *buf) {
    sprintf(buf, "%d", value);
    return buf;
}

string nextpal(string str){
    if(str.length()>1000000) return "";
    int n = str.length();
    if(n==1 && str.compare("9")!=0){
        int a;
        a=str[0];
        a++;
        str[0]=a;
        return str;
    }else{
        if(checknine(str)){
            str[0] = '1';
            for(int i=1;i<n;i++)
                str[i]='0';
            str.append("1");
            return str;
        }else{
            int h = n/2;
            bool isodd = (n%2==1);
            int i = h-1;
            int j = isodd ? h+1 : h;
            if(str[i]!=str[j] && str[i]!='9' && str[i]!='9'){
                if(str[i]>str[j])
                    return getmirror(str,h,isodd,false);
                else
                    if(str[i]<str[j] && str[i]!='9' && str[i]!='9')
                        return getmirror(str,h,isodd,true);
                
            }else{
                bool ls = false;
                while(i>0 && str[i]==str[j])
                    i--,j++;
                if(i==0 || str[i]<str[j])
                    ls = true;
                if(i==0 && str[i]>str[j]){
                    int a = str[j];
                    str[j] = ++a;
                    return str;
                }
                if(ls){
                    int carry = 1;
                    int a=0;
                    i = h-1;
                    char b;
                    if(isodd){
                        b = str[h];
                        a = atoi(&b);
                        a += carry;
                        carry = a/10;
                        itoa(a%10,&b);
                        str[h] = b;
                        j = h+1;
                    }else
                        j = h;
                    while(i>=0){
                        b = str[i];
                        a = atoi(&b);
                        a += carry;
                        carry = a/10;
                        itoa(a%10,&b);
                        str[i] = b;
                        str[j++] = str[i--];
                    }
                    return str;
                }else
                    return getmirror(str,h,isodd,false);
            }
        }
            
    }
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