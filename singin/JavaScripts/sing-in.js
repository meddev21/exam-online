/*var type = document.getElementById("box").value;
var etudient = document.getElementById("etudient");
var prof = document.getElementById("prof");
if(type=="etudient"){
   etudient.setAttribute(disabled,"");
   }else{
       prof.setAttribute(disabled,"");
       
   }



/*


lkqsjdfmlkqjsdlfkjqmsdf


*/




var bf = document.getElementById("f");
var bs = document.getElementById("s");
var bt = document.getElementById("t");
var df = document.getElementById("first");
var ds1 = document.getElementById("second1");
var ds2 = document.getElementById("second2");
var dt = document.getElementById("third");
var rd1 = document.getElementById("rd1");
var rd2 = document.getElementById("rd2");
var next = document.getElementById("next");
var previous = document.getElementById("previous");
var atag = document.getElementsByClassName('crumbs');
var values = document.getElementsByTagName('input');
var  i=1,moduldatabase='';
var level=document.getElementsByClassName("level");
var btnn = document.getElementsByClassName("btn");
var modules = document.getElementById('modules');
var emailv = document.getElementsByClassName("tooltiptext");
var ml1 = ["تحليل1","جبر1","informatique","POO","structure machine","terminologie","programation","analyse2","algabre2","phisique","TIC"]; 
var ml2 = ["archi","algo","POO","logic","anglais2","anglais3","GL","thiory graph","APP WEB","reseaux","SE"]; 
var ml2 = ["archi","algo","POO","logic","anglais2","anglais3","GL","thiory graph","APP WEB","reseaux","SE"]; 
var ml3 = ["paradigme","SE2","GRAPH","compulation","anglais4","GL2","IHM","INFOGRAPH","APP MOBILE","REDACTION","BASE DONNE","SECURETY"]; 
var mm1 = ["m1","m1","m1","m1","m1"];
var mm2 = ["m2","m2","m2","m2","m2"]; 
atag[2].setAttribute("style","background:#d9534f;");
atag[2].classList.add('visit');
rd2.checked=true;
document.getElementById("crumbs").style.display="none";
next.onclick = function(){
    i++; 
    switchdiv(i);
    emailv[0].style.visibility="hidden";
    emailv[0].style.opacity="0";
}
previous. onclick = function(){
    i--;
    switchdiv(i);
}
function switchdiv(i){
    
        if(i==1){
        
        atag[i+1].classList.add('visit');
        atag[i].classList.remove('visit');
        atag[i-1].classList.remove('visit'); 
    df.setAttribute("style","display: block;");
    ds1.setAttribute("style","display: none;");
    ds2.setAttribute("style","display: none;");
    dt.setAttribute("style","display: none;");
    previous.disabled = true ; 
    next.disabled = false;
       atag[i+1].setAttribute("style","background:#d9534f;");
       atag[i].setAttribute("style","background:#337ab7;");
       atag[i-1].setAttribute("style","background:#337ab7;");

   }
   if(i==2){
       if(rd1.checked==true)
           { 
            rd2.checked=false;
            ds1.setAttribute("style","display:block;");   
            ds2.setAttribute("style","display:none;");   
           }
       if(rd2.checked==true)
        {    
         rd1.checked=false;
         ds1.setAttribute("style","display:none;");   
         ds2.setAttribute("style","display:block;");   
    
        }
        atag[i-1].classList.add('visit');
        atag[i-2].classList.remove('visit');
        atag[i].classList.remove('visit');
    atag[i-1].classList.add('.visit');  
    df.setAttribute("style","display: none;");
    dt.setAttribute("style","display: none;");
       previous.disabled = false ; 
       next.disabled = false; 
       atag[i-1].setAttribute("style","background:#d9534f;");
       atag[i-2].setAttribute("style","background:#337ab7;");
       atag[i].setAttribute("style","background:#337ab7;");
   }
   if(i==3){
        atag[i-3].classList.add('visit');
        atag[i-2].classList.remove('visit');
        atag[i-1].classList.remove('visit');
       
    df.setAttribute("style","display: none");
    ds1.setAttribute("style","display: none;");
    ds2.setAttribute("style","display: none;");
    dt.setAttribute("style","display: block;");
       previous.disabled = false ; 
       next.disabled = true; 
       atag[i-3].setAttribute("style","background:#d9534f;");
       atag[i-2].setAttribute("style","background:#337ab7;");
       atag[i-1].setAttribute("style","background:#337ab7;");
   } 
 
}
/*
function validateEmail(sEmail) {
  var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

  if(!sEmail.match(reEmail)) {
    emailv[0].style.visibility="visible";
    emailv[0].style.opacity="1";  
      return false;
      
  }
  return true;
}
values[2].onfocus = function(){
    emailv[0].style.visibility="hidden";
    emailv[0].style.opacity="0"; 
    
}
function tooldatev(){
    console.log("hover");
    emailv[1].style.visibility="visible";
    emailv[1].style.opacity="1";
    emailv[1].style.width="150px";
    emailv[1].style.bottom="100px";
}
function tooldateh(){
    emailv[1].style.visibility="hidden";
    emailv[1].style.opacity="0";  
}
*/


function levell(id,modul){
   moduldatabase = modul.split(',');
 var chek = document.getElementById(id);   
if(chek.checked==true){
modules.innerHTML=modules.innerHTML+generate(id);
 }else{
    document.getElementById("select"+id).remove();
 }
}
function generate(id) {
  var smoduls ='<select multiple id="select'+id+'"name="modul'+id+'[]" >',tt='';
  switch(id){
     case "L1":for(var ikk=0;ikk<moduldatabase.length;ikk++){
    smoduls=smoduls.concat('<option>'+moduldatabase[ikk]+'</option>');};break;
     case "L2":for(var ikk=0;ikk<moduldatabase.length;ikk++){
    smoduls=smoduls.concat('<option>'+moduldatabase[ikk]+'</option>');};break;
     case "L3":for(var ikk=0;ikk<moduldatabase.length;ikk++){
    smoduls=smoduls.concat('<option>'+moduldatabase[ikk]+'</option>');};break;
     case "M1":for(var ikk=0;ikk<moduldatabase.length;ikk++){
    smoduls=smoduls.concat('<option>'+moduldatabase[ikk]+'</option>');};break;
     case "M2":for(var ikk=0;ikk<moduldatabase.length;ikk++){
    smoduls=smoduls.concat('<option>'+moduldatabase[ikk]+'</option>');};break;     
                 
          } var smoduls =smoduls.concat('</select>&emsp;'); 
 return smoduls;
}
function closeit() {
document.getElementById("crumbs").style.display="none";   
}
function displayit() {
    document.getElementById("crumbs").style.display="block";
    
}
function signin(id){
var user = document.getElementById("username").value;    
var pass = document.getElementById("password").value;    
var tool = document.getElementById("singintool");   
var btns = document.getElementById(id);   
    if(user=='' || pass==''){
    btns.disabled = true;
    btns.style.cursor="default";
    var fieldrem =  document.getElementById("singintool");
    fieldrem.style.visibility="visible";
    fieldrem.style.opacity="1";    
    }
}
window.onmousemove = function(){    
var fieldrem =  document.getElementById("singintool");
var btns = document.getElementById("sub");   
    btns.disabled = false;
    fieldrem.style.visibility="hidden";
    fieldrem.style.opacity="0"; 
    next.disabled=false;
}
function et(){
for(var etc=10;etc<=14;etc++){
if(values[etc].checked==true)
    return false;
}
    return true;
}
function ep(){
for(var epc=16;epc<=20;epc++){
//var slectmod = .value;
if(values[epc].checked==true)
{    if(document.getElementById('selectl'+(epc-15)+'p').value!=''){
    return false; }}
}
    return true;
}
next.onmouseover = function(){
    if(i==1){
  if(values[2].value==''||values[3].value==''||values[4].value==''||values[5].value=='')
      {next.disabled=true;console.log("NO1");
    }
        else{console.log("YES1");}
        
} 
   if(i==2&&rd1.checked==true){
       if(values[8].value==''||values[9].value==''||et()){
           next.disabled=true;console.log("NO2");}
       else{console.log("YES2");}
   }
       
if(i==2&&rd2.checked==true){
        if(values[15].value==''||ep())
      { next.disabled=true;console.log("YES3");}
    else{console.log("YES3");}
    console.log(et());
    }

}
/*
btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}*/
