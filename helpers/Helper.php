<?php


/***********************************************************************************************************************
 *  ///////////////////////////╭━━━╮╱╱╱╱╱╱╱╱╭╮╱╱╱╱╱╱╱╱╱╱╱╱╱╭━━━╮╱╱╱╱╱╱╱╱╱╱╱╱╭╮////////////////////////////////////////
 *  ///////////////////////////┃╭━╮┃╱╱╱╱╱╱╱╭╯╰╮╱╱╱╱╱╱╱╱╱╱╱╱╰╮╭╮┃╱╱╱╱╱╱╱╱╱╱╱╱┃┃////////////////////////////////////////
 *  ///////////////////////////┃┃╱╰╯╭━━╮╭━╮╰╮╭╯╭━━╮╭━━╮╱╱╱╱╱┃┃┃┃╭━━╮╭╮╭╮╭━━╮┃┃╱╭━━╮╭━━╮╭━━╮╭━╮////////////////////////
 *  ///////////////////////////┃┃╭━╮┃╭╮┃┃╭╯╱┃┃╱┃┃━┫┃━━┫╭━━╮╱┃┃┃┃┃┃━┫┃╰╯┃┃┃━┫┃┃╱┃╭╮┃┃╭╮┃┃┃━┫┃╭╯////////////////////////
 *  ///////////////////////////┃╰┻━┃┃╭╮┃┃┃╱╱┃╰╮┃┃━┫┣━━┃╰━━╯╭╯╰╯┃┃┃━┫╰╮╭╯┃┃━┫┃╰╮┃╰╯┃┃╰╯┃┃┃━┫┃┃/////////////////////////
 *  ///////////////////////////╰━━━╯╰╯╰╯╰╯╱╱╰━╯╰━━╯╰━━╯╱╱╱╱╰━━━╯╰━━╯╱╰╯╱╰━━╯╰━╯╰━━╯┃╭━╯╰━━╯╰╯/////////////////////////
 *  ///////////////////////////╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱┃┃//  (C) 2022  ///////////////////
 *  ///////////////////////////╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╱╰╯/////////////////////////////////
 *----------------------------------------------------------------------------------------------------------------------
 *
 * @author     Gartes | sad.net79@gmail.com | Telegram : @gartes
 * @date       26.11.22 19:25
 * Created by PhpStorm.
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 **********************************************************************************************************************/

namespace Vmsdek;

use DOMDocument;
use Exception;
use GNZ11\Core\Js;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Uri\Uri;
use TableShipmentmethods;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * Объект Helper Плагина Vmsdek
 *
 * @since 1.0.0
 */
class Helper
{

	/**
	 * @var bool Gnz11 - is Loaded
	 * @since 1.0.0
	 */
	protected static $initGnz11 = false;

	/**
	 * @var Helper
	 * @since 1.0.0
	 */
	public static $instance;

	/**
	 * Helper constructor.
	 *
	 * @throws Exception
	 * @since 1.0.0
	 */
	private function __construct($options = array())
	{
		return $this;
	}#END FN

	/**
	 * @param   array  $options
	 *
	 * @return Helper
	 * @throws Exception
	 * @since 3.9
	 */
	public static function instance(array $options = array()): Helper
	{
		if ( self::$instance === null )
		{
			self::$instance = new self($options);
		}

		return self::$instance;
	}#END FN

	/**
	 * Добавить параметры метода доставки|оплаты для JS скрипта
	 * @param TableShipmentmethods $method
	 *
	 * @return void
	 * @throws Exception
	 * @since 3.9
	 */
	public static function addScriptOptionsMethodParams(TableShipmentmethods $method)
	{
		self::getExtensionVersion();
		echo'<pre>';print_r( $method );echo'</pre>'.__FILE__.' '.__LINE__;
		
		$addOptions = [
			'shipment_name' => $method->shipment_name ,
			'shipment_element' => $method->shipment_element ,
			'virtuemart_shipmentmethod_id' => $method->virtuemart_shipmentmethod_id ,
			'debug_on' => $method->debug_on ,
		];

		$scriptOptions = self::getScriptOptions();
		$scriptOptions = array_merge($scriptOptions, $addOptions);

		self::addScriptOptions($scriptOptions);
	}

	/**
	 * Загрузка ресурсов в админ панели
	 * ---
	 *
	 * @throws Exception
	 * @since 3.9
	 */
	public static function addAssetsAdmin()
	{
		self::initGnz11();
		$_extensionVersion = self::getExtensionVersion();
		$doc = Factory::getDocument();
		$doc->addStyleSheet('/plugins/vmshipment/vmsdek/assets/css/plg_vmshipment_vmsdek.admin.core.css?v='.$_extensionVersion);
		Js::addJproLoad(Uri::root() . 'plugins/vmshipment/vmsdek/assets/js/plg_vmshipment_vmsdek.admin.core.js?v='.$_extensionVersion);
	}

	/**
	 * Init - GNZ11 LIBRARY
	 * ---
	 *
	 * @return bool
	 * @throws Exception
	 * @since 1.0.0
	 */
	public static function initGnz11(): bool
	{
		if ( self::$initGnz11 ) return true; #END IF
		$patchGnz11 = JPATH_LIBRARIES . '/GNZ11';
		try
		{
			Js::instance();
		}
		catch ( Exception $e )
		{
			$app = Factory::getApplication();
			if ( !Folder::exists($patchGnz11) )
			{
				$app->enqueueMessage('The GNZ11 library must be installed', 'error');

				return false;
			}#END IF
		}
		self::$initGnz11 = true;

		return true;
	}

	/**
	 * Получить версию расширения Vmshipment Vmsdek
	 *
	 * @return mixed
	 * @throws Exception
	 * @since 1.0.0
	 */
	public static function getExtensionVersion()
	{
		$scriptOptions = self::getScriptOptions();
		if ( isset($scriptOptions[ '_extensionVersion' ]) ) return $scriptOptions[ '_extensionVersion' ]; #END IF

		$xml_file = JPATH_ROOT . '/plugins/vmshipment/vmsdek/vmsdek.xml';
		$dom      = new DOMDocument("1.0", "utf-8");
		$dom->load($xml_file);
		$_extensionVersion = $dom->getElementsByTagName('version')->item(0)->textContent;

		$app = \Joomla\CMS\Factory::getApplication();

		$scriptOptions = [
			'_extensionVersion' => $_extensionVersion ,
			'option' => $app->input->get('option' , null , 'STRING') ,
			'view' => $app->input->get('view' , null , 'STRING') ,
			'task' => $app->input->get('task' , null , 'STRING') ,

		];
		self::addScriptOptions( $scriptOptions );

		return $_extensionVersion;
	}

	/**
	 * Получить Script Options для Vmshipment Vmsdek
	 *
	 * @param   string  $key
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public static function getScriptOptions(string $key = 'Vmshipment.Vmsdek'): array
	{
		$doc = Factory::getDocument();

		return $doc->getScriptOptions($key);
	}

	/**
	 * Установить данные Script Options для Vmshipment Vmsdek
	 *
	 * @param   string  $key
	 * @param   array   $dataArr
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function addScriptOptions(array $dataArr, string $key = 'Vmshipment.Vmsdek')
	{
		$doc = Factory::getDocument();
		$doc->addScriptOptions($key, $dataArr);
	}

	/**
	 * Метод проверки связи JS & Server
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function testConnect(): array
	{
		$app = Factory::getApplication();
		$app->enqueueMessage('Message - Test Connect is OK!');
		$app->enqueueMessage('Notice - Test Connect is OK!', 'notice');
		$app->enqueueMessage('Warning - Test Connect is OK!', 'warning');
		$app->enqueueMessage('Error - Test Connect is OK!', 'error');

		$option = $app->input->get('option', false, 'STRING');
		$view = $app->input->get('view', false, 'STRING');
		$task = $app->input->get('task', false, 'STRING');
		$app->enqueueMessage('System - option ' . $option );
		$app->enqueueMessage('System - view ' . $view );
		$app->enqueueMessage('System - task ' . $task );

		return ['testConnectResult' => 'OK'];
	}
}