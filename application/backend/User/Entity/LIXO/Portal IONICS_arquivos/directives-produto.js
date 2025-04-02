epanel.directive('efVinculado', ['$timeout', 'EpanelHandleResponse', 'EpanelHandleBeforeSubmit', 'EpanelMessenger', 'EpanelLocale', 'ServiceFactory',
    function($timeout, EpanelHandleResponse, EpanelHandleBeforeSubmit, EpanelMessenger, EpanelLocale, ServiceFactory) {
        return {
            restrict: 'A',
            scope: true,
            link: function(scope, element, attrs) {

                var service = ServiceFactory.create(attrs.module, attrs.entity);
                scope.config = {
                    limit: parseInt(attrs.limit),
                    hasMore: false,
                    offset: 0,
                    quering: true,
                };

                var search = function(callbackSearch) {
                    console.log("efVinculado::search(showMore)");
                    console.log(scope.config);
                    service.query({
                        q: scope.config.query,
                        order: scope.config.order,
                        desc: scope.config.desc,
                        limit: scope.config.limit,
                        offset: scope.config.offset
                    }, function(response) {
                        EpanelHandleResponse(null, response, scope, function() {
                            if (response.class === "Eliti_Response_Success_Objects") {
                                if (scope.showMoreCliked) {
                                    console.log("search::adicionando novos objetos retornados à lista original...");
                                    scope.config.hasMore = response.objects.length >= scope.config.limit;
                                    scope.objects = scope.objects.concat(response.objects);
                                } else {
                                    console.log("search::limpando lista e mostrando objetos retornados...");
                                    console.log(scope.objects);
                                    console.log(response.objects);
                                    scope.objects = response.objects;
                                    scope.config.hasMore = scope.objects.length >= scope.config.limit;
                                }
                            }
                        });

                        if (callbackSearch) {
                            callbackSearch();
                        }
                        scope.config.quering = false;
                    });
                };

                scope.reset = function() {
                    scope.config.offset = 0;
                    scope.objects = [];
                    search();
                };

                scope.searchOnType = function() {
                    scope.config.quering = true;
                    $timeout(function() {
                        // Mágica abaixo funcionando estranhamente.
                        // de o cabra digitar rapidamente 'asdf' ele vai procurar várias vezes por 'asdf'
                        // Mágica!!!! Pq isso funciona?? Não sei!
                        // Mas o resultado é que ele só faz a pesquisa se o cabra ficar, pelo menos, meio segundo sem digitar
                        if (scope.config.quering) {
                            console.log("ENTROU...");
//                console.log("Query: " + $scope.query);
                            scope.reset();
                        } else {
                            console.log("EVITOU ENTRAR...");
                        }
                    }, 500);
                };

                scope.showMore = function() {
                    scope.showMoreCliked = true;
                    scope.config.offset += scope.config.limit;
                    search(function() {
                        scope.showMoreCliked = false;
                    });
                };

                scope.isFiltering = function() {
                    return scope.config.query ? true : false;
                };

                scope.hasObjects = function() {
                    return scope.objects && scope.objects.length > 0 ? true : false;
                };

                scope.doShow = function(asc, col) {
                    return (asc != scope.config.desc) && (scope.config.order == col);
                };

                scope.sortBy = function(ord) {
                    if (scope.config.order === ord) {
                        scope.config.desc = !scope.config.desc;
                    } else {
                        scope.config.desc = false;
                    }
                    scope.config.order = ord;
                    scope.reset();
                };

                scope.getObject = function(o) {
                    console.log("efList::getObjectById(" + o.id + ")");
                    console.log("antes...");
                    console.log(scope.object);
                    scope.object = {};
                    service.get({id: o.id}, function(result) {
                        EpanelHandleResponse(null, result, scope, function() {
                            console.log("depois...");
                            console.log(scope.object);
                        });
                    });
                };

                search();
                
                scope.loaded = true;

            }
        };
    }
]);