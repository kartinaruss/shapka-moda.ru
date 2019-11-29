
        <!-- BEGIN product -->
        <div class="product-item">
            <p class="discount icon">-52<span>%</span></p>
            <!-- BEGIN product.picture -->
            <div class="product-image {product.LABEL}">
                <a href="item/{product.KEY}"><img src="images/product/s/{product.picture.SRC}" alt="{product.NAME}" /></a>
            </div>
            <!-- END product.picture -->
            <div class="product-name"><a href="item/{product.KEY}">{product.NAME}</a>
            <span style="color: #888888; text-align: right; font-size: 14px; white-space: nowrap; ">(арт. {product.CODE})</span>
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

