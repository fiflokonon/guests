<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Action\User\RegisterAction;
use App\Action\User\LoginAction;
use App\Action\User\UsersAction;
use App\Action\User\UserAction;
use App\Action\User\ChangeStatusAction;
use App\Action\User\EditUserAction;
use App\Action\User\DeleteUserAction;
use App\Domain\Core\Middleware\LoginMiddleware;
use App\Domain\Core\Middleware\CorsMiddleware;
use App\Action\User\GetMeAction;
use App\Action\Event\EventAction;
use App\Action\Event\EditEventAction;
use App\Action\Event\EventsAction;
use App\Action\Event\CreateEventAction;
use App\Action\Event\DeleteEventAction;
use App\Action\Event\EventsForUserAction;
use App\Action\Event\TodayEventsAction;
use App\Action\Event\UserTodayEventsAction;
use App\Action\Event\PastEventsAction;
use App\Action\Event\UserPastEventsAction;
use App\Action\Event\ComingEventsAction;
use App\Action\Event\UserComingEventsAction;
use App\Action\Photo\GetActivePhotoAction;
use App\Action\Photo\AddPhotoAction;
use App\Action\Photo\PhotoAction;
use App\Action\Photo\PhotosAction;
use App\Action\Photo\UpdatePhotoAction;
use App\Action\Photo\UserPhotosAction;
use App\Action\Photo\DeletePhotoAction;
use App\Action\Invitation\CreateInvitationAction;
use App\Action\Invitation\DeleteInvitationAction;
use App\Action\Invitation\InvitationAction;
use App\Action\Invitation\InvitationsAction;
use App\Action\Invitation\EventInvitationsAction;

return function (App $app) {
    $app->get('/', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write('Hello, World!');
        return $response;
    });
    /**************************************************
     ************  ROUTES   ***************************
     **************************************************/

    /** ROUTES WITHOUT AUTHENTIFICATION */

    $app->post('/register', RegisterAction::class)->add(CorsMiddleware::class);
    $app->post('/login', LoginAction::class)->add(CorsMiddleware::class);
    $app->get('/api/users', UsersAction::class)->add(CorsMiddleware::class);
    $app->get('/api/events', EventsAction::class);
    /** ROUTES WITH AUTHENTIFICATION  */
    $app->group('/api', function (RouteCollectorProxy $app)
    {
        $app->get('/users/me', GetMeAction::class);
        #$app->get('/users', UsersAction::class);
        $app->get('/users/{id}', UserAction::class);
        $app->put('/users/{id}/change-status', ChangeStatusAction::class);
        $app->put('/users/{id}/edit',EditUserAction::class);
        $app->delete('/users/{id}/delete', DeleteUserAction::class);

        #$app->get('/events', EventsAction::class);
        $app->get('/events/{id}', EventAction::class);
        $app->get('/users/{id}/events', EventsForUserAction::class);
        $app->post('/users/{id}/events', CreateEventAction::class);
        $app->put('/events/{id}', EditEventAction::class);
        $app->delete('/events/{id}', DeleteEventAction::class);
        $app->get('/past-events', PastEventsAction::class);
        $app->get('/coming-events', ComingEventsAction::class);
        $app->get('/today-events', TodayEventsAction::class);
        $app->get('/users/{id}/past-events', UserPastEventsAction::class);
        $app->get('/users/{id}/coming-events', UserComingEventsAction::class);
        $app->get('/users/{id}/today-events', UserTodayEventsAction::class);

        $app->get('/photos', PhotosAction::class);
        $app->get('/photos/{id}', PhotoAction::class);
        $app->get('/users/{id}/active-photo', GetActivePhotoAction::class);
        $app->get('/users/{id}/photos', UserPhotosAction::class);
        $app->put('/photos/{id}', UpdatePhotoAction::class);
        $app->delete('/photos/{id}', DeletePhotoAction::class);
        $app->post('/users/{id}/photos', AddPhotoAction::class);

        $app->post('/events/{id}/invitations', CreateInvitationAction::class);
        $app->get('/invitations-list', InvitationsAction::class);
        $app->get('/events/{id}/invitations', EventInvitationsAction::class);
        $app->get('/invitations/{id}', InvitationAction::class);
        $app->delete('/invitations/{id}', DeleteInvitationAction::class);
    })->add(LoginMiddleware::class)->add(CorsMiddleware::class);

};
