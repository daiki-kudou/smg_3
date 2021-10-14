<?php

use Illuminate\Database\Seeder;
use App\Models\Agent;

class AgentsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('agents')->truncate();
    // factory(\App\Models\Agent::class, 200)->create();
    DB::insert(
      'INSERT INTO agents 
    (id, name, company, post_code, address1, address2, address3, person_firstname, person_lastname, firstname_kana, lastname_kana, person_mobile, person_tel, fax, email, cost, payment_limit, payment_day, payment_remark, site, site_url, login, site_id, site_pass, agent_remark, site_remark, deal_remark, cxl, cxl_url, cxl_remark, last_remark, created_at, updated_at) 
    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
      [1, 'アクセア', '株式会社アクセア', NULL, NULL, NULL, NULL, '戸水', '愛子', NULL, NULL, NULL, NULL, NULL, NULL, 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-06-17 19:18:04', '2021-06-29 14:56:28']
    );
    DB::insert(
      'INSERT INTO agents 
    (id, name, company, post_code, address1, address2, address3, person_firstname, person_lastname, firstname_kana, lastname_kana, person_mobile, person_tel, fax, email, cost, payment_limit, payment_day, payment_remark, site, site_url, login, site_id, site_pass, agent_remark, site_remark, deal_remark, cxl, cxl_url, cxl_remark, last_remark, created_at, updated_at) 
    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
      [2, '日本会議室', NULL, NULL, NULL, NULL, NULL, '担当者なし', '　', NULL, NULL, NULL, NULL, NULL, NULL, 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-06-17 19:18:43', '2021-06-17 19:18:43']
    );
    DB::insert(
      'INSERT INTO agents 
    (id, name, company, post_code, address1, address2, address3, person_firstname, person_lastname, firstname_kana, lastname_kana, person_mobile, person_tel, fax, email, cost, payment_limit, payment_day, payment_remark, site, site_url, login, site_id, site_pass, agent_remark, site_remark, deal_remark, cxl, cxl_url, cxl_remark, last_remark, created_at, updated_at) 
    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
      [3, '会議室コンシェルジュ', NULL, NULL, NULL, NULL, NULL, '担当者なし', '　', NULL, NULL, NULL, NULL, NULL, NULL, 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-06-17 19:19:12', '2021-06-17 19:19:12']
    );
    DB::insert(
      'INSERT INTO agents 
    (id, name, company, post_code, address1, address2, address3, person_firstname, person_lastname, firstname_kana, lastname_kana, person_mobile, person_tel, fax, email, cost, payment_limit, payment_day, payment_remark, site, site_url, login, site_id, site_pass, agent_remark, site_remark, deal_remark, cxl, cxl_url, cxl_remark, last_remark, created_at, updated_at) 
    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
      [4, 'インスタベース', NULL, NULL, NULL, NULL, NULL, '担当者なし', '　', NULL, NULL, NULL, NULL, NULL, NULL, 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-06-17 19:20:44', '2021-06-17 19:20:44']
    );
    DB::insert(
      'INSERT INTO agents 
    (id, name, company, post_code, address1, address2, address3, person_firstname, person_lastname, firstname_kana, lastname_kana, person_mobile, person_tel, fax, email, cost, payment_limit, payment_day, payment_remark, site, site_url, login, site_id, site_pass, agent_remark, site_remark, deal_remark, cxl, cxl_url, cxl_remark, last_remark, created_at, updated_at) 
    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
      [5, 'スペースマーケット', NULL, NULL, NULL, NULL, NULL, '担当者なし', '　', NULL, NULL, NULL, NULL, NULL, NULL, 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-06-17 19:21:53', '2021-06-17 19:21:53']
    );
    DB::insert(
      'INSERT INTO agents 
    (id, name, company, post_code, address1, address2, address3, person_firstname, person_lastname, firstname_kana, lastname_kana, person_mobile, person_tel, fax, email, cost, payment_limit, payment_day, payment_remark, site, site_url, login, site_id, site_pass, agent_remark, site_remark, deal_remark, cxl, cxl_url, cxl_remark, last_remark, created_at, updated_at) 
    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
      [6, 'スペイシー', NULL, NULL, NULL, NULL, NULL, '担当者なし', '　', NULL, NULL, NULL, NULL, NULL, NULL, 25, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'https://osaka-conference.com/cancelpolicy/', NULL, NULL, '2021-06-17 19:22:15', '2021-07-27 22:30:04']
    );
    DB::insert(
      'INSERT INTO agents 
    (id, name, company, post_code, address1, address2, address3, person_firstname, person_lastname, firstname_kana, lastname_kana, person_mobile, person_tel, fax, email, cost, payment_limit, payment_day, payment_remark, site, site_url, login, site_id, site_pass, agent_remark, site_remark, deal_remark, cxl, cxl_url, cxl_remark, last_remark, created_at, updated_at) 
    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
      [7, '※仲介会社テスト（高木）', '高木株式会社', '5500015', '大阪府', '大阪市西区南堀江', NULL, '高木', '美佐', NULL, NULL, NULL, NULL, NULL, NULL, 30, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-07-16 14:28:08', '2021-07-16 14:28:08']
    );
  }
}
