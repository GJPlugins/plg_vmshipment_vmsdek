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
 * @date       26.11.22 16:41
 * Created by PhpStorm.
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 **********************************************************************************************************************/

use Joomla\CMS\Language\Text;
use Joomla\CMS\Installer\Adapter\ModuleAdapter;
use Joomla\CMS\Installer\Adapter\PluginAdapter;

/**
 *
 * @package     Joomla.Administrator
 * @subpackage  Plugin Vmshipment - Vmsdek
 *
 * @copyright   Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       3.9
 */
class PlgVmshipmentVmsdekInstallerScript
{
	/**
	 * Отметить для отмены установки
	 * ---
	 * Flag to cancel the installation
	 * ---
	 *
	 * @var bool
	 * @since 3.9
	 */
	protected $cancelInstallation = false;


	/**
	 * Этот метод вызывается после установки плагина.
	 * ---
	 * This method is called after a component is installed.
	 * ---
	 *
	 * @param   Joomla\CMS\Installer\Adapter\PluginAdapter  $parent  - Parent object calling this method.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function install(Joomla\CMS\Installer\Adapter\PluginAdapter $parent)
	{
		echo '<p>' . Text::_('VMSHIPMENT_VMSDEK_INSTALL') . '</p>';
//		$parent->getParent()->setRedirectURL('index.php?option=com_helloworld');
//		die(__FILE__ .' '. __LINE__ );

	}

	/**
	 * Этот метод вызывается после удаления Плагина.
	 * ---
	 * This method is called after a component is uninstalled.
	 * ---
	 *
	 * @param   Joomla\CMS\Installer\Adapter\PluginAdapter  $parent  - Parent object calling this method.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function uninstall(Joomla\CMS\Installer\Adapter\PluginAdapter $parent)
	{
		echo '<p>' . Text::_('VMSHIPMENT_VMSDEK_UNINSTALL') . '</p>';
	}

	/**
	 * Этот метод вызывается после обновления Плагина.
	 * ---
	 *
	 * @param   Joomla\CMS\Installer\Adapter\PluginAdapter  $parent  - Parent object calling object.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function update(Joomla\CMS\Installer\Adapter\PluginAdapter $parent)
	{
		// Обновление до версии - ( %s ) 
		// Текст "Обновление успешно"
		echo '<p>' . Text::sprintf('VMSHIPMENT_VMSDEK_UPDATE', (string) $parent->get('manifest')->version) . '</p>';
	}

	/**
	 * Запускается непосредственно перед выполнением каких-либо действий по установке Плагина.
	 * ---
	 * В этой функции должны выполняться проверки и предварительные условия.
	 * ---
	 * Runs just before any installation action is performed on the component.
	 * Verifications and pre-requisites should run in this function.
	 *
	 *
	 * @param   string                                      $type    - Type of PreFlight action. Possible values are:
	 *                                                               - * install
	 *                                                               - * update
	 *                                                               - * discover_install
	 * @param   Joomla\CMS\Installer\Adapter\PluginAdapter  $parent  - Parent object calling object.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function preflight(string $type, Joomla\CMS\Installer\Adapter\PluginAdapter $parent)
	{

//		$language = JFactory::getLanguage();
//		echo'<pre>';print_r( $language );echo'</pre>'.__FILE__.' '.__LINE__;

		// Старт обновления 
		// Текст - "Начало обновления"
		echo '<p>' . JText::_('VMSHIPMENT_VMSDEK_PREFLIGHT_' . mb_strtoupper($type)) . '</p>';
	}

	/**
	 * Запускается сразу после выполнения любого действия по установке компонента.
	 * ---
	 * Runs right after any installation action is performed on the component.
	 * ---
	 *
	 * @param   string                                      $type    - Type of PostFlight action. Possible values are:
	 *                                                               - * install
	 *                                                               - * update
	 *                                                               - * discover_install
	 * @param   Joomla\CMS\Installer\Adapter\PluginAdapter  $parent  - Parent object calling object.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function postflight(string $type, Joomla\CMS\Installer\Adapter\PluginAdapter $parent)
	{

		$this->createModule($parent);
		// Обновление успешно завершено 
		// Текст "Обновление завершено"
		echo '<p>' . JText::_('VMSHIPMENT_VMSDEK_POSTFLIGHT_' . mb_strtoupper($type)) . '</p>';
	}


	/**
	 * @param $parent
	 *
	 * @return void
	 * @since 3.9
	 */
	protected function createModule($parent)
	{
		$db    = JFactory::getDBO();
		$Query = $db->getQuery(true);

		$table   = $db->quoteName('#__modules');
		$columns = [
			'position',
			'published',
			'access', 'ziffilter_value_fild'];


		// mypanel
		$db->setQuery("UPDATE `#__modules`" .
			" SET 
			`position` = 'panel', 
			`published` = '1', 
			`access` = '3'" .
			" WHERE `#__modules`.`module` = 'mod_mypanel'; 
			");

		if ( !$db->query() && ($db->getErrorNum() != 1060) )
		{
			echo $db->getErrorMsg(true);
		}
//		die(__FILE__ .' '. __LINE__ );

	}

}