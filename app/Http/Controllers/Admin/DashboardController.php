<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Package;
use App\Models\Participant;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'facilityCount' => Facility::count(),
            'galleryCount' => Gallery::count(),
            'packageCount' => Package::count(),
            'participantCount' => Participant::count(),
        ]);
    }
}
