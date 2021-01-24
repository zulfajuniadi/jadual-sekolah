angular.module('app', [])
.controller('MainController', function($scope, $http){
    $scope.days = {
        '1' : 'Monday',
        '2' : 'Tuesday',
        '3' : 'Wednesday',
        '4' : 'Thursday',
        '5' : 'Friday',
        '6' : 'Saturday',
        '7' : 'Sunday',
    }

    const todayDay = (new Date).getDay();
    let selectedDay = todayDay;
    $scope.selectedDayName = $scope.days[selectedDay];

    $scope.children = [];

    $scope.setDay = function(day) {
        selectedDay = day;
        $scope.selectedDayName = $scope.days[selectedDay];
        $scope.getClassList();
    }

    $scope.getClass = function(day) {
        if(day == selectedDay) {
            return 'btn-warning';
        }
        if(day == todayDay) {
            return 'btn-primary';
        }
        return 'btn-default';
    }

    $scope.getClassList = function() {
        $http.get(location.pathname + '?class=' + selectedDay)
            .then(function(res){
                $scope.children = res.data;
            })
    }

    $scope.goToClass = function(schedule) {
        $http.get(location.pathname + '?attend=' + schedule.id).then(function(){
            if(schedule.class_url) {
                window.open(schedule.class_url, '_blank');
            }
        });
    }

    $scope.getClassList();
})

.filter('time', function(){
    return function(time) {
        const parts = time.split(':');
        let suff = 'AM';
        if(parts[0] > 12) {
            suff = 'PM';
            parts[0] = parts[0] - 12;
        }
        return parts[0] + ':' + parts[1] + suff;
    }
})

;
