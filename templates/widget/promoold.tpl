<!-- BEGIN promo -->
<div class="block w4 bg_val">
<!-- BEGIN promo.timer -->
<script:no-cache language="javascript" type="text/javascript">
$(document).ready(function(){
    setInterval(function(){
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
    },1000);
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
            $('.day1__').html(RemainsFullDays);
            $('.hour1__').html(RemainsFullHours);
            $('.min1__').html(RemainsMinutes);
            $('.sec1__').html(lastSec);
        }



});
</script>
<!-- END promo.timer -->
        <div style="margin-bottom: 0px; padding: 20px 0px 10px 10px;">{promo.BODY}</div>
            <table width="100%" border="0">
            <tr>
            <td width="*" align="right" style="padding-right: 10px">
			<div class="time2" style=" font-size: 13px; font-weight:bold; margin: 0px; padding: 0px">&nbsp;&nbsp;&nbsp;&nbsp;До конца акции осталось:<br>
      			<div class="c-block c-block-2" style="visibility:hidden; width: 0px"><div class="bl-inner"><span class="day1__">0</span></div> <span class="etitle etitle-3">дней</span></div> 
				<div class="c-block c-block-2"><div class="bl-inner"><span class="hour1__">0</span></div> <span class="etitle etitle-3" style="font-size: 11px; font-weight:400;padding-top: 0px; text-shadow:1px 1px 2px black;">часов</span></div> 
				<div class="c-block c-block-2"><div class="bl-inner"><span class="min1__">0</span></div> <span class="etitle etitle-3" style="font-size: 11px;font-weight:400;padding-top: 0px; text-shadow:1px 1px 2px black;">минут</span></div> 
				<div class="c-block c-block-2"><div class="bl-inner"><span class="sec1__">15</span></div> <span class="etitle etitle-3" style="font-size: 11px;font-weight:400;padding-top: 0px; text-shadow:1px 1px 2px black;">секунд</span></div>
			</div>
			</td>
			<td align="left">
			<div class="time3" style="border: 0px solid #000000; text-align: left; font-size: 13px; font-weight:bold;  margin: 0px; padding: 0px;">Подарков осталось:<br>
			<div class="c-block2 c-block-2" style="text-align: center; margin-left: 27px"><div class="bl-inner2"><span>{promo.Count}</span></div> <span class="etitle etitle-3" style="font-size: 11px;font-weight:400;padding-top: 0px; text-shadow:1px 1px 2px black;">штук</span></div>
			</div>
			</td>
			</tr>
			</table>
</div>
<!-- END promo -->