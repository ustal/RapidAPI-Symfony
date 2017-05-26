<?php

/**
 * Created by PhpStorm.
 * User: George Cherenkov
 * Date: 15.05.17
 * Time: 11:25
 */

namespace GoogleDriveBundle\Controller;

use GuzzleHttp\Exception\ConnectException;
use RapidAPI\Exception\PackageException;
use RapidAPI\Exception\RequiredFieldException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PackageController
 * @Route("/api/GoogleDrive")
 */
class PackageController extends Controller
{
    /**
     * @Route("", name="getMetadata")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getMetadata()
    {
        try {
            $metadata = $this->get('metadata');
            $result = $metadata->getClearMetadata();
        } catch (PackageException $exception) {
            $result = $this->createPackageExceptionResponse($exception);
        }
        return new JsonResponse($result);
    }

    /**
     * @Route("/getAccessToken")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function getAccessToken() {
        try {
            $manager = $this->get('manager');
            $sender = $this->get('sender');
            $manager->setBlockName(__FUNCTION__);

            $bodyParams = $manager->getBodyParams();
            $bodyParams['grant_type'] = 'authorization_code';
            $urlParams = $manager->getUrlParams();

            $url = $manager->createFullUrl($bodyParams, 'https://www.googleapis.com');

            $headers['Content-Type'] = "application/x-www-form-urlencoded";

            $data = $manager->createGuzzleData($url, $headers, $urlParams, $bodyParams);

            $result = $sender->send($data);
        } catch (PackageException $exception) {
            $result = $this->createPackageExceptionResponse($exception);
        } catch (RequiredFieldException $exception) {
            $result = $this->createRequiredFieldExceptionResponse($exception);
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/refreshToken")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function refreshToken() {
        try {
            $manager = $this->get('manager');
            $sender = $this->get('sender');

            $manager->setBlockName(__FUNCTION__);

            $bodyParams = $manager->getBodyParams();
            $urlParams = $manager->getUrlParams();

            $url = $manager->createFullUrl($bodyParams);
            $headers['Content-Type'] = "application/x-www-form-urlencoded";
            $bodyParams['grant_type'] = 'refresh_token';

            $data = $manager->createGuzzleData($url, $headers, $urlParams, $bodyParams);

            $result = $sender->send($data);
        } catch (PackageException $exception) {
            $result = $this->createPackageExceptionResponse($exception);
        } catch (RequiredFieldException $exception) {
            $result = $this->createRequiredFieldExceptionResponse($exception);
        } catch (ConnectException $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        } catch (\Exception $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR2";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        } catch (\Throwable $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR3";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/revokeAccessToken")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function revokeAccessToken() {
        try {
            $manager = $this->get('manager');
            $sender = $this->get('sender');

            $manager->setBlockName(__FUNCTION__);

            $bodyParams = $manager->getBodyParams();
            $urlParams = $manager->getUrlParams();

            $url = $manager->createFullUrl($bodyParams);
            $headers['Content-Type'] = "application/x-www-form-urlencoded";

            $data = $manager->createGuzzleData($url, $headers, $urlParams, $bodyParams);

            $result = $sender->send($data);
        } catch (PackageException $exception) {
            $result = $this->createPackageExceptionResponse($exception);
        } catch (RequiredFieldException $exception) {
            $result = $this->createRequiredFieldExceptionResponse($exception);
        } catch (ConnectException $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        } catch (\Exception $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR2";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        } catch (\Throwable $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR3";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/{blockName}", requirements={"blockName" = "\w+"})
     * @Method("POST")
     *
     * @param null $blockName
     *
     * @return JsonResponse
     */
    public function getOtherMethods($blockName = null) {
        try {
            $manager = $this->get('manager');
            $sender = $this->get('sender');
            $manager->setBlockName($blockName);

            $bodyParams = $manager->getBodyParams();
            $urlParams = $manager->getUrlParams();

            $url = $manager->createFullUrl($bodyParams);
            $headers = $this->createHeaders($bodyParams);

            $data = $manager->createGuzzleData($url, $headers, $urlParams, $bodyParams);

            $result = $sender->send($data);
        } catch (PackageException $exception) {
            $result = $this->createPackageExceptionResponse($exception);
        } catch (RequiredFieldException $exception) {
            $result = $this->createRequiredFieldExceptionResponse($exception);
        } catch (ConnectException $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        } catch (\Exception $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR2";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        } catch (\Throwable $exception) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = "INTERNAL_PACKAGE_ERROR3";
            $result['contextWrites']['to']['status_msg'] = $exception->getMessage();
        }

        return new JsonResponse($result);
    }

    private function createHeaders(&$data)
    {
        $result = [
            'Authorization' => 'Bearer ' . $data['accessToken']
        ];
        unset($data['accessToken']);

        return $result;
    }

    private function createPackageExceptionResponse(PackageException $exception)
    {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = $exception->getMessage();

        return $result;
    }

    private function createRequiredFieldExceptionResponse(RequiredFieldException $exception)
    {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = "REQUIRED_FIELDS";
        $result['contextWrites']['to']['status_msg'] = "Please, check and fill in required fields.";
        $result['contextWrites']['to']['fields'] = explode(',', $exception->getMessage());

        return $result;
    }
}