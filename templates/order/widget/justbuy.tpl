<!-- BEGIN widget.justbuy -->
<div class="block justbuy w2 border2">
     <div style="width:279px;  height:32px; margin: 0px; margin-bottom:30px;"><h2>{widget.justbuy.NAME}</h2></div>
    <!-- BEGIN widget.justbuy.item -->
    <div class="item">
        <!-- BEGIN widget.justbuy.item.picture --><div class="L"><a href="item/{widget.justbuy.item.KEY}"><img src="images/product/s/{widget.justbuy.item.picture.SRC}" alt=""/></a></div><!-- END widget.justbuy.item.picture -->
        <div class="R">
            <div class="name" style="font-size: 15px"><a href="item/{widget.justbuy.item.KEY}" style="text-decoration: none; font-weight: bold">{widget.justbuy.item.NAME}</a></div>
            <div class="text">{widget.justbuy.item.BRIEF}</div>
            <div class="text" style="font-weight: bold; font-size: 16px; color: #FF3C00;">{widget.justbuy.item.PRICE}&nbsp;{CURRENCY}</div>
            <div class="text" style="font-size: 14px; font-style: italic; padding-top: 3px;">{widget.justbuy.item.TIME}</div>
        </div>
    </div>
    <!-- END widget.justbuy.item -->
</div>
<!-- END widget.justbuy -->