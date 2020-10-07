<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;

class PageController extends Controller
{
    public function home() {

        $contacts = Contacts::all();

        $response = [
            'contacts' => $contacts
        ];

        return view('contactManager', $response);
    }
}
