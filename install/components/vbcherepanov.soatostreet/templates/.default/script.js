BX.namespace("BX.Soato.StreetComponent");
(function () {
    'use strict';
    BX.Soato.StreetComponent = {
        params: {},
        param: {},
        url: {},
        popupID: false,
        popupHeader: false,
        popupContent: false,
        message: {},
        time1:0,
        time2:0,
        default:true,

        init: function (arResult, param) {
            this.params = {
                param: param,
                input: BX(arResult.input),
                streetList: BX(arResult.streetList),
                streetCode: BX(arResult.streetCode),
                soato: BX(arResult.StreetSoato),
                message: arResult.MESSAGE,
                cityCode:'',
            };
            this.initInput();
            BX.addCustomEvent(window, "OnChangeCitySoato", BX.proxy(this.changeCitySoato, this));
        },
        changeCitySoato:function(citycode){
            this.params.cityCode = citycode.cityCode;
        },
        initInput: function () {
            BX.bind(this.params.input, 'keyup',  BX.proxy(this.change, this));
        },

        change: function () {
            var d={
                val:{
                    query:this.params.input.value,
                    city:this.params.cityCode,
                    site_id:BX.message('SITE_ID'),
                }
            };
            var _this=this;
            BX.ajax.runComponentAction("vbcherepanov:vbcherepanov.soatostreet", "getListenerStreet", {
                mode: 'class',
                data: d,
                signedParameters: this.params.param.signedParameters
            }).then(function (response) {
                if (response.data.DATA == 1) {
                    if(response.data.ERROR == ""){
                        BX.clean(_this.params.streetList);
                        var list = [];

                        for (var i = 0; i < response.data.STREET.length; i++) {
                            list.push(
                                BX.create('LI', {
                                    attrs: {
                                        'data-soato': response.data.STREET[i].SOATO,
                                        'data-code': response.data.STREET[i].CODE
                                    },
                                    html: response.data.STREET[i].NAME,
                                    events: {click: BX.proxy(_this.selectStreet, _this)}
                                })
                            );
                        }
                        let ul = BX.create('UL', {children: list});
                        _this.params.streetList.appendChild(ul);
                    }else {
                        BX.clean(_this.params.streetList);
                    }
                }else {
                    BX.clean(_this.params.streetList);
                }
            });
        },
        selectStreet:function(){
           var current = BX.proxy_context;
           this.params.input.value = current.innerHTML;
           this.params.streetCode.value = current.getAttribute('data-code');
           this.params.soato.value = current.getAttribute('data-soato');
           BX.clean(this.params.streetList);
        }
    };
})();