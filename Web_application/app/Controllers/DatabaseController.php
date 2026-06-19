<?php

namespace App\Controllers;

use App\Models\DatabaseLogger;
use Core\Controller;

class DatabaseController extends Controller
{
    public function getDatabaseLogger()
    {
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

        $this->view(
            "admin/database_logger",
            [
                "log" => $log,
                "total_pages" => $totalPages,
                "page" => $page,
                "pagStart" => $paginationStart,
                "pagEnd" => $paginationEnd
            ]
        );
    }
}
