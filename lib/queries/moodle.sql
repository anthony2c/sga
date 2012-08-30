select mdl_user.id as userid, upper(concat(lastname, ' ', firstname)) as studentname, mdl_role.name as rolename 
from mdl_user, mdl_enrol, mdl_user_enrolments, 
	mdl_course, mdl_role_assignments, mdl_role 
where mdl_role_assignments.roleid = mdl_role.id
	and mdl_role_assignments.userid = mdl_user.id 
	and mdl_user.id = mdl_user_enrolments.userid
	and mdl_user_enrolments.enrolid = mdl_enrol.id  
	and mdl_enrol.courseid = mdl_course.id
	and mdl_role.shortname = 'student' 
group by mdl_user.id, firstname, lastname, mdl_role.name