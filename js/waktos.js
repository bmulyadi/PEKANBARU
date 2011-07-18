now=new Date();dy=now.getDay();dd=now.getDate();
	mm = now.getMonth();yy=now.getFullYear();mn="Jan";
	if(mm==1 )mn="Feb";if(mm==2)mn="Mar";if(mm==3)mn="Apr";
	if(mm==4 )mn="Mei";if(mm==5)mn="Jun";if(mm==6)mn="Jul";
	if(mm==7 )mn="Agst";if(mm==8)mn="Sep";if(mm==9)mn="Okt";
	if(mm==10)mn="Nov";if(mm==11)mn="Des";dn="Minggu";
	if(dy==1 )dn="Senin";if(dy==2)dn="Selasa";
	if(dy==3 )dn="Rabu";if(dy==4)dn="Kamis";
	if(dy==5 )dn="Jumat";if(dy==6)dn="Sabtu";
	document.write(dn+", "+dd+" "+mn+" "+yy);
	Stamp = new Date();
	var Hours;
	var Mins;
	var Time;
	Hours = Stamp.getHours();
	if (Hours >= 12) {
	Time = " PM";
	}
	else {
	Time = " AM";
	}
	
	if (Hours > 12) {
	Hours -= 12;
	}
	
	if (Hours == 0) {
	Hours = 12;
	}
	
	Mins = Stamp.getMinutes();
	
	if (Mins < 10) {
	Mins = "0" + Mins;
	}
	
	document.write(' ' + Hours + ":" + Mins + Time + '');