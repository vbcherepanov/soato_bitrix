BX.namespace("BX.Soato.CityComponent");
(function () {
    'use strict';
    BX.Soato.CityComponent = {
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
                cityList: BX(arResult.cityList),
                cityCode: BX(arResult.cityCode),
                soato: BX(arResult.Soato),
                message: arResult.MESSAGE,
            };
            this.initInput();
        },

        initInput: function () {
            console.log(this);
            BX.bind(this.params.input, 'keyup',  BX.proxy(this.change, this));
        },

        change: function () {
            var d={
                val:{
                    query:this.params.input.value,
                    site_id:BX.message('SITE_ID'),
                }
            };
            var _this=this;
            BX.ajax.runComponentAction("vbcherepanov:vbcherepanov.soatocity", "getListenerCity", {
                mode: 'class',
                data: d,
                signedParameters: this.params.param.signedParameters
            }).then(function (response) {
                if (response.data.DATA == 1) {
                    if(response.data.ERROR == ""){
                        BX.clean(_this.params.cityList);
                        var list = [];

                        for (var i = 0; i < response.data.CITY.length; i++) {
                            list.push(
                                BX.create('LI', {
                                    attrs: {
                                        'data-soato': response.data.CITY[i].SOATO,
                                        'data-code': response.data.CITY[i].CODE
                                    },
                                    html: response.data.CITY[i].NAME,
                                    events: {click: BX.proxy(_this.selectCity, _this)}
                                })
                            );
                        }
                        let ul = BX.create('UL', {children: list});
                        _this.params.cityList.appendChild(ul);
                    }else {
                        BX.clean(_this.params.cityList);
                    }
                }else {
                    BX.clean(_this.params.cityList);
                }
            });
        },
        selectCity:function(){
           var current = BX.proxy_context;
           this.params.input.value = current.innerHTML;
           this.params.cityCode.value = current.getAttribute('data-code');
            this.params.soato.value = current.getAttribute('data-soato');
           BX.clean(this.params.cityList);
            let eventData = {
                cityCode: current.getAttribute('data-code'),
            };
            BX.onCustomEvent('OnChangeCitySoato', [eventData]);
        }
    };
})();