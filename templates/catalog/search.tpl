<!-- INCLUDE header.tpl -->
<div class="catalog w2 item border2">
    <div style="width:100%; height:32px; color:#ffffff; margin: 0px;"><h2>Найдено товаров: {SEARCH_TOTAL}</h2></div>
    <!-- BEGIN products -->
    <div class="product-items clearfix">
        <!-- BEGIN product -->
        <div class="product-item">
            <p class="discount icon">-52<span>%</span></p>
            <!-- BEGIN product.picture -->
            <div class="product-image {product.LABEL}">
                <a href="item/{product.KEY}"><img src="images/product/s/{product.picture.SRC}" alt="{product.NAME}" /></a>
            </div>
            <!-- END product.picture -->

            <div class="product-name">
                <a href="item/{product.KEY}">{product.NAME}</a>
                <span style="color: #888888; text-align: right; font-size: 14px; white-space: nowrap; 1font-weight: bold">(арт. {product.CODE})</span>
                <div style="font-style:italic; font-size: 14px">{product.BRIEF}</div>
            </div>
            <div class="product-price">
                <!-- BEGIN product.price_old -->
                <div class="old-price">{product.PRICE_OLD} {CURRENCY}</div>
                <!-- END product.price_old -->
                <!-- BEGIN product.price -->
                <div class="price">{product.PRICE} {CURRENCY}</div>
                <!-- END product.price -->
            </div>
            <div class="actions clearfix">
                <a href="item/{product.KEY}" class="button gray view">Подробнее</a>
                <div class="button pink red {BUTTON_ORDER_CLASS}" id="{product.ID}<!-- BEGIN product.param -->:0<!-- END product.param -->" >{BUTTON_ORDER_TEXT}</div>
                <!--onclick="yaCounter34834310.reachGoal('knopka_korzina'); return true;"-->
            </div>
        </div>
        <!-- END product -->
    </div>
    <!-- BEGIN paginator -->
        <div class="pageList">
            <!-- BEGIN paginator.first --><a href="catalog/search/{SEARCH_QUERY2}/page/{paginator.first.NUM}{URL_POSTFIX}">{paginator.first.NUM}</a><!-- END paginator.first -->
            <!-- BEGIN paginator.separator1 --><ins>...</ins><!-- END paginator.separator1 -->
            <!-- BEGIN paginator.middle1 --><a href="catalog/search/{SEARCH_QUERY2}/page/{paginator.middle1.NUM}{URL_POSTFIX}">{paginator.middle1.NUM}</a><!-- END paginator.middle1 -->
            <!-- BEGIN paginator.current --><i>{paginator.current.NUM}</i><!-- END paginator.current -->
            <!-- BEGIN paginator.middle2 --><a href="catalog/search/{SEARCH_QUERY2}/page/{paginator.middle2.NUM}{URL_POSTFIX}">{paginator.middle2.NUM}</a><!-- END paginator.middle2 -->
            <!-- BEGIN paginator.separator2 --><ins>...</ins><!-- END paginator.separator2 -->
            <!-- BEGIN paginator.last --><a href="catalog/search/{SEARCH_QUERY2}/page/{paginator.last.NUM}{URL_POSTFIX}">{paginator.last.NUM}</a><!-- END paginator.last -->
        </div>
        <!-- END paginator -->
    <!-- END products -->
</div>
<!-- INCLUDE footer.tpl -->