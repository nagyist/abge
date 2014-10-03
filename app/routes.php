<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


	//Route::controller('/dashboard/promotioners', 'PromotionerController');
	//Route::controller('/dashboard/supporters', 'SupporterController');
	//Route::controller('/dashboard/', 'DashboardController');
	//Route::controller('/', 'FrontendController');
	//Route::controller('/auth', 'AuthenticationController');
if(Auth::check() && Auth::user()->type=="superadmin"):
	Route::controller('/dashboard/org/participants', 'ORGParticipantController');
	Route::controller('/dashboard/org/associates', 'ORGAssociateController');
	Route::controller('/dashboard/teachers', 'TeacherController');
	Route::controller('/dashboard/sections', 'SectionController');
	Route::controller('/dashboard/companies', 'CompanyController');
	Route::controller('/dashboard/categories', 'CategoryController');
	Route::controller('/dashboard/events', 'EventController');
	Route::controller('/dashboard/courses/{idCourse}/usertypes/{idUserType}/dates', 'DateController');
	Route::controller('/dashboard/courses/{idCourse}/usertypes', 'UserTypeController');
	Route::controller('/dashboard/courses/{idCourse}/inscriptions/{idInscription}/files', 'FileController');
	Route::controller('/dashboard/courses/{idCourse}/inscriptions', 'InscriptionController');
	Route::controller('/dashboard/courses/{idCourse}/content', 'ContentController');
	Route::controller('/dashboard/courses', 'CourseController');
else:
	Route::controller("/gd-admin","AuthenticationController");
endif;
	
	Route::get('/logout', function(){
		Auth::logout();
		return Redirect::to("/gd-admin");
	});
	
	Route::controller('/dashboard', 'DashboardController');
	// Route::get('/dashboard/', function(){
	// 	return Redirect::to('/');
	// });
	//Route::controller('/auth', 'AuthenticationController');
	Route::controller('/autenticacao', 'AuthenticationController');
	Route::controller('/courses/{id?}/{content?}/{idContent?}', 'FrontendCourseController');
	Route::controller('/{id}/{content?}/{idContent?}', 'FrontendCourseController');
	Route::controller('/', 'FrontendController');



// Route::get('/', function(){
// 	$course = Courses::find(1);

// 	$teachers = $course->teachers;
// 	$promotioners = $course->promotioners;
// 	$supporters = $course->supporters;
// 	//var_dump($promotioners);
// 	foreach($teachers as $teacher):
// 		var_dump($teacher->firstName);
// 	endforeach;
	
// 	foreach($supporters as $supporter):
// 		var_dump($supporter->title);
// 	endforeach;

// 	foreach($promotioners as $promotioner):
// 		var_dump($promotioner->title);
// 	endforeach;

// 	var_dump($course->company->title);
// 	var_dump($course->category->title);

// 	//var_dump($course->category->title);
// 	//var_dump($course->category->title);
// 	//var_dump($course->category->title);
// 	//
// //	dd($course->teachers);
// });
