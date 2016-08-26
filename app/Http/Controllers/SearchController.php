<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Simple search response, this redirects back to the home page. this will be replaced entirely by the ajax endpoint.
     * So that is does not need to leave the page
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search(Request $request)
    {

        $searchTerm = $request->searchTerm;

        $searchEntity = Search::where('user_id', Auth::user()->id)->where('searchTerm', $searchTerm)->first();

        if ($searchEntity) {
            $searchEntity->updated_at = new \DateTime();
            $searchEntity->save();
        } else {
            $search = new Search();
            $search->searchTerm = $searchTerm;
            $search->user_id = Auth::user()->id;
            $search->save();

        }

        $searchData = $this->getJson($searchTerm, 1);
        //why is this not passing back to the page properly.
        return back()->with(['searchData' => $searchData, 'searchTerm', $searchTerm]);
    }


    /**
     * Get Json from API
     * Ideally with time this would be moved out to a service
     * @param string $searchTerm
     * @param int $pageNumber
     * @return array
     */
    public function getJson($searchTerm, $pageNumber)
    {
        $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=fdac2e9676991ac53b34651adab52518&text=' . $searchTerm . '&per_page=5&page=' . $pageNumber . '&format=json&nojsoncallback=1';
        $results = json_decode(file_get_contents($url), true);
        $searchData['pageNumber'] = $results['photos']['page'];
        $searchData['pages'] = $results['photos']['pages'];
        $searchData['searchTerm'] = $searchTerm;
        $searchResults = [];

        //Transform into JSON encodable array
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
        $searchData['searchResults'] = $searchResults;
        return $searchData;
    }


    /**
     * Ajax Endpoint
     * @param Request $request
     * @return array
     */
    public function ajax(Request $request)
    {

        $pageNumber = $request->pageNumber ? $request->pageNumber : 1;

        $searchTerm = $request->searchTerm;
        $searchData = $this->getJson($searchTerm, $pageNumber);
        return $searchData;
    }


}
