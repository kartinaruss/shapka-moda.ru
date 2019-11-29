<!-- BEGIN promo -->
<div class="block w4 bg_val">
<!-- BEGIN promo.timer -->
<script language="javascript" type="text/javascript">
    jQuery(document).ready(function () {
        setInterval(function () {
                    var now = new Date();
                    var endTS =
                    {promo.TIMESTAMP}*1000;
                    var minMinutes = {promo.MINMUNUTES};

                    var totalRemains = (endTS - now.getTime());
                    if (totalRemains > 1) {


                        var RemainsSec = (parseInt(totalRemains / 1000));
                        var RemainsFullDays = (parseInt(RemainsSec / (24 * 60 * 60)));
                        var secInLastDay = RemainsSec - RemainsFullDays * 24 * 3600;

                        //  console.log((RemainsSec/60));
                        var items = function (RemainsSec) {
                            var items = Math.ceil((RemainsSec / 60) / minMinutes);
                            return (items >= 10) ? items : '0' + items;
                        }


                        var RemainsFullHours = (parseInt(secInLastDay / 3600));
                        if (RemainsFullHours < 10){RemainsFullHours="0"+RemainsFullHours};
                        $('.scriptTimer .hours .left-time-postion-inner').html(RemainsFullHours);

                        var secInLastHour = secInLastDay - RemainsFullHours * 3600;
                        var RemainsMinutes = (parseInt(secInLastHour / 60));
                        if (RemainsMinutes < 10){RemainsMinutes="0"+RemainsMinutes};
                        $('.scriptTimer .minutes .left-time-postion-inner').html(RemainsMinutes);


                        var lastSec = secInLastHour - RemainsMinutes * 60;
                        if (lastSec < 10){lastSec="0"+lastSec};
                        $('.scriptTimer .sicunds .left-time-postion-inner').html(lastSec);


                        // $('.timer>.digits').html((RemainsFullDays ? "<span>" + RemainsFullDays + "дн.</span> " : "") + RemainsFullHours + ":" + RemainsMinutes + ":" + lastSec);
                        //$('.timer>.digits').html( RemainsFullHours + ":" + RemainsMinutes + ":" + lastSec);
                        $('.scriptPrezent .goods .left-time-postion-inner').html(items(RemainsSec));
                    }
                    else {
                        $(".timer").remove();
                    }
                },
                1000
        )
        ;
    });
</script>
<!-- END promo.timer -->
        <div style="margin-bottom: 0px; padding: 20px 0px 10px 10px;">{promo.BODY}</div>
            <div class="timerClock_timer scriptTimer ">


    <div class="title">ДО КОНЦА АКЦИИ ОСТАЛОСЬ:</div>
    <!-- BEGIN promo.timer -->


    <div class="left-time-postion hours">
        <div class="left-time-postion-inner">
            00
        </div>
        <div style="clear:both;"></div>
        <div class="left-time-postion-name">часов</div>
    </div>

    <div class="left-time-postion minutes">
        <div class="left-time-postion-inner">
            57
        </div>
        <div style="clear:both;"></div>
        <div class="left-time-postion-name">минут</div>

    </div>

    <div class="left-time-postion sicunds">
        <div class="left-time-postion-inner">
            30
        </div>
        <div style="clear:both;"></div>
        <div class="left-time-postion-name">секунд</div>
    </div>

</div>






<!-- END promo.timer -->



<div class="prezent scriptPrezent">
    <div class="title">ПОДАРКОВ ОСТАЛОСЬ:</div>

    <div class="prezent_count goods">
        <div class="left-time-postion-inner">
            57
        </div>
        <div style="clear:both;"></div>
        <div style="  margin-left: 15px;" class="left-time-postion-name">штук</div>

    </div>
</div>

</div>
<!-- END promo -->
