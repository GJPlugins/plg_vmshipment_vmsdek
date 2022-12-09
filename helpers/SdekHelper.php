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
 * @date       27.11.22 16:18
 * Created by PhpStorm.
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 **********************************************************************************************************************/

namespace Vmsdek;

use CdekSDK\Requests;
use CdekSDK2\Exceptions\AuthException;
use CdekSDK2\Exceptions\RequestException;
use Exception;
use Joomla\CMS\Factory;
use stdClass;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use VirtueMartCart;

//	use Joomla\Http\Http;
//	use Joomla\Http\Transport\Stream as StreamTransport;

class SdekHelper extends Helper
{
	protected array $methodParams = [];

    public static $instance;

	/**
	 * helper constructor.
	 *
	 * @throws Exception
	 * @since 3.9
	 */
	private function __construct($methodParams = array())
	{
        
		require_once JPATH_PLUGINS . '/vmshipment/vmsdek/libraries/vendor/autoload.php';
		$this->methodParams = $methodParams ;

		return $this;
	}#END FN

	/**
	 * @param   array  $options
	 *
	 * @return SdekHelper
	 * @throws Exception
	 * @since 3.9
	 */
	public static function instance(array $options = []): SdekHelper
	{
		if ( self::$instance === null )
		{
			self::$instance = new self($options);
		}
		return self::$instance;
	}#END FN

    /**
     * Авторизаци в системе CdekSDK2
     * @return \CdekSDK2\Client
     * @throws Exception
     * @since 3.9
     */
    protected function setAuthorize(){
        $app = Factory::getApplication();
        $sdek_api_login = $app->input->get('loginApi', $this->methodParams['sdek_api_login'] , 'RAW');
        $sdek_api_pass = $app->input->get('passApi', $this->methodParams['sdek_api_pass'], 'RAW');

        $client = new Psr18Client();
        $cdek = new \CdekSDK2\Client( $client );
        $cdek->setAccount( $sdek_api_login );
        $cdek->setSecure( $sdek_api_pass  );





        return $cdek ;
    }

    /**
     * Загрузить список пунктов выдачи заказов
     * @return \CdekSDK2\Dto\CityList|\CdekSDK2\Dto\PickupPointList|\CdekSDK2\Dto\RegionList|\CdekSDK2\Dto\WebHookList|bool
     * @throws Exception
     * @since 3.9
     */
    public function getPickupsCity( $city_id = false ){
        $app = Factory::getApplication();
        $docType = $app->getDocument()->getType();
        $city_id = $app->input->get('city_id', $city_id , 'INT');
        $task = $app->input->get('task', false , 'STRING');

        $cdek = $this->setAuthorize();
        $result = $cdek->offices()->getFiltered([ 'city_code' => $city_id ]);
        if ($result->isOk()) {
            //Запрос успешно выполнился
            $pvzlist = $cdek->formatResponseList($result, \CdekSDK2\Dto\PickupPointList::class);

            // Если Ajax запрос - от метода доставки Sdek
            if ( $docType == 'json' && $task == 'getPickupsCity' )
            {
                $app->enqueueMessage('Выберите отделение отправления');
                $app->enqueueMessage('Список отделений загружен');
            }#END IF


            return $pvzlist ;
        }
        $app->enqueueMessage('Ошибка при загрузки пунктов получения.');
        return false ;
    }

    /**
     * Загрузить форму выбора городов доставки
     * @return array
     * @since 3.9
     */
	public function getCitySelectForm(){

//		$client = new Psr18Client();
//		$cdek = new \CdekSDK2\Client( $client );
//		$cdek->setAccount($this->methodParams['sdek_api_login'] );
//		$cdek->setSecure($this->methodParams['sdek_api_pass'] );
//		Описание фильтров \CdekSDK2\Actions\LocationCities::FILTER
//		$result = $cdek->cities()->getFiltered(['country_codes' => 'RU' ]);
		// Запрос успешно выполнился
//		$cities = $cdek->formatResponseList($result, \CdekSDK2\Dto\CityList::class);
//
//		echo'<pre>';print_r( $cities );echo'</pre>'.__FILE__.' '.__LINE__;
//		die(__FILE__ .' '. __LINE__ );



		\JLayoutHelper::render('form_select_city'  );

		$layout = new \Joomla\CMS\Layout\FileLayout('form_select_city');
		$layout->addIncludePaths(JPATH_PLUGINS . '/vmshipment/vmsdek/tmpl');
		$htmlFormCitySelect =  $layout->render([]);

		return [
			'formHtml' => $htmlFormCitySelect ,
		];
    }

    /**
     * Получение тарифа для доставки заказа
     * @param int $city_id Код населенного пункта СДЭК (метод "Список населенных пунктов")
     * @param VirtueMartCart $cart
     * @param int $delivery_type - тип доставки выбранный у покупателя (4 -> На склад | 3 -> Доставка курьером )
     * @return stdClass - Данные тарифа - от Cdek
     * @throws AuthException
     * @throws RequestException
     * @since 3.9
     */
    public function getCosts(int $city_id  , VirtueMartCart $cart , int $delivery_type = 4 ): stdClass
    {

        $app = Factory::getApplication();
        $client = new Psr18Client();
        $sdek_api_login = $app->input->get('loginApi', $this->methodParams['sdek_api_login'] , 'RAW');
        $sdek_api_pass = $app->input->get('passApi', $this->methodParams['sdek_api_pass'], 'RAW');
        $Api = new \CdekSDK2\Http\Api($client,$sdek_api_login,$sdek_api_pass);
        $Api->authorize();
        /**
         * @var array $packages Список информации по местам (упаковкам)
         */
        $packages['weight']  = VirtueMartCart::getCartWeight ( $cart ,   'GR');

        /**
         * Посылка склад-склад
         * Услуга экономичной доставки товаров по России для компаний, осуществляющих дистанционную торговлю.
         */
        $tariff_code = 136 ;
        // Если у покупателя выбрано доставка в PVZ
        if ( $delivery_type == 4  )
        {
            // Склад - слад
//            if ( $this->methodParams->sdek_delivery_mode_pvz == 4 ) $tariff_code = 136 ;#END IF
            // Двери->склад
            if ( $this->methodParams['sdek_delivery_mode_pvz'] == 2 ) $tariff_code = 138 ;#END IF
        }
        if($delivery_type == 3){
            // Дверь->Дверь
            if ( $this->methodParams['sdek_delivery_mode_courier'] == 1 ) $tariff_code = 139 ;#END IF
            // Склад->Дверь
            if ( $this->methodParams['sdek_delivery_mode_courier'] == 3 ) $tariff_code = 137 ;#END IF
        }#END IF


        $data = [
            'currency' => 1,
            'tariff_code' => $tariff_code ,
            'to_location' => [
                "code" => $this->methodParams['sender_city_id']
            ],
            'from_location' => [
                //                'address' => 'волгоград проспект ленина 28',
                "code" => $city_id
            ],
            "packages" =>  $packages ,
            /*"packages" => [
                "height" => 10 ,
                "weight" => 10 ,
                "width" => 15 ,
                "length" => 25 ,
            ]*/
        ];

        $result = $Api->post('/calculator/tariff' , $data );
        if ( !$result->isOk() )
        {
            // TODO - Обработка ошибок при расчете цен на доставку
        }#END IF
        $body = $result->getBody();
        $result = json_decode( $body  );

        // Добавляем стоимость упаковки
        $result->delivery_sum += $this->methodParams['packaging_cost'] ;

        $result->delivery_type = $delivery_type;

        return $result ;
    }

    /**
     * Сохранить данные пользователя User State И рассчитать стоимость доставки
     * @return bool|array
     * @throws Exception
     * @since 3.9
     */
    public function setUserStateFormAndGetPrice()
    {
        $Helper = parent::instance( $this->methodParams );
        $Helper->setUserStateForm();

        $userState = $Helper->getUserStateForm();
        if ( empty( $userState['city_id'] ) )
        {
            return true ;
        }#END IF

        $cart = VirtueMartCart::getCart();
        $cart->prepareCartData(false);

        $resultCosts[] = $this->getCosts( $userState['city_id'] , $cart , 4 );
        $resultCosts[] = $this->getCosts( $userState['city_id'] , $cart , 3 );
        return ['updatesCosts'=>$resultCosts] ;
    }

}