<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    public function __construct()
    {
        // Share pending submissions with all views for admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            View::share('submissions', $this->getPendingSubmissions());
        }
    }
    
    protected function getPendingSubmissions()
    {
        if (!Storage::disk('local')->exists('online_submissions.json')) {
            return [];
        }
        
        $submissions = json_decode(Storage::disk('local')->get('online_submissions.json'), true) ?? [];
        
        // Filter only pending submissions and sort by newest
        $pendingSubmissions = array_filter($submissions, function($submission) {
            return $submission['status'] === 'pending';
        });
        
        // Sort by created_at descending
        usort($pendingSubmissions, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return $pendingSubmissions;
    }
}
