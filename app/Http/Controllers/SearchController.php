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
        $searchData = $this->getJson($searchTerm,1);
        //why is this not passing back to the page properly.
        return back()->with(['searchData' => $searchData, 'searchTerm',$searchTerm]);
    }


    /**Get Json from API
     * Ideally with time this would be moved out to a service
     * @param string $searchTerm
     * @param int $pageNumber
     * @return array
     */
    public function getJson($searchTerm, $pageNumber)
    {
        $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=fdac2e9676991ac53b34651adab52518&text=' . $searchTerm . '&per_page=5&page='.$pageNumber.'&format=json&nojsoncallback=1';
        $results = json_decode(file_get_contents($url), true);
        $searchData['pageNumber'] = $results['photos']['page'];
        $searchData['pages'] = $results['photos']['pages'];
        $searchData['searchTerm'] = $searchTerm;
        $searchResults = [];

        if ($results) {
            foreach ($results['photos']['photo'] as $photos) {

                //this should be a modelled object instead of an array

                $d['title'] = $photos['title'];
                $d['farm'] = $photos['farm'];
                $d['id'] = $photos['id'];
                $d['secret'] = $photos['secret'];
                $d['server'] = $photos['server'];
                $searchResults[] = $d;
            }
        }
        $searchData['searchResults'] = $searchResults;
        return $searchData;
    }


    public function ajax(Request $request){

        $pageNumber = $request->pageNumber ? $request->pageNumber: 1;

        $searchTerm = $request->searchTerm;
        $search = new Search();
        $search->searchTerm = $searchTerm;
        $search->user_id = Auth::user()->id;
        $search->save();
        $searchData = $this->getJson($searchTerm, $pageNumber);
        return $searchData;
    }


}
