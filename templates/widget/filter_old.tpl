<!-- BEGIN widget.filter -->
<div class="filter w">
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
    <div class="items">
        <div class="item" style="text-align:center;">от <input type="text" name="filter_price_from" size="6" id="price_from" rel="0"/> до <input type="text" name="filter_price_to" size="6" id="price_to" rel="50000"/> {CURRENCY}</div>
        <div class="item slider"></div>
    </div>
    <center><a href="filter" class="button red">Подобрать</a></center>
    <div class="notice">Найдено товаров: <span id="found_count">0</span>. <a href="filter">Показать</a></div>
</div>
<!-- END widget.filter -->