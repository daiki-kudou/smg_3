<?php

namespace Tests\Unit\Venue;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

use App\Models\Venue;


class VenueTest extends TestCase
{
  public function testDatabase()
  {
    $this->assertTrue(
      Schema::hasColumns('venues', [

        "id",
        "alliance_flag",
        "name_area",
        "name_bldg",
        "name_venue",
        "size1",
        "size2",
        "capacity",
        "eat_in_flag",
        "post_code",
        "address1",
        "address2",
        "address3",
        "remark",
        "first_name",
        "last_name",
        "first_name_kana",
        "last_name_kana",
        "person_tel",
        "person_email",
        "luggage_flag",
        "luggage_post_code",
        "luggage_address1",
        "luggage_address2",
        "luggage_address3",
        "luggage_name",
        "luggage_tel",
        "cost",
        "mgmt_company",
        "mgmt_tel",
        "mgmt_emer_tel",
        "mgmt_first_name",
        "mgmt_last_name",
        "mgmt_person_tel",
        "mgmt_email",
        "mgmt_sec_company",
        "mgmt_sec_tel",
        "mgmt_remark",
        "smg_url",
        "entrance_open_time",
        "backyard_open_time",
        "layout",
        "layout_prepare",
        "layout_clean",
        "reserver_company",
        "reserver_tel",
        "reserver_fax",
        "reserver_remark",
      ]),
      1
    );
  }

  public function testCreateDatabase()
  {
  }
}
