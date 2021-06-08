<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailTemplatesController extends Controller
{
  public function index()
  {
    return view('admin.mail_templates.index');
  }
  public function cron()
  {
    return view('admin.mail_templates.cron');
  }
}
