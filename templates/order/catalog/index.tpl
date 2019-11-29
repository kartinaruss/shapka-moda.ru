<!-- INCLUDE header.tpl -->
<!-- BEGIN cat_output -->
<div class="catalog w3 border2">
	<!-- BEGIN cat_output.category -->
	<div style="width:100%; height:32px; color:#ffffff; margin: 0px;"><h2>{cat_output.category.NAME}{cat_output.category.NAMEC}</h2></div>

	<!-- END cat_output.category -->

    <!-- BEGIN cat_output.products -->
    <div class="items fix">
        <!-- BEGIN cat_output.product -->
        <div class="item">
            <h3><a href="item/{cat_output.product.KEY}">{cat_output.product.NAME}
            <br>
            </a></h3>
            <!-- BEGIN cat_output.product.picture --><div class="img {cat_output.product.LABEL}"><a href="item/{cat_output.product.KEY}"><img src="images/product/s/{cat_output.product.picture.SRC}" alt="{cat_output.product.NAME}"/></a></div><!-- END cat_output.product.picture -->
            <!--<div class="brief text"><p>{cat_output.product.BRIEF}</p></div>-->
            <!-- BEGIN cat_output.product.param -->
            <div class="param"><span>{cat_output.product.param.NAME}</span>
                <select>
                    <!-- BEGIN cat_output.product.param.val --><option value="{cat_output.product.ID}:{cat_output.product.param.val.NUM}" rel="{cat_output.product.param.val.PRICE}" rel2="{cat_output.product.param.val.PRICE_OLD}">{cat_output.product.param.val.NAME}</option><!-- END cat_output.product.param.val -->
                </select>
            </div>
            <!-- END cat_output.product.param -->
            <!-- BEGIN cat_output.product.price_old --><div class="oldprice">Старая цена: <span>{cat_output.product.PRICE_OLD}</span> {CURRENCY}</div><!-- END cat_output.product.price_old -->
            <!-- BEGIN cat_output.product.price --><div class="price">Цена: <span>{cat_output.product.PRICE}</span> {CURRENCY}</div><!-- END cat_output.product.price -->
            <div class="actions">
                <a href="item/{cat_output.product.KEY}" class="button gray view">Подробнее</a>
                <div class="button red {BUTTON_ORDER_CLASS}" id="{cat_output.product.ID}<!-- BEGIN cat_output.product.param -->:0<!-- END cat_output.product.param -->">{BUTTON_ORDER_TEXT}</div>
            </div>
        </div>
        <!-- END cat_output.product -->
	    <!-- BEGIN cat_output.paginator -->
	    <div class="oPager">
	        <!-- BEGIN paginator.first --><a href="catalog/{CATEGORY_KEY}/page/{paginator.first.NUM}{URL_POSTFIX}">{paginator.first.NUM}</a><!-- END paginator.first -->
	        <!-- BEGIN paginator.separator1 --><ins>...</ins><!-- END paginator.separator1 -->
	        <!-- BEGIN paginator.middle1 --><a href="catalog/{CATEGORY_KEY}/page/{paginator.middle1.NUM}{URL_POSTFIX}">{paginator.middle1.NUM}</a><!-- END paginator.middle1 -->
	        <!-- BEGIN paginator.current --><i>{paginator.current.NUM}</i><!-- END paginator.current -->
	        <!-- BEGIN paginator.middle2 --><a href="catalog/{CATEGORY_KEY}/page/{paginator.middle2.NUM}{URL_POSTFIX}">{paginator.middle2.NUM}</a><!-- END paginator.middle2 -->
	        <!-- BEGIN paginator.separator2 --><ins>...</ins><!-- END paginator.separator2 -->
	        <!-- BEGIN paginator.last --><a href="catalog/{CATEGORY_KEY}/page/{paginator.last.NUM}{URL_POSTFIX}">{paginator.last.NUM}</a><!-- END paginator.last -->
	    </div>
	    <!-- END paginator -->
    </div>
    <!-- END products -->
    <!-- BEGIN category --><!-- BEGIN category.seotext -->
    <div class="basement text">{category.SEOTEXT}</div>
    <!-- END category.seotext --><!-- END category -->
</div>
<!-- END cat_output -->
<!-- INCLUDE footer.tpl -->