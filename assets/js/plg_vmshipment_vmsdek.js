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
 * @date 24.11.22 23:08
 * Created by PhpStorm.
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 **********************************************************************************************************************/
/* global jQuery , Joomla   */
window.plg_vmshipment_vmsdek = function () {
    var $ = jQuery;
    var self = this;
    // Домен сайта
    var host = Joomla.getOptions('GNZ11').Ajax.siteUrl;
    // Медиа версия
    var __v = '?rm=';

    this.__type = false;
    this.__plugin = false;
    this.__name = false;
    this._params = {

        __module: false,
        RecentlyViewed: false,
    };
    // Ajax default options
    this.AjaxDefaultData = {
        group: null,
        plugin: null,
        module: null,
        method: null,
        option: 'com_ajax',
        format: 'json',
        task: null,
    };
    // Default object parameters
    this.ParamsDefaultData = {
        // Медиа версия
        __v: '1.0.0',
        // Режим разработки
        development_on: false,
    }

    /**
     * Start Init
     * @constructor
     */
    this.Init = function () {
        this._params = Joomla.getOptions('plg_vmshipment_vmsdek', this.ParamsDefaultData);
        __v = self._params.development_on ? '' : '?v=' + self._params.__v;

        // Параметры Ajax Default
        this.setAjaxDefaultData();
        this.addEvtListener();
        // Перехват событий JoomlaSubmit 
        this.JoomlaSubmitInit();
    };
    /**
     * Добавить слушателей событий
     * Для элементов с событиями должен быть установлен атрибут data-evt=""
     * etc. -   <a data-evt="map-go">
     *              <span class="icon-database" aria-hidden="true"></span>
     *              Map-Go
     *          </a>
     */
    this.addEvtListener = function () {
        // Event - change
        document.addEventListener('change', function (e) {
            console.log('plg_vmshipment_vmsdek', e.target.dataset);
            switch (e.target.dataset.evt) {
                case "" :
                    if (e.target.checked) {
                        console.log('plg_vmshipment_vmsdek', "Checkbox is checked..");
                    } else {
                        console.log('plg_vmshipment_vmsdek', "Checkbox is not checked..");
                    }
                    break;
            }
        });
        // Event - click
        document.addEventListener('click', function (e) {
            console.log('plg_vmshipment_vmsdek', e.target.dataset.evt);
            switch (e.target.dataset.evt) {
                case "" :
                    break;
            }
        });
        // Event - keyup 
        document.addEventListener("keyup", function (e) {
            if ($(e.target).hasClass('translite')) {

            }
            console.log('com_customfilters.administrator.core', e.target);
        });
    }
    /**
     * Установка перехвата для событий Joomla.submitbutton
     * @constructor
     */
    this.JoomlaSubmitInit = function () {
        var JoomlaSubmitButtonClone = Joomla.submitbutton
        Joomla.submitbutton = function (task) {
            console.log('plg_vmshipment_vmsdek - JoomlaSubmitInit', task);
            switch (task) {
                case '':

                    break
                default :
                    JoomlaSubmitButtonClone(task)
            }
        };
    }
    /**
     * Отправить запрос
     * @param Data - отправляемые данные
     *      Клонировать объект AjaxDefaultData  ---
     *      var Data = JSON.parse(JSON.stringify( self.AjaxDefaultData ));
     *      - Если обращение к компоненту Joomla Должен содержать ---
     *      Data.task = 'taskName';
     *
     * @param Params - Array
     *          Params = {
     *             URL : this._params.URL,
     *             dataType : this._params.dataType , 
     *         }
     *         <?php
     *          $doc = \Joomla\CMS\Factory::getDocument();
     *          $opt = [
     *              // Медиа версия
     *              '__v' => '1.0.0',
     *                 // Режим разработки
     *              'development_on' => false,
     *              // URL - Сайта
     *              'URL' => JURI::root(),
     *              'dataType' => 'html' , - по умлчанию 'json'
     *          ];
     *          $doc->addScriptOptions('customfiltersAdminCore' , $opt );
     *         ?>
     * @returns {Promise}
     * @constructor
     */
    this.AjaxPost = function (Data, Params) {
        var data = $.extend(true, this.AjaxDefaultData, Data);
        return new Promise(function (resolve, reject) {
            self.getModul("Ajax").then(function (Ajax) {
                // Не обрабатывать сообщения
                Ajax.ReturnRespond = true;
                // Отправить запрос
                Ajax.send(data, 'plg_vmshipment_vmsdek', Params).then(function (r) {
                    resolve(r);
                }, function (err) {
                    console.error(err);
                    reject(err);
                })
            });
        });
    };
    /**
     * Параметры Ajax Default
     */
    this.setAjaxDefaultData = function () {
        if (typeof Joomla !== 'undefined') {
            this.AjaxDefaultData[1] = Joomla.getOptions('csrf.token', false);
        }
        this.AjaxDefaultData.group = this._params.__type;
        this.AjaxDefaultData.plugin = this._params.__name;
        this.AjaxDefaultData.module = this._params.__module;
        this._params.__name = this._params.__name || this._params.__module;
    }
    this.Init();
};
(function () {
    if (typeof window.GNZ11 === "undefined") {
        // Дожидаемся события GNZ11Loaded
        document.addEventListener('GNZ11Loaded', function (e) {
            start()
        }, false);
    } else {
        start()
    }

// Start prototype
    function start() {
        window.plg_vmshipment_vmsdek.prototype = new GNZ11();
        window.Plg_vmshipment_vmsdek = new window.plg_vmshipment_vmsdek();
    }
})()
















