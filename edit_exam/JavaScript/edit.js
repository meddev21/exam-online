var choose = document.getElementById("choose");
var chooseques = document.getElementById("chooseques");
var qeuscont = document.getElementById("qeuscont");
var addchose = document.getElementById("addchose");
var edittext = document.getElementById("choosequestion");
var editnote = document.getElementById("choosequestionn");
var dateex = document.getElementById("choosequestionn");
var timeex = document.getElementById("timeex");
var duraex = document.getElementById("time");
var boxchoose ,conter,namee; 
var edit = document.getElementById("edit");    
var deletee = document.getElementById("delete");
/*
function showcpannel(){
document.getElementById("cpannel").style.display="none";   
}
edit.onclick = function(){

    showcpannel();
}*/


document.getElementById("editquest").onclick = function(){
    document.getElementById("currentques").style.display="block";
    document.getElementById("texttype").style.display="none";
    document.getElementById('choose').value = 'none';
}
document.getElementById("addingquest").onclick = function(){
    document.getElementById("currentques").style.display="none";
    document.getElementById("texttype").style.display="block";
    $('#qeuscont').html("");
}
document.getElementById("addchoise").onclick = function (){
 document.getElementById("texttype").style.display="block";       
}
function closeit() {
document.getElementById("cpannel").style.display="none";   
}
choose.onchange = function(){
    var res2;// = choose.value.substr(2);
    var numb = choose.value.match(/\d/g);
    numb = numb.join("");
    res2=choose.value.replace(numb, "");
    console.log(res2);
    switch(res2)
      { case "none": $('#qeuscont').html("");break;
        case "one":boxchoose="radio";conter=0;
            $('#qeuscont').html('<br/>'+'<span class="input-group-addon" id="span'+boxchoose+conter+'">'
                         + '<input value="'+conter+'"  type="'+boxchoose+'" id="'+boxchoose+conter+'" name="onechoise"/>'
                         + '<input name="quesinfo[]" type="text"class="form-title" id="text'+boxchoose+conter+'">'
                         + '<button class="btn btn-success" type="button" id="remove'+boxchoose+conter+'"'
                         + 'onclick="removee(this.id)">'
                         + '<span class="glyphicon glyphicon-remove"></span>'
                         + '</button>'
                           /* + '<button class="btn btn-success" id="add'+choose+idchoose+conterType+'"'
                            + 'type="button" onclick="addQ(this.id)">'
                            + '<span class="glyphicon glyphicon-ok"></span>'
                            + '</button>'       */                 
                         + '</span>');
            break;
            
          case "multi":boxchoose="checkbox";conter=0;
            $('#qeuscont').html('<br/>'+'<span class="input-group-addon" id="span'+boxchoose+conter+'">'
                         + '<input value="'+conter+'"  type="'+boxchoose+'" id="'+boxchoose+conter+'" name="onechoise"/>'
                         + '<input name="quesinfo[]" type="text"class="form-title" id="text'+boxchoose+conter+'">'
                         + '<button class="btn btn-success" type="button" id="remove'+boxchoose+conter+'"'
                         + 'onclick="removee(this.id)">'
                         + '<span class="glyphicon glyphicon-remove"></span>'
                         + '</button>'
                           /* + '<button class="btn btn-success" id="add'+choose+idchoose+conterType+'"'
                            + 'type="button" onclick="addQ(this.id)">'
                            + '<span class="glyphicon glyphicon-ok"></span>'
                            + '</button>'       */                 
                         + '</span>');
              break;
            
        case "true_false":conter=0;
            $('#qeuscont').html('<br/>'+'<span class="input-group-addon" id="spanyas_no'+conter+'">'
                         + '<span style="color:#fff">'
                         + '<input type="radio" id="no" value="0" name="yes_no"/>'
                         + ' خاطئ </span>'+ '<br/>' 
                         + '<span style="color:#fff">'
                         + '<input type="radio" id="yes" value="1" name="yes_no"/>'
                         + ' صحيح </span>'+ '<br/>'                    
                         + '</span>');
                      break;
        
    }conter++;
 }
    
    
addchose.onclick = function () {
    "use strict";
        var namee="";
    if(boxchoose=="radio"){namee="onechoise";}else{namee="multi[]";}
        $('#qeuscont').append('<br id="br'+boxchoose+conter+'"/>'+'<span class="input-group-addon"'   
                         + 'id="span'+boxchoose+conter+'">'
                         + '<input value="'+conter+'" name="'+namee+'" type="'+boxchoose+'"id="'+boxchoose+conter+'" />'
                         + '<input name="quesinfo[]" type="text"class="form-title" id="text'+boxchoose+conter+'">'
                         + '<button class="btn btn-success" id="remove'+boxchoose+conter+'"'
                         + 'type="button" onclick="removee(this.id)">'
                         + '<span class="glyphicon glyphicon-remove"></span>'
                         + '</button>'
                         + '</span>');
  conter++;
}

function removee(id)
{ var nbrchild=(qeuscont.childElementCount)/2-1;     
  var ordernum= Number(id.substr(id.length-2, 1));
  var chosing = id.substring(6, id.length-2);
//  'span'+chosing+count+'0'   
//    chosing+count+'0' checkbox or radio
 // 'text'+chosing+count+'0'
 while(ordernum<nbrchild){
 document.getElementById('span'+chosing+(ordernum+1)+'0').id = 'span'+chosing+ordernum+'0';    
 document.getElementById(''+chosing+(ordernum+1)+'0').id = ''+chosing+ordernum+'0';    
 document.getElementById('text'+chosing+(ordernum+1)+'0').id = 'text'+chosing+ordernum+'0';     
      ordernum++;}
 
   var idspan = id.replace("remove","span");
    var idbr = id.replace("remove","br");
        $('#'+idspan).remove();
        $('#'+idbr).remove();
}
function showch(quesArray){
    //alert();
    var res = Number(chooseques.value.substr(0, 1));
    var checked="";
    conter=0;
    $('#qeuscont').html("");
    //console.log(quesArray[res][2]);
    switch(quesArray[res][2]){
      case 'seule_choix':boxchoose="radio";break;   
      case 'multi_choix':boxchoose="checkbox";break;   
    }
    var corpns=quesArray[res][5].split(",")
    var choix=quesArray[res][6].split(",")
    document.getElementById("choosequestion").value=quesArray[res][3];
    document.getElementById("choosequestionn").value=quesArray[res][4];
    if(quesArray[res][2]!="vrai_faux"){
    for(var conter1=0;conter1<choix.length;conter1++){
        for(var conter2=0;conter2<corpns.length;conter2++){
            if(choix[conter1]==corpns[conter2])
                {checked="checked";break;}
            else
                {checked="";} }
            var namee="";
    if(boxchoose=="radio"){namee="onechoise";}else{namee="multi[]";}
        $('#qeuscont').append('<br id="br'+boxchoose+conter+'"/>'+'<span class="input-group-addon"'   
                         + 'id="span'+boxchoose+conter+'">'
                         + '<input value="'+conter+'" name="'+namee+'" type="'+boxchoose+'"id="'+boxchoose+conter+'" '+checked+' />'
                         + '<input name="quesinfo[]" value="'+choix[conter1]+'" type="text"class="form-title" id="text'+boxchoose+conter+'">'
                         + '<button class="btn btn-success" id="remove'+boxchoose+conter+'"'
                         + 'type="button" onclick="removee(this.id)">'
                         + '<span class="glyphicon glyphicon-remove"></span>'
                         + '</button>'
                         + '</span>');
    conter++;
    }}
    
    console.log(quesArray[chooseques.value][3]);
    conter--;
}
/*
function verifie(){
    if(choose.value != "true_false"){
    var check=0,forchek="",foriniput="";
while(document.getElementById("text"+boxchoose+conter)!=null){
  if(document.getElementById("text"+boxchoose+conter).value!=""){    
  if(document.getElementById(boxchoose+conter).checked==true){forchek="ok";}   
  foriniput="ok";
  }else{foriniput="";}  check++;
}    
   if(forchek=="ok" && foriniput=="ok"){return true;}
                  {return false; } } 
   if(TypeQue.value == "true_false"){
      if(document.getElementById("yes").checked==true||document.getElementById("no").checked==true)
          {console.log("returned true"); return true;}else{console.log("returned false"); return false;}
   }
    }
*/
window.onmouseover = function(){
    if($('#qeuscont').html()=="")
    {
    document.getElementById("addchose").style.display="none";
    document.getElementById("add").style.display="none";
    }else{
        
    document.getElementById("addchose").style.display="block";
    document.getElementById("add").style.display="block";
    }
   /* var child ;
 if(titleQus.value!='' && notQus.value!='' && verifie() && notQus.value>=1 && child)
    {
      addexam.disabled=false;
    }else{
        addexam.disabled=true;
    }*/ 
}

/*
function check(){
 refuse.disabled = false;accepte.disabled = false;
}
*/