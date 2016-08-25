<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        $searchTerm = $request->searchTerm;

        //todo upsert rather then create a new one each time.
        $search = new Search();
        $search->searchTerm = $searchTerm;
        $search->user_id = Auth::user()->id;
        $search->save();
        $searchResults = $this->getJson($searchTerm);

        //why is this not passing back to the page properly.
        return back()->with(['searchResults' => $searchResults], 'searchTerm',$searchTerm);
    }


    /**Get Json from API
     * Ideally with time this would be moved out to a service
     * @param $searchTerm
     * @return array
     */
    public function getJson($searchTerm)
    {
        $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=6d5c5a20d108f8f56f324394d3e2381f&text=' . $searchTerm . '&per_page=5&format=json&nojsoncallback=1';
        $results = json_decode(file_get_contents($url), true);
        $searchResults = [];
        if ($results) {
            foreach ($results['photos']['photo'] as $photos) {
                $d['title'] = $photos['title'];
                $d['farm'] = $photos['farm'];
                $d['id'] = $photos['id'];
                $d['secret'] = $photos['secret'];
                $d['server'] = $photos['server'];
                $searchResults[] = $d;
            }
        }
        return $searchResults;
    }
}
