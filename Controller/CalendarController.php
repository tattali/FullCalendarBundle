<?php

namespace AncaRebeca\FullCalendarBundle\Controller;

use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function loadAction(Request $request)
    {
        $startDate = new \DateTime($request->get('start'));
        $endDate = new \DateTime($request->get('end'));
        $filters = $request->get('filters', []);
        $content = [];

        try {
            $content = $this
                ->get('anca_rebeca_full_calendar.service.calendar')
                ->getData($startDate, $endDate, $filters);
            $status = empty($content) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        } catch (\Exception $exception) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($content);
        $response->setStatusCode($status);

        return $response;
    }
}