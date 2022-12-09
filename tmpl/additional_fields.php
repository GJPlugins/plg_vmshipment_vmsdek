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
/**
 * @var plgVmshipmentVmsdek $this
 * @var array  $viewData
 * @var array $userState - Данные пользователя из User State
 * @var string $_extensionVersion Версия плагина (vmshipment | vmpayment)
 * @var string $element Название плагина ()
 * @var string $_type == vmshipment | vmpayment
 * @var string $method_name - Название метода доставки
 * @var string $description - Описание для метода (vmshipment | vmpayment)
 * @var string $html_logos - Html logo для метода (vmshipment | vmpayment)
 */
empty($viewData)?:extract($viewData);

$layoutDeliveryPickups = new \Joomla\CMS\Layout\FileLayout('additional_fields.delivery-pickups');
$layoutDeliveryPickups->addIncludePaths(JPATH_PLUGINS . '/vmshipment/vmsdek/tmpl');


/**
 * Макет для вывода дополнительных полей (Доставка|Оплата)
 */
?>
<!-- START additional_fields.php -->
<div id="plg_<?= $_type ?>"
     class="additional_fields plg_<?= $element ?>" style="box-sizing: border-box;">
    <!-- BUTTON Выбор города -->
    <button _ngcontent-rz-client-c247="" data-evt="city-select-form" type="button"
            class="button--with-icon button--white deliveries__city ng-star-inserted">
        <span _ngcontent-rz-client-c247="" class="deliveries__city-inner">
		    <svg _ngcontent-rz-client-c247="" aria-hidden="true" class="deliveries__city-marker">
			    <use _ngcontent-rz-client-c247="" href="#icon-map-marker"></use>
		    </svg>
            <?php
//            echo'<pre>';print_r( $userState  );echo'</pre>'.__FILE__.' '.__LINE__;
            ?>
		    <span _ngcontent-rz-client-c247="" class="deliveries__city-title">
			    <span _ngcontent-rz-client-c247="" class="deliveries__city-label"> Ваш город </span>
			    <span _ngcontent-rz-client-c247="" class="deliveries__city-name">
                    <?= ( !isset($userState['city_name'])?'Выбрать город доставки':$userState['city_name'] )?>
                </span>
			    <span _ngcontent-rz-client-c247=""
                      class="deliveries__city-label <?= ( isset($userState['region_name']) ?:'hidden' )?> ">
                    <?= ( !isset($userState['country_name']) ?: $userState['country_name'] . ' ' ) ?>
                    <?= ( !isset($userState['region_name']) ?:$userState['region_name'] )?>

                </span>
		    </span>
		    <svg _ngcontent-rz-client-c247="" aria-hidden="true" class="deliveries__city-chevron">
			    <use _ngcontent-rz-client-c247="" href="#icon-chevron-down"></use>
		    </svg>
	    </span>
    </button>
    <!-- delivery-pickups -->
    <?= $layoutDeliveryPickups->render( $viewData ); ?>

        
    <?php
//    echo'<pre>';print_r( $userState );echo'</pre>'.__FILE__.' '.__LINE__;

    ?>

    <input type="hidden" name="vm_sdek[city_id]" value="<?= ( !isset($userState['city_id'])?'':$userState['city_id'] )?>" >
    <!-- Название города -->
    <input type="hidden" name="vm_sdek[city_name]" value="<?= ( !isset($userState['city_name'])?'':$userState['city_name'] )?>" >
    <!-- Полное название : Город, Регион, Страна -->
    <input type="hidden" name="vm_sdek[city_value]" value="<?= ( !isset($userState['city_value']) ?'':$userState['city_value'] )?>" >
    <!-- Название региона -->
    <input type="hidden" name="vm_sdek[region_name]" value="<?= ( !isset($userState['region_name']) ?'':$userState['region_name'] )?>" >

    <input type="hidden" name="vm_sdek[country_name]" value="<?= ( !isset($userState['country_name']) ?'':$userState['country_name'] )?>" >
</div>
<!-- END additional_fields.php -->