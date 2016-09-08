<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::group(['middlewareGroups' => ['web']], function () {

    Route::get('/', array('as' => 'home', 'uses' => 'Frontend\HomeController@index'));
    Route::get('auteur', 'Frontend\HomeController@auteur');
    Route::get('page/{id}', 'Frontend\HomeController@page');
    Route::get('colloque', 'Frontend\HomeController@colloque');
    Route::get('contact', 'Frontend\HomeController@contact');
    Route::get('jurisprudence', 'Frontend\JurisprudenceController@index');
    Route::get('unsubscribe/{id?}', 'Frontend\HomeController@unsubscribe');

    Route::post('sendMessage', 'Frontend\HomeController@sendMessage');

    /*
    |--------------------------------------------------------------------------
    | Subscriptions adn newsletter Routes
    |--------------------------------------------------------------------------
    */

    Route::get('newsletter', 'Frontend\NewsletterController@index');
    Route::get('archive', 'Frontend\NewsletterController@archive');
    Route::get('newsletter/campagne/{id}', 'Frontend\NewsletterController@campagne');
    Route::resource('newsletter', 'Frontend\NewsletterController');

    //Route::post('unsubscribe', 'Backend\Newsletter\InscriptionController@unsubscribe');
    //Route::post('subscribe', 'Backend\Newsletter\InscriptionController@subscribe');
    //Route::get('activation/{token}', 'Backend\Newsletter\InscriptionController@activation');
    //Route::post('resend', 'Backend\Newsletter\InscriptionController@resend');
    //Route::get('campagne/{id}', 'Frontend\CampagneController@show');

    /*
    |--------------------------------------------------------------------------
    | Backend Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'admin', 'middleware' => ['auth','administration']], function () {

        Route::get('/', 'Backend\AdminController@index');
        Route::resource('config', 'Backend\ConfigController');

        Route::post('upload', 'Backend\UploadController@upload');
        Route::post('uploadJS', 'Backend\UploadController@uploadJS');
        Route::post('uploadRedactor', 'Backend\UploadController@uploadRedactor');

        Route::get('imageJson/{id?}', ['uses' => 'Backend\UploadController@imageJson']);
        Route::get('fileJson/{id?}', ['uses' => 'Backend\UploadController@fileJson']);

        Route::resource('arret',     'Backend\ArretController');
        Route::resource('analyse',   'Backend\AnalyseController');
        Route::resource('categorie', 'Backend\CategorieController');
        Route::resource('parent', 'Backend\ParentController');
        Route::resource('contenu',   'Backend\ContentController');
        Route::resource('author',    'Backend\AuthorController');
        Route::resource('page',    'Backend\PageController');

        /*
       |--------------------------------------------------------------------------
       | Backend subscriptions, newsletters and campagnes Routes
       |--------------------------------------------------------------------------
       */


        Route::get('ajax/arret/{id}', 'Backend\ArretController@simple'); // build.js
        Route::get('ajax/arrets/{id?}', 'Backend\ArretController@arrets'); // build.js
        Route::get('ajax/categories/{id?}', 'Backend\CategorieController@categories'); // utils.js
        Route::get('ajax/analyses/{id}', 'Backend\AnalyseController@simple');
   /*     
        Route::delete('subscriber', 'Backend\Newsletter\SubscriberController@destroy');
        Route::resource('subscriber', 'Backend\Newsletter\SubscriberController');
        Route::get('subscribers', ['uses' => 'Backend\Newsletter\SubscriberController@subscribers']);

        Route::resource('import', 'Backend\Newsletter\ImportController');
        Route::resource('statistics', 'Backend\Newsletter\StatsController');*/
    });

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    */

    Route::get('auth/login',  'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    /*
    |--------------------------------------------------------------------------
    | Registration Routes
    |--------------------------------------------------------------------------
    */

    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');

    /*
    |--------------------------------------------------------------------------
    | Password reset link request Routes
    |--------------------------------------------------------------------------
    */

    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

    /*
    |--------------------------------------------------------------------------
    |  Password reset Routes
    |--------------------------------------------------------------------------
    */

    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');

    /*
    |--------------------------------------------------------------------------
    |  Testing Routes
    |--------------------------------------------------------------------------
    */

    Route::get('testcampagne', function()
    {


        $csv    = public_path('files/import/import.csv');

        // echo file_get_contents($csv);exit;

        $mailjet = \App::make('App\Droit\Newsletter\Worker\MailjetInterface');

        $dataID = $mailjet->uploadCSVContactslistData(file_get_contents($csv));
        return $mailjet->importCSVContactslistData($dataID->ID);

        //$subscription = \App::make('App\Droit\Newsletter\Repo\NewsletterUserInterface');
        //$user = $subscription->findByEmail( 'cindy.leschaud@gmail.com' );
        //$user->subscriptions()->detach(3);


        //$campagne  = \App::make('App\Droit\Newsletter\Worker\CampagneInterface');
        //$campagnes = $campagne->getSentCampagneArrets();

        //$campagnes  = \App::make('App\Droit\Newsletter\Repo\NewsletterContentInterface');
        //$campagne = $campagnes->find(2);

        /*    $subscription = \App::make('App\Droit\Newsletter\Repo\NewsletterUserInterface');
            $user = $subscription->findByEmail( 'cindy@leschaud.ch' );

            echo '<pre>';
            print_r($user);

            echo '</pre>';*/

    });

});

