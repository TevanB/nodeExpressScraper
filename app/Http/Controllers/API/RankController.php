<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
class RankController extends Controller
{
  public function getRank(Request $input)
  {
    $data = json_decode(file_get_contents('output.json'));
    return json_encode($data);

  }

}
?>
