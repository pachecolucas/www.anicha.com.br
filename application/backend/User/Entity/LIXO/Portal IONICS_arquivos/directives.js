epanel.directive('efCpf', ['$filter', function($filter) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function(scope, element, attrs, ngModel) {
                // Aplica a máscara
                element.mask('000.000.000-00');
            }
        };
    }
]);

/**
 * Datepicker 1.3.0
 * http://bootstrap-datepicker.readthedocs.org/en/release/
 */
epanel.directive('efDate', ['$filter', function($filter) {

        return {
            restrict: 'A',
            require: '?ngModel',
            link: function(scope, element, attrs, ngModel) {

                var convertBrToUs = function(value) {
                    if (isValidDate2(value)) {
                        var comp = value.split('/');
                        var m = parseInt(comp[1], 10);
                        var d = parseInt(comp[0], 10);
                        var y = parseInt(comp[2], 10);
                        return y + "-" + ('0' + m).slice(-2) + "-" + ('0' + d).slice(-2);
                    } else {
                        return "INVÁLIDA";
                    }
                };

                var isValidDate2 = function(text) {
                    if (!text) {
                        return false;
                    }
                    console.log("isValidDate2 ?");
                    var comp = text.split('/');
                    var m = parseInt(comp[1], 10);
                    var d = parseInt(comp[0], 10);
                    var y = parseInt(comp[2], 10);
                    console.log("dia: " + d);
                    console.log("mês: " + m);
                    console.log("ano: " + y);
//                    if (y < 1999) {
//                        return false;
//                    }
                    var date = new Date(y, m - 1, d);
                    console.log(date);
                    if (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d) {
                        console.log("É válida!");
                        return true;
                    } else {
                        console.log("Não é válida!");
                        return false;
                    }
                };

                // Aplica a máscara
                element.mask("00/00/0000");

                // Aplica o Datepicker 1.3.0
                element.datepicker({
                    format: 'dd/mm/yyyy',
                    language: 'pt-BR',
                    autoclose: true,
                    startDate: "01/01/1900"
                }).on('changeDate', function(ev) {
                    // Para que ao mudar a data no model continue no formato yyyy-mm-dd
                    console.log("Mudou: ");
//                    console.log(element.val());
//                    handleChange();
                }).on('show', function(ev) {
                    // Para que ao abrir as opções venha o calendário correspondente à data exibida e não o dia de hoje
                    // ISSO NÃO ESTÁ FUNCIONANDO PORQUE O EVENTO É DISPARADO TODA VEZ QUE ABRE O CALENDÁRIO E NÃO APENAS NA INICIALIZAÇÃO
                    console.log(element.val());
//                    element.datepicker('setDate', element.val());
                }).on('hide', function(ev) {
                    // Na saída deve devolver o valor do model ao seu estado original (yyyy-mm-dd)
                    console.log("onHide");
                    handleChange();
                });

                // Pega a data que chegou do model (ex: 1984-12-20) e mostra bonitinha (ex: 20/12/1984)
                (ngModel.$render = function() {
//                    console.log("OIOIOI:"+ngModel.$viewValue);
//                    ngModel.$setViewValue(convertBrToUs(element.val()));
////                    console.log($filter('date')(ngModel.$viewValue, 'dd/MM/yyyy'));
                    var dataBr = $filter('date')(ngModel.$viewValue, 'dd/MM/yyyy');
                    console.log("MAGICA");
                    if (isValidDate2(dataBr)) {
                        console.log("É VÁLIDA E VAI SETAR");
                        element.val(dataBr);
                        handleChange(dataBr);
//                        console.log("VALOR NOVO: "+element.val());
////                        handleChange();
////                        console.log(convertBrToUs(magica));
//                        ngModel.$setViewValue(convertBrToUs(dataBr));
////                        element.datepicker('setDate', magica);
                    }
                })();

                function handleChange(dataBr) {
                    console.log("handleChange()");
                    console.log(element.val());
                    ngModel.$setViewValue(convertBrToUs(element.val()));
                    if (dataBr) {
                        element.datepicker('setDate', dataBr);
                        ngModel.$setViewValue(convertBrToUs(element.val()));
                    } else {
                        scope.$apply();
                    }
                }

                function handleChangeKeyUp() {
                    console.log('KEYUP');
                    handleChange();
                }
                function handleChangeBlur() {
                    console.log('BLUR');
                    handleChange();
                }

                element.bind('keyup', handleChangeKeyUp); // Troca enquanto estiver alterando
                element.bind('blur', handleChangeBlur); // Senão na hora de sair fode!

            }
        };
    }
]);

/**
 * Datepicker 1.3.0
 * http://bootstrap-datepicker.readthedocs.org/en/release/
 */
epanel.directive('efBirthDate', ['$filter', function($filter) {

        return {
            restrict: 'A',
            require: '?ngModel',
            link: function(scope, element, attrs, ngModel) {

                var convertBrToUs = function(value) {
                    if (isValidDate2(value)) {
                        var comp = value.split('/');
                        var m = parseInt(comp[1], 10);
                        var d = parseInt(comp[0], 10);
                        var y = parseInt(comp[2], 10);
                        return y + "-" + ('0' + m).slice(-2) + "-" + ('0' + d).slice(-2);
                    } else {
                        return "INVÁLIDA";
                    }
                };

                var isValidDate2 = function(text) {
                    if (!text) {
                        return false;
                    }
                    console.log("isValidDate2 ?");
                    var comp = text.split('/');
                    var m = parseInt(comp[1], 10);
                    var d = parseInt(comp[0], 10);
                    var y = parseInt(comp[2], 10);
                    console.log("dia: " + d);
                    console.log("mês: " + m);
                    console.log("ano: " + y);
//                    if (y < 1999) {
//                        return false;
//                    }
                    var date = new Date(y, m - 1, d);
                    console.log(date);
                    if (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d) {
                        console.log("É válida!");
                        return true;
                    } else {
                        console.log("Não é válida!");
                        return false;
                    }
                };

                // Aplica a máscara
                element.mask("00/00/0000");

                // Pega a data que chegou do model (ex: 1984-12-20) e mostra bonitinha (ex: 20/12/1984)
                (ngModel.$render = function() {
//                    console.log("OIOIOI:"+ngModel.$viewValue);
//                    ngModel.$setViewValue(convertBrToUs(element.val()));
////                    console.log($filter('date')(ngModel.$viewValue, 'dd/MM/yyyy'));
                    var dataBr = $filter('date')(ngModel.$viewValue, 'dd/MM/yyyy');
                    console.log("MAGICA");
                    if (isValidDate2(dataBr)) {
                        console.log("É VÁLIDA E VAI SETAR");
                        element.val(dataBr);
                        handleChange(dataBr);
//                        console.log("VALOR NOVO: "+element.val());
////                        handleChange();
////                        console.log(convertBrToUs(magica));
//                        ngModel.$setViewValue(convertBrToUs(dataBr));
////                        element.datepicker('setDate', magica);
                    }
                })();

                function handleChange(dataBr) {
                    console.log("handleChange()");
                    console.log(element.val());
                    ngModel.$setViewValue(convertBrToUs(element.val()));
                    if (dataBr) {
                        ngModel.$setViewValue(convertBrToUs(element.val()));
                    } else {
                        scope.$apply();
                    }
                }

                function handleChangeKeyUp() {
                    console.log('KEYUP');
                    handleChange();
                }
                function handleChangeBlur() {
                    console.log('BLUR');
                    handleChange();
                }

                element.bind('keyup', handleChangeKeyUp); // Troca enquanto estiver alterando
                element.bind('blur', handleChangeBlur); // Senão na hora de sair fode!

            }
        };
    }
]);

/*
 * Diretiva mágica linda pra caralho que deixa o número bonitinho.
 * A vida é mais linda com o efFloat funcionando!
 * O dia que isso não funcionar pode se matar.
 */
epanel.directive('efFloat', ['$filter', function($filter) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function(scope, element, attrs, ngModel) {
                element.maskMoney({thousands: '.', decimal: ','});
                (ngModel.$render = function() {
//               element.val($filter('number')(ngModel.$viewValue, 2));
                    element.val($filter('number')(ngModel.$viewValue, 2));
//               element.maskMoney({thousands: '.', decimal: ','});
                })();

                element.bind('keyup', handleChange);

                var convertBrToUs = function(value) {
                    return parseFloat($.parseNumber(value, {format: "#.###,00", locale: "br"}));
                };

                function handleChange() {
                    ngModel.$setViewValue(convertBrToUs(element.val()));
                    scope.$apply();
                }
                ;

            }
        };
    }
]);
//
//epanel.directive('efDate', function() {
//    return {
//        restrict: 'A',
//        require: 'ngModel',
//        link: function(scope, element, attrs, ngModel) {
//            element.bind('blur', updateModel);
//
//            function updateModel() {
//                console.log("updateModel():" + element.val());
//                ngModel.$setViewValue("11/12/2013");
//                scope.$apply();
//            }
//        }
//    };
//});

epanel.directive('efFocus', ['$timeout', '$parse', function($timeout, $parse) {
        return {
            //scope: true,   // optionally create a child scope
            link: function(scope, element, attrs) {
                $timeout(function() {
                    element.focus();
                });
            }
        };
    }
]);

epanel.directive('efTitle', [function() {
        return {
            //scope: true,   // optionally create a child scope
            link: function(scope, element, attrs) {
                element.tooltip({title: attrs.efTitle});
            }
        };
    }
]);

epanel.directive('efCrud', ['$timeout', 'EpanelHandleResponse', 'EpanelHandleBeforeSubmit', 'EpanelMessenger', 'EpanelLocale', 'ServiceFactory',
    function($timeout, EpanelHandleResponse, EpanelHandleBeforeSubmit, EpanelMessenger, EpanelLocale, ServiceFactory) {
        return {
            restrict: 'A',
            scope: {},
            link: function(scope, element, attrs) {

                var service = ServiceFactory.create(attrs.module, attrs.entity);
                scope.$parent.config = {
                    limit: parseInt(attrs.limit),
                    hasMore: false,
                    offset: 0,
                    quering: true,
                };

                var search = function(callbackSearch) {
                    console.log("efCrud::search(showMore)");
                    console.log(scope.$parent.config);
                    service.query({
                        q: scope.$parent.config.query,
                        order: scope.$parent.config.order,
                        desc: scope.$parent.config.desc,
                        limit: scope.$parent.config.limit,
                        offset: scope.$parent.config.offset
                    }, function(response) {
                        EpanelHandleResponse(null, response, scope, function() {
                            if (response.class === "Eliti_Response_Success_Objects") {
                                if (scope.showMoreCliked) {
                                    console.log("search::adicionando novos objetos retornados à lista original...");
                                    scope.$parent.config.hasMore = response.objects.length >= scope.$parent.config.limit;
                                    scope.$parent.objects = scope.$parent.objects.concat(response.objects);
                                } else {
                                    console.log("search::limpando lista e mostrando objetos retornados...");
                                    console.log(scope.$parent.objects);
                                    console.log(response.objects);
                                    scope.$parent.objects = response.objects;
                                    scope.$parent.config.hasMore = scope.$parent.objects.length >= scope.$parent.config.limit;
                                    console.log(scope.$parent.objects);
                                }
                            }
                        });

                        if (callbackSearch) {
                            callbackSearch();
                        }
                        scope.$parent.config.quering = false;
                    });
                };

                scope.$parent.reset = function() {
                    scope.$parent.config.offset = 0;
                    scope.$parent.objects = [];
                    search();
                };

                scope.$parent.searchOnType = function() {
                    scope.$parent.config.quering = true;
                    $timeout(function() {
                        // Mágica abaixo funcionando estranhamente.
                        // de o cabra digitar rapidamente 'asdf' ele vai procurar várias vezes por 'asdf'
                        // Mágica!!!! Pq isso funciona?? Não sei!
                        // Mas o resultado é que ele só faz a pesquisa se o cabra ficar, pelo menos, meio segundo sem digitar
                        if (scope.$parent.config.quering) {
                            console.log("ENTROU...");
//                console.log("Query: " + $scope.query);
                            scope.$parent.reset();
                        } else {
                            console.log("EVITOU ENTRAR...");
                        }
                    }, 500);
                };

                scope.$parent.showMore = function() {
                    scope.showMoreCliked = true;
                    scope.$parent.config.offset += scope.$parent.config.limit;
                    search(function() {
                        scope.showMoreCliked = false;
                    });
                };

                scope.$parent.isFiltering = function() {
                    return scope.$parent.config.query ? true : false;
                };

                scope.$parent.hasObjects = function() {
                    return scope.$parent.objects && scope.$parent.objects.length > 0 ? true : false;
                };

                scope.$parent.doShow = function(asc, col) {
                    return (asc != scope.$parent.config.desc) && (scope.$parent.config.order == col);
                };

                scope.$parent.sortBy = function(ord) {
                    if (scope.$parent.config.order === ord) {
                        scope.$parent.config.desc = !scope.$parent.config.desc;
                    } else {
                        scope.$parent.config.desc = false;
                    }
                    scope.$parent.config.order = ord;
                    scope.$parent.reset();
                };

                scope.$parent.getObject = function(o) {
                    console.log("efCrud::getObjectById(" + o.id + ")");
                    console.log("antes...");
                    console.log(scope.$parent.object);
                    scope.$parent.object = {};
                    service.get({id: o.id}, function(result) {
                        EpanelHandleResponse(null, result, scope, function() {
                            console.log("depois...");
                            console.log(scope.$parent.object);
                        });
                    });
                };

                /*
                 * Quando o objeto é salvo no Modal, o objeto da lista é
                 * atualizado ao assumindo o mesmo valor do objeto salvo no Modal.
                 */
                scope.updateO = function(object) {
                    console.log("efList::updateO()");
                    console.log(object);
                    var estaNaLista = false;
                    angular.forEach(scope.$parent.objects, function(o, key) {
                        if (o.id === object.id) {
                            estaNaLista = true;
                            scope.$parent.objects[key] = object;
                        }
                    });
                    if (!estaNaLista) {
                        console.log("efList::updateO(): não esta na lista");
                        scope.$parent.objects.push(object);
                    }
                };

                scope.$parent.delete = function(object) {
                    console.log("efList::delete(object)");
                    console.log(object);
                    if (confirm(EpanelLocale.pt_BR.confirm_delete)) {
                        service.delete({id: object.id}, function(response) {
                            EpanelHandleResponse(null, response, scope, function() {
                                if (response.class === "Eliti_Response_Success_Message") {
                                    $("*").modal("hide");
                                    angular.forEach(scope.$parent.objects, function(o, key) {
                                        if (o.id === object.id) {
                                            scope.$parent.objects.splice(key, 1);
                                        }
                                    });
                                }
                            });
                        });
                    }
                };

                search();

                scope._depoisDoPost = function(jsonResponse) {
                    if (jsonResponse.class === "Eliti_Response_Success_Object") {
                        $("*").modal("hide");
                        scope.updateO(jsonResponse.object);
                    }
                };

                /**
                 *  POST 
                 */
                var form = $(element).find("form[ef-form]")[0];
                console.log(form);
                scope.$parent.errors = [];
                scope.$parent.loaded = false;
                var url = $(form).attr("action");

                if (!url) {
                    console.warn("Faltou informar a url");
                    console.warn(form);
                } else {
                    $(form).ajaxForm({
                        method: "post",
                        url: url,
                        clearForm: false, // clear all form fields after successful submit 
                        beforeSubmit: function(formData, jqForm, options) {
                            return EpanelHandleBeforeSubmit($(form), scope.$parent);
                        },
                        complete: function() {
                            scope.$parent.loaded = true;
                            scope.$apply(); // força update da view;
                        },
                        success: function(responseText, statusText, xhr, form) {
                            console.log("=====SaveCtrl::SUCCESS=====");
                            EpanelHandleResponse($(form), responseText, scope, function() {
                                try {
                                    var jsonResponse = (typeof responseText === 'object') ? responseText : jQuery.parseJSON(responseText);
//                                    EpanelMessenger.success(EpanelLocale.pt_BR.saved);
                                    scope._depoisDoPost(jsonResponse);
                                } catch (e) {
                                    return false;
                                }
                            });
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("=====SaveCtrl::ERROR=====");
                            EpanelHandleResponse(form, XMLHttpRequest.responseText, scope);
                            return false;
                        }
                    });
                }
                scope.$parent.loaded = true;

            }
        };
    }
]);

epanel.directive('efPost', ['ServiceFactory', 'EpanelMessenger', 'EpanelHandleResponse', 'EpanelHandleBeforeSubmit', function(ServiceFactory, EpanelMessenger, EpanelHandleResponse, EpanelHandleBeforeSubmit) {
        return {
            restrict: 'A',
            scope: {
                afterPost: '&'
            },
            link: function(scope, element, attrs) {
                console.log("============efPost===========");
                /*
                 * Solução inspirada em:
                 * http://blog-it.hypoport.de/2013/11/06/passing-functions-to-angularjs-directives/
                 * (Atenção: o parâmetro 'object' não pode mudar de nome)
                 */
                if (attrs.afterPost) {
                    console.log("Possui afterPost(object)");
//                    scope.afterPost({object: "OI"}); // testar
//                    alert("possui");
                } else {
                    console.log("NÃO Possui afterPost(object)");
                    delete scope.afterPost;
//                    alert("não possui");
                }
                // pelo fato de estar definido no scope (afterPost: '&') sempre entrará aqui!
                if (scope.hasOwnProperty("afterPost") && (typeof scope["afterPost"] === 'function')) {
                    console.warn("CACILDIS!");
                }

                scope.Object = Object; // Para poder usar coisas como a que seque na View: {{Object.keys({'dasdsa':'adaf', 'aerewr':'adafsd'}).length}}

                // LIST
                var form = element;
                //scope.o = null;
                scope.$parent.errors = [];
                scope.$parent.loaded = false;
//                scope.url = $(form).attr("action");

                form.submit(function() {
                    scope.save();
                    return false;
                });

                console.log("LOADED1: " + scope.$parent.loaded);
                scope.$parent.loaded = true;
                console.log("LOADED2: " + scope.$parent.loaded);

                scope.save = function() {

//                    if (!scope.url) {
//                        alert("Faltou informar a url");
//                    }
                    console.log("SaveCtrl::save()");
                    
                    scope.$parent.loaded = false;
                
                    form.ajaxSubmit({
                        method: "post",
//                        url: scope.url,
                        clearForm: false, // clear all form fields after successful submit 
                        beforeSubmit: function(formData, jqForm, options) {
                            return EpanelHandleBeforeSubmit(form, scope.$parent);
                        },
                        complete: function() {
                            scope.$parent.loaded = true;
                            scope.$apply(); // força update da view;
                        },
                        success: function(responseText, statusText, xhr, form) {
                            console.log("=====SaveCtrl::SUCCESS=====");
                            EpanelHandleResponse(form, responseText, scope);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("=====SaveCtrl::ERROR=====");
                            EpanelHandleResponse(form, XMLHttpRequest.responseText, scope.$parent);
                            return false;
                        }
                    });
                    /* End JQuery Form Plugin */
                };

            }
        };
    }
]);