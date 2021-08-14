<?php

namespace App\Sprint;

use Illuminate\Support\Arr;
use App\Sprint\Contracts\CreatesProjects;
use App\Sprint\Contracts\CreatesAgencies;
use App\Sprint\Contracts\CreatesNewUsers;

class Sprint
{
    /**
     * The user model that should be used by Sprint.
     *
     * @var string
     */
    public static $userModel = 'App\\Models\\Auth\\User';

    /**
     * The project model that should be used by Sprint.
     *
     * @var string
     */
    public static $projectModel = 'App\\Models\\Project';

    /**
     * The membership model that should be used by Sprint.
     *
     * @var string
     */
    public static $membershipModel = 'App\\Models\\Membership';

    /**
     * Get the name of the user model used by the application.
     *
     * @return string
     */
    public static function showsUserObject()
    {
        return config('sprint.show-user-object');
    }

    /**
     * Get the name of the user model used by the application.
     *
     * @return string
     */
    public static function userModel()
    {
        return static::$userModel;
    }

    /**
     * Get a new instance of the user model.
     *
     * @return mixed
     */
    public static function newUserModel()
    {
        $model = static::userModel();

        return new $model;
    }

    /**
     * Get the name of the project model used by the application.
     *
     * @return string
     */
    public static function projectModel()
    {
        return static::$projectModel;
    }

    /**
     * Get a new instance of the project model.
     *
     * @return mixed
     */
    public static function newProjectModel()
    {
        $model = static::projectModel();

        return new $model;
    }

    /**
     * Specify the team model that should be used by Sprint.
     *
     * @param  string  $model
     * @return static
     */
    public static function useTeamModel(string $model)
    {
        static::$teamModel = $model;

        return new static;
    }

    /**
     * Get the name of the membership model used by the application.
     *
     * @return string
     */
    public static function membershipModel()
    {
        return static::$membershipModel;
    }

    /**
     * Specify the membership model that should be used by Sprint.
     *
     * @param  string  $model
     * @return static
     */
    public static function useMembershipModel(string $model)
    {
        static::$membershipModel = $model;

        return new static;
    }

    /**
     * Find a user instance by the given ID.
     *
     * @param  int  $id
     * @return mixed
     */
    public static function findUserByIdOrFail($id)
    {
        return static::newUserModel() -> where('id', $id) -> firstOrFail();
    }

    /**
     * Find a user instance by the given email address or fail.
     *
     * @param  string  $email
     * @return mixed
     */
    public static function findUserByEmailOrFail(string $email)
    {
        return static::newUserModel() -> where('email', $email) -> firstOrFail();
    }

    /**
     * Register a class / callback that should be used to create new users.
     *
     * @param  string  $callback
     * @return void
     */
    public static function createUsersUsing(string $callback)
    {
        return app() -> singleton(CreatesNewUsers::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create new users.
     *
     * @param  string  $callback
     * @return void
     */
    public static function createProjectsUsing(string $callback)
    {
        return app() -> singleton(CreatesProjects::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create new users.
     *
     * @param  string  $callback
     * @return void
     */
    public static function createAgenciesUsing(string $callback)
    {
        return app() -> singleton(CreatesAgencies::class, $callback);
    }

    /**
     * Determine if the application is using the terms confirmation feature.
     *
     * @return bool
     */
    public static function hasTermsAndPrivacyPolicyFeature()
    {
        return Features::hasTermsAndPrivacyPolicyFeature();
    }

    /**
     * Determine if the application is using any account deletion features.
     *
     * @return bool
     */
    public static function hasAccountDeletionFeatures()
    {
        return Features::hasAccountDeletionFeatures();
    }
    
}