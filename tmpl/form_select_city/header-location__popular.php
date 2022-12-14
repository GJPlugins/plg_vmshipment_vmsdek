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
 * @date       28.11.22 15:10
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

empty($viewData)?:extract($viewData);
$location__popular = [
	[
		'cityName'=> 'Москва',
        'city_id' => 44 ,
        'city_value' => 'Москва, Москва, Россия',
        'regionName' => 'Москва',
        'countryName' => 'Россия',
	],
	[
		'cityName'=> 'Санкт-Петербург',
		'city_id' => 137 ,
		'city_value' => 'Санкт-Петербург, Санкт-Петербург, Россия',
		'regionName' => 'Санкт-Петербург',
		'countryName' => 'Россия',
	],
	[
		'cityName'=> 'Калуга',
		'city_id' => 142 ,
		'city_value' => 'Калуга, Калужская область, Россия',
		'regionName' => 'Калужская область',
		'countryName' => 'Россия',
	],
	[
		'cityName'=> 'Ярославль',
		'city_id' => 146 ,
		'city_value' => 'Ярославль, Ярославская область, Россия',
		'regionName' => 'Ярославская область',
		'countryName' => 'Россия',
	],
	[
		'cityName'=> 'Тула',
		'city_id' => 150 ,
		'city_value' => 'Тула, Тульская область, Россия',
		'regionName' => 'Тульская область',
		'countryName' => 'Россия',
	],
	[
		'cityName'=> 'Псков',
		'city_id' => 393 ,
		'city_value' => 'Псков, Псковская область, Россия',
		'regionName' => 'Псковская область',
		'countryName' => 'Россия',
	],
];
foreach ( $location__popular as $item )
{




    ?>
    <li _ngcontent-rz-client-c89=""

        class="header-location__popular-item ng-star-inserted">
        <a _ngcontent-rz-client-c89=""
           data-evt="vmsdek.location_popular"
           data-id="<?= $item['city_id'] ?>"
           data-city_name="<?= $item['cityName'] ?>"
           data-value="<?= $item['city_value'] ?>"
           data-region_name="<?= $item['regionName'] ?>"
           data-country_name="<?= $item['countryName'] ?>"
           class="header-location__popular-link">
            <?= $item['cityName'] ?>
        </a>
    </li>
    <?php
}#END FOREACH

?>


