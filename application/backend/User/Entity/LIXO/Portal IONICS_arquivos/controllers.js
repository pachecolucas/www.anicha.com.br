function EntityCtrl($scope, $timeout, ServiceFactory, EpanelMessenger, EpanelHandleResponse) {

    console.log("EntityCtrl");
    $scope.Object = Object; // Para poder usar coisas como a que seque na View: {{Object.keys({'dasdsa':'adaf', 'aerewr':'adafsd'}).length}}

    // ENTITY
    $scope.service = null;

    // LIST
    $scope.listable = true;
//    var sortableEle;
    $scope.objects = [];
    $scope.offset = 0;
    $scope.has_more = false;
    $scope.desc = false;
    var quering = false;

    // EDIT
    $scope.posting = false;
    $scope.service = null;

    $scope.init = function(config) {
        console.log("EntityCtrl::init([config])");
        console.log(config);
        $scope.initEntityCtrl(config);
    };

    $scope.initEntityCtrl = function(config) {
        console.log("EntityCtrl::initEntityCtrl([config])");
        $scope.beforeLoad(config);

        if (config.listable === false) {
            $scope.listable = false;
        }
        console.log("Listable:" + $scope.listable);

        // ENTITY
        $scope.module = config.module;
        $scope.entity = config.entity;

        // LIST
        $scope.limit = config.limit;
        $scope.service = ServiceFactory.create($scope.module, $scope.entity);
        if ($scope.listable) {
            $scope.search();
        }

        // EDIT
        if (config.id > 0) {
//            console.log("É edição (" + config.id + ")");
            $scope.service.get({id: config.id}, function(jsonObj) {
                $scope.o = jsonObj;
                console.log($scope.o);
            });
        } else {
//            console.log("É criação");
        }
        $scope.onload(config);
        $scope.afterLoad(config);
    };

    $scope.onload = function(config) {
        // função para ser sobrescrita ao carregar
    };

    $scope.beforeLoad = function(config) {
        // função para ser sobrescrita ao carregar
    };

    $scope.afterLoad = function(config) {
        // função para ser sobrescrita ao carregar
    };

    //
    // ENTITY LIST
    // Isso parou de funcionar no VagaCtrl pq $scope.query passou a pertence à
    // subclasse (VagaCtrl) e não pode mais ser encontrado na super classe.
    //
    $scope.searchOnType = function(query) {
        var quering = true;
        console.log($scope.teste);
        
        console.log(query);
//        $timeout(function() {
//            // Mágica!!!! Pq isso funciona?? Não sei!
//            // Mas o resultado é que ele só faz a pesquisa se o cabra ficar, pelo menos, meio segundo sem digitar
//            if (quering) {
////                console.log("Query: " + $scope.query);
//                $scope.reset();
//            }
//        }, 500);
    };

    $scope.isFiltering = function() {
        return $scope.query ? true : false;
    };

    $scope.reset = function() {
        $scope.offset = 0;
        $scope.objects = [];
        $scope.search();
    };

    $scope.search = function(showMore) {
        console.log("EntityCtrl::search(showMore)");
        console.log("QUERY:" + $scope.query);
        console.log("ORDER:" + $scope.order);
        console.log("DESC:" + $scope.desc);
        console.log("LIMIT:" + $scope.limit);
        console.log("OFFSET:" + $scope.offset);
        $scope.service.query({
            q: $scope.query,
            order: $scope.order,
            desc: $scope.desc,
            limit: $scope.limit,
            offset: $scope.offset
        }, function(response) {
            EpanelHandleResponse(null, response, $scope, null, showMore);
//            if (showMore) {
//                $scope.objects = $scope.objects.concat(objects);
//            } else {
//                $scope.objects = objects;
//            }
//            $scope.has_more = objects.length >= $scope.limit;
            quering = false;

        });
    };

    $scope.sort_by = function(ord) {
        if ($scope.order == ord) {
            $scope.desc = !$scope.desc;
        } else {
            $scope.desc = false;
        }
        $scope.order = ord;
//        console.log($scope.desc);
//        console.log($scope.order);
        $scope.reset();
    }

    $scope.do_show = function(asc, col) {
        return (asc != $scope.desc) && ($scope.order == col);
    };

    $scope.deleteFromList = function() {
        var id = this.o.id;
        if (confirm("Quer realmente apagar o item nº" + id + "?")) {
            $scope.service.delete({id: id}, function() {
                $("#o_" + id).fadeOut();
                EpanelMessenger.success("Item nº" + id + " foi apagado!");
            }, function(response) {
                EpanelMessenger.error("Ocorreu um erro ao tentar apagar este item: (" + response.data + ")");
//                console.log(response.data);
            });
        }
    }

    $scope.showMore = function() {
        $scope.offset += $scope.limit;
        $scope.search(true);
    }

    //
    // EDIT
    //
    $scope.onSuccess = function() {
        // função para ser sobrescrita ao salvar com sucesso
    }

    $scope.cancelar = function() {
        if ($scope.o.id) {
            $scope.init($scope.module, $scope.entity, $scope.o.id);
        } else {
            $scope.o = null;
        }
    }

    $scope.removeItem = function(item, lista) {
        console.log("vai deletar (" + item + ")...");
        var index = lista.indexOf(item);
        lista.splice(index, 1);
    }

    $scope.delete = function(lista) {
        console.log("LISTA:" + lista);
        var id = $scope.o.id;
        if (confirm("Quer realmente apagar o item nº" + id + "?")) {
            $scope.service.delete({id: id}, function() {
                if (lista) {
                    console.log("Tem que remover da lista");
                    var index = lista.indexOf($scope.o);
                    lista.splice(index, 1);
                }
                EpanelMessenger.success("Item nº" + id + " foi apagado!");
                $scope.o = null;
//                $("#o_" + id + "_" + $scope.entity).fadeOut();

            }, function(response) {
                EpanelMessenger.error(response.data);
                console.log(response.data);
            });
        }
    };

    $scope.getObjectById = function(id) {
        console.log("EntityCtrl::getObjectById(" + id + ")");
        console.log("antes...");
        console.log($scope.o);
        $scope.o = null;
        $scope.service.get({id: id}, function(result) {
            EpanelHandleResponse(null, result, $scope);
            console.log("depois...");
            console.log($scope.o);
        });
    };

}