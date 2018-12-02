<?php
namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Configuration;

class HomeController_1 extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageModel  = null;
        $pageId     = Configuration::getConfiguration('general_home_page');

        if (null !== $pageId) {
            $pageModel = Page::find($pageId);
        }

        return view('home.index')->with('pageModel', $pageModel);
    }
}
