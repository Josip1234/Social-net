<?php

namespace App\Controllers;

use App\Models\DatabaseLogger;
use Core\Controller;

class DatabaseController extends Controller
{
    public function getDatabaseLogger()
    {
        $log = DatabaseLogger::selectLoggerContent();
        $this->view(
            "admin/database_logger",
            [
                "log" => $log
            ]
        );
    }
}
