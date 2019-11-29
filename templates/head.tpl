<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name='wmail-verification' content='9afc2a14c8c1406c' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{TITLE} {TITLE_POSTFIX}</title>
    <base href="{BASEURL}"/>
    <meta name="Keywords" content="{KEYWORDS}"/>
    <meta name="Description" content="{DESCRIPTION}"/>
    <meta name='yandex-verification' content='{YANDEX_VERIFICATION}' />
    <meta name="google-site-verification" content="{GOOGLE_VERIFICATION}" />
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <meta content="telephone=no" name="format-detection" />

	{CANONICAL}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,700italic,400italic&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./assets/css/normalize.min.css">
    <link rel="stylesheet" type="text/css" href="./styles/jquery.fancybox.css">
    <link rel="stylesheet" href="/assets/css/fonts.css"><!-- ruble -->
    <link rel="stylesheet" href="/assets/css/main.css?{TIMER}">

    <link rel="icon" type="image/png" href="./favicon.png">
    <link rel="alternate" type="application/rss+xml" title="Новости интернет-магазина" href="blog/rss" />

    <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
    <![endif]-->
    <script type="text/javascript" src="./scripts/jquery.js"></script>
    <script type="text/javascript" src="./assets/js/vendor/jquery.plugin.min.js"></script>
    <script type="text/javascript" src="./assets/js/vendor/jquery.countdown.min.js"></script>
    <script type="text/javascript" src="./assets/js/vendor/jquery.countdown-ru.js"></script>

    <script type="text/javascript" src="./scripts/jquery.form.js"></script>
    <script type="text/javascript" src="./scripts/jquery.easing.js"></script>
    <script type="text/javascript" src="./scripts/jquery.fancybox.js"></script>
    <script type="text/javascript" src="./scripts/jquery.cycle.js"></script>
    <script type="text/javascript" src="./scripts/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="./scripts/jquery.cookie.js"></script>
    <script type="text/javascript" src="./scripts/jquery.json.js"></script>
    <script type="text/javascript" src="./scripts/init2.js?3"></script>
    <script type="text/javascript" src="./js/main3.js"></script>

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1114504538666194'); // Insert your pixel ID here.
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1114504538666194&ev=PageView&noscript=1"/></noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->

    <!--
    <script type="text/javascript" src="./js/main.js"></script>
    <script type="text/javascript" src="./js/main2.js"></script>
    -->
    <script:no-cache type="text/javascript">
        $(function () {
            var newDate = new Date();
            newDate={TIMESTAMP}*1000;

            var austDay=new Date(newDate);

            $('#timer1').countdown({
                until: austDay,
                format: 'HMS',
                padZeroes: true
            });
        })

    </script>
	<script type="text/javascript">
	(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=hSVwpAi6t5izRPuTK9KNiJ5gvBm1vQFi9aY0Vx5G0JY5dN4sIRnXortq9yWNy4Ro14KvD4Xx00azEQEcHVtpbiK2FCIChQNy5EJU562XoNWduMG464y1xuQ*T4wOC42RlIgxTNDtzPXmocDmLsZRKTYHhQTLpTwtgEoFDLxk4cE-&pixel_id=1000067382';
	</script>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-152614874-1"></script>
	<script>
	 window.dataLayer = window.dataLayer || [];
	 function gtag(){dataLayer.push(arguments);}
	 gtag('js', new Date());

	 gtag('config', 'UA-152614874-1');
	</script>
	
    {GOOGLE_ANALYTICS}
</head>

<!-- BEGIN vk -->
<script:no-cache type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
<!-- BEGIN vk_app -->
<script:no-cache type="text/javascript">
  VK.init({apiId: {vk_app.ID}, onlyWidgets: true});
</script>
<!-- END vk_app -->
<!-- END vk -->
