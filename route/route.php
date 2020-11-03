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
    Route::get('Class/getClassInfo', 'admin/ClassServer/getClassInfo');
    Route::get('Class/getClass', 'admin/ClassServer/getClass');
    Route::post('Class/addClass', 'admin/ClassServer/addClass');
    Route::post('Class/updateClass', 'admin/ClassServer/updateClass');
    Route::post('Class/deleteClass', 'admin/ClassServer/deleteClass');
    //课程
    Route::get('Course/getCourseInfo', 'admin/Course/getCourseInfo');
    Route::get('Course/getCourse', 'admin/Course/getCourse');
    Route::post('Course/addCourse', 'admin/Course/addCourse');
    Route::post('Course/updateCourse', 'admin/Course/updateCourse');
    Route::post('Course/deleteCourse', 'admin/Course/deleteCourse');
    //视频
    Route::get('Video/getVideoInfo', 'admin/Video/getVideoInfo');
    Route::get('Video/getVideo', 'admin/Video/getVideo');
    Route::post('Video/addVideo', 'admin/Video/addVideo');
    Route::post('Video/updateVideo', 'admin/Video/updateVideo');
    Route::post('Video/deleteVideo', 'admin/Video/deleteVideo');
    //课程表
    Route::get('Timetable/getTimeTableInfo', 'admin/TimeTable/getVideoInfo');
    Route::get('Timetable/getTimeTable', 'admin/TimeTable/getTimeTable');
    Route::post('Timetable/addTimeTable', 'admin/TimeTable/addTimeTable');
    Route::post('Timetable/updateTimeTable', 'admin/TimeTable/updateTimeTable');
    Route::post('Timetable/deleteTimeTable', 'admin/TimeTable/deleteTimeTable');
    //管理员
    Route::post('user/login', 'admin/User/login');
    Route::get('user/info', 'admin/User/info');
    Route::get('user/getUser', 'admin/User/getUser');
    Route::post('user/logout', 'admin/User/logout');
    Route::post('user/updateUser', 'admin/User/updateUser');
    //上传
    Route::post('Upload/execAction', 'admin/Upload/execAction');
    Route::post('Upload/execActionBlod', 'admin/Upload/execActionBlod');
});

Route::group('hsxz', function(){
    Route::get('get_class_info', 'hsxz/ClassServer/getClassInfo');
    Route::get('get_class', 'hsxz/ClassServer/getClass');

    Route::get('get_course_info', 'hsxz/Course/getCourseInfo');
    Route::get('get_course', 'hsxz/Course/getCourse');
});
