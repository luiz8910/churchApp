<?php

namespace App\Providers;

use App\Repositories\SpeakerCategoryRepository;
use App\Repositories\SpeakerRepository;
use App\Repositories\SpeakerRepositoryEloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;


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
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StateRepository::class, \App\Repositories\StateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PersonRepository::class, \App\Repositories\PersonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleRepository::class, \App\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GroupRepository::class, \App\Repositories\GroupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EventRepository::class, \App\Repositories\EventRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\VisitorRepository::class, \App\Repositories\VisitorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ChurchRepository::class, \App\Repositories\ChurchRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ResponsibleRepository::class, \App\Repositories\ResponsibleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FrequencyRepository::class, \App\Repositories\FrequencyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecentUsersRepository::class, \App\Repositories\RecentUsersRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecentGroupsRepository::class, \App\Repositories\RecentGroupsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecentEventsRepository::class, \App\Repositories\RecentEventsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RequiredFieldsRepository::class, \App\Repositories\RequiredFieldsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RegisterModelsRepository::class, \App\Repositories\RegisterModelsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EventSubscribedListRepository::class, \App\Repositories\EventSubscribedListRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UploadStatusRepository::class, \App\Repositories\UploadStatusRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GeofenceRepository::class, \App\Repositories\GeofenceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ImportRepository::class, \App\Repositories\ImportRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeedRepository::class, \App\Repositories\FeedRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReportRepository::class, \App\Repositories\ReportRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SiteRepository::class, \App\Repositories\SiteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContactSiteRepository::class, \App\Repositories\ContactSiteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AboutItemRepository::class, \App\Repositories\AboutItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeaturesRepository::class, \App\Repositories\FeaturesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeaturesItemRepository::class, \App\Repositories\FeaturesItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\IconRepository::class, \App\Repositories\IconRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FaqRepository::class, \App\Repositories\FaqRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlansRepository::class, \App\Repositories\PlansRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TypePlansRepository::class, \App\Repositories\TypePlansRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlansItensRepository::class, \App\Repositories\PlansItensRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CreditCardRepository::class, \App\Repositories\CreditCardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CodeRepository::class, \App\Repositories\CodeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BugRepository::class, \App\Repositories\BugRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaymentRepository::class, \App\Repositories\PaymentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AdminRepository::class, \App\Repositories\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ExhibitorsCategoriesRepository::class, \App\Repositories\ExhibitorsCategoriesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ExhibitorsRepository::class, \App\Repositories\ExhibitorsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SponsorRepository::class, \App\Repositories\SponsorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SponsorCategoryRepository::class, \App\Repositories\SponsorCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SpeakerRepository::class, \App\Repositories\SpeakerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SpeakerCategoryRepository::class, \App\Repositories\SpeakerCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProviderRepository::class, \App\Repositories\ProviderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProviderCategoryRepository::class, \App\Repositories\ProviderCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DocumentRepository::class, \App\Repositories\DocumentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PollRepository::class, \App\Repositories\PollRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PollItensRepository::class, \App\Repositories\PollItensRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PollAnswerRepository::class, \App\Repositories\PollAnswerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AnswerRepositoryRepository::class, \App\Repositories\AnswerRepositoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AnswerRepository::class, \App\Repositories\AnswerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SessionRepository::class, \App\Repositories\SessionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeedbackRepository::class, \App\Repositories\FeedbackRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AllowedPaymentsRepository::class, \App\Repositories\AllowedPaymentsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaymentsMethodsRepository::class, \App\Repositories\PaymentsMethodsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\QuestionRepository::class, \App\Repositories\QuestionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeedbackSessionRepository::class, \App\Repositories\FeedbackSessionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeedbackSessionTypeRepository::class, \App\Repositories\FeedbackSessionTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeedbackSessionTypeRepository::class, \App\Repositories\FeedbackSessionTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SessionLikesRepository::class, \App\Repositories\SessionLikesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SessionCheckRepository::class, \App\Repositories\SessionCheckRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UrlRepository::class, \App\Repositories\UrlRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaymentSlipRepository::class, \App\Repositories\PaymentSlipRepositoryEloquent::class);
        //:end-bindings:
    }
}
