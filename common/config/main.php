<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',//开启中文
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 开启路由
	    'urlManager' => [
	    	'enablePrettyUrl' => true,//美化url==ture
	    	'showScriptName' => false,//隐藏index.php
	    	//'suffix' => '.html',//后缀
	    ],
	    //语言包
	    'i18n' => [
	    	'translations' => [
	    		'*' => [
	    			'class' => 'yii\i18n\PhpMessageSource',
	    			//'basePast' => '/message',
	    			'fileMap' => 'common.php',
	    		],
	    	],
	    ],
    ],
];
