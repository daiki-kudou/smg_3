<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;



class DataTableController extends Controller
{
  public function ReservationDataTablesAjax(Request $request)
  {

    if (empty($request)) {
      ## Read value
      $draw = 0;
      $start = 0;
      $rowperpage = 10; // Rows display per page

      // Total records
      $totalRecords = Reservation::all()->count();

      // Fetch records
      $records = Reservation::select('*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

      $data_arr = array();

      foreach ($records as $record) {
        $id = $record->id;
        $reserve_date = $record->reserve_date;

        $data_arr[] = array(
          "id" => $id,
          "reserve_date" => $reserve_date,
        );
      }

      $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "aaData" => $data_arr
      );
      echo json_encode($response);
      exit;
    } else {
      ## Read value
      $draw = $request->get('draw');
      $start = $request->get("start");
      $rowperpage = $request->get("length"); // Rows display per page

      $columnIndex_arr = $request->get('order');
      $columnName_arr = $request->get('columns');
      $order_arr = $request->get('order');
      $search_arr = $request->get('search');

      $columnIndex = $columnIndex_arr[0]['column']; // Column index
      $columnName = $columnName_arr[$columnIndex]['data']; // Column name
      $columnSortOrder = $order_arr[0]['dir']; // asc or desc

      // Total records
      $totalRecords = Reservation::all()->count();

      // Fetch records
      $records = Reservation::orderBy($columnName, $columnSortOrder)
        ->select('reservations.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

      $data_arr = array();

      foreach ($records as $record) {
        $id = $record->id;
        $reserve_date = $record->reserve_date;

        $data_arr[] = array(
          "id" => $id,
          "reserve_date" => $reserve_date,
        );
      }

      $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "aaData" => $data_arr
      );


      echo json_encode($response);
      exit;
    }
  }
}
