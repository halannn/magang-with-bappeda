<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\LaporanKegiatan;
use App\Policies\LaporanKegiatanPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The model to policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    LaporanKegiatan::class => LaporanKegiatanPolicy::class,
  ];

  /**
   * Register any authentication / authorization services.
   */
  public function boot(): void
  {
    $this->registerPolicies();

    //
  }
}
