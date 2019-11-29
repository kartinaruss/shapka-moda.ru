<!-- INCLUDE header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
    initOrderForm($("#feedback"));
});
</script>
<div class="w2 border2 text">
    <!-- BEGIN page -->{page.CONTENT}<!-- END page -->
    <div id="feedback"><!-- INCLUDE feedback/index.tpl --></div>
</div>
<!-- INCLUDE footer.tpl -->