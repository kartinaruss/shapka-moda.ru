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
                        //block.find("form .oActButtons a.cancel").click();
                        // Уведомление о сохранении
                        notice('Файлы обновлены');
                    } else {
                        block.find("form>div.oT2").html(data);
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
    // редактор
    initEditor($("form textarea.wiki",block),$("form",block));
}
</script>
<div class="helpDescr">В данном разделе вы можете редактировать robots.txt и загружать sitemap.xml</div>
<div class="cats">
    <a href="admin/stuff">Параметры сайта</a>
    <a href="admin/stuff/options">Опции</a>
    <a href="admin/stuff/stat">Статистика</a>
    <span style="background:#ffffff;">SEO</span>
</div>
<div class="catExt settings oEditor">
    <form action="admin/stuff/seo/settings" method="post" enctype="multipart/form-data">
        <div class="oT2 oEditItem"><!-- INCLUDE admin/stuff/seo/settings.tpl --></div>
    </form>
</div>
<!-- INCLUDE admin/footer.tpl -->