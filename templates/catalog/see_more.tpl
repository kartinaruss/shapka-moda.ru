
        <!-- BEGIN cat_output.product -->
        <div class="product-item">
            <p class="discount icon">-52<span>%</span></p>
            <!-- BEGIN cat_output.product.picture -->
            <div class="product-image {cat_output.product.LABEL}">
                <a href="item/{cat_output.product.KEY}"><img src="images/product/s/{cat_output.product.picture.SRC}" alt="{cat_output.product.NAME}" /></a>
            </div>
            <!-- END cat_output.product.picture -->
            <div class="product-name">
                <a href="item/{cat_output.product.KEY}">{cat_output.product.NAME}</a>
                <span style="color: #888888; text-align: right; font-size: 14px; white-space: nowrap; 1font-weight: bold">(арт. {cat_output.product.CODE})</span>
                <div style="font-style:italic; font-size: 14px">{cat_output.product.BRIEF}</div>
            </div>
            <div class="product-price">
                <!-- BEGIN cat_output.product.price_old -->
                <div class="old-price">{cat_output.product.PRICE_OLD} {CURRENCY}</div>
                <!-- END cat_output.product.price_old -->
                <!-- BEGIN cat_output.product.price -->
                <div class="price">{cat_output.product.PRICE} {CURRENCY}</div>
                <!-- END cat_output.product.price -->
            </div>
            <div class="actions clearfix">
                <a href="item/{cat_output.product.KEY}" class="button gray view">Подробнее</a>
                <div class="button pink red {BUTTON_ORDER_CLASS}" id="{cat_output.product.ID}<!-- BEGIN cat_output.product.param -->:0<!-- END cat_output.product.param -->" >{BUTTON_ORDER_TEXT}</div>
                <!--onclick="yaCounter34834310.reachGoal('knopka_korzina'); return true;"-->
            </div>
        </div>
        <!-- END cat_output.product -->

