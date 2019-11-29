<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
    // Блок настроек
    initSettings();

    $(".tabs a").removeClass('active');
    $(".tabs a[href='admin/order']").addClass('active');
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
                        //block.find("form .oActButtons a.cancel").click();
                        // Уведомление о сохранении
                        notice('Настройки уведомлений успешно изменены');
                    } else {
                        block.find("form>div.oT2").html(data);
                        // редактор
                        initEditor($("form textarea.wiki",block),$("form",block));
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
            // редактор
            initEditor($("form textarea.wiki",block),$("form",block));
            ajaxloader.hide();
        });
    });
    // редактор
    initEditor($("form textarea.wiki",block),$("form",block));
}
</script>
<div class="helpDescr">В данном разделе вы можете настроить смс-уведомления при заказах на сайте.</div>
<div class="cats">
    <a href="admin/order">Заказы</a>
    <a href="admin/order/export">Экспорт</a>
    <span style="background:#ffffff;">SMS-уведомления</span>
</div>
<div class="catExt settings oEditor">
    <form action="admin/stuff/sms/settings" method="post">
        <div class="oT2 oEditItem"><!-- INCLUDE admin/stuff/sms/settings.tpl --></div>
    </form>
</div>
<!-- INCLUDE admin/footer.tpl -->