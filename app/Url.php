<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Url extends Model
{
    protected $fillable = ['url_before', 'url_after'];

    public static function getUrl($url_before, $ACCESS_TOKEN ){

            $client = new \GuzzleHttp\Client();

            try {

            $requestUrl = sprintf('https://api-ssl.bitly.com/v3/shorten?longUrl=%s&access_token=%s', $url_before, $ACCESS_TOKEN);

            $response = $client->request('GET', $requestUrl , [
                                        'Accept' => 'application/json',
                                        'Content-Type' => 'application/json'
                                        ])->getBody();

            $data = $response->getContents();

            $data = json_decode($data, true);

            $shortUrl = $data['data']['url'];

            // Storing the URLs in the DB
            Url::create([
                'url_before' => $url_before,
                'url_after' => $shortUrl
            ]);

            } catch (\Exception $exception) {
                
                return redirect()->back()->with('message', 'Please re-check the URL!');
                
            }

            return $data;

    }

    public static function getExpandUrl($url_before, $ACCESS_TOKEN ){

            $client = new \GuzzleHttp\Client();

            try {

            $requestUrl = sprintf('https://api-ssl.bitly.com/v3/expand?shortUrl=%s&access_token=%s', $url_before, $ACCESS_TOKEN);

            $response = $client->request('GET', $requestUrl , [
                                        'Accept' => 'application/json',
                                        'Content-Type' => 'application/json'
                                        ])->getBody();

            $data = $response->getContents();

            $data = json_decode($data, true);

            $longUrl = $data['data']['expand'][0]['long_url'];

            // Storing the URLs in the DB

            Url::create([
                'url_before' => $url_before,
                'url_after' => $longUrl
            ]);

            } catch (\Exception $exception) {

                return redirect()->back()->with('message', 'Please re-check the URL!');
                
            }


            return $data;

    }


}