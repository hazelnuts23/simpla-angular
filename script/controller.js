var angApp = angular.module("angApp", []);

angApp.controller("angCtrl", function($scope){
    $scope.class = "SCSJ";
    $scope.changeName = function(){
        $scope.students =
            [{name: 'Syafiq Azizi', matrix: 'SCSJ01'},
                {name: 'Sharina Zolkifli', matrix: 'SCSJ02'},
                {name: 'Al Azieze', matrix: 'SCSJ03'}];
    }


});
angApp.controller("angCtrl2", function($scope){
    $scope.value1 = 45646;
    $scope.value2 = 756734;
});