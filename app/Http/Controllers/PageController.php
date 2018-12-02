<?php
namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display the specified page.
     *
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Page::whereSlug($slug)->first();

        return view('page.show')->with('page', $page);
    }
}
