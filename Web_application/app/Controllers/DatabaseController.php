<?php

namespace App\Controllers;

use App\Models\AccountType;
use App\Models\DatabaseLogger;
use Core\Controller;

class DatabaseController extends Controller
{
    public function getDatabaseLogger()
    {
        $search = "";
        if (!isset($_GET["pag"])) header('Location: index.php?page=admin/database_logger&pag=1');
        $limit = 5;
        $page = isset($_GET["pag"]) ? $_GET["pag"] : 0;
        $totalRow = DatabaseLogger::countRowsForDatabaseLogger();
        $totalPages = ceil($totalRow / $limit);
        $log = DatabaseLogger::selectLoggerContent($limit, $page);
        $paginationStart = max(1, $page - floor($limit / 2));
        $paginationEnd = $paginationStart + $limit - 1;

        if ($paginationEnd > $totalPages) {
            $paginationEnd = $totalPages;
            $paginationStart = max(1, $paginationEnd - $limit + 1);
        }
        //we will search by account type we need account type values to list as select choice.
        //we need textual values only
        $acTypes = AccountType::getRecordsFromAccountTypeTable();

        $this->view(
            "admin/database_logger",
            [
                "log" => $log,
                "total_pages" => $totalPages,
                "page" => $page,
                "pagStart" => $paginationStart,
                "pagEnd" => $paginationEnd,
                "aType" => $acTypes,
                "search" => $search
            ]
        );
    }
    public function getDatabaseLoggerSearch()
    {
     
        $searchedValue = (isset($_POST["account_type"]) ? $_POST["account_type"] : "");
        
        //(!isset($_SESSION["searched_at"])) ? $_SESSION["searched_at"] = $searchedValue : $searchedValue = $_SESSION["searched_at"];
        if(!isset($_SESSION["searched_at"])){
            $_SESSION["searched_at"] = $searchedValue;
        }elseif($_SESSION["searched_at"]!=$_POST["account_type"]){
            $_SESSION["searched_at"] = $_POST["account_type"];
        }
        else{
            $searchedValue = $_SESSION["searched_at"];
        }
       
        $page = isset($_GET["pag"]) ? $_GET["pag"] : 0;
        $limit = 5;
        $totalRow = DatabaseLogger::countRowsForDatabaseLoggerSearch($searchedValue);
        $totalPages = ceil($totalRow / $limit);
        $log = DatabaseLogger::selectLoggerContentSearch($searchedValue, $limit, $page);

        $paginationStart = max(1, $page - floor($limit / 2));
        $paginationEnd = $paginationStart + $limit - 1;

        if ($paginationEnd > $totalPages) {
            $paginationEnd = $totalPages;
            $paginationStart = max(1, $paginationEnd - $limit + 1);
        }

        $this->view("admin/database_logger_search", [
            "log" => $log,
            "search" => $searchedValue,
            "total_pages" => $totalPages,
            "page" => $page,
            "pagStart" => $paginationStart,
            "pagEnd" => $paginationEnd,
            "searched" => $searchedValue
        ]);
    }
}
