<?php

namespace WPXFollowgramLight\Http\Controllers\Dashboard;

use WPXFollowgramLight\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return WPXFollowgramLight()->view('dashboard.index');
    }

    public function widget()
    {
        return WPXFollowgramLight()
      ->view('dashboard.widget')
      ->withAdminScripts('wpxfg-admin');
    }

    public function save()
    {
        WPXFollowgramLight()->options->set('account.user_id', $this->request->get('account.user_id'));
        WPXFollowgramLight()->options->set('account.api_key', $this->request->get('account.api_key'));

        return WPXFollowgramLight()
      ->view('dashboard.index')
      ->with('feedback', 'Options Updated successfully!');
    }
}
