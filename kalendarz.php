<?php $rightOff = true; require_once("ajax/db.php"); ?>
                
    <style>
        span, td, p { text-align: left; }
        th { text-align: center; }
        .fc-day-header {
            color: #fff;
            background-color: #79648b;
        }
        .angularjs-datetime-picker {
            z-index: 999;
        }
        .mb { margin-bottom: 10px; }
        .datetimepicker-wrapper {
            vertical-align: middle;
            display: inline-block;
        }
        .datetimepicker-wrapper > input {
            margin-bottom: 0 !important;
            width: 130px;
        }
        .datetimepicker-wrapper [ng-model=hours], 
        .datetimepicker-wrapper [ng-model=minutes] {
            width: 46px !important;
        }
        .scrollabe {
            width: 100%;
            height: 300px;
            overflow: scroll;
        }
        .me { 
            background-color: #5cb85c;
            border-color: #4cae4c;
            color: #fff;
        }
        .notme { 
            background-color: #3071a9;
            border-color: #285e8e;
            color: #fff;
        }
    </style>

    <div class="kalendarz_big row nopadding">
        <div class="col-xs-12">

            <section style="margin-top: 20px;">
                <div class="">
                    <div class="row-fluid">

                        <div class="span8">

                            <div class="btn-toolbar">
                              <div class="btn-group">
                                  <button class="btn btn-danger" ng-click="setView('agendaDay')"><i class="fa fa-clock-o" aria-hidden="true"></i> AgendaDay</button>
                                  <button class="btn btn-success" ng-click="setView('agendaWeek')"><i class="fa fa-calendar" aria-hidden="true"></i> AgendaWeek</button>
                                  <button class="btn btn-warning" ng-click="setView('month')"><i class="fa fa-calendar" aria-hidden="true"></i> Month</button>
                              </div>
                              <div class="btn-group pull-right">
                                  <button class="btn btn-primary" ng-click="doPreviousView()"><i class="fa fa-chevron-left" aria-hidden="true"></i> Prev</button>
                                  <button class="btn btn-danger" ng-click="viewToday()"><i class="fa fa-calendar" aria-hidden="true"></i> Today</button>
                                  <button class="btn btn-primary" ng-click="doNextView()"><i class="fa fa-chevron-right" aria-hidden="true"></i> Next</button>
                              </div>
                            </div>

                            <h3>{{showingTitle}}</h3>
                            <div id="calendarBig" full-calendar></div>

                            <hr>
                            <a class="pull-right btn btn-success" data-toggle="modal" data-target="#newEventDataModal"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Add New Event</a>

                        </div>

                    </div>
                </div>
            </section>

        </div>
    </div>
