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
 * @date 27.11.22 15:27
 * Created by PhpStorm.
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 **********************************************************************************************************************/
/* global jQuery , Joomla , callAfterConfirmed  */

window.plg_script_vmsdek = function () {
    var r = {data : {updatesCosts : undefined}}
    var $ = jQuery;
    var self = this;
    /**
     * Экземпляр модального окна с формой выбора города
     */
    this.ModalFormCitySelect = {} ;
    /**
     * Селектор для ввода названия города в модальном окне - Autocomplete
     * ---
     * @type {*|jQuery|HTMLElement}
     */
    self.$inputCity  = {} ;
    /**
     * ID - Пункта получения
     * ---
     * @type {*|jQuery|HTMLElement}
     */
    this.$InputOffice_id = $('input[name="'+ self._params._nameHiddenOfficeId +'"]')
    /**
     * Запомнить полное название города из предыдущего выбора перед его сменой
     * || Тула, Тульская область, Россия
     *
     * @type {string}
     */
    this.oldSelectCity = ''
    /**
     * Триггер для загрузки складов - после закрытия окна с формой выбора города
     * + Если TRUE - Нужно загружать склады
     * @type {boolean}
     */
    this.triggerUpdateOffices = false ;



    /**
     * Start Init
     * @constructor
     */
    this.Init = function () {

        this.addEvtListener();
        this.addChosenSelect();

        // $('#address_1_field').val('Chevchenko 226 - 44')
        // $('#email_field').val('viclingvolive@gmail.com')



        console.log( 'plg_script_vmsdek Init' , this._params );

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

        $('form#adminForm').on('keyup' , 'input[name="vm_sdek[address_house][street]"]' , self._correct_address )
        .on('keyup' , 'input[name="vm_sdek[address_house][house]"]', self._correct_address )
        .on('keyup' , 'input[name="vm_sdek[address_house][flat]"]' , self._correct_address )

        /**
         * Изменение офиса отправления
         */
        $('select[name="'+self._params._nameSelectPickup+'"]').on('change', function(evt, params) {

            self.onOfficeChange(evt, params);
        });



        // Event - change
        document.addEventListener('change', function (e) {
            console.log('plg_vmshipment_vmsdek.core EVT change', e.target );

            // изменение плагина доставки
            if (e.target.name === 'virtuemart_shipmentmethod_id' && e.target.value === self._params.virtuemart_method_id ){
                self.onCheckShipMethodVMSdek( e.target );

            }

            switch (e.target.dataset.evt) {
                // изменение - типа доставки - ПВЗ | Курьер
                case "on_change_delivery_type" :
                    self.onChangeDeliveryType( e.target );

                    break;
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
            // console.log( 'plg_script_vmsdek' , e.target.dataset );

            switch (e.target.dataset.evt) {
                case "city-select-form" :
                    self.getCitySelectForm();
                    break;
                //    Кнопка преминить в окне выбора городов
                case "vmsdek.city_apply" :
                    self.CityApply()
                    break;
                case "vmsdek.location_popular" :
                    self.setLocationPopular(e.target)
                    break;
            }
        });
        // Event - keyup 
        document.addEventListener("keyup", function (e) {
            if ($(e.target).hasClass('translite')) {
            }
        });
    };
    /**
     * EVENT - Изменение плагина доставки
     */
    this.onCheckShipMethodVMSdek = function (){
        var city_id = $('input[name="vm_sdek[city_id]"]').val()
        if (city_id.length){
            self.setUserState();
        }
        console.log( 'plg_script_vmsdek::onCheckShipMethodVMSdek' , city_id );
         
    }
    /**
     * Изменение - типа доставки - ПВЗ | Курьер
     * @param target
     */
    this.onChangeDeliveryType = function (target){
        var $inputsDeliveryType = $('input[name="vm_sdek[delivery_type]"]')
        $inputsDeliveryType.each(function (i,a) {
            var _classLi = 'active'
            if ( a.checked ) {
                // console.log('plg_script_vmsdek::onChangeDeliveryType', "Checkbox is checked..");
                $(a).closest('li.checkout-variant').addClass(_classLi)
            } else {
                $(a).closest('li.checkout-variant').removeClass(_classLi)
                // console.log('plg_script_vmsdek::onChangeDeliveryType', "Checkbox is not checked..");
            }

        })
        self.setUserState();

    }
    /**
     * Event - Change Office получателя
     * @param evt
     */
    this.onOfficeChange = function (element){
        var idOffice = $(element).val();
        var address = $(element).find('option:selected').text();
        console.log( 'plg_script_vmsdek::onOfficeChange' , idOffice );
        console.log( 'plg_script_vmsdek::onOfficeChange' , address );


        self.$InputOffice_id.val(idOffice);
        $('input[name="vm_sdek[pickups_name]"]').val( address )

        self.setUserState();

        
        // self.setUserState( 'self::onOfficeChange' );
    }
    /**
     * Event Modal - Клик по популярным регионам
     * @param target
     */
    this.setLocationPopular = function (target){
        self.setDataSelectCity( target.dataset )
    };
    /**
     * Event Modal - кнопка "ПРИМЕНИТЬ" - в окне выбора городов
     * @constructor
     */
    this.CityApply = function (){

        // Закрыть модальное окно
        this.ModalFormCitySelect.close();
    }
    /**
     * Загрузить список офисов для указанного города
     */
    this.loadOfficeInCity = function () {
        var officeId = $('input[name="'+ self._params._nameHiddenOfficeId+'"]').val()
        var Data = JSON.parse(JSON.stringify( self.AjaxDefaultData ));
        Data.city_id = $('[name="vm_sdek[city_id]"]').val() ;
        Data.task = 'getPickupsCity' ;
        self.AjaxPost( Data ).then(function (r){
            // если input officeId пустое - склад еще не выбирался ни разу - показываем приглашение выбрать склад
            if ( !officeId.length ){
                // Noty Render Messages
                self.renderMessages(r.messages)
            }
            self.setUserState( 'self::loadOfficeInCity' );
            self.setOfficeList( r.data.items );
        },function (err){console.log( 'plg_script_vmsdek' , err );})
    }
    /**
     * Устанавливаем загруженные отделения для получения
     * @param PickupPoints
     */
    this.setOfficeList = function (PickupPoints){
        var $selectElement = $('select[name="'+self._params._nameSelectPickup+'"]');

        var $placeHolder = $('<option />' , {
            value: 0 ,
            text : 'Выбрать пункт получения'
        })

        $selectElement
            .empty()
            .append( $placeHolder )
        var addOptionElement
        for (const key in PickupPoints) {
            addOptionElement = $('<option />' , {
                value: PickupPoints[key].code ,
                text : PickupPoints[key].location.address
            });
            $selectElement.append( addOptionElement );
        }
        $selectElement.trigger("chosen:updated");
    }
    /**
     * Загрузить формы выбора города
     */
    this.getCitySelectForm = function () {
        const Data = JSON.parse(JSON.stringify(self.AjaxDefaultData));
        Data.helper = '\\Vmsdek\\SdekHelper';
        Data.task = 'getCitySelectForm';
        self.AjaxPost(Data, {}).then(function (r) {
            self.createModal(r.data.formHtml , 'CitySelectForm');
        });
    }
    /**
     * Создать модальное окно для формы
     * @param html
     * @param baseClassModal префикс класса модального окна
     */
    this.createModal = function (html , baseClassModal ) {
        self.__loadModul.Fancybox().then(function (Modal) {
            self.ModalFormCitySelect = Modal
            self.ModalFormCitySelect.open(html, {
                // Класс основного элемента
                baseClass: "Vmsdek-" + baseClassModal + " vmsdek-modal",
                // предотвращает закрытие при нажатии overlay fancybox(v3)
                clickSlide : false,
                // полностью отключить сенсорные жесты default : true
                touch: false,
                // Когда контент загружен и анимирован
                afterShow: function (instance, current) {
                    self.initFormCity()
                },
                // Прежде чем экземпляр пытается закрыть. Верните false, чтобы отменить закрытие.
                beforeClose: function () {
                    console.log( 'plg_script_vmsdek' , 'beforeClose function' );


                },
                // После того как экземпляр был закрыт
                afterClose: function () {
                    if ( self.triggerUpdateOffices ) {
                        self.triggerUpdateOffices = false ;

                        self.loadOfficeInCity() ;

                    }
                },
            })
        })
    }
    /**
     * Init формы выбора города в модальном окне
     * ---
     */
    this.initFormCity = function (){
        // Находим поле ввода города для установки Autocomplete
        self.$inputCity = $(self._params._nameInputCityModal__autocomplete);
        // Запоминаем - ID города перед его изменение
        var $vmSdekCityIdInput =   $('[name="vm_sdek[city_id]"]');
        var $vmSdekCityValueInput =  $('[name="vm_sdek[city_value]"]');
        var $buttonAplyCity = $('.header-location__footer button.button')
        // Полное название города
        self.oldSelectCity  = $vmSdekCityValueInput.val();



        if (self.oldSelectCity.length){
            // Если город раньше выбирался - вставляем в поле поиска города
            self.$inputCity.val( self.oldSelectCity )
            // Делаем активную кнопку "Применить"
            $buttonAplyCity.removeAttr('disabled');
        }

        self.$inputCity.autocomplete({
            appendTo: ".autocomplete__list" ,
            source: function(request,response) {
                $.ajax({
                    url: "https://api.cdek.ru/city/getListByTerm/jsonp.php?country_codes=RU&callback=xxxx",
                    dataType: "jsonp",
                    data: {
                        q: function () {
                            return self.$inputCity.val()
                        },
                        /*name_startsWith: function () {
                            return $inputCity.val()
                        }*/
                    },
                    success: function(data) {
                        if ( typeof data.geonames === "undefined" ) return ;
                        console.log( 'plg_script_vmsdek' , data.geonames );
                        var _geonames = []
                        for (let i = 0; i < data.geonames.length ; i++) {
                            // Только Россия
                            // if ( data.geonames[i].countryIso !== "RU" ) continue ;
                            _geonames.push( data.geonames[i] )   ;

                        }

                        response($.map( _geonames, function(item) {
                            return {
                                city_name : item.cityName , // "Санкт-Петербург"

                                country_id : item.countryId, // "1"
                                country_iso: item.countryIso, // "RU"
                                country_name: item.countryName, // "Россия"

                                id : item.id,   // 137 - ID - города
                                name : item.name, // "Санкт-Петербург, Санкт-Петербург, Россия" - полное название
                                region_id :  item.regionId , // "82" - ID - Области
                                region_name: item.regionName,

                                // То что отображается в списке подсказок
                                label:  item.name ,
                                // То что будет установлено в Input как значение
                                // value: item.cityName,
                                value: item.name,
                            }
                        }));


                    }
                });
            },
            minLength: 1,
            select: function(event,ui) {
                self.setDataSelectCity(ui.item)
            },
        })
    }
    /**
     * + После выбора в списке autocomplete OR клик по популярным городам || устанавливаем данные в форму !
     * ---
     * @param item Object - Данные Autocomplete ui.item
     */
    this.setDataSelectCity = function (item){
        // ID Города
        $('[name="vm_sdek[city_id]"]').val(item.id);
        // Скрытый Input с полным название города
        $('[name="vm_sdek[city_value]"]').val(item.value);
        // Название города
        $('[name="vm_sdek[city_name]"]').val(item.city_name);
        $('[name="vm_sdek[region_name]"]').val(item.region_name);
        $('[name="vm_sdek[country_name]"]').val(item.country_name);

        
        // подписать кнопку выбора города на странице корзины
        $('span.deliveries__city-name').text( item.city_name )
            .next()
            .text(item.country_name + ' ' + item.region_name)
            .removeClass('hidden');

        // Сделать активную кнопку применить
        $('.header-location__footer button.button').removeAttr('disabled');
        // Устанавливаем полное название населенного пункта в поле ввода города
        self.$inputCity.val(item.value);

        // Если город обновился - устанавливаем триггер для загрузки складов
        if ( item.value !== self.oldSelectCity ) self.triggerUpdateOffices = true ;

        self._correct_address( );
    }
    /**
     * Обновить стоимость доставки
     * @param updatesCosts
     */
    this.setDeliveryPrice = function (updatesCosts){
        var basePrice = 0 ;
        $(updatesCosts).each(function (i,a){
            var typeDeliveryId = a.delivery_type
            var $radioTypeDelivery = $('.select-delivery-variant').find('input[name="vm_sdek[delivery_type]"][value="'+typeDeliveryId+'"]');

            $radioTypeDelivery.closest('div.checkout-variant__radio')
                .find('span.checkout-variant__price')
                .text('Стоимость доставки: '+a.delivery_sum+' руб')

            if ($radioTypeDelivery.prop("checked")){
                basePrice = a.delivery_sum ;
            }
        });


        if (typeof Onepage !== "undefined"  ){
            var orderTotal = +$( 'input#shipment_id_0_0_order_total' ).val()

            var $opc_totalsElements = $( 'input[name="opc_totals"][id*="shipment_id_35_"]' )
            $opc_totalsElements.each(function (i,a){
                var attrId = $(a).attr('id');

                if ( attrId.match(/.+order_shipping$/) ){
                    $(a).val( basePrice )


                }
                if (attrId.match(/.+order_total$/)){
                    $(a).val( orderTotal + basePrice )
                    console.log( 'plg_script_vmsdek::' , orderTotal );
                    console.log( 'plg_script_vmsdek::' , basePrice );
                    console.log( 'plg_script_vmsdek::' , orderTotal + basePrice );
                    console.log( 'plg_script_vmsdek::setDeliveryPrice' , attrId );
                    console.log( 'plg_script_vmsdek::setDeliveryPrice' , a );

                }

            })

            Onepage.getTotals();
        }

        // <input type="hidden" name="opc_totals" id="shipment_id_35_10_order_shipping" value="888888888">
        // <input type="hidden" name="opc_totals" id="shipment_id_35_10_order_total" value="56565655656565">
        // Onepage.getTotals();

        // $( "input[name*='man']" )
        console.log( 'plg_script_vmsdek::setDeliveryPrice' , self._params.virtuemart_method_id );
        console.log( 'plg_script_vmsdek::setDeliveryPrice' , typeof Onepage);

        console.log( 'plg_script_vmsdek::setDeliveryPrice' , basePrice  );
    }
    /**
     * Сохраняем User State
     */
    this.setUserState = function (context){

        var $Form = $('input[name="virtuemart_shipmentmethod_id"]').closest('form')

        var Data = JSON.parse(JSON.stringify(self.AjaxDefaultData));
        Data.helper = '\\Vmsdek\\SdekHelper';
        Data.task = 'setUserStateFormAndGetPrice';
        Data.fieldNameSpace = 'vm_sdek';
        Data.method_id = self._params.virtuemart_method_id ;
        Data.formData = $Form.serialize();
        self.AjaxPost(Data, {}).then(function (r) {
            if (typeof r.data.updatesCosts !== "undefined" ){
                self.setDeliveryPrice( r.data.updatesCosts )
            }
             console.log( 'plg_script_vmsdek :: setUserState' , r );
        },
            function (err){console.log( 'plg_script_vmsdek :: setUserState' , err );});

        self._correct_address();
    }
    /**
     * Валидация данных VMSdek перед созданием заказа
     * @param event
     * @returns {boolean}
     */
    this.validateVmsdekForm = function( event ){
        if (!$(self._params.selectorInputElement).prop('checked')) return true ;

        var resultValidate = true ;

        var errorMessage = {
            error : [],
            notice : [],
        };
        var city_id = $('input[name="vm_sdek[city_id]"]').val();
        // Выбранные способ доставки - ПВЗ | Курьер
        var $checkTypeDelivery = $('input[name="vm_sdek[delivery_type]"]:checked');
        var idTypeDelivery = +$checkTypeDelivery.val()
        var pickupsValue = $('select[name="vm_sdek[pickups]"] option:selected').val()
        var address_houseStreet = $('input[name="vm_sdek[address_house][street]"]').val()
        var address_houseHouse = $('input[name="vm_sdek[address_house][house]"]').val()

        // проверить выбранный город
        if (!city_id.length){
            resultValidate = false ;
            errorMessage.error.push( 'Не выбран город для доставки "'+ self._params.method_name + '"' )     ;
        }
        // проверить тип доставки "Доставка в ПВЗ" или "Доставка курьером"
        if ( !$checkTypeDelivery[0] ){
            resultValidate = false ;
            errorMessage.error.push( 'Не выбран вариант доставки для "'+ self._params.method_name + '"' )     ;
            errorMessage.notice.push( 'Нужно выбрать "Доставка в ПВЗ" или "Доставка курьером"' )     ;
        }

        if ( idTypeDelivery === 4 && pickupsValue === '0' ){
            resultValidate = false ;
            errorMessage.error.push( 'Не выбран Пункт выдачи заказов для доставки "'+ self._params.method_name + '"' )     ;
        }

        if (idTypeDelivery === 3 && (!address_houseStreet.length || !address_houseHouse.length) ){
            resultValidate = false ;
            errorMessage.error.push( 'Не указан адрес получателя для доставки "'+ self._params.method_name + '"' )     ;
        }

        self.renderMessages(errorMessage)



        // Если валидация не прошла
        if ( !resultValidate ){
            $('#form_submitted').val(0)
            $('#checkout_loader').remove();
            return false ;
        }


        return true ;
    }
    /**
     * Установить в поле адрес покупателя
     * ---
     * @private
     */
    this._correct_address = function (  ){
        // Выбранные способ доставки - ПВЗ | Курьер
        var $checkTypeDelivery = $('input[name="vm_sdek[delivery_type]"]:checked');
        var idTypeDelivery = +$checkTypeDelivery.val();

        // Полное название города!
        var cityName = $('input[name="vm_sdek[city_value]"]').val()



        var pickups_text = '' ;
        var textField = '' ;
        switch (idTypeDelivery){
            case 3 :
                var street =  $('input[name="vm_sdek[address_house][street]"]').val();
                if ( street ) street = ' Курьером: ' + street ;

                var house = $('input[name="vm_sdek[address_house][house]"]').val();
                if (house) house = ' дом: '+ house

                var flat = $('input[name="vm_sdek[address_house][flat]"]').val();
                if (flat) flat = ' кв.: '+ flat
                textField = cityName + street + house + flat
                break ;
            default :

                var pickups_id =  $('select[name="vm_sdek[pickups]"] option:selected').val()
                console.log( 'plg_script_vmsdek::_correct_address' , pickups_id );
                
                if ( pickups_id !== "0" ){
                    pickups_text = 'ПВЗ: ' +  $('select[name="vm_sdek[pickups]"] option:selected').text()
                        + '(' + pickups_id + ')'
                }
                textField = cityName +' '+ pickups_text   ;
        }

        $('#address_1_field').val( textField );
    }

    /**
     * ---------------------------------------------------
     */
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
        window.plg_script_vmsdek.prototype = new window.plg_Vmshipment_Vmsdek_Core();
        window.Plg_script_vmsdek = new window.plg_script_vmsdek();
        /**
         * Поддержка компонента OnePage
         */
        if (typeof Onepage !== "undefined" && typeof callAfterConfirmed !== "undefined" ){
            callAfterConfirmed.push(  Plg_script_vmsdek.validateVmsdekForm )
        }
    }
})()
















