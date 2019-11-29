<!-- INCLUDE header.tpl -->
<div class="catalog w2 border2">
    <!-- BEGIN page --><div class="text">{page.CONTENT}</div><!-- END page -->
    <div class="items fix">
        <!-- BEGIN product -->
        <div class="item">
            <h3><a href="item/{product.KEY}">{product.NAME}</a></h3>
            <!-- BEGIN product.picture -->
            <div class="img {product.LABEL}">
                <a href="item/{product.KEY}"><img src="images/product/s/{product.picture.SRC}" alt="{product.NAME}"/></a>
            </div>
            <!-- END product.picture -->
            <!--<div class="brief text"><p>{product.BRIEF}</p></div>-->
            <!-- BEGIN product.param -->
            <div class="param"><span>{product.param.NAME}</span>
                <select>
                    <!-- BEGIN product.param.val --><option value="{product.ID}:{product.param.val.NUM}" rel="{product.param.val.PRICE}" rel2="{product.param.val.PRICE_OLD}" rel2="{product.param.val.PRICE_OLD}">{product.param.val.NAME}</option><!-- END product.param.val -->
                </select>
            </div>
            <!-- END product.param2 -->
            <!-- BEGIN product.param -->
            <div class="param">
            </div>
            <!-- END product.param2 -->
            <!-- BEGIN product.price_old --><div class="oldprice text">Старая цена: <span>{product.PRICE_OLD}</span> {CURRENCY} </div><!-- END product.price_old -->
            <!-- BEGIN product.price --><div class="price">Цена: <span>{product.PRICE}</span> {CURRENCY}</div><!-- END product.price -->
            <div class="actions">
                <div class="button red {BUTTON_ORDER_CLASS}" id="{product.ID}<!-- BEGIN product.param -->:0<!-- END product.param -->">{BUTTON_ORDER_TEXT}</div>
                <a href="item/{product.KEY}" class="button gray view">Подробнее</a>
            </div>
        </div>
        <!-- END product -->
    </div>
</div>
<!-- INCLUDE footer.tpl -->