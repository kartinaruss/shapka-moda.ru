<!-- INCLUDE admin/header.tpl -->
<div class="cats">
    <a href="admin/testimonial">Отзывы</a>
    <span style="background:#ffffff;">Комментарии ВКонтакте</span>
</div>
<div class="catExt feedback oEditor" style="padding:50px 30px;">
    <!-- BEGIN vk_app -->
    <script:no-cache type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
    <div id="vk_comments"></div>
	<script type="text/javascript">
	window.onload = function () {
	 VK.init({apiId: {vk_app.ID}, onlyWidgets: true});
	 VK.Widgets.CommentsBrowse('vk_comments', {width: 600, limit: 25, mini: 0});
	}
	</script>
    <!-- END vk_app -->
</div>
<!-- INCLUDE admin/footer.tpl -->