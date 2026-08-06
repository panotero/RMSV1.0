<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavMenu extends Model
{
    use HasFriendlyDates;

    protected $table = 'nav_menus';
    // App\Models\NavMenu.php

    protected $fillable = [
        'title',
        'icon',
        'link',
        'allowed_roles',
        'allowed_office',
        'parent_menu',
        'menu_order',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
    ];
}
