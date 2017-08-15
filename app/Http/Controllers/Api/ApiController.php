<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Search;
use Request;

/**
 * Class AdminController
 * @package App\Http\Controllers\Api
 * @author johnyoung
 */
class ApiController extends Controller
{
    public function __construct()
    {
    }

    /**
     * 搜房移动端api demo
     * 根据房源id获取出售房源详情
     *
     * @return json数据
     */
    public function getOldHouseSaleById()
    {
        $id = Request::input('id', 0);
        $serchObj = new Search('hs');
        return response()->json($serchObj->searchHouseById($id));
    }
}