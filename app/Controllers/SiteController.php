<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Project;

class SiteController
{
    public function home(): void
    {
        View::render('pages/home', ['projects' => Project::all()]);
    }

    public function project(string $slug): void
    {
        $project = Project::findBySlug($slug);

        if (!$project) {
            http_response_code(404);
            echo 'Project not found';
            return;
        }

        View::render('pages/project', ['project' => $project]);
    }
}
