<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
    // Блок настроек
    initSettings();
});
// Изменение настроек
var initSettings = function(){
    var block = $(".settings");
    // Сохранение
    $("form .oActButtons a.save",block).live('click',function(){
        ajaxloader.show();
        $("form",block).submit(function(){
            $(this).ajaxSubmit({
                success: function(data) {
                    if (data=='ok') {
                        // Уведомление о сохранении
                        notice('Настройки блока успешно изменены');
                    } else {
                        block.find("form>div.oT2").html(data);
                        
                        $(".chosen",block).chosen({no_results_text: "Ничего не найдено по запросу"});
                    }
                    ajaxloader.hide();
                }
            });
            return false;
        }).submit();
        return false;
    });
    // Отмена
    $("form .oActButtons a.cancel",block).live('click',function(){
        ajaxloader.show();
        block.find("form>div.oT2").load(block.find("form").attr('action'),{},function(data){
            ajaxloader.hide();
        });
    });
    
    $(".chosen",block).chosen({no_results_text: "Ничего не найдено по запросу"});
}
</script>
<div class="helpDescr">В данном разделе вы можете редактировать такие блоки как гарантия, акция и скидка и другие.</div>
<div class="cats">
    <a href="admin/block/guarantee">Гарантия</a>
    <a href="admin/block/promo">Акция</a>
    <a href="admin/block/discount">Скидка</a>
    <span style="background:#ffffff;">Только что купили</span>
    <a href="admin/block/special" >Специальное предложение</a>
    <a href="admin/stuff/cert">Сертификаты</a>
</div>
<div class="catExt oEditor">
    <div class="settings"><form action="admin/block/justbuy/settings" method="post">
        <div class="oT2 oEditItem"><!-- INCLUDE admin/block/justbuy/settings.tpl --></div>
    </form></div>
</div>
<!-- INCLUDE admin/footer.tpl -->