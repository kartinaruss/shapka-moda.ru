<!-- INCLUDE admin/header.tpl -->
<div class="cats">
    <a href="admin/product/main">Товары на главной</a>
    <a href="admin/product/category">Категории</a>
    <a href="admin/product/all">Все товары</a>
    <span style="background:#ffffff;">Экспорт</span>
    <a href="admin/product/import/csv">Импорт</a>
</div>
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
                        notice('Изменения сохранены');
                        setTimeout(function(){ location.reload(); },2000);
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
}
</script>
<div class="product oEditor catExt">
    <div class="list oEditor" style="padding:40px 10px;">
        <div class="oT2 oEditItem"><table>
            <tbody>
                <tr><td colspan="2"><h3>Экспорт товаров в CSV</h3></td></tr>
                <tr><td colspan="2">
		            <div class="oActButtons">
		                <a class="save" href="admin/product/export/csv">Скачать файл</a>
		            </div>
                </td></tr>
            </tbody>
        </table></div>
    </div>
</div>
<div class="settings oEditor">
    <form action="admin/product/export/yml" method="post">
        <div class="oT2 oEditItem"><!-- INCLUDE admin/product/export/yml.tpl --></div>
    </form>
</div>
<!-- INCLUDE admin/footer.tpl -->