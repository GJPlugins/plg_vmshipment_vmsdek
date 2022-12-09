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
 * @date       27.11.22 19:25
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

?>
<div _ngcontent-rz-client-c46="" cdktrapfocus="" cdktrapfocusautocapture=""
     class="modal__holder modal__holder_show_animation modal__holder_size_medium">
    <div _ngcontent-rz-client-c46="" class="modal__header"><h3 _ngcontent-rz-client-c46="" class="modal__heading">
            Выберите свой город</h3>
        <button _ngcontent-rz-client-c46="" type="button" cdkfocusinitial="" class="modal__close"
                aria-label="Закрыть модальное окно">
            <svg _ngcontent-rz-client-c46="" pointer-events="none">
                <use _ngcontent-rz-client-c46="" href="#icon-close-modal"></use>
            </svg>
        </button>
    </div>
    <div _ngcontent-rz-client-c46="" class="modal__content">
        <rz-modal class="ng-star-inserted">
            <common-city _ngcontent-rz-client-c247="" _nghost-rz-client-c89="" class="ng-star-inserted">
                <p _ngcontent-rz-client-c89="" class="header-location__intro ng-star-inserted">
                    <svg _ngcontent-rz-client-c89="" width="24" height="24">
                        <use _ngcontent-rz-client-c89="" xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="#icon-delivery-self"></use>
                    </svg>
                    Доставляем заказы по всей России!
                </p>
                <!---->
                <ul _ngcontent-rz-client-c89="" class="header-location__popular ng-star-inserted">
                    <?=  $this->sublayout('header-location__popular' , [] ); ?>

                    <!---->
                </ul>
                <form _ngcontent-rz-client-c89="" novalidate="" action=""
                      class="header-location__search ng-untouched ng-pristine ng-valid ng-star-inserted">
                    <fieldset _ngcontent-rz-client-c89="" class="form__row">
                        <label _ngcontent-rz-client-c89="" for="cityinput" class="form__label">
                            Введите населенный пункт России
                        </label>
                        <auto-complete _ngcontent-rz-client-c89="" id="cityinput" class="header-location__search-input"
                                       _nghost-rz-client-c88="">
                            <div _ngcontent-rz-client-c88="" class="autocomplete">
                                <input _ngcontent-rz-client-c88="" type="text" autocomplete="off"
                                       name="search" _size_medium=""
                                       class="autocomplete__input ng-untouched ng-pristine ng-valid"
                                       placeholder="">
                                <div class="autocomplete__list dialog">
                                    <!---->
                                    <!---->
                                    <!---->
                                </div>
                                <!---->
                            </div>
                        </auto-complete>

                    </fieldset>
                    <!---->
                    <p _ngcontent-rz-client-c89="" class="header-location__search-example ng-star-inserted">
                        Например,
                        <a _ngcontent-rz-client-c89="" class="link-dotted"> Котюжины </a>
                    </p>
                    <!---->
                </form>
                <!---->
                <!---->
                <fieldset _ngcontent-rz-client-c89="">
                    <div _ngcontent-rz-client-c89="" class="header-location__footer">
                        <a _ngcontent-rz-client-c89="" apprzroute="" class="button button_size_medium button_color_gray"
                           href="<?= \Joomla\CMS\Uri\Uri::root()?>">
                            Перейти на главную страницу
                        </a>
                        <button _ngcontent-rz-client-c89="" data-evt="vmsdek.city_apply"
                                class="button button_size_medium button_color_green" disabled>
                            Применить
                        </button>
                    </div>
                </fieldset>

                <p _ngcontent-rz-client-c89="" class="header-location__caption">
                    Выбор города поможет предоставить
                    актуальную информацию о наличии товара, его цены и способов доставки в вашем городе! Это поможет
                    сохранить больше свободного времени для вас!
                </p>
            </common-city>
            <!---->
        </rz-modal>
        <!---->
    </div>
</div>

