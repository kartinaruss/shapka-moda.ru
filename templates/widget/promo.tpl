<!-- BEGIN promo -->
<div class=" w4 bg_val">
<!-- BEGIN promo.timer -->
<script:no-cache language="javascript" type="text/javascript">
$(document).ready(function(){
 /*   setInterval(function(){
        var now = new Date();
        var endTS = {promo.TIMESTAMP}*1000;
        var totalRemains = (endTS-now.getTime());
        if (totalRemains>1){
            var RemainsSec=(parseInt(totalRemains/1000));
            var RemainsFullDays=(parseInt(RemainsSec/(24*60*60)));
            var secInLastDay=RemainsSec-RemainsFullDays*24*3600;
            var RemainsFullHours=(parseInt(secInLastDay/3600));
            if (RemainsFullHours<10){RemainsFullHours="0"+RemainsFullHours};
            var secInLastHour=secInLastDay-RemainsFullHours*3600;
            var RemainsMinutes=(parseInt(secInLastHour/60));
            if (RemainsMinutes<10){RemainsMinutes="0"+RemainsMinutes};
            var lastSec=secInLastHour-RemainsMinutes*60;
            if (lastSec<10){lastSec="0"+lastSec};
            $('.timer>.digits').html((RemainsFullDays ? "<span>"+RemainsFullDays+"дн.</span> " :"")+RemainsFullHours+":"+RemainsMinutes+":"+lastSec);
        }
        else {$(".timer").remove();}
    },1000);*/
        var now = new Date();
        var endTS = {promo.TIMESTAMP}*1000;
        var totalRemains = (endTS-now.getTime());
        if (totalRemains>1){
            var RemainsSec=(parseInt(totalRemains/1000));
            var RemainsFullDays=0;/*(parseInt(RemainsSec/(24*60*60)));*/
            var secInLastDay=RemainsSec-RemainsFullDays*24*3600;
            var RemainsFullHours=(parseInt(secInLastDay/3600));
            if (RemainsFullHours<10){RemainsFullHours="0"+RemainsFullHours};
            var secInLastHour=secInLastDay-RemainsFullHours*3600;
            var RemainsMinutes=(parseInt(secInLastHour/60));
            if (RemainsMinutes<10){RemainsMinutes="0"+RemainsMinutes};
            var lastSec=secInLastHour-RemainsMinutes*60;
            if (lastSec<10){lastSec="0"+lastSec};
            $('#day1__').html(RemainsFullDays);
            $('#hour1__').html(RemainsFullHours);
            $('#min1__').html(RemainsMinutes);
            $('#sec1__').html(lastSec);
        }

        setInterval(function(){
        var now = new Date();
        var endTS = {promo.TIMESTAMP}*1000;
        var totalRemains = (endTS-now.getTime());
        if (totalRemains>1){
            var RemainsSec=(parseInt(totalRemains/1000));
            var RemainsFullDays=0;/*(parseInt(RemainsSec/(24*60*60)));*/
            var secInLastDay=RemainsSec-RemainsFullDays*24*3600;
            var RemainsFullHours=(parseInt(secInLastDay/3600));
            if (RemainsFullHours<10){RemainsFullHours="0"+RemainsFullHours};
            var secInLastHour=secInLastDay-RemainsFullHours*3600;
            var RemainsMinutes=(parseInt(secInLastHour/60));
            if (RemainsMinutes<10){RemainsMinutes="0"+RemainsMinutes};
            var lastSec=secInLastHour-RemainsMinutes*60;
            if (lastSec<10){lastSec="0"+lastSec};
            $('#day1__').html(RemainsFullDays);
            $('#hour1__').html(RemainsFullHours);
            $('#min1__').html(RemainsMinutes);
            $('#sec1__').html(lastSec);
        }
        },1000);



});
</script>
<!-- END promo.timer -->
        <div style="margin-bottom: 0px; padding: 20px 0px 0px 10px;">{promo.BODY}</div>
            <table width="100%" border="0" class="timerClock_timer">
            <tr>
            <td width="*" align="right" style="padding-right: 10px">
			<div class="time2" style=" font-size: 14px; font-weight:bold; margin: 0px; padding: 0px; text-align: center"><span style="line-height:30px;font-size: 13px;text-shadow:1px 1px 2px black; margin-bottom: 5px;">До конца акции осталось:<br></span>
      			<div class="c-block c-block-2" style="visibility:hidden; width: 0px"><div class="bl-inner"><span id="day1__">00</span></div> <span class="etitle etitle-3">дней</span></div>
				<div class="left-time-postion hours" style="margin-left:88px;"><div class="left-time-postion-inner"><span id="hour1__">32</span></div> <span class="etitle etitle-3" style="font-size: 14px; font-weight:400;padding-top: 0px; text-shadow:1px 1px 2px black;">часов</span></div>
				<div class="left-time-postion minutes"><div class="left-time-postion-inner"><span id="min1__">59</span></div> <span class="etitle etitle-3" style="font-size: 14px;font-weight:400;padding-top: 0px; text-shadow:1px 1px 2px black;">минут</span></div>
				<div class="left-time-postion sicunds"><div class="left-time-postion-inner"><span id="sec1__">59</span></div> <span class="etitle etitle-3" style="font-size: 14px;font-weight:400;padding-top: 0px; text-shadow:1px 1px 2px black;">секунд</span></div>
			</div>
			</td>
			</tr>
			</table>
</div>
<!-- END promo -->