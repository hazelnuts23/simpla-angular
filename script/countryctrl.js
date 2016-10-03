var cApp = angular.module("cApp", []).controller("countryCtrl", function ($scope, $http) {
    $scope.editform = true;
    $scope.addform = true;

    $http.get("/angular/backend/country.php?mode=getAll").then(function (response) {
        $scope.countries = response.data;
    })
    $scope.closeSave = function () {
        $scope.addform = true;
        $scope.update_name = null;
        $scope.update_sortname = null;
    }
    $scope.closeUpdate = function () {
        $scope.editform = true;
        $scope.update_name = null;
        $scope.update_sortname = null;
    }
    $scope.addCountry = function(){
        $scope.addform = false;
    }
    $scope.editCountry = function (id) {
        $scope.editform = false;
        $http.get("/angular/backend/country.php?mode=getSpec&id=" + id).then(function (response) {
            $scope.update_id = response.data.id;
            $scope.update_name = response.data.name;
            $scope.update_sortname = response.data.sortname;
            console.log($scope.update_name);
        })
    }
    $scope.saveCountry = function () {
        var param = { name: $scope.add_name,
            sortname: $scope.add_sortname
        };
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post('/angular/backend/country.php?mode=add',
            param
        ).success(function (data) {
            console.log(data);
            if (data.error == 1) {
                console.log("ERROR");
            } else if (data.error == 0) {
                window.location.reload();
            }

        }).error(function() {
            alert('not submitted');
        })
    }
    $scope.updateCountry = function () {
        var param = {id: $scope.update_id,
            name: $scope.update_name,
            sortname: $scope.update_sortname
        };
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        $http.put('/angular/backend/country.php?mode=edit',
            param
        ).success(function (data) {
            console.log(data);
            if (data.error == 1) {
                console.log("ERROR");
            } else if (data.error == 0) {

                    window.location.reload();

            }
        }).error(function() {
            alert('not submitted');
        })
    }
})