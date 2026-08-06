<?php

namespace App\Controllers;

use App\Helpers\FilesHelper;
use App\Helpers\Validation;
use App\Models\AccountType;
use App\Models\Image;
use App\Models\ProfileDetail;
use App\Models\ProfileLogger;
use Core\Controller;
use Core\Auth;
use App\Models\User;



class UserController extends Controller
{
        //activate helpers for checking and creating user image folders if they are not existing
        public function index()
        {
                Auth::requireLogin();

                $userWithoutAddress = User::selectNumAddress($_SESSION["user"]["id"]);
                $userWithoutImage = User::selectNumImage($_SESSION["user"]["id"]);

                if ($userWithoutAddress > 0) {
                        //$profil=User::profileData($_SESSION['user']['id']);
                        $profil = "";
                } else {
                        $profil = User::profileData($_SESSION['user']['id']);
                        if ($profil == false) {
                                $profil = [];
                                $userImage = [];
                        } else {
                                $userImage = Image::selectUserImage($_SESSION["user"]["id"], 'p');
                        }
                }

                if ($userWithoutImage === 0 || $userWithoutImage == false) {
                        $userImage = "";
                } else {
                        $userImage = Image::selectUserImage($_SESSION["user"]["id"], 'p');
                }


                $this->view('users/profile', [
                        'profil' => $profil,
                        'profileImage' => $userImage,
                        'userImage' => $userWithoutImage,
                        'usrAddr' => $userWithoutAddress,
                ]);
        }
        public function edit()
        {
                Auth::requireLogin();
                $profil = User::profileData($_GET["id"]);
                $this->view('users/update', [
                        'profil' => $profil
                ]);
        }
        public function update()
        {
                Auth::requireLogin();
                $validation = Validation::validateForm();
                if ($validation === true) {
                        User::updateProfileTable($_POST);
                        $_SESSION['update'] = "Successfully updated profile.";
                        $profil = User::profileData($_SESSION['user']['id']);
                        header('Location: index.php');
                        $this->view(
                                'users/profile',
                                ['profil' => $profil]
                        );
                } else {
                        $profil = User::profileData($_SESSION['user']['id']);
                        $this->view('users/update', [
                                'errors' => $validation,
                                'profil' => $profil,
                                'data' => $_POST,
                        ]);
                }
        }
        public function updateProfileImage()
        {
                Auth::requireLogin();
                //if user does not have profile image
                if (isset($_GET["option"])) {
                        //if option is insert then user can insert profile image in database
                        //before that, view with a form will be shown
                        if ($_GET["option"] === "insert") {
                                $this->view('users/profile_img_update');
                        }
                } else {
                        $_SESSION["fullUrl"] = FilesHelper::displayFullUrl();
                        if (isset($_SESSION["imageUploadError"])) {
                                unset($_SESSION["imageUploadError"]);
                        }
                        $currentDirectory = isset($_GET["id"]) ? $_GET["id"] : 0;
                        $directory = FilesHelper::returnCurrentUrl($currentDirectory);
                        $profileMarkImage = isset($_GET["profileMarkImage"]) ? $_GET["profileMarkImage"] : '';
                        $userImage = Image::selectUserImage($_SESSION["user"]["id"], $profileMarkImage);
                        $this->view('users/profile_img_update', [
                                'directory' => $directory,
                                'profileImage' => $userImage,
                        ]);;
                };
        }
        //current profile will be last inserted by user
        public function updateImg()
        {
                Auth::requireLogin();
                $errors = [];
                $imgName = Image::uploadImage(FilesHelper::returnCurrentUrl($_SESSION["user"]["id"]));
                $image = $_POST;
                $url = isset($_SESSION["url"]) ? $_SESSION["url"] : "";
                if (isset($_SESSION["imageUploadError"])) {

                        $url = $_SESSION["fullUrl"];
                        unset($_SESSION["fullUrl"]);
                        //return to image update
                        header('Location: ' . $url);
                } else {
                        $errors = Image::insertNewImageRecord($image, $imgName, $url);
                        $id = Image::getLatestId($_SESSION["user"]["id"]);
                        $errors = Image::updateProfileMarkImage($_SESSION["user"]["id"]);
                        $errors = Image::updateProfileMarkImageToNewImage($id["max"], $_SESSION["user"]["id"]);
                        if (empty($errors)) {
                                unset($_SESSION["url"]);
                                header('Location:index.php?page=users/profile');
                        }
                }
        }
        public function editAccountType()
        {
                Auth::requireLogin();
                Auth::requireAdmin();
                $accountTypeList = AccountType::getAllRecordsFromAccountTypeTable();
                if (isset($_GET["id"])) {
                        $profileDetailsId = ProfileDetail::getProfileDetailId($_GET["id"]);
                        $currentRole = ProfileDetail::getAccountTypeId($_GET["id"]);
                }

                $this->view(
                        'users/update_account_type',
                        [
                                'account_type' => $accountTypeList,
                                'id' => $profileDetailsId,
                                'role' => $currentRole
                        ]
                );
        }
        public function insertNewImage()
        {
                Auth::requireLogin();
                $errors = [];

                $imageName = Image::uploadImage(FilesHelper::returnCurrentUrl($_SESSION["user"]["id"]));

                $image = $_POST;

                $url = isset($_SESSION["url"]) ? $_SESSION["url"] : "";
                if (isset($_SESSION["imageUploadError"])) {

                        $url = $_SESSION["fullUrl"];
                        unset($_SESSION["fullUrl"]);
                        //return to image update
                        header('Location: ' . $url);
                } else {
                        $errors = Image::insertNewImageRecord($image, $imageName, $url);
                        $id = Image::getLatestId($_SESSION["user"]["id"]);

                        if (empty($errors)) {
                                unset($_SESSION["url"]);
                                header('Location:index.php?page=users/profile');
                        }
                }
        }
        public function profile_log_index()
        {
                Auth::requireLogin();
                Auth::requireAdmin();
                $search = "";
                //this is a fix to prevent empty list and pagination available for next previous 
                if (!isset($_GET["pag"])) header('Location: index.php?page=profile_log&pag=1');

                $limit = 5;
                $page = isset($_GET["pag"]) ? $_GET["pag"] : 0;
                $totalRow = ProfileLogger::countRowsForProfileLog();
                $logList = ProfileLogger::getProfileLogWithPagination($limit, $page);
                $totalPages = ceil(($totalRow / $limit));

                $paginationStart = max(1, $page - floor($limit / 2));
                $paginationEnd = $paginationStart + $limit - 1;

                if ($paginationEnd > $totalPages) {
                        $paginationEnd = $totalPages;
                        $paginationStart = max(1, $paginationEnd - $limit + 1);
                }

                $this->view(
                        "admin/user_log",
                        [
                                "users" => $logList,
                                "total_pages" => $totalPages,
                                "page" => $page,
                                "pagStart" => $paginationStart,
                                "pagEnd" => $paginationEnd,
                                "search" => $search
                        ]
                );
        }
        public function profile_log_index_search()
        {
                Auth::requireLogin();
                Auth::requireAdmin();
                $searchedValue = (isset($_POST["username"]) ? $_POST["username"] : "");
                (!isset($_SESSION["searched"])) ? $_SESSION["searched"] = $searchedValue : $searchedValue = $_SESSION["searched"];

                $page = isset($_GET["pag"]) ? $_GET["pag"] : 0;
                $limit = 5;

                $users = ProfileLogger::searchByUsernameWithPagination($searchedValue, $limit, $page);
                $totalRow = ProfileLogger::countRowsForProfileLogSearch($searchedValue);


                $totalPages = ceil(($totalRow / $limit));

                $paginationStart = max(1, $page - floor($limit / 2));
                $paginationEnd = $paginationStart + $limit - 1;

                if ($paginationEnd > $totalPages) {
                        $paginationEnd = $totalPages;
                        $paginationStart = max(1, $paginationEnd - $limit + 1);
                }

                $this->view(
                        "admin/user_log_search",
                        [
                                "users" => $users,
                                "search" => $searchedValue,
                                "total_pages" => $totalPages,
                                "page" => $page,
                                "pagStart" => $paginationStart,
                                "pagEnd" => $paginationEnd,
                                "searched" => $searchedValue
                        ]
                );
        }
        public function manage_users()
        {
                Auth::requireLogin();
                Auth::requireAdmin();
                $userId = $_SESSION['user']['id'];
                if (!isset($_GET["pag"])) header('Location: index.php?page=admin/user_management&pag=1');
                $limit = 5;
                $page = isset($_GET["pag"]) ? $_GET["pag"] : 0;
                $uData = User::getUserData($userId, $limit, $page);
                $totalRow = User::selectCountRowsForUserData($userId);
                $totalPages = ceil(($totalRow / $limit));

                $paginationStart = max(1, $page - floor($limit / 2));
                $paginationEnd = $paginationStart + $limit - 1;

                if ($paginationEnd > $totalPages) {
                        $paginationEnd = $totalPages;
                        $paginationStart = max(1, $paginationEnd - $limit + 1);
                }

                $this->view("admin/user_management", [
                        'users' => $uData,
                        "total_pages" => $totalPages,
                        "page" => $page,
                        "pagStart" => $paginationStart,
                        "pagEnd" => $paginationEnd
                ]);
        }
        public function edit_status()
        {
                Auth::requireLogin();
                Auth::requireAdmin();
                $userId = (isset($_GET["id"])) ? $_GET["id"] : 0;
                $listOfAccountTypes = AccountType::getAllRecordsFromAccountTypeTable();
                if ($userId != 0) {
                        $userName = User::getUserNameNoEmailById($userId);
                        $accountStatus = ProfileDetail::selectAccountStatus($userId);
                        $acTypeId = ProfileDetail::getAccountTypeId($userId);
                } else {
                        $userName = [];
                        $accountStatus = [];
                        $acTypeId = [];
                }
                $this->view("admin/change_account_status", [
                        "username" => $userName,
                        "acStatus" => $accountStatus,
                        "acTypes" => $listOfAccountTypes,
                        "acTypeId" => $acTypeId
                ]);
        }
        public function update_account_status()
        {
                Auth::requireLogin();
                Auth::requireAdmin();

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        if (Validation::validateAccountStatusInput($_POST) == true) {
                                $accountStatus = $_POST["accountStatus"];
                                $acId = $_POST["accountType"];
                                $userId = $_POST["userId"];
                                ProfileDetail::updateAccountStatusAndAccountType($accountStatus, $acId, $userId);
                                $_SESSION["msg"] = "Successfully updated status of " . $_POST["username"] . " user";
                                header('Location:index.php?page=admin/user_management');
                        } else {
                                header('Location:index.php?page=admin/account_status&id=' . $_POST["userId"] . '');
                                exit;
                        }
                }
        }
        public function manage_users_search()
        {
                Auth::requireLogin();
                Auth::requireAdmin();

                $userSearched=isset($_POST["user"])?$_POST["user"]:"";
                if($userSearched=="")header('Location: index.php?page=admin/user_management&pag=1');
                $userId = $_SESSION['user']['id'];
                if (!isset($_GET["pag"])) header('Location: index.php?page=admin/user_management_search&pag=1');
                $limit = 5;
                $page = isset($_GET["pag"]) ? $_GET["pag"] : 0;
                $uData = User::getUserDataSearch($userId, $limit, $page,$userSearched);
                $totalRow = User::selectCountRowsForUserDataSearch($userId,$userSearched);
                $totalPages = ceil(($totalRow / $limit));

                $paginationStart = max(1, $page - floor($limit / 2));
                $paginationEnd = $paginationStart + $limit - 1;

                if ($paginationEnd > $totalPages) {
                        $paginationEnd = $totalPages;
                        $paginationStart = max(1, $paginationEnd - $limit + 1);
                }




                $this->view("admin/user_management_search", [
                        'users' => $uData,
                        "total_pages" => $totalPages,
                        "page" => $page,
                        "pagStart" => $paginationStart,
                        "pagEnd" => $paginationEnd
                ]);
        }
        public function showListOfBannedUsers(){
                Auth::requireLogin();
                Auth::requireAdmin();
                $userId = $_SESSION['user']['id'];
                $bannedUsers=User::getListOfBannedUsers($userId);
                $this->view("admin/list_of_banned_users",[
                        'users'=>$bannedUsers
                ]);
        }
}
