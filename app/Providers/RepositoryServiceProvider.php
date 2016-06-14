<?php

namespace Teachat\Providers;

use Illuminate\Support\ServiceProvider;
use Teachat\Repositories\Eloquent\AnnouncementsEloquent;
use Teachat\Repositories\Eloquent\AppointmentsEloquent;
use Teachat\Repositories\Eloquent\ChildrenEloquent;
use Teachat\Repositories\Eloquent\CurriculumEloquent;
use Teachat\Repositories\Eloquent\GradesEloquent;
use Teachat\Repositories\Eloquent\SchoolEloquent;
use Teachat\Repositories\Eloquent\StateUsEloquent;
use Teachat\Repositories\Eloquent\SubjectCategoryEloquent;
use Teachat\Repositories\Eloquent\TeacherProfileEloquent;
use Teachat\Repositories\Eloquent\TeacherSubjectsEloquent;
use Teachat\Repositories\Eloquent\UserEloquent;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;
use Teachat\Repositories\Interfaces\AppointmentsInterface;
use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\CurriculumInterface;
use Teachat\Repositories\Interfaces\GradesInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\SubjectCategoryInterface;
use Teachat\Repositories\Interfaces\TeacherProfileInterface;
use Teachat\Repositories\Interfaces\TeacherSubjectsInterface;
use Teachat\Repositories\Interfaces\UserInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserEloquent::class);
        $this->app->bind(SchoolInterface::class, SchoolEloquent::class);
        $this->app->bind(StateUsInterface::class, StateUsEloquent::class);
        $this->app->bind(TeacherProfileInterface::class, TeacherProfileEloquent::class);
        $this->app->bind(SubjectCategoryInterface::class, SubjectCategoryEloquent::class);
        $this->app->bind(GradesInterface::class, GradesEloquent::class);
        $this->app->bind(CurriculumInterface::class, CurriculumEloquent::class);
        $this->app->bind(AnnouncementsInterface::class, AnnouncementsEloquent::class);
        $this->app->bind(ChildrenInterface::class, ChildrenEloquent::class);
        $this->app->bind(TeacherSubjectsInterface::class, TeacherSubjectsEloquent::class);
        $this->app->bind(AppointmentsInterface::class, AppointmentsEloquent::class);
    }
}
