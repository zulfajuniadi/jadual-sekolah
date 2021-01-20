<div id="schedule" ng-app="app" ng-controller="MainController" ng-cloak>

    <h3 class="mb-4 text-center">
        Schedule for {{selectedDayName}}
    </h3>

    <div class="btn-group mt-3 text-center d-block">
        <button class="btn btn-sm mb-2" ng-repeat="(k, day) in days" ng-class="getClass(k)" ng-click="setDay(k)">
            {{day}}
        </button>
    </div>

    <div class="row mt-3">
        <div class="col-lg-4 col-md-6 text-center" ng-repeat="child in children">
            <div class="div">
                <div class="card-header">
                    <strong>
                        {{child.name}}
                    </strong>
                </div>
                <table class="table table-bordered bg-white">
                    <tbody>
                        <tr ng-repeat="schedule in child.schedules">
                            <td>
                                {{schedule.start_time | time}} - {{schedule.end_time | time}}
                            </td>
                            <td>
                                {{schedule.name}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js" integrity="sha512-7oYXeK0OxTFxndh0erL8FsjGvrl2VMDor6fVqzlLGfwOQQqTbYsGPv4ZZ15QHfSk80doyaM0ZJdvkyDcVO7KFA==" crossorigin="anonymous"></script>
