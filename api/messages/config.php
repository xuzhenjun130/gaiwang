<?php
/**
 * 前台语言包配置文件
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
	'sourcePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'messagePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'messages',
	'languages'=>array('zh_tw','en'),
	'fileTypes'=>array('php'),
	'overwrite'=>true,
	'exclude'=>array(
		'.svn',
		'.gitignore',
		'yiilite.php',
		'yiit.php',
		'/i18n/data',
		'/messages',
		'/vendors',
		'/web/js',
	),
    'languageName'=>array(
        'zh_tw'=>'繁体',
        'en'=>'英文',
    ),
    //语言包目录下的各个文件说明
    'languageInfoMap'=>array(
        'site.php'=>'测试',
    ),
);
