<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Package;
use App\Models\Participant;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'setting' => SiteSetting::query()->firstOrFail(),
            'contact' => Contact::query()->firstOrFail(),
            'facilities' => Facility::visible()->get(),
            'galleries' => Gallery::visible()->get(),
            'packages' => Package::visible()->get(),
            'participants' => Participant::visible()->get(),
        ]);
    }
}
