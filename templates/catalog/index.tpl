<!-- INCLUDE header.tpl -->
<!-- BEGIN cat_output -->
<div class="catalog w3 border2">
    <!-- BEGIN cat_output.category -->
    <div class="page-title">
        <h2>{cat_output.category.DESCRIPTION}</h2>
    </div>

    <!-- END cat_output.category -->

    <!--
    <!-- BEGIN cat_output.if_subcats --><!-- BEGIN maincats -->
    <div class="items"  style="border-bottom: 1px solid #D3C5E0; padding-bottom: 20px; margin-bottom: 5px">
        <!-- BEGIN cat_output.subcat -->
        <div class="item2">
            <!-- BEGIN cat_output.subcat.picture --><div class="img"><a href="catalog/{cat_output.subcat.KEY}"><img src="images/product/category/{cat_output.subcat.picture.SRC}" alt=""/></a></div><!-- END cat_output.subcat.picture -->
            <h2><a href="catalog/{cat_output.subcat.KEY}">{cat_output.subcat.NAME}</a></h2>
        </div>
        <!-- END cat_output.subcat -->
    </div>
    <!-- END maincats --><!-- END cat_output.if_subcats -->
    -->

    <!-- BEGIN cat_output.products -->
    <div class="product-items clearfix">
        <!-- BEGIN cat_output.product -->
        <div class="product-item">
            <p class="discount icon">-52<span>%</span></p>
            <!-- BEGIN cat_output.product.picture -->
            <div class="product-image {cat_output.product.LABEL}">
                <a href="item/{cat_output.product.KEY}"><img src="images/product/s/{cat_output.product.picture.SRC}" alt="{cat_output.product.NAME}" /></a>
            </div>
            <!-- END cat_output.product.picture -->
            
            <!-- BEGIN cat_output.product.top -->
			<p class="best-seller icon"></p>
			<!-- END cat_output.product.top -->
			
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
    </div>
    
    [abtest_v1]    
    <div class="see_more_wrapper">
		<div class="see_more button pink clearfix" style="width: 25%;margin: 0 auto;min-width: 300px;">
				Смотреть еще
		</div>
		<div class="see_more2 button gray clearfix" style="display:none;cursor:default;width: 25%;margin: 0 auto;min-width: 300px;">
				Смотреть еще
		</div>
	</div>
	[/abtest_v1]
    
    <!-- BEGIN cat_output.paginator -->
    <div class="pageList">
        <!-- BEGIN paginator.first --><a href="catalog/{CATEGORY_KEY}/page/{paginator.first.NUM}{URL_POSTFIX}">{paginator.first.NUM}</a><!-- END paginator.first -->
        <!-- BEGIN paginator.separator1 --><ins>...</ins><!-- END paginator.separator1 -->
        <!-- BEGIN paginator.middle1 --><a href="catalog/{CATEGORY_KEY}/page/{paginator.middle1.NUM}{URL_POSTFIX}">{paginator.middle1.NUM}</a><!-- END paginator.middle1 -->
        <!-- BEGIN paginator.current --><i>{paginator.current.NUM}</i><!-- END paginator.current -->
        <!-- BEGIN paginator.middle2 --><a href="catalog/{CATEGORY_KEY}/page/{paginator.middle2.NUM}{URL_POSTFIX}">{paginator.middle2.NUM}</a><!-- END paginator.middle2 -->
        <!-- BEGIN paginator.separator2 --><ins>...</ins><!-- END paginator.separator2 -->
        <!-- BEGIN paginator.last --><a href="catalog/{CATEGORY_KEY}/page/{paginator.last.NUM}{URL_POSTFIX}">{paginator.last.NUM}</a><!-- END paginator.last -->
    </div>
    <!-- END paginator -->
    <!-- END products -->
    
     <!-- INCLUDE widget/visited_mobile.tpl -->
</div>
<!-- END cat_output -->
<!-- BEGIN seotext -->
<div class="catalog w border2"><div class="text">{seotext.SEOTEXT}</div></div>
<!-- END seotext -->
<!-- INCLUDE footer.tpl -->
