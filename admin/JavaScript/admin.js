var refuse = document.getElementById("refuse");
var accepte = document.getElementById("accepte");
var chekall =document.getElementById("chekall");
refuse.disabled = true;accepte.disabled = true;
function check(){
 if(verifie()==true){
  refuse.disabled = false;accepte.disabled = false;
}else{
  refuse.disabled = true;accepte.disabled = true;
}  
if(vercheckall()==true){
 chekall.checked=true;
}else{
 chekall.checked=false;

}   
}
function vercheckall(){
 var i = 0;
while(document.getElementById("chek"+i)!=null){
var check = document.getElementById("chek"+i); 
if(check.checked == false){
    return false;
}
i++;
}  return true; 
}
function checkall()
{
var i = 0;var chked=true;
if(chekall.checked==true)
    {chked=true;  
     refuse.disabled = false;accepte.disabled = false;
    }else{chked=false;
         refuse.disabled = true;accepte.disabled = true;
         }
while(document.getElementById("chek"+i)!=null){
var check = document.getElementById("chek"+i); 
check.checked = chked;i++;
}
}
function verifie(){
var i = 0;
while(document.getElementById("chek"+i)!=null){
var check = document.getElementById("chek"+i); 
if(check.checked == true){
    return true;
  }i++;
}  
 return false;   
}/*  onclick="checkall()" */