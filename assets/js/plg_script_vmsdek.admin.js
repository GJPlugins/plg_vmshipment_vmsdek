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
/* global jQuery , Joomla   */
window.plg_script_vmsdekAdmin = function () {
    var $ = jQuery;
    var self = this;
    this.$selectElement = $('select#params_sender_office')
    this.$inputCity = $('#params_sender_city');
    /**
     * Start Init
     * @constructor
     */
    this.Init = function () {

        this.addEvtListener();
        this._addEvtListenerOfficeChange()
        this.initFormCity();
        this.loadPickupOffice();
    };
    /**
     * Добавить слушателей событий
     * @private
     */
    this._addEvtListenerOfficeChange = function (){
        /**
         * Изменение офиса отправления
         */
        $('select#params_sender_office').on('change', function(evt, params) {
            self.onOfficeChange(evt, params);
        });


    }
    /**
     * Обработка события - "Изменение офиса отправления"
     * @param evt
     */
    this.onOfficeChange = function (evt ){
        var idOffice = $(evt.target).val();
        $('input#params_sender_office_id').val( idOffice )
        console.log( 'plg_script_vmsdek.admin' , idOffice );

    }
    /**
     * Init поля выбора города
     * ---
     */
    this.initFormCity = function (){
        self.$inputCity.autocomplete({
            // appendTo: ".autocomplete__list" ,
            source: function(request,response) {
                jQuery.ajax({
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
     * После выбора в списке autocomplete или клик по популярным городам
     * устанавливаем данные в форму !
     * @param item
     */
    this.setDataSelectCity = function (item){

        // ID Города
        $('#params_sender_city_id').val(item.id);
        self.$inputCity.val(item.value)
        self.loadPickupOffice();

    }
    this.loadPickupOffice = function (){

        var Data = JSON.parse(JSON.stringify( self.AjaxDefaultData ));
        Data.city_id = $('#params_sender_city_id').val() ;
        Data.helper = '\\Vmsdek\\SdekHelper' ;
        Data.methodId = this._params.virtuemart_shipmentmethod_id;
        Data.loginApi = $('#params_sdek_api_login').val();
        Data.passApi = $('#params_sdek_api_pass').val();
        Data.task = 'getPickupsCity' ;

        console.log( 'plg_script_vmsdek.admin' , Data.loginApi.length );

        if (!Data.loginApi.length || !Data.passApi.length || !Data.city_id.length   ){
            return ;
        }

        self.AjaxPost( Data ).then(function (r){
            var officeId =  $('#params_sender_office_id').val()
            if ( !officeId.length ){
                // Noty Render Messages
                self.renderMessages(r.messages)
            }

            self.setOfficeList( r.data.items );
        },function (err){console.log( 'plg_script_vmsdek' , err );})

    }
    this.setOfficeList = function (PickupPoints){
        var checkBool ;
        var office_id = $('#params_sender_office_id').val() ;
        var addOptionElement
        var $placeHolder = $('<option />' , {
            value: 0 ,
            text : 'Выбрать пункт отправления'
        })

        self.$selectElement.empty()
        self.$selectElement.append( $placeHolder );
        for (const key in PickupPoints) {
            // checkBool = city_id === PickupPoints[key].code ? 'selected' : ''  ;

            addOptionElement = $('<option />' , {
                value: PickupPoints[key].code ,
                text : PickupPoints[key].location.address,
                // selected : checkBool ,
            })


            if ( office_id === PickupPoints[key].code ){

                addOptionElement.attr('selected' , 'selected' )
                console.log( 'plg_script_vmsdek.admin' , addOptionElement  );
            }

            
            self.$selectElement.append( addOptionElement );
        }
        // Version Old
        self.$selectElement.trigger("liszt:updated");
        // Version 1.8.7 Latest
        self.$selectElement.trigger("chosen:updated");

        

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
        window.plg_script_vmsdekAdmin.prototype = new window.plg_Vmshipment_Vmsdek_Admin_Core();
        window.plgScriptVmSdekAdmin = new window.plg_script_vmsdekAdmin();
    }
})()
















