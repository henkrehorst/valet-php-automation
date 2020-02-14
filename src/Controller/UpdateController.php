<?php

namespace App\Controller;

use App\Entity\PlatformUpdate;
use App\Service\UpdateFinishService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    private $updateFinishService;

    /**
     * UpdateController constructor.
     * @param UpdateFinishService $updateFinishService
     */
    public function __construct(UpdateFinishService $updateFinishService)
    {
        $this->updateFinishService = $updateFinishService;
    }

    /**
     * @Route("/platform/update/{platformUpdate}", name="update", methods={"POST"})
     * @param Request $request
     * @param PlatformUpdate $platformUpdate
     * @return JsonResponse
     */
    public function finishPlatformUpdate(Request $request, PlatformUpdate $platformUpdate)
    {
        //protect route with api token
        if (getenv('UPDATE_ENDPOINT_TOKEN') === $request->headers->get('token')) {
            //check bottle hash is not empty
            if (!empty($request->get('bottle_hash'))) {
                $platformUpdate = $this->updateFinishService->finishPlatformUpdate($platformUpdate, $request->get('bottle_hash'));

                $updateStatus = $this->updateFinishService->finishUpdate($platformUpdate);
                return JsonResponse::create(['update_status' => $updateStatus]);
            } else {
                return JsonResponse::create(['Error' => [
                    'bottle_hash' => 'bottle hash is not set'
                ]], 404);
            }
        } else {
            return JsonResponse::create(['Error' => 'access denied'], 403);
        }
    }
}
