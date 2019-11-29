<div class="block posilka w">
    <h2>Где моя посылка?</h2>
    <form id="ems_tracker" name="ems_tracker" method="get">
        <div class="inputText" style="width:180px;float:left;margin:3px;"><i><b><input type="text" name="ems_track" id="ems_track" onchange="document.getElementById('zamena').href = 'http://gdeposylka.ru/'+document.ems_tracker.ems_track.value+'?tos=accept&apikey=180185.d69f95eac8&country=RU';" /></b></i></div> 
        <a class="button red" id=zamena rel="gdeposylka">Проверить</a>
    </form><br/>
    <p style="font-size:12px;padding:0">Введите номер почтового отправления чтобы отследить статус доставки Вашей посылки.</p>
<script type="text/javascript">
<!--
    gp_wdg_title    = "{SITE_NAME}";
    document.write('<sc'+'ript type="text/javascript" src="http://cdn.gdeposylka.ru/assets/js/widgets/packed.widget.v2.js"></sc'+'ript>');
//-->
</script>
</div>