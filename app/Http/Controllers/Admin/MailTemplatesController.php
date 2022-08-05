<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailTemplate;

class MailTemplatesController extends Controller
{
	public function index()
	{
		return view('admin.mail_templates.index');
	}

	public function show($id)
	{
		$template = MailTemplate::find($id);
		return view('admin.mail_templates.show', [
			'id' => $id,
			'template' => $template
		]);
	}

	public function update(Request $request)
	{
		$validatedData = $request->validate([
			'subtitle' => 'required',
			'body' => 'required',
		], [
			'subtitle.required' => '※表題は必須項目です',
			'body.required' => '※表題は必須項目です',

		]);

		$data = $request->all();
		$template = MailTemplate::find($data['id'])
			->update(
				[
					'subtitle' => $data['subtitle'],
					'body' => $data['body'],
				]
			);
		return redirect(route('admin.mail_templates.show', $data['id']))->with('flash_message', '※更新に成功しました');
	}

	public function cron()
	{
		return view('admin.mail_templates.cron');
	}
}
