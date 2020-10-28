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
Route::group('admin', function () {
    Route::get('Class/getClassInfo', 'hsxz/ClassServer/getClassInfo');
    Route::get('Class/getClass', 'hsxz/ClassServer/getClass');
    Route::post('Class/addClass', 'hsxz/ClassServer/addClass');
    Route::post('Class/updateClass', 'hsxz/ClassServer/updateClass');
    Route::post('Class/deleteClass', 'hsxz/ClassServer/deleteClass');
    //课程
    Route::get('Course/getCourseInfo', 'hsxz/Course/getCourseInfo');
    Route::get('Course/getCourse', 'hsxz/Course/getCourse');
    Route::post('Course/addCourse', 'hsxz/Course/addCourse');
    Route::post('Course/updateCourse', 'hsxz/Course/updateCourse');
    Route::post('Course/deleteCourse', 'hsxz/Course/deleteCourse');
    //视频
    Route::get('Video/getVideoInfo', 'hsxz/Video/getVideoInfo');
    Route::get('Video/getVideo', 'hsxz/Video/getVideo');
    Route::post('Video/addVideo', 'hsxz/Video/addVideo');
    Route::post('Video/updateVideo', 'hsxz/Video/updateVideo');
    Route::post('Video/deleteVideo', 'hsxz/Video/deleteVideo');
    //课程表
    Route::get('Timetable/getTimeTableInfo', 'hsxz/TimeTable/getVideoInfo');
    Route::get('Timetable/getTimeTable', 'hsxz/TimeTable/getTimeTable');
    Route::post('Timetable/addTimeTable', 'hsxz/TimeTable/addTimeTable');
    Route::post('Timetable/updateTimeTable', 'hsxz/TimeTable/updateTimeTable');
    Route::post('Timetable/deleteTimeTable', 'hsxz/TimeTable/deleteTimeTable');
    //管理员
    Route::post('user/login', 'admin/User/login');
    Route::get('user/info', 'admin/User/info');
    Route::get('user/getUser', 'admin/User/getUser');
    Route::post('user/logout', 'admin/User/logout');
    Route::post('user/updateUser', 'admin/User/updateUser');
    //上传
    Route::post('Upload/execAction', 'hsxz/Upload/execAction');
    Route::post('Upload/execActionBlod', 'hsxz/Upload/execActionBlod');
});

Route::group('index', function(){
    Route::get('index', 'index/index/hello');
    Route::get('showError', 'index/index/showError');
})->model('\app\hsxz\model\UserModel');
