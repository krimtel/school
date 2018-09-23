<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth';
$route['shakuntala/login'] = 'Auth';
$route['sharda/login'] = 'Auth';
$route['shakuntala/logout'] = 'Auth/logout';
$route['sharda/logout'] = 'Auth/logout';


$route['sharda/dashboard'] = 'Admin_ctrl';
$route['sharda/admin/session'] = 'Admin_ctrl/session';
$route['sharda/master-record/session'] = 'Admin_ctrl/session';
$route['sharda/admin/add-student'] = 'Admin_ctrl/student_add';
$route['sharda/master-record/add-student'] = 'Admin_ctrl/student_add';
$route['sharda/master-record/add-teacher'] = 'Admin_ctrl/add_teacher';
$route['sharda/admin/add-subject'] = 'Admin_ctrl/subject';
$route['sharda/master-record/add-subject'] = 'Admin_ctrl/subject';
$route['sharda/admin/attendance'] = 'Admin_ctrl/student_attendance';
$route['sharda/transaction-record/attendance'] = 'Admin_ctrl/student_attendance';
$route['sharda/admin/marks_entry'] = 'Admin_ctrl/marks_entry';
$route['sharda/transaction-record/marks_entry'] = 'Admin_ctrl/marks_entry';
$route['sharda/admin/subject-allocation'] = 'Admin_ctrl/subject_allocation_entry';
$route['sharda/transaction-record/subject-allocation'] = 'Admin_ctrl/subject_allocation_entry';
$route['sharda/admin/add-class'] = 'Admin_ctrl/class_add';
$route['sharda/admin/add-section'] = 'Admin_ctrl/section';
$route['sharda/admin/mark-preview'] = 'Admin_ctrl/marks_preview';
$route['sharda/production-reporting/mark-preview'] = 'Admin_ctrl/marks_preview';
$route['sharda/production-reporting/mark-preview-high-class'] = 'Admin_ctrl/mark_preview_high_class';
$route['sharda/admin/marksheet_generation'] = 'Admin_ctrl/marksheet_generation';
$route['sharda/production-reporting/marksheet_generation'] = 'Admin_ctrl/marksheet_generation';
$route['sharda/admin/students-record'] = 'Admin_ctrl/students_report';
$route['sharda/reports/students-record'] = 'Admin_ctrl/students_report';
$route['sharda/admin/new_window'] = 'Admin_ctrl/new_window';
$route['sharda/admin/new'] = 'Admin_ctrl/new_w';
$route['sharda/master-record/add-user'] = 'Admin_ctrl/add_user_role';
$route['sharda/master-record/class_subjects'] = 'Admin_ctrl/class_wise_subject_allocation';
$route['sharda/master-record/exam-type'] = 'Admin_ctrl/add_exam_type';
$route['sharda/utility_tool/upload_photo'] = 'Admin_ctrl/upload_photo';
$route['sharda/reports/teachers_abstract'] = 'Admin_ctrl/teachers_abstract';
$route['sharda/master-record/class-teacher'] = 'Admin_ctrl/class_teacher';
$route['sharda/transaction-record/attendence-entry'] = 'Admin_ctrl/attendence_entry';
$route['sharda/reports/log-report'] = 'Admin_ctrl/log_report';
$route['sharda/transaction-record/marks_entry_high_class'] = 'Admin_ctrl/marks_entry_high_class';
$route['sharda/production-reporting/high-class-marksheet-generation'] = 'Admin_ctrl/high_class_marksheet_generation';
$route['sharda/production-reporting/marks-entry-check'] = 'Admin_ctrl/marks_entry_check';
$route['sharda/web/student_record'] = 'Admin_webctrl';
$route['sharda/transaction-record/compart_marks_entry'] = 'Admin_ctrl/compart_marks_entry';
$route['sharda/production-reporting/compart_marksheet_generation'] = 'Admin_ctrl/compart_marksheet_generation';
$route['sharda/transaction-record/compart_marks_entry_high_class'] = 'Admin_ctrl/compart_marks_entry_high_class';
$route['sharda/production-reporting/compart_high-class-marksheet-generation'] = 'Admin_ctrl/compart_high_class_marksheet_generation';


///////////////////////////////////////// shakuntala school /////////////////////////////////////////




$route['shakuntala/dashboard'] = 'Admin_ctrl';
$route['shakuntala/admin/session'] = 'Admin_ctrl/session';
$route['shakuntala/master-record/session'] = 'Admin_ctrl/session';
$route['shakuntala/admin/add-student'] = 'Admin_ctrl/student_add';
$route['shakuntala/master-record/add-student'] = 'Admin_ctrl/student_add';
$route['shakuntala/master-record/add-teacher'] = 'Admin_ctrl/add_teacher';
$route['shakuntala/admin/add-subject'] = 'Admin_ctrl/subject';
$route['shakuntala/master-record/add-subject'] = 'Admin_ctrl/subject';
$route['shakuntala/admin/attendance'] = 'Admin_ctrl/student_attendance';
$route['shakuntala/transaction-record/attendance'] = 'Admin_ctrl/student_attendance';
$route['shakuntala/admin/marks_entry'] = 'Admin_ctrl/marks_entry';
$route['shakuntala/transaction-record/marks_entry'] = 'Admin_ctrl/marks_entry';

$route['shakuntala/transaction-record/compart_marks_entry'] = 'Admin_ctrl/compart_marks_entry';
$route['shakuntala/admin/subject-allocation'] = 'Admin_ctrl/subject_allocation_entry';
$route['shakuntala/transaction-record/subject-allocation'] = 'Admin_ctrl/subject_allocation_entry';
$route['shakuntala/admin/add-class'] = 'Admin_ctrl/class_add';
$route['shakuntala/admin/add-section'] = 'Admin_ctrl/section';
$route['shakuntala/admin/mark-preview'] = 'Admin_ctrl/marks_preview';
$route['shakuntala/production-reporting/mark-preview'] = 'Admin_ctrl/marks_preview';
$route['shakuntala/production-reporting/mark-preview-high-class'] = 'Admin_ctrl/mark_preview_high_class';
$route['shakuntala/admin/marksheet_generation'] = 'Admin_ctrl/marksheet_generation';
$route['shakuntala/production-reporting/marksheet_generation'] = 'Admin_ctrl/marksheet_generation';
$route['shakuntala/production-reporting/compart_marksheet_generation'] = 'Admin_ctrl/compart_marksheet_generation';
$route['shakuntala/admin/students-record'] = 'Admin_ctrl/students_report';
$route['shakuntala/reports/students-record'] = 'Admin_ctrl/students_report';
$route['shakuntala/admin/new_window'] = 'Admin_ctrl/new_window';
$route['shakuntala/admin/new'] = 'Admin_ctrl/new_w';
$route['shakuntala/master-record/add-user'] = 'Admin_ctrl/add_user_role';
$route['shakuntala/master-record/class_subjects'] = 'Admin_ctrl/class_wise_subject_allocation';
$route['shakuntala/master-record/exam-type'] = 'Admin_ctrl/add_exam_type';
$route['shakuntala/utility_tool/upload_photo'] = 'Admin_ctrl/upload_photo';
$route['shakuntala/reports/teachers_abstract'] = 'Admin_ctrl/teachers_abstract';
$route['shakuntala/master-record/class-teacher'] = 'Admin_ctrl/class_teacher';
$route['shakuntala/transaction-record/attendence-entry'] = 'Admin_ctrl/attendence_entry';
$route['shakuntala/reports/log-report'] = 'Admin_ctrl/log_report';
$route['shakuntala/transaction-record/marks_entry_high_class'] = 'Admin_ctrl/marks_entry_high_class';
$route['shakuntala/transaction-record/compart_marks_entry_high_class'] = 'Admin_ctrl/compart_marks_entry_high_class';
$route['shakuntala/production-reporting/high-class-marksheet-generation'] = 'Admin_ctrl/high_class_marksheet_generation';
$route['shakuntala/production-reporting/compart_high-class-marksheet-generation'] = 'Admin_ctrl/compart_high_class_marksheet_generation';
$route['shakuntala/production-reporting/marks-entry-check'] = 'Admin_ctrl/marks_entry_check';
$route['shakuntala/web/student_record'] = 'Admin_webctrl';
$route['shakuntala/web/bus'] = 'Admin_webctrl/bus';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
