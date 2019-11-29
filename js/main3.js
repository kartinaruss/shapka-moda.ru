function number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands
	//
	// +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +	 bugfix by: Michael White (http://crestidg.com)

	var i, j, kw, kd, km;

	// input sanitation & defaults
	if( isNaN(decimals = Math.abs(decimals)) ){
		decimals = 2;
	}
	if( dec_point == undefined ){
		dec_point = ",";
	}
	if( thousands_sep == undefined ){
		thousands_sep = ".";
	}

	i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

	if( (j = i.length) > 3 ){
		j = j % 3;
	} else{
		j = 0;
	}

	km = (j ? i.substr(0, j) + thousands_sep : "");
	kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
	//kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
	kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


	return km + kw + kd;
}


function addReview(){
	
	$( "form.product-review" ).submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			url: '/addreview/add',
			data: $(this).serialize(),
			dataType:'html',
			type:'POST',
			success: function(data){
				$('.notice-success').remove();
				$('.notice-warning').remove();
				$('.product-reviews-form').append(data);
			}
		});
		
	});
	
}






var cur_price;
var old_price;
var size_name;
var mprice;
var msize;


$(document).ready(function(){
	
	addReview();
	
	$( ".list-grid" ).click(function() {	
		$('.product-items').removeClass('product-list');	
		$(this).addClass('active');
		$(this).siblings('a').removeClass('active');
		$.cookie('gridlist', null);

	});
	
	$( ".list-list" ).click(function() {	
		$('.product-items').addClass('product-list');	
		$(this).addClass('active');
		$(this).siblings('a').removeClass('active');
		$.cookie('gridlist', 'list');

	});

	

	 var $siz = $("option:selected", $('#size'));

	 if($siz.length){
	 	$('#cur_price').html(number_format($siz.attr('rel'), 0, '.', ' '));
		$('#old_price').html(number_format($siz.attr('rel2'), 0, '.', ' '));
		$('#size_name').html(' ('+$siz.html()+')');
	 }

	$("a.fancybox-order").fancybox({
		onComplete: function(el){

			console.log($(el).data('custom-size'));

			$('.phone_number').mask('+7 (999) 999-9999');

			if($(el).data('custom-size')){
				var $form = $('.custom-size');

				$('#cur_price',$form).html(cur_price);
				$('#old_price',$form).html(old_price);
				$('#size_name',$form).html(size_name);

				$('.mprice',$form).val(mprice);
				$('.msize',$form).val(msize);
			}
		}
	});


    $('#size').change(function(){

    	var optionSelected = $("option:selected", this);

        var $size = $(optionSelected);

		cur_price = number_format($size.attr('rel'), 0, '.', ' ');
		old_price = number_format($size.attr('rel2'), 0, '.', ' ');

		size_name = ' ('+$size.html()+')';

		mprice = $size.attr('rel');
		msize = $size.html();



    });



	$('.aborder').live('click',function(){
		var $form = $(this).parent().parent();
			$.ajax({
			url:$form.attr('action'),
			data:$form.serialize(),
			dataType:'html',
			type:'POST',
			beforeSend: function(xhr, opts){
				var tel = $form.find('.phone_number');
				if(tel.val().replace(/[^0-9]/gim, '').length !=11){
						tel.css('border', '1px solid #F00');
                		tel.css('color', '#F00');
						tel.val('Пожалуйста, введите телефон корректно...');
		                tel.mouseenter(function() {
		                	tel.css('border','1px solid #ddd');
		                    tel.css('color', '#222');
		                    tel.val('');
		                    tel.unbind( "mouseenter" );
		                });

						xhr.abort();
				}
			},
			success: function(data){
				$form.hide().parent().append(data);
			}
		});
	});

    $('.menu-button').click( function (e) {

        $('#r-menu-title, #r-menu').toggle();

    });

    $('.responsive-menu-button .button').click(function(){
        $('.responsive-menu-2').stop().slideToggle();
        return false;
    });

    $('.responsive-menu-2 span').click(function(e){
        var el = $(this);
        var text = el.html();
        el.html(text=='+'?'-':'+');
        el.next().stop().slideToggle();
    });

});





// Форма отзыва
$(".button.write").click(function(){
	hideFlash();
	block.load('testimonial',{},function(){
		initOrderForm(block);
		bg.fadeIn(300);
		popup.css({'top':(getBodyScrollTop()+95)+'px'});
		popup.show();
		$(".CloseButton",popup).add(bg).unbind().click(function(){
			bg.fadeOut(300);
			popup.hide();
			showFlash();
		});
	});
});

function add_basket_Soloway(category_id,offer_id) {
    (function (h)
    {function k() {
        var a = function (d,b) {
            if (this instanceof AdriverCounter) d = a.items.length || 1,
                a.items[d] = this, b.ph = d,
            b.custom && (b.custom = a.toQueryString(b.custom,";")),
                a.request(a.toQueryString(b));
            else return a.items[d]};
        a.httplize = function (a) {return (/^\/\//.test(a)?location.protocol:"")+a};
        a.loadScript = function (a) {
            try {
                var b = g.getElementsByTagName("head")[0],
                    c = g.createElement("script");
                c.setAttribute("type", "text/javascript");
                c.setAttribute("charset", "windows-1251");
                c.setAttribute("src",a.split("![rnd]").join(Math.round(1E6*Math.random())));
                c.onreadystatechange = function () {
                    /loaded|complete/.test(this.readyState)&&(c.onload=null,b.removeChild(c))};
                c.onload = function () {b.removeChild(c)};
                b.insertBefore(c,b.firstChild)} catch (f) {}};
        a.toQueryString = function (a,b,c) {
            b = b || "&";c = c || "=";var f = [],e;
            for (e in a) a.hasOwnProperty(e) && f.push(e+c+escape(a[e]));
            return f.join(b)};
        a.request = function (d) {var b = a.toQueryString(a.defaults);
            a.loadScript(a.redirectHost+"/cgi-bin/erle.cgi?"+d+"&rnd=![rnd]"+(b?"&"+b:""))};
        a.items = [];
        a.defaults = { tail256: document.referrer || "unknown" };
        a.redirectHost = a.httplize("//ad.adriver.ru");return a}
        var g = document;
        "undefined" === typeof AdriverCounter && (AdriverCounter = k());
        new AdriverCounter(0, h)})
    ({
		"sid":216650,
		"sz":"add_basket",
		"bt":62,
		"custom": {
			"11":category_id,
			"10":offer_id
		}
    });
}

function delete_basket_Soloway(category_id,offer_id) {

    offer_id = offer_id.split(':')[0];

    (function (h)
    {function k() {
        var a = function (d,b) {
            if (this instanceof AdriverCounter) d = a.items.length || 1,
                a.items[d] = this, b.ph = d,
            b.custom && (b.custom = a.toQueryString(b.custom,";")),
                a.request(a.toQueryString(b));
            else return a.items[d]};
        a.httplize = function (a) {return (/^\/\//.test(a)?location.protocol:"")+a};
        a.loadScript = function (a) {
            try {
                var b = g.getElementsByTagName("head")[0],
                    c = g.createElement("script");
                c.setAttribute("type", "text/javascript");
                c.setAttribute("charset", "windows-1251");
                c.setAttribute("src",a.split("![rnd]").join(Math.round(1E6*Math.random())));
                c.onreadystatechange = function () {
                    /loaded|complete/.test(this.readyState)&&(c.onload=null,b.removeChild(c))};
                c.onload = function () {b.removeChild(c)};
                b.insertBefore(c,b.firstChild)} catch (f) {}};
        a.toQueryString = function (a,b,c) {
            b = b || "&";c = c || "=";var f = [],e;
            for (e in a) a.hasOwnProperty(e) && f.push(e+c+escape(a[e]));
            return f.join(b)};
        a.request = function (d) {var b = a.toQueryString(a.defaults);
            a.loadScript(a.redirectHost+"/cgi-bin/erle.cgi?"+d+"&rnd=![rnd]"+(b?"&"+b:""))};
        a.items = [];
        a.defaults = { tail256: document.referrer || "unknown" };
        a.redirectHost = a.httplize("//ad.adriver.ru");return a}
        var g = document;
        "undefined" === typeof AdriverCounter && (AdriverCounter = k());
        new AdriverCounter(0, h)})
    ({
		"sid":216650,
		"sz":"del_basket",
		"bt":62,
		"custom":
			{
			"11":category_id,
			"10":offer_id
		}
    });
}

function order_Soloway(order_sum,lead_id) {
    (function (h)
    {function k() {
        var a = function (d,b) {
            if (this instanceof AdriverCounter) d = a.items.length || 1,
                a.items[d] = this, b.ph = d,
            b.custom && (b.custom = a.toQueryString(b.custom,";")),
                a.request(a.toQueryString(b));
            else return a.items[d]};
        a.httplize = function (a) {return (/^\/\//.test(a)?location.protocol:"")+a};
        a.loadScript = function (a) {
            try {
                var b = g.getElementsByTagName("head")[0],
                    c = g.createElement("script");
                c.setAttribute("type", "text/javascript");
                c.setAttribute("charset", "windows-1251");
                c.setAttribute("src",a.split("![rnd]").join(Math.round(1E6*Math.random())));
                c.onreadystatechange = function () {
                    /loaded|complete/.test(this.readyState)&&(c.onload=null,b.removeChild(c))};
                c.onload = function () {b.removeChild(c)};
                b.insertBefore(c,b.firstChild)} catch (f) {}};
        a.toQueryString = function (a,b,c) {
            b = b || "&";c = c || "=";var f = [],e;
            for (e in a) a.hasOwnProperty(e) && f.push(e+c+escape(a[e]));
            return f.join(b)};
        a.request = function (d) {var b = a.toQueryString(a.defaults);
            a.loadScript(a.redirectHost+"/cgi-bin/erle.cgi?"+d+"&rnd=![rnd]"+(b?"&"+b:""))};
        a.items = [];
        a.defaults = { tail256: document.referrer || "unknown" };
        a.redirectHost = a.httplize("//ad.adriver.ru");return a}
        var g = document;
        "undefined" === typeof AdriverCounter && (AdriverCounter = k());
        new AdriverCounter(0, h)})
    ({"sid":216650,"sz":"order","bt":62,"custom":{"151":order_sum,"150":lead_id}});
}
