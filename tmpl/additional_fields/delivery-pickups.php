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
 * @author Gartes | sad.net79@gmail.com | Telegram : @gartes
 * @date 03.12.22 09:35
 * Created by PhpStorm.
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 **********************************************************************************************************************/
/**
 *
 * @license
 * @copyright
 * @since 3.9
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
/**
 * @var array $displayData
 * @var array $userState - Данные пользователя из User State 
 * @var array $PickupsCity - Список офисов для города
 * @var string $_nameSelectPickup - Имя для Select Element - выбора складов
 * @var string $_nameHiddenOfficeId - Имя для hidden Input -
 * @var int $sdek_delivery_mode_pvz - Режимы доставки ПВЗ
 * @var int $sdek_delivery_mode_courier - Режимы доставки к двери
 */
empty($displayData) ?: extract($displayData);

$street = $userState['address_house']['street'] ?? '';
$house = $userState['address_house']['house'] ?? '';
$flat = $userState['address_house']['flat'] ?? '';

// Выбранный тип доставки PVZ | DOOR
$delivery_type = $userState['delivery_type'] ?? $sdek_delivery_mode_pvz;


//echo'<pre>';print_r( $userState['office_id'] );echo'</pre>'.__FILE__.' '.__LINE__;
//die(__FILE__ .' '. __LINE__ );


?>
<script>
    (function ($){
        setTimeout(function (){
            $('select[name="<?= $_nameSelectPickup ?>"]').chosen({disable_search_threshold: 10});
        },3000)
    })(jQuery)
</script>
<ul class="select-delivery-variant">
    <!-- Доставка ПВЗ -->
    <li class="checkout-variant <?= ($delivery_type != $sdek_delivery_mode_pvz ?: 'active"') ?> ">
        <div _ngcontent-rz-client-c210="" class="checkout-variant__inner">
            <!-- Radio - Доставка PVZ -->
            <div _ngcontent-rz-client-c210="" class="checkout-variant__radio">
                <input _ngcontent-rz-client-c210=""
                       type="radio"
                       data-evt="on_change_delivery_type"
                       name="vm_sdek[delivery_type]"
                       <?= ($delivery_type != $sdek_delivery_mode_pvz?:'checked="checked"')  ?>
                       value="<?= $sdek_delivery_mode_pvz ?>">
                <label _ngcontent-rz-client-c210="" class="checkout-variant__label">
                    <span _ngcontent-rz-client-c210="" class="checkout-variant__body">
                        <span _ngcontent-rz-client-c210="" class="checkout-variant__title">
                            Доставка в ПВЗ
                            <!---->
                            <!---->
                        </span>
                        <span _ngcontent-rz-client-c210="" class="checkout-variant__price ng-star-inserted">
                            <rz-checkout-delivery-price _ngcontent-rz-client-c210="" class="ng-star-inserted">
                                по тарифам перевозчика
                                <!---->
                                <!---->
                                <!---->
                                <!---->
                                <!---->
                            </rz-checkout-delivery-price>
                            <!---->
                            <!---->
                        </span>
                        <!---->
                    </span>
                </label>
            </div>

            <div _ngcontent-rz-client-c210="" class="checkout-variant__content ng-star-inserted">
                <!---->
                <rz-checkout-delivery-pickup-content _ngcontent-rz-client-c217="" _nghost-rz-client-c215=""
                                                     class="ng-star-inserted">
                    <div _ngcontent-rz-client-c215="" class="delivery-pickups">
                        <rz-checkout-delivery-dropdown-pickups _ngcontent-rz-client-c215="" _nghost-rz-client-c212=""
                                                               class="ng-star-inserted">
                            <div _ngcontent-rz-client-c212="" class="dropdown-pickups">

                                    <div _ngcontent-rz-client-c211="" class="autocomplete">

                                        <?php
                                        $optionArr = ['<option value="0" >Выбрать адрес доставки</option>'];
                                        foreach ($PickupsCity as $item)
                                        {
                                            $selected ='';
                                            if ( isset( $userState['office_id'])&&!empty($userState['office_id']) &&$userState['office_id']== $item->code )
                                            {
                                                $selected =  'selected="selected"' ;
                                            }#END IF

                                            $optionArr[] = '<option value="'. $item->code .'" '.$selected.' >'. $item->location->address .'</option>' ;
                                        }#END FOREACH
                                        ?>

                                        <select data-placeholder="Choose a country..." onchange="Plg_script_vmsdek.onOfficeChange(this)" name="<?= $_nameSelectPickup ?>" class="chosen-select">
                                            <?= implode( '' , $optionArr ) ?>
                                        </select>
                                        <input type="hidden" name="<?= $_nameHiddenOfficeId ?>" value="" />
                                        <input type="hidden" name="vm_sdek[pickups_name]" value="" />
                                        <!---->

                                        <!---->
                                    </div>

                            </div>
                        </rz-checkout-delivery-dropdown-pickups>
                        <div _ngcontent-rz-client-c215="" class="delivery-pickups__info ng-star-inserted">
                            <dl _ngcontent-rz-client-c215="" class="delivery-pickups__schedule">
                                <!---->
                            </dl>
                            <!--<button _ngcontent-rz-client-c215="" type="button"
                                    class="button button--link delivery-pickups__map">
                                <span _ngcontent-rz-client-c215=""
                                      class="button button--medium button--link button--icon delivery-pickups__map-text">
                                    <svg  _ngcontent-rz-client-c215="" width="16" height="16">
                                        <use _ngcontent-rz-client-c215="" href="#icon-map-marker"></use>
                                    </svg>
                                    Карта
                                </span>
                                <span _ngcontent-rz-client-c215="" class="delivery-pickups__map-frame">
                                    <svg _ngcontent-rz-client-c215="" width="16" height="16">
                                        <use _ngcontent-rz-client-c215="" href="#icon-link-out"></use>
                                    </svg>
                                </span>
                            </button>-->
                        </div>
                        <!---->
                        <!---->
                    </div>
                    <!---->
                    <!---->
                </rz-checkout-delivery-pickup-content>
                <!---->
                <div _ngcontent-rz-client-c217="" class="interval-not-allowed-wrap ng-star-inserted">
                    <!---->
                </div>
                <!---->
                <!---->
                <!---->
                <!---->
            </div>
            <!---->
        </div>
        <!---->
        <!---->
        <!---->
        <!---->
    </li>
    <!-- Доставка к Двери -->
    <li class="checkout-variant <?= ($delivery_type != $sdek_delivery_mode_courier?:'active"')  ?> ">
        <div _ngcontent-rz-client-c210="" class="checkout-variant__inner checkout-variant__inner--selected">
            <!-- Radio - Доставка DOOR -->
            <div _ngcontent-rz-client-c210="" class="checkout-variant__radio">
                <input _ngcontent-rz-client-c210=""
                       type="radio"
                       data-evt="on_change_delivery_type"
                       name="vm_sdek[delivery_type]"
                    <?= ($delivery_type != $sdek_delivery_mode_courier?:'checked="checked"')  ?>
                       value="<?= $sdek_delivery_mode_courier ?>">
                <label _ngcontent-rz-client-c210="" class="checkout-variant__label">
                    <span _ngcontent-rz-client-c210="" class="checkout-variant__body">
                        <span _ngcontent-rz-client-c210="" class="checkout-variant__title">
                            Доставка курьером
                            <!---->
                            <!---->
                        </span>
                        <span _ngcontent-rz-client-c210="" class="checkout-variant__price ng-star-inserted">
                            <rz-checkout-delivery-price _ngcontent-rz-client-c210="" class="ng-star-inserted">
                                по тарифам перевозчика
                                <!---->
                                <!---->
                                <!---->
                                <!---->
                                <!---->
                            </rz-checkout-delivery-price>
                            <!---->
                            <!---->
                        </span>
                        <!---->
                    </span>
                </label>
            </div>

            <div _ngcontent-rz-client-c210="" class="checkout-variant__content ng-star-inserted">
                <!---->
                <rz-checkout-delivery-pickup-content _ngcontent-rz-client-c217="" _nghost-rz-client-c215=""
                                                     class="ng-star-inserted">
                    <div _ngcontent-rz-client-c215="" class="delivery-pickups">
                        <rz-checkout-delivery-dropdown-pickups _ngcontent-rz-client-c215="" _nghost-rz-client-c212=""
                                                               class="ng-star-inserted">
                            <div _ngcontent-rz-client-c212="" class="dropdown-pickups">

                                <div _ngcontent-rz-client-c211="" class="autocomplete">

                                    <!--  ПОЛЯ ДЛЯ ПОЛУЧАТЕЛЯ -->
                                    <div class="vmsdk-mode_courier" id="vmsdk-address_house" style="">
                                        <label>
                                            <span class="label_sdek">Улица</span>
                                            <input type="text"
                                                   id="vm_sdek_street"
                                                   name="vm_sdek[address_house][street]"
                                            value="<?= $street ?>"/>
                                        </label>
                                        <label class="house_sdek">
                                            <span class="label_sdek">Дом</span>
                                            <input type="text"
                                                   id="vm_sdek_house"
                                                   name="vm_sdek[address_house][house]"
                                                   value="<?= $house ?>" />
                                        </label>
                                        <label>
                                            <span class="label_sdek">Квартира</span>
                                            <input type="text" id="vm_sdek_flat"
                                                   name="vm_sdek[address_house][flat]"
                                                   value="<?= $flat ?>"/>
                                        </label>
                                    </div>




                                    <!-- -->
                                </div>

                            </div>
                        </rz-checkout-delivery-dropdown-pickups>
                        <div _ngcontent-rz-client-c215="" class="delivery-pickups__info ng-star-inserted">
                            <dl _ngcontent-rz-client-c215="" class="delivery-pickups__schedule">
                                <!---->
                            </dl>
                            <!--<button _ngcontent-rz-client-c215="" type="button"
                                    class="button button--link delivery-pickups__map">
                                <span _ngcontent-rz-client-c215=""
                                      class="button button--medium button--link button--icon delivery-pickups__map-text">
                                    <svg  _ngcontent-rz-client-c215="" width="16" height="16">
                                        <use _ngcontent-rz-client-c215="" href="#icon-map-marker"></use>
                                    </svg>
                                    Карта
                                </span>
                                <span _ngcontent-rz-client-c215="" class="delivery-pickups__map-frame">
                                    <svg _ngcontent-rz-client-c215="" width="16" height="16">
                                        <use _ngcontent-rz-client-c215="" href="#icon-link-out"></use>
                                    </svg>
                                </span>
                            </button>-->
                        </div>
                        <!---->
                        <!---->
                    </div>
                    <!---->
                    <!---->
                </rz-checkout-delivery-pickup-content>
                <!---->
                <div _ngcontent-rz-client-c217="" class="interval-not-allowed-wrap ng-star-inserted">
                    <!---->
                </div>
                <!---->
                <!---->
                <!---->
                <!---->
            </div>
            <!---->
        </div>
    </li>
</ul>


