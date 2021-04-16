<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function index(){
        $title = "Welcome to the Jungle";
        //return view('pages.index',compact('title'));
        return view('pages.index')->with('title',$title);
    }
    public function about(){
        $title = "About Us";
        return view('pages.about')->with('title',$title);
    }
    public function services(){
        $title = "Services";
        $data=array(
            'title'=>$title,
            'services'=>['Web Development', 'Programming','SEO']
        );
        return view('pages.services')->with($data);
    }
}
