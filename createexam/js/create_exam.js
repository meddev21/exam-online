
var TypeQue = document.getElementById('Type-question'),
    addQue  = document.getElementById('add'),
    a1      = document.getElementById('a1');
var choose,  
    idchoose = 0,
    conterType = 0,
    conterQus = 1;
var conform = document.getElementById("conform");
var addexam = document.getElementById("net");
var btn = document.getElementById("buttonexam");
var leftside = document.getElementById("leftside");
TypeQue.onchange = function () {
    "use strict";
    if (TypeQue.value === "no") {
        $('#a1').html('');
        $('#add').css({'display': 'none'});
        
    }else if (TypeQue.value === "un") {
            
            choose = "radio";
            idchoose = 0;
            conterType = 0;
            
            $('#a1').html('<br/>'+'<span class="input-group-addon" id="span'+choose+idchoose+conterType+'">'
                         + '<input value="'+idchoose+'"  type="'+choose+'" id="'+choose+idchoose+conterType+'" name="onechoise"/>'
                         + '<input name="quesinfo[]" type="text"class="form-title" id="text'+choose+idchoose+conterType+'">'
                         + '<button class="btn btn-success" type="button" id="remove'+choose+idchoose+conterType+'"'
                         + 'onclick="removee(this.id)">'
                         + '<span class="glyphicon glyphicon-remove"></span>'
                         + '</button>'
                           /* + '<button class="btn btn-success" id="add'+choose+idchoose+conterType+'"'
                            + 'type="button" onclick="addQ(this.id)">'
                            + '<span class="glyphicon glyphicon-ok"></span>'
                            + '</button>'       */                 
                         + '</span>');

        
            $('#add').css({'display': 'block'});
    
        
    } else if (TypeQue.value === "deux") {

        choose="checkbox";
        idchoose=0;
        
            $('#a1').html('<br/>'+'<span class="input-group-addon" id="span'+choose+idchoose+conterType+'">'
                         + '<input value="'+idchoose+'" type="'+choose+'"id="'+choose+idchoose+conterType+'" name="multi[]"/>'
                         + '<input name="quesinfo[]" type="text" class="form-title" id="text'+choose+idchoose+conterType+'">'
                         + '<button class="btn btn-success" type="button" id="remove'+choose+idchoose+conterType+'"'
                         + 'onclick="removee(this.id)">'
                         + '<span class="glyphicon glyphicon-remove"></span>'
                         + '</button>'
                           /* + '<button class="btn btn-success" id="add'+choose+idchoose+conterType+'"'
                            + 'type="button" onclick="addQ(this.id)">'
                            + '<span class="glyphicon glyphicon-ok"></span>'
                            + '</button>'  */                      
                          + '</span>');

        
        $('#add').css({'display': 'block'});        
        
    } else if (TypeQue.value === "yas_no"){

        idchoose=0;
            $('#a1').html('<br/>'+'<span class="input-group-addon" id="spanyas_no'+idchoose+conterType+'">'
                         + '<span style="color:#fff">'
                         + '<input type="radio" id="no" value="0" name="yes_no"/>'
                         + ' خاطئ </span>'+ '<br/>' 
                         + '<span style="color:#fff">'
                         + '<input type="radio" id="yes" value="1" name="yes_no"/>'
                         + ' صحيح </span>'+ '<br/>'
                        
                          /*  + '<button class="btn btn-success" id="add1'+choose+idchoose+conterType+'"'
                            + 'type="button" onclick="add1(this.id)">'
                            + '<span class="glyphicon glyphicon-ok"></span>'
                            + '</button>'  */                      
                         + '</span>');


        $('#add').css({'display': 'none'});
        
    }
    $('#net').css({'display': 'block'});
};

addQue.onclick = function () {
    "use strict";
        idchoose++;var namee="";
    if(choose=="radio"){namee="onechoise";}else{namee="multi[]";}
    
    
        $('#a1').append('<br id="br'+choose+idchoose+conterType+'"/>'+'<span class="input-group-addon"'   
                         + 'id="span'+choose+idchoose+conterType+'">'
                         + '<input value="'+idchoose+'" name="'+namee+'" type="'+choose+'"id="'+choose+idchoose+conterType+'" />'
                         + '<input name="quesinfo[]" type="text"class="form-title" id="text'+choose+idchoose+conterType+'">'
                         + '<button class="btn btn-success" id="remove'+choose+idchoose+conterType+'"'
                         + 'type="button" onclick="removee(this.id)">'
                         + '<span class="glyphicon glyphicon-remove"></span>'
                         + '</button>'
                         
                      /*  + '<button class="btn btn-success" id="add'+choose+idchoose+conterType+'"'
                        + 'type="button" onclick="addQ(this.id)">'
                        + '<span class="glyphicon glyphicon-ok"></span>'
                        + '</button>'     */                   
                        
                         + '</span>');
  
};    

function removee(id)
{ var nbrchild=(a1.childElementCount)/2-1;     
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

function subject(value, idee){
  document.getElementById(idee).innerHTML= value;
}

    var cont = 0;

function addQ(id)
{   
    var idButtonAdd = id;
    var idInput = id.replace("add","text");       
    var idText = document.getElementById(idInput).value;
    var idInputText = document.getElementById(idInput);

    if(idText === ""){
        alert('أدخل نص السؤال...');
    }else{
        $('#exam').before('<div style="width:95%;margin-right:20%; font-size:large" id="a2'+cont+'" onclick="textQus(this.id)">'
                          +'<input type="'+choose+'" id="'+choose+idchoose+conterType+'"/> '+' ' +idText+ '</div>');
        idInputText.disabled = true;
        
    document.getElementById(id).disabled = true;

        cont++;
        conform.disabled = false;
    }
}
addexam.disabled=true;
function add1(id){
    $('#exam').before('<span style="color:#000; width:20%; margin-right:20%; font-size:large">'
                         + '<input type="radio" id="yes" value="صحيح"/>'//radioyas_no'+idchoose++ +conterType+'
                         + ' صحيح </span>'+ '<br/>'
                         + '<span style="color:#000; width:20%; margin-right:20%; font-size:large">'
                         + '<input type="radio" id="no" value="خطا"/>'//radioyas_no'+idchoose++ +conterType+'
                         + ' خاطئ </span>'+ '<br/>'                        
                         + '</span>');
    
    
    conform.disabled = false;
    $('#a1').html('');
}



//...الدالة الخاصة التمرين
$(function(){
    
    $('#conform').click(function(){
        
        var titleQus = document.getElementById('titleQus').value,
            notQus   = document.getElementById('notQus').value;
//            tit = document.getElementById('titleQus'),
  //          not = document.getElementById('notQus');
        
        $('#a1').html('');
        $('#add').css({'display': 'none'});
        TypeQue.value = "no";
        
        $('#exam').before('<div id="Exe'+conterQus+'" onclick="textQus(this.id)">'
                          +'<h3 style="margin-right:15%;">'+titleQus+' : '+notQus+'(ن)</h3></div><br>');
        conterQus++;
    
     
    $('#titleQus').val('');
    $('#notQus').val('');    
        
    conform.disabled = true;
   // TypeQue.disabled = false;    
    });
    

    
    
    
});

function verifie(){
    if(TypeQue.value != "yas_no"){
    var check=0;var forchek="",foriniput="";
while(document.getElementById("text"+choose+check+"0")!=null){
  if(document.getElementById("text"+choose+check+"0").value!=""){    
  if(document.getElementById(choose+check+"0").checked==true){forchek="ok";}   
  foriniput="ok";
  }else{foriniput="";}  check++;
}    
   if(forchek=="ok" && foriniput=="ok"){return true;}
                  {return false; } } 
   if(TypeQue.value == "yas_no"){
      if(document.getElementById("yes").checked==true||document.getElementById("no").checked==true)
          {console.log("returned true"); return true;}else{console.log("returned false"); return false;}
   }
    } 
window.onmouseover = function(){
var child ;
    if(TypeQue.value != "yas_no")
        {child = (((a1.childElementCount)/2) > 1 ) ? true:false;}
    else{   child=true;}
 if($('#nameModel').val()===''||$('#data').val()===''||$('#timeex').val()===''||$('#time').val()===''){
    } else{ btn.disabled=false;
            
          }
    if(titleQus.value!='' && notQus.value!='' && verifie() && notQus.value>=1 && child)
    {
      addexam.disabled=false;
    }else{
        addexam.disabled=true;
    }    

      


}
  
    $('#net').click(function(){  var colorgreen="black",truecolor="",falsecolor="";      
    
        $('#add').css({'display':'none'});
        $('#net').css({'display': 'none'});
        $('#titleQus').css({'disabled': 'true'});
        $('#exam').before('<h2>'+titleQus.value+'         '+notQus.value+'(ن) </h2>');
   if(choose=="checkbox"||choose=="radio"){var check=0;
   while(document.getElementById("text"+choose+check+"0")!=null) 
 {   if(document.getElementById(choose+check+"0").checked==true){colorgreen="green"; }
     
     
     $('#exam').before('<div style="width:95%;margin-right:20%; font-size:large; color:'+colorgreen+';" d="a2" '+
                  '<h3>'+document.getElementById("text"+choose+check+"0").value+'</h3>'           
                    +'</div>');
 
 check++;
 
 
 
 
 colorgreen="black"; 
 }
   }   
        
      if(TypeQue.value == "yas_no"){
       if(document.getElementById("yes").checked==true){truecolor="green";falsecolor="red";}
          else{truecolor="red";falsecolor="green";}
        $('#exam').before('<div style="width:95%;margin-right:20%; font-size:large; color:'+truecolor+';" id="a2" '+
                     '<h3>'+document.getElementById("yes").value+'</h3>'
                    +'</div>');
          $('#exam').before('<div style="width:95%;margin-right:20%; font-size:large; color:'+falsecolor+';" id="a2" '+
                     '<h3>'+document.getElementById("no").value+'</h3>'
                    +'</div>');          
        }
                             
   // $('#a1').html('');TypeQue.value = "no";
    //titleQus.value='' ; notQus.value='';                               
    });

/*


if(titleQus.value!='' && notQus.value!='')
    {
      TypeQue.disabled = false;
      titleQus.disabled=true;  
      notQus.disabled=true;  
    }else{
        
        TypeQue.disabled = true;
    }





*/