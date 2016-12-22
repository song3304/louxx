<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Addons\Core\Events\ControllerEvent::class => [
            'App\Listeners\ControllerListener@handle',
        ],
        \Addons\Core\Events\BeforeControllerEvent::class => [
            'App\Listeners\BeforeControllerListener@handle',
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\Weixin\WeixinExtendSocialite@handle',
            'SocialiteProviders\WeixinWeb\WeixinWebExtendSocialite@handle',
            'SocialiteProviders\Weibo\WeiboExtendSocialite@handle',
            'SocialiteProviders\QQ\QqExtendSocialite@handle',
        ],
    ];

    /**
     * 要注册的订阅者类。
     *
     * @var array
     */
    protected $subscribe = [
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
