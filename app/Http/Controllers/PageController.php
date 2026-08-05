<?php

namespace App\Http\Controllers;

use App\Models\MailerSetting;
use App\Models\User;
use App\Models\SettingRole;
use App\Models\UserDepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function page_dashboard()
    {
        return view('pages.dashboard');
    }

    public function page_NotificationTest()
    {
        return view('pages.settings.notification_test', [
            'roles' => SettingRole::orderBy('role_name')->get(['id', 'role_name']),
            'departments' => UserDepartment::orderBy('name')->get(['id', 'name']),
            'users' => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function page_UserManagement()
    {


        return view('pages.settings.usersmanagement');
    }
    public function page_Mailer()
    {

        $config = MailerSetting::latest()->first();
        return view('pages.settings.mailer', compact('config'));
    }
    public function page_Menus()
    {
        return view('pages.settings.menus');
    }

    public function page_Themes()
    {
        return view('pages.settings.theme');
    }
    public function page_Users()
    {
        return view('pages.settings.users');
    }
    public function page_TeamManagement()
    {
        return view('pages.settings.team_management');
    }
    public function page_settings()
    {
        return view('pages.settings.settings');
    }

    public function page_AppSettings()
    {
        return view('pages.recruitment.app_settings');
    }

    public function page_Applicants()
    {
        return view('pages.recruitment.applicants');
    }

    public function page_OrientationSchedule()
    {
        return view('pages.recruitment.orientation_schedule');
    }

    public function profile()
    {
        return "page profile";
    }

    public function settings()
    {
        return "page settings";
    }
}
