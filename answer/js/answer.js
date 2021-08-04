var timeLeft,time,hours,minute;


function hide(confirm){
//document.getElementById('content2').disabled=false;
document.getElementById(confirm).style.display="none";
}
function show(confirm){

document.getElementById(confirm).style.display="block";
}

function myFunction(hou,mi,note,recivebool){
    if(hou==0 && mi==0)
        {           
            $("#timer").html(""); 
            h=0;m=0;
            if(document.getElementById('divetd')!=null)
                {document.getElementById('divetd').innerHTML="<div class='noexam'><h1>حاليا لا يوجد امتحان لعرضه يرجى الرجوع الى  <a href='../../main-p-etudient/page/main-p-etudinet.php'>الصفحة الرئيسية</a> لمعاينة أوقات الامتحان .....و شكرًا</h1> </div>";
                }
              if(recivebool==true){
document.getElementById('divetd').innerHTML="<div class='noexam'><h1 style='width: 600px;' >  لقد تحصلت على "+note+" في هذا الامتحان الرجوع الى <a href='../../main-p-etudient/page/main-p-etudinet.php'>الصفحة الرئيسية</a> </h1> </div>";

}
           
            return;
        }
    hours=hou;minute=mi;
    time= new Date().toString();
    
}

function makeTimer(h,m) {

			var endTime = new Date(time);	
            endTime.setHours(endTime.getHours()+h);                     endTime.setMinutes(endTime.getMinutes()+m); 
			endTime = (Date.parse(endTime) / 1000);

			var now = new Date();
			now = (Date.parse(now) / 1000);

			timeLeft  = endTime - now;

			var days = Math.floor(timeLeft / 86400); 
			var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
			var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
			var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
  
			if (hours < "10") { hours = "0" + hours; }
			if (minutes < "10") { minutes = "0" + minutes; }
			if (seconds < "10") { seconds = "0" + seconds; }

			//$("#days").html(days + "<span>Days</span>");
			$("#hours").html(hours);
			$("#minutes").html(minutes);
			$("#seconds").html(seconds);		
	}



 var ti =	setInterval(function() { makeTimer(hours,minute); 
            if (timeLeft < 0) {
        clearInterval(ti);
        $("#timer").html("انتهى الوقت");
        document.getElementById('sendrep').click();
    }                       
                                   
                                   
                                   }, 1000); 

       


     
     