epanel.factory('EpanelValidator', function() {
    return {
        cpf: function(strCPF) {
            strCPF = strCPF.replace('.', '');
            strCPF = strCPF.replace('.', '');
            strCPF = strCPF.replace('-', '');

            var Soma;
            var Resto;
            Soma = 0;
            if (strCPF == "00000000000")
                return false;

            for (i = 1; i <= 9; i++)
                Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11))
                Resto = 0;
            if (Resto != parseInt(strCPF.substring(9, 10)))
                return false;

            Soma = 0;
            for (i = 1; i <= 10; i++)
                Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11))
                Resto = 0;
            if (Resto != parseInt(strCPF.substring(10, 11)))
                return false;

            return true;
        },
        email: function(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    };
});

epanel.factory('EpanelList', function() {
    return {
        add: function(object, list) {
            console.log("EpanelList:: Adicionando na lista:");
            console.log(object);
            console.log(list);
            var estaNaLista = false;
            angular.forEach(list, function(o, key) {
                if (o.id === object.id) {
                    console.log("EpanelList:: já estava na lista");
                    estaNaLista = true;
                    list[key] = object;
                }
            });
            if (!estaNaLista) {
                console.log("EpanelList::updateO(): não estava na lista");
                list.push(object);
            }
        },
        remove: function(object, list) {
            angular.forEach(list, function(o, key) {
                if (o.id === object.id) {
                    list.splice(key, 1);
                }
            });
        },
        has: function(object, list) {
            var estaNaLista = false;
            angular.forEach(list, function(o, key) {
                if (o.id === object.id) {
                    console.log("EpanelList:: já estava na lista");
                    estaNaLista = true;
                    list[key] = object;
                }
            });
            return estaNaLista;
        }
    };
});

/**
 * ServiceFactory
 */
epanel.factory('ServiceFactory', function($resource) {
    return {
        create: function(module, entity) {
            console.log("ServiceFactory::create('" + module + "', '" + entity + "')");
            return $resource(
                    '/' + module + '/' + entity + '/:id', {id: '@id'},
            {
                'get': {method: 'GET', isArray: false},
                'query': {method: 'GET', isArray: false},
                'save': {method: 'POST'},
                'sort': {method: 'PUT', isArray: false},
                'remove': {method: 'DELETE'},
                'delete': {method: 'DELETE'}
            }
            );
        }
    }
});

/**
 * EpanelMessenger
 */
epanel.factory('EpanelMessenger', function() {
    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-top',
        //                        theme: 'future'
    };
    var msg = {
        success: function(msgText) {
            Messenger().post({message: msgText, type: "success", showCloseButton: true});
        },
        error: function(msgText) {
            Messenger().post({message: msgText, type: "error", showCloseButton: true});
        }
    };

    return msg;
});

/**
 * EpanelLocale
 */
epanel.factory('EpanelLocale', function() {
    return {
        pt_BR: {
            validation_error: "Por favor, corrija o(s) campo(s) em vermelho.",
            saved: "Item foi salvo com sucesso.",
            confirm_delete: "Tem certeza de que deseja apagar?",
        },
        es: {
            validation_error: "Corrija los campos rojos.",
            saved: "Guardado con éxito.",
            confirm_delete: "¿Está seguro que desea eliminar?",
        },
        en: {
            validation_error: "Please correct the highlighted field(s).",
            saved: "Successfully saved.",
            confirm_delete: "Are you sure you want to delete?",
        },
    };
});

/**
 * EpanelHandleResponse
 */
epanel.factory('EpanelHandleResponse', ['EpanelMessenger', 'EpanelLocale',
    function(EpanelMessenger, EpanelLocale) {
        return function(form, response, $scope, callback) {
            console.log("-----EpanelHandleResponse()-----");
            console.log(response);
            try {
                console.log("RESPONSE:");
                console.log(response);
                var jsonResponse = (typeof response === 'object') ? response : jQuery.parseJSON(response);
                console.log(jsonResponse.class);
                switch (jsonResponse.class) {
                    case "Eliti_Response_Error_Validation":
                        console.log(jsonResponse.errors);
                        $.each(jsonResponse.errors, function() {
                            // coloca a mensagem de erro
                            console.log("[name=" + this.key + "]");
                            form.find("[name=" + this.key + "]")
                                    .focus()
                                    .closest(".form-group").addClass("has-error")
                                    .append('<small><span class="help-block" style="margin:0;"><i class="fa fa-exclamation-triangle"></i> ' + this.message + '</span></small>');
                        });
                        $scope.$apply();
//                        EpanelMessenger.error(EpanelLocale.teste);
                        EpanelMessenger.error(EpanelLocale.pt_BR.validation_error);
                        break;
                    case "Eliti_Response_Error_Validation_Special":
                        console.log("Eliti_Response_Error_Validation_Special2");
                        console.log(jsonResponse.errors);

                        angular.forEach(jsonResponse.errors, function(error, key) {
                            console.log("[name=" + error.key + "]:" + error.message);
                            form.find("[name=" + error.key + "]")
                                    .focus()
                                    .closest(".form-group").addClass("has-error");
                            if (error.message) {
                                $scope.$parent.errors.push(error.message);
                            }
                        });
                        console.log($scope.$parent.errors);
//                        $.each(jsonResponse.errors, function() {
//                            // coloca a mensagem de erro
//                            console.log(this);
//                            console.log("[name=" + this.key + "]:" + this.message);
//                            form.find("[name=" + this.key + "]")
//                                    .focus()
//                                    .closest(".form-group").addClass("has-error");
//                            if (this.message) {
//                                $scope.errors.push(this.message);
//                            }
//                        });
                        $scope.$apply();
//                EpanelMessenger.error("Por favor, corrija o(s) campo(s) destacado(s).");
                        break;
                    case "Eliti_Response_Error_Message":
                        console.log(jsonResponse.message);
                        EpanelMessenger.error(jsonResponse.message);
                        break;
                    case "Eliti_Response_Error_Access":
                        var accessErrorHTML = '<div style="z-index:999999;position:relative;background:#F88;padding:20px;width:auto;max-width:500px;margin:20px auto;text-align:center;color:white;">' +
                                '<h2 style="color:white;"><i class="fa fa-lock"></i> Restrição de Acesso</h2>' +
                                '<p class="lead"><b>' + jsonResponse.user.nome + '</b>, o acesso a este recurso encontra-se bloqueado para o seu perfil.</p>' +
                                '<p>Caso acredite que deveria ter acesso, por favor, copie e envie os dados abaixo para o administrador do Portal IONICS:</p>' +
                                '<p class="well well-sm" style="font-family: monospace; font-size:10px; color:#666; font-weight: bold;">' +
                                '[' + jsonResponse.user.id + '-' + jsonResponse.user.email + ', ' + jsonResponse.user.grupo.tipo.id + '-' + jsonResponse.user.grupo.tipo.nome + ', ' + jsonResponse.user.grupo.id + '-' + jsonResponse.user.grupo.nome + ',' + jsonResponse.method + '-' + jsonResponse.module + '/' + jsonResponse.controller + '/' + jsonResponse.action + ', ' + jsonResponse.tipoId + '-' + jsonResponse.tipo + ']' +
                                '</p>' +
                                '</div>';
                        $.magnificPopup.open({items: {src: accessErrorHTML}, type: 'inline'});
                        break;
                    case "Eliti_Response_Success_Silence":
//                        console.log(jsonResponse.message);
                        break;
                    case "Eliti_Response_Success_Message":
                        console.log(jsonResponse.message);
                        EpanelMessenger.success(jsonResponse.message);
                        break;
                    case "Eliti_Response_Success_Redirect":
                        console.log(jsonResponse.link);
                        window.location = jsonResponse.link;
                        break;
                    case "Eliti_Response_Success_Object":
                        console.log(jsonResponse.object);
                        if ($scope) {
                            if ($scope.hasOwnProperty("afterPost") && (typeof $scope["afterPost"] === 'function')) {
                                console.log("Utilizando scope.afterPost()...");
                                console.log(jsonResponse.object);
                                $scope.afterPost({object: jsonResponse.object});
                            } else if ($scope.$parent.hasOwnProperty("object")) {
                                console.log("Utilizando setObject default... ($scope.$parent)");
                                $scope.$parent.object = jsonResponse.object;
                            } else {
                                console.log("Utilizando setObject default... ($scope)");
                                $scope.object = jsonResponse.object;
                            }
                        } else {
                            console.log("$scope é NULL e não será utilizado setObject");
                        }
                        break;
                    case "Eliti_Response_Success_Objects":
                        console.log(jsonResponse.objects);
                        if ($scope) {
                            if (callback && (typeof callback === 'function')) {
                                console.log("Utilizando callback()... (está comentado, mas usa no final)");
//                            callback();
                            } else if ($scope.$parent.hasOwnProperty("objects")) {
                                console.log("Utilizando setObjects default... ($scope.$parent)");
                                alert("Algo insperado aconteceu. (ERRO: Eliti_Response_Success_Objects)");
//                            $scope.$parent.objects = jsonResponse.objects;
                            } else {
                                console.log("Utilizando setObjects default... ($scope)");
                                alert("Algo insperado aconteceu. (ERRO: Eliti_Response_Success_Objects)");
//                            $scope.objects = jsonResponse.objects;
                            }
                        }
                        break;
                    case "Eliti_Response_Success_Html":
                        console.log("Target: " + jsonResponse.target);
                        console.log("HTML: " + jsonResponse.html);
                        $(jsonResponse.target).html(jsonResponse.html);
                        break;
                    default:
                        EpanelMessenger.error("Resposta recebida não foi algo dentro do esperado.");
                        break;
                }
                if (callback) {
                    callback();
                }
                if ($scope && $scope.callback) {
                    console.log("Chamando callback do scopo");
                    $scope.callback(jsonResponse);
                }
            } catch (e) {
                EpanelMessenger.error("Ops... Algo inesperado parece ter acontecido. Contate imediatamente o administrador do Sistema.");
                console.log(response);
                return false;
            }
        };
    }
]);


/**
 * EpanelHandleResponse
 */
epanel.factory('EpanelHandleBeforeSubmit', [
    function() {
        return function(form, scope) {
            console.log("-----EpanelHandleBeforeSubmit()-----");
            // Tradicionais mudanças na view
            form.find(".help-block").remove(); // retira as mensagens de erro
            form.find(".form-group").removeClass("has-error"); // retira marcação de erro
            scope.loaded = false;
            scope.errors = [];
            scope.$apply();
            console.log("LOADED:" + scope.loaded);

            // Verificação de errors em todos os input[type=file]
            var hasErrors = false;
            // Prepara response para o caso de haver erro
            var response = {
                class: "Eliti_Response_Error_Validation",
                errors: []
            };
            // pega todos os inputs to tipo file
            var inputFiles = $(form).find("input[type=file]");
            // para cada um dos inputs to tipo file
            inputFiles.each(function() {
                // verifica se o arquivo dele não é maior que o máximo aceito
                if (this.files[0]) {
                    var fileSizeInMB = this.files[0].size / 1024 / 1024;
                    console.log("Tamanho do arquivo: " + fileSizeInMB + "MB");
                    if (fileSizeInMB > 5) {
                        hasErrors = true;
                        response.errors.push({key: "curriculo", message: "Arquivo deveria possuir no máximo 5 MB. Este possui " + fileSizeInMB.toFixed(1) + " MB."});
                    }
                }
            });
            if (hasErrors) {
                EpanelHandleResponse(form, response, scope);
                scope.loaded = true;
                scope.$apply(); // força update da view;
                return false;
            }
            return true;
        };
    }
]);