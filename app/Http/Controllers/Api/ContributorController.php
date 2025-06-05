<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Class\Contributors; // Although not used for search anymore, keeping for context
use App\Database\BD;

class ContributorController extends Controller
{
    /**
     * Search for contributors by name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $searchTerm = $request->query('name');

        if (empty($searchTerm) || strlen($searchTerm) < 3) {
            return response()->json([]);
        }


        $lowerSearchTerm = strtolower($searchTerm);
        $query = "SELECT * , nombre AS name FROM contributors WHERE LOWER(nombre) LIKE ?";
        $params = ["%{$lowerSearchTerm}%"];
        $searchResults = BD::getDataWithQuery($query, $params);

        $formattedResults = $searchResults;


        return response()->json($formattedResults);
    }
}
