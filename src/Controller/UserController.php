<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * UserController
 *
 * @package App/Controller
 */
class UserController extends ApiController
{
    /**
     * editActivityAction
     *
     * @Route("/user/{id_user}/activity/{id_activity}/edit", name="api_user_organizer_activity_edit", methods={"PUT"})
     *
     * @param int $id_user
     * @param int $id_activity
     * @param Request $request
     * @return Response
     */
    public function editActivityAction($id_user, $id_activity, Request $request)
    {
        $user = $this->validateUser($id_user, true);

        $activity = $this->validateActivity($id_activity);

        if ($user->getId != $activity->getOrganizer()) {
            throw $this->createNotFoundException(
                'User is not organizer that activity'
            );
        }

        $requestData = json_decode($request->getContent(), true);
        empty($requestData['name']) ? true : $activity->setName($requestData['name']);

        $this->getDoctrine()->getRepository(Activity::class)->updateActivity($activity);

        $data = [
            'id' => $activity->getId(),
            'name' => $activity->getName()
        ];
            
        $this->response($data);
    }

    /**
     * deleteActivityAction
     *
     * @Route("/user/{id_user}/activity/{id_activity}/delete", name="api_user_organizer_activity_delete", methods={"DELETE"})
     *
     * @param int $id_user
     * @param int $id_activity
     * @return Response
     */
    public function deleteActivityAction($id_user, $id_activity)
    {
        $user = $this->validateUser($id_user, true);

        $activity = $this->validateActivity($id_activity);

        if ($user->getId != $activity->getOrganizer()) {
            throw $this->createNotFoundException(
                'User is not organizer that activity'
            );
        }

        $this->getDoctrine()->getRepository(Activity::class)->removeActivity($activity);
            
        $this->response(['status' => 'OK']);
    }

    /**
     * getActivitiesOrganizedAction
     *
     * @Route("/user/{id_user}/activitiesOrganized", name="api_user_organizer_get_categories", methods={"GET"})
     *
     * @param int $id_user
     * @return Response
     */
    public function getActivitiesOrganizedAction($id_user)
    {
        $user = $this->validateUser($id_user, true);

        /** @var Activity[] $activities */
        $activities  = $user->getOrganizedActivities();

        $data = [];
        if (!empty($activities)) {
            foreach ($activities as $key => $activity) {
                $data[] = [
                    'name' => $activity->getName()
                ];
            }
        }
    
        $this->response($data);
    }

    /**
     * getActivitiesByCategory
     *
     * @Route("/user/{id_user}/category/{id_category}/activities", name="api_user_organizer_get_categories", methods={"GET"})
     *
     * @param int $id_user
     * @param int $id_category
     * @return Response
     */
    public function getActivitiesByCategory($id_user, $id_category)
    {
        $user = $this->validateUser($id_user);

        $category = $this->validateCategory($id_category);

        $activities = $category->getActivities();

        $data = [];
        if (!empty($activities)) {
            foreach ($activities as $key => $activity) {
                $data[] = [
                    'name' => $activity->getName()
                ];
            }
        }
    
        $this->response($data);
    }

    /**
     * solicitudeAction
     *
     * Format Request
     *  data : {
     *    action : <boolean>
     * }
     *
     * @Route("/user/{id_user}/solicitude", name="api_user_post_solicitude", methods={"POST"})
     *
     * @param int $id_user
     * @param int $id_activity
     * @param Request $request
     * @return Response
     */
    public function solicitudeAction($id_user, $id_activity, Request $request)
    {
        $user = $this->validateUser($id_user);

        $activity = $this->validateActivity($id_activity);

        $requestData = json_decode($request->getContent(), true);

        if (!empty($requestData['action']) and $requestData['action']) {
            $user->addActivities($activity);
            $this->getDoctrine()->getRepository(User::class)->updateUser($user);
        }

        $this->response(['status' => 'OK']);
    }

    /**
     * getActivitiesAction
     *
     * @Route("/user/{id_user}/activities", name="api_user_get_categories", methods={"GET"})
     *
     * @param int $id_user
     * @return Response
     */
    public function getActivitiesAction($id_user)
    {
        $user = $this->validateUser($id_user);

        /** @var Activity[] $activities */
        $activities  = $user->getActivities();

        $data = [];
        if (!empty($activities)) {
            foreach ($activities as $key => $activity) {
                $data[] = [
                    'name' => $activity->getName()
                ];
            }
        }
    
        $this->response($data);
    }

    /**
     * getAllActivitiesAction
     *
     * @Route("/user/{id_user}/allActivities", name="api_user_get_all_activities", methods={"GET"})
     *
     * @param int $id_user
     * @return Response
     */
    public function getAllActivitiesAction($id_user)
    {
        $user = $this->validateUser($id_user);

        $activities = $this->getDoctrine()->getRepository(Activity::class)->findAll();

        $data = [];
        if (!empty($activities)) {
            foreach ($activities as $key => $activity) {
                $data[] = [
                    'name' => $activity->getName()
                ];
            }
        }
    
        $this->response($data);
    }

    /**
     * getAllUsersAction
     *
     * @Route("/user/{id_user}/users", name="api_user_get_all_users", methods={"GET"})
     *
     * @param int $id_user
     * @return Response
     */
    public function getAllUsersAction($id_user)
    {
        $user = $this->validateUser($id_user);

        $users = $this->getDoctrine()->getRepository(Activity::class)->findAll();

        $data = [];
        if (!empty($users)) {
            foreach ($users as $key => $user) {
                $data[] = [
                    'name' => $user->getName()
                ];
            }
        }
    
        $this->response($data);
    }

    /**
     * validateUser
     *
     * @param int $id_user
     * @param bool $organized
     * @return User
     *
     */
    public function validateUser($id_user, $organized = false)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id_user);

        if (empty($user)) {
            throw $this->createNotFoundException(
                'No user found for id '.$id_user
            );
        }

        if ($organized) {
            if (!$user->getOrganizer()) {
                throw $this->createNotFoundException(
                    'User is not organizer'
                );
            }
        }

        return $user;
    }

    /**
     * validateActivity
     *
     * @param int $id_activity
     * @return Activity
     *
     */
    public function validateActivity($id_activity)
    {
        $activity = $this->getDoctrine()->getRepository(Activity::class)->find($id_activity);

        if (empty($activity)) {
            throw $this->createNotFoundException(
                'No activity found for id '.$id_activity
            );
        }

        return $activity;
    }

    /**
     * validateCategory
     *
     * @param int $id_category
     * @return Category
     *
     */
    public function validateCategory($id_category)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id_category);

        if (empty($category)) {
            throw $this->createNotFoundException(
                'No category found for id '.$id_category
            );
        }

        return $category;
    }
}
