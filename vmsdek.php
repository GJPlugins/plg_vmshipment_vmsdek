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
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

use GNZ11\Core\Js;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Uri\Uri;
use Vmsdek\Helper;

/**
 * Плагин Доставки Vmsdek для Virtuemart
 *
 * @author  Gartes
 * @package Vmshipment Vmsdek
 * @since   1.0.0
 */
class plgVmshipmentVmsdek extends vmPSPlugin
{

	/**
	 * Версия расширения vmsdek
	 * ---
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected $_extensionVersion = '1.0.0';

	/**
	 * @param $subject
	 * @param $config
	 *
	 * @date  26.11.22 19:25
	 * @since 1.0.0
	 */
	function __construct(&$subject, $config)
	{
		// Регистрируем Библиотеку GNZ11
		JLoader::registerNamespace('GNZ11', JPATH_LIBRARIES . '/GNZ11', false, false, 'psr4');
		// Регистрируем Namespace Vmsdek для Helpers
		JLoader::registerNamespace('Vmsdek', JPATH_PLUGINS . '/vmshipment/vmsdek/helpers', false, false, 'psr4');

		parent::__construct($subject, $config);

		$this->_tablepkey   = 'id'; //virtuemart_order_id';
		$this->_idName      = 'virtuemart_' . $this->_psType . 'method_id';
		$this->_configTable = '#__virtuemart_' . $this->_psType . 'methods';

		$varsToPush = $this->getVarsToPush();
		$this->setConfigParameterable($this->_configTableFieldName, $varsToPush);

		$this->_extensionVersion = Helper::getExtensionVersion();
	}

	/**
	 * Проверить условия отображения способа доставки
	 *
	 * @param   VirtueMartCart  $cart
	 * @param   stdClass        $method
	 * @param   array           $cart_prices
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	protected function checkConditions(VirtueMartCart $cart, $method, $cart_prices): bool
	{
		return true;
	}

	/**
	 * Метод конвертации(преобразования) - данных
	 *
	 * @param   stdClass  $method
	 *
	 * @since 1.0.0
	 */
	function convert(stdClass $method)
	{

	}

	/**
	 * Отображает логотипы плагина  VirtueMart Vmshipment Vmsdek
	 * ---
	 * isplays the logos of a VirtueMart plugin
	 *
	 * @param   array  $logo_list
	 *
	 * @return string HTML with logos
	 * @author Valerie Isaksen
	 * @author Max Milbers
	 * @since  1.0.0
	 */
	protected function displayLogos(array $logo_list): string
	{
		$img = "";

		if ( !(empty($logo_list)) )
		{
			$url = 'images/virtuemart/' . $this->_psType;

			if ( !Folder::exists(VMPATH_ROOT . '/' . $url) )
			{
				$url = 'images/stories/virtuemart/' . $this->_psType;
				if ( !Folder::exists(VMPATH_ROOT . '/' . $url) )
				{
					return $img;
				}
			}

			if ( !is_array($logo_list) )
			{
				$logo_list = (array) $logo_list;
			}
			foreach ( $logo_list as $logo )
			{
				if ( !empty($logo) )
				{
					if ( JFile::exists(VMPATH_ROOT . '/' . $url . '/' . $logo) )
					{
						$alt_text = substr($logo, 0, strpos($logo, '.'));
						//Currently we do not see  the images in the invoices, because they are given with absolute URLS, which are needed for the email. We need a better solution here.
						$img .= '<span class="vmCart' . ucfirst($this->_psType) . 'Logo" >';
						$img .= '<img align="middle" src="' . Uri::root() . $url . '/' . $logo . '"  alt="' . $alt_text . '" />';
						$img .= '</span> ';
					}
				}
			}
		}

		return $img;
	}

	/**
	 * Получить стоимость доставки
	 *
	 * @param   VirtueMartCart  $cart
	 * @param   stdClass        $method
	 * @param   Array           $cart_prices
	 *
	 * @return int
	 * @since 1.0.0
	 */
	public function getCosts(VirtueMartCart $cart, $method, $cart_prices): int
	{
		if ( $method->free_shipment && $cart_prices[ 'salesPrice' ] >= $method->free_shipment )
		{
			return 0.0;
		}
		else
		{
			if ( empty($method->shipment_cost) ) $method->shipment_cost = 0.0;
			if ( empty($method->package_fee) ) $method->package_fee = 0.0;

			return $method->shipment_cost + $method->package_fee;
		}
	}

	/**
	 * Отображение способа доставки в заказе BE-Admin
	 * --
	 * Orede Info BE-Admin
	 *
	 * @param   int  $virtuemart_order_id  Id Order
	 *
	 * @return string - Html
	 * @since 1.0.0
	 */
	protected function getOrderShipmentHtml($virtuemart_order_id): string
	{
		$db = JFactory::getDBO();
		$q  = 'SELECT * FROM `' . $this->_tablename . '` '
			. 'WHERE `virtuemart_order_id` = ' . $virtuemart_order_id;
		$db->setQuery($q);
		if ( !($shipinfo = $db->loadObject()) )
		{
			$msg = vmText::sprintf('VMSHIPMENT_VMSDEK_NO_ENTRY_FOUND', $virtuemart_order_id);
			vmWarn($msg);
			vmDebug($msg, $q . " " . $db->getErrorMsg());

			return '';
		}

		$currency   = CurrencyDisplay::getInstance();
		$tax        = ShopFunctions::getTaxByID($shipinfo->tax_id);
		$taxDisplay = is_array($tax) ? $tax[ 'calc_value' ] . ' ' . $tax[ 'calc_value_mathop' ] : $shipinfo->tax_id;
		$taxDisplay = ($taxDisplay == -1) ? vmText::_('COM_VIRTUEMART_PRODUCT_TAX_NONE') : $taxDisplay;

		$html = '<table class="adminlist table">' . "\n";
		$html .= $this->getHtmlHeaderBE();
		$html .= $this->getHtmlRowBE('WEIGHT_COUNTRIES_SHIPPING_NAME', $shipinfo->shipment_name);
		$html .= $this->getHtmlRowBE('WEIGHT_COUNTRIES_WEIGHT', $shipinfo->order_weight . ' ' . ShopFunctions::renderWeightUnit($shipinfo->shipment_weight_unit));
		$html .= $this->getHtmlRowBE('WEIGHT_COUNTRIES_COST', $currency->priceDisplay($shipinfo->shipment_cost));
		$html .= $this->getHtmlRowBE('WEIGHT_COUNTRIES_PACKAGE_FEE', $currency->priceDisplay($shipinfo->shipment_package_fee));
		$html .= $this->getHtmlRowBE('WEIGHT_COUNTRIES_TAX', $taxDisplay);
		$html .= '</table>' . "\n";

		return $html;
	}

	/**
	 * Поля для таблицы плагина доставки
	 * Fields for the shipping plugin table
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getTableSQLFields()
	{
		$SQLfields = [
			'id'                           => 'int(1) UNSIGNED NOT NULL AUTO_INCREMENT',
			'virtuemart_order_id'          => 'int(11) UNSIGNED',
			'order_number'                 => 'char(32)',
			'virtuemart_shipmentmethod_id' => 'mediumint(1) UNSIGNED',
			'shipment_name'                => 'varchar(5000)',
			'order_weight'                 => 'decimal(10,4)',
			'shipment_weight_unit'         => 'char(3) DEFAULT \'KG\'',
			'shipment_cost'                => 'decimal(10,2)',
			'shipment_package_fee'         => 'decimal(10,2)',
			'tax_id'                       => 'smallint(1)'
		];

		return $SQLfields;
	}

	/**
	 * Создать таблицу для этого плагина, если она еще не существует.
	 * ---
	 * Create the table for this plugin if it does not yet exist.
	 *
	 * @author Valérie Isaksen
	 * @since  1.0.0
	 */
	public function getVmPluginCreateTableSQL(): string
	{
		return $this->createTableSQL('Shipment Vmsdek Table');
	}

	/**
	 * Системное событие перед созданием Head page
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function onBeforeCompileHead()
	{

	}

	/**
	 * Это событие запускается после сохранения заказа; он получает способ доставки-
	 * конкретные данные.
	 * ---
	 * This event is fired after the order has been stored; it gets the shipment method-
	 * specific data.
	 *
	 * @param   VirtueMartCart  $cart   the cart
	 * @param   array           $order  The actual order saved in the DB
	 *
	 * @return bool|null Null when this method was not selected, otherwise true
	 * @author Valerie Isaksen
	 * @since  1.0.0
	 */
	public function plgVmConfirmedOrder(VirtueMartCart $cart, array $order): ?bool
	{

		if ( !($method = $this->getVmPluginMethod($order[ 'details' ][ 'BT' ]->virtuemart_shipmentmethod_id)) )
		{
			return null; // Another method was selected, do nothing
		}
		if ( !$this->selectedThisElement($method->shipment_element) )
		{
			return false;
		}
		$values[ 'virtuemart_order_id' ]          = $order[ 'details' ][ 'BT' ]->virtuemart_order_id;
		$values[ 'order_number' ]                 = $order[ 'details' ][ 'BT' ]->order_number;
		$values[ 'virtuemart_shipmentmethod_id' ] = $order[ 'details' ][ 'BT' ]->virtuemart_shipmentmethod_id;
		$values[ 'shipment_name' ]                = $this->renderPluginName($method);
		$values[ 'order_weight' ]                 = $this->getOrderWeight($cart, $method->weight_unit);
		$values[ 'shipment_weight_unit' ]         = $method->weight_unit;

		$costs = $this->getCosts($cart, $method, $cart->cartPrices);
		if ( !empty($costs) )
		{
			$values[ 'shipment_cost' ]        = $method->shipment_cost;
			$values[ 'shipment_package_fee' ] = $method->package_fee;
		}
		if ( empty($values[ 'shipment_cost' ]) ) $values[ 'shipment_cost' ] = 0.0;
		if ( empty($values[ 'shipment_package_fee' ]) ) $values[ 'shipment_package_fee' ] = 0.0;

		$values[ 'tax_id' ] = $method->tax_id;
		$this->storePSPluginInternalData($values);

		return true;
	}

	/**
	 * Срабатывает на странице настройки способа доставки этого плагина для VM2 Version
	 * ---
	 * Может использоваться для загрузки скриптов UI
	 *
	 * @param $name
	 * @param $id
	 * @param $dataOld
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	function plgVmDeclarePluginParamsShipment($name, $id, &$dataOld): bool
	{
		return $this->declarePluginParams('shipment', $name, $id, $dataOld);
	}

	/**
	 * Срабатывает на странице настройки способа доставки этого плагина для VM3 Version
	 * ---
	 * Может использоваться для загрузки скриптов UI
	 *
	 * @param $data
	 *
	 * @return bool
	 * @throws Exception
	 * @since 1.0.0
	 */
	function plgVmDeclarePluginParamsShipmentVM3(&$data): bool
	{
		$app = \Joomla\CMS\Factory::getApplication();
		// Проверяем что находимся именно в режиме редактирования нужного метода (Доставка|Оплата)
		if ( $app->isClient('administrator') && $this->_name == 'vmsdek' )
		{
			$method = $this->getVmPluginMethod( $data->virtuemart_shipmentmethod_id );
			Helper::addScriptOptionsMethodParams( $method );
			Helper::addAssetsAdmin();

		}#END IF
		return $this->declarePluginParams('shipment', $data);

	}

	/**
	 * plgVmDisplayListFE Это событие запускается, чтобы отобразить методы плагина в корзине (например, изменить
	 * отгрузку/оплату).
	 *
	 * plgVmDisplayListFE This event is fired to display the pluginmethods in the cart (edit shipment/payment) for
	 * example
	 *
	 * @param   VirtueMartCart  $cart      Cart object
	 * @param   integer         $selected  ID of the method selected
	 * @param                   $htmlIn
	 *
	 * @return boolean True в случае успеха, false в случае неудачи, null, если этот подключаемый модуль не был выбран.
	 * При ошибках необходимо использовать JError::raiseWarning (или JError::raiseError) для установки сообщения.
	 *
	 * True on success, false on failures, null when this plugin was not selected.
	 * On errors, JError::raiseWarning (or JError::raiseError) must be used to set a message.
	 *
	 * @author Valerie Isaksen
	 * @author Max Milbers
	 * @since  1.0.0
	 */
	public function plgVmDisplayListFEShipment(VirtueMartCart $cart, $selected = 0, &$htmlIn): bool
	{
		return $this->displayListFE($cart, $selected, $htmlIn);
	}

	/**
	 * Проверяет, сколько плагинов доступно. Если только один, у пользователя не будет выбора. Введите страницу
	 * edit_xxx
	 * Плагин должен сначала проверить, является ли он правильным типом
	 * ---
	 * Checks how many plugins are available. If only one, the user will not have the choice. Enter edit_xxx page
	 * The plugin must check first if it is the correct type
	 *
	 * @param   VirtueMartCart  $cart  the cart object
	 *
	 * @return null Если плагин не найден, 0 если найдено более одного плагина, virginmart_xxx_id если найден только
	 *              один плагин if no plugin was found, 0 if more then one plugin was found,  virtuemart_xxx_id if only
	 *              one plugin is found
	 *
	 * @author Valerie Isaksen
	 * @since  1.0.0
	 */
	function plgVmOnCheckAutomaticSelectedShipment(VirtueMartCart $cart, array $cart_prices, &$shipCounter)
	{

		return $this->onCheckAutomaticSelected($cart, $cart_prices, $shipCounter);
	}

	/**
	 * @TODO  Gartes - Добавить описание метода в шаблон
	 *
	 * @param   VirtueMartCart  $cart
	 *
	 * @return false|void|null
	 * @since 1.0.0
	 */
	function plgVmOnCheckoutCheckDataShipment(VirtueMartCart $cart)
	{

		if ( empty($cart->virtuemart_shipmentmethod_id) ) return false;

		//На данный момент может иметь смысл использовать идентификатор поставщика корзины
		//At the moment one, could make sense to use the cart vendor id
		$virtuemart_vendor_id = 1;
		if ( $this->getPluginMethods($virtuemart_vendor_id) === 0 )
		{
			return null;
		}

		foreach ( $this->methods as $this->_currentMethod )
		{
			if ( $cart->virtuemart_shipmentmethod_id == $this->_currentMethod->virtuemart_shipmentmethod_id )
			{
				if ( !$this->checkConditions($cart, $this->_currentMethod, $cart->cartPrices) )
				{
					return false;
				}
				break;
			}
		}
	}

	/**
	 * Если в параметрах способа доставки установлено отображать на странице товара
	 * и условия доставки допускают - добавляем в массив HTML для отображения.
	 *
	 * @param   TableProducts  $product                  Объект товара
	 * @param   array          $productDisplayShipments  Массив с HTML для способов доставки
	 *
	 * @return false
	 * @since 1.0.0
	 */
	function plgVmOnProductDisplayShipment($product, &$productDisplayShipments)
	{

		if ( $this->getPluginMethods($product->virtuemart_vendor_id) === 0 )
		{
			return false;
		}

		$html = array();

		$currency = CurrencyDisplay::getInstance();
		// Перебираем способы доставки
		foreach ( $this->methods as $this->_currentMethod )
		{
			if ( $this->_currentMethod->show_on_pdetails )
			{
				if ( !isset($cart) )
				{
					$cart                        = VirtueMartCart::getCart();
					$cart->products[ 'virtual' ] = $product;
					$cart->_productAdded         = true;
					$cart->prepareCartData();
				}
				// Если условия отображения допускают
				if ( $this->checkConditions($cart, $this->_currentMethod, $cart->cartPrices) )
				{
					$product->prices[ 'shipmentPrice' ] = $this->getCosts($cart, $this->_currentMethod, $cart->cartPrices);

					if ( isset($product->prices[ 'VatTax' ]) and count($product->prices[ 'VatTax' ]) > 0 )
					{
						reset($product->prices[ 'VatTax' ]);
						$rule = current($product->prices[ 'VatTax' ]);
						if ( isset($rule[ 1 ]) )
						{
							$product->prices[ 'shipmentTax' ]   = $product->prices[ 'shipmentPrice' ] * $rule[ 1 ] / 100.0;
							$product->prices[ 'shipmentPrice' ] = $product->prices[ 'shipmentPrice' ] * (1 + $rule[ 1 ] / 100.0);
						}
					}
					// создаем HTML - для вывода на странице товара
					$html[ $this->_currentMethod->virtuemart_shipmentmethod_id ] = $this->renderByLayout('default', array("method" => $this->_currentMethod, "cart" => $cart, "product" => $product, "currency" => $currency));
				}
			}
		}
		if ( isset($cart) )
		{
			unset($cart->products[ 'virtual' ]);
			$cart->_productAdded = true;
			$cart->prepareCartData();
		}

		$productDisplayShipments[] = $html;
	}

	/**
	 * Это событие запускается после выбора способа оплаты.
	 * Его можно использовать для хранения дополнительная информация об оплате в корзине.
	 *
	 * @param   VirtueMartCart  $cart
	 *
	 * @return null
	 * @since 3.9
	 */
	public function plgVmOnSelectCheckShipment(VirtueMartCart &$cart)
	{

		return $this->OnSelectCheck($cart);
	}

	/**
	 * Рассчитать цену (значение, tax_id) выбранного метода  Вызывается калькулятором Эта функция НЕ подлежит повторной
	 * реализации. Если не переопределять, то берутся значения по умолчанию из этой функции.
	 * ---
	 *
	 * @param   VirtueMartCart  $cart
	 * @param   array           $cart_prices
	 * @param                   $cart_prices_name
	 *
	 * @return bool|null
	 * @since 1.0.0
	 */
	public function plgVmOnSelectedCalculatePriceShipment(VirtueMartCart $cart, array &$cart_prices, &$cart_prices_name)
	{
		return $this->onSelectedCalculatePrice($cart, $cart_prices, $cart_prices_name);
	}

	/**
	 * Этот метод запускается при отображении сведений о заказе в бэкэнде.
	 * Он отображает данные по отгрузке.
	 * ПРИМЕЧАНИЕ. Этот плагин НЕ следует использовать для отображения полей формы, так как он вызывается снаружи
	 * форма! Вместо этого используйте plgVmOnUpdateOrderBE()!
	 * ---
	 * This method is fired when showing the order details in the backend.
	 * It displays the shipment-specific data.
	 * NOTE, this plugin should NOT be used to display form fields, since it's called outside
	 * a form! Use plgVmOnUpdateOrderBE() instead!
	 *
	 * @param   integer  $virtuemart_order_id             The order ID
	 * @param   integer  $virtuemart_shipmentmethod_id    ID способа доставки заказа
	 *                                                    The order shipment method ID
	 *
	 * @return mixed Null для отправлений, которые не активны, текст (HTML) в противном случае
	 *               Null for shipments that aren't active, text (HTML) otherwise
	 * @author Valerie Isaksen
	 * @since  1.0.0
	 */
	public function plgVmOnShowOrderBEShipment($virtuemart_order_id, $virtuemart_shipmentmethod_id)
	{

		if ( !($this->selectedThisByMethodId($virtuemart_shipmentmethod_id)) )
		{
			return null;
		}
		$html = $this->getOrderShipmentHtml($virtuemart_order_id);

		return $html;
	}

	/**
	 * Этот метод запускается при отображении сведений о заказе во внешнем интерфейсе.
	 * Он отображает данные по отгрузке.
	 * ---
	 * This method is fired when showing the order details in the frontend.
	 * It displays the shipment-specific data.
	 *
	 * @param   integer  $virtuemart_order_id           ID заказа
	 *                                                  The order ID
	 * @param   integer  $virtuemart_shipmentmethod_id  ID выбранного способа доставки
	 *                                                  The selected shipment method id
	 * @param   string   $shipment_name                 Имя способа доставки
	 *                                                  Shipment Name
	 *
	 * @return mixed Null для отправлений, которые не активны, текст (HTML) в противном случае
	 *               Null for shipments that aren't active, text (HTML) otherwise
	 * @author Valérie Isaksen
	 * @author Max Milbers
	 * @since  1.0.0
	 */
	public function plgVmOnShowOrderFEShipment($virtuemart_order_id, $virtuemart_shipmentmethod_id, &$shipment_name)
	{
		$this->onShowOrderFE($virtuemart_order_id, $virtuemart_shipmentmethod_id, $shipment_name);
	}

	/**
	 * Этот метод запускается при отображении при печати заказа. * Он отображает данные, относящиеся к способу оплаты.
	 * ---
	 * This method is fired when showing when priting an Order. It displays the the payment method-specific data.
	 *
	 * @param   integer  $_virtuemart_order_id  The order ID
	 * @param   integer  $method_id             method used for this order
	 *
	 * @return mixed Нулевой, если для способов оплаты, которые не были выбраны, текст (HTML) в противном случае
	 * Null when for payment methods that were not selected, text (HTML) otherwise
	 * @author Valerie Isaksen
	 * @since  1.0.0
	 * TODO - Скорее всего ошибка в имени метода - правильно plgVmOnShowOrderPrint
	 */
	function plgVmonShowOrderPrint($order_number, $method_id)
	{
		return $this->onShowOrderPrint($order_number, $method_id);
	}

	/**
	 * Создайте таблицу для этого плагина, если она еще не существует.
	 * Эта функция проверяет, активен ли вызываемый плагин. Когда да, вызывается стандартный метод для создания таблиц.
	 * ---
	 * Create the table for this plugin if it does not yet exist.
	 * This functions checks if the called plugin is active one.
	 * When yes it is calling the standard method to create the tables
	 *
	 * @author Valérie Isaksen
	 * @since  1.0.0
	 */
	function plgVmOnStoreInstallShipmentPluginTable($jplugin_id): bool
	{
		return $this->onStoreInstallPluginTable($jplugin_id);
	}

	/**
	 * TODO Добавить описание метода в шаблон
	 *
	 * @param $data
	 * @param $table
	 *
	 * @return bool
	 * @author Max Milbers
	 * @since  1.0.0
	 */
	function plgVmSetOnTablePluginShipment(&$data, &$table): bool
	{
		$name = $data[ 'shipment_element' ];
		$id   = $data[ 'shipment_jplugin_id' ];

		if ( !empty($this->_psType) and !$this->selectedThis($this->_psType, $name, $id) )
		{
			return false;
		}
		else
		{
			$tCon = array('weight_start', 'weight_stop', 'orderamount_start', 'orderamount_stop', 'shipment_cost', 'package_fee');
			foreach ( $tCon as $f )
			{
				if ( !empty($data[ $f ]) )
				{
					$data[ $f ] = str_replace(array(',', ' '), array('.', ''), $data[ $f ]);
				}
			}

			//$data['show_on_pdetails'] = (int) $data['show_on_pdetails'];
			return $this->setOnTablePluginParams($name, $id, $table);
		}
	}

	/**
	 * Создать HTML - Для отображения выбора плагина VirtueMart Vmshipment Vmsdek в корзине при оформлении заказа
	 * --
	 *
	 * @param   stdClass  $plugin  Virtuemart Vmshipment method
	 *
	 * @return mixed
	 * @throws Exception
	 * @since 1.0.0
	 */
	protected function renderPluginName($plugin)
	{
		Helper::initGnz11();
		Js::addJproLoad(Uri::root() . 'plugins/vmshipment/vmsdek/assets/js/plg_vmshipment_vmsdek.core.js');

		static $c = array();
		$idN = 'virtuemart_' . $this->_psType . 'method_id';

		// Если Html метода доставки уже создавался
		if ( isset($c[ $this->_psType ][ $plugin->{$idN} ]) )
		{
			return $c[ $this->_psType ][ $plugin->{$idN} ];
		}

		$htmlLogos      = '';
		$plugin_name    = $this->_psType . '_name';
		$plugin_desc    = $this->_psType . '_desc';
		$logosFieldName = $this->_psType . '_logos';
		$logos          = property_exists($plugin, $logosFieldName) ? $plugin->{$logosFieldName} : array();
		if ( !empty($logos) )
		{
			$htmlLogos = $this->displayLogos($logos);
		}

		$data = [
			"_extensionVersion"            => $this->_extensionVersion,
			// TODO - определять для (Оплата|Доставка)
			"virtuemart_shipmentmethod_id" => $plugin->virtuemart_shipmentmethod_id,
			"selectorInputElement"         => 'shipment_id_' . $plugin->virtuemart_shipmentmethod_id,
			// -------------------------------------------
			"element"                      => $plugin->element,
			"folder"                       => $plugin->folder,
			"type"                         => $plugin->type,
			"_type"                        => $this->_type,
			"method_name"                  => $plugin->{$plugin_name},
			"description"                  => $plugin->{$plugin_desc},
			"html_logos"                   => $htmlLogos,

		];
		// Добавляем данные для JS скриптов
		Helper::addScriptOptions($data);

		$c[ $this->_psType ][ $plugin->{$idN} ] = $this->renderByLayout('plugin_name', $data);
		// Макет для дополнительных полей
		$c[ $this->_psType ][ $plugin->{$idN} ] .= $this->renderByLayout('additional_fields', $data);

		return $c[ $this->_psType ][ $plugin->{$idN} ];
	}

	/**
	 * Точка входа Ajax
	 * ---
	 *
	 * @return void
	 * @throws Exception
	 * @since 1.0.0
	 */
	public function onAjaxVmsdek()
	{
		$app    = \Joomla\CMS\Factory::getApplication();
		$task   = $app->input->get('task', 'testConnect', 'STRING');
		$Helper = Helper::instance();
		if ( !method_exists($Helper, $task) )
		{
			echo new JResponseJson(null, 'METHOD \Vmsdek\Helper::' . $task . ' NOT EXISTS', false);
			die();
		}#END IF
		try
		{
			$resultData = $Helper->{$task}();
		}
		catch ( \Exception $e )
		{
			// Executed only in PHP 5, will not be reached in PHP 7
			echo 'Выброшено исключение: ', $e->getMessage(), "\n";
			echo '<pre>';
			print_r($e);
			echo '</pre>' . __FILE__ . ' ' . __LINE__;
			die(__FILE__ . ' ' . __LINE__);
		}

		echo new JResponseJson($resultData, '', false);
		die();
	}
}