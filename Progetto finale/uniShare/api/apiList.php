<?php
/*
 * Questo file contiene un array che al suo interno ha tutte le api disponibili al sito web. in questo modo,
 * evito che un utente maligno carichi il suo script e lo possa richiamare come api.
 * Evito quindi di valutare o eseguire input diretto dell'utente, passando sempre attraverso un elenco di funzionalità
 * hardcoded.
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

$available_apis["get_notes"]["FILE"] = "./res/API_SEARCH_DOCUMENTS.php";
$available_apis["get_notes"]["FUNC"] = "ApiSearchNotes";

$available_apis["get_bought_notes"]["FILE"] = "./res/API_GET_ACQUIRED_NOTES.php";
$available_apis["get_bought_notes"]["FUNC"] = "getBoughtNotes";

$available_apis["get_sale"]["FILE"] = "./res/API_GET_SALE.php";
$available_apis["get_sale"]["FUNC"] = "getSales";

$available_apis["admin_get_users"]["FILE"] = "./res/API_ADMIN_GET_USERS.php";
$available_apis["admin_get_users"]["FUNC"] = "adminGetUserList";

$available_apis["admin_list_notes"]["FILE"] = "./res/API_ADMIN_LIST_NOTES.php";
$available_apis["admin_list_notes"]["FUNC"] = "listDocuments";

$available_apis["get_teachers"]["FILE"] = "./res/API_GET_TEACHERS.php";
$available_apis["get_teachers"]["FUNC"] = "getTeachers";

/*SET APIS*/
$available_apis["user_widget_pos_set"]["FILE"] = "./res/API_SET_DASHBOARD_WIDGET.php";
$available_apis["user_widget_pos_set"]["FUNC"] = "setDashboardWidget";

$available_apis["update_user_info"]["FILE"] = "./res/API_SET_USER_DATA.php";
$available_apis["update_user_info"]["FUNC"] = "updateUserInformation";

$available_apis["add_bought_item"]["FILE"] = "./res/API_BUY.php";
$available_apis["add_bought_item"]["FUNC"] = "buy";

$available_apis["pull_note"]["FILE"] = "./res/API_PULL_NOTE_FROM_SALE.php";
$available_apis["pull_note"]["FUNC"] = "pullFromSale";

$available_apis["promote_user"]["FILE"] = "./res/API_PROMOTE_ADMIN.php";
$available_apis["promote_user"]["FUNC"] = "promote";

$available_apis["add_review"]["FILE"] = "./res/API_ADD_REVIEW.php";
$available_apis["add_review"]["FUNC"] = "insertReview";

$available_apis["update_psw"]["FILE"] = "./res/API_CHANGE_PASSWORD.php";
$available_apis["update_psw"]["FUNC"] = "updatePassword";

$available_apis["cashflow"]["FILE"] = "./res/API_ADMIN_GET_CASHFLOW.php";
$available_apis["cashflow"]["FUNC"] = "getCash";

$available_apis["chart_income"]["FILE"] = "./res/API_GET_CHART_INCOME.php";
$available_apis["chart_income"]["FUNC"] = "getIncomeChart";

$available_apis["chart_buy"]["FILE"] = "./res/API_CHART_GET_NOTES.php";
$available_apis["chart_buy"]["FUNC"] = "getChartNotes";

/*DELETE APIS */
$available_apis["drop_note"]["FILE"] = "./res/API_DELETE_NOTE.php";
$available_apis["drop_note"]["FUNC"] = "deleteNote";

$available_apis["drop_user"]["FILE"] = "./res/API_DELETE_USER.php";
$available_apis["drop_user"]["FUNC"] = "deleteUser";