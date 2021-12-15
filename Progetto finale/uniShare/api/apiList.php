<?php
/*
 * Questo file contiene un array che al suo interno ha tutte le api disponibili al sito web. in questo modo,
 * evito che un utente maligno carichi il suo script e lo possa richiamare come api.
 *
 * */

$available_apis = Array();

$available_apis["sign_up"]["FILE"] = "./res/API_SIGNUP.php";
$available_apis["sign_up"]["FUNC"] = "signup";

$available_apis["log_in"]["FILE"] = "./res/API_LOGIN.php";
$available_apis["log_in"]["FUNC"] = "login";

$available_apis["log_out"]["FILE"] = "./res/API_LOG_OUT.php";
$available_apis["log_out"]["FUNC"] = "logout";

$available_apis["log_in_check"]["FILE"] = "./res/API_GET_USER_LOGGED.php";
$available_apis["log_in_check"]["FUNC"] = "userIsLogged";


/*GET APIS*/
$available_apis["user_type_get"]["FILE"] = "./res/API_GET_USER_TYPE.php";
$available_apis["user_type_get"]["FUNC"] = "getUserType";

$available_apis["user_info_get"]["FILE"] = "./res/API_GET_USER_INFO.php";
$available_apis["user_info_get"]["FUNC"] = "getUserInfo";

$available_apis["user_dashboard_get"]["FILE"] = "./res/API_GET_USER_DASHBOARD.php";
$available_apis["user_dashboard_get"]["FUNC"] = "getUserDashboard";

$available_apis["get_university_list"]["FILE"] = "./res/API_GET_UNIVERSITA.php";
$available_apis["get_university_list"]["FUNC"] = "apiElencaUniversita";

$available_apis["get_teaching_list"]["FILE"] = "./res/API_GET_INSEGNAMENTI.php";
$available_apis["get_teaching_list"]["FUNC"] = "apiElencaInsegnamenti";

/*SET APIS*/
$available_apis["user_widget_pos_set"]["FILE"] = "./res/API_SET_DASHBOARD_WIDGET.php";
$available_apis["user_widget_pos_set"]["FUNC"] = "setDashboardWidget";

$available_apis["update_user_info"]["FILE"] = "./res/API_SET_USER_DATA.php";
$available_apis["update_user_info"]["FUNC"] = "updateUserInformation";