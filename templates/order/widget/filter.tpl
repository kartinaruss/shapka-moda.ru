<!-- BEGIN widget.filter -->
<div class="filter w2 border2">
	<div style="width:279px; height:32px; margin: 0px; margin-bottom:30px;"><h2>Фильтр</h2></div>
    <a href="javascript:;" class="reset">сбросить все</a>
    <link rel="stylesheet" type="text/css" href="styles/jquery-ui.css"/>
    <script type="text/javascript" src="scripts/jquery-ui2.js"></script>
    <!-- BEGIN widget.criteria -->
    <h3>{widget.criteria.NAME}</h3>
    <div class="items opt">
        <!-- BEGIN widget.criteria.sub -->
        <div class="item"><input type="checkbox" name="filter_criteria_id[]" value="{widget.criteria.sub.ID}" id="cr{widget.criteria.sub.ID}"/><label for="cr{widget.criteria.sub.ID}">{widget.criteria.sub.NAME}</label></div>
        <!-- END widget.criteria.sub -->
    </div>
    <!-- END widget.criteria -->
    <h3>Цена</h3>
    <div class="items" style="margin-top:20px; margin-bottom:25px;">
        <div class="item" style="text-align:left;margin-left:0px;">от <input type="text" name="filter_price_from" size="6" id="price_from" rel="0" style="width:45px; font-size:14px;"/> - до <input type="text" name="filter_price_to" size="6" id="price_to" rel="4500" style="width:45px; font-size:14px;" value="4500"/> {CURRENCY}</div>
        <div class="item slider"></div>
    </div>
    <center><a href="filter" class="button red">Подобрать</a></center>
    <div class="notice">Найдено товаров: <span id="found_count">0</span>. <a href="filter">Показать</a></div>
</div>
<!-- END widget.filter -->