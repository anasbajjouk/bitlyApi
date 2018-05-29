<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{


    public function index()
    {
        return view('welcome');
    }


    public function store(Request $request)
    {
        // Validation Form
        $this->validate($request,[
            'urladdress'=>'required',
            'radio'=>'required'
        ]);
        
        // Variables 
        $radio = $request->input('radio'); // Radio checked value
        $url_before = $request->input('urladdress'); // URL ADDRESS
        $ACCESS_TOKEN=env('BITLY_ACCESS_TOKEN'); // ACCESS TOKEN FROM  BITLY ACCOUNT
 

        if($radio == "shorten"){

            // Calling the getUrl Method in order to shorten the URL
            return Url::getUrl($url_before, $ACCESS_TOKEN);

        }else{

            // Calling the getExpandUrl  Method in order to expand the URL
            return Url::getExpandUrl($url_before, $ACCESS_TOKEN);

        }


    }

  
}
