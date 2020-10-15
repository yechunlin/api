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

//班级
Route::group('Class', function () {
    Route::get('getClassInfo', 'hsxz/ClassServer/getClassInfo');
    Route::get('getClass', 'hsxz/ClassServer/getClass');
    Route::post('addClass', 'hsxz/ClassServer/addClass');
    Route::post('updateClass', 'hsxz/ClassServer/updateClass');
    Route::post('deleteClass', 'hsxz/ClassServer/deleteClass');
	Route::get('searchClass', 'hsxz/ClassServer/searchClass');
});
//课程
Route::group('Course', function () {
    Route::get('getCourseInfo', 'hsxz/Course/getCourseInfo');
    Route::get('getCourse', 'hsxz/Course/getCourse');
    Route::post('addCourse', 'hsxz/Course/addCourse');
    Route::post('updateCourse', 'hsxz/Course/updateCourse');
    Route::post('deleteCourse', 'hsxz/Course/deleteCourse');
	Route::get('searchCourse', 'hsxz/Course/searchCourse');
});

Route::group('admin/user', function () {
    Route::post('login', 'admin/User/login');
    Route::get('info', 'admin/User/info');
});
