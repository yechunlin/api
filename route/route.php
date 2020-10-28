<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::miss('output/Output/notFound');

//班级
Route::group('Class', function () {
    Route::get('getClassInfo', 'hsxz/ClassServer/getClassInfo');
    Route::get('getClass', 'hsxz/ClassServer/getClass');
    Route::post('addClass', 'hsxz/ClassServer/addClass');
    Route::post('updateClass', 'hsxz/ClassServer/updateClass');
    Route::post('deleteClass', 'hsxz/ClassServer/deleteClass');
});
//课程
Route::group('Course', function () {
    Route::get('getCourseInfo', 'hsxz/Course/getCourseInfo');
    Route::get('getCourse', 'hsxz/Course/getCourse');
    Route::post('addCourse', 'hsxz/Course/addCourse');
    Route::post('updateCourse', 'hsxz/Course/updateCourse');
    Route::post('deleteCourse', 'hsxz/Course/deleteCourse');
});

//视频
Route::group('Video', function () {
    Route::get('getVideoInfo', 'hsxz/Video/getVideoInfo');
    Route::get('getVideo', 'hsxz/Video/getVideo');
    Route::post('addVideo', 'hsxz/Video/addVideo');
    Route::post('updateVideo', 'hsxz/Video/updateVideo');
    Route::post('deleteVideo', 'hsxz/Video/deleteVideo');
});

//课程表
Route::group('Timetable', function () {
    Route::get('getTimeTableInfo', 'hsxz/TimeTable/getVideoInfo');
    Route::get('getTimeTable', 'hsxz/TimeTable/getTimeTable');
    Route::post('addTimeTable', 'hsxz/TimeTable/addTimeTable');
    Route::post('updateTimeTable', 'hsxz/TimeTable/updateTimeTable');
    Route::post('deleteTimeTable', 'hsxz/TimeTable/deleteTimeTable');
});

//管理员
Route::group('admin/user', function () {
    Route::post('login', 'admin/User/login');
    Route::get('info', 'admin/User/info');
    Route::get('getUser', 'admin/User/getUser');
    Route::post('logout', 'admin/User/logout');
    Route::post('updateUser', 'admin/User/updateUser');
});

//upload
Route::post('Upload/execAction', 'hsxz/Upload/execAction');
Route::post('Upload/execActionBlod', 'hsxz/Upload/execActionBlod');

Route::group('index', function(){
    Route::get('index', 'index/index/hello');
    Route::get('showError', 'index/index/showError');
})->model('\app\hsxz\model\UserModel');
