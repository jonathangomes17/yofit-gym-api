<?php

declare(strict_types=1);

use App\Modules\Gym\Handler\StudentTraining\StudentAvailableTrainingsHandler;
use App\Modules\Gym\Handler\StudentTraining\StudentEnabledTrainingHandler;
use App\Modules\Gym\Handler\StudentTraining\StudentOtherTrainingsHandler;
use FastRoute\RouteCollector;
use App\Infrastructure\Router;
use App\Modules\Gym\Handler\Training\TrainingCreateHandler;
use App\Modules\Gym\Handler\Training\TrainingDetailHandler;
use App\Modules\Gym\Handler\Training\TrainingUpdateHandler;
use App\Modules\Gym\Handler\Activity\ActivityCreateHandler;
use App\Modules\Gym\Handler\Activity\ActivityDetailHandler;
use App\Modules\Gym\Handler\Activity\ActivityUpdateHandler;
use App\Modules\Gym\Handler\Activity\ActivityDeleteHandler;
use App\Modules\Gym\Handler\Activity\ActivityAssociateTrainingHandler;
use App\Modules\Gym\Handler\User\UserCreateHandler;
use App\Modules\Gym\Handler\User\UserUpdateHandler;
use App\Modules\Gym\Handler\User\UserDeleteHandler;
use App\Modules\Gym\Handler\StudentTraining\StudentSearchActivitiesHandler;
use App\Modules\Gym\Handler\StudentTraining\StudentSearchTrainingsHandler;
use App\Modules\Gym\Handler\StudentTraining\StudentEnrolTrainingCreateHandler;
use App\Modules\Gym\Handler\StudentTraining\StudentTrainingChangeStatusHandler;
use App\Modules\Gym\Handler\StudentTrainingProgress\StudentTrainingProgressCreateHandler;
use App\Modules\Gym\Handler\StudentTrainingProgress\StudentTrainingProgressChangeStatusHandler;

return function (RouteCollector $r): void {
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->addGroup('/v1', function (RouteCollector $r) {
            $r->addGroup('/training', function (RouteCollector $r) {
                $r->post('', [TrainingCreateHandler::class, Router::$IS_PUBLIC]);

                $r->get('/{uuid}', [TrainingDetailHandler::class, Router::$IS_PUBLIC]);

                $r->put('', [TrainingUpdateHandler::class, Router::$IS_PUBLIC]);
            });

            $r->addGroup('/activity', function (RouteCollector $r) {
                $r->post('', [ActivityCreateHandler::class, Router::$IS_PUBLIC]);

                $r->get('/{uuid}', [ActivityDetailHandler::class, Router::$IS_PUBLIC]);

                $r->put('', [ActivityUpdateHandler::class, Router::$IS_PUBLIC]);

                $r->delete('/{uuid}', [ActivityDeleteHandler::class, Router::$IS_PUBLIC]);

                $r->post('/{uuid_activity}/training/{uuid_training}/sections/{sections}', [
                    ActivityAssociateTrainingHandler::class,
                    Router::$IS_PUBLIC
                ]);
            });

            $r->addGroup('/user', function (RouteCollector $r) {
                $r->post('', [UserCreateHandler::class, Router::$IS_PUBLIC]);

                $r->put('', [UserUpdateHandler::class, Router::$IS_PUBLIC]);

                $r->delete('/{uuid}', [UserDeleteHandler::class, Router::$IS_PUBLIC]);
            });

            $r->addGroup('/student-training', function (RouteCollector $r) {
                $r->post('', [StudentEnrolTrainingCreateHandler::class, Router::$IS_PUBLIC]);

                $r->patch('/{uuid}/change-status', [StudentTrainingChangeStatusHandler::class, Router::$IS_PUBLIC]);

                $r->get('/{uuid}/trainings', [StudentSearchTrainingsHandler::class, Router::$IS_PUBLIC]);

                $r->get('/{uuid}/available-trainings', [StudentAvailableTrainingsHandler::class, Router::$IS_PUBLIC]);

                $r->get('/{uuid}/enabled-training', [StudentEnabledTrainingHandler::class, Router::$IS_PUBLIC]);

                $r->get('/{uuid}/other-trainings', [StudentOtherTrainingsHandler::class, Router::$IS_PUBLIC]);

                $r->get('/{uuid}/training/{student_training_uuid}/activities', [
                    StudentSearchActivitiesHandler::class,
                    Router::$IS_PUBLIC
                ]);
            });

            $r->addGroup('/student-training-progress', function (RouteCollector $r) {
                $r->post('', [StudentTrainingProgressCreateHandler::class, Router::$IS_PUBLIC]);

                $r->patch('/{student_training_uuid}/student-training/{activity_uuid}/activity/change-status', [
                    StudentTrainingProgressChangeStatusHandler::class,
                    Router::$IS_PUBLIC
                ]);
            });
        });
    });
};
