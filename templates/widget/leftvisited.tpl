<!-- BEGIN leftVisited -->

<div class="widget" style="margin-top: 20px;">
    <div class="widget-title">
        <div class="h2s"><a style="font-size: 20px;">Вы смотрели</a></div>
    </div>

    <div class="product-items">
        <!-- BEGIN visited -->
        <div  class="visited-item product-item">
			<div class="product-name">
                <a href="item/{visited.KEY}">{visited.NAME}</a>                
            </div>
            <p class="discount icon" style="font-size: 16px;margin-top: 24px;">-52<span>%</span></p>
            <!-- BEGIN visited.picture -->
            <div class="product-image {visited.LABEL}" style="width:190px; height:190px">
                <a href="item/{visited.KEY}">
                    <img src="images/product/s/{visited.picture.SRC}" alt="{visited.NAME}" style="max-width:190px; max-height:190px; "/>
                </a>
            </div>
            <!-- END visited.picture -->
            <div class="product-price">
                <!-- BEGIN visited.price_old -->
                <div class="old-price">{visited.PRICE_OLD} {CURRENCY}</div>
                <!-- END visited.price_old -->
                <!-- BEGIN visited.price -->
                <div class="price">{visited.PRICE} {CURRENCY}</div>
                <!-- END visited.price -->
            </div>
            <div class="actions clearfix" >
                <a href="item/{visited.KEY}" class="button gray view" style="width:90px">Подробнее</a>
                <div data-price="{visited.PRICE}" class="button pink red {BUTTON_ORDER_CLASS}" style="width:90px;margin-left:10px" id="{visited.ID}<!-- BEGIN visited.param -->:{visited.param.POS}<!-- END visited.param -->" >{BUTTON_ORDER_TEXT}</div>
            </div>
        </div>
        <!-- END visited -->
    </div>
</div>
<!-- END leftVisited -->
