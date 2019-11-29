<!-- INCLUDE header.tpl -->
<div class="catalog w2 border2">

	<div style="width:104%; height:38px; background-color:#eeedee; margin: -4px 0px 0px -14px; padding-top: 4px"><h2>Найдено товаров: {TOTAL}<img src="./images/iconfoot.png" style="float:right; display:inline-block; margin:1px 10px 0 0;" /></h2></div>
    <div class="items fix">

        <!-- BEGIN product -->
        <div class="item">
            <h3><a href="item/{product.KEY}">{product.NAME}</a></h3>
            <!-- BEGIN product.picture --><div class="img {product.LABEL}"><a href="item/{product.KEY}"><img src="images/product/s/{product.picture.SRC}" alt="{product.NAME}"/></a></div><!-- END product.picture -->
            <div class="brief text"><p>{product.BRIEF}</p></div>
            <!-- BEGIN product.param -->
            <div class="param"><span>{product.param.NAME}</span>
                <select>
                    <!-- BEGIN product.param.val --><option value="{product.ID}:{product.param.val.NUM}" rel="{product.param.val.PRICE}" rel2="{product.param.val.PRICE_OLD}">{product.param.val.NAME}</option><!-- END product.param.val -->
                </select>
            </div>
            <!-- END product.param -->
            <!-- BEGIN product.price_old --><div class="oldprice">Старая цена: <span>{product.PRICE_OLD}</span> {CURRENCY}</div><!-- END product.price_old -->
            <!-- BEGIN product.price --><div class="price">Цена: <span>{product.PRICE}</span> {CURRENCY}</div><!-- END product.price -->
            <div class="actions">
                <a href="item/{product.KEY}" class="button gray view">Подробнее</a>
                <div class="button red {BUTTON_ORDER_CLASS}" id="{product.ID}<!-- BEGIN product.param -->:0<!-- END product.param -->">{BUTTON_ORDER_TEXT}</div>
            </div>
        </div>
        <!-- END product -->
        <!-- BEGIN paginator -->
        <div class="oPager">
            <!-- BEGIN paginator.first --><a href="filter/page/{paginator.first.NUM}{URL_POSTFIX}">{paginator.first.NUM}</a><!-- END paginator.first -->
            <!-- BEGIN paginator.separator1 --><ins>...</ins><!-- END paginator.separator1 -->
            <!-- BEGIN paginator.middle1 --><a href="filter/page/{paginator.middle1.NUM}{URL_POSTFIX}">{paginator.middle1.NUM}</a><!-- END paginator.middle1 -->
            <!-- BEGIN paginator.current --><i>{paginator.current.NUM}</i><!-- END paginator.current -->
            <!-- BEGIN paginator.middle2 --><a href="filter/page/{paginator.middle2.NUM}{URL_POSTFIX}">{paginator.middle2.NUM}</a><!-- END paginator.middle2 -->
            <!-- BEGIN paginator.separator2 --><ins>...</ins><!-- END paginator.separator2 -->
            <!-- BEGIN paginator.last --><a href="filter/page/{paginator.last.NUM}{URL_POSTFIX}">{paginator.last.NUM}</a><!-- END paginator.last -->
        </div>
        <!-- END paginator -->
    </div>
</div>
<!-- INCLUDE footer.tpl -->