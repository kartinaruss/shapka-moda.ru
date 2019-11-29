<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
    $(".tabs a[href^='admin/theme']").addClass('active');
    
	$(".pictureBlock").each(function(i,item){
		var block = $(item);
	    // Форма загрузки файла
	    $("form .oFileLink.add",block).live('click',function(){
	        var form = $("form",block);
	        form.unbind().submit(function(){
	            ajaxloader.show();
	            $(this).ajaxSubmit({
	                success: function(data) {
	                    block.html(data);
	                    ajaxloader.hide();
	                }
	            });
	            return false;
	        }).find("input[type='file']").change(function(){
	            var oldAction = form.attr('action');
	            form.attr('action',$(this).attr('rel'))
	                .submit()
	                .attr('action',oldAction);
	        });
	    });
	    // Удалить
	    $("form .oFileLink.delete",block).live('click',function(){
	    	ajaxloader.show();
	        block.load($(this).attr('rel'),{},function(){ ajaxloader.hide(); });
        });
	});
});
</script>
<div class="helpDescr">В данном разделе вы можете загрузить фавикон.</div>
<div class="cats">
    <a href="admin/theme">Готовые темы</a>
    <a href="admin/theme/color">Цветовая гамма</a>
    <a href="admin/theme/background">Фоновая картинка</a>
    <a href="admin/theme/logo">Логотип</a>
    <span style="background:#ffffff;">Фавикон</span>
</div>
<div class="catExt settings oEditor">
    <div class="oT2 oEditItem">
    <table><tbody>
	    <tr><td colspan="2"><h3>&nbsp;</h3></td></tr>
        <tr>
            <td><span>Фавикон (<a href="favicon.ico?v={VERSION_FAVICON}" target="_blank">favicon.ico</a>):</span></td>
            <td class="pictureBlock"><form action="admin/theme/favicon/add" method="post" enctype="multipart/form-data">
			    <!-- BEGIN no_img -->
				<div class="addImage">
				    <span class="oFileLink add"><i>Прикрепить</i><input type="file" name="file" size="40" rel="admin/theme/favicon/add"/></span>
				</div>
				<!-- END no_img -->
				<!-- BEGIN img -->
				<div class="changeImage">
				    <img src="favicon.ico?v={VERSION_FAVICON}" alt="" title="" style="border:1px solid gray;padding:3px;"/>
				    <span class="oFileLink add"><i>Поменять</i><input type="file" name="file" size="40" rel="admin/theme/favicon/add"/></span>
				    <span class="oFileLink delete" rel="admin/theme/favicon/delete"><i>Удалить</i></span>
				</div>
				<!-- END img -->
            </form></td>
        </tr>
        <tr><td colspan="2"><div class="Example">Картинка должна быть квадратная, размером 16х16 или 32х32 пикселя, в формате *.ico<br/>Конвертировать в формат ICO можно <a href="http://www.icoconverter.com/" target="_blank">онлайн здесь</a></div></td></tr>
	</tbody></table>
    </div>
</div>
<!-- INCLUDE admin/footer.tpl -->