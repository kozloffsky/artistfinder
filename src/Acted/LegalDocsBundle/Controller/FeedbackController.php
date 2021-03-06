<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Form\FeedbackCreateType;
use Acted\LegalDocsBundle\Form\FeedbackRatingCreateType;
use JMS\Serializer\Tests\Serializer\DateIntervalFormatTest;
use Acted\LegalDocsBundle\Repository\FeedbackRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

use Acted\LegalDocsBundle\Entity\Feedback;

class FeedbackController extends Controller
{
    /**
     * Add rating for artist from client
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Add rating for artist from client",
     *  input="Acted\LegalDocsBundle\Form\FeedbackRatingCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function addRatingAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $feedbackRatingCreateForm = $this->createForm(FeedbackRatingCreateType::class, null, ['method' => 'POST']);
        $feedbackRatingCreateForm->handleRequest($request);

        if ($feedbackRatingCreateForm->isSubmitted() && (!$feedbackRatingCreateForm->isValid())) {
            return new JsonResponse($serializer->toArray($feedbackRatingCreateForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if (empty($user)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'User is not authorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = $feedbackRatingCreateForm->getData();

        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ], Response::HTTP_BAD_REQUEST);
        }

        $event = $data['event'];
        $artist = $data['artist'];
        $rating = $data['rating'];

        $feedbackRepo = $em->getRepository('ActedLegalDocsBundle:Feedback');
        $feedback = $feedbackRepo->findOneBy(array(
            'artist' => $artist,
            'event' => $event
        ));

        if (!empty($feedback)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Feedback has already had record with these event and artist'
            ], Response::HTTP_BAD_REQUEST);
        }

        //check event date
        $timestampStartingEvent = $event->getStartingDate()->getTimestamp();
        $rangeTimestamp = 12 * 60 * 60;
        $currentTimestamp = strtotime('today');

        if (($timestampStartingEvent * $rangeTimestamp) < $currentTimestamp) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Feedback already exists'
            ], Response::HTTP_BAD_REQUEST);
        }

        $feedback = new Feedback();
        $feedback->setArtist($artist);
        $feedback->setEvent($event);
        $feedback->setRating($rating);
        $em->persist($feedback);
        $em->flush();

        $average = $feedbackRepo->getAverageArtistRating($artist);
        $average = $average['averageRating'];
        $total = $feedbackRepo->countArtistFeedbacks($artist);
        $total = $total[0]['countRows'];
        $artistRepo = $em->getRepository('ActedLegalDocsBundle:Artist');
        $artist = $artistRepo->find($artist);
        $artist->setAverageRating($average);
        $artist->setTotalRatings($total);
        $em->persist($artist);
        $em->flush();


        //Send notification email
        $feedbackManager = $this->get('app.feedback.manager');
        $feedbackManager->sendNotify($user, $feedback);

        return new JsonResponse(array(
            'status' => 'success'
        ), Response::HTTP_OK);
    }

    /**
     * Add feedback and rating for artist from client
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Add feedback and rating for artist from client",
     *  input="Acted\LegalDocsBundle\Form\FeedbackCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function addFeedbackRatingAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $feedbackCreateForm = $this->createForm(FeedbackCreateType::class, null, ['method' => 'POST']);
        $feedbackCreateForm->handleRequest($request);

        if ($feedbackCreateForm->isSubmitted() && (!$feedbackCreateForm->isValid())) {
            return new JsonResponse($serializer->toArray($feedbackCreateForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if (empty($user)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'User is not authorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = $feedbackCreateForm->getData();
        $event = $data['event'];
        $artist = $data['artist'];
        $rating = $data['rating'];
        $feedbackText = $data['feedback'];

        $feedbackRepo = $em->getRepository('ActedLegalDocsBundle:Feedback');
        $feedback = $feedbackRepo->findOneBy(array(
            'artist' => $artist,
            'event' => $event
        ));

        //check event date
        $timestampStartingEvent = $event->getStartingDate()->getTimestamp();
        $rangeTimestamp = 12 * 60 * 60;
        $currentTimestamp = strtotime('today');

        if (($timestampStartingEvent * $rangeTimestamp) < $currentTimestamp) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Feedback already exists'
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!empty($feedback) && !empty($feedback->getFeedback())) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Feedback already exists'
            ], Response::HTTP_BAD_REQUEST);
        }

        // feedback is not exists yet
        if (empty($feedback)) {
            $feedbackObj = new Feedback();
            $feedbackObj->setArtist($artist);
            $feedbackObj->setEvent($event);
            $feedbackObj->setRating($rating);
            $feedbackObj->setFeedback($feedbackText);
            $em->persist($feedbackObj);
            $em->flush();

            $average = $feedbackRepo->getAverageArtistRating($artist);
            $average = $average['averageRating'];
            $total = $feedbackRepo->countArtistFeedbacks($artist);
            $total = $total[0]['countRows'];
            $artistRepo = $em->getRepository('ActedLegalDocsBundle:Artist');
            $artist = $artistRepo->find($artist);
            $artist->setAverageRating($average);
            $artist->setTotalRatings($total);
            $em->persist($artist);
            $em->flush();

            //Send notification email
            $feedbackManager = $this->get('app.feedback.manager');
            $feedbackManager->sendNotify($user, $feedbackObj);
        }

        //there is rating without feedback
        if (!empty($feedback) && empty($feedback->getFeedback())) {
            $feedback->setArtist($artist);
            $feedback->setEvent($event);
            $feedback->setRating($rating);
            $feedback->setFeedback($feedbackText);
            $em->persist($feedback);
            $em->flush();
        }

        return new JsonResponse(array(
            'status' => 'success',
        ), Response::HTTP_OK);
    }

    /**
     * get average rating
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get average rating",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param Artist $artist
     * @return JsonResponse
     */
    public function getAverageRatingAction(Request $request, $artist)
    {
        $em = $this->getDoctrine()->getManager();
        $feedbackRepo = $em->getRepository('ActedLegalDocsBundle:Feedback');
        $data = $feedbackRepo->getAverageArtistRating($artist);
        $countFeedbacks = $feedbackRepo->countArtistFeedbacks($artist);
        return new JsonResponse(array(
            'status' => 'success',
            'total' => $countFeedbacks[0]['countRows'],
            'averageRating' => $data['averageRating']
        ), Response::HTTP_OK);
    }

    /**
     * get feedbacks by artist
     *
     * @ApiDoc(
     *  resource=true,
     *  description="get feedbacks by artist",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param Artist $artist
     * @param integer $page
     * @param integer $size
     * @return JsonResponse
     */
    public function getFeedbacksAction(Request $request, Artist $artist, $page, $size)
    {
        $em = $this->getDoctrine()->getManager();
        $feedbackRepo = $em->getRepository('ActedLegalDocsBundle:Feedback');

        $artistFeedbacks = $feedbackRepo->getArtistFeedbacks($artist, $page, $size);

        return new JsonResponse(array(
            'status' => 'success',
            'feedbacks' => $artistFeedbacks['feedbacks']
        ), Response::HTTP_OK, array(
            'count' => $artistFeedbacks['countRows']
        ));
    }

    /**
     * get feedback
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get feedback",
     *  input="Acted\LegalDocsBundle\Form\FeedbackRatingCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function getFeedbackAction(Request $request)
    {

    }

    /**
     * Return all not viewed feedbacks for Artist.
     *
     * @return
     */
    public function getMonthFeedbacksAction()
    {
        $user = $this->getUser();
        $response = ['status' => 'success', 'feedbacks' => []];

        if ($user->getArtist()) {
            $id = $user->getArtist()->getId();
            $em = $this->getEM();
            $repo = $em->getRepository('ActedLegalDocsBundle:Feedback');
            $feedbacks = $repo->getArtistMonthFeedbacks($id);

            $serializer = $this->get('jms_serializer');
            $context = SerializationContext::create()->setGroups('messages_feedbacks');
            $feedbacks = $serializer->toArray($feedbacks, $context);
            $response = ['status' => 'success', 'feedbacks' => $feedbacks];
        }
        return new JsonResponse($response);
    }

    /**
     * Remove feedback.
     *
     * @param Request $request
     * @param $feedback
     *
     * @return JsonResponse
     */
    public function removeFeedbackAction(Request $request, $feedback)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getEM();
        $repo = $em->getRepository('ActedLegalDocsBundle:Feedback');
        $feedback = $repo->find($feedback);
        $em->remove($feedback);
        $em->flush();
        return new JsonResponse([
            'status' => 'success'
        ], Response::HTTP_OK);
    }
}
