<?php

define('TIMESTAMP', time());

global $ncufreshdb, $ncufreshfb;

return array(
    'name'      => '2013 大一生活知訊網',
    'basePath'  => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app',
    'preload'   => array('log', 'security'),
    'import'    => array(
        'application.models.*',
        'application.models.video.*',
        'application.models.game.*',
        'application.models.majorClubForm.*',
		'application.models.profile.*',
        'application.models.forum.*',
        'application.models.freshmanread.*',
        'application.models.site.*',
        'application.models.campusTour.*',
        'application.components.*',
		'application.extensions.*'
    ),
    'modules'   => array(
        /*'gii'=>array(
                'class'   =>'system.gii.GiiModule',
                'password'=>'pass'
                )*/
    ),

    'components'=> array(
        'user'          => array(
           // 'class'             => 'GeneralUser',
           'allowAutoLogin'    => true,
           'loginUrl'=>array('/site/index')
        ),
        'session'       => array(
            'autoStart'         => true,
            'sessionName'       => 'NcuFresh2013'
        ),
        'assetManager'    => array(
            'basePath'            => dirname(__FILE__)  . DIRECTORY_SEPARATOR . 'assets'
        ),
		'counter' => array(
            'class' => 'UserCounter',
        ),
        'urlManager'    => array(
            'urlFormat'         => 'path',
            'rules'             => array(
                ''                                          => array('site/index', 'urlSuffix' => ''),
                '<action:\w+>'                              => 'site/<action>',
                '<action:\w+>'                              => 'site/<action>',
                // '<controller:\w+>/<id:\d+>/<title:.+>'     => '<controller>/view',
                // '<controller:\w+>/<id:\d+>'                 => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'        => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<select:\w+>'    => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                 => '<controller>/<action>'
            ),
            'urlSuffix'         => '.html',
            'caseSensitive'     => true,
            'showScriptName'    => false,
            'useStrictParsing'  => true
        ),
        'db'            => array(
            'connectionString'  => 'mysql:host=' . $ncufreshdb['host'] . ';dbname=' . $ncufreshdb['database'],
            'emulatePrepare'    => true,
            'username'          => $ncufreshdb['username'],
            'password'          => $ncufreshdb['password'],
            'charset'           => 'utf8',
            'tablePrefix'       => '',
            'enableParamLogging'=> true,
            'enableProfiling'   => true
        ),
       'errorHandler'  => array(
           'errorAction'       => 'site/error'
       ),
        // 'security'      => array(
        //     'class'             => 'Security'
        // ),
        'log'           => array(
            'class'             => 'CLogRouter',
            'routes'            => array(
                array(
                    'class'     => 'CFileLogRoute',
                    'levels'    => 'trace, info, error, warning',
                )
            )
        ),
        'request'               => array(
            'enableCsrfValidation'=>true,
        ),
        'widgetFactory' => array(
            'widgets' => array(
                'CJuiDatePicker' => array(
                    'themeUrl' => 'css/themes',
                    'theme' => 'pepper-grinder',
                ),
            ),
        ),
        'clientScript' => array(
            'class' => 'MyClientScript',
        ),
    ),

    'params'            => array(
		'no_login_uid' => array('27183ba590ad4e82df6f35015572f181'),

		'admin' => array('andy199310@gmail.com','a2584310@gmail.com','ncufresh@gmail.com','qaws01395@yahoo.com.tw'),

		'check_web_base' => true,

		'web_base' => 'ncufresh.ncu.edu.tw',

		'game'	=> array(	'daily_money' => '5',
							'max_energy' => '4',
							'max_pu_pu' => '12',
							'golden_card_type' => '1',
							'lotto_card_min' => '15',
							'lotto_card_max' => '30',
							'robber_card_max' => '25',
							'stop_card_cid' => '5',
							'defend_card_cid' => '11',
							'using_tele_card_check' => 'uiregurehjgo',
							'get_question_pid' => '0',
							'gifter_id' => '27183ba590ad4e82df6f35015572f181',
							'achievement' => array('chance' => array(
																	'1' => array('4'),
																	'5' => array('2', '3'),
																	'10' => array('8', '9'),
																	'25' => array('5', '6', '12'),
																	'50' => array('7', '10', '11'),
																	'100' => array('1'),
																	'101' => array('1', '1', '2', '2', '3', '3', '4', '4', '5', '5', '6', '6','7', '7', '8', '8', '9', '9', '10', '10', '11', '11', '12', '12'),
																),
													'destiny' => array(
																	'1' => array('4'),
																	'5' => array('2', '3'),
																	'10' => array('8', '9'),
																	'25' => array('5', '6', '12'),
																	'50' => array('7', '10', '11'),
																	'100' => array('1'),
																	'101' => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'),
																),
													'question' => array(
																	'1' => array('4'),
																	'5' => array('2', '3'),
																	'10' => array('8', '9'),
																	'25' => array('5', '6', '12'),
																	'50' => array('7', '10', '11'),
																	'100' => array('1'),
																	'101' => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'),
																),
													'money' => array(
																	'250' => array('4'),
																	'500' => array('2', '3'),
																	'750' => array('8', '9'),
																	'1000' => array('5', '6', '12'),
																	'1500' => array('7', '10', '11'),
																	'3000' => array('1'),
																	'3001' => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'),
																),
													)
											),
    ),
);
