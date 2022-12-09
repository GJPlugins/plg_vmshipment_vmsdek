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
 * @date 26.11.22 19:25
 * Created by PhpStorm.
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 **********************************************************************************************************************/
/* global jQuery , Joomla   */
window.plg_Vmshipment_Vmsdek_Core = function () {
    const $ = jQuery;
    const self = this;
    // Домен сайта
    const host = Joomla.getOptions('GNZ11').Ajax.siteUrl;
    // Ajax default options
    this.AjaxDefaultData = {
        group: 'vmshipment',
        plugin: 'vmsdek',
        method: null,
        option: 'com_ajax',
        format: 'json',
        task: null,
    };
    // Default object parameters
    this.ParamsDefaultData = {
        // Медиа версия
        _extensionVersion: '1.0.0',
        // plugin group
        _type: 'vmshipment',
        // plugin name
        _element: 'vmsdek',
        // Режим разработки
        development_on: false,
        // Название метода (Оплатs|Доставки)
        method_name: '',
    }
    this._params = {
        selectorInputElement : false ,
        virtuemart_method_id : 0 ,
    }
    /**
     * Start Init
     * @constructor
     */
    this.Init = function () {
        this._params = Joomla.getOptions('Vmshipment.Vmsdek', this.ParamsDefaultData);
        // В параметры запроса добавить method Id
        this.AjaxDefaultData.methodId = this._params.virtuemart_method_id ;

        // Добавить слушателей событий
        this.addEvtListener();
        // Перехват событий JoomlaSubmit 
        this.JoomlaSubmitInit();

        this.LoadScriptElement();


        console.log( 'plg_vmshipment_vmsdek.core' , this._params );
        
        // тестирования связи с сервером PlgVmshipmentVmsdekCore.testAjax()
        // для запуска из консоли 
        // this.testAjax();
    }
    this.addChosenSelect = function (){
        self.load.js('/plugins/vmshipment/vmsdek/assets/chosen/chosen.jquery.js').then(
            function (){
                /*$('select[name="pickups"]').chosen({disable_search_threshold: 10}).change(function(){
                    var id = $(this).val();
                    console.log( 'plg_vmshipment_vmsdek.core::' , id ); 

                });*/
            },
            function (err){console.log( 'plg_vmshipment_vmsdek.core::' , err );})
       /* setTimeout(function (){

        },5000)*/
    }

    /**
     * Дозагрузка файла скрипта plg_script_vmsdek
     * @constructor
     */
    this.LoadScriptElement = function () {
        self.load.js('/plugins/vmshipment/vmsdek/assets/js/plg_script_vmsdek.js?v='+this._params._extensionVersion );
    }
    /**
     * Метод тестирования связи с сервером
     * -----------------------------------
     * Метод тестирования можно запустить в консоли набрав PlgVmshipmentVmsdekCore.testAjax()
     */
    this.testAjax = function () {
        const Data = JSON.parse(JSON.stringify(self.AjaxDefaultData));
        Data.content = 'Тестирования связи с сервером';
        Data.task = 'testConnect';
        console.log('plg_vmshipment_vmsdek.core - Data', Data);
        self.AjaxPost(Data, {}).then(function (r) {
            // Noty Render Messages
            self.renderMessages(r.messages)
            // Стандартный вывод сообщений 
            // Joomla.renderMessages( r.messages )
            console.log('plg_vmshipment_vmsdek.core', r);
        }, function (err) {
            console.log('plg_vmshipment_vmsdek.core', err);
        })
    }
    /**
     * Добавить слушателей событий
     * Для элементов с событиями должен быть установлен атрибут data-evt=""
     * etc. -   <a data-evt="map-go">
     *              <span class="icon-database" aria-hidden="true"></span>
     *              Map-Go
     *          </a>
     */
    this.addEvtListener = function () {

        // Вешаем на все способы доставки слушателя "change"
        document.querySelectorAll('[name="virtuemart_shipmentmethod_id"]').forEach(item => {
            item.addEventListener('change', event => {
                if ( + event.target.value === + self._params.virtuemart_method_id ){
                    self.methodSelected(true);
                }else {
                    self.methodSelected(false);
                }
            })
        })

        // Event - change
        document.addEventListener('change', function (e) {
            console.log('plg_vmshipment_vmsdek.core', e.target.dataset);
            switch (e.target.dataset.evt) {
                case "" :
                    if (e.target.checked) {
                        console.log('plg_vmshipment_vmsdek.core', "Checkbox is checked..");
                    } else {
                        console.log('plg_vmshipment_vmsdek.core', "Checkbox is not checked..");
                    }
                    break;
            }
        });
        // Event - click
        document.addEventListener('click', function (e) {
            console.log('plg_vmshipment_vmsdek.core', e.target.dataset.evt);
            switch (e.target.dataset.evt) {
                case "" :
                    break;
            }
        });
        // Event - keyup 
        document.addEventListener("keyup", function (e) {
            if ($(e.target).hasClass('translite')) {

            }

        });
    }
    /**
     * Обработчик события - изменения способа (Доставка|Оплата)
     * @param checkedMethod TRUE - Если выбран -
     */
    this.methodSelected = function (checkedMethod){
        
    }
    /**
     * Установка перехвата для событий Joomla.submitbutton
     * @constructor
     */
    this.JoomlaSubmitInit = function () {
        var JoomlaSubmitButtonClone = Joomla.submitbutton
        Joomla.submitbutton = function (task) {
            console.log('plg_vmshipment_vmsdek.core - JoomlaSubmitInit', task);
            switch (task) {
                case '':

                    break
                default :
                    JoomlaSubmitButtonClone(task)
            }
        };
    }
    /**
     * Отправить Ajax запрос APP
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
     *          $doc->addScriptOptions('Vmshipment.Vmsdek' , $opt );
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
                Ajax.send(data, 'plg_vmshipment_vmsdek.core', Params).then(function (r) {
                    resolve(r);
                }, function (err) {
                    console.error(err);
                    reject(err);
                })
            });
        });
    };
    /**
     * Удалить все данные User State - Используется для отладки
     * Use: PlgVmshipmentVmsdekCore.cleanUserStateForm()
     */
    this.cleanUserStateForm = function (){
        const Data = JSON.parse(JSON.stringify(self.AjaxDefaultData));
        Data.helper = '\\Vmsdek\\Helper';
        Data.task = 'cleanUserStateForm';
        self.AjaxPost(Data, {}).then(function (r) {
            if (+self._params.debug_on === 1 ){
                self.renderMessages(r.messages)
            }

            console.log( 'plg_script_vmsdek :: setUserState' , self._params.debug_on );
            console.log( 'plg_script_vmsdek :: setUserState' , r );
        },function (err){console.log( 'plg_script_vmsdek :: setUserState' , err );});
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
        window.plg_Vmshipment_Vmsdek_Core.prototype = new GNZ11();
        window.PlgVmshipmentVmsdekCore = new window.plg_Vmshipment_Vmsdek_Core();
    }
})()